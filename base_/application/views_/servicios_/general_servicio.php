<?=n_row_12()?>    
    <div class="text_nombre_servicio">
        <?=heading_enid(get_text_tipo_servicio($flag_servicio) ."/" . $nombre_servicio . icon('fa fa-pencil text_nombre_servicio'))?>
    </div>
    <div style="display: none;" class="input_nombre_servicio_facturacion">
        <form class="form_servicio_nombre_info">
            <?=input(["type"=>"text", "name"=>"q2", "value"=>$nombre_servicio, "required"=>true])?>
            <?=input_hidden(["name"=>"q", "value"=>"nombre_servicio"])?>
            <?=guardar("GUARDAR")?>
        </form>
    </div>
<?=end_row()?>