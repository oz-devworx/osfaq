UPDATE `%TABLE_PREFIX%faq_admin` SET `key_value` = '1.3.1 ST' WHERE `key_name` = 'DB_FAQ_VERSION';

DELETE FROM `%TABLE_PREFIX%faq_admin` WHERE `key_name` = 'SM_BASE';
INSERT INTO `%TABLE_PREFIX%faq_admin` (`key_name`, `key_value`) VALUES
('OSFA_SM_TYPE', 'test'),
('OSFA_SM_PATH', '/'),
('OSFA_SM_IDX', ''),
('OSFA_SM_IDX_MAPS', ''),
('OSFA_SM_NOTIFY', ''),
('OSFA_SM_MAP', 'sitemap.xml');

ALTER TABLE `%TABLE_PREFIX%faq_admin` CHANGE `key_value` `key_value` VARCHAR( 255 ) CHARACTER SET utf8 NOT NULL; 

ALTER TABLE `%TABLE_PREFIX%faqs` ADD `upload_text` VARCHAR( 255 ) NULL DEFAULT NULL AFTER `pdfupload`;

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


DELETE FROM `%TABLE_PREFIX%faq_settings` WHERE `key_name` = 'IMAGE_UPLOAD_MAX';
DELETE FROM `%TABLE_PREFIX%faq_settings` WHERE `key_name` = 'USE_FANCY_BUTTONS';

UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_DEFAULT_LANG' WHERE `key_name` = 'DEFAULT_FAQ_LANG'; 
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_ENABLE_SSL' WHERE `key_name` = 'ENABLE_SSL';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_DEFAULT_IPP' WHERE `key_name` = 'FAQ_DEFAULT_IPP';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSF_ADMIN_HEADING' WHERE `key_name` = 'ADMIN_HEADING';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_INACTIVE_COLOR' WHERE `key_name` = 'ITEM_INACTIVE_COLOR';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_ACTIVE_COLOR' WHERE `key_name` = 'ITEM_ACTIVE_COLOR';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_WYSIWYG_STAFF' WHERE `key_name` = 'WYSIWYG_STAFF';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSF_CLIENT_HEADING' WHERE `key_name` = 'CLIENT_HEADING';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_CLIENT_PG_STRIP' WHERE `key_name` = 'CLIENT_PG_STRIP';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_WYSIWYG_CLIENT' WHERE `key_name` = 'WYSIWYG_CLIENT';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_USER_SUBMITS_ALLOW' WHERE `key_name` = 'ALLOW_USER_SUBMITS';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_OPTIONAL_FOOTER' WHERE `key_name` = 'OPTIONAL_FAQ_FOOTER';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_SEARCH_BG_COLOR' WHERE `key_name` = 'SEARCH_BACKGROUND_COLOR';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSF_SEO_HEADING' WHERE `key_name` = 'SEO_HEADING';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_URL_FRIENDLY' WHERE `key_name` = 'FAQ_URL_FRIENDLY';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_MAX_URL_LENGTH' WHERE `key_name` = 'MAX_URL_LENGTH';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_SEO_REMOVE_JOINERS' WHERE `key_name` = 'SEO_REMOVE_JOINERS';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSF_EXT_HEADING' WHERE `key_name` = 'EXT_HEADING';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_EXT_FAQS_ALLOW' WHERE `key_name` = 'DISPLAY_EXT_FAQS';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_EXT_LIMIT' WHERE `key_name` = 'EXT_LIMIT';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_MAX_TXT_LENGTH' WHERE `key_name` = 'MAX_TXT_LENGTH';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_EXT_FEATURED' WHERE `key_name` = 'EXT_FEATURED';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_EXT_POPULAR' WHERE `key_name` = 'EXT_POPULAR';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_EXT_NEW' WHERE `key_name` = 'EXT_NEW';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_USER_ANON' WHERE `key_name` = 'ALLOW_USER_ANON';
UPDATE `%TABLE_PREFIX%faq_settings` SET `key_name` = 'OSFDB_STAFF_AS_ADMIN' WHERE `key_name` = 'ALLOW_STAFF_AS_ADMIN';

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSFDB_TIMEZONE', 'Australia/Brisbane', 'timezone', 3, now(), '0000-00-00 00:00:00'),
('OSFDB_DISABLE_CLIENT', 'false', 'truefalse', 8, now(), '0000-00-00 00:00:00'),
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
('OSFDB_FEED_RANDOM', 'false', 'truefalse', 140, now(), '0000-00-00 00:00:00');


