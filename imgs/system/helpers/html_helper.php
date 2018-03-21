<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('end_row'))
{
  function end_row(){
    $row= "</div>
          </div>";
    return $row;
  }
}
/**/

if ( ! function_exists('n_row_12'))
{

function n_row_12($extra =""){

    $row= "<div class='row'>
            <div class='col-lg-12 col-md-12 col-sm-12 ". $extra ." '>";
    return $row;
  }


}


function construye_header_modal($id_modal  , $titulo_modal , $ml =0 ){

    $class = '';
    if ($ml == 1 ) {
      $class = ' modal-lg ';  
    }  
  $modal ='
    <div class="portfolio-modal modal fade" id="'.$id_modal.'" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                    <h2 class="titulo_modal_enid">
                    '.$titulo_modal.'
                    </h2>
                    ';
                    return $modal;


            
  }

  function construye_footer_modal(){
  
    $m ='     
      <br>
              <button type="button" class="btn btn-primary" data-dismiss="modal">
                <i class="fa fa-times">
                </i> 
                Cerrar
              </button>

             </div>
              </div>              
          </div>
      </div>
  </div> ';
  return $m;    
  }
  






if ( ! function_exists('btn_cancelar'))
{
  function btn_cancelar(){

    
       return "<button type='button' class='btn btn-default btn_cancelar' data-dismiss='modal'>
                Cancelar
              </button>"; 
    
  }
}


/**/
if ( ! function_exists('btn_confirma_delete_img'))
{
  function btn_confirma_delete_img($in_session , $class ,$id  ,    $extra = '' ){

    if ($in_session ==  1 ){
       return "<button  id='".$id."'  class='btn btn-default btn_confirma_eliminar ".$class."  ' ".$extra."  > 
                  Eliminar
                </button>"; 
    }
  }
}

/**/
if ( ! function_exists('btn_call_to_action'))
{
  function btn_call_to_action($in_session , $class , $id , $extra , $titulo ,  $url  ){

    if ($in_session ==  1 ){
       return "<a href='".$url."'>
                <button  id='".$id."'  class='btn btn-default call_to_action ".$class."  ' ".$extra."  > 
                  ".$titulo."
                </button>
              </a>"; 
    }
  }
}


/**/
if ( ! function_exists('btn_cargar_elementos'))
{
  function btn_cargar_elementos($in_session , $class , $id , $extra , $titulo ){

    if ($in_session ==  1 ){
       return "<button  id='".$id."'  class='btn btn-default ".$class."  ' ".$extra."  > 
                ".$titulo."
              </button>"; 
    }
  }
}

/**/
/**/
if ( ! function_exists('btn_registrar_cambios_enid'))
{
  function btn_registrar_cambios_enid($id , $class , $extra = '' )
  {
    return "<button type='submit' id='".$id ."' class='button-registrar  btn btn-default ".$class." ' $extra> 
                Registrar
            </button>"; 
  }
}

/**/

if ( ! function_exists('btn_conf'))
{
  function btn_conf($extra_class = '' ,  $extra= '')
  {
    return "<i class='fa fa-cog ".$extra_class." '  $extra ></i>"; 
  }
}



