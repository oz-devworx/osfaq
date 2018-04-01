UPDATE `%TABLE_PREFIX%osfaq_admin` SET `key_value` = '1.4.0 ST' WHERE `key_name` = 'DB_FAQ_VERSION';

ALTER TABLE `%TABLE_PREFIX%osfaq` ADD `canned` SMALLINT(1) NOT NULL DEFAULT '0' AFTER `featured`;
