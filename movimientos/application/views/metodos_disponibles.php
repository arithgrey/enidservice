<?php    
    $nombre=  entrega_data_campo($usuario , "nombre");
    $apellido_paterno=  entrega_data_campo($usuario , "apellido_paterno");
    $apellido_materno=  entrega_data_campo($usuario , "apellido_materno");
    $nombre_persona =  $nombre ." " . $apellido_paterno ." " .$apellido_materno;    
?>

<main>
<?=n_row_12()?>
    <div class="col-lg-4 col-lg-offset-4" style="background: #fbfbfb;border-right-style: solid;border-width: .9px;border-left-style: solid;">
        <center>
            <h3 style="font-weight: bold;font-size: 2em;">      
                ASOCIAR CUENTA BANCARIA
            </h3>            
        </center>
            <p>
                Enid Service protege y garantiza la seguridad de la información de su cuenta bancaria. Nunca revelaremos su información financiera y, cada vez que inicie una transacción con esta cuenta bancaria, Enid Service se lo notificará por correo electrónico.
            </p>
        <form class="form_asociar_cuenta" method="POST" action="?action=4">
            <div class="page-header">
                <?php if($error == 1): ?>
                    <div style="background: #ba0606; color: white;padding: 5px;">
                        SE PRESENTARON ERRORES AL ASOCIAR CUENTA, VERIFIQUE SU INFORMACIÓN ENVIADA
                    </div>
                <?php endif; ?>
                <div style="border-bottom-style: solid;border-width: 1px;">
                    <h4>
                        <?=$nombre_persona;?>                  
                    </h4>
                </div>
                <h4>
                    <small style="color:black;">
                    1.- PAÍS
                    </small>
                </h4>
                <select class="form-control" name="pais">
                    <option value="1" >
                        México
                    </option>
                </select>
                <h4>
                    <small style="color:black;">
                    2.- SELECCIONA TU BANCO
                    </small>
                </h4>
                <?=create_select(
                    $bancos , 
                    "banco" , 
                    "banco_cuenta" ,
                    "sel1" , 
                    "nombre", 
                    "id_banco", 
                1 )?>
                
                <?php if($banca == 0): ?>
                    <h4>
                        <small style="color:black;">
                            3.-NÚMERO CLABE(18 dígitos)
                        </small>
                    </h4>
                    <input 
                        class="form-control numero_tarjeta" 
                        id="input-1" 
                        name="clabe"                                                            
                        placeholder="Número clabe de tu banco"
                        required=""                    
                        maxlength="18"
                        minlength="18">
                <?php else:?>
                    <h4>
                        <small style="color:black;">
                            4.- TIPO DE TARJETA 
                        </small>
                    </h4>
                    <select class="form-control" name="tipo_tarjeta">
                        <option value="0" >
                            Débito
                        </option>
                        <option value="1">
                            Crédito
                        </option>
                    </select>
                    <h4>
                        <small style="color:black;">
                            5.- NÚMERO DE TARJETA 
                                <i class="fa fa-credit-card-alt"></i>
                        </small>
                    </h4>
                    <input 
                        class="form-control numero_tarjeta" 
                        id="input-1" 
                        name="numero_tarjeta"
                        placeholder="Número de tarjeta"
                        required=""                    
                        minlength="16"
                        maxlength="16">
                <?php endif; ?>
                <input type="hidden" name="tipo" value="<?=$banca?>">
                <div style="margin-top: 20px;">
                    <button type="submit" class="a_enid_blue" style="color: white!important">
                        ASOCIAR <i class="fa fa-chevron-right"></i>
                    </button>
                </div>
                <div style="margin-top: 35px;background: #213668;padding: 10px;">
                    <p class="white" style="font-size: 1.1em;">
                        Al asociar tu cuenta, podrás transferir tu saldo de 
                        Enid Service a tu cuenta personal
                    </p>
                </div>            
            </div>
        </form>    
    </div>
<?=end_row()?>
</main>

<style type="text/css">
    .banco_cuenta{
        width: 100%;
    }
</style>
<script type="text/javascript" src="<?=base_url()?>/application/js/asociar.js">
</script>