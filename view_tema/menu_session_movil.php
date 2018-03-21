<div id="mySidenav" class="sidenav">
	<div class="container" style="background-color: #2874f0; padding-top: 10px;">
        <span class="sidenav-heading" style="font-size: .8em;">
        	<img src="../img_tema/enid_service_logo.jpg" style="width: 50px;">
        	Enid Service
        </span>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    </div>
   
    <a  class="links" 
		href="../afiliados/"
		style="font-size: .8em;color:black!important;">
        <i class="fa fa-usd">
        </i>
        Afiliados
    </a>
    <a  class="links" 
    	href="../contacto/#envio_msj"
    	style="font-size: .8em;color:black!important;">
        <i class="fa fa-paper-plane">
        </i>
        Envía mensaje
    </a>
    
    <?php if ($in_session ==  0): ?>
        <a  class="links white blue_enid_background" 
            href="../login"
            style="padding: 5px;color: white!important; font-size: .8em;">
                Acceso 
            <i class="fa fa-user"></i>
        </a>
    <?php endif; ?>       		

</div>