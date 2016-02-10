-- MySQL Script generated by MySQL Workbench
-- 02/10/16 10:49:02
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema wds_di
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `wds_di` ;

-- -----------------------------------------------------
-- Schema wds_di
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `wds_di` DEFAULT CHARACTER SET utf8 ;
USE `wds_di` ;

-- -----------------------------------------------------
-- Table `UZYTKOWNICY`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UZYTKOWNICY` ;

CREATE TABLE IF NOT EXISTS `UZYTKOWNICY` (
  `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `LOGIN` VARCHAR(20) NOT NULL,
  `HASLO` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `id_UNIQUE` (`ID` ASC),
  UNIQUE INDEX `nazwa_UNIQUE` (`LOGIN` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ODDZIAL`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ODDZIAL` ;

CREATE TABLE IF NOT EXISTS `ODDZIAL` (
  `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `NAZWA` VARCHAR(25) NOT NULL,
  `NUMER` VARCHAR(10) NOT NULL,
  `TATUAZ` VARCHAR(5) NOT NULL,
  `ADRES` VARCHAR(60) NOT NULL,
  `TELEFON` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `id_UNIQUE` (`ID` ASC),
  UNIQUE INDEX `nazwa_UNIQUE` (`NAZWA` ASC),
  UNIQUE INDEX `TATUAZ_UNIQUE` (`TATUAZ` ASC),
  UNIQUE INDEX `NUMER_UNIQUE` (`NUMER` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `U_O`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `U_O` ;

CREATE TABLE IF NOT EXISTS `U_O` (
  `U_ID` INT UNSIGNED NOT NULL,
  `O_ID` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`U_ID`, `O_ID`),
  INDEX `fk_uzytkownicy_has_oddzial_oddzial1_idx` (`O_ID` ASC),
  INDEX `fk_uzytkownicy_has_oddzial_uzytkownicy_idx` (`U_ID` ASC),
  CONSTRAINT `fk_uzytkownicy_has_oddzial_uzytkownicy`
    FOREIGN KEY (`U_ID`)
    REFERENCES `UZYTKOWNICY` (`ID`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_uzytkownicy_has_oddzial_oddzial1`
    FOREIGN KEY (`O_ID`)
    REFERENCES `ODDZIAL` (`ID`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `HODOWCA`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HODOWCA` ;

CREATE TABLE IF NOT EXISTS `HODOWCA` (
  `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `IMIE` VARCHAR(20) NULL,
  `NAZWISKO` VARCHAR(45) NOT NULL,
  `TELEFON` VARCHAR(20) NOT NULL,
  `ADRES` VARCHAR(60) NOT NULL,
  UNIQUE INDEX `id_UNIQUE` (`ID` ASC),
  PRIMARY KEY (`ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `HODOWLA`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `HODOWLA` ;

CREATE TABLE IF NOT EXISTS `HODOWLA` (
  `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `NAZWA` VARCHAR(50) NOT NULL,
  `O_ID` INT UNSIGNED NOT NULL,
  `H_ID` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `id_UNIQUE` (`ID` ASC),
  INDEX `fk_hodowla_oddzial1_idx` (`O_ID` ASC),
  INDEX `fk_HODOWLA_HODOWCA1_idx` (`H_ID` ASC),
  CONSTRAINT `fk_hodowla_oddzial1`
    FOREIGN KEY (`O_ID`)
    REFERENCES `ODDZIAL` (`ID`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_HODOWLA_HODOWCA1`
    FOREIGN KEY (`H_ID`)
    REFERENCES `HODOWCA` (`ID`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MIOT`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `MIOT` ;

CREATE TABLE IF NOT EXISTS `MIOT` (
  `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `URODZONY` DATE NOT NULL,
  `ZNAKOWANY` DATE NOT NULL,
  `POZYCJA` VARCHAR(20) NOT NULL,
  `H_ID` INT UNSIGNED NOT NULL,
  INDEX `fk_MIOT_HODOWLA1_idx` (`H_ID` ASC),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  PRIMARY KEY (`ID`),
  CONSTRAINT `fk_MIOT_HODOWLA1`
    FOREIGN KEY (`H_ID`)
    REFERENCES `HODOWLA` (`ID`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `FCI`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `FCI` ;

CREATE TABLE IF NOT EXISTS `FCI` (
  `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `NAZWA` VARCHAR(90) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  UNIQUE INDEX `NAZWA_UNIQUE` (`NAZWA` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `RASA`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `RASA` ;

CREATE TABLE IF NOT EXISTS `RASA` (
  `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `NAZWA` VARCHAR(50) NOT NULL,
  `FCI_ID` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  UNIQUE INDEX `NAZWA_UNIQUE` (`NAZWA` ASC),
  INDEX `fk_RASA_FCI1_idx` (`FCI_ID` ASC),
  CONSTRAINT `fk_RASA_FCI1`
    FOREIGN KEY (`FCI_ID`)
    REFERENCES `FCI` (`ID`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `PIES`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `PIES` ;

CREATE TABLE IF NOT EXISTS `PIES` (
  `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `SUKA` TINYINT(1) NULL,
  `IMIE` VARCHAR(20) NULL,
  `OZNACZENIE` VARCHAR(15) NOT NULL,
  `OJCIEC` VARCHAR(80) NOT NULL,
  `MATKA` VARCHAR(80) NOT NULL,
  `M_ID` INT UNSIGNED NOT NULL,
  `R_ID` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  UNIQUE INDEX `OZNACZENIE_UNIQUE` (`OZNACZENIE` ASC),
  INDEX `fk_PIES_MIOT1_idx` (`M_ID` ASC),
  INDEX `fk_PIES_RASA1_idx` (`R_ID` ASC),
  CONSTRAINT `fk_PIES_MIOT1`
    FOREIGN KEY (`M_ID`)
    REFERENCES `MIOT` (`ID`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PIES_RASA1`
    FOREIGN KEY (`R_ID`)
    REFERENCES `RASA` (`ID`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
