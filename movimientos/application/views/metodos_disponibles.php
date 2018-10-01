<?php    
    $nombre=  get_campo($usuario , "nombre");
    $apellido_paterno=  get_campo($usuario , "apellido_paterno");
    $apellido_materno=  get_campo($usuario , "apellido_materno");
    $nombre_persona =  $nombre ." " . $apellido_paterno ." " .$apellido_materno;    
    $text_tipo_ingreso = ($banca ==  0)?"ASOCIAR CUENTA BANCARIA":"ASOCIAR TARJETA DE DÉDITO O CRÉDITO" ;
?>


<?=n_row_12()?>
    <div class='contenedor_principal_enid'>
        <?php if($seleccion == 0):?>
            <?=n_row_12()?>
                <div class="col-lg-4 col-lg-offset-4" style="background: #fbfbfb;border-right-style: solid;border-width: .9px;border-left-style: solid;">        
                    <center>
                        <h3 style="font-size: 2em;">      
                            <?=$text_tipo_ingreso?>
                        </h3>            
                    </center>
                        <p>
                            Enid Service protege y garantiza la seguridad de la información de su cuenta bancaria. Nunca revelaremos su información financiera y, cada vez que inicie una transacción con esta cuenta bancaria, Enid Service se lo notificará por correo electrónico.
                        </p>
                    <form class="form_asociar_cuenta" method="POST" action="?action=4">
                        <div class="page-header">
                            <?php if($error == 1): ?>
                                <div style="background: #004bff; color: white;padding: 5px;">
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
                                            <?=icon("fa fa-credit-card-alt")?>
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
                            <div >
                                <button type="submit" class="a_enid_blue" style="color: white!important">
                                    ASOCIAR <?=icon("fa fa-chevron-right")?>
                                </button>
                            </div>
                            <div style="margin-top: 35px;background: #213668;padding: 10px;">
                                <p class="white" >
                                    Al asociar tu cuenta, podrás transferir tu saldo de 
                                    Enid Service a tu cuenta personal
                                </p>
                            </div>            
                        </div>
                    </form>    
                </div>
            <?=end_row()?>

        <?php else:?>
            <div class="col-lg-4 col-lg-offset-4" 
                    style="background: #fbfbfb;border-right-style: solid;border-width: .9px;border-left-style: solid;">
                    <center>
                        <h3 style="font-size: 2em;">      
                            ASOCIAR CUENTA BANCARIA Ó TARJETA DE CRÉDITO O DÉBITO
                        </h3>            
                    </center>
                    <center>
                    <a href="?q=transfer&action=1&tarjeta=1" 
                        style="color:black;"  
                    class="">
                        <div class="asociar_cuenta_bancaria" 
                            style="border-style: solid;border-width: .9px;padding: 10px;
                            margin-top: 50px;">
                            Asociar  tarjeta de crédito o débito
                        </div>
                    </a>
                    <a href="?q=transfer&action=1"  class="white" style="color: white!important">
                        <div 
                            style="border-style: solid;border-width: .9px;padding: 10px;
                            margin-top: 10px;color: white!important!important" class="a_enid_blue asociar_tarjeta">
                            Asociar cuenta bancaria
                        </div>
                    </a>
                    </center>                
            </div>
        <?php endif; ?>
    </div>
<?=end_row()?>


