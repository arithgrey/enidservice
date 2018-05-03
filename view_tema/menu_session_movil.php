<div id="mySidenav" class="sidenav">
	
    <div class="container" style="padding-top: 10px;background: black;">
        <span class="sidenav-heading" style="font-size: .9em;">
        	<img src="../img_tema/enid_service_logo.jpg" style="width: 50px;padding: 1px;">
        	<span style="font-size:1.5em;"> 
                Enid Service
            </span>
        </span>
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    </div> 
    <?=n_row_12()?>      
        <form class="form" action="../search">
            <?=n_row_12()?>      
                <div class="col-lg-12">
                    <div style="font-weight: bold;font-size: 1.1em;margin-top: 20px;">            
                        <i class="fa fa-search"></i>
                        BÚSQUEDA
                    </div>
                </div>
            <?=end_row()?>  
            <?=n_row_12()?> 
                <div class="col-lg-12">
                    <input name="q" placeholder="Articulo ó servicio" width="100%">
                    <button class="a_enid_blue_sm">
                        Buscar
                    </button>   
                </div>
            <?=end_row()?>           
        </form>   
    <?=end_row()?>  
    <?=n_row_12()?>
        <div style="margin-top: 60px;background: black;">

            <a  style="font-weight: bold;font-size: 1.1em;margin-top: 150px;color: white!important;"
                href="../planes_servicios?action=nuevo">
                VENDER
            </a>
        </div> 
    <?=end_row()?>       

    <?php if ($in_session === 0):?>              
        <a  class="links" 
            href="../login/?action=nuevo"
            style="font-size: .9em;color:black!important;margin-top: 20px;">
            <i class="fa fa-shopping-cart">
            </i>
            Vender 
        </a>        
        <a  class="links" 
        	href="../contacto/#envio_msj"
            style="font-size: .9em;color:black!important;">
            <i class="fa fa-paper-plane">
            </i>
            Envía mensaje
        </a>
        <a  class="links white blue_enid_background2" 
            href="../login"
            style="font-size: .9em;color: white!important;">
            Iniciar sesión
            <i class="fa fa-user"></i>
        </a> 
    <?php else: ?>
      
    <?php endif; ?>                  

</div>