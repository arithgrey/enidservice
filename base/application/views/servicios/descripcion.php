                <?=n_row_12()?>               
                    <div class="contenedor_inf_servicios">
                        <div>
                            <div class="titulo_seccion_producto titulo_producto_servicio">
                                INFORMACIÓN SOBRE TU - 
                                <?=entrega_data_campo($servicio ,"nombre_servicio")?>
                            </div>
                        </div>                    
                        <div class="text_desc_servicio">
                            <i  class="fa fa-pencil text_desc_servicio" 
                                style="margin-left: 10px;">
                            </i>
                            <span style="font-size: 1em!important;" class='contenedor_descripcion'>
                                <?=entrega_data_campo($servicio , 'descripcion');?>            
                            </span>            
                        </div>
                        <div style="display: none;" class="input_desc_servicio_facturacion">
                            <form class="form_servicio_desc">
                                <div>                                                    
                                    <input type="hidden" name="q" value="descripcion">
                                    <div id="summernote">
                                        - <?=entrega_data_campo($servicio , 'descripcion');?>            
                                    </div>
                                </div>    
                                <div>
                                    <button class="btn_guardar_desc input-sm">
                                        GUARDAR 
                                    </button>
                                </div>
                            </form>
                        </div>    
                    </div>     
                <?=end_row()?>  