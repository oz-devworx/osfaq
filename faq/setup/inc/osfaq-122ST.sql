DROP TABLE IF EXISTS `%TABLE_PREFIX%osfaq_categories`;
CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%osfaq_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `category` varchar(250) NOT NULL DEFAULT '',
  `category_status` smallint(1) NOT NULL DEFAULT '0',
  `featured` smallint(1) NOT NULL DEFAULT '0',
  `client_views` int(15) NOT NULL DEFAULT '0',
  `client_entry` smallint( 1 ) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `%TABLE_PREFIX%osfaq`;
CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%osfaq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` longtext,
  `answer` longtext,
  `faq_active` smallint(1) NOT NULL DEFAULT '0',
  `featured` smallint(1) NOT NULL DEFAULT '0',
  `pdfupload` varchar(64) DEFAULT NULL,
  `upload_text` varchar(255) DEFAULT NULL,
  `name` varchar(64) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `phone` varchar(32) NOT NULL DEFAULT '',
  `client_views` int(15) NOT NULL DEFAULT '0',
  `client_entry` smallint( 1 ) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `%TABLE_PREFIX%osfaq_to_categories`;
CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%osfaq_to_categories` (
  `faqcategory_id` int(11) NOT NULL DEFAULT '0',
  `faq_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`faqcategory_id`,`faq_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `%TABLE_PREFIX%osfaq_admin`;
CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%osfaq_admin` (
  `id` int( 11 ) NOT NULL AUTO_INCREMENT,
  `key_name` varchar( 32 ) NOT NULL,
  `key_value` varchar( 255 ) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_name` (`key_name`)
) ENGINE=MYISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `%TABLE_PREFIX%osfaq_admin` (`key_name`, `key_value`) VALUES
('DB_FAQ_VERSION', '1.2.2 ST'),
('OSFA_SM_TYPE', 'test'),
('OSFA_SM_PATH', '/'),
('OSFA_SM_IDX', ''),
('OSFA_SM_IDX_MAPS', ''),
('OSFA_SM_NOTIFY', ''),
('OSFA_SM_MAP', 'sitemap.xml');


DROP TABLE IF EXISTS `%TABLE_PREFIX%osfaq_settings_lang`;
CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%osfaq_settings_lang` (
  `settings_key` varchar(35) NOT NULL,
  `language` varchar(32) NOT NULL DEFAULT 'english',
  `title` varchar(128) NOT NULL,
  `description` longtext DEFAULT NULL,
  `last_modified` datetime NOT NULL,
  PRIMARY KEY (`settings_key`,`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `%TABLE_PREFIX%osfaq_settings`;
