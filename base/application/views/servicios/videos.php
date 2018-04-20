<div style="margin-top: 30px;"></div>
<?=n_row_12()?>    
    <div class="well" style="background: #fefefe!important">    
        <div class='titulo_seccion_producto'>
            TIENES ALGÚN VIDEO SOBRE TU - <?=$tipo_promocion?> 
        </div>
        <div style="margin-top: 20px;">                            
        </div>
        <?=n_row_12()?>
            <div border="1">
                <span class="strong" style="font-size: 1em;">
                    <i class="fa fa-youtube-play" style="color: red; font-size: 1.3em;">
                    </i>
                    <strong style="font-size: .9em;">
                        Video Youtube
                    </strong>
                </span>
            </div>
            <div class="text_video_servicio">
                <span style="font-size: .9em;">
                    <?=entrega_data_campo($servicio , "url_vide_youtube")?>
                </span>
                <i  class="fa fa-pencil text_url_youtube" 
                                        style="margin-left: 10px;">
                </i>
            </div>
                                <div style="display: none;" class="input_url_youtube">
                                    <form class="form_servicio_youtube">
                                        <div>                           
                                            <input type="hidden" name="q" value="url_vide_youtube">
                                            <input type="url" name="q2" class='url_youtube' 
                                            value ="<?=entrega_data_campo($servicio , 'url_vide_youtube')?>"
                                            required>
                                            <span class="place_url_youtube">            
                                            </span>
                                        </div>    
                                        <div>
                                            <button class="btn input-sm">
                                                Guardar 
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                            <?=end_row()?>  
       </div>  
                         
                              
<?=end_row()?>