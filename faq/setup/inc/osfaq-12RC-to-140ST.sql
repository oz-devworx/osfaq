UPDATE `%TABLE_PREFIX%osfaq_admin` SET `key_value` = '1.4.0 ST' WHERE `key_name` = 'DB_FAQ_VERSION';

ALTER TABLE `%TABLE_PREFIX%osfaq` CHANGE `show_on_nonfaq` `featured` SMALLINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `%TABLE_PREFIX%osfaq_categories` CHANGE `show_on_nonfaq` `featured` SMALLINT( 1 ) NOT NULL DEFAULT '0';

ALTER TABLE `%TABLE_PREFIX%osfaq` ADD `client_entry` SMALLINT( 1 ) NOT NULL DEFAULT '0' AFTER `client_views`;
ALTER TABLE `%TABLE_PREFIX%osfaq_categories` ADD `client_entry` SMALLINT( 1 ) NOT NULL DEFAULT '0' AFTER `client_views`;

ALTER TABLE `%TABLE_PREFIX%osfaq` ADD `canned` SMALLINT(1) NOT NULL DEFAULT '0' AFTER `featured`;

INSERT INTO `%TABLE_PREFIX%osfaq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSFDB_STATUS_DEFAULT', 'false', 'truefalse', 23, now(), '0000-00-00 00:00:00'),
('OSFDB_FEATURE_DEFAULT', 'false', 'truefalse', 24, now(), '0000-00-00 00:00:00');

UPDATE `%TABLE_PREFIX%osfaq_settings` SET `sort_order` = 28 WHERE `key_name` = 'OSFDB_WYSIWYG_STAFF';
UPDATE `%TABLE_PREFIX%osfaq_settings` SET `sort_order` = 46 WHERE `key_name` = 'OSF_FAQ_SUBMIT_PAGE';
UPDATE `%TABLE_PREFIX%osfaq_settings` SET `sort_order` = 47 WHERE `key_name` = 'OSFDB_USER_SUBMITS_ALLOW';
UPDATE `%TABLE_PREFIX%osfaq_settings` SET `sort_order` = 48 WHERE `key_name` = 'OSFDB_USER_ANON';
UPDATE `%TABLE_PREFIX%osfaq_settings` SET `sort_order` = 49 WHERE `key_name` = 'OSFDB_WYSIWYG_CLIENT';


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
