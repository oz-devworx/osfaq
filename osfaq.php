<?php
/* *************************************************************************
  Id: osfaq.php

  Client side FAQ display page.


  Tim Gall
  Copyright (c) 2009-2013 osfaq.oz-devworx.com.au - All Rights Reserved.
  http://osfaq.oz-devworx.com.au

  This file is part of osFaq.

  Released under the GNU General Public License v3 WITHOUT ANY WARRANTY.
  For licensing, see LICENSE.html or http://osfaq.oz-devworx.com.au/license

************************************************************************* */

/**
 * Displays a single question and answer pair using html formatting.
 *
 * @param int $faq_id
 * @param string $question_str Question text
 * @param string $answer_str Answer text
 * @param string $document document name
 * @param string $search_str search text if any
 */
function show_faq_answer($faq_id, $question_str, $answer_str, $document, $document_name, $search_str){
  global $rf_rows, $showall, $category_id, $answer;//$answer is an answer index (int)

        // update faq view counter
        db_query('UPDATE ' . TABLE_FAQS . ' SET client_views = (client_views + 1) WHERE id = ' . $faq_id . ';');
?>
      <tr>
        <td class="Q" valign="top"><?php echo OSF_Q; ?></td>
        <td valign="bottom" class="question"><a name="f<?php echo $faq_id; ?>"></a>
          <p>
<?php
        if((OSFDB_SHOW_SINGLE!='true' || (OSFDB_SHOW_SINGLE=='true' && $answer>0)) || $rf_rows == 1 || $showall){
          // if theres only one FAQ or $showall==true we don't add any FAQ link.
          echo FaqFuncs::highlight_keywords($question_str, $search_str);
        }else{
?>
            <a rel="nofollow" href="<?php echo FaqFuncs::format_url(FILE_FAQ, FaqFuncs::get_all_get_params(array('cid','answer')) . 'cid='.$category_id, 'SSL', $question_str) . '#f'.$faqs['id']; ?>"><?php echo FaqFuncs::highlight_keywords($question_str, $search_str); ?></a>
<?php
        }
?>
          </p>
        </td>
      </tr>
      <tr>
        <td class="A" valign="top"><?php echo OSF_A; ?></td>
        <td valign="bottom"><?php echo isset($_GET['search_desc']) ? FaqFuncs::highlight_keywords($answer_str, $search_str) : $answer_str; ?>
<?php
        if (!empty($document) && is_file(DIR_FS_DOC . $document)) {
          $upext = substr($document, strrpos($document, '.') +1);

          if($upext == 'pdf'){
            echo '<hr />' . OSF_PDF_DOWNLOAD;
          }else{
            echo '<hr />' . OSF_DOC_DOWNLOAD;
          }

          echo ' <a href="' . DIR_WS_DOC . $document . '" target="_blank">' .(FaqFuncs::not_null($document_name) ? $document_name : $document). '</a> (' .FaqFuncs::display_filesize(filesize(DIR_FS_DOC . $document)) . ')';

          if($upext == 'pdf'){
            echo OSF_ADOBE_READER;
          }
        }
?>
        </td>
      </tr>
<?php
} /// END "function show_faq_answer(...)"

require ('./faq/include/OsFaqAdapter.class.php');
$osfAdapter = new OsFaqAdapter();

$osfAdapter->init_client();
require ('./faq/include/main.faq.php'); // !important

/// DEFAULT LANGUAGE FILE.
require_once (DIR_FAQ_LANG . OSFDB_DEFAULT_LANG . '/faq.lang.php');

require (DIR_FAQ_INCLUDES . 'FaqFuncs.php');
require (DIR_FAQ_INCLUDES . 'FaqForm.php');

require_once (DIR_FAQ_INCLUDES . 'FaqPaginator.php');
require_once (DIR_FAQ_INCLUDES . 'FaqCrumb.php');
require_once (DIR_FAQ_INCLUDES . 'FaqSQLExt.php');


