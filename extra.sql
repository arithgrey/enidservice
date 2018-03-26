

alter table response add status int(1) not null default 0;
alter table response add leido_cliente int(1) not null default 0;
alter table response add leido_vendedor int(1) not null default 0;

alter table response add id_usuario int;
alter table response add 
FOREIGN KEY (id_usuario) REFERENCES usuario(idusuario)

update precio set id_ciclo_facturacion = 5 where id_ciclo_facturacion =  7;
delete from ciclo_facturacion where id_ciclo_facturacion =  7;
insurgentes 1940 inaden 10 
Banamex estarbucks 
Pantalon  - eliza 

UPDATE servicio set nombre_servicio =  UPPER(nombre_servicio);
delete from llamada;
delete from propuesta;
drop table  propuesta;
delete from usuario_persona_correo;
drop table  usuario_persona_correo;
delete from persona;
