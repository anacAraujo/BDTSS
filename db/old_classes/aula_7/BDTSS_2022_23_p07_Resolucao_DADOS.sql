SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';



-- -----------------------------------------------------
-- Table `pastores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pastores` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `pastores` (
  `id_pastores` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `telemovel` VARCHAR(15) NOT NULL,
  PRIMARY KEY (`id_pastores`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `rebanhos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `rebanhos` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `rebanhos` (
  `id_rebanhos` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `data_criacao` DATETIME NOT NULL,
  PRIMARY KEY (`id_rebanhos`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `alcateias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `alcateias` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `alcateias` (
  `id_alcateias` INT NOT NULL AUTO_INCREMENT,
  `designacao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_alcateias`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `locais`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `locais` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `locais` (
  `id_locais` INT NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_locais`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `ataques`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ataques` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `ataques` (
  `id_ataques` INT NOT NULL,
  `ref_alcateias` INT NOT NULL,
  `ref_rebanhos` INT NOT NULL,
  `ref_locais` INT NOT NULL,
  `data` DATETIME NOT NULL,
  PRIMARY KEY (`id_ataques`),
  INDEX `fk_ataque_alcateia1_idx` (`ref_alcateias` ASC),
  INDEX `fk_ataque_local1_idx` (`ref_locais` ASC),
  INDEX `fk_ataque_rebanho1_idx` (`ref_rebanhos` ASC),
  CONSTRAINT `fk_ataque_alcateia1`
    FOREIGN KEY (`ref_alcateias`)
    REFERENCES `alcateias` (`id_alcateias`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ataque_local1`
    FOREIGN KEY (`ref_locais`)
    REFERENCES `locais` (`id_locais`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ataque_rebanho1`
    FOREIGN KEY (`ref_rebanhos`)
    REFERENCES `rebanhos` (`id_rebanhos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `ovelhas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ovelhas` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `ovelhas` (
  `id_ovelhas` INT NOT NULL AUTO_INCREMENT,
  `marca_auricular` VARCHAR(45) NOT NULL,
  `data_nascimento` DATETIME NOT NULL,
  `ref_rebanhos` INT NOT NULL,
  `ref_ataques` INT NULL,
  PRIMARY KEY (`id_ovelhas`),
  INDEX `fk_ovelha_rebanho1_idx` (`ref_rebanhos` ASC),
  INDEX `fk_ovelhas_ataques1_idx` (`ref_ataques` ASC),
  CONSTRAINT `fk_ovelha_rebanho1`
    FOREIGN KEY (`ref_rebanhos`)
    REFERENCES `rebanhos` (`id_rebanhos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ovelhas_ataques1`
    FOREIGN KEY (`ref_ataques`)
    REFERENCES `ataques` (`id_ataques`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `pastores_rebanhos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pastores_rebanhos` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `pastores_rebanhos` (
  `ref_pastores` INT NOT NULL,
  `ref_rebanhos` INT NOT NULL,
  `percentagem` FLOAT NOT NULL,
  PRIMARY KEY (`ref_pastores`, `ref_rebanhos`),
  INDEX `fk_pastor_rebanho_pastor1_idx` (`ref_pastores` ASC),
  INDEX `fk_pastor_rebanho_rebanho1_idx` (`ref_rebanhos` ASC),
  CONSTRAINT `fk_pastor_rebanho_pastor1`
    FOREIGN KEY (`ref_pastores`)
    REFERENCES `pastores` (`id_pastores`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pastor_rebanho_rebanho1`
    FOREIGN KEY (`ref_rebanhos`)
    REFERENCES `rebanhos` (`id_rebanhos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `tosquias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tosquias` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `tosquias` (
  `id_tosquias` INT NOT NULL AUTO_INCREMENT,
  `ref_ovelhas` INT NOT NULL,
  `data` DATETIME NOT NULL,
  `quantidade` DECIMAL(4,2) NOT NULL,
  PRIMARY KEY (`id_tosquias`),
  INDEX `fk_tusquia_ovelha1_idx` (`ref_ovelhas` ASC),
  CONSTRAINT `fk_tusquia_ovelha1`
    FOREIGN KEY (`ref_ovelhas`)
    REFERENCES `ovelhas` (`id_ovelhas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `lobos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lobos` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `lobos` (
  `id_lobos` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `ref_alcateias` INT NOT NULL,
  PRIMARY KEY (`id_lobos`),
  INDEX `fk_lobo_alcateia1_idx` (`ref_alcateias` ASC),
  CONSTRAINT `fk_lobo_alcateia1`
    FOREIGN KEY (`ref_alcateias`)
    REFERENCES `alcateias` (`id_alcateias`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `pastagens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pastagens` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `pastagens` (
  `id_pastagens` INT NOT NULL,
  `ref_rebanhos` INT NOT NULL,
  `ref_locais` INT NOT NULL,
  `data_inicio` DATE NOT NULL,
  `data_fim` DATE NULL,
  PRIMARY KEY (`id_pastagens`, `ref_rebanhos`, `ref_locais`),
  INDEX `fk_pastar_rebanho1_idx` (`ref_rebanhos` ASC),
  INDEX `fk_pastar_local1_idx` (`ref_locais` ASC),
  CONSTRAINT `fk_pastar_rebanho1`
    FOREIGN KEY (`ref_rebanhos`)
    REFERENCES `rebanhos` (`id_rebanhos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pastar_local1`
    FOREIGN KEY (`ref_locais`)
    REFERENCES `locais` (`id_locais`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `parentescos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `parentescos` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `parentescos` (
  `ref_ovelhas1` INT NOT NULL,
  `ref_ovelhas2` INT NOT NULL,
  `parentesco` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`ref_ovelhas1`, `ref_ovelhas2`),
  INDEX `fk_ovelhas_has_ovelhas_ovelhas2_idx` (`ref_ovelhas2` ASC),
  INDEX `fk_ovelhas_has_ovelhas_ovelhas1_idx` (`ref_ovelhas1` ASC),
  CONSTRAINT `fk_ovelhas_has_ovelhas_ovelhas1`
    FOREIGN KEY (`ref_ovelhas1`)
    REFERENCES `ovelhas` (`id_ovelhas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ovelhas_has_ovelhas_ovelhas2`
    FOREIGN KEY (`ref_ovelhas2`)
    REFERENCES `ovelhas` (`id_ovelhas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `pastores`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `pastores` (`id_pastores`, `nome`, `telemovel`) VALUES (1, 'Joaquim Santos', '936777888');
INSERT INTO `pastores` (`id_pastores`, `nome`, `telemovel`) VALUES (2, 'Manuel Figueira', '912345678');

COMMIT;


-- -----------------------------------------------------
-- Data for table `rebanhos`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `rebanhos` (`id_rebanhos`, `nome`, `data_criacao`) VALUES (1, 'Rebanho 1', '2005-02-25');
INSERT INTO `rebanhos` (`id_rebanhos`, `nome`, `data_criacao`) VALUES (2, 'Rebanho 2', '2006-04-07');
INSERT INTO `rebanhos` (`id_rebanhos`, `nome`, `data_criacao`) VALUES (3, 'Rebanho 3', '2007-01-01');
INSERT INTO `rebanhos` (`id_rebanhos`, `nome`, `data_criacao`) VALUES (4, 'Rebanho 4', '2008-01-11');

COMMIT;


-- -----------------------------------------------------
-- Data for table `alcateias`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `alcateias` (`id_alcateias`, `designacao`) VALUES (1, 'Alcateia 1');
INSERT INTO `alcateias` (`id_alcateias`, `designacao`) VALUES (2, 'Alcateia 2');
INSERT INTO `alcateias` (`id_alcateias`, `designacao`) VALUES (3, 'Alcateia 3');
INSERT INTO `alcateias` (`id_alcateias`, `designacao`) VALUES (4, 'Alcateia 4');

COMMIT;


-- -----------------------------------------------------
-- Data for table `locais`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `locais` (`id_locais`, `nome`) VALUES (1, 'Aqui ao lado');
INSERT INTO `locais` (`id_locais`, `nome`) VALUES (2, 'Lá longe');
INSERT INTO `locais` (`id_locais`, `nome`) VALUES (3, 'Mais lá em cima');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ataques`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `ataques` (`id_ataques`, `ref_alcateias`, `ref_rebanhos`, `ref_locais`, `data`) VALUES (1, 1, 1, 1, '2008-06-23');
INSERT INTO `ataques` (`id_ataques`, `ref_alcateias`, `ref_rebanhos`, `ref_locais`, `data`) VALUES (2, 2, 1, 1, '2008-06-25');
INSERT INTO `ataques` (`id_ataques`, `ref_alcateias`, `ref_rebanhos`, `ref_locais`, `data`) VALUES (3, 3, 4, 3, '2008-10-10');

COMMIT;


-- -----------------------------------------------------
-- Data for table `ovelhas`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `ovelhas` (`id_ovelhas`, `marca_auricular`, `data_nascimento`, `ref_rebanhos`, `ref_ataques`) VALUES (1, 'Ovelha 1', '2005-05-12', 1, 3);
INSERT INTO `ovelhas` (`id_ovelhas`, `marca_auricular`, `data_nascimento`, `ref_rebanhos`, `ref_ataques`) VALUES (2, 'Ovelha 2', '2005-05-12', 1, 2);
INSERT INTO `ovelhas` (`id_ovelhas`, `marca_auricular`, `data_nascimento`, `ref_rebanhos`, `ref_ataques`) VALUES (3, 'Ovelha 3', '2005-08-25', 1, 1);
INSERT INTO `ovelhas` (`id_ovelhas`, `marca_auricular`, `data_nascimento`, `ref_rebanhos`, `ref_ataques`) VALUES (4, 'Ovelha 4', '2005-08-25', 2, NULL);
INSERT INTO `ovelhas` (`id_ovelhas`, `marca_auricular`, `data_nascimento`, `ref_rebanhos`, `ref_ataques`) VALUES (5, 'Ovelha 5', '2006-07-29', 2, NULL);
INSERT INTO `ovelhas` (`id_ovelhas`, `marca_auricular`, `data_nascimento`, `ref_rebanhos`, `ref_ataques`) VALUES (6, 'Ovelha 6', '2006-07-29', 3, NULL);
INSERT INTO `ovelhas` (`id_ovelhas`, `marca_auricular`, `data_nascimento`, `ref_rebanhos`, `ref_ataques`) VALUES (7, 'Ovelha 7', '2006-07-29', 4, NULL);
INSERT INTO `ovelhas` (`id_ovelhas`, `marca_auricular`, `data_nascimento`, `ref_rebanhos`, `ref_ataques`) VALUES (8, 'Ovelha 8', '2006-07-29', 4, 1);
INSERT INTO `ovelhas` (`id_ovelhas`, `marca_auricular`, `data_nascimento`, `ref_rebanhos`, `ref_ataques`) VALUES (9, 'Ovelha 9', '2007-11-21', 3, NULL);
INSERT INTO `ovelhas` (`id_ovelhas`, `marca_auricular`, `data_nascimento`, `ref_rebanhos`, `ref_ataques`) VALUES (10, 'Ovelha 10', '2008-10-09', 4, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `pastores_rebanhos`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `pastores_rebanhos` (`ref_pastores`, `ref_rebanhos`, `percentagem`) VALUES (1, 1, 100);
INSERT INTO `pastores_rebanhos` (`ref_pastores`, `ref_rebanhos`, `percentagem`) VALUES (1, 2, 70);
INSERT INTO `pastores_rebanhos` (`ref_pastores`, `ref_rebanhos`, `percentagem`) VALUES (2, 2, 30);
INSERT INTO `pastores_rebanhos` (`ref_pastores`, `ref_rebanhos`, `percentagem`) VALUES (2, 3, 100);
INSERT INTO `pastores_rebanhos` (`ref_pastores`, `ref_rebanhos`, `percentagem`) VALUES (2, 4, 50);
INSERT INTO `pastores_rebanhos` (`ref_pastores`, `ref_rebanhos`, `percentagem`) VALUES (1, 4, 50);

COMMIT;


-- -----------------------------------------------------
-- Data for table `tosquias`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `tosquias` (`id_tosquias`, `ref_ovelhas`, `data`, `quantidade`) VALUES (1, 1, '2007-09-28', 1);
INSERT INTO `tosquias` (`id_tosquias`, `ref_ovelhas`, `data`, `quantidade`) VALUES (2, 2, '2007-09-28', 1.5);
INSERT INTO `tosquias` (`id_tosquias`, `ref_ovelhas`, `data`, `quantidade`) VALUES (3, 2, '2008-10-21', 1.2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `lobos`
-- -----------------------------------------------------
START TRANSACTION;

INSERT INTO `lobos` (`id_lobos`, `nome`, `ref_alcateias`) VALUES (1, 'Lobo 1', 1);
INSERT INTO `lobos` (`id_lobos`, `nome`, `ref_alcateias`) VALUES (2, 'Lobo 2', 1);
INSERT INTO `lobos` (`id_lobos`, `nome`, `ref_alcateias`) VALUES (3, 'Lobo 3', 1);
INSERT INTO `lobos` (`id_lobos`, `nome`, `ref_alcateias`) VALUES (4, 'Lobo 4', 2);
INSERT INTO `lobos` (`id_lobos`, `nome`, `ref_alcateias`) VALUES (5, 'Lobo 5', 3);
INSERT INTO `lobos` (`id_lobos`, `nome`, `ref_alcateias`) VALUES (6, 'Lobo 6', 2);

COMMIT;

