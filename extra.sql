alter table empresa drop reservacion_tel;
alter table empresa drop reservacion_mail;
alter table empresa drop formatted_address;
alter table empresa drop place_id;
alter table empresa drop lng;
alter table empresa drop lat;
alter table empresa drop quienes_somos;
alter table empresa drop mision;
alter table empresa drop  vision;
alter table empresa drop  years;
alter table empresa drop  mas_info;
alter table empresa drop  slogan;
alter table empresa drop mensaje_comunidad;
alter table empresa drop num_contacto;
alter table empresa drop tweeter;
alter table empresa drop facebook;
alter table empresa drop gp;
alter table empresa drop www;
alter table empresa drop email_contacto;

alter table usuario drop url_fb;
alter table usuario drop url_tw;
alter table usuario drop url_www;


alter table usuario drop formatted_address; 
alter table usuario drop place_id; 
alter table usuario drop  lng;
alter table usuario drop  lat;

alter table usuario drop  password_prospecto;
alter table usuario drop  id_cuenta_fb;
alter table usuario drop  cuenta_fb;
alter table usuario drop  direccion;

alter table usuario add entregas_en_casa int not null default 0;
alter table servicio add entregas_en_casa int not null default 0;

            
update clasificacion set flag_servicio =1 where id_clasificacion = 29
update clasificacion set flag_servicio =1 ,  segundo_nivel =1
where id_clasificacion > 29 and  id_clasificacion <37


                                 

-- -----------------------------------------------------
-- Table `enidserv_web`.`solicitud_pago`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `enidserv_web`.`solicitud_pago` (
  `id_solicitud` INT NOT NULL AUTO_INCREMENT,
  `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` INT NOT NULL DEFAULT 0,
  `email_solicitado` VARCHAR(45) NULL,
  `monto_solicitado` FLOAT NOT NULL,
  PRIMARY KEY (`id_solicitud`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `enidserv_web`.`solicitud_pago_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `enidserv_web`.`solicitud_pago_usuario` (
  `id_solicitud` INT NOT NULL,
  `id_usuario` INT(11) NOT NULL,
  INDEX `fk_solicitud_pago_has_usuario_usuario1_idx` (`id_usuario` ASC),
  INDEX `fk_solicitud_pago_has_usuario_solicitud_pago1_idx` (`id_solicitud` ASC),
  CONSTRAINT `fk_solicitud_pago_has_usuario_solicitud_pago1`
    FOREIGN KEY (`id_solicitud`)
    REFERENCES `enidserv_web`.`solicitud_pago` (`id_solicitud`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitud_pago_has_usuario_usuario1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `enidserv_web`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

alter table solicitud_pago_usuario add status int(1) not  null default 0;
