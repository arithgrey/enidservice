<!DOCTYPE html>
<html lang="es">
<head>
<?=$this->load->view("../../../view_tema/header_meta_enid")?>
<div id="flipkart-navbar">
    <div class="container">
        <?php if($is_mobile <  1 && $in_session ==  0):?>

            <div class="menu_completo_enid_service">
                <!--1-->
                <?=get_logo($is_mobile)?>
                <!--8-->
                <?php if($is_mobile ==  0 && !isset($proceso_compra) || (isset($proceso_compra) && $proceso_compra == 0) ):?>
                    <?=$this->load->view("../../../view_tema/formularios/form_busqueda_departamentos")?>
                <?php endif;?>
                <!--3-->
                <?=$this->load->view("../../../view_tema/menu_session")?>
            </div>
        <?php elseif($is_mobile ==  1 &&  $in_session ==  0):?>
            <?=get_logo($is_mobile , $in_session)?>

        <?php  elseif($is_mobile ==  1 &&  $in_session ==  1  ):?>
            <?=get_logo($is_mobile , $in_session)?>
            <div class="col-lg-11">
                <?=$this->load->view("../../../view_tema/tmp_menu")?>
            </div>
        <?php  elseif($is_mobile == 0 &&  $in_session ==  1  ):?>
            <?=get_logo($is_mobile , $in_session)?>
            <div class="col-lg-11">
                <?=$this->load->view("../../../view_tema/formularios/form_busqueda_departamentos")?>
                <?=$this->load->view("../../../view_tema/tmp_menu")?>
            </div>
        <?php endif;?>


    </div>
</div>
<?=$this->load->view("../../../view_tema/menu_session_movil")?>