/**/
if ( ! function_exists('heading'))
{
	function heading($data = '', $h = '1', $attributes = '')
	{
		$attributes = ($attributes != '') ? ' '.$attributes : $attributes;
		return "<h".$h.$attributes.">".$data."</h".$h.">";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('ul'))
{
	function ul($list, $attributes = '')
	{
		return _list('ul', $list, $attributes);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('ol'))
{
	function ol($list, $attributes = '')
	{
		return _list('ol', $list, $attributes);
	}
}

  /**/
  function tema_header($tema = 0 ){

    switch ($tema) {
      case 0:
          return  'TemplateEnid/header_template';
        break;
        /*Black team*/
      case 1:
          return  "TemplateEnid/black/black_template";
        break;

      default:
        return  "TemplateEnid/header_template";
        break;
    }
  }
  /**/
  function tema_header_all($tema = 0 ){

    switch ($tema) {
      case 0:
          return  'TemplateEnid/header_template_all_user';
        break;
        /*Black team*/
      case 1:
          return  "TemplateEnid/black/black_template_all";
        break;

      default:
        return  'TemplateEnid/header_template_all_user';
        break;
    }
  }
  /**/
  function tema_footer($tema = 0 ){

    switch ($tema) {
      case 0:
          return  'TemplateEnid/footer_template';
        break;
        /*Black team*/
      case 1:
          return  "TemplateEnid/black/footer_black_template";
        break;

      default:
        return  "TemplateEnid/footer_template";
        break;
    }
  }

  



  /**/
  function template_text_img($id  ,  $class  , $modal , $black  = 0 ,  $title ='' ){

    $template =  " 
                <span title='".$title ."' id='".$id."' data-toggle='modal' data-target= '".$modal."' class='text-imagen-enid ".$class."'>
                    + Imagen
                </span> ";
    if ($black == 1  ) {
      $template =  " 
                <span title='".$title ."' id='".$id."' data-toggle='modal' data-target= '".$modal."' class='text-imagen-enid-b ".$class."'>
                    + Imagen
                </span> ";
    }
    
    return $template;
  }
  function valida_btn_show_down_contect($text, $min ){

      if (strlen(trim($text)) < $min) {
        return "";
      }else{
        return template_show_down_content();
      }
  }
  /**/
  function template_show_down_content(){
      $template =  "
                  <center>
                    <span class='row more-info-f more-info-f-down'>
                        <i class='fa fa-chevron-down' aria-hidden='true'>
                        </i>
                    </span>
                    <span class='row more-info-f more-info-f-up'>
                        <i class='fa fa-chevron-up' aria-hidden='true'>
                        </i>
                    </span>
                  </center>  
                ";
      return $template;          
  }
  /**/
  function template_btn_plantilla($id , $extra_class , $modal ,  $center_text =  'Usar plantilla'){
    $template =  "
                <button class='btn  btn-template ".$extra_class." ' id='".$id."' data-toggle='modal' data-target='".$modal."' >
                    <i class='fa fa-file-text-o'>
                    </i>
                    ". $center_text."
                </button> "; 
    return $template;            
  }
  /**/
  
  /**/
  function template_view_like_public($url){

    $template = n_row_12()
                ."<span>
                    <a class='ver-public-sm' href='".$url."' >
                      <i class='fa fa-arrow-circle-o-right'> 
                      </i>
                      Ver como el público 
                    </a>
                </span>"
                .end_row();
    return $template;
  }  
  /**/
/**/
function btn_asistencia(){
  $btn =  "<button class='btn_call_to_emp  btn_asistencia' type='button' data-toggle='modal' data-target='#asistencia_moal' >
            <span class='place_asistentes'>                                
            </span> Viviré la experiencia
          </button>";

  return $btn;
}
/**/
function btn_busqueda_eventos(){

  $url = base_url("index.php/eventos/busqueda");
  $btn =  '<a class="btn btn-default  btn-busqueda-enid pull-right" 
            style="background:#166781; color: white !important;" 
            title="Próximos eventos en Enid Service" 
            href="'.$url.'" class="btn btn-default">                        
            <i class="fa fa-search">
            </i>
            Eventos                    
          </a>  
    ';

  return $btn;
}  
/**/
function btn_inicio_session($no_publics){
    
    $url = base_url('index.php/startsession');
    $btn = '';
    if ($no_publics ==  0 ){
      $btn =  '
      <a href="'.$url.'" class="btn_inicio_session_enid pull-right" >
        <button class="btn btn-default login-btn">                    
          Iniciar/Registrar
        </button>
      </a>';  
    }
    
    return $btn;   
}
/**/
function btn_registra_evento($no_publics){

  $url = base_url('index.php/home/prospectos');
  $btn = '';
    if($no_publics ==  0 ){
          $btn = '
          <a href="'.$url.'" class="pull-right">
            <button class="btn btn-default registra-evento">                    
              + Registra tu evento
            </button>
          </a> ';
      }

  return $btn;
}
/**/
/**/
function create_select($data , $name , $class , $id , $text_option , $val ){

    $select ="<select name='". $name ."'  class='".$class ."'  id='". $id ."'> ";

      foreach ($data as $row) {      
        $select .=  "<option value='". $row[$val] ."'>". $row[$text_option]." </option>";
      }

    $select .="</select>";
    return $select;
}
/**/
function create_select_selected($data , $campo_val, $campo_text , $selected , $name ,  $class  ){

    $select ="<select class='".$class."' name='".$name."'>"; 
    foreach ($data as $row ){

        if ($row[$campo_val] ==  $selected  ) {
          $select .=  "<option value='". $row[$campo_val]  ."' selected > " . $row[$campo_text]."</option>";  
        }else{
          $select .=  "<option value='". $row[$campo_val]  ."'> " . $row[$campo_text]."</option>";
          
        }
        
    }
    $select .="</select>"; 
    return $select;
  }
  /**/
  /**/
  function create_select_estados_user($selected ,  $class ){    

      $estados = array( "Usuario Activo"  , "Inactivo"  , "Baja" );   
      $select ="<select class='".$class  ."' name='nuevo_estado' >";      

      for ($a=0; $a <count($estados); $a++) { 
          if ($estados[$a] ==  $selected ) {
            $select .=  "<option  value='". $estados[$a]."' selected > ". $estados[$a] ."</option>";
          }else{
            $select .=  "<option  value='". $estados[$a]."'> ". $estados[$a] ."</option>";
          }          
      }

      $select .="</select>";
      return $select; 
  }

  /*GRUPO*/
  function create_select_grupos($selected ,  $class ){    

      
      $data_grupos = array("Marketing" , "Audio y video" ,  "Iluminación" , "Calidad" , "Venta" , "Escenografía" , "Comunicación" , "Desarrollo");
      $select ="<select class='".$class  ."' name='user_grupo' >";      
      for ($a=0; $a <count($data_grupos); $a++) { 
          if ($data_grupos[$a] ==  $selected ) {
            $select .=  "<option  value='". $data_grupos[$a]."' selected > ". $data_grupos[$a] ."</option>";
          }else{
            $select .=  "<option  value='". $data_grupos[$a]."'> ". $data_grupos[$a] ."</option>";
          }          
      }

      $select .="</select>";
      return $select; 
  }
  /**/
  function create_select_cargos($selected ,  $class ){    
      
      $cargos = array( "Staff"  , "Director" ,  "Director comercial" , "Director de comunicación" , "Director de tecnología" , "Coordinador",  "Gerente" ,  "Subdirector" ,  "Supervisor" , "Jefe de operaciones" ,      "Otro");
      $select ="<select class='".$class  ."' name='nuser_cargo' >";      
      for ($a=0; $a <count($cargos); $a++) { 
          if ($cargos[$a] ==  $selected ) {
            $select .=  "<option  value='". $cargos[$a]."' selected > ". $cargos[$a] ."</option>";
          }else{
            $select .=  "<option  value='". $cargos[$a]."'> ". $cargos[$a] ."</option>";
          }          
      }

      $select .="</select>";
      return $select; 
  }
  /**/
  /**/
  function create_select_estados_incidencia($id , $name ){    
      
      $estados_incidencia = array("", "Pendiente" ,  "En proceso" , "Finalizado");
      
      $select ="<select id='".$id."' class='form-control input-sm' name='".$name."' >";      
      for ($a=0; $a <count($estados_incidencia); $a++) {           


            if ($a> 0 ) { 
              
              $select .=  "<option  value='".$a."'> ". $estados_incidencia[$a] ."</option>";        
            }
            
      }
      $select .="</select>";
      return $select; 
  }

  /**/
  function create_select_sexo($name_select , $selected , $id_select , $class_select  ){

      $sexo = array("Masculino" , "Femenino");

      $select ="<select name='". $name_select  ."'  id='".$id_select."' class='". $class_select."' > ";      
      for ($a=0; $a <count($sexo) ; $a++) { 

        if ($sexo[$a] ==  $selected ) {
            $select.= "<option value='".$sexo[$a]."' selected> ". $sexo[$a]."</option>";
        }else{
            $select.= "<option value='".$sexo[$a]."' > ". $sexo[$a]."</option>";
        }
          
      }
      $select .= "</select>";
      return $select; 
  }
  /**/
  function create_select_cantidad($name ){
      $select = "<select name='". $name ."' id='". $name   ."' class='form-control input-sm ". $name   ."'>";
        for ($i=1; $i < 1000; $i++) {           
              $select .= "<option value='". $i ."'>". $i ."</option> ";            
        } 
        
      $select .= "<select>";
      return $select;
  }
  /**/
  function create_select_num($name){
      $select = "<select name='". $name ."' id='". $name   ."' class='form-control ". $name   ."'>";

        for ($i=1; $i < 700; $i++) {           
            $select .= "<option value='". $i ."'>". $i ." artistas  </option> ";
        } 
        
      $select .= "<select>";
      return $select;
  }
  /*Select que general la edad*/
  function create_select_edad_form($name ,  $selected = 0 ){
      $select = "<select name='". $name ."' id='". $name   ."' class='form-control input-sm ". $name   ."'>";

        for ($i=15; $i < 70; $i++) {           

            if ($selected ==  $i ){
              $select .= "<option value='". $i ."' selected >". $i ." Años </option> ";  
            }else{
              $select .= "<option value='". $i ."'>". $i ." Años </option> ";
            }
            
        } 
        
      $select .= "<select>";
      return $select;
  }
  /**/


if ( ! function_exists('_list'))
{
	function _list($type = 'ul', $list, $attributes = '', $depth = 0)
	{
		// If an array wasn't submitted there's nothing to do...
		if ( ! is_array($list))
		{
			return $list;
		}

		// Set the indentation based on the depth
		$out = str_repeat(" ", $depth);

		// Were any attributes submitted?  If so generate a string
		if (is_array($attributes))
		{
			$atts = '';
			foreach ($attributes as $key => $val)
			{
				$atts .= ' ' . $key . '="' . $val . '"';
			}
			$attributes = $atts;
		}
		elseif (is_string($attributes) AND strlen($attributes) > 0)
		{
			$attributes = ' '. $attributes;
		}

		// Write the opening list tag
		$out .= "<".$type.$attributes.">\n";

		// Cycle through the list elements.  If an array is
		// encountered we will recursively call _list()

		static $_last_list_item = '';
		foreach ($list as $key => $val)
		{
			$_last_list_item = $key;

			$out .= str_repeat(" ", $depth + 2);
			$out .= "<li>";

			if ( ! is_array($val))
			{
				$out .= $val;
			}
			else
			{
				$out .= $_last_list_item."\n";
				$out .= _list($type, $val, '', $depth + 4);
				$out .= str_repeat(" ", $depth + 2);
			}

			$out .= "</li>\n";
		}

		// Set the indentation for the closing tag
		$out .= str_repeat(" ", $depth);

		// Write the closing list tag
		$out .= "</".$type.">\n";

		return $out;
	}
}

// ------------------------------------------------------------------------

/**
 * Generates HTML BR tags based on number supplied
 *
 * @access	public
 * @param	integer
 * @return	string
 */
if ( ! function_exists('br'))
{
	function br($num = 1)
	{
		return str_repeat("<br />", $num);
	}
}

// ------------------------------------------------------------------------

/**
 * Image
 *
 * Generates an <img /> element
 *
 * @access	public
 * @param	mixed
 * @return	string
 */
if ( ! function_exists('img'))
{
	function img($src = '', $index_page = FALSE)
	{
		if ( ! is_array($src) )
		{
			$src = array('src' => $src);
		}

		// If there is no alt attribute defined, set it to an empty string
		if ( ! isset($src['alt']))
		{
			$src['alt'] = '';
		}

		$img = '<img';

		foreach ($src as $k=>$v)
		{

			if ($k == 'src' AND strpos($v, '://') === FALSE)
			{
				$CI =& get_instance();

				if ($index_page === TRUE)
				{
					$img .= ' src="'.$CI->config->site_url($v).'"';
				}
				else
				{
					$img .= ' src="'.$CI->config->slash_item('base_url').$v.'"';
				}
			}
			else
			{
				$img .= " $k=\"$v\"";
			}
		}

		$img .= '/>';

		return $img;
	}
}

// ------------------------------------------------------------------------

/**
 * Doctype
 *
 * Generates a page document type declaration
 *
 * Valid options are xhtml-11, xhtml-strict, xhtml-trans, xhtml-frame,
 * html4-strict, html4-trans, and html4-frame.  Values are saved in the
 * doctypes config file.
 *
 * @access	public
 * @param	string	type	The doctype to be generated
 * @return	string
 */
if ( ! function_exists('doctype'))
{
	function doctype($type = 'xhtml1-strict')
	{
		global $_doctypes;

		if ( ! is_array($_doctypes))
		{
			if (defined('ENVIRONMENT') AND is_file(APPPATH.'config/'.ENVIRONMENT.'/doctypes.php'))
			{
				include(APPPATH.'config/'.ENVIRONMENT.'/doctypes.php');
			}
			elseif (is_file(APPPATH.'config/doctypes.php'))
			{
				include(APPPATH.'config/doctypes.php');
			}

			if ( ! is_array($_doctypes))
			{
				return FALSE;
			}
		}

		if (isset($_doctypes[$type]))
		{
			return $_doctypes[$type];
		}
		else
		{
			return FALSE;
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Link
 *
 * Generates link to a CSS file
 *
 * @access	public
 * @param	mixed	stylesheet hrefs or an array
 * @param	string	rel
 * @param	string	type
 * @param	string	title
 * @param	string	media
 * @param	boolean	should index_page be added to the css path
 * @return	string
 */
if ( ! function_exists('link_tag'))
{
	function link_tag($href = '', $rel = 'stylesheet', $type = 'text/css', $title = '', $media = '', $index_page = FALSE)
	{
		$CI =& get_instance();

		$link = '<link ';

		if (is_array($href))
		{
			foreach ($href as $k=>$v)
			{
				if ($k == 'href' AND strpos($v, '://') === FALSE)
				{
					if ($index_page === TRUE)
					{
						$link .= 'href="'.$CI->config->site_url($v).'" ';
					}
					else
					{
						$link .= 'href="'.$CI->config->slash_item('base_url').$v.'" ';
					}
				}
				else
				{
					$link .= "$k=\"$v\" ";
				}
			}

			$link .= "/>";
		}
		else
		{
			if ( strpos($href, '://') !== FALSE)
			{
				$link .= 'href="'.$href.'" ';
			}
			elseif ($index_page === TRUE)
			{
				$link .= 'href="'.$CI->config->site_url($href).'" ';
			}
			else
			{
				$link .= 'href="'.$CI->config->slash_item('base_url').$href.'" ';
			}

			$link .= 'rel="'.$rel.'" type="'.$type.'" ';

			if ($media	!= '')
			{
				$link .= 'media="'.$media.'" ';
			}

			if ($title	!= '')
			{
				$link .= 'title="'.$title.'" ';
			}

			$link .= '/>';
		}


		return $link;
	}
}

// ------------------------------------------------------------------------

/**
 * Generates meta tags from an array of key/values
 *
 * @access	public
 * @param	array
 * @return	string
 */
if ( ! function_exists('meta'))
{
	function meta($name = '', $content = '', $type = 'name', $newline = "\n")
	{
		// Since we allow the data to be passes as a string, a simple array
		// or a multidimensional one, we need to do a little prepping.
		if ( ! is_array($name))
		{
			$name = array(array('name' => $name, 'content' => $content, 'type' => $type, 'newline' => $newline));
		}
		else
		{
			// Turn single array into multidimensional
			if (isset($name['name']))
			{
				$name = array($name);
			}
		}

		$str = '';
		foreach ($name as $meta)
		{
			$type		= ( ! isset($meta['type']) OR $meta['type'] == 'name') ? 'name' : 'http-equiv';
			$name		= ( ! isset($meta['name']))		? ''	: $meta['name'];
			$content	= ( ! isset($meta['content']))	? ''	: $meta['content'];
			$newline	= ( ! isset($meta['newline']))	? "\n"	: $meta['newline'];

			$str .= '<meta '.$type.'="'.$name.'" content="'.$content.'" />'.$newline;
		}

		return $str;
	}
}

// ------------------------------------------------------------------------

/**
 * Generates non-breaking space entities based on number supplied
 *
 * @access	public
 * @param	integer
 * @return	string
 */
if ( ! function_exists('nbs'))
{
	function nbs($num = 1)
	{
		return str_repeat("&nbsp;", $num);
	}
}


/* End of file html_helper.php */
/* Location: ./system/helpers/html_helper.php */