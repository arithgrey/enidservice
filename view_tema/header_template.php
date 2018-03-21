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
                        <?php if($in_session ==  0){?>
                                <?=$this->load->view("../../../view_tema/menu_session")?>
                            <?php } ?>
                            <?=$this->load->view("../../../view_tema/tmp_menu")?>

                       
                            <div class="row menu_completo_enid_service">
                                    <div class="col-lg-3 col-sm-12">

                                       <?php if($in_session ==  0){?>
                                        <h2 style="margin:0px;">
                                            <span 
                                                class="smallnav menu white" 
                                                  onclick="openNav()">☰ 
                                                <a href="../" class="white">                                
                                                </a>
                                            </span>
                                        </h2>

                                        <?php } ?>

                                        <h1 style="margin:0px;font-size: 1.2em!important;">
                                                <a href="../" 
                                                    style="color: white!important;"
                                                    class="largenav">
                                                    <img 
                                                    src="../img_tema/enid_service_logo.jpg" 
                                                    style="width: 40px;">
                                                </a>
                                        </h1>
                                    </div>
                                    
                                    
                                    <div class="col-lg-9 col-sm-12 contenedor_busqueda_global_enid_service">
                                        <form action="../search">
                                            <div class="row">
                                                
                                                
                                                <div class="col-lg-3">
                                                    <?=$clasificaciones_departamentos?>
                                                </div>
                                                <input 
                                                    class="col-lg-7 input_busqueda_producto" 
                                                    type="text" 
                                                    style="height: 30px!important;margin-top: 5px;" 
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

    <?php if($in_session ==  0){?>
    <?=$this->load->view("../../../view_tema/menu_session_movil")?>
    <?php }?>  
       


<div class="procesando_solicutud_enid_service" style="display: none;">
    <div class="animationload">
        <div class="osahanloading">
        </div>
    </div>
</div>



<style type="text/css">
#flipkart-navbar {
    background-color: #03163f;
    color: #FFFFFF;
}

.row1{
    padding-top: 10px;
}

.row2 {
    padding-bottom: 20px;
}

.flipkart-navbar-input {
    padding: 10px 5px;
    border-radius: 2px 0 0 2px;
    border: 0 none;
    outline: 0 none;
    font-size: 15px;
}

.flipkart-navbar-button {
    
    background-color: #ffe11b;
    border: 1px solid #ffe11b;    
    color: #565656;        
    cursor: pointer;
}

.cart-button {
    background-color: #2469d9;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .23), inset 1px 1px 0 0 hsla(0, 0%, 100%, .2);
    padding: 10px 0;
    text-align: center;
    height: 41px;
    border-radius: 2px;
    font-weight: 500;
    width: 120px;
    display: inline-block;
    color: #FFFFFF;
    text-decoration: none;
    color: inherit;
    border: none;
    outline: none;
}

.cart-button:hover{
    text-decoration: none;
    color: #fff;
    cursor: pointer;
}

.cart-svg {
    display: inline-block;
    width: 16px;
    height: 16px;
    vertical-align: middle;
    margin-right: 8px;
}

.item-number {
    border-radius: 3px;
    background-color: rgba(0, 0, 0, .1);
    height: 20px;
    padding: 3px 6px;
    font-weight: 500;
    display: inline-block;
    color: #fff;
    line-height: 12px;
    margin-left: 10px;
}

.upper-links {
    display: inline-block;
    padding: 0 11px;
    line-height: 23px;
    font-family: 'Roboto', sans-serif;
    letter-spacing: 0;
    color: inherit;
    border: none;
    outline: none;
    font-size: 12px;
}

.dropdown {
    position: relative;
    display: inline-block;
    margin-bottom: 0px;
}

.dropdown:hover {
    background-color: #fff;
}

.dropdown:hover .links {
    //color: #000;
}

.dropdown:hover .dropdown-menu {
    display: block;
}

.dropdown .dropdown-menu {
    position: absolute;
    top: 100%;
    display: none;
    background-color: #fff;
    color: #333;
    left: 0px;
    border: 0;
    border-radius: 0;
    box-shadow: 0 4px 8px -3px #555454;
    margin: 0;
    padding: 0px;
}

.links {
    color: #fff;
    text-decoration: none;
}

.links:hover {
    //color: #fff;
    text-decoration: none;
}

.profile-links {
    font-size: 12px;
    font-family: 'Roboto', sans-serif;
    border-bottom: 1px solid #e9e9e9;
    box-sizing: border-box;
    display: block;
    padding: 0 11px;
    line-height: 23px;
}

.profile-li{
    padding-top: 2px;
}

.largenav {
    display: none;
}

.smallnav{
    display: block;
}

.smallsearch{
    margin-left: 15px;
    margin-top: 15px;
}

.menu{
    cursor: pointer;
}

@media screen and (min-width: 768px) {
    .largenav {
        display: block;
    }
    .smallnav{
        display: none;
    }
    .smallsearch{
        margin: 0px;
    }
}

/*Sidenav*/
.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: #fff;
    overflow-x: hidden;
    transition: 0.5s;
    box-shadow: 0 4px 8px -3px #555454;
    padding-top: 0px;
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #818181;
    display: block;
    transition: 0.3s
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
    color: #fff;        
}

@media screen and (max-height: 450px) {
  .sidenav a {font-size: 18px;}
}

.sidenav-heading{
    font-size: 36px;
    color: #fff;
}

.input_busqueda_producto ,.button_busqueda_producto{
    display: inline-table!important;
}
</style>
<script type="text/javascript">
function openNav() {
    document.getElementById("mySidenav").style.width = "70%";    
    document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.body.style.backgroundColor = "rgba(0,0,0,0)";
}
</script>