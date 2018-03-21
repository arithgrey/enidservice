<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**/
if ( ! function_exists('url_uso')){
	
	function url_uso(){
		return base_url("index.php/home/uso");    
	}
}



/**/
if ( ! function_exists('url_contacto')){
	
	function url_contacto(){
		return "http://www.enidservice.com/inicio/#contacto";    
	}
}



if ( ! function_exists('url_social')){
	
	function url_social(){
		return base_url()."#social";    
	}
}


/**/
if ( ! function_exists('url_registro')){
	
	function url_registro(){
		return base_url()."#registro";    
	}
}


/**/
if ( ! function_exists('url_registro_nuevo_miembro')){
	
	function url_registro_nuevo_miembro(){
		return "../login/index.php/api/emp/prospectos_enid/format/json";    
	}
}


/**/
if ( ! function_exists('url_developer')){
	
	function url_developer(){
		return "http://www.enidservice.com/jonathan-govinda-medrano-salazar";    
	}
}
/**/
if ( ! function_exists('url_global'))
{
	function url_global()
	{
		return base_url('index.php/inicio');    
	}
}
/**/
/**/
if ( ! function_exists('url_presentacion'))
{
	function url_presentacion(){
		return '../../principal';
	}	
}
/**/

if ( ! function_exists('url_log_out'))
{
	function url_log_out(){
		return "../../login/index.php/startsession/logout";
	}	
}
/**/
if ( ! function_exists('url_info_cuenta')){
	function url_info_cuenta(){
		return base_url('index.php/recursocontroller/informacioncuenta'); 
	}	
}
/**/
if ( ! function_exists('url_busqueda_eventos')){
	function url_busqueda_eventos(){
		return  "../busqueda"; 
	}	
}
/**/
/**/
if ( ! function_exists('url_solicita_artista'))
{
	function url_solicita_artista($id_empresa){
		return  base_url('index.php/emp/solicita_tu_artista') ."/".$id_empresa;
	}	
}
/**/
if ( ! function_exists('url_cuenta_tu_historia'))
{
	function url_cuenta_tu_historia($id_empresa){
		return  base_url('index.php/emp/cuenta_tu_historia') ."/".$id_empresa;
	}	
}
/**/
if ( ! function_exists('url_la_historia')){
	function url_la_historia($id_empresa){
		return  base_url('index.php/emp/la_historia') ."/".$id_empresa;
	}	
}
/**/
if ( ! function_exists('url_nuevo_miembro')){
	
	function url_nuevo_miembro(){
		return base_url('index.php/home/nuevo_miembro');
	}		
	
}
/**/
if ( ! function_exists('create_url_img_artista'))
{
	function create_url_img_artista($id_artista){
		return  base_url('index.php/enid/imagen_artista') ."/".$id_artista;
	}

}	
/***/
if ( ! function_exists('create_url_img_acceso'))
{
	function create_url_img_acceso($id_acceso){
		return  base_url('index.php/enid/imagen_acceso') ."/".$id_acceso;
	}
}	
/**/
if ( ! function_exists('create_url_img_escenario'))
{
	function create_url_img_escenario($id_escenario){
		return base_url('index.php/enid/imagen_escenario')."/".$id_escenario;
	}
}	
/**/
if ( ! function_exists('create_url_img_evento'))
{
	function create_url_img_evento($id_evento){
		return base_url('index.php/enid/img_evento')."/".$id_evento;
	}
}	
/**/
if ( ! function_exists('url_dia_evento'))
{
	function url_dia_evento($id_evento){
		return  base_url('index.php/eventos/dia_evento') ."/".$id_evento;
	}
}	
/**/
if ( ! function_exists('url_accesos_al_evento'))
{

	function url_accesos_al_evento($id_evento){
		return  base_url('index.php/eventos/accesos_al_evento') ."/".$id_evento;
	}
}
/**/
if ( ! function_exists('url_accesos_configuracion_avanzada'))
{
	function url_accesos_configuracion_avanzada($id_evento ){
		return base_url('index.php/accesos/configuracionavanzada/')."/0/". $id_evento;
	}
}
/**/
if ( ! function_exists('site_url'))
{
	function site_url($uri = '')
	{
		$CI =& get_instance();
		return $CI->config->site_url($uri);
	}
}
/**/
if ( ! function_exists('url_inicio_eventos'))
{
	function url_inicio_eventos()
	{
		return base_url('../principal');    
	}
}
/**/
if ( ! function_exists('create_url_puntoventa_admin')){
  /**/
  function create_url_puntoventa_admin($extra=''){
    return base_url("index.php/puntosventa/administrar")."/".$extra;
  }
}
/**/
if ( ! function_exists('url_edit_user')){
  /**/  
  function url_edit_user($url ,  $text ){

    $url_next =  "<a href='".$url."' style='color:white;'>
                    ". $text."
                    <i class='fa fa-cog'>
                    </i>
                  </a>";  
    return $url_next;                
  }
}
/**/
if ( ! function_exists('create_url_evento_public')){
  function create_url_evento_public($nombre, $id_evento , $extra='' ){
    $url =  base_url('/index.php/eventos/visualizar') . "/". $id_evento;
    return "<a href='". $url ."'  $extra >" . $nombre ."</a>";
  }
}  

