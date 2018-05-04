alter table usuario add ultima_publicacion timestamp not null default current_timestamp;
alter table usuario add informes_telefono int not null default 0;
insert into funcionalidad(funcionalidad) values("Entregas");



insert into privacidad(privacidad , id_funcionalidad) values("¿CLIENTES TAMBIÉN PUEDEN RECOGER SUS COMPRAS EN TU NEGOCIO?" , 3);
delete from funcionalidad where id_funcionalidad =4;

alter table usuario drop entregas_en_casa;
alter table  usuario add lada_negocio int(3);



alter table pagina_web_bot add id_servicio int not null default 0;
alter table pagina_web add id_servicio int not null default 0;
