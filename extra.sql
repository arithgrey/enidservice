/*SE REPARA AL DÍA XXXX*/
alter table banco add status int(1) not null default 1;


alter table cuenta_pago change numero_tarjeta numero_tarjeta varchar(18);

alter table cuenta_pago add tipo int(1) not null default 0;

alter table cuenta_pago add clabe int(18);

alter table cuenta_pago add tipo_tarjeta int not null default 0;
alter table cuenta_pago change clabe clabe  bigint
alter table cuenta_pago change numero_tarjeta numero_tarjeta  bigint;

alter table usuario add nombre_usuario  varchar(15);

alter table usuario add tel_lada int(3);







-- -----------------------------------------------------
-- Table `enidserv_web`.`funcionalidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `enidserv_web`.`funcionalidad` (
  `id_funcionalidad` INT NOT NULL AUTO_INCREMENT,
  `funcionalidad` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_funcionalidad`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `enidserv_web`.`privacidad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `enidserv_web`.`privacidad` (
  `id_privacidad` INT NOT NULL AUTO_INCREMENT,
  `privacidad` TEXT NOT NULL,
  `id_funcionalidad` INT NOT NULL,
  PRIMARY KEY (`id_privacidad`),
  INDEX `fk_privacidad_funcionalidad1_idx` (`id_funcionalidad` ASC),
  CONSTRAINT `fk_privacidad_funcionalidad1`
    FOREIGN KEY (`id_funcionalidad`)
    REFERENCES `enidserv_web`.`funcionalidad` (`id_funcionalidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `enidserv_web`.`privacidad_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `enidserv_web`.`privacidad_usuario` (
  `id_privacidad` INT NOT NULL,
  `id_usuario` INT(11) NOT NULL,
  INDEX `fk_privacidad_has_usuario_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_privacidad_has_usuario_privacidad1_idx` (`id_privacidad` ASC),
  CONSTRAINT `fk_privacidad_has_usuario_privacidad1`
    FOREIGN KEY (`id_privacidad`)
    REFERENCES `enidserv_web`.`privacidad` (`id_privacidad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_privacidad_has_usuario_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `enidserv_web`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



INSERT INTO funcionalidad(funcionalidad) values("Visibilidad");
INSERT INTO funcionalidad(funcionalidad) values("Seguridad");

INSERT INTO privacidad(privacidad , id_funcionalidad ) VALUES("Permite que otros te encuentren por tu dirección de correo electrónico "  ,1 );
INSERT INTO privacidad(privacidad , id_funcionalidad ) VALUES("Permite que tus clientes vean tu número de teléfono"  ,1 );
INSERT INTO privacidad(privacidad , id_funcionalidad ) VALUES("Permite que tus los vendedores vean tu número de teléfono "  ,1 );
INSERT INTO privacidad(privacidad , id_funcionalidad ) VALUES("Ocultar contenido que pueda herir la sensibilidad de algunas personas"  , 2);




 
SELECT * FROM funcionalidad;