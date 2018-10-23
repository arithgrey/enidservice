<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
	
	function create_arr_tags($data){
	    $tags = array();
	    
	    foreach ($data as $row){ 

	      $metakeyword 		=  $row["metakeyword"];    
	      if (strlen($metakeyword)>0) {   
	        $tags 			=  json_decode($metakeyword , true);
	      }
	    }
	    return $tags;
  	} 
  	
}
