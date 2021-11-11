-- BMP — Javier González González

DROP TABLE IF EXISTS `blocks`;
DROP TABLE IF EXISTS `miners`;
DROP TABLE IF EXISTS `actions`;
DROP TABLE IF EXISTS `key_value`;


CREATE TABLE `blocks` (
    `id`                    int(10) UNSIGNED          NOT NULL AUTO_INCREMENT,
    `blockchain`            char(3)                   NOT NULL COMMENT 'Ticker',
    `height`                int(8) UNSIGNED           NOT NULL,
    `hash`                  char(64)                  NOT NULL,
    `difficulty`            decimal(25,2)             NOT NULL,
    `time`                  datetime,
    `time_median`           datetime,
    `size`                  decimal(20,0)         DEFAULT NULL,
    `tx_count`              decimal(10,0)         DEFAULT NULL,
    `version_hex`           varchar(64)           DEFAULT NULL,
    `coinbase`              varchar(900)          DEFAULT NULL,
    `pool`                  varchar(100)          DEFAULT NULL,
    `pool_link`             varchar(100)          DEFAULT NULL,
    `signals`               varchar(900)          DEFAULT NULL,
    `power_by`              varchar(20)               NOT NULL COMMENT 'value | opreturn',
    `quota_total`           decimal(30,8)             NOT NULL,
    `hashpower`             decimal(60,0)             NOT NULL COMMENT 'difficulty * pow(2,32) / 600',
    PRIMARY KEY (id),
    KEY `blockchain` (`blockchain`),
    KEY `height` (`height`),
    KEY `time` (`time`),
    KEY `pool` (`pool`),
    KEY `hashpower` (`hashpower`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `miners` (
    `id`                    bigint(16) UNSIGNED       NOT NULL AUTO_INCREMENT,
    `blockchain`            char(3)                   NOT NULL COMMENT 'Ticker',
    `txid`                  char(64)                  NOT NULL,
    `height`                int(8) UNSIGNED           NOT NULL,
    `address`               varchar(64)               NOT NULL,
    `address_delegated`     varchar(64)           DEFAULT NULL COMMENT 'Optional delegation origin address',
    `nick`                  varchar(30)           DEFAULT NULL,
    `power_by`              varchar(20)           DEFAULT NULL COMMENT 'NULL | action',
    `quota`                 decimal(30,8)             NOT NULL COMMENT 'Relative to a block',
    `power`                 decimal(12,8)         DEFAULT NULL COMMENT 'Percentage, updated with every block',
    `hashpower`             decimal(60,0)             NOT NULL COMMENT 'block_hashpower / BLOCK_WINDOW',
    PRIMARY KEY (id),
    KEY `blockchain` (`blockchain`),
    KEY `height` (`height`),
    KEY `address` (`address`),
    KEY `address_delegated` (`address_delegated`),
    KEY `power` (`power`),
    KEY `hashpower` (`hashpower`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `actions` (
    `id`                    bigint(16) UNSIGNED       NOT NULL AUTO_INCREMENT,
    `blockchain`            char(3)                   NOT NULL COMMENT 'Ticker',
    `txid`                  char(64)                  NOT NULL,
    `height`                int(8) UNSIGNED       DEFAULT NULL,
    `time`                  datetime,
    `address`               varchar(64)               NOT NULL,
    `op_return`             longtext              DEFAULT NULL COMMENT 'hex',
    `action_id`             char(2)                   NOT NULL,
    `action`                varchar(50)               NOT NULL,
    `p1`                    varchar(300)          DEFAULT NULL COMMENT 'BMP protocol parameter',
    `p2`                    varchar(300)          DEFAULT NULL,
    `p3`                    varchar(300)          DEFAULT NULL,
    `p4`                    varchar(300)          DEFAULT NULL,
    `p5`                    varchar(300)          DEFAULT NULL,
    `p6`                    varchar(300)          DEFAULT NULL,
    `nick`                  varchar(50)           DEFAULT NULL,
    `power`                 decimal(12,8)             NOT NULL COMMENT 'Percentage of hashpower',
    `hashpower`             decimal(60,0)             NOT NULL COMMENT 'Hashpower sum by miner address',
    `evidence`              longtext              DEFAULT NULL COMMENT 'Hashpower blocks proof',
    `json`                  longtext              DEFAULT NULL COMMENT 'Action cache',
    PRIMARY KEY (id),
    KEY `blockchain` (`blockchain`),
    KEY `txid` (`txid`),
    KEY `height` (`height`),
    KEY `time` (`time`),
    KEY `address` (`address`),
    KEY `action` (`action`),
    KEY `p1` (`p1`),
    KEY `p2` (`p2`),
    KEY `p3` (`p3`),
    KEY `p4` (`p4`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `key_value` (
    `id`                    int(10) UNSIGNED          NOT NULL AUTO_INCREMENT,
    `name`                  varchar(700)              NOT NULL,
    `value`                 longtext              DEFAULT NULL,
    PRIMARY KEY (id),
    KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
