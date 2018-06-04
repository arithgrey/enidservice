<div id="mySidenav" class="sidenav">
	
    <div>        
        <a 
        href="javascript:void(0)" 
        class="closebtn closebtn_lateral" 
        onclick="closeNav()">×
        </a>
        <div class="logo_lateral_login">
            <a href="../search/?q2=0&q=">
                <img src="../img_tema/enid_service_logo.jpg" >        	        
            </a>
        </div>

    </div> 
    <?=n_row_12()?>      
        <br>
        <form class="form" action="../search">            
            <?=n_row_12()?> 
                <div class="col-lg-12">
                    <input name="q" 
                    placeholder="Articulo ó servicio" 
                    class="input_search form-control">                    
                    <button class="boton-busqueda form-control" >
                        BUSCAR
                    </button>   
                </div>
            <?=end_row()?>           
        </form>   
    <?=end_row()?>      
    <?php if ($in_session === 0):?>                      
        <?=n_row_12()?> 
        <div class="contenedor-lateral-menu">
            <div class="col-lg-12">
                <a  
                    class="iniciar_sesion_lateral" 
                    style="color: white!important;" 
                    href="../login">
                    INICIAR SESIÓN
                    <i class="fa fa-user"></i>
                </a> 
            </div>
            <div class="col-lg-12">
                <a  href="../login/?action=nuevo" 
                    style="color: white!important;" 
                    class='call_to_action_anuncio'>
                    ANUNCIA TU NEGOCIO AQUÍ
                </a> 
            </div>     
        </div>
        <?=end_row()?>             
    <?php else: ?>      
    <?php endif; ?>                  

</div>