CREATE TABLE IF NOT EXISTS `enidserv_web`.`recibo_comentario` (
  `id_recibo_comentario` INT NOT NULL AUTO_INCREMENT,
  `comentario` TEXT NULL,
  `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `id_recibo` INT(11) NOT NULL,
  PRIMARY KEY (`id_recibo_comentario`),
  INDEX `fk_recibo_comentario_proyecto_persona_forma_pago1_idx` (`id_recibo` ASC),
  CONSTRAINT `fk_recibo_comentario_proyecto_persona_forma_pago1`
    FOREIGN KEY (`id_recibo`)
    REFERENCES `enidserv_web`.`proyecto_persona_forma_pago` (`id_proyecto_persona_forma_pago`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