/**/
if ( ! function_exists('create_url_config_escenario')){  
  function create_url_config_escenario($extra){
    return base_url("index.php/escenario/configuracionavanzada")."/".$extra;
  }
} 

if ( ! function_exists('create_url_escenario_in_evento')){  
  function create_url_escenario_in_evento($id_escenario , $id_evento ){

    return base_url('index.php/escenario/inevento')."/".$id_escenario. "/".$id_evento;
  }
} 

if ( ! function_exists('create_url_historias')){  
	/**/
 function create_url_historias($id_empresa){
    return base_url("index.php/emp/cuenta_tu_historia")."/".$id_empresa;
  }
}
/**/	
if ( ! function_exists('create_url_evento_view')){    
  function create_url_evento_view($id_evento){
    return base_url("index.php/eventos/visualizar") . "/" .  $id_evento;
  }
}  
/**/
if ( ! function_exists('url_resumen_artistas_escenario')){    
  function url_resumen_artistas_escenario($id_escenario){
    return base_url('index.php/escenario/resumen_artistas_escenario')."/".$id_escenario;
  }
}  

/**/
if( ! function_exists('url_evento_view_config')){    
	function url_evento_view_config($id_evento){
    	return base_url("index.php/eventos/nuevo") . "/" .  $id_evento;
  	}
}
/**/
if( ! function_exists('url_tmp_img')){    
	function url_tmp_img($id_imagen){
    	return base_url("index.php/enid/img")."/".$id_imagen;
  	}
}
/**/

if( ! function_exists('url_tmp_maps')){    
	function url_tmp_maps(){
    	return base_url('index.php/maps/map');
  	}
}

if( ! function_exists('url_ingresos_egresos')){    

	function url_ingresos_egresos(){
		return  base_url('index.php/emp/ingresos_egresos');
  	}
}
/**/
if(! function_exists('url_inicio_session')){    
	function url_inicio_session(){
		return "../login";	
	}	
}
/**/
if(! function_exists('url_usos_privacidad_enid_service')){    
	function url_usos_privacidad_enid_service(){
		return base_url('index.php/home/usos_privacidad_enid_service');	
	}	
}

if(! function_exists('url_sugerencias')){    
	function url_sugerencias(){
		return base_url('index.php/reportecontrolador');	
	}	
}
/**/
if(! function_exists('url_publicidad_template')){    
	function url_publicidad_template($id_publicidad){		
		return  base_url("index.php/templates/img_publicidad")."/".$id_publicidad;
	}	
}
/**/
if(! function_exists('url_templates')){    
	function url_templates($extra){		
		return base_url('index.php/templates/eventos').$extra;
	}	
}