/// Bail out if the client side was disabled by admin
if(OSFDB_DISABLE_CLIENT=='true'){
  $osfAdapter->get_client_page_header();
  echo '<p>' . OSF_CLIENT_DISABLED . '</p>';
  $osfAdapter->get_client_page_footer();
  exit(0);
}

/// INTERNAL PHP
$pages = new FaqPaginator(FILE_FAQ);
$sqle = new FaqSQLExt;
$FaqCrumb = new FaqCrumb;
$faqForm = new FaqForm;

/* TODO: make search a bit smarter
 *
 * SEARCH IDEAS:
 * split multiple words
 * use additional MySql SOUNDEX in conditions.
 * Also look into updating the keyword highlighting to support these ideas.
 */

// Make sure we are not returning results from html formatting.
// EG: only get results from visible text
$search_str = isset($_GET['faqsearch']) ? db_input(htmlspecialchars(trim($_GET['faqsearch'])), false) : '';

$search_desc = isset($_GET['search_desc']) ? true : false;
$showall = ($_GET['print']=='true') ? true : false;
$answer = isset($_GET['answer']) ? (int)$_GET['answer'] : 0;

if(isset($_GET['cid'])){
  $category_id = (int)$_GET['cid'];

  // update cat view counter here
  if(!isset($_GET['answer']) && $category_id > 0){
    db_query('UPDATE ' . TABLE_FAQCATS . ' SET client_views = (client_views + 1) WHERE id = ' . $category_id . ';');
  }

}else{
  $category_id = 0;
}

if($category_id > 0){
  $cat_name = FaqFuncs::get_cat_name($category_id);
}else{
  $cat_name = OSF_TOP_LEVEL;
}



