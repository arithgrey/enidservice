<?php	   
	$l ="Usuarios activos: ".count($info_usuarios);
	echo $l;
	foreach($info_usuarios as $row){			
     
    $id_usuario =  $row["id_usuario"]; 
    $nombre =  $row["nombre"]; 
    $email =  $row["email"]; 
    $apellido_paterno =  $row["apellido_paterno"]; 
    $apellido_materno =  $row["apellido_materno"]; 
    $num_accesos =  $row["num_accesos"];

    $tel_contacto = $row["tel_contacto"];
    $afiliado =  $nombre ." " . $apellido_materno ." " .$apellido_paterno; 
    /**/
    $comision_venta =  $row["comision_venta"];
    
    $url_imagen =  "../imgs/index.php/enid/imagen_usuario/".$id_usuario;


    ?>
    <div class="popup-box chat-popup" id="qnimate" style="margin-top: 4px;">
            <div class="popup-head">
              <div class="popup-head-left pull-left">
                <img 
                  src="<?=$url_imagen?>" style='width: 44px;'
                   onerror="this.src='../img_tema/user/user.png'"> 
                  <span class="black">
                    <?=$afiliado?>
                  </span>
                  
                  <span style="">
                    <span class="blue_enid_background white" style="padding: 3px;">
                      Alcance <?=$num_accesos?>

                    </span>
                    |

                    
                    <?php if($comision_venta>0){?>
                    <span 
                      class="white" 
                      title="Ganancias por pagar"
                      style="padding: 2px;background: #0F285C;">
                      <?=$comision_venta?>MXN
                    </span> | 
                    <?php }?>

                    <?=$email;?> |  <?=$tel_contacto?> | 

                  </span>
              </div>
              <div class="popup-head-right pull-right">                
                <div class="btn-group">

                        <button 
                          class="chat-header-button" 
                          data-toggle="dropdown" 
                          type="button" 
                          aria-expanded="false">
                         <?=icon("fa fa-plus")?>                        
                         </i> 
                        </button>
                        <ul role="menu" class="dropdown-menu pull-right">
                        
                        <li>
                          <a style="">                            
                            Información del afiliado
                          </a>
                        </li>

                          
                        </ul>
                </div>        
              </div>
          </div>
        </div> 
        <?php 

	}	
?>



<style type="text/css">
  .popup-box{    
      border: 1px solid #b0b0b0;
      bottom: 0;      
      right: 70px;
      width: 100%;
  }
  .round.hollow {
      margin: 40px 0 0;
  }
  .round.hollow a {
      border: 2px solid #ff6701;
      border-radius: 35px;
      color: red;
      color: #ff6701;
      font-size: 23px;
      padding: 10px 21px;
      text-decoration: none;      
  }
  .round.hollow a:hover {
      border: 2px solid #000;
      border-radius: 35px;
      color: red;
      color: #000;
      font-size: 23px;
      padding: 10px 21px;
      text-decoration: none;
  }
  .popup-box-on {
      display: block !important;
  }
  .popup-box .popup-head {
      background-color: #fff;
      clear: both;
      color: #7b7b7b;
      display: inline-table;
      font-size: 21px;
      padding: 7px 10px;
      width: 100%;       
  }
  .bg_none i {
      border: 1px solid #ff6701;
      border-radius: 25px;
      color: #ff6701;
      font-size: 17px;
      height: 33px;
      line-height: 30px;
      width: 33px;
  }
  .bg_none:hover i {
      border: 1px solid #000;
      border-radius: 25px;
      color: #000;
      font-size: 17px;
      height: 33px;
      line-height: 30px;
      width: 33px;
  }
  .bg_none {
      background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
      border: medium none;
  }
  .popup-box .popup-head .popup-head-right {
      margin: 11px 7px 0;
  }
  .popup-box .popup-messages {
  }
  .popup-head-left img {
      border: 1px solid #7b7b7b;
      border-radius: 50%;
      width: 44px;
  }
  .popup-messages-footer > textarea {
      border-bottom: 1px solid #b2b2b2 !important;
      height: 34px !important;
      margin: 7px;
      padding: 5px !important;
       border: medium none;
      width: 95% !important;
  }
  .popup-messages-footer {
      background: #fff none repeat scroll 0 0;
      bottom: 0;
      position: absolute;
      width: 100%;
  }
  .popup-messages-footer .btn-footer {
      overflow: hidden;
      padding: 2px 5px 10px 6px;
      width: 100%;
  }
  .simple_round {
      background: #d1d1d1 none repeat scroll 0 0;
      border-radius: 50%;
      color: #4b4b4b !important;
      height: 21px;
      padding: 0 0 0 1px;
      width: 21px;
  }
  .direct-chat-messages {
      overflow: auto;
      padding: 10px;
      transform: translate(0px, 0px);
      
  }
  .popup-head-right .btn-group {
      display: inline-flex;
    margin: 0 8px 0 0;
    vertical-align: top !important;
  }
  .chat-header-button {
      background: transparent none repeat scroll 0 0;
      border: 1px solid #636364;
      border-radius: 50%;
      font-size: 14px;
      height: 30px;
      width: 30px;
  }
  .popup-head-right .btn-group .dropdown-menu {
      border: medium none;
      min-width: 122px;
    padding: 0;
  }
  .popup-head-right .btn-group .dropdown-menu li a {
      font-size: 12px;
      padding: 3px 10px;
    color: #303030;
  }
  .direct-chat-reply-name {
      color: #fff;
      font-size: 15px;
      margin: 0 0 0 10px;
      opacity: 0.9;
  }
  .direct-chat-img-reply-small
  {
      border: 1px solid #fff;
      border-radius: 50%;
      float: left;
      height: 20px;
      margin: 0 8px;
      width: 20px;
    background:#3f9684;
  }


  .popup-messages .doted-border::after {
    background: transparent none repeat scroll 0 0 !important;
      border-right: 2px dotted #fff !important;
    bottom: 0;
      content: "";
      left: 17px;
      margin: 0;
      position: absolute;
      top: 0;
      width: 2px;
     display: inline;
      z-index: -2;
  }


  .direct-chat-text::after, .direct-chat-text::before {
     
      border-color: transparent #dfece7 transparent transparent;
      
  }
  .direct-chat-text::after, .direct-chat-text::before {
      -moz-border-bottom-colors: none;
      -moz-border-left-colors: none;
      -moz-border-right-colors: none;
      -moz-border-top-colors: none;
      border-color: transparent #d2d6de transparent transparent;
      border-image: none;
      border-style: solid;
      border-width: medium;
      content: " ";
      height: 0;
      pointer-events: none;
      position: absolute;
      right: 100%;
      top: 15px;
      width: 0;
  }
  .direct-chat-text::after {
      border-width: 5px;
      margin-top: -5px;
  }
  .direct-chat-text {
      background: #d2d6de none repeat scroll 0 0;
      border: 1px solid #d2d6de;
      border-radius: 5px;
      color: #444;
      margin: 5px 0 0 50px;
      padding: 5px 10px;
      position: relative;
  }
  .info_persona:hover{
    cursor: pointer;
  }
</style>