/**/
if(! function_exists('url_imagen_empresa')){    
	function url_imagen_empresa($id_empresa){		
		return base_url("index.php/enid/imagen_empresa")."/".$id_empresa;
	}	
}




/**/
// ------------------------------------------------------------------------

/**
 * Base URL
 * 
 * Create a local URL based on your basepath.
 * Segments can be passed in as a string or an array, same as site_url
 * or a URL to a file can be passed in, e.g. to an image file.
 *
 * @access	public
 * @param string
 * @return	string
 */
if ( ! function_exists('base_url'))
{
	function base_url($uri = '')
	{
		$CI =& get_instance();
		return $CI->config->base_url($uri);
	}
}

// ------------------------------------------------------------------------

/**
 * Current URL
 *
 * Returns the full URL (including segments) of the page where this
 * function is placed
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('current_url'))
{
	function current_url()
	{
		$CI =& get_instance();
		return $CI->config->site_url($CI->uri->uri_string());
	}
}

// ------------------------------------------------------------------------
/**
 * URL String
 *
 * Returns the URI segments.
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('uri_string'))
{
	function uri_string()
	{
		$CI =& get_instance();
		return $CI->uri->uri_string();
	}
}

// ------------------------------------------------------------------------

/**
 * Index page
 *
 * Returns the "index_page" from your config file
 *
 * @access	public
 * @return	string
 */
if ( ! function_exists('index_page'))
{
	function index_page()
	{
		$CI =& get_instance();
		return $CI->config->item('index_page');
	}
}

// ------------------------------------------------------------------------

/**
 * Anchor Link
 *
 * Creates an anchor based on the local URL.
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the link title
 * @param	mixed	any attributes
 * @return	string
 */
if ( ! function_exists('anchor'))
{
	function anchor($uri = '', $title = '', $attributes = '')
	{
		$title = (string) $title;

		if ( ! is_array($uri))
		{
			$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
		}
		else
		{
			$site_url = site_url($uri);
		}

		if ($title == '')
		{
			$title = $site_url;
		}

		if ($attributes != '')
		{
			$attributes = _parse_attributes($attributes);
		}

		return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
	}
}

// ------------------------------------------------------------------------

/**
 * Anchor Link - Pop-up version
 *
 * Creates an anchor based on the local URL. The link
 * opens a new window based on the attributes specified.
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the link title
 * @param	mixed	any attributes
 * @return	string
 */
if ( ! function_exists('anchor_popup'))
{
	function anchor_popup($uri = '', $title = '', $attributes = FALSE)
	{
		$title = (string) $title;

		$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;

		if ($title == '')
		{
			$title = $site_url;
		}

		if ($attributes === FALSE)
		{
			return "<a href='javascript:void(0);' onclick=\"window.open('".$site_url."', '_blank');\">".$title."</a>";
		}

		if ( ! is_array($attributes))
		{
			$attributes = array();
		}

		foreach (array('width' => '800', 'height' => '600', 'scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0', ) as $key => $val)
		{
			$atts[$key] = ( ! isset($attributes[$key])) ? $val : $attributes[$key];
			unset($attributes[$key]);
		}

		if ($attributes != '')
		{
			$attributes = _parse_attributes($attributes);
		}

		return "<a href='javascript:void(0);' onclick=\"window.open('".$site_url."', '_blank', '"._parse_attributes($atts, TRUE)."');\"$attributes>".$title."</a>";
	}
}

// ------------------------------------------------------------------------

/**
 * Mailto Link
 *
 * @access	public
 * @param	string	the email address
 * @param	string	the link title
 * @param	mixed	any attributes
 * @return	string
 */
if ( ! function_exists('mailto'))
{
	function mailto($email, $title = '', $attributes = '')
	{
		$title = (string) $title;

		if ($title == "")
		{
			$title = $email;
		}

		$attributes = _parse_attributes($attributes);

		return '<a href="mailto:'.$email.'"'.$attributes.'>'.$title.'</a>';
	}
}

