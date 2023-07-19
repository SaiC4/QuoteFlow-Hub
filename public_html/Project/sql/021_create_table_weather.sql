CREATE TABLE IF NOT EXISTS `Weather_data`(
    `id`        int auto_increment not null,
    `city`      VARCHAR(255) NOT NULL,
    `state`     VARCHAR(50) NOT NULL,
    `country`   VARCHAR(50) NOT NULL,
    `date_time` DATETIME NOT NULL,
    `temp`      DECIMAL(5, 2) NOT NULL,
    `longit`    DECIMAL(9, 6),
    `latit`     DECIMAL(8, 6),
    `airqual`   INT NOT NULL,
    `created`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `modified`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
)