if($search_str!='') {

  /// faq pagination count
  $faq_count_query = db_query("SELECT distinct f.id FROM ".TABLE_FAQS." f, ".TABLE_FAQS2FAQCATS." f2f left join ".TABLE_FAQCATS." fc on(f2f.faqcategory_id=fc.id) WHERE ((f2f.faqcategory_id = 0) OR (f2f.faqcategory_id = fc.id and fc.category_status = '1')) and f2f.faq_id = f.id and f.faq_active = '1' and (f.question LIKE '%".$search_str."%'".($search_desc ? " OR f.answer LIKE '%".$search_str."%')" : ')')." group by f.id order by f.question");

  $pages->items_total = db_num_rows($faq_count_query);
  $pages->paginate();

  /// categories search
  $result_subcats = db_query("SELECT distinct f1.id, f1.category FROM ".TABLE_FAQCATS." f1 WHERE f1.category LIKE '%".$search_str."%' AND f1.category_status = '1' group by f1.id order by f1.category");

  /// faq search
  $result_faqs = db_query("SELECT distinct f.id, f.question, f.answer, f.name, f.date_added, f.last_modified, f.pdfupload, f.upload_text FROM ".TABLE_FAQS." f, ".TABLE_FAQS2FAQCATS." f2f left join ".TABLE_FAQCATS." fc on(f2f.faqcategory_id=fc.id) WHERE ((f2f.faqcategory_id = 0) OR (f2f.faqcategory_id = fc.id and fc.category_status = '1')) and f2f.faq_id = f.id and f.faq_active = '1' and (f.question LIKE '%".$search_str."%'".($search_desc ? " OR f.answer LIKE '%".$search_str."%')" : ')')." group by f.id order by f.question" . (($pages->items_total > 0) ? " " . $pages->limit : ""));

} else {

  /// faq pagination count
  if($category_id==0){
    $faq_condition = "f2f.faq_id = f.id and f2f.faqcategory_id = ".$category_id." and f.faq_active = 1";
    $faq_count_query = db_query("SELECT distinct COUNT(f.id) as faq_count FROM ".TABLE_FAQS." f, ".TABLE_FAQS2FAQCATS." f2f WHERE " . $faq_condition . " order by f.question");
  }else{
    $faq_condition = "f2f.faqcategory_id = fc.id and f2f.faq_id = f.id and f2f.faqcategory_id = ".$category_id." and fc.category_status = 1 and f.faq_active = 1";
    $faq_count_query = db_query("SELECT distinct COUNT(f.id) as faq_count FROM ".TABLE_FAQS." f, ".TABLE_FAQCATS." fc, ".TABLE_FAQS2FAQCATS." f2f WHERE " . $faq_condition . " order by f.question");
  }

  $row_count = db_fetch_array($faq_count_query);

  $pages->set_items_total((int)$row_count['faq_count']);
  /* **************************************************
   * START pagination control for remote requests.
   ************************************************** */
  if(!isset($_GET['pg']) && !isset($_GET['page']) && $answer>0){
    $pgConfigQuery = $sqle->db_compile(TABLE_FAQS." f, ".TABLE_FAQCATS." fc, ".TABLE_FAQS2FAQCATS." f2f"
                                      ,array('distinct f.id')
                                      ,FaqSQLExt::$SELECT
                                      ,$faq_condition
                                      ,''
                                      ,'f.question');

    $pgCount = 0;
    while ($pgConfig = db_fetch_array($pgConfigQuery)) {
      $pgCount++;
      if($answer==$pgConfig['id']) break;
    }

    if($pgCount > 0){
      $_GET['pg'] = ceil($pgCount/$pages->items_per_page);
    }
    //print('$pgCount='.$pgCount.', $pages->items_per_page='.$pages->items_per_page.', $_GET[\'pg\']='.$_GET['pg']);
  }
  /* **************************************************
   * END pagination control for remote requests.
   ************************************************** */
  $pages->paginate();


  /// subcategories
  $result_subcats = db_query("SELECT distinct f1.id, f1.category FROM ".TABLE_FAQCATS." f1 WHERE f1.parent_id = '".$category_id."' AND f1.category_status = '1' order by f1.category");
  /// faqs
  if($category_id==0){
    $result_faqs = db_query("SELECT distinct f.id, f.question, f.answer, f.name, f.date_added, f.last_modified, f.pdfupload, f.upload_text FROM ".TABLE_FAQS." f, ".TABLE_FAQS2FAQCATS." f2f WHERE " . $faq_condition . " order by f.question" . (($pages->items_total > 0) ? " " . $pages->limit : ""));
  }else{
    $result_faqs = db_query("SELECT distinct f.id, f.question, f.answer, f.name, f.date_added, f.last_modified, f.pdfupload, f.upload_text FROM ".TABLE_FAQS." f, ".TABLE_FAQCATS." fc, ".TABLE_FAQS2FAQCATS." f2f WHERE " . $faq_condition . " order by f.question" . (($pages->items_total > 0) ? " " . $pages->limit : ""));
  }
}
$rf_rows = db_num_rows($result_faqs);






$FaqCrumb->add(OSF_LINK, FaqFuncs::format_url(FILE_FAQ, '', 'SSL'));

if($search_str!='') {
	$FaqCrumb->add(OSF_SEARCH_LINK.$search_str, FaqFuncs::format_url(FILE_FAQ, ($showall ? 'print=true&':'').'faqsearch='.$search_str.($search_desc ? '&search_desc=true' : ''), 'SSL'));
}else{

	/// collect parent category data
	if(isset($_GET['cid']) && is_numeric($_GET['cid']) && $_GET['cid'] > 0){
		$parent_cats_array = FaqFuncs::faq_get_parent_tree((int)$_GET['cid']);// !important - also required for page output

		if(is_array($parent_cats_array)){
			for ($i=0; $i<sizeof($parent_cats_array); $i++) {
				$FaqCrumb->add($parent_cats_array[$i]['title'], $parent_cats_array[$i]['link'] . ($showall ? '&print=true':''));
			}
		}
		if(OSFDB_SHOW_FAQ_COUNTS=='true') $faq_count = ' (' . FaqFuncs::count_faqs_in_category((int)$category_id) . ')';
		$FaqCrumb->add($cat_name . $faq_count, FaqFuncs::format_url(FILE_FAQ, 'cid='.$category_id.($showall ? '&print=true':''), 'SSL', $cat_name));
	}
}

