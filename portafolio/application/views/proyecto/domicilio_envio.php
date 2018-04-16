<?php	
    
    /**/
    $id_recibo =  $param["id_recibo"];    
    $id_codigo_postal = 0;
    $direccion= "";
    $calle ="";
    $entre_calles= "";
    $numero_exterior= "";
    $numero_interior=  "";
    $cp= "";
    $asentamiento =  "";
    $direccion_envio ="";
    $municipio = "";
    $estado ="";
    $flag_existe_direccion_previa = 0;
    $pais ="";
    $direccion_visible ="style='display:none;'";
    
    foreach ($info_envio_direccion as $row){
        
        $direccion =  $row["direccion"];
        $calle =  $row["calle"];
        $entre_calles =  $row["entre_calles"];
        $numero_exterior =  $row["numero_exterior"];
        $numero_interior =  $row["numero_interior"];
        $cp =  $row["cp"];
        $asentamiento =  $row["asentamiento"];
        $municipio  =  $row["municipio"];
        $estado = $row["estado"];        
        $flag_existe_direccion_previa ++;
        $direccion_visible ="";
        $id_codigo_postal = $row["id_codigo_postal"];
        $pais ="";        
    }
    /**/
?>

<div class="contenedor_deuda_para_envio" style="display: none;">
    <div class="col-lg-6 col-lg-offset-3">
        <?=n_row_12()?>                            
            <div class="col-lg-6 col-lg-offset-3">
                <img src="../img_tema/bancos/ejemplo_proceso_envio.png" width="100%">
            </div>
        <?=end_row()?>
        <?=n_row_12()?>                            
            <p  style="font-size: 1.8em;padding: 5px;" class="blue_enid_background white">
                SALDO PENDIENTE
                <?=$data_saldo_pendiente;?>MXN               
            </p>
            <div>   
                <?=valida_boton_pago($param , $id_recibo)?>
            </div>
        <?=end_row()?>
    </div>

</div>                                  
                        







<div class='contenedor_informacion_envio'>    
    <div class="row">
        	<div class="col-lg-6 col-lg-offset-3" 
                style="border-style:solid;border-width: 1px;padding: 5px;">
                
                    
                        <?=n_row_12()?>
                            <center>
                                <h2 class="titulo_enid">
                                    DIRECCIÓN DE ENVÍO
                                </h2>                                
                            </center>
                        <?=end_row()?>
                        <br>                
                        <div 
                            id='modificar_direccion_seccion' class="contenedor_form_envio">
                            <hr>
                            <form class="form-horizontal form_direccion_envio">

                               
                                  

                                    <?=n_row_12()?>                                
                                        <div class="titulo_enid_sm_sm">
                                                                Código postal
                                        </div>
                                        <input 
                                            maxlength="5"
                                            name="cp"
                                            value="<?=$cp?>" 
                                            placeholder="* Código postal"
                                            required="required" 
                                            class="codigo_postal" 
                                            id="codigo_postal"
                                            type="text">                
                                        <span class="place_codigo_postal">
                                        </span>
                                        <input type="hidden" 
                                            name="id_usuario"
                                            value="<?=$id_usuario?>">
                                        
                                    <?=end_row()?>

                                    <?=n_row_12()?>
                                            <div class="titulo_enid_sm_sm">
                                                Calle
                                            </div>                                            
                                            <input 
                                                class="textinput address1  
                                                required" 
                                                name="calle" 

                                                value="<?=$calle;?>" 
                                                maxlength="30" 
                                                placeholder="* Calle" 
                                                required="required" 
                                                autocorrect="off" type="text">
                                    <?=end_row()?>

                                    <?=n_row_12()?>
                                        <div class="titulo_enid_sm_sm">        
                                                            Entre la calle y la calle, o información adicional
                                        </div>
                                        <input
                                        required 
                                        class="textinput address3 " 
                                        name="referencia" 
                                        value="<?=$entre_calles;?>"                             placeholder="Entre la calle y la calle, o información adicional" 
                                        type="text">                
                                    <?=end_row()?>
                                    <?=n_row_12()?>
                                        <div class="titulo_enid_sm_sm">
                                            Número Exterior
                                        </div>
                                        <input 
                                        class="required numero_exterior"
                                        name="numero_exterior" 
                                        value="<?=$numero_exterior?>" 
                                        maxlength="8" 
                                        placeholder="* Número Exterior" 
                                        required
                                        type="text">  
                                    <?=end_row()?>    
                                    <?=n_row_12()?>
                                        <div class="titulo_enid_sm_sm">
                                            Número Interior
                                        </div>
                                                            
                                        <input 
                                        class="numero_interior" 
                                        name="numero_interior" 
                                        value="<?=$numero_interior;?>" 
                                        maxlength="10"  
                                        autocorrect="off" 
                                        type="text"
                                        required>
                                    <?=end_row()?>                                      
                                    <div <?=$direccion_visible?> 
                                        class="parte_colonia_delegacion">

                                        <?=n_row_12()?>
                                            <div class="titulo_enid_sm_sm">
                                                Colonia
                                            </div>
                                            <div class="place_colonias_info">
                                                <input type="text" name="colonia" 
                                                                value="<?=$asentamiento?>" readonly>
                                            </div>
                                                    
                                            <span class="place_asentamiento">
                                            </span>
                                        <?=end_row()?>                                                  
                                        <?=n_row_12()?>
                                            <div class=" district delegacion_c">
                                                <div class="titulo_enid_sm_sm">
                                                                    Delegación o Municipio
                                                </div>
                                                <div class="place_delegaciones_info">
                                                    <input 
                                                        type="text" 
                                                        name="delegacion"
                                                        value="<?=$municipio?>" readonly>
                                                </div>              
                                            </div>
                                        <?=end_row()?>          
                                        <?=n_row_12()?>
                                            <div class=" district  estado_c">
                                                <div class="titulo_enid_sm_sm">
                                                    Estado    
                                                </div>            
                                                <div class="place_estado_info">
                                                    <input 
                                                        type="text" 
                                                        name="estado"
                                                        value="<?=$estado?>" readonly>
                                                </div>              
                                            </div>
                                        <?=end_row()?>                           
                                        <?=n_row_12()?>
                                            <div class=" district pais_c">
                                                <div class="value">
                                                    <div class="titulo_enid_sm_sm">  
                                                        País    
                                                    </div>
                                                    <div class="place_pais_info">
                                                    </div>              
                                                </div>      
                                            </div>

                                        <?=end_row()?>  

                                        <?=n_row_12()?>
                                            <div class="direccion_principal_c">
                                                <div class="titulo_enid_sm_sm">
                                                    Esta es mi dirección principal 
                                                </div>
                                                <select name='direccion_principal'>
                                                    <option value="1">
                                                        SI
                                                    </option>    
                                                    <option value="0">
                                                        NO 
                                                    </option>
                                                </select>
                                            </div>
                                            <input 
                                                type="hidden"  
                                                name="id_recibo" 
                                                value="<?=$id_recibo?>">
                                        <?=end_row()?> 
                                        
                                        <?=n_row_12()?>                          
                                            <div class="col-lg-12 button_c">
                                                <button class="btn text_btn_direccion_envio a_enid_blue">
                                                                Registrar dirección 
                                                </button>
                                            </div>
                                        <?=end_row()?>                           
                                </div>
                            </form>
                        </div>                                                 
            </div>
    </div>    
</div>





  






<br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br>