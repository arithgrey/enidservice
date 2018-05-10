alter table usuario add ultima_publicacion timestamp not null default current_timestamp;
alter table usuario add informes_telefono int not null default 0;
insert into funcionalidad(funcionalidad) values("Entregas");
insert into privacidad(privacidad , id_funcionalidad) values("¿CLIENTES TAMBIÉN PUEDEN RECOGER SUS COMPRAS EN TU NEGOCIO?" , 3);
delete from funcionalidad where id_funcionalidad =4;
alter table usuario drop entregas_en_casa;
alter table pagina_web_bot add id_servicio int not null default 0;
delete from faq;
alter table  proyecto_persona_forma_pago add fecha_cancelacion  timestamp not null default  current_timestamp;
alter table proyecto_persona_forma_pago add se_cancela int not null  default 0;
alter table servicio add entregas_en_casa int not null default 0;
alter table servicio add telefono_visible  int not null default 0;
alter table servicio add valoracion int not null default 0;
alter table proyecto_persona_forma_pago add cancela_cliente int not null default 0;
alter table direccion add  nombre_receptor varchar(75);
alter table proyecto_persona_forma_pago change resumen_pedido resumen_pedido text;




