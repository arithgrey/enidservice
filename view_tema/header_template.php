<?php
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
?>    
<!DOCTYPE html>
<html lang="es">
<head>
<?=$this->load->view("../../../view_tema/header_meta_enid")?>

<div id="flipkart-navbar">
    <div class="container">        
                        
                            <?=$this->load->view("../../../view_tema/menu_session")?>
                            <?=$this->load->view("../../../view_tema/tmp_menu")?>

                            <div class="extra_menu_simple" style="display: none;">
                                <a href="../">
                                    <img src="../img_tema/enid_service_logo.jpg" 
                                    style="width: 50px;">
                                </a>                                        
                            </div>
                            <div class="menu_completo_enid_service">
                                    <div class="col-lg-3">
                                        <span class="smallnav menu white"
                                                style="font-size: 1.5em;font-weight: bold;" 
                                                onclick="openNav()">☰ 
                                                <a  class="white" 
                                                style="color: white!important;">
                                                    Enid Service                                
                                                </a>
                                        </span>           
                                        <a  href="../"
                                            class="largenav">
                                            <img 
                                            src="../img_tema/enid_service_logo.jpg" 
                                            style="width: 50px;">
                                        </a>                                        
                                    </div>
                                    
                                    
                                    <div class="col-lg-9 contenedor_busqueda_global_enid_service">
                                        <form action="../search">
                                            <div class="row">
                                                
                                                
                                                <div class="col-lg-3">
                                                    <?=$clasificaciones_departamentos?>
                                                </div>
                                                <input 
                                                    class="col-lg-7 input_busqueda_producto input_enid" 
                                                    type="text" 
                                                    style="margin-top: 5px;" 
                                                    placeholder="Buscar" 
                                                    name="q">
                                                    <button 
                                                        style="height: 30px!important;" 
                                                        class="flipkart-navbar-button col-lg-1
                                                        button_busqueda_producto
                                                        col-sm-2">
                                                    <i class="fa fa-search">
                                                    </i>
                                                </button>   
                                                
                                            </div>
                                        </form>
                                    </div>
                            </div>
                            


    </div>
</div>

<?=$this->load->view("../../../view_tema/menu_session_movil")?>

       


