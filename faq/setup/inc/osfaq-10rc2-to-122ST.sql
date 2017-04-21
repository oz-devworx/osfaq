ALTER TABLE `%TABLE_PREFIX%faqcategories` ADD `featured` SMALLINT( 1 ) NOT NULL DEFAULT '0' AFTER `category_status`;
ALTER TABLE `%TABLE_PREFIX%faqcategories` ADD `client_views` INT( 15 ) NOT NULL DEFAULT '0' AFTER `featured`;
ALTER TABLE `%TABLE_PREFIX%faqcategories` CHANGE `last_modified` `last_modified` DATETIME NULL DEFAULT NULL;

UPDATE `%TABLE_PREFIX%faqcategories` SET `last_modified` = NULL WHERE `last_modified` = '0000-00-00 00:00:00';

ALTER TABLE `%TABLE_PREFIX%faqs` ADD `featured` SMALLINT( 1 ) NOT NULL DEFAULT '0' AFTER `faq_active`;
ALTER TABLE `%TABLE_PREFIX%faqs` ADD `client_views` INT( 15 ) NOT NULL DEFAULT '0' AFTER `phone`;
ALTER TABLE `%TABLE_PREFIX%faqs` DROP `category_id`;
ALTER TABLE `%TABLE_PREFIX%faqs` CHANGE `last_modified` `last_modified` DATETIME NULL DEFAULT NULL;
ALTER TABLE `%TABLE_PREFIX%faqs` ADD `upload_text` VARCHAR( 255 ) NULL DEFAULT NULL AFTER `pdfupload`;

UPDATE `%TABLE_PREFIX%faqs` SET `last_modified` = NULL WHERE `last_modified` = '0000-00-00 00:00:00';

ALTER TABLE `%TABLE_PREFIX%faq_settings` ADD `sort_order` INT( 7 ) NOT NULL DEFAULT '0' AFTER `description`;
ALTER TABLE `%TABLE_PREFIX%faq_settings` CHANGE `key_value` `key_value` LONGTEXT NOT NULL DEFAULT '';
ALTER TABLE `%TABLE_PREFIX%faq_settings` DROP `title`;
ALTER TABLE `%TABLE_PREFIX%faq_settings` DROP `description`;

