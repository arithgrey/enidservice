<?php
  $list ="";      
  foreach ($servicios as $row) {
        
    $nombre_servicio =  $row["nombre_servicio"];      
    $id_servicio  =  $row["id_servicio"];        
    $precio =  $row["precio"];        
    $flag_envio_gratis =  $row["flag_envio_gratis"];
    $text_extra =  is_servicio($row);        
    $precio_publico =  $row["precio_publico"];        
    $url_img  = 
    $url_request."imgs/index.php/enid/imagen_servicio/".$id_servicio;
    $url_img_error  = $url_request."img_tema/portafolio/producto.png";      
    $extra_url =  ($in_session == 1)?"&q2=".$id_usuario : "";      
    $url_info_producto =  "../producto/?producto=".$id_servicio.$extra_url;
    $url_venta =
    "http://enidservice.com/inicio/producto/?producto=".$id_servicio.$extra_url;
    $social = create_social_buttons($url_venta , $nombre_servicio);
?>

<table  class="enid_mobile_max_width" width="728" 
style="background: white; padding: 10px;">
        <tr>
          <td align="center" bgcolor="ffffff" width="360"  class="emailMobileColumnSplit">
            <table    class="emailMobileMaxHeight">
                <tr>
                  <td>
                    <table class="emailMobileStyledContentCell">
                      <tr>
                        <td class="enid_mobile_max_width"  align="center" >
                          
                        </td>
                      </tr>
                      <tr>
                        <td height="10">
                        </td>
                      </tr>                  
                      <tr>
                        <td align="center" width="330" 
                        	style="font-size:20px;font-family:Futura, Arial;
                        	line-height:22px;
                        	font-weight:none;
                        	text-align:center;
                        	text-transform:uppercase;
                        	color:#000001; padding-left:2px; padding-right:2px;">

                          <a
                            href="<?=$url_info_producto?>"
                            style="color:#000001; text-decoration:none" 
                            class="info_producto"  
                            id="<?=$id_servicio?>">                            
                            <?=$nombre_servicio?>
                          </a>

                    </td>
                      </tr>
                      <tr>
                        <td height="8">
                        </td>
                      </tr>                   
                      <tr>
                        <td 
	                        align="center" 
	                        width="330" 
	                        style="font-size:14px;font-family: Futura, Arial;
	                        line-height:20px;
	                        letter-spacing:0pt;
	                        color:#000001; 
	                        padding-left:2px; 
	                        padding-right:2px;">
                          	<a href="" style="color:#000001; text-decoration:none">
                            	<?=$text_extra?>
                          	</a>
                          	<?=$social?>
                      </td>
                      </tr>
                      <tr>
                        <td height="15">
                        </td>
                      </tr>                      
                      <tr>
                        <td align="center">
                          <table align="center">
                            <tr>
                              <td width="220" align="center"   style="font-size:14px;line-height:12px; border:2px solid #000000; font-family:Futura, Arial; letter-spacing:1px; color:#000000; background-color:#ffffff; text-decoration:none; text-transform:uppercase;padding-bottom:10px; padding-top:10px; padding-left:10px; padding-right:10px;font-weight:none;">
                                  <a style="color:#000001; text-decoration:none" 
                                    class="info_producto"
                                    href="<?=$url_info_producto?>"
                                    id="<?=$id_servicio?>">
                                  	<?=$precio_publico?> 
                                  	MXN
                                    <span style="font-size:20px;">›
                                  </span>
                                </a>
                            </td>
                            </tr>
                          </table>
                      </td>
                      </tr>                      
                      <tr>
                        <td height="20">
                        </td>
                      </tr>
                    </table>
                </td>
                </tr>
              </table>
        </td>
          <td >
          </td>
          <td  align="center"  width="360"  class="emailMobileColumnSplit">
            <table class="enid_mobile_max_width"   >
              <tr>
                <td>
                  <a
                    href="<?=$url_info_producto?>"
                    style="color:#000001; text-decoration:none">
                    
                    <div width="360" height="225">
                      <img  
                      	src="<?=$url_img?>"    
                        class="enid_mobile_max_width"                     
                        alt="<?=$nombre_servicio?>"                      
                        style="width:100%" 
                        onerror="this.src='<?=$url_img_error?>'" >
                    </div>
                </a>
            </td>
              </tr>
            </table>
        </td>
        </tr>
      </table>
      <hr>
      <?php 

    }
  
?>