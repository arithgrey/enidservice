<div class='row'>
    <div class='col-lg-12'>
        <div style='background:#007BE3!important;'>                    
            <h3 class='white'>
               <i class="fa fa-money" aria-hidden="true">
                </i>
                Labor de venta
            </h3>
        </div>           
    </div>
    <div class='col-lg-12'>                                             
        <div class="panel">                                             
            <div class="panel-body">               
                <?=n_row_12()?> 
                    
                        <div class='place_contactos_disponibles'>
                        </div>
                        <div class='place_resultado_final'>
                        </div>                    
                <?=end_row()?>
                <?=n_row_12()?>
                    <center>
                        <div class='col-lg-4 col-lg-offset-4 '>
                            <div class='contenedor_formulario_contactos' 
                                id='contenedor_formulario_contactos'>                                     
                                <form class='form_busqueda_contacto'>                                                  
                                    <div class='white text-center strong' style='padding:10px;background:#0075FF;'>                                                        
                                        ¿Qué tipo de negocio deseas atacar?                                                         
                                    </div>
                                    <label class="control-label white" >
                                        Tipo de Negocio
                                    </label>                    

                                    <?=create_select($tipos_negocios_base_telefonica , 
                                        "tipo_negocio" , 
                                        "tipo_negocio   form-control" , 
                                        "tipo_negocio" ,
                                        "nombre", 
                                        "idtipo_negocio" 
                                    )?> 
                                    


                                    <input  name="id_usuario" type='hidden'  value='<?=$id_usuario;?>'>                            
                                    <button class='btn'>
                                        Mostrar nuevo contacto
                                    </button>                        
                                </form>            
                            </div>                            
                        </div>                                           
                    </center>
                <?=end_row()?>
            </div>
        </div>      
    </div>
</div>




















