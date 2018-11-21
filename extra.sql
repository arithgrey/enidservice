CREATE TABLE IF NOT EXISTS `enidserv_web`.`tipificacion_recibo` (
  `id_tipificacion` INT(11) NOT NULL,
  `id_recibo` INT(11) NOT NULL,
  `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  INDEX `fk_tipificacion_has_proyecto_persona_forma_pago_proyecto_pe_idx` (`id_recibo` ASC),
  INDEX `fk_tipificacion_has_proyecto_persona_forma_pago_tipificacio_idx` (`id_tipificacion` ASC),
  CONSTRAINT `fk_tipificacion_has_proyecto_persona_forma_pago_tipificacion1`
    FOREIGN KEY (`id_tipificacion`)
    REFERENCES `enidserv_web`.`tipificacion` (`id_tipificacion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tipificacion_has_proyecto_persona_forma_pago_proyecto_pers1`
    FOREIGN KEY (`id_recibo`)
    REFERENCES `enidserv_web`.`proyecto_persona_forma_pago` (`id_proyecto_persona_forma_pago`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

USE `enidserv_web` ;

/**/
alter table tipificacion add tipo int not null default 1;
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `icono`, `tipo`) VALUES ('11', 'FALTA DE STOCK(NO TUVIMOS EL PRODUCTO)', '', '2');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('12', 'EL CLIENTE CANCELÓ LA ENTREGA', '2', '');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('13', 'EL CLIENTE NO SE PRESENTÓ A LA ENTREGA', '3', '');
alter table tipificacion_recibo add status int(1) not null default 1;
