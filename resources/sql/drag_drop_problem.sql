-- MySQL Script generated by MySQL Workbench
-- Tue Dec 26 19:36:09 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`drag_drop`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`drag_drop` ;

CREATE TABLE IF NOT EXISTS `mydb`.`drag_drop` (
  `drag_drop_id` INT NOT NULL,
  `drag_drop_description` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`drag_drop_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`drag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`drag` ;

CREATE TABLE IF NOT EXISTS `mydb`.`drag` (
  `drag_id` INT NOT NULL,
  `drag_description` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`drag_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`drop`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`drop` ;

CREATE TABLE IF NOT EXISTS `mydb`.`drop` (
  `drop_id` INT NOT NULL,
  `drop_description` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`drop_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`drag_drop_association`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`drag_drop_association` ;

CREATE TABLE IF NOT EXISTS `mydb`.`drag_drop_association` (
  `drag_drop_drag_drop_id` INT NOT NULL,
  `drag_drag_id` INT NOT NULL,
  `drop_drop_id` INT NOT NULL,
  INDEX `fk_drag_drop_association_drag_drop_idx` (`drag_drop_drag_drop_id` ASC),
  INDEX `fk_drag_drop_association_drag1_idx` (`drag_drag_id` ASC),
  INDEX `fk_drag_drop_association_drop1_idx` (`drop_drop_id` ASC),
  PRIMARY KEY (`drag_drop_drag_drop_id`, `drag_drag_id`, `drop_drop_id`),
  CONSTRAINT `fk_drag_drop_association_drag_drop`
    FOREIGN KEY (`drag_drop_drag_drop_id`)
    REFERENCES `mydb`.`drag_drop` (`drag_drop_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_drag_drop_association_drag1`
    FOREIGN KEY (`drag_drag_id`)
    REFERENCES `mydb`.`drag` (`drag_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_drag_drop_association_drop1`
    FOREIGN KEY (`drop_drop_id`)
    REFERENCES `mydb`.`drop` (`drop_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
