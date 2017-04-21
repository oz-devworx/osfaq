<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex, nofollow" />
<title><?php echo FAQ_TITLE; ?></title>
<link rel="stylesheet" href="styles.css" media="screen" />
<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
</head>
<body>
<div id="maincontent">
  <h1><?php echo PAGE_HEADING; ?></h1>
  <div class="wmark">
<?php
if($abortError){
?>
    <div class="messageHandlerError"><img src="images/error.gif" />
<?php
  echo sprintf(OSFI_ERROR_ENCOUTERED, $errorMessage);
?>
    </div>
    <br /><br />
    <form action="install.php" method="get" enctype="text/plain">
      <input type="submit" value="<?php echo OSFI_RESTART_INSTALL; ?>" />
    </form>
<?php
  require('inc/footer.inc.php');
  exit();
}
?>