<div class='col-lg-4'>
    <?=div("Inicio", ["class"=>'strong'])?>
    <?=input([
        "data-date-format"      =>"yyyy-mm-dd",
        "name"                  =>'fecha_inicio' ,
        "class"                 =>"form-control input-sm datetimepicker4" ,
        "id"                    =>'datetimepicker4' 
    ])?>
</div>
<div class='col-lg-4'>
    <?=div("Fin", ["class"=>'strong'])?>
    <?=input(
        [
            "data-date-format"  =>  "yyyy-mm-dd",
            "name"              =>  'fecha_termino',
            "class"             =>  "form-control input-sm datetimepicker5" ,
            "id"                =>  'datetimepicker5' 
        ])?>        
</div>
<?=guardar("Búsqueda", ["class"  => 'col-lg-4'])?>