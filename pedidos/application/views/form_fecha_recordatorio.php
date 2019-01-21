<div class="col-lg-6 col-lg-offset-3">
    <form class="form_fecha_recordatorio" >
        <?=heading_enid("RECORDATORIO",
            4,
            ["class" =>"strong titulo_horario_entra"])?>
        <br>
        <?=label(icon("fa fa-calendar-o") ." FECHA ",["class" =>"col-lg-4 control-label"])?>
        <div class="col-lg-8">
            <?=input([
                "data-date-format"  =>  "yyyy-mm-dd",
                "name"              =>  'fecha_cordatorio',
                "class"             =>  "form-control input-sm " ,
                "type"				=>  'date',
                "value"             =>  date("Y-m-d"),
                "min"				=>  add_date(date("Y-m-d") , -15),
                "max"				=>  add_date(date("Y-m-d") , 15)
            ])?>
        </div>
        <?=label( icon("fa fa-clock-o") ." HORA",
            ["class" =>	"col-lg-4 control-label"]
        )?>


        <div class="col-lg-8">
            <?=lista_horarios()?>
        </div>
        <?=input_hidden([
            "class" => "recibo",
            "name"	=> "recibo",
            "value"	=> $orden
        ])?>
        <br>
        <?=label(  " TIPO",
            ["class" =>	"col-lg-4 control-label"]
        )?>
        <div class="col-lg-8">
            <?=create_select($tipo_recortario, "tipo", "form-control tipo_recordatorio", "tipo_recordatorio", "tipo" , "idtipo_recordatorio")?>
        </div>
        <?=textarea(["name" => "descripcion" , "class" => "form-control"]);?>
        <?=guardar("CONTINUAR" ,["class" =>"top_20"])?>

    </form>
</div>
<?=place("place_recordatorio")?>