<div class='col-lg-4'>
    <?=div("Inicio", ["class"=>'strong'])?>
    <?=input([
        "data-date-format"      =>"yyyy-mm-dd",
        "name"                  =>'fecha_inicio' ,
        "class"                 =>"form-control input-sm datetimepicker4" ,
        "id"                    =>'datetimepicker4' ,
        "value"                 => date("Y-m-d")
    ])?>
</div>
<div class='col-lg-4'>
    <?=div("Fin", ["class"=>'strong'])?>
    <?=input(
        [
            "data-date-format"  =>  "yyyy-mm-dd",
            "name"              =>  'fecha_termino',
            "class"             =>  "form-control input-sm datetimepicker5" ,
            "id"                =>  'datetimepicker5' ,
            "value"             =>  date("Y-m-d")
        ])?>        
</div>
<br>
<?=div(guardar("Búsqueda " .icon("fa fa-chevron-right").icon("fa fa-chevron-right")), ["class"  => 'col-lg-4'])?>