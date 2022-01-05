<?php
function es_administrador_o_vendedor($data)
{

    if (hay_restricciones($data)) {

        $response = in_array($data['id_perfil'], $data['restricciones']['es_administrador_o_vendedor']);

    } else {

        $id_perfil = prm_def($data, 'id_perfil');
        $perfiles = [3, 4, 6, 10];
        $response = in_array($id_perfil, $perfiles);
    }
    return $response;


}

function es_vendedor($data)
{

    if (hay_restricciones($data)) {

        $response = in_array($data['id_perfil'], $data['restricciones']['es_vendedor']);

    } else {
        $response = (prm_def($data, 'id_perfil') == 6);

    }
    return $response;

}

function hay_restricciones($data)
{

    return array_key_exists('restricciones', $data);
}

function es_cliente($data)
{

    $response = false;
    $key = 'id_perfil';
    if (array_key_exists('restricciones', $data)) {

        $response = in_array($data[$key], $data['restricciones']['es_cliente']);

    } else if (array_key_exists('perfiles', $data) && es_data($data['perfiles'])) {


        $response = (pr($data['perfiles'], $key) == 20);

    } else if (pr($data, "id_departamento") == 9) {

        $response = true;

    } else {
        $response = (prm_def($data, $key) == 20);

    }
    return $response;

}

function puede_repartir($data)
{

    return in_array($data['id_perfil'], $data['restricciones']['puede_repartir']);

}

function es_repartidor($data)
{

    $id_perfil = prm_def($data, 'id_perfil');
    if ($id_perfil > 0) {

        $response = ($id_perfil == 21);

    } else {
        $response = in_array($data['id_perfil'], $data['restricciones']['es_repartidor']);
    }

    return $response;

}

function es_administrador($data)
{

    return in_array($data['id_perfil'], $data['restricciones']['es_administrador']);

}

function es_premium($data, $usuario)
{

    $es_vendedor = es_vendedor($data);
    $es_administrador = es_administrador($data);
    $administrador_vendedor = ($es_vendedor || $es_administrador);
    $idtipo_comisionista = pr($usuario, "idtipo_comisionista");
    return ($administrador_vendedor && $idtipo_comisionista > 1);

}

function texto_status_orden($data, $id_status, $tipo = 0)
{

    $tipo_texto = ["text_cliente", "text_vendedor", "nombre"];
    $data_status_enid = $data["data_status_enid"];
    return search_bi_array(
        $data_status_enid, 'id_estatus_enid_service', $id_status, $tipo_texto[$tipo]);


}

function format_tipo_comisionista($objet_session, $id_tipo_comisionista)
{

    $tipo = "";
    if (is_array($objet_session)) {

        $tipo_comisionista = $objet_session["tipo_comisionista"];
        $cantidad = intval($id_tipo_comisionista) - 1;
        $tipo_tipo = $tipo_comisionista[$cantidad]["nombre"];
        $estrellas = $tipo_comisionista[$cantidad]["estrella"];
        $text_estrellas = crea_estrellas($estrellas);
        $tipo = _text_("Nivel", $tipo_tipo, $text_estrellas);

    }
    return $tipo;

}
