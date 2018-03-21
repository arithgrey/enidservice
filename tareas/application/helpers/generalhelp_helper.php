<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function get_dominio($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
}
/**/
function get_select_descargas_email(){

  $num_email =["250" , "500"];
  $select ='<select id="selectbasic" name="limit" class="form-control input-sm">';
  for ($b=0; $b < count($num_email); $b++) {         
    $select.= "<option value='".$num_email[$b]."'>".$num_email[$b]."</option>";
  }
  $select .='</select>';
  return $select;
}

/**/
function get_tels($id_usuario){    
    
    $l ='
                          <ul>
                            <li>
                                  <a target="_blank" href="tel:5552967027" class=" " style="font-size:.8em;color:black;">
                                      <i class="icon-mobile contact">
                                      </i>⁠⁠⁠(55)5296-7027
                                  </a>
                            </li>   
                            
                            <li>
                                <a target="_blank" href="tel:5532693811" class=" " style="font-size:.8em;color:black;">
                                    <i class="icon-mobile contact">
                                    </i>
                                    (55) 3269-3811
                                </a>
                            </li>
                              
                          </ul>
      ';
    if ($id_usuario ==  158 ){

          
    $l ='
                          <ul>                               
                            <li>
                                <a target="_blank" href="tel:+015532693811" class=" " style="font-size:1.2em;color:black;">
                                    <i class="icon-mobile contact">
                                    </i>
                                    (55) 3269-3811
                                </a>
                            </li>
                            <li>
                                  <a target="_blank" href="tel:5552967027" class=" " style="font-size:.8em;color:black;">
                                      <i class="icon-mobile contact">
                                      </i>⁠⁠⁠(55)5296-7027
                                  </a>
                            </li>   
                            <li>
                                  <a target="_blank" href="tel:+015545444823" class=" " style="font-size:1.2em;color:black;">
                                      <i class="icon-mobile contact">
                                      </i>(55) 4544-4823
                                  </a>
                              </li>

                            
                          </ul>
      ';
    }
    return $l;
}

/**/
function get_btn_nuevo_mensaje( $id_usuario , $servicio ){
    
    $btn ="<i class='btn fa fa-plus btn_nuevo_mensaje input-sm'   
            id='".$servicio."'
            title='Agregar mensaje'
            href='#tab_registro_msj' 
            data-toggle='tab'                     
            style='background:black!important;'>
          </i>";
    
  return $btn;
}
/**/
function get_btn_comando($id_usuario){

  $btn ="";
  if ($id_usuario ==  1 ){    
    
    $btn ="<i class='btn fa fa-plus' data-toggle='modal' data-target='#registra_info_comando'>
          </i>";
  }
  return $btn;
}
/**/
function get_parte_facebook($id_usuario){    
      return "?q=1&q2=$id_usuario";
}
function get_parte_mercado_libre($id_usuario){    
      return "?q=2&q2=$id_usuario";
}
function get_parte_linkeding($id_usuario){    
      return "?q=3&q2=$id_usuario";
}
function get_parte_twitter($id_usuario){    
      return "?q=4&q2=$id_usuario";
}
function get_parte_gmail($id_usuario){    
      return "?q=5&q2=$id_usuario";
}

function get_parte_blog($id_usuario){    
      return "?q=6&q2=$id_usuario";
}

/**/
function template_documentacion($titulo,  $descripcion , $url_img  ){    
      $block =  "
                  <span>
                  <b>"; 
      $block .= $titulo;
      
      $block .= "</b>
                </span>
                <br>
                <span>
                ". $descripcion;

      $block .= "</span>
                  <img src='".$url_img."' class='desc-img'>
                ";                          
      $block .= "<br>
                <br>";
      return $block;


  }
/**/
if(!function_exists('invierte_date_time')){
  
  function construye_menu_enid_service($titulos , $extras ){
      $menu =  ""; 
      for ($a=0; $a < count($titulos ); $a++){ 
        $menu .=  "<a ".$extras[$a]." >" . $titulos[$a]." | </a>" ; 
      }
      return $menu;
  }
  /**/
  /**/
  

  /*NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN */
  function navegador(){
    return $_SERVER['HTTP_USER_AGENT'];
  }
  /**/
  function ip_user(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
  }  
  /**/
  function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE){    
        $source = 'abcdefghijklmnopqrstuvwxyz';
        if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($n==1) $source .= '1234567890';
        if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
        if($length>0){
            $rstr = "";
            $source = str_split($source,1);
            for($i=1; $i<=$length; $i++){
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,count($source));
                $rstr .= $source[$num-1];
            }
        }
        return $rstr;
  }
  function create_url_preview($img){
    return base_url()."../img_tema/portafolio/".$img;
  }

  /**/
  function valida_template_perfil_home($perfil){

    switch ($perfil) {
      case 7:
          return "principal/center_page_general"; 
        break;
      case 4:
          return "principal/center_page_general_prospecto";   
        break;    
      case 3:
          return "principal/center_page_general_prospecto"; 
      break;  
      
      default:
        return ""; 
      break;
    }
  }                                                

  /*NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN */
  
  function get_random(){
    return  mt_rand();       
  }
  /**/
  function get_td($valor , $extra = '' )
  {
    return "<td ". $extra ." NOWRAP >". $valor ."</td>";
  }
  function get_th($valor , $extra = '' )
  {
    return "<th ". $extra ." NOWRAP >". $valor ."</th>";
  }
  
  /**/
  
  function n_row_12($extra =""){

    $row= "<div class='row'>
            <div class='col-lg-12 col-md-12 col-sm-12 ". $extra ." '>";
    return $row;
  }
  function end_row(){
    $row= "</div>
          </div>";
    return $row;
  }
  /**/
  function titulo_enid($titulo){

    $n_titulo =  n_row_12() 
                 ."<h1 class='titulo_enid_service'>
                    ". $titulo ."
                    </h1>".
                 end_row();

    return $n_titulo;             
  }
  /**/
  function now_enid(){
    return  date('Y-m-d');
  }
  
  

}/*Termina el helper*/