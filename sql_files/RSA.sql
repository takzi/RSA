DROP DATABASE IF EXISTS `RSA_DB`;
CREATE DATABASE RSA_DB;

USE RSA_DB;

DROP TABLE IF EXISTS `role`;
CREATE TABLE role (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(35) NOT NULL,
	PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `user`;
CREATE TABLE user (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`first_name` VARCHAR(30) NOT NULL,
	`last_name` VARCHAR(30) NOT NULL,
	`role_ID` INT(11) NOT NULL,
	`email` VARCHAR(40) NOT NULL UNIQUE,
	`password` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `fk_user_role` (`role_ID`),
	CONSTRAINT `fk_user_role` FOREIGN KEY (`role_ID`) REFERENCES `role` (`id`) ON UPDATE CASCADE
);

DROP TABLE IF EXISTS `bus_driver`;
CREATE TABLE bus_driver (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`contact_ID` INT(11) NOT NULL,
	`contact_number` VARCHAR(15) NULL,
	PRIMARY KEY (`id`),
	KEY `fk_bus_driver_contact` (`contact_ID`),
	CONSTRAINT `fk_bus_driver_contact` FOREIGN KEY (`contact_ID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS `availability`;
CREATE TABLE availability (
	`bus_driver_ID` INT(11) NOT NULL,
	`availability` DATE NOT NULL,
	`time_of_day` ENUM('Any','Morning','Afternoon') NOT NULL,
	PRIMARY KEY (`bus_driver_ID`,`availability`),
	KEY `fk_availability_bus_driver` (`bus_driver_ID`),
	CONSTRAINT `fk_availability_bus_driver` FOREIGN KEY (`bus_driver_ID`) REFERENCES `bus_driver` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE schedule (
	`id` INT(11) NOT NULL,
	`date` DATE NOT NULL,
	`time_of_day` ENUM('Any','Morning','Afternoon') NOT NULL,
	`bus_driver_ID` INT(11),
	`status` ENUM('Pending Approval','Approved','In Progress','Finalized'),
	PRIMARY KEY (`id`,`date`,`time_of_day`),
	KEY `fk_schedule_bus_driver` (`bus_driver_ID`),
	CONSTRAINT `fk_schedule_bus_driver` FOREIGN KEY (`bus_driver_ID`) REFERENCES `bus_driver` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS `congregation`;
CREATE TABLE congregation (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`contact_ID` INT(11) NOT NULL,
	`name` VARCHAR(45) NOT NULL,
	PRIMARY KEY (`id`),
	KEY `fk_congregation_contact` (`contact_ID`),
	CONSTRAINT `fk_congregation_contact` FOREIGN KEY (`contact_ID`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS `rotation`;
CREATE TABLE rotation (
	`id` INT(11) NOT NULL,
	`rotation_number` INT(11) NOT NULL,
	`congregation_ID` INT(11) NOT NULL,
	`rotation_date_from` DATE NOT NULL,
	`rotation_date_to` DATE NOT NULL,
	`status` ENUM('Pending Approval','Approved','In Progress','Finalized'),
	PRIMARY KEY (`id`,`rotation_number`),
	KEY `fk_rotation_congregation` (`congregation_ID`),
	CONSTRAINT `fk_rotation_congregation` FOREIGN KEY (`congregation_ID`) REFERENCES `congregation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS `blackout_dates`;
CREATE TABLE blackout_dates (
	`congregation_ID` INT(11) NOT NULL,
	`blackout_date_from` DATE NOT NULL,
	`blackout_date_to` DATE NOT NULL,
	PRIMARY KEY (`congregation_ID`,`blackout_date_from`,`blackout_date_to`),
	KEY `fk_blackout_congregation` (`congregation_ID`),
	CONSTRAINT `fk_blackout_congregation` FOREIGN KEY (`congregation_ID`) REFERENCES `congregation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS `holiday`;
CREATE TABLE holiday (
	`name` VARCHAR(20) NOT NULL,
	`date` DATE NOT NULL,
	`last_congregation` INT(11) NULL,
	PRIMARY KEY (`name`,`date`),
	KEY `fk_last_congregation` (`last_congregation`),
	CONSTRAINT `fk_last_congregation` FOREIGN KEY (`last_congregation`) REFERENCES `congregation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS `supporting_congregation`;
CREATE TABLE supporting_congregation (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(35) NOT NULL,
	PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `congregation_supporting`;
CREATE TABLE congregation_supporting (
	`congregation_ID` INT(11) NOT NULL,
	`supporting_ID` INT(11) NOT NULL,
	PRIMARY KEY(`congregation_ID`,`supporting_ID`),
	KEY `fk_congregation_supporting_supporting_ID` (`supporting_ID`),
	KEY `fk_congregation_supporting_congregation_ID` (`congregation_ID`),
	CONSTRAINT `fk_congregation_supporting_supporting_ID` FOREIGN KEY (`supporting_ID`) REFERENCES `supporting_congregation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT `fk_congregation_supporting_congregation_ID` FOREIGN KEY (`congregation_ID`) REFERENCES `congregation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);