CREATE TABLE IF NOT EXISTS `%TABLE_PREFIX%osfaq_settings` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `key_name` varchar(35) NOT NULL,
  `key_value` longtext,
  `field_type` varchar(15) NOT NULL,
  `sort_order` int(7) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_name` (`key_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `%TABLE_PREFIX%osfaq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSFDB_DEFAULT_LANG', 'english', 'lang', 1, now(), '0000-00-00 00:00:00'),
('OSFDB_TIMEZONE', 'Australia/Brisbane', 'timezone', 3, now(), '0000-00-00 00:00:00'),
('OSFDB_ENABLE_SSL', 'false', 'truefalse', 5, now(), '0000-00-00 00:00:00'),
('OSFDB_DEFAULT_IPP', '10', 'textfield', 6, now(), '0000-00-00 00:00:00'),
('OSFDB_STAFF_AS_ADMIN', 'false', 'truefalse', 7, now(), '0000-00-00 00:00:00'),
('OSFDB_DISABLE_CLIENT', 'false', 'truefalse', 8, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%osfaq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_ADMIN_HEADING', '', 'heading', 9, now(), '0000-00-00 00:00:00'),
('OSFDB_INACTIVE_COLOR', '#FFEBCC', 'textfield', 17, now(), '0000-00-00 00:00:00'),
('OSFDB_ACTIVE_COLOR', '#E1FFE1', 'textfield', 20, now(), '0000-00-00 00:00:00'),
('OSFDB_STATUS_DEFAULT', 'false', 'truefalse', 23, now(), '0000-00-00 00:00:00'),
('OSFDB_FEATURE_DEFAULT', 'false', 'truefalse', 24, now(), '0000-00-00 00:00:00'),
('OSFDB_WYSIWYG_STAFF', 'true', 'truefalse', 28, now(), '0000-00-00 00:00:00'),
('OSFDB_WYS_STAFF_THEME', 'Moono', 'wysiwyg_theme', 29, now(), '0000-00-00 00:00:00'),
('OSFDB_UPLOAD_EXTENSIONS', 'pdf, ods, odt, txt, doc, docx, xls, xlsx, tab, csv, xml', 'textfield', 30, now(), '0000-00-00 00:00:00'), 
('OSFDB_UPLOAD_SIZE', '5242880', 'upload_size', 31, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%osfaq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_CLIENT_HEADING', '', 'heading', 35, now(), '0000-00-00 00:00:00'),
('OSFDB_CLIENT_PG_STRIP', '3', 'textfield', 36, now(), '0000-00-00 00:00:00'),
('OSFDB_SHOW_SINGLE', 'false', 'truefalse', 40, now(), '0000-00-00 00:00:00'), 
('OSFDB_SHOW_FAQ_COUNTS', 'true', 'truefalse', 41, now(), '0000-00-00 00:00:00'), 
('OSFDB_INCLUDE_SUBCATS', 'false', 'truefalse', 42, now(), '0000-00-00 00:00:00'),
('OSFDB_OPTIONAL_FOOTER', '<div style="font-size:small"><code>Company, Business and Organisation names used in these FAQs may be trademarks of their respective owners.</code></div>', 'textarea', 43, now(), '0000-00-00 00:00:00'),
('OSFDB_SEARCH_BG_COLOR', '#FFCC00', 'textfield', 45, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%osfaq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_FAQ_SUBMIT_PAGE', '', 'heading', 46, now(), '0000-00-00 00:00:00'),
('OSFDB_USER_SUBMITS_ALLOW', 'true', 'truefalse', 47, now(), '0000-00-00 00:00:00'),
('OSFDB_USER_ANON', 'true', 'truefalse', 48, now(), '0000-00-00 00:00:00'),
('OSFDB_WYSIWYG_CLIENT', 'true', 'truefalse', 49, now(), '0000-00-00 00:00:00'),
('OSFDB_WYS_CLIENT_THEME', 'Moono', 'wysiwyg_theme', 50, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%osfaq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_RECAPTCHA_HEADING', '', 'heading', 51, now(), '0000-00-00 00:00:00'), 
('OSFDB_RECAPTCHA_ENABLE', 'false', 'truefalse', 52, now(), '0000-00-00 00:00:00'), 
('OSFDB_RECAPTCHA_PUBLIC_KEY', '', 'textfield', 53, now(), '0000-00-00 00:00:00'),
('OSFDB_RECAPTCHA_PRIVATE_KEY', '', 'textfield', 54, now(), '0000-00-00 00:00:00'), 
('OSFDB_RECAPTCHA_THEME', 'red', 'recaptcha_theme', 55, now(), '0000-00-00 00:00:00'),
('OSFDB_RECAPTCHA_TAB_INDEX', '7', 'textfield', 56, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%osfaq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_SEO_HEADING', '', 'heading', 59, now(), '0000-00-00 00:00:00'),
('OSFDB_URL_FRIENDLY', 'false', 'truefalse', 60, now(), '0000-00-00 00:00:00'),
('OSFDB_MAX_URL_LENGTH', '39', 'textfield', 61, now(), '0000-00-00 00:00:00'),
('OSFDB_SEO_REMOVE_JOINERS', 'true', 'truefalse', 62, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%osfaq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
('OSF_EXT_HEADING', '', 'heading', 65, now(), '0000-00-00 00:00:00'),
('OSFDB_EXT_FAQS_ALLOW', 'true', 'truefalse', 70, now(), '0000-00-00 00:00:00'),
('OSFDB_EXT_LIMIT', '3', 'textfield', 75, now(), '0000-00-00 00:00:00'),
('OSFDB_MAX_TXT_LENGTH', '35', 'textfield', 77, now(), '0000-00-00 00:00:00'),
('OSFDB_EXT_FEATURED', 'true', 'truefalse', 80, now(), '0000-00-00 00:00:00'),
('OSFDB_EXT_POPULAR', 'true', 'truefalse', 85, now(), '0000-00-00 00:00:00'),
('OSFDB_EXT_NEW', 'true', 'truefalse', 90, now(), '0000-00-00 00:00:00');

INSERT INTO `%TABLE_PREFIX%osfaq_settings` (`key_name`, `key_value`, `field_type`, `sort_order`, `date_added`, `last_modified`) VALUES
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

