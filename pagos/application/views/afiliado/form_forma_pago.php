<?php

    $id_cuenta_pago =  "";
    $numero_tarjeta = "";
    $propietario_tarjeta = "";
    $id_banco_registrado = 0;
    $nombre = "";

    foreach ($forma_pago as $row) {
            
        $id_cuenta_pago =  $row["id_cuenta_pago"];
        $numero_tarjeta =  $row["numero_tarjeta"];
        $propietario_tarjeta =  $row["propietario_tarjeta"];
        $id_banco_registrado =  $row["id_banco"];
        $nombre = $row["nombre"];
    }    
?>


<?php
        
    $opcions = "";    
    foreach($bancos as $row){
            
        $id_banco = $row["id_banco"]; 
        $nombre = $row["nombre"];    
        $imagen = $row["imagen"];

        if ($flag_registro_previo == 1 ){        

            if ($id_banco ==  $id_banco_registrado ){
                $opcions .= "<option value='".$id_banco."' selected>".$nombre."</option>";         
            }else{
                $opcions .= "<option value='".$id_banco."' >".$nombre."</option>";     
            }                
        }else{

            $opcions .= "<option value='".$id_banco."' >".$nombre."</option>";    
        }        
    }
    /**/
    $nombre_persona ="";    
    foreach ($usuario as $row){        
        $nombre_persona = $row["nombre"] . " ". $row["apellido_paterno"] ." " .$row["apellido_materno"];
    }
    /**/
?>



<?=n_row_12()?>
    
<div class="col-lg-10 col-lg-offset-1" >
    <div class="panel panel-default" >
      <div class="panel-leftheading">
            <p class="strong">
               Cuenta registrada     
            </p>
      </div>
      <div class="panel-rightbody">          
          <div class="col-lg-3">
              <?=valida_imagen_banco_pago(
                $id_banco_registrado , 
                $flag_registro_previo)?>                         
          </div>
          <div class="col-lg-4">
                <div>
                    <span style="font-size: .8em;">
                        <?=valida_numero_tarjeta(
                        $numero_tarjeta, 
                        $flag_registro_previo)?>
                    </span>
                </div>
                <div>
                    <span style="font-size: .8em;">
                        <?=valida_nombre_propietario(
                            $flag_registro_previo ,  
                            $nombre_persona ,
                            $propietario_tarjeta )?>
                    </span>
                </div>
          </div>          
      </div>        
    </div>
</div>        
<?=end_row()?>
<hr>

