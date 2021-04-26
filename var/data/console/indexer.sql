
DROP TABLE IF EXISTS `index_process_event`;
DROP TABLE IF EXISTS `index_event`;
DROP TABLE IF EXISTS `index_process`;

CREATE TABLE `index_event` (

`event_id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,

`type` VARCHAR(64) NOT NULL,

`entity` VARCHAR(64) NOT NULL,

`entity_pk` BIGINT(20) DEFAULT NULL,

`created_at` DATETIME NOT NULL,

`old_data` MEDIUMTEXT,

`new_data` MEDIUMTEXT,

PRIMARY KEY (`event_id`),

UNIQUE KEY `IDX_UNIQUE_EVENT` (`type`,`entity`,`entity_pk`)

) ENGINE=INNODB DEFAULT CHARSET=utf8;

CREATE TABLE `index_process` (

`process_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,

`indexer_code` VARCHAR(32) NOT NULL,

`status` ENUM('pending','working','require_reindex') NOT NULL DEFAULT 'pending',

`started_at` DATETIME DEFAULT NULL,

`ended_at` DATETIME DEFAULT NULL,

`mode` ENUM('real_time','manual') NOT NULL DEFAULT 'real_time',

PRIMARY KEY (`process_id`),

UNIQUE KEY `IDX_CODE` (`indexer_code`)

) ENGINE=INNODB DEFAULT CHARSET=utf8;


INSERT INTO
`index_process`(`process_id`,`indexer_code`,`status`,`started_at`,`ended_at`,`mode`)
VALUES (1,'catalog_product_attribute','pending','2010-02-13
00:00:00','2010-02-13
00:00:00','real_time'),(2,'catalog_product_price','pending','2010-02-13
00:00:00','2010-02-13
00:00:00','real_time'),(3,'catalog_url','pending','2010-02-13
19:12:15','2010-02-13
19:12:15','real_time'),(4,'catalog_product_flat','pending','2010-02-13
00:00:00','2010-02-13
00:00:00','real_time'),(5,'catalog_category_flat','pending','2010-02-13
00:00:00','2010-02-13
00:00:00','real_time'),(6,'catalog_category_product','pending','2010-02-13
00:00:00','2010-02-13
00:00:00','real_time'),(7,'catalogsearch_fulltext','pending','2010-02-13
00:00:00','2010-02-13
00:00:00','real_time'),(8,'cataloginventory_stock','pending','2010-02-13
00:00:00','2010-02-13 00:00:00','real_time');

CREATE TABLE `index_process_event` (

`process_id` INT(10) UNSIGNED NOT NULL,

`event_id` BIGINT(20) UNSIGNED NOT NULL,

`status` ENUM('new','working','done','error') NOT NULL DEFAULT 'new',

PRIMARY KEY (`process_id`,`event_id`),

KEY `FK_INDEX_EVNT_PROCESS` (`event_id`),

CONSTRAINT `FK_INDEX_EVNT_PROCESS` FOREIGN KEY (`event_id`) REFERENCES
`index_event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,

CONSTRAINT `FK_INDEX_PROCESS_EVENT` FOREIGN KEY (`process_id`)
REFERENCES `index_process` (`process_id`) ON DELETE CASCADE ON UPDATE
CASCADE

) ENGINE=INNODB DEFAULT CHARSET=utf8;