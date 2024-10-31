CREATE TABLE `%{database.entities.button.table}`
(
    `id`               INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `label`            VARCHAR(100)     NULL,
    `paymentType`      VARCHAR(50)               DEFAULT 'CB',
    `image`            VARCHAR(250)              DEFAULT NULL,
    `height`           INT              NULL,
    `position`         INT              NULL     DEFAULT 1,
    `displayType`      VARCHAR(10)      NOT NULL DEFAULT 'DEFAULT',
    `integration`      VARCHAR(10)      NOT NULL DEFAULT 'EXTERNAL',
    `paymentNumber`    INT(5) UNSIGNED  NOT NULL DEFAULT 1,
    `firstPaymentPart` INT(5) UNSIGNED           DEFAULT NULL,
    `orderRepeated`    INT(1) UNSIGNED           DEFAULT 0,
    `discount`         INT(11) UNSIGNED NOT NULL DEFAULT 0,
    `minAmount`        DECIMAL(10, 2)   NULL,
    `maxAmount`        DECIMAL(10, 2)   NULL,
    `paymentMode`      VARCHAR(10)      NOT NULL DEFAULT 'CASH',
    `paymentReport`    VARCHAR(15)               DEFAULT NULL,
    `id_shop`          INT(11) UNSIGNED NOT NULL
) ENGINE = `%{db.var.engine}`
  DEFAULT CHARSET = `utf8`
;