DROP TABLE IF EXISTS `%TABLE_PREFIX%faq_settings_lang`;
CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%faq_settings_lang` (
  `settings_key` varchar(35) NOT NULL,
  `language` varchar(32) NOT NULL DEFAULT 'english',
  `title` varchar(128) NOT NULL,
  `description` longtext DEFAULT NULL,
  `last_modified` datetime NOT NULL,
  PRIMARY KEY (`settings_key`,`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_ENABLE_SSL',`sort_order` = 5 WHERE `key_name` = 'ENABLE_SSL';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_WYSIWYG_STAFF',`sort_order` = 28 WHERE `key_name` = 'WYSIWYG_STAFF';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_WYSIWYG_CLIENT',`sort_order` = 49 WHERE `key_name` = 'WYSIWYG_CLIENT';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_USER_SUBMITS_ALLOW',`sort_order` = 47 WHERE `key_name` = 'ALLOW_USER_SUBMITS';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_OPTIONAL_FOOTER',`sort_order` = 43 WHERE `key_name` = 'OPTIONAL_FAQ_FOOTER';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_SEARCH_BG_COLOR',`sort_order` = 45 WHERE `key_name` = 'SEARCH_BACKGROUND_COLOR';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_URL_FRIENDLY',`sort_order` = 60 WHERE `key_name` = 'FAQ_URL_FRIENDLY';

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSFDB_DEFAULT_LANG', 'english', 'lang', 1, now(), '0000-00-00 00:00:00'),
('OSFDB_TIMEZONE', 'Australia/Brisbane', 'timezone', 3, now(), '0000-00-00 00:00:00'),
('OSFDB_DEFAULT_IPP', '10', 'textfield', 6, now(), '0000-00-00 00:00:00'),
('OSFDB_STAFF_AS_ADMIN', 'false', 'truefalse', 7, now(), '0000-00-00 00:00:00'),
('OSFDB_DISABLE_CLIENT', 'false', 'truefalse', 8, now(), '0000-00-00 00:00:00'),
('OSF_ADMIN_HEADING', '', 'heading', 9, now(), '0000-00-00 00:00:00'),
('OSFDB_INACTIVE_COLOR', '#FEE7E7', 'textfield', 17, now(), '0000-00-00 00:00:00'),
('OSFDB_ACTIVE_COLOR', '#E1FFE1', 'textfield', 20, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_CLIENT_HEADING', '', 'heading', 35, now(), '0000-00-00 00:00:00'),
('OSFDB_CLIENT_PG_STRIP', '3', 'textfield', 36, now(), '0000-00-00 00:00:00'),
('OSFDB_USER_ANON', 'false', 'truefalse', 49, now(), '0000-00-00 00:00:00'),
('OSF_SEO_HEADING', '', 'heading', 59, now(), '0000-00-00 00:00:00'),
('OSFDB_MAX_URL_LENGTH', '39', 'textfield', 61, now(), '0000-00-00 00:00:00'),
('OSFDB_SEO_REMOVE_JOINERS', 'true', 'truefalse', 62, now(), '0000-00-00 00:00:00'),
('OSF_EXT_HEADING', '', 'heading', 65, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSFDB_EXT_FAQS_ALLOW', 'true', 'truefalse', 70, now(), '0000-00-00 00:00:00'),
('OSFDB_EXT_LIMIT', '3', 'textfield', 75, now(), '0000-00-00 00:00:00'),
('OSFDB_MAX_TXT_LENGTH', '43', 'textfield', 77, now(), '0000-00-00 00:00:00'),
('OSFDB_EXT_FEATURED', 'true', 'truefalse', 80, now(), '0000-00-00 00:00:00'),
('OSFDB_EXT_POPULAR', 'true', 'truefalse', 85, now(), '0000-00-00 00:00:00'),
('OSFDB_EXT_NEW', 'true', 'truefalse', 90, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_FEED_HEADING', '', 'heading', 100, now(), '0000-00-00 00:00:00'),
('OSFDB_FEED_ALLOW', 'true', 'truefalse', 105, now(), '0000-00-00 00:00:00'),
('OSFDB_FEED_ATOM', 'true', 'truefalse', 106, now(), '0000-00-00 00:00:00'),
('OSFDB_FEED_CACH', 'true', 'truefalse', 110, now(), '0000-00-00 00:00:00'),
('OSFDB_FEED_CACHE_LIMIT', '60', 'textfield', 111, now(), '0000-00-00 00:00:00'),
('OSFDB_FEED_LIMIT', '15', 'textfield', 116, now(), '0000-00-00 00:00:00'),
('OSFDB_FEED_CATEGORIES', 'false', 'truefalse', 120, now(), '0000-00-00 00:00:00'),
('OSFDB_FEED_FEATURED', 'true', 'truefalse', 125, now(), '0000-00-00 00:00:00'),
('OSFDB_FEED_DATE', 'true', 'truefalse', 130, now(), '0000-00-00 00:00:00'),
('OSFDB_FEED_VIEWS', 'true', 'truefalse', 135, now(), '0000-00-00 00:00:00'),
('OSFDB_FEED_RANDOM', 'true', 'truefalse', 140, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSFDB_UPLOAD_EXTENSIONS', 'pdf, ods, odt, txt, doc, docx, xls, xlsx, tab, csv, xml', 'textfield', 30, now(), '0000-00-00 00:00:00'), 
('OSFDB_UPLOAD_SIZE', '5242880', 'upload_size', 31, now(), '0000-00-00 00:00:00'),
('OSFDB_SHOW_SINGLE', 'false', 'truefalse', 40, now(), '0000-00-00 00:00:00'), 
('OSFDB_SHOW_FAQ_COUNTS', 'true', 'truefalse', 41, now(), '0000-00-00 00:00:00'), 
('OSFDB_INCLUDE_SUBCATS', 'false', 'truefalse', 42, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_FAQ_SUBMIT_PAGE', '', 'heading', 46, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_RECAPTCHA_HEADING', '', 'heading', 51, now(), '0000-00-00 00:00:00'), 
('OSFDB_RECAPTCHA_ENABLE', 'false', 'truefalse', 52, now(), '0000-00-00 00:00:00'), 
('OSFDB_RECAPTCHA_PUBLIC_KEY', '', 'textfield', 53, now(), '0000-00-00 00:00:00'),
('OSFDB_RECAPTCHA_PRIVATE_KEY', '', 'textfield', 54, now(), '0000-00-00 00:00:00'), 
('OSFDB_RECAPTCHA_THEME', 'red', 'recaptcha_theme', 55, now(), '0000-00-00 00:00:00'),
('OSFDB_RECAPTCHA_TAB_INDEX', '7', 'textfield', 56, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES 
('OSFDB_WYS_CLIENT_THEME', 'Moono', 'wysiwyg_theme', 50, now(), '0000-00-00 00:00:00'), 
('OSFDB_WYS_STAFF_THEME', 'Moono', 'wysiwyg_theme', 29, now(), '0000-00-00 00:00:00'),
('OSFDB_STATUS_DEFAULT', 'false', 'truefalse', 23, now(), '0000-00-00 00:00:00'),
('OSFDB_FEATURE_DEFAULT', 'false', 'truefalse', 24, now(), '0000-00-00 00:00:00');

DROP TABLE IF EXISTS `%TABLE_PREFIX%faq_admin`;
CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%faq_admin` (
  `id` int( 11 ) NOT NULL AUTO_INCREMENT,
  `key_name` varchar( 32 ) NOT NULL,
  `key_value` varchar( 255 ) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_name` (`key_name`)
) ENGINE=MYISAM  DEFAULT CHARSET=utf8;


INSERT INTO `%TABLE_PREFIX%faq_admin` (`key_name`, `key_value`) VALUES
('DB_FAQ_VERSION', '1.2.2 ST'),
('OSFA_SM_TYPE', 'test'),
('OSFA_SM_PATH', '/'),
('OSFA_SM_IDX', ''),
('OSFA_SM_IDX_MAPS', ''),
('OSFA_SM_NOTIFY', ''),
('OSFA_SM_MAP', 'sitemap.xml');


RENAME TABLE %TABLE_PREFIX%faqcategories         TO %TABLE_PREFIX%osfaq_categories,
             %TABLE_PREFIX%faqs                  TO %TABLE_PREFIX%osfaq,
             %TABLE_PREFIX%faqs_to_faqcategories TO %TABLE_PREFIX%osfaq_to_categories,
             %TABLE_PREFIX%faq_settings          TO %TABLE_PREFIX%osfaq_settings,
             %TABLE_PREFIX%faq_settings_lang     TO %TABLE_PREFIX%osfaq_settings_lang,
             %TABLE_PREFIX%faq_admin             TO %TABLE_PREFIX%osfaq_admin;

ALTER TABLE `%TABLE_PREFIX%osfaq` ADD `client_entry` SMALLINT( 1 ) NOT NULL DEFAULT '0' AFTER `client_views`;
ALTER TABLE `%TABLE_PREFIX%osfaq_categories` ADD `client_entry` SMALLINT( 1 ) NOT NULL DEFAULT '0' AFTER `client_views`;


ALTER TABLE `%TABLE_PREFIX%osfaq` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `%TABLE_PREFIX%osfaq` 
CHANGE `question` `question` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
CHANGE `answer` `answer` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
CHANGE `pdfupload` `pdfupload` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
CHANGE `upload_text` `upload_text` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
CHANGE `name` `name` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
CHANGE `email` `email` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
CHANGE `phone` `phone` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '';

ALTER TABLE `%TABLE_PREFIX%osfaq_admin` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `%TABLE_PREFIX%osfaq_admin` 
CHANGE `key_name` `key_name` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
CHANGE `key_value` `key_value` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;

ALTER TABLE `%TABLE_PREFIX%osfaq_categories` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `%TABLE_PREFIX%osfaq_categories` 
CHANGE `category` `category` VARCHAR( 250 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '';

ALTER TABLE `%TABLE_PREFIX%osfaq_settings` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `%TABLE_PREFIX%osfaq_settings` 
CHANGE `key_name` `key_name` VARCHAR( 35 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
CHANGE `key_value` `key_value` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
CHANGE `field_type` `field_type` VARCHAR( 15 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;

ALTER TABLE `%TABLE_PREFIX%osfaq_settings_lang` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `%TABLE_PREFIX%osfaq_settings_lang` 
CHANGE `settings_key` `settings_key` VARCHAR( 35 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
CHANGE `language` `language` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'english',
CHANGE `title` `title` VARCHAR( 128 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
CHANGE `description` `description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `%TABLE_PREFIX%osfaq_to_categories` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