$rssAlt = ((OSFDB_FEED_ATOM=='true') ? 'Atom':'RSS') . ' Feed';








/// PAGE OUTPUT
$osfAdapter->get_client_page_header();
?>
<div id="faqs">

  <?php echo $FaqCrumb->get(' &raquo; '); ?>
  <div class="clear"></div>

  <div style="float:left;">
    <a name="top"></a><h1>
    <?php if(OSFDB_FEED_ALLOW=='true'){ ?><a href="<?php echo FILE_FAQ_FEED; ?>" target="_blank"><img src="faq/img/icons/feed-icon-14x14.png" border="0" alt="<?php echo $rssAlt; ?>" title="<?php echo $rssAlt; ?>" /></a> <?php } ?>
    <?php echo OSF_TITLE; ?></h1>
<?php
if(OSFDB_USER_SUBMITS_ALLOW=='true'){
  if(OSFDB_USER_ANON=='true' || $osf_isClient){
    echo ' <a href="'.FaqFuncs::format_url(FILE_FAQ_SUBMIT, '', 'SSL').'">' . OSF_SUGGEST_NEW . '</a>';
  }
}
?>
  </div>
	<div style="float:right;">
<?php
/// Search form
echo $faqForm->form_open('faq_search', FILE_FAQ, '', 'get');
//echo $faqForm->hidden_field('print', 'true');// displays fulltext of all faqs
echo $faqForm->input_field('faqsearch', (isset($_GET['faqsearch']) ? trim($_GET['faqsearch']) : OSF_SEARCH_FIELD), 'style="width:170px;" onfocus="if(this.value==\'' . OSF_SEARCH_FIELD . '\'){this.value=\'\';}" onblur="if(this.value==\'\'){this.value=\'' . OSF_SEARCH_FIELD . '\';}"') . '<br />';
echo $faqForm->submit_css(OSF_SEARCH_BTN) . ' ' . $faqForm->checkbox_field('search_desc', '', true) . ' <small>' . OSF_SEARCH_ANSWER . '</small>';
echo $faqForm->form_close();
?>
	</div>
  <div class="clear"></div>

  <hr />



<?php
/// output root category menu
if((!isset($_GET['cid']) || $category_id==0) && !FaqFuncs::not_null($search_str)){

  echo '  <h4>' . OSF_SELECT_CAT . '</h4>' . "\n";

  $faq_tree_array = FaqFuncs::faq_get_tree();
  $ift=0;
  for ($ift=0; $ift<sizeof($faq_tree_array); $ift++) {
    echo $faq_tree_array[$ift]['text'] . '<br />' . "\n";
  }

  if($category_id>0 && $ift==0){
    echo '  <h3>'.OSF_NO_FAQS.'</h3>';
  }
}



/// output parent categories
if($category_id>0){
  echo '  <h2 class="fade">'.OSF_PARENT_CATS.'</h2>' . "\n";
?>
  <div>
    &bull; <a href="<?php echo FaqFuncs::format_url(FILE_FAQ, '', 'SSL'); ?>" class="faq"><?php echo OSF_ALL_CATS; ?></a><br />
<?php
  if(is_array($parent_cats_array)){
  	for ($i=0; $i<sizeof($parent_cats_array); $i++) {
        echo $parent_cats_array[$i]['text'] . '<br />' . "\n";
  	}
  }
?>
  </div>
  <div class="clear"></div>
<?php
}