// ------------------------------------------------------------------------

/**
 * Encoded Mailto Link
 *
 * Create a spam-protected mailto link written in Javascript
 *
 * @access	public
 * @param	string	the email address
 * @param	string	the link title
 * @param	mixed	any attributes
 * @return	string
 */
if ( ! function_exists('safe_mailto'))
{
	function safe_mailto($email, $title = '', $attributes = '')
	{
		$title = (string) $title;

		if ($title == "")
		{
			$title = $email;
		}

		for ($i = 0; $i < 16; $i++)
		{
			$x[] = substr('<a href="mailto:', $i, 1);
		}

		for ($i = 0; $i < strlen($email); $i++)
		{
			$x[] = "|".ord(substr($email, $i, 1));
		}

		$x[] = '"';

		if ($attributes != '')
		{
			if (is_array($attributes))
			{
				foreach ($attributes as $key => $val)
				{
					$x[] =  ' '.$key.'="';
					for ($i = 0; $i < strlen($val); $i++)
					{
						$x[] = "|".ord(substr($val, $i, 1));
					}
					$x[] = '"';
				}
			}
			else
			{
				for ($i = 0; $i < strlen($attributes); $i++)
				{
					$x[] = substr($attributes, $i, 1);
				}
			}
		}

		$x[] = '>';

		$temp = array();
		for ($i = 0; $i < strlen($title); $i++)
		{
			$ordinal = ord($title[$i]);

			if ($ordinal < 128)
			{
				$x[] = "|".$ordinal;
			}
			else
			{
				if (count($temp) == 0)
				{
					$count = ($ordinal < 224) ? 2 : 3;
				}

				$temp[] = $ordinal;
				if (count($temp) == $count)
				{
					$number = ($count == 3) ? (($temp['0'] % 16) * 4096) + (($temp['1'] % 64) * 64) + ($temp['2'] % 64) : (($temp['0'] % 32) * 64) + ($temp['1'] % 64);
					$x[] = "|".$number;
					$count = 1;
					$temp = array();
				}
			}
		}

		$x[] = '<'; $x[] = '/'; $x[] = 'a'; $x[] = '>';

		$x = array_reverse($x);
		ob_start();

	?><script type="text/javascript">
	//<![CDATA[
	var l=new Array();
	<?php
	$i = 0;
	foreach ($x as $val){ ?>l[<?php echo $i++; ?>]='<?php echo $val; ?>';<?php } ?>

	for (var i = l.length-1; i >= 0; i=i-1){
	if (l[i].substring(0, 1) == '|') document.write("&#"+unescape(l[i].substring(1))+";");
	else document.write(unescape(l[i]));}
	//]]>
	</script><?php

		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
}

// ------------------------------------------------------------------------

/**
 * Auto-linker
 *
 * Automatically links URL and Email addresses.
 * Note: There's a bit of extra code here to deal with
 * URLs or emails that end in a period.  We'll strip these
 * off and add them after the link.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the type: email, url, or both
 * @param	bool	whether to create pop-up links
 * @return	string
 */
if ( ! function_exists('auto_link'))
{
	function auto_link($str, $type = 'both', $popup = FALSE)
	{
		if ($type != 'email')
		{
			if (preg_match_all("#(^|\s|\()((http(s?)://)|(www\.))(\w+[^\s\)\<]+)#i", $str, $matches))
			{
				$pop = ($popup == TRUE) ? " target=\"_blank\" " : "";

				for ($i = 0; $i < count($matches['0']); $i++)
				{
					$period = '';
					if (preg_match("|\.$|", $matches['6'][$i]))
					{
						$period = '.';
						$matches['6'][$i] = substr($matches['6'][$i], 0, -1);
					}

					$str = str_replace($matches['0'][$i],
										$matches['1'][$i].'<a href="http'.
										$matches['4'][$i].'://'.
										$matches['5'][$i].
										$matches['6'][$i].'"'.$pop.'>http'.
										$matches['4'][$i].'://'.
										$matches['5'][$i].
										$matches['6'][$i].'</a>'.
										$period, $str);
				}
			}
		}

		if ($type != 'url')
		{
			if (preg_match_all("/([a-zA-Z0-9_\.\-\+]+)@([a-zA-Z0-9\-]+)\.([a-zA-Z0-9\-\.]*)/i", $str, $matches))
			{
				for ($i = 0; $i < count($matches['0']); $i++)
				{
					$period = '';
					if (preg_match("|\.$|", $matches['3'][$i]))
					{
						$period = '.';
						$matches['3'][$i] = substr($matches['3'][$i], 0, -1);
					}

					$str = str_replace($matches['0'][$i], safe_mailto($matches['1'][$i].'@'.$matches['2'][$i].'.'.$matches['3'][$i]).$period, $str);
				}
			}
		}

		return $str;
	}
}

// ------------------------------------------------------------------------

/**
 * Prep URL
 *
 * Simply adds the http:// part if no scheme is included
 *
 * @access	public
 * @param	string	the URL
 * @return	string
 */
if ( ! function_exists('prep_url'))
{
	function prep_url($str = '')
	{
		if ($str == 'http://' OR $str == '')
		{
			return '';
		}

		$url = parse_url($str);

		if ( ! $url OR ! isset($url['scheme']))
		{
			$str = 'http://'.$str;
		}

		return $str;
	}
}

// ------------------------------------------------------------------------

/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with a "separator" string 
 * as the word separator.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator
 * @return	string
 */
if ( ! function_exists('url_title'))
{
	function url_title($str, $separator = '-', $lowercase = FALSE)
	{
		if ($separator == 'dash') 
		{
		    $separator = '-';
		}
		else if ($separator == 'underscore')
		{
		    $separator = '_';
		}
		
		$q_separator = preg_quote($separator);

		$trans = array(
			'&.+?;'                 => '',
			'[^a-z0-9 _-]'          => '',
			'\s+'                   => $separator,
			'('.$q_separator.')+'   => $separator
		);

		$str = strip_tags($str);

		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}

		return trim($str, $separator);
	}
}