UPDATE `%TABLE_PREFIX%faq_settings` SET `sort_order` = 43 WHERE `key_name` = 'OSFDB_OPTIONAL_FOOTER';
UPDATE `%TABLE_PREFIX%faq_settings` SET `sort_order` = 45 WHERE `key_name` = 'OSFDB_SEARCH_BG_COLOR';

UPDATE `%TABLE_PREFIX%faq_settings` SET `sort_order` = 28 WHERE `key_name` = 'OSFDB_WYSIWYG_STAFF';
UPDATE `%TABLE_PREFIX%faq_settings` SET `sort_order` = 49 WHERE `key_name` = 'OSFDB_WYSIWYG_CLIENT';
UPDATE `%TABLE_PREFIX%faq_settings` SET `sort_order` = 46 WHERE `key_name` = 'OSF_FAQ_SUBMIT_PAGE';
UPDATE `%TABLE_PREFIX%faq_settings` SET `sort_order` = 47 WHERE `key_name` = 'OSFDB_USER_SUBMITS_ALLOW';
UPDATE `%TABLE_PREFIX%faq_settings` SET `sort_order` = 48 WHERE `key_name` = 'OSFDB_USER_ANON';

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSFDB_UPLOAD_EXTENSIONS', 'pdf, ods, odt, txt, doc, docx, xls, xlsx, tab, csv, xml', 'textfield', 30, now(), '0000-00-00 00:00:00'), 
('OSFDB_UPLOAD_SIZE', '5242880', 'upload_size', 31, now(), '0000-00-00 00:00:00'),
('OSFDB_SHOW_SINGLE', 'false', 'truefalse', 40, now(), '0000-00-00 00:00:00'), 
('OSFDB_SHOW_FAQ_COUNTS', 'true', 'truefalse', 41, now(), '0000-00-00 00:00:00'), 
('OSFDB_INCLUDE_SUBCATS', 'false', 'truefalse', 42, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_FAQ_SUBMIT_PAGE', '', 'heading', 47, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_RECAPTCHA_HEADING', '', 'heading', 51, now(), '0000-00-00 00:00:00'), 
('OSFDB_RECAPTCHA_ENABLE', 'false', 'truefalse', 52, now(), '0000-00-00 00:00:00'), 
('OSFDB_RECAPTCHA_PUBLIC_KEY', '', 'textfield', 53, now(), '0000-00-00 00:00:00'),
('OSFDB_RECAPTCHA_PRIVATE_KEY', '', 'textfield', 54, now(), '0000-00-00 00:00:00'), 
('OSFDB_RECAPTCHA_THEME', 'light', 'recaptcha_theme', 55, now(), '0000-00-00 00:00:00'),
('OSFDB_RECAPTCHA_TAB_INDEX', '7', 'textfield', 56, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%faq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES 
('OSFDB_WYS_CLIENT_THEME', 'Moono', 'wysiwyg_theme', '50', now(), '0000-00-00 00:00:00'), 
('OSFDB_WYS_STAFF_THEME', 'Moono', 'wysiwyg_theme', '29', now(), '0000-00-00 00:00:00'),
('OSFDB_STATUS_DEFAULT', 'false', 'truefalse', 23, now(), '0000-00-00 00:00:00'),
('OSFDB_FEATURE_DEFAULT', 'false', 'truefalse', 24, now(), '0000-00-00 00:00:00');

RENAME TABLE %TABLE_PREFIX%faqcategories         TO %TABLE_PREFIX%osfaq_categories,
             %TABLE_PREFIX%faqs                  TO %TABLE_PREFIX%osfaq,
             %TABLE_PREFIX%faqs_to_faqcategories TO %TABLE_PREFIX%osfaq_to_categories,
             %TABLE_PREFIX%faq_settings          TO %TABLE_PREFIX%osfaq_settings,
             %TABLE_PREFIX%faq_settings_lang     TO %TABLE_PREFIX%osfaq_settings_lang,
             %TABLE_PREFIX%faq_admin             TO %TABLE_PREFIX%osfaq_admin;

             
ALTER TABLE `%TABLE_PREFIX%osfaq` CHANGE `show_on_nonfaq` `featured` SMALLINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `%TABLE_PREFIX%osfaq_categories` CHANGE `show_on_nonfaq` `featured` SMALLINT( 1 ) NOT NULL DEFAULT '0';

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