/// output subcategories
if((OSFDB_SHOW_SINGLE!='true' || (OSFDB_SHOW_SINGLE=='true' && $answer==0)) && $category_id>0 && db_num_rows($result_subcats) > 0){
  $subcat_cnt = 0;
?>
  <br />
  <?php echo '  <h2 class="fade">'.(FaqFuncs::not_null($search_str) ? OSF_CATS : OSF_SUB_CATS).'</h2>' . "\n"; ?>
  <div>
<?php
  while ($subcats = db_fetch_array($result_subcats)) {
?>
    &bull; <a href="<?php echo FaqFuncs::format_url(FILE_FAQ, FaqFuncs::get_all_get_params(array('cid','faqsearch','search_desc')) . 'cid='.$subcats['id'], 'SSL', $subcats['category']); ?>" class="faq"><?php echo FaqFuncs::highlight_keywords($subcats['category'], $_GET['faqsearch']); ?></a><?php if(OSFDB_SHOW_FAQ_COUNTS=='true'){ echo ' (' . FaqFuncs::count_faqs_in_category((int)$subcats['id']) . ')'; } ?><br />
<?php
  }
?>
  </div>
  <div class="clear"></div>
<?php
}


/// output current category when in single faq mode
if(OSFDB_SHOW_SINGLE=='true' && $answer>0){
?>
  <br />
  <?php echo '  <h2 class="fade">'.OSF_CURRENT_CATEGORY.'</h2>' . "\n"; ?>
  <div>
    &bull; <a href="<?php echo FaqFuncs::format_url(FILE_FAQ, FaqFuncs::get_all_get_params(array('cid','answer')) . 'cid='.$category_id, 'SSL', $cat_name); ?>" class="faq"><?php echo FaqFuncs::highlight_keywords($cat_name, $_GET['faqsearch']); ?></a><?php if(OSFDB_SHOW_FAQ_COUNTS=='true'){ echo ' (' . FaqFuncs::count_faqs_in_category($category_id) . ')'; } ?><br />
  </div>
  <div class="clear"></div>
<?php
}