// ------------------------------------------------------------------------

/**
 * Header Redirect
 *
 * Header redirect in two flavors
 * For very fine grained control over headers, you could use the Output
 * Library's set_header() function.
 *
 * @access	public
 * @param	string	the URL
 * @param	string	the method: location or redirect
 * @return	string
 */
if ( ! function_exists('redirect'))
{
	function redirect($uri = '', $method = 'location', $http_response_code = 302)
	{
		if ( ! preg_match('#^https?://#i', $uri))
		{
			$uri = site_url($uri);
		}

		switch($method)
		{
			case 'refresh'	: header("Refresh:0;url=".$uri);
				break;
			default			: header("Location: ".$uri, TRUE, $http_response_code);
				break;
		}
		exit;
	}
}

// ------------------------------------------------------------------------

/**
 * Parse out the attributes
 *
 * Some of the functions use this
 *
 * @access	private
 * @param	array
 * @param	bool
 * @return	string
 */
if ( ! function_exists('_parse_attributes'))
{
	function _parse_attributes($attributes, $javascript = FALSE)
	{
		if (is_string($attributes))
		{
			return ($attributes != '') ? ' '.$attributes : '';
		}

		$att = '';
		foreach ($attributes as $key => $val)
		{
			if ($javascript == TRUE)
			{
				$att .= $key . '=' . $val . ',';
			}
			else
			{
				$att .= ' ' . $key . '="' . $val . '"';
			}
		}

		if ($javascript == TRUE AND $att != '')
		{
			$att = substr($att, 0, -1);
		}

		return $att;
	}
}


/* End of file url_helper.php */
/* Location: ./system/helpers/url_helper.php */