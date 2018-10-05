<?=heading_enid("USUARIOS" , 3)?>
<?=$paginacion?>
<?php	
	$l ="";
	foreach($miembros as $row) {
	
		$id_usuario         =   $row["id_usuario"]; 
		$nombre             =   $row["nombre"]; 
		$email              =   $row["email"]; 
		$apellido_paterno   =   $row["apellido_paterno"]; 
		$apellido_materno   =   $row["apellido_materno"]; 
		$tel_contacto       =   ""; 
		$afiliado           =   $nombre . " " . $apellido_paterno ." " . $apellido_materno;		
    $url_imagen         =   "../imgs/index.php/enid/imagen_usuario/".$id_usuario;
    $editar             =   
    [
      "class"           =>  'usuario_enid_service', 
      "data-toggle"     =>  'tab', 
      "href"            =>  '#tab_mas_info_usuario', 
      "id"              =>  $id_usuario
    ];
            
    $fecha_registro =  $row["fecha_registro"];
    ?>
<div class="popup-box chat-popup" id="qnimate" >
  <div class="popup-head">
    <div class="popup-head-left pull-left">
      <?=img([
                "src"       => $url_imagen,
                "style"     => 'width: 44px!important;',
                "onerror"   => "this.src='../img_tema/user/user.png'"
          ])?>
        <?=span($afiliado)?>
        <?=div($fecha_registro)?>                                    
    </div>
    <?php if ($modo_edicion == 1):?>
    <div class="popup-head-right pull-right">                
      <?=span(icon("fa fa-envelope") ,  
      ["title"=>"Email de recordatorio enviados"])?>                    
      <div class="btn-group">
        <?=guardar(icon('fa fa-plus') ,  
          [
            "class"       => "chat-header-button" ,
            "data-toggle" => "dropdown" 
          ])?>
        <ul role="menu" class="dropdown-menu pull-right">
          <li>  
            <?=anchor(icon('fa fa-pencil')."Editar información",$editar)?>                        
          </li>                      
        </ul>
        </div>  
      </div>
  <?php endif; ?>
    </div>
  </div> 
<?php }?>

<?=$l;?>
<script type="text/javascript" rsc="<?=base_url()?>/application/css/template/info_usuarios.css"></script>
