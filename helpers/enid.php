<?php 
if ( ! function_exists('add_input'))
{
  function add_input( $attributes='')
  {    
      $attr =  add_attributes($attributes);
      return "<input ".$attr.">";
  }
}
/**/
if ( ! function_exists('add_element'))
{
  function add_element( $info , $type , $attributes='')
  {    
      $attr =  add_attributes($attributes);
      return "<".$type." ".$attr." >".$info."</".$type.">";
  }
}
/**/
if ( ! function_exists('add_attributes'))
{
  function add_attributes($attributes)
  {
    if (is_string($attributes))
    {
      return ($attributes != '') ? ' '.$attributes : '';
    }

    $att = '';
    foreach ($attributes as $key => $val)
    {    
        $att .= ' ' . $key . '="' . $val . '"';    
    }
    return $att;
  }
}

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
if ( ! function_exists('anchor_enid'))
{
  function anchor_enid( $title = '', $attributes = '')
  {
    $title = (string) $title;
    if ($attributes != '')
    {
      $attributes = _parse_attributes($attributes);
    }

    return '<a '.$attributes.'>'.$title.'</a>';
  }
}

if ( ! function_exists('get_td'))
{
  function get_td($val , $attributes = '' ){

      $attr =  add_attributes($attributes);   
      return "<td ". $attr ." NOWRAP >". $val ."</td>";
  }
}

if ( ! function_exists('select_enid'))
{
  function select_enid($data , $text_option , $val ,  $attributes ='' ){

      $attr =  add_attributes($attributes);   
      $select ="<select ".$attr."> ";

        foreach ($data as $row) {      
          $select .=  "<option value='". $row[$val] ."'>". $row[$text_option]." </option>";
        }

      $select .="</select>";
      return $select;
  }
}