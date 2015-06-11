CREATE DATABASE IF NOT EXISTS `1414` DEFAULT CHARACTER SET latin1 ;
USE `1414`;
CREATE  TABLE IF NOT EXISTS `config_farm` (
	`farm_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`farm_uid` VARCHAR(50) NOT NULL DEFAULT '1414' COMMENT 'the farm unique name',
	`name` VARCHAR(50) NOT NULL DEFAULT '' COMMENT 'the farm name',
	`domain` VARCHAR(50) NOT NULL DEFAULT '1414intl.com' COMMENT 'farm domain name used by UAC for identification',
	`language` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`row_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
	PRIMARY KEY (`farm_id`),
	UNIQUE INDEX `config_partner_farm_uid_unique_index` (`farm_uid` ASC)
) ENGINE = InnoDB AUTO_INCREMENT = 230000000 DEFAULT CHARACTER SET = latin1 CHECKSUM = 1 ROW_FORMAT = DYNAMIC;

CREATE TABLE IF NOT EXISTS `config_tenant` (
	`tenant_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`farm_id` INT(11) UNSIGNED NOT NULL,
	`tenant_uid` VARCHAR(50) NULL COMMENT 'the unique tenant uid that tied to the tenant id', 
	`name` VARCHAR(50) NULL DEFAULT NULL COMMENT 'printable tenant name for log an dither service functions',
	`time_zone` VARCHAR(64) NOT NULL DEFAULT 'America/Los_Angeles' COMMENT 'time area mapping (e.g.: America/Los_Angeles)',
	`type` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '[1=default,0=regular]',
	`row_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`tenant_id`),
	INDEX `config_tenant_partner_id_index` (`farm_id` ASC),
	UNIQUE INDEX `config_tenant_tenant_uid_unique_index` (`tenant_uid` ASC),
	INDEX `config_tenant_name_index` (`name` ASC),
	CONSTRAINT `config_tenant_farm_id_foreign_key` FOREIGN KEY (`farm_id`) REFERENCES `config_farm` (`farm_id`) ON DELETE CASCADE ON UPDATE RESTRICT 
) ENGINE = InnoDB AUTO_INCREMENT = 240000000 DEFAULT CHARACTER SET = latin1 CHECKSUM = 1 COMMENT = 'Table for tenant (billable customer/company) information' ROW_FORMAT = DYNAMIC;

CREATE  TABLE IF NOT EXISTS `config_user` (
	`user_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`tenant_id` INT(11) UNSIGNED NOT NULL,
	`fname` VARCHAR(50) NULL DEFAULT NULL COMMENT 'user First name',
	`lname` VARCHAR(50) NULL DEFAULT NULL COMMENT 'user Last name',
	`email` VARCHAR(256) NULL DEFAULT NULL COMMENT 'user email',
	`language` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '[1=us,2=de]',
	`type` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '[1=default,0=regular]',
	`row_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
	PRIMARY KEY (`user_id`),
	INDEX `config_user_tenant_id_index` (`tenant_id` ASC),
	UNIQUE INDEX `config_user_email_unique_index` (`email` ASC),
	CONSTRAINT `config_user_tenant_id_foreign_key` FOREIGN KEY (`tenant_id`) REFERENCES `config_tenant` (`tenant_id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 250000000 DEFAULT CHARACTER SET = latin1 CHECKSUM = 1 COMMENT = 'USER is a object to represent end-user' ROW_FORMAT = DYNAMIC;

CREATE  TABLE IF NOT EXISTS `config_number` (
	`number_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`number` BIGINT(20) UNSIGNED NOT NULL,
	`user_id` INT(11) UNSIGNED NOT NULL,
	`intl_code` INT(11) UNSIGNED NULL DEFAULT 11,
	`country_code` INT(11) UNSIGNED NULL DEFAULT NULL,
	`area_code` INT(11) UNSIGNED NULL DEFAULT NULL,
	`row_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`number_id`),
	UNIQUE INDEX `config_number_number` (`number` ASC),
	INDEX `config_number_user_id_index` (`user_id` ASC),
	CONSTRAINT `config_number_user_id` FOREIGN KEY (`user_id`) REFERENCES `config_user` (`user_id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 260000000 DEFAULT CHARACTER SET = latin1 CHECKSUM = 1 ROW_FORMAT = DYNAMIC;

CREATE  TABLE IF NOT EXISTS `config_device` (
	`device_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) UNSIGNED NOT NULL,
	`username` BIGINT(20) UNSIGNED NOT NULL,
	`ha1` CHAR(64) NULL, 
	`device_type` TINYINT(1) UNSIGNED NULL DEFAULT 0 COMMENT 'device type [1=1414, 0=regular]',
	`row_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
	PRIMARY KEY (`device_id`),
	UNIQUE INDEX `config_device_device_user_id_index` (`user_id`, `device_id`),
	INDEX `config_device_user_id_index` (`user_id` ASC),
	UNIQUE INDEX `config_device_username_unique_index` (`username` ASC),
	CONSTRAINT `config_device_user_id_foreign_key` FOREIGN KEY (`user_id`) REFERENCES `config_user` (`user_id` ) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 270000000 DEFAULT CHARACTER SET = latin1 CHECKSUM = 1 COMMENT = 'User Agent Client' ROW_FORMAT = DYNAMIC;

CREATE TABLE `state_device`(
	`state_device_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`device_id` INT(11) UNSIGNED NOT NULL,
	`ip` INT(11) UNSIGNED NOT NULL,
	`status` VARCHAR(512) NOT NULL,
	`bt` BIGINT(20) UNSIGNED NOT NULL,
	`nonce` VARCHAR(128) NULL,
	`apikey` VARCHAR(128) NULL,
	`row_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`state_device_id`),
	KEY `state_device_device_id` (`device_id`),
	CONSTRAINT `state_device_config_device_device_id` FOREIGN KEY (`device_id`) REFERENCES `config_device` (`device_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT = 280000000 DEFAULT CHARSET=latin1 CHECKSUM=1 ROW_FORMAT=DYNAMIC;

CREATE TABLE `state_cmd`(
	`cmd_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`device_id` INT(11) UNSIGNED NOT NULL,
	`cmd` VARCHAR(512) NOT NULL,
	`row_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`cmd_id`),
	KEY `state_cmd_device_id` (`device_id`),
	CONSTRAINT `state_cmd_config_device_device_id` FOREIGN KEY (`device_id`) REFERENCES `config_device` (`device_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT = 290000000 DEFAULT CHARSET=latin1 CHECKSUM=1 ROW_FORMAT=DYNAMIC;
