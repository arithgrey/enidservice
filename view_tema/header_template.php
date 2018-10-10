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
            <?php $img_enid   = img_enid(["style"=>"width: 50px!important;"] ); ?>
            <?=anchor_enid($img_enid ,["href"=>"../"])?>
        </div>
        <div class="menu_completo_enid_service">
        <div class="col-lg-3">
            <?=div(
                "☰ ENID SERVICE",
                [
                    "class" =>  "smallnav menu white", 
                    "style" =>  "", 
                    "onclick"=> "openNav()"
                ])?>
            <?=anchor_enid($img_enid, 
                ["href"  =>  "../"]
            )?>

        </div>
        <div class="col-lg-9 contenedor_busqueda_global_enid_service">
                <form action="../search">
                <?=div($clasificaciones_departamentos , ["class"=>"col-lg-3"])?>
                <?=input(
                    [
                    "class"         =>  "col-lg-7 input_busqueda_producto input_enid", 
                    "type"          =>  "text", 
                    "style"         =>  "margin-top: 5px;", 
                    "placeholder"   =>  "Buscar",  
                    "name"          =>  "q"
                ])?>                
                <?=guardar("",
                    [                       
                    "class"         =>  
                    "flipkart-navbar-button col-lg-1 button_busqueda_producto fa fa-search col-sm-2"])?>
                </form>
            </div>
        </div>        
    </div>
</div>
<?=$this->load->view("../../../view_tema/menu_session_movil")?>