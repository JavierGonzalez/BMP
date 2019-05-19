-- BMP


DROP TABLE IF EXISTS `blocks`;
DROP TABLE IF EXISTS `miners`;
DROP TABLE IF EXISTS `actions`;
DROP TABLE IF EXISTS `key_value`;


CREATE TABLE `blocks` (
  `id`                    int(8) UNSIGNED           NOT NULL AUTO_INCREMENT,
  `chain`                 char(3)               DEFAULT NULL,
  `height`                int(8) UNSIGNED       DEFAULT NULL,
  `hash`                  char(64)              DEFAULT NULL,
  `size`                  decimal(20,0)         DEFAULT NULL,
  `tx_count`              decimal(10,0)         DEFAULT NULL,
  `version_hex`           varchar(64)           DEFAULT NULL,
  `previousblockhash`     char(64)              DEFAULT NULL,
  `merkleroot`            char(64)              DEFAULT NULL,
  `time`                  datetime,
  `time_median`           datetime,
  `bits`                  varchar(20)           DEFAULT NULL,
  `nonce`                 decimal(20,0)         DEFAULT NULL,
  `difficulty`            decimal(30,8)         DEFAULT NULL,
  `reward_coinbase`       decimal(30,8)         DEFAULT NULL,
  `reward_fees`           decimal(30,8)         DEFAULT NULL,
  `coinbase`              varchar(900)          DEFAULT NULL,
  `pool`                  varchar(100)          DEFAULT NULL,
  `signals`               varchar(900)          DEFAULT NULL,
  `hashpower`             decimal(60,0)         DEFAULT NULL,
  PRIMARY KEY (id),
  KEY `chain` (`chain`),
  KEY `height` (`height`),
  KEY `time` (`time`),
  KEY `hashpower` (`hashpower`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `miners` (
  `id`                    bigint(16) UNSIGNED       NOT NULL AUTO_INCREMENT,
  `chain`                 char(3)               DEFAULT NULL,
  `txid`                  char(64)              DEFAULT NULL,
  `height`                int(8) UNSIGNED       DEFAULT NULL,
  `address`               varchar(64)           DEFAULT NULL,
  `method`                varchar(64)           DEFAULT NULL,
  `value`                 decimal(30,8)         DEFAULT NULL,
  `quota`                 int(8)                DEFAULT NULL,
  `power`                 decimal(18,14)        DEFAULT NULL,
  `hashpower`             decimal(60,0)         DEFAULT NULL,
  PRIMARY KEY (id),
  KEY `chain` (`chain`),
  KEY `height` (`height`),
  KEY `address` (`address`),
  KEY `hashpower` (`hashpower`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `actions` (
  `id`                    bigint(16) UNSIGNED       NOT NULL AUTO_INCREMENT,
  `chain`                 char(3)               DEFAULT NULL,
  `txid`                  char(64)              DEFAULT NULL,
  `height`                int(8) UNSIGNED       DEFAULT NULL,
  `time`                  datetime,
  `address`               varchar(64)           DEFAULT NULL,
  `op_return`             longtext              DEFAULT NULL,
  `action`                varchar(50)           DEFAULT NULL,
  `action_id`             varchar(10)           DEFAULT NULL,
  `p1`                    varchar(300)          DEFAULT NULL,
  `p2`                    varchar(300)          DEFAULT NULL,
  `p3`                    varchar(300)          DEFAULT NULL,
  `p4`                    varchar(300)          DEFAULT NULL,
  `p5`                    varchar(300)          DEFAULT NULL,
  `p6`                    varchar(300)          DEFAULT NULL,
  `json`                  longtext              DEFAULT NULL,
  `power`                 decimal(18,14)        DEFAULT NULL,
  `hashpower`             decimal(60,0)         DEFAULT NULL,
  PRIMARY KEY (id),
  KEY `chain` (`chain`),
  KEY `height` (`height`),
  KEY `time` (`time`),
  KEY `action_id` (`action_id`),
  KEY `p1` (`p1`),
  KEY `action` (`action`),
  KEY `hashpower` (`hashpower`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `key_value` (
  `id`                    int(8) UNSIGNED           NOT NULL AUTO_INCREMENT,
  `key`                   varchar(200)          DEFAULT NULL,
  `value`                 longtext              DEFAULT NULL,
  PRIMARY KEY (id),
  KEY `key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
