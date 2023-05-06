ALTER TABLE `filmes` 
ADD COLUMN `capa` VARCHAR(50) NULL AFTER `sinopse`,
ADD UNIQUE INDEX `capa_UNIQUE` (`capa` ASC);

UPDATE `filmes` SET `capa` = 'filme_1.jpg' WHERE `filmes`.`id_filmes` = 1; 
UPDATE `filmes` SET `capa` = 'filme_2.jpg' WHERE `filmes`.`id_filmes` = 2; 
UPDATE `filmes` SET `capa` = 'filme_3.jpg' WHERE `filmes`.`id_filmes` = 3; 
UPDATE `filmes` SET `capa` = 'filme_4.jpg' WHERE `filmes`.`id_filmes` = 4; 
UPDATE `filmes` SET `capa` = 'filme_5.jpg' WHERE `filmes`.`id_filmes` = 5; 
UPDATE `filmes` SET `capa` = 'filme_6.jpg' WHERE `filmes`.`id_filmes` = 6; 
UPDATE `filmes` SET `capa` = 'filme_7.jpg' WHERE `filmes`.`id_filmes` = 7; 
UPDATE `filmes` SET `capa` = 'filme_8.jpg' WHERE `filmes`.`id_filmes` = 8; 
UPDATE `filmes` SET `capa` = 'filme_9.jpg' WHERE `filmes`.`id_filmes` = 9; 
UPDATE `filmes` SET `capa` = 'filme_10.jpg' WHERE `filmes`.`id_filmes` = 10; 