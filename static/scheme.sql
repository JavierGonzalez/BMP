-- BMP

CREATE TABLE `blocks` (
  `id`                    int(8) UNSIGNED       NOT NULL AUTO_INCREMENT,
  `height`                int(8) UNSIGNED       DEFAULT NULL,
  `time`                  timestamp             DEFAULT NULL,
  `nonce`                 varchar(32)           DEFAULT NULL,
  `hash`                  varchar(64)           DEFAULT NULL,
  `size`                  decimal(20,0)         DEFAULT NULL,
  `difficulty`            varchar(32)           DEFAULT NULL,
  `tx_count`              decimal(10,0)         DEFAULT NULL,
  `reward_block`          varchar(32)           DEFAULT NULL,
  `reward_fees`           varchar(32)           DEFAULT NULL,
  `hashpower`             decimal(50,0)         DEFAULT NULL,
  `coinbase_text_hex`     varchar(512)          DEFAULT NULL,
  `coinbase_text`         varchar(32)           DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `hashpower` (
  `id`                    bigint(16) UNSIGNED   NOT NULL AUTO_INCREMENT,
  `height`                int(8) UNSIGNED       DEFAULT NULL,
  `address`               varchar(64)           DEFAULT NULL,
  `value`                 int(8)                DEFAULT NULL,
  `share`                 decimal(16,13)        DEFAULT NULL,
  `hashpower`             decimal(50,0)         DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `tx` (
  `id`                    bigint(16) UNSIGNED   NOT NULL AUTO_INCREMENT,
  `height`                int(8) UNSIGNED       DEFAULT NULL,
  `address`               varchar(64)           DEFAULT NULL,
  `value`                 int(8)                DEFAULT NULL,
  `share`                 decimal(16,13)        DEFAULT NULL,
  `hashpower`             decimal(50,0)         DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `key_value` (
  `id`                    int(8) UNSIGNED       NOT NULL AUTO_INCREMENT,
  `key`                   varchar(32)           DEFAULT NULL,
  `value`                 varchar(512)          DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;