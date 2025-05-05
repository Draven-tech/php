-- Database schema for USJR application
SET NAMES utf8mb4;
START TRANSACTION;

CREATE DATABASE IF NOT EXISTS `orm` 
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `orm`;

CREATE TABLE IF NOT EXISTS `students` (
    `studID` INT AUTO_INCREMENT PRIMARY KEY,
    `studlname` VARCHAR(255) NOT NULL,
    `studfname` VARCHAR(255) NOT NULL,
    `studmname` VARCHAR(255) NULL,
    `Course` VARCHAR(255) NOT NULL,
    `Year` TINYINT UNSIGNED NOT NULL CHECK (`Year` BETWEEN 1 AND 5),
    `studcollege` VARCHAR(10) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_college` (`studcollege`),
    INDEX `idx_name_combo` (`studlname`, `studfname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Minimal test data
INSERT INTO `students` 
    (`studlname`, `studfname`, `studmname`, `Course`, `Year`, `studcollege`)
VALUES
    ('Gudio', 'Jeoffrey', 'Camocamo', 'BSIT', 4, 'SCS'),
    ('Bandalan', 'Roderick', 'A', 'BSIT', 4, 'SCS')
ON DUPLICATE KEY UPDATE 
    `updated_at` = CURRENT_TIMESTAMP;

COMMIT;