///////////////////////////////////////
///////////////////////////////////////
if($rf_rows > 0){
?>
  <br />
<?php
  if(OSFDB_SHOW_SINGLE!='true' || (OSFDB_SHOW_SINGLE=='true' && $answer==0)) echo '<h2>' .(isset($_GET['faqsearch']) ? OSF_SEARCH_RESULTS . ' ('.$pages->items_total.')' : '<span class="fade">'.OSF_FAQ_NAME.'</span>' . $cat_name). '</h2>' . "\n";


  /// Pagination
  if(OSFDB_SHOW_SINGLE!='true' || (OSFDB_SHOW_SINGLE=='true' && $answer==0)){
    switch(OSFDB_CLIENT_PG_STRIP){
      case '2':
      // bottom only
      break;

      case '1':
      case '3':
      default:
        if($pages->items_total > $rf_rows){
          echo '<div class="paginate_row paginate_top">';
          echo $pages->display_pages(); // page numbers
          echo $pages->display_jump_menu(); // page jump menu
          echo $pages->display_items_per_page(); // items per page menu
          echo '</div>' . "\n";
        }
      break;
    }
  }
?>
    <table width="100%" border="0" cellpadding="8" cellspacing="0">
<?php
  /// output faq data
  while ($faqs = db_fetch_array($result_faqs)) {

    //display the authors name
    $osf_answer = $faqs['answer'];
    if(FaqFuncs::not_null($faqs['name'])){
      $osf_answer .= '<br /><small class="fade"><b>' . OSF_FAQ_AUTHOR . '</b> ' . $faqs['name'] . '</small>';
    }

    /// selected faq
    if(OSFDB_SHOW_SINGLE=='true' && $answer>0){

      if($answer==(int)$faqs['id'] || $rf_rows==1) {
        show_faq_answer($faqs['id'], $faqs['question'], $osf_answer, $faqs['pdfupload'], $faqs['upload_text'], $search_str);

        break;
      }else{
        continue;
      }

    }else{
      if($answer==(int)$faqs['id'] || $showall || $rf_rows==1) {

        show_faq_answer($faqs['id'], $faqs['question'], $osf_answer, $faqs['pdfupload'], $faqs['upload_text'], $search_str);

    /// not selected faq
      } else {
?>
      <tr>
        <td class="Q" valign="top"><?php echo OSF_Q; ?></td>
        <td valign="bottom" class="question"><a name="f<?php echo $faqs['id']; ?>"></a><p><a href="<?php echo FaqFuncs::format_url(FILE_FAQ, FaqFuncs::get_all_get_params(array('cid','answer')) . 'cid='.$category_id.'&answer='.$faqs['id'], 'SSL', $faqs['question']) . '#f'.$faqs['id']; ?>"<?php echo ((OSFDB_SHOW_SINGLE=='true') ? '' : ' rel="nofollow"'); ?>><?php echo FaqFuncs::highlight_keywords($faqs['question'], $_GET['faqsearch']); ?></a></p></td>
      </tr>
<?php
      }
    }
  }///while
?>
    </table>
<?php
  if(OSFDB_SHOW_SINGLE!='true' || (OSFDB_SHOW_SINGLE=='true' && $answer==0)){
    /// Pagination
    switch(OSFDB_CLIENT_PG_STRIP){
      case '1':
      // top only
      break;

      case '2':
      case '3':
      default:
        //if($pages->items_total > $rf_rows){
          echo '<div class="paginate_row">';
          echo $pages->display_pages(); // page numbers
          echo $pages->display_jump_menu(); // page jump menu
          echo $pages->display_items_per_page(); // items per page menu
          echo '</div>' . "\n";
        //}
      break;
    }
  }
?>
    <div class="paginate_row paginate_bot">
      <?php if($rf_rows > 1 && OSFDB_SHOW_SINGLE!='true'){ ?><a rel="nofollow" href="<?php echo FaqFuncs::format_url(FILE_FAQ, FaqFuncs::get_all_get_params(array('cid','print')) . 'cid='.$category_id.'&print='.(!$showall ? 'true' : 'false'), 'SSL', $cat_name) . '#top'; ?>"><?php echo (!$showall ? OSF_SHOW : OSF_HIDE) . OSF_ALL_ANSWERS; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<?php } ?>
      <a rel="nofollow" href="<?php echo FaqFuncs::format_url(FILE_FAQ, FaqFuncs::get_all_get_params(array('i','ipp')), 'SSL') . '#top'; ?>"><?php echo OSF_TOP; ?></a>
      &nbsp;&nbsp;|&nbsp;&nbsp;<a rel="nofollow" href="javascript:history.back()"><?php echo OSF_BACK; ?></a>
      <?php if(OSFDB_USER_SUBMITS_ALLOW=='true' && (OSFDB_USER_ANON=='true' || $osf_isClient)){ echo '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="'.FaqFuncs::format_url(FILE_FAQ_SUBMIT, '', 'SSL').'">' . OSF_SUGGEST_NEW . '</a>'; } ?>
      <?php if(OSFDB_FEED_ALLOW=='true'){ ?>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo FILE_FAQ_FEED; ?>" target="_blank"><img src="faq/img/icons/feed-icon-14x14.png" border="0" alt="<?php echo $rssAlt; ?>" title="<?php echo $rssAlt; ?>" /></a><?php } ?>
    	<?php if($rf_rows > 1 && !$showall && OSFDB_SHOW_SINGLE!='true'){ ?><div style="float:right;font-size:11px;" class="fade"> <?php echo OSF_REVEAL_HIDE; ?></div><?php } ?>
    </div>

<?php
}elseif($category_id>0 || FaqFuncs::not_null($search_str)){
  echo '  <h3>'.OSF_NO_FAQS.'</h3>' . "\n";
}

if(FaqFuncs::not_null(OSFDB_OPTIONAL_FOOTER)) echo '<div class="clear"></div><hr />' . OSFDB_OPTIONAL_FOOTER . "\n";
?>
</div>
<?php $osfAdapter->get_client_page_footer(); ?>