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


alter table tipificacion add tipo int not null default 1;
alter table tipificacion_recibo add status int(1) not null default 1;
alter table tipificacion change nombre_tipificacion nombre_tipificacion text;



use enidserv_web;
select * from tipificacion;

INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('14', 'CLIENTE NO CONTESTÓ PREVIO A LA ENTREGA', '2', '');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('15', 'CLIENTE PIDE CAMBIO EN FECHA DE ENTREGA', '2', '');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('16', 'LE PARECE CARO', '2', '');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('17', 'PENSÓ QUE EL PRODUCTO TENÍA MEJORES CARACTERÍSTICAS', '2', '');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('18', 'DEVOLUCIÓN POR GATANTÍA', '4', '');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('19', 'NO REALIZÓ EL PAGO Y SE REALIZARON LAS ACCIONES DE VENTA Y RECUPERACIÓN', '4', '');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('20', 'NO TENEMOS STOCK', '4', '');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('21', 'NO TENEMOS STOCK',  '4' ,'');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('22', 'NO TENEMOS STOCK', '5', '');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('23', 'DEVOLUCIÓN POR GARANTÍA', '5', '');
INSERT INTO `enidserv_web`.`tipificacion` (`id_tipificacion`, `nombre_tipificacion`, `tipo`, `icono`) VALUES ('24', 'NO SE PRESENTA AL NEGOCIO', '6', '');
