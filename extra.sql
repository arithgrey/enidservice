CREATE TABLE IF NOT EXISTS `enidserv_web`.`tipo_punto_encuentro` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tipo` VARCHAR(255) NULL,
  `status` INT(1) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `enidserv_web`.`linea_metro` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(55) NOT NULL,
  `numero` INT NOT NULL,
  `color` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `enidserv_web`.`punto_encuentro` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(250) NOT NULL,
  `status` INT(1) NOT NULL DEFAULT 0,
  `id_tipo_punto_encuentro` INT NOT NULL,
  `id_linea_metro` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_punto_encuentro_tipo_punto_encuentro1_idx` (`id_tipo_punto_encuentro` ASC),
  INDEX `fk_punto_encuentro_linea_metro1_idx` (`id_linea_metro` ASC),
  CONSTRAINT `fk_punto_encuentro_tipo_punto_encuentro1`
    FOREIGN KEY (`id_tipo_punto_encuentro`)
    REFERENCES `enidserv_web`.`tipo_punto_encuentro` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_punto_encuentro_linea_metro1`
    FOREIGN KEY (`id_linea_metro`)
    REFERENCES `enidserv_web`.`linea_metro` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `enidserv_web` ;



insert into tipo_punto_encuentro (tipo ) values("LÍNEA DEL METRO");
insert into tipo_punto_encuentro (tipo ) values("ESTACIÓN DEL  METRO BUS");
insert into tipo_punto_encuentro (tipo ) values("PLAZA O CENTRO COMERCIAL");


alter table linea_metro add icon text; 

insert into linea_metro(nombre ,numero, color , icon ) values("PANTITLAN OBSERVATORIO" , 1, "ROSA"  , "");
insert into linea_metro(nombre ,numero, color , icon ) values("CUATRO CAMINOS TASQUEÑA" , 2, "AZUL" , "../img_tema/linea_metro/cabeza_linea2.png");
insert into linea_metro(nombre ,numero, color , icon ) values("INDIOS VERDES UNIVERSIDAD" , 3, "VERDE" ,"../img_tema/linea_metro/cabeza_linea3.png");
insert into linea_metro(nombre ,numero, color , icon ) values("SANTA ANITA MARTÍN CARRERA" , 4, "AZUL AGUA", "../img_tema/linea_metro/cabeza_linea4.png" );
insert into linea_metro(nombre ,numero, color , icon ) values("POLITECNICO PANTITLAN" , 5, "AZUL AGUA" , "../img_tema/linea_metro/cabeza_linea5.png");
insert into linea_metro(nombre ,numero, color , icon ) values("EL ROSARIO MARTÍN CARRERA" , 6, "AZUL AGUA" , "../img_tema/linea_metro/cabeza_linea6.png");
insert into linea_metro(nombre ,numero, color , icon ) values("EL ROSARIO BARRANCA DEL MUERTO" , 7, "NARANJA" , "../img_tema/linea_metro/cabeza_linea7.png");
insert into linea_metro(nombre ,numero, color , icon ) values("GARIBALDI COSTITUCIÓN DEL 1917" , 8, "VERDE" , "../img_tema/linea_metro/cabeza_linea8.png");
insert into linea_metro(nombre ,numero, color , icon ) values("TACUBAYA PANTITLAN" , 9, "CAFE" , "../img_tema/linea_metro/cabeza_linea9.png");
insert into linea_metro(nombre ,numero, color , icon ) values("PANTITLAN LA PAZ LINEA A " , 10, "MORADA" , "../img_tema/linea_metro/cabeza_lineaA.png");
insert into linea_metro(nombre ,numero, color , icon ) values("CIUDA AZTECA BUENAVISTA LINEA B " , 11, "VERDE CON GRIS" , "../img_tema/linea_metro/cabeza_lineaB.png");
insert into linea_metro(nombre ,numero, color , icon ) values("TLAHUAC MIXCOAC" , 12, "DORADA" , "../img_tema/linea_metro/cabeza-linea12.png");


INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," OBSERVATORIO", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," TACUBAYA", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," JUANACATLAN", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," CHAPULTEPEC", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," SEVILLA", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," INSURGENTES", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," CUAUHTEMOC", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," BALDERAS", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," SALTO DEL AGUA", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," ISABEL LA CATOLICA", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," PINO SUAREZ", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," MERCED", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," CANDELARIA", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," SAN LAZARO", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," MOCTEZUMA", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," BALBUENA", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," BOULEVARD PUERTO AEREO", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," GOMEZ FARIAS", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," ZARAGOZA", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," PANTITLAN", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," GOMEZ FARIAS", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," ZARAGOZA", 1);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," PANTITLAN", 1);



INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CUATRO CAMINOS", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PANTEONES", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TACUBA", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CUITLAHUAC", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"POPOTLA", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"COLEGIO MILITAR", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"NORMAL", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"SAN COSME", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"REVOLUCIÓN", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"HIDALGO", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"BELLAS ARTES", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ALLENDE", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ZOCALO", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PINO SUAREZ", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"SAN ANTONIO ABAD", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CHABACANO", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"VIADUCTO", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"XOLA", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"VILLA DE CORTES", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"NATIVITAS", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PORTALES", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ERMITA", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"GENERAL ANAYA", 2);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TASQUEÑA", 2);



INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"INDIOS VERDES",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"DEPORTIVO 18 DE MARZO",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"POTRERO",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"LA RAZA",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TLATELOLCO",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"GUERRERO",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"HIDALGO",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"JUAREZ",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"BALDERAS",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"NIÑOS HEROES",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"HOSPITAL GENERAL",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CENTRO MEDICO",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ETIOPIA/ PLAZA DE LA TRANSPARENCIA",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"EUGENIA",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"DIVISION DEL NORTE",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ZAPATA",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"COYOACAN",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"VIVEROS/ DERECHOS HUMANOS",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"MIGUEL ANGEL DE QUEVEDO",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"COPILCO",3);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"UNIVERSIDAD",3);



INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"MARTÍN CARRERA",4);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TALISMAN",4);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"BONDOJITO",4);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CONSULADO",4);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CANAL DEL NORTE",4);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"MORELOS",4);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CANDELARIA",4);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"FRAY SERVANDO",4);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"JAMAICA",4);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"SANTA ANITA",4);




INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PANTITLAN",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"HANGARES",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TERMINAL AEREA",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"OCEANIA",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ARAGON",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"EDUARDO MOLINA",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"OSULADO",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"VALLE GOMEZ",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"MISTERIOS",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"LA RAZA",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"AUTOBUSES DEL NORTE",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"INSTITUTO DEL PETROLEO",5);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"POLITECNICO",5);



INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1, "EL ROSARIO", 6);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1, "TEZOZOMOC", 6);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1, "AZCAPOTZALCO", 6);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1, "FERRERIA/ ARENA CIUDAD DE MEXICO", 6);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1, "NORTE 45", 6);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1, "VALLEJO", 6);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1, "INSTITUTO DEL PETROLEO", 6);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1, "LINDAVISTA", 6);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1, "DEPORTIVO 18 DE MARZO", 6);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1, "LA VILLA/ BASILICA", 6);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1, "MARTIN CARRERA", 6);



INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"EL ROSARIO",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"AQUILES SERDÁN",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CAMARONES",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"REFINERIA",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TACUBA",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"SAN JOAQUIN",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"POLANCO",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"AUDITORIO",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CONSTITUYENTES",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," TACUBAYA",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," SAN PEDRO DE LOS PINOS",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," SAN ANTONIO",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," MIXCOAC",7);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1," BARRANCA DEL MUERTO",7);




INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"GARIBALDI/ LAGUNILLA", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"BELLAS ARTES", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"SAN JUAN DE LETRAN", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"SALTO DEL AGUA", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"DOCTORES", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"OBRERA", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CHABACANO", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"LA VIGA", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"SANTA ANITA", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"COYUYA", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"IZTACALCO", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"APATLACO", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ACULCO", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ESCUADRON 201", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ATLALILCO", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"IZTAPALAPA", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CERRO DE LA ESTRELLA", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"UAM-I", 8);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CONSTITUCION DE 1917", 8);





INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TACUBAYA",9);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PATRIOTISMO",9);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CHILPANCINGO",9);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CENTRO MEDICO",9);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"LAZARO CARDENAS",9);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CHABACANO",9);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"JAMAICA",9);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"MIXIUHCA",9);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"VELODROMO",9);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CIUDAD DEPORTIVA",9);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PUEBLA",9);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PANTITLAN",9);






INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PANTITLAN",10);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"AGRICOLA ORIENTAL",10);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CANAL DE SAN JUAN",10);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TEPALCATES",10);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"GUELATAO",10);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PEÑON VIEJO",10);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ACATITLA",10);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"SANTA MARTA",10);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"LOS REYES",10);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"LA PAZ",10);


INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CIUDAD AZTECA",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PLAZA ARAGON ",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"OLIMPICA",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ECATEPEC",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"MUZQUIZ",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"RIO DE LOS REMEDIOS",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"IMPULSORA",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"NEZAHUALCOYOTL",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"VILLA DE ARAGON",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"BOSQUE DE ARAGON",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"DEPORTIVO OCEANIA",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"OCEANIA",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ROMERO RUBIO",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"RICARDO FLORES MAGON",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"SAN LAZARO",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"MORELOS",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TEPITO",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"LAGUNILLA",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"GARIBALDI/ LAGUNILLA",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"GUERRERO",11);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"BUENAVISTA",11);




INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"MIXCOAC" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"INSURGENTES SUR" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"HOSPITAL 20 DE NOVIEMBRE" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ZAPATA" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PARQUE DE LOS VENADOS" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"EJE CENTRAL" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ERMITA" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"MEXICALTZINGO" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ATLALILCO" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CULHUACAN" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"SAN ANDRES TOMATLAN" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"LOMAS ESTRELLAS" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"CALLE 11" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"PERIFERICO ORIENTE" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TEZONCO" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"OLIVOS" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"NOPALERA" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"ZAPOTITLAN" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TLALTENCO" , 12);
INSERT INTO punto_encuentro(id_tipo_punto_encuentro , nombre , id_linea_metro) VALUES(1,"TLAHUAC" , 12);




alter table punto_encuentro add costo_envio float not null default 50;
ALTER TABLE  proyecto_persona_forma_pago ADD  fecha_contra_entrega TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP();

INSERT INTO  forma_pago(forma_pago ) values("Pago contra entrega");
CREATE TABLE IF NOT EXISTS `enidserv_web`.`proyecto_persona_forma_pago_punto_encuentro` (
  `id_proyecto_persona_forma_pago` INT(11) NOT NULL,
  `id_punto_encuentro` INT(11) NOT NULL,
  `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  INDEX `fk_proyecto_persona_forma_pago_has_punto_encuentro_punto_en_idx` (`id_punto_encuentro` ASC),
  INDEX `fk_proyecto_persona_forma_pago_has_punto_encuentro_proyecto_idx` (`id_proyecto_persona_forma_pago` ASC),
  CONSTRAINT `fk_proyecto_persona_forma_pago_has_punto_encuentro_proyecto_p1`
    FOREIGN KEY (`id_proyecto_persona_forma_pago`)
    REFERENCES `enidserv_web`.`proyecto_persona_forma_pago` (`id_proyecto_persona_forma_pago`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_proyecto_persona_forma_pago_has_punto_encuentro_punto_encu1`
    FOREIGN KEY (`id_punto_encuentro`)
    REFERENCES `enidserv_web`.`punto_encuentro` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

USE `enidserv_web` ;
show tables;




update tipo_punto_encuentro set status =1 limit 199;
alter table  tipo_punto_encuentro change status status int not null default 1;
update tipo_punto_encuentro set status =0 where id in (2,3);





CREATE TABLE IF NOT EXISTS `enidserv_web`.`intento_compra` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `id_recibo` INT(11) NOT NULL,
  `id_forma_pago` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_intento_compra_proyecto_persona_forma_pago1_idx` (`id_recibo` ASC),
  INDEX `fk_intento_compra_forma_pago1_idx` (`id_forma_pago` ASC),
  CONSTRAINT `fk_intento_compra_proyecto_persona_forma_pago1`
    FOREIGN KEY (`id_recibo`)
    REFERENCES `enidserv_web`.`proyecto_persona_forma_pago` (`id_proyecto_persona_forma_pago`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_intento_compra_forma_pago1`
    FOREIGN KEY (`id_forma_pago`)
    REFERENCES `enidserv_web`.`forma_pago` (`id_forma_pago`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;






-------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `enidserv_web`.`tipo_entrega` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fecha_entrega` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

USE enidserv_web;
INSERT INTO tipo_entrega(nombre) VALUES("PUNTO ENCUENTRO");
INSERT INTO tipo_entrega(nombre) VALUES("MENSAJERIA");
INSERT INTO tipo_entrega(nombre) VALUES("VISITA EN NEGOCIO");



CREATE TABLE IF NOT EXISTS `enidserv_web`.`intento_tipo_entrega` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `id_servicio` INT(11) NOT NULL,
  `id_tipo_entrega` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_intento_tipo_entrega_servicio1_idx` (`id_servicio` ASC),
  INDEX `fk_intento_tipo_entrega_tipo_entrega1_idx` (`id_tipo_entrega` ASC),
  CONSTRAINT `fk_intento_tipo_entrega_servicio1`
    FOREIGN KEY (`id_servicio`)
    REFERENCES `enidserv_web`.`servicio` (`id_servicio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_intento_tipo_entrega_tipo_entrega1`
    FOREIGN KEY (`id_tipo_entrega`)
    REFERENCES `enidserv_web`.`tipo_entrega` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
