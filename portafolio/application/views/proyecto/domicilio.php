<?php	
    
    /**/
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

    
        <div class="row">
        	<div style="border-style:solid;border-width: 1px;padding: 5px;">
                <div>                    
                    <div>   
                        <div>
                            <center>
                                <span style="font-size: 48px;line-height: 80%;">
                                    <i class="fa fa-bus"></i>
                                    Dirección de envio 
                                </span>
                            </center>
                        </div>                   
                        <br>                
                        <div 
                            id='modificar_direccion_seccion' class="contenedor_form_envio">
                            <hr>
                            <form class="form-horizontal form_direccion_envio">

                                <div>                                    
                                  <?=n_row_12()?>
                                    <div>
                                        
                            

                                        <div>
                                                    
                                                    <div class="value">                
                                                            <label class="label-off"">
                                                                Código postal
                                                            </label> 
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
                                                                value="<?=$param['id_usuario']?>">
                                                            
                                                    </div>
                                                    
                                                    
                                        </div>

                                        <div>      
                                                    <div class="value">                    
                                                            <label class="label-off" for="dwfrm_profile_address_address1">
                                                                Calle
                                                            </label> 
                                                            <input 
                                                            class="textinput address1  
                                                            required" 
                                                            name="calle" 

                                                            value="<?=$calle;?>" 
                                                            maxlength="30" 
                                                            placeholder="* Calle" 
                                                            required="required" 
                                                            autocorrect="off" type="text">
                                                                      
                                                    </div>
                                                
                                        </div>
                                        <div>      
                                                    <div class="value">                  
                                                          <label class="label-off" for="dwfrm_profile_address_address3">
                                                            Entre la calle y la calle, o información adicional
                                                          </label> 
                                                          <input
                                                          required 
                                                          class="textinput address3 " 
                                                          name="referencia" 
                                                          value="<?=$entre_calles;?>"                                                           
                                                          placeholder="Entre la calle y la calle, o información adicional" 
                                                          type="text">                
                                                    </div>      
                                                    
                                        </div>

                                        <div>
                                                
                                                    <div class="value">
                                                          
                                                            <label class="label-off" for="dwfrm_profile_address_houseNumber">
                                                            Número Exterior
                                                            </label> 
                                                            <input 
                                                                class="required numero_exterior"
                                                                name="numero_exterior" 
                                                                value="<?=$numero_exterior?>" 
                                                                maxlength="8" 
                                                                placeholder="* Número Exterior" 
                                                                required
                                                                type="text">
                                                        
                                                    </div>              
                                        </div>

                                        <div>              
                                                    <div class="value">                                
                                                            <label class="label-off" for="dwfrm_profile_address_address2">
                                                                Número Interior
                                                            </label> 
                                                            <input 
                                                            class="numero_interior" 
                                                            name="numero_interior" 
                                                            value="<?=$numero_interior;?>" 
                                                            maxlength="10"  
                                                            autocorrect="off" 
                                                            type="text"
                                                            required>               
                                                        
                                                    </div>      
                                        </div>

                                        <div <?=$direccion_visible?> class="parte_colonia_delegacion">

                                        <div>            
                                                    <div class="value">                
                                                            <label 
                                                            class="label-off" 
                                                            for="dwfrm_profile_address_colony">
                                                                Colonia
                                                            </label> 
                                                            <div class="place_colonias_info">
                                                                <input type="text" name="colonia" 
                                                                value="<?=$asentamiento?>" readonly>
                                                            </div>
                                                    </div>      
                                                    <span class="place_asentamiento">
                                                        
                                                    </span>
                                                    
                                        </div>
                                        <div>
                                            <div class=" district delegacion_c" 
                                           >
                                                        <div class="value">
                                                                              
                                                                <label class="label-off" for="dwfrm_profile_address_district">
                                                                    Delegación o Municipio
                                                                </label> 
                                                                <div class="place_delegaciones_info">
                                                                    <input 
                                                                    type="text" 
                                                                    name="delegacion"
                                                                    value="<?=$municipio?>" readonly>
                                                                </div>              
                                                        </div>      
                                            </div>
                                        
                                            <div class=" district  estado_c">
                                                        <div class="value">
                                                                <label 
                                                                class="label-off" for="dwfrm_profile_address_district">
                                                                    Estado    
                                                                </label> 
                                                                <div class="place_estado_info">
                                                                    <input 
                                                                    type="text" 
                                                                    name="estado"
                                                                    value="<?=$estado?>" readonly>
                                                                </div>              
                                                        </div>      
                                            </div>


                                            <div class=" district pais_c">
                                                        <div class="value">
                                                                <label 
                                                                class="label-off" for="dwfrm_profile_address_district">
                                                                    País    
                                                                </label> 
                                                                <div class="place_pais_info">
                                                                    
                                                                </div>              
                                                        </div>      
                                            </div>

                                                    
                                                    <div class="direccion_principal_c">
                                                        <label class="strong">
                                                            Esta es mi dirección principal 
                                                        </label>
                                                        <select name='direccion_principal'>
                                                            <option value="1">
                                                                SI 
                                                            </option>    
                                                            <option value="0">
                                                                NO 
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-12 button_c">
                                                        <button class="btn text_btn_direccion_envio">
                                                            Registrar dirección 
                                                        </button>
                                                    </div>
                                            </div>        
                                        </div>


                                        </div>
                                                  

                                        </div>
                                        </div>
                                        
                                        
                                    </div>
                                  <?=end_row()?>
                                </div>
                            </form>
                        </div>                            
                        <?=n_row_12()?>                            
                                <div 
                                    class="seccion_saldo_pendiente"  
                                    id="seccion_saldo_pendiente" 
                                    style="display: none;">
                                    <div class="price-table">
                                        <div class="row">
                                            <div class="col-lg-8 col-lg-offset-2">
                                                <div class="pricing text-center two">
                                                    <div>
                                                        <div>
                                                            <center>
                                                                <div style="width: 200px;">

                                                                    <img 
                                                                    src="../img_tema/bancos/ejemplo_proceso_envio.png"
                                                                    width="100%">
                                                                </div>
                                                            </center>
                                                        </div>
                                                        <p  style="font-size: 1.8em;padding: 5px;" 
                                                            class="blue_enid_background white">
                                                            <em>
                                                                
                                                                <?=create_seccion_saldo_pendiente($data_saldo_pendiente)?>MXN   
                                                            </em>                                    
                                                        </p>
                                                        <p 
                                                            style="font-weight: bold;font-size: 1.2em;">
                                                            Saldo pendiente 
                                                        </p>
                                                        <div>   
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                          
                        <?=end_row()?>
                        
                    </div>
                </div>
            </div>
        </div>
    






  










<br>
<br><br><br><br>