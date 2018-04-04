/*SE REPARA AL DÍA XXXX*/
alter table banco add status int(1) not null default 1;
alter table cuenta_pago change numero_tarjeta numero_tarjeta varchar(18);
alter table cuenta_pago add tipo int(1) not null default 0;
alter table cuenta_pago add clabe int(18);

alter table cuenta_pago add tipo_tarjeta int not null default 0;
alter table cuenta_pago change clabe clabe  bigint
alter table cuenta_pago change numero_tarjeta numero_tarjeta  bigint;
