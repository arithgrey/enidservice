<?=n_row_12()?>
<div class="col-lg-12">
  <span   
    class='text-center strong'
    style='font-size:.8em!important;'>
    # Resultados
    <?=count($info);?>    
  </span>   
</div>
<?=end_row()?>
<?php  
	$l ="";
	$tipo = 0;	
	$estilos_estra ="style='font-size:.8em!important;background: #0030ff;color: white;'"; 	
	foreach ($info as $row) {	

		$tipo =  $row["tipo"];
		$id_persona =  $row["id_persona"];
		$nombre =  $row["nombre"];
		$a_paterno =  $row["a_paterno"];
		$a_materno =  $row["a_materno"];
		$tel =  $row["tel"];
		$tel_2 =  $row["tel_2"];		
		$correo =  $row["correo"];		
		$id_usuario_enid_service = $row["id_usuario_enid_service"];		
		$img_cliente = "../imgs/index.php/imagen_usuario/".$id_usuario_enid_service;	
		
		$nombre  = $nombre . " " . $a_paterno . " " . $a_materno; 						
		$fecha_registro = $row["fecha_registro"];			
    $url_imagen ="../imgs/index.php/enid/imagen_usuario/".$id_usuario_enid_service;	
    /*PERSONA*/
		$extra_persona =  "<i class='info_persona black' id='".$id_persona."'></i>";

		$extra_agendar =  "<i href='#tab_agendar_llamada' data-toggle='tab' 
            							class='btn_agendar_llamada fa fa-phone-square ' 
            							id='".$id_persona."'>
            							</i>";
			
			$btn_agregar_servicios =  btn_ticket($tipo , $id_persona , $nombre );
			
      ?>
        <div class="popup-box chat-popup" id="qnimate" style="margin-top: 4px;">
            <div class="popup-head">
              <div class="popup-head-left pull-left">
                <img 
                  src="<?=$url_imagen?>" style='width: 44px;'  
                  onerror="this.src='../img_tema/user/user.png'" > 
                  <span <?=$extra_persona?> >
                    <?=$nombre?>
                  </span>
              </div>
              <div class="popup-head-right pull-right ">
                <div class="btn-group">
                        <button 
                          class="chat-header-button" 
                          data-toggle="dropdown" 
                          type="button" 
                          aria-expanded="false">
                         <i class="fa fa-plus">                        
                         </i> 
                        </button>
                        <ul role="menu" class="dropdown-menu pull-right ">
                        <li>
                            <a href="#" style="font-size: 1.3em;">
                              Información del cliente
                            </a>
                        </li>
                        <!--
                        <li>
                            <a href="#">
                            Block
                          </a>
                        </li>
                        <li>
                            <a href="#">
                            Clear Chat
                          </a>
                        </li>
                        <li>
                            <a href="#">
                            Email Chat
                          </a>
                        </li>
                      -->
                        </ul>
                </div>        
              </div>
          </div>
        </div>                
      <?php 


	}
 	
?>







<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br><br>
<br>
<br>
<br>
<br><br>
<br>
<br>
<br>
<br><br>
<br>
<br>
<br>
<br>



<style type="text/css">
  @import url(https://fonts.googleapis.com/css?family=Oswald:400,300);
  @import url(https://fonts.googleapis.com/css?family=Open+Sans);
  .popup-box{    
      border: 1px solid #b0b0b0;
      bottom: 0;      
      right: 70px;
      width: 100%;
      font-family: 'Open Sans', sans-serif;
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
      font-family: 'Open Sans', sans-serif;
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
       font-family: Oswald;
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

<script type="text/javascript">
        $(function(){
          $('#qnimate').addClass('popup-box-on');
            $("#addClass").click(function () {
            $('#qnimate').addClass('popup-box-on');
            });
          
            $("#removeClass").click(function () {
          $('#qnimate').removeClass('popup-box-on');
            });
      })
</script>