<?=n_row_12()?>
    
    <div class="col-lg-10 col-lg-offset-1">
            
            <div>
                <strong>
                    Actualizar
                </strong>
            </div>
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse0" 
                                style="background: #004fb6;color: white;">
                                <div class="row">
                                    <div class="col-md-1">
                                            <div class="step s0">1
                                            </div>
                                    </div>
                                    <div class="col-md-11 step-text white">
                                        Selecciona el banco donde realizaremos tu pago 
                                        <span class="place_banco"></span>
                                    </div>
                                </div>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse0" class="panel-collapse collapse in">
                        <div class="panel-body" style="background: white;">
                        <div class="line-wizard l1">
                        </div>
                            <div class="row">


                                     <?=n_row_12()?>
                                        <div class="col-lg-9"></div>
                                        <div class="col-lg-3">
                                            <div class="place_imagen_banco">   
                                                <?=valida_imagen_banco_pago(
                                                        $id_banco_registrado , 
                                                        $flag_registro_previo)?>         
                                            </div>
                                        </div>                                    
                                    <?=end_row()?>    

                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-11 step-text">
                                    <div class="form-group">
                                    <select class="form-control banco_cuenta" id="sel1"  >
                                        <option value="0">Seleccione un banco ...  </option>
                                        <?=$opcions?>
                                    </select>
                                    </div>
                                    <div class="row pull-right">
                                        <div class="col-md-1">
                                            <div class ="step-fll-prev step-prev prev" num-step="0">
                                                <i class="fa fa-angle-left" aria-hidden="true">
                                            </i>
                                        </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                        <div class="col-md-1 siguiente_banco">
                                            <div class ="step-fll-prev step-fll next" num-step="0">
                                                <i class="fa fa-angle-right " aria-hidden="true" >
                                            </i>
                                        </div>
                                        </div>
                                    </div>
                                    
                                    
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" 
                            style="background: #004fb6;color: white;">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="step s1">2</div>
                                </div>
                                    <div class="col-md-11 step-text white">
                                        Indicanos a que número de cuenta podemos depositarte                                         
                                        <span class="place_numero_tarjeta">             
                                        </span>    
                                    </div>
                                </div>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                        <div class="panel-body" style="background: white;">
                            <div class="line-wizard l2">
                            </div>
                                <div class="row">

                                    <?=n_row_12()?>
                                        <div class="col-lg-9"></div>
                                        <div class="col-lg-3">
                                            <img src="../img_tema/bancos/numero_tarjeta.png" style="width:100%">
                                        </div>
                                        

                                    <?=end_row()?>    

                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-11 step-text">
                                        <div class="form-group">
                                            <input 
                                                class="form-control numero_tarjeta" 
                                                id="input-1" 
                                                name=""                                        
                                                value="<?=valida_numero_tarjeta($numero_tarjeta, $flag_registro_previo)?>" 
                                                placeholder="Número cuenta donde depositarte">
                                            
                                        </div>
                                        <div class="row pull-right siguiente_numero_tarjeta">
                                            <div class="col-md-1">
                                                <div class ="step-fll-prev step-prev prev" num-step="1">
                                                    <i class="fa fa-angle-left" aria-hidden="true">
                                                </i>
                                            </div>
                                            </div>
                                            <div class="col-md-1">
                                            </div>
                                            <div class="col-md-1">
                                                <div class ="step-fll-prev step-fll next" num-step="1">
                                                    <i class="fa fa-angle-right" aria-hidden="true" >
                                                </i>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a  
                                style="background: #004fb6;color: white;"
                                data-toggle="collapse" data-parent="#accordion" href="#collapse2" >
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="step s3">3</div>
                                </div>
                                    <div class="col-md-11 step-text white">

                                        Confirma el titular a quien depositaremos 
                                        <span class="place_propietario_tarjeta">
                                            
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <div class="panel-body" style="background: white;">
                            <div class="line-wizard l3">
                            </div>
                                <div class="row">
                                    <div class="col-md-1">
                                    </div>
                                        <div class="col-md-11 step-text">
                                            <div class="form-group">
                                                <input 
                                                    class="form-control propietario" 
                                                    id="input-1" 
                                                    type="text" 
                                                    value="<?=valida_nombre_propietario(
                                                            $flag_registro_previo ,  
                                                            $nombre_persona ,
                                                            $propietario_tarjeta )?>"
                                                    placeholder="Propietario de la cuenta">
                                            </div>
                                            <div class="row pull-right">
                                            <div class="col-md-5">
                                                <button 
                                                    
                                                    type="button"
                                                    class="btn btn-primary actualizar_form"
                                                     style="background: #02142f!important">            
                                                    Actualizar 
                                                </button>
                                            </div>
                                            <div class="col-md-5">
                                                <button type="button" class="btn btn-secondary">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>
<?=end_row()?>




<style type="text/css">
    .step {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-family: 'SansaPro-SemiBold';
    font-size: 25px;
    color: #fff;
    line-height: 50px;
    text-align: center !important;
    background: #FF0000;
    transition: all 1s;
}

.step-ok {
    width: 50px; 
    height: 50px;
    border-radius: 50%;
    font-family: 'SansaPro-SemiBold';
    font-size: 25px;
    color: #fff;
    line-height: 50px;
    text-align: center !important;
    background: #39B54A;
}

.step-fll-prev {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-family: 'SansaPro-Bold';
    font-size: 30px !important;
    text-align: center !important;
    cursor: pointer;
}

.step-fll {
    color: #fff;
    background: #283897;
    margin-left: 3px;
    line-height: 38px;
}

.step-prev {
    color: #283897;
    background: #FFF;
    border-width: 2px;
    border-style: solid;
    border-color: #283897;
    margin-left: -5px;
    line-height: 35px;
}

.step-fll-prev i {
    font-size: 30px !important;
}

.step-text {
    /*font-family: 'SansaPro-SemiBold';*/
    font-size: 15px;
    padding-left: 46px;
    padding-top: 5px;
}

.panel-default {
    border-color: transparent;
}

.panel {
    margin-bottom: 20px;
    background-color: transparent;
    border: 0px solid transparent;
    border-radius: 4px;
    -webkit-box-shadow: 0 0px 0px rgba(0,0,0,0.05);
    box-shadow: 0 0px 0px rgba(0,0,0,0.05);
}

.panel-default>.panel-heading {
    color: #333;
    background-color: transparent;
    border-color: transparent;
}

.panel-group .panel-heading+.panel-collapse .panel-body {
    border-top: 0px solid #ddd;
}

.line-wizard {
    position: absolute;
    width: 2px;
    background-color: #CCCCCC;
    z-index: -1;
}

.l1 {
    height: 214px;
    margin-top: -44px;
    margin-left: 25px;
}

.l2 {
    height: 217px;
    margin-top: -45px;
    margin-left: 25px;
}

.l3 {
    height: 131px;
    margin-top: -199px;
    margin-left: 25px;
}
</style>

<br>
<br><br><br><br><br><br><br>