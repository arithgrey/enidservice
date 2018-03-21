<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){    
/**/
function create_select_estatus($name ,  $class , $id){

    $estados = array("TODOS","Usuario Activo","Inactivo","Baja");
    $select = "<select name = '".$name."' class='".$class ."' id='".$id."'> ";        
    for ($a=0; $a <count($estados); $a++) { 
            
        $select .= "<option value='".$estados[$a]."'>". $estados[$a] ."</option>";    
     
    }
    $select .= "<select> ";    
    return $select;

    

}
/**/
function create_select_turnos($name ,  $class , $id ){

    $turnos = array("TODOS" , "Matutino", "Vespertino", "Nocturno", "Mixto" );
    $select = "<select name = '".$name."' class='".$class ."' id='".$id."'> ";        
    for ($a=0; $a <count($turnos); $a++) { 
            
        $select .= "<option value='".$turnos[$a]."'>". $turnos[$a] ."</option>";    
     
    }
    $select .= "<select> ";    
    return $select;


}
/**/
function validate_social($url , $class , $class_icon ,  $flag  = 0  ){

    $red_social =  ""; 
    $class_extra =  "";

    if ( trim(strlen($url) ) > 7){
        $class_extra =  " color_social ";        
    }
    $url_text =  "<i class='". $class_icon."  $class_extra'>
                  </i>
                ";
    if ($flag == 1 ){
        $url_text =  "www";
    }
    return "
            <li class='". $class  ." '>
                <a>
                ".$url_text."                
                </a>
            </li>
            "; 
    

}
/**/
function resumen_usuarios_cuenta($data){   

    $table ='<table class="table table-bordered">                                          
                      <tr class="text-center header-table-info" >';
                        $table.= get_td("Miembros", "" );
                        $table.= get_td("Activos en el sistema", "" );
                        $table.= get_td("Bajas", "" );
                        $table.= get_td("Administradores de la cuenta", "" );
                        $table.= get_td("Estrategas dígitales", "" );                        
    $table.='</tr>';                                            
                    

    foreach ($data as $row) {

        $porcentaje_usuarios   = 0; 
        $porcentaje_activos = 0;
        $porcentaje_baja =0;
        $porcentaje_administradores  =0;
        $porcentaje_estrategas =  0;

        

        $porcentaje_usuarios =  get_promedio_users($row["usuarios"] , $row["usuarios"]  ); 
        $porcentaje_activos =  get_promedio_users(  $row["usuarios"] , $row["usuarios_activos"] );
        $porcentaje_baja =  get_promedio_users( $row["usuarios"], $row["usuarios_baja"]  );
        $porcentaje_administradores =  get_promedio_users($row["usuarios"],  $row["administradores_cuenta"]);
        $porcentaje_estrategas =  get_promedio_users( $row["usuarios"]  , $row["estrategas_digitales"]  );    

        


        $table.="<tr class='text-center' >";   
                    $table.= get_td($row["usuarios"], "");
                    $table.= get_td($row["usuarios_activos"] , "");
                    $table.= get_td($row["usuarios_baja"], "");
                    $table.= get_td($row["administradores_cuenta"], "");
                    $table.= get_td($row["estrategas_digitales"], "");
                 $table .="</tr>

                 <tr class='text-center'>";
                    $table.=get_td( $porcentaje_usuarios . "%"  , "");
                    $table.=get_td( $porcentaje_activos  . "%", "");
                    $table.=get_td( $porcentaje_baja   . "%" , "");
                    $table.=get_td( $porcentaje_administradores  . "%" , "");
                    $table.=get_td( $porcentaje_estrategas  . "%" , "");
                 $table .="</tr>
                 ";
    }

    $table.="</table><br>";
    return $table;

}    



function get_promedio_users($usuarios , $val){

    $result =0;

    if ($val >0 ){            
        
        $result = ($val / $usuarios) *  (100);
        $result =   number_format($result , 2, '.', ' ');
    }
    return $result;

}

/**/
function list_filtro_integrantes($integrantes){

	$list_filter ="<datalist id='integrantes-list' >";
	foreach ($integrantes as $row) {
           
        $list_filter .="<option value='". $row["nombre"] ."'>".  $row["nombre"] ." - " . $row["email"]  ."</option>";            
    }

    $list_filter .="</datalist>";
    return $list_filter;
}



/**/
function lista_usuarios_cuenta($integrantes ){

    $height ="style='overflow-x: scroll;' "; 
    if (count($integrantes) > 15 ) {
        $height ="style='overflow-x: scroll;  height: 400px;' " ; 
    }

    $list =  ""; 
    $list .=  "<div  $height>"; 
    $list .='<table  class="table_enid" style="font-size:.75em; text-align:center; padding:10px; width:100%;" border="1"  cellspacing="1" >
                <tr style="background: rgb(90, 141, 161); color:white; padding:100px;">';                                                                                                           
                    $list .= get_td("Configurar" );  
                    $list .= get_td("Estado" );                                                                                                        
                    $list .= get_td("Miembro" );
                    $list .= get_td("Usuario" );
                    $list .= get_td("Email alterno"  );
                    $list .= get_td( "Edad" ); 
                    $list .= get_td("Registrado"  );
                    $list .= get_td("Perfil" );
                    $list .= get_td("Estado" );
                    $list .= get_td("Tel" );
                    $list .= get_td("Tel. alterno"  );
                    $list .= get_td("#Empleado" );
                    $list .= get_td("Turno" );
                    $list .= get_td("Horario"  );
                    $list .= get_td("Grupo" );
                    $list .= get_td("Cargo" );
                    $list .= get_td("RFC" );                    
                    $list .= get_td("Última modificación" );                                        
                    $list .= get_td("Facebook" );                                        
                    $list .= get_td("Twitter" );                                        
                    $list .= get_td("Página web" );                                        
        $list .='</tr>';


            $now = 1;
    $b =0;
    foreach ($integrantes as $row) {
        
        $id_user = $row["idusuario"];
            
            $list .="<tr style='font-size: .9em;' >";                              
            $list .=  get_td("<i class='editar_permisos_miembro fa fa-cog' id='". $row["idusuario"] . "'></i>" );                           
            $list .= get_td("<a class='config_estatus_user' id='". $row["idusuario"]."'>". $row["status"]  ."</a>" );               
            $img  = create_icon_img($row , "img_user", $row["idusuario"], "a"  );                                
            
            $miembro = $row["nombre"] .  $row["apellido_paterno"]  . $row["apellido_materno"];
            $list .= get_td($img  . "<br>" . $miembro );
            $list .= get_td($row["email"]  );
            $list .= get_td($row["email_alterno"] );
            $list .= get_td($row["edad"]); 
            $list .= get_td($row["fecha_registro"] );
            $list .= get_td( $row["nombreperfil"] , "" );
            
            $list .= get_td( $row["tel_contacto"] );
            $list .= get_td( $row["tel_contacto_alterno"] );
            $list .= get_td( $row["numero_empleado"] );
            $list .= get_td($row["turno"]  );
            $inicio_fin_labor =  $row["inicio_labor"] . " " . $row["fin_labor"];
            $list .= get_td( $inicio_fin_labor);      
            $list .=  get_td( $row["grupo"]);
            $list .=  get_td($row["cargo"] );
            $list .= get_td($row["rfc"]);        
            $list .= get_td($row["ultima_modificacion"]);        

            $list .= get_td($row["url_fb"]);        
            $list .= get_td($row["url_tw"]);        
            $list .= get_td($row["url_www"]);                

        $list .="</tr> 
                    ";      
        $now++;
        $b ++;
    }

    $list .=  "</div>"; 
    $list .='</table>';    
    
    return $list;
}
/*Terminal la función*/
}/*Termina el helper*/