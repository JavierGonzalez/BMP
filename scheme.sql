-- BMP — Javier González González


DROP TABLE IF EXISTS `blocks`;
DROP TABLE IF EXISTS `miners`;
DROP TABLE IF EXISTS `actions`;


CREATE TABLE `blocks` (
    `id`                    int(8) UNSIGNED           NOT NULL AUTO_INCREMENT,
    `chain`                 char(3)                   NOT NULL COMMENT 'Ticker',
    `height`                int(8) UNSIGNED           NOT NULL,
    `hash`                  char(64)                  NOT NULL,
    `size`                  decimal(20,0)             NOT NULL,
    `tx_count`              decimal(10,0)             NOT NULL,
    `version_hex`           varchar(64)               NOT NULL,
    `previousblockhash`     char(64)                  NOT NULL,
    `merkleroot`            char(64)                  NOT NULL,
    `time`                  datetime,
    `time_median`           datetime,
    `bits`                  varchar(20)               NOT NULL,
    `nonce`                 decimal(20,0)             NOT NULL,
    `difficulty`            decimal(30,8)             NOT NULL,
    `coinbase`              varchar(900)          DEFAULT NULL,
    `pool`                  varchar(100)          DEFAULT NULL,
    `signals`               varchar(900)          DEFAULT NULL,
    `power_by`              varchar(20)               NOT NULL COMMENT 'value OR opreturn',
    `quota_total`           decimal(30,8)             NOT NULL,
    `hashpower`             decimal(60,0)             NOT NULL,
    PRIMARY KEY (id),
    KEY `chain` (`chain`),
    KEY `height` (`height`),
    KEY `time` (`time`),
    KEY `hashpower` (`hashpower`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `miners` (
    `id`                    bigint(16) UNSIGNED       NOT NULL AUTO_INCREMENT,
    `chain`                 char(3)                   NOT NULL COMMENT 'Ticker',
    `txid`                  char(64)                  NOT NULL,
    `height`                int(8) UNSIGNED           NOT NULL,
    `address`               varchar(64)               NOT NULL,
    `nick`                  varchar(30)           DEFAULT NULL,
    `quota`                 decimal(30,8)             NOT NULL COMMENT 'Relative to a block',
    `power`                 decimal(12,8)         DEFAULT NULL COMMENT 'Percentage, updated with every block',
    `hashpower`             decimal(60,0)             NOT NULL COMMENT 'Hashes',
    PRIMARY KEY (id),
    KEY `chain` (`chain`),
    KEY `height` (`height`),
    KEY `address` (`address`),
    KEY `power` (`power`),
    KEY `hashpower` (`hashpower`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



CREATE TABLE `actions` (
    `id`                    bigint(16) UNSIGNED       NOT NULL AUTO_INCREMENT,
    `chain`                 char(3)                   NOT NULL COMMENT 'Ticker',
    `txid`                  char(64)                  NOT NULL,
    `height`                int(8) UNSIGNED       DEFAULT NULL,
    `time`                  datetime,
    `address`               varchar(64)               NOT NULL,
    `op_return`             longtext                  NOT NULL COMMENT 'hex',
    `action_id`             char(2)                   NOT NULL,
    `action`                varchar(50)               NOT NULL,
    `p1`                    varchar(300)          DEFAULT NULL,
    `p2`                    varchar(300)          DEFAULT NULL,
    `p3`                    varchar(300)          DEFAULT NULL,
    `p4`                    varchar(300)          DEFAULT NULL,
    `p5`                    varchar(300)          DEFAULT NULL,
    `p6`                    varchar(300)          DEFAULT NULL,
    `json`                  longtext              DEFAULT NULL,
    `nick`                  varchar(30)           DEFAULT NULL,
    `power`                 decimal(12,8)             NOT NULL COMMENT 'Percentage, immutable',
    `hashpower`             decimal(60,0)             NOT NULL COMMENT 'Hashes,     immutable',
    PRIMARY KEY (id),
    KEY `chain` (`chain`),
    KEY `height` (`height`),
    KEY `time` (`time`),
    KEY `action_id` (`action_id`),
    KEY `action` (`action`),
    KEY `p1` (`p1`),
    KEY `p2` (`p2`),
    KEY `power` (`power`),
    KEY `hashpower` (`hashpower`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
