<?php

	$terminos =  create_lista_terminos_servicio_next($terminos_servicio);
	$lista_terminos =  $terminos["html"];
	$num_terminos =  $terminos["num_terminos"];

    $data_info["terminos_servicio"] =  $terminos_enid;
	foreach ($info_servicio as $row) {
		
		$nombre_servicio =  $row["nombre_servicio"];
		$descripcion = $row["descripcion"];
		$fecha_registro = $row["fecha_registro"]; 
		$status =  $row["status"];		
	}
?>

<?php
    
    $id_precio  = "";
    $precio  = "";    
    $id_ciclo_facturacion = "";
    $ciclo = "";
    $flag_meses = "";
    $num_meses = "";

    $iva = 0;
    /*INFO PRECIOS SERVICIO */
    foreach ($precios_servicio  as $row){
        
        $id_precio  =  $row["id_precio"];
        $precio  =  $row["precio"];    
        $id_ciclo_facturacion =  $row["id_ciclo_facturacion"];
        $ciclo =  $row["ciclo"];
        $flag_meses =  $row["flag_meses"];
        $num_meses =  $row["num_meses"];
        
    }
    $iva =  $precio * .16;
    $total = $precio  + $iva;


    $text_meses ="No aplica";
    $text_num_mensualidades =  "No aplica";

    if($flag_meses > 0){
        $text_meses ="Si"; 
        $text_num_mensualidades =  $num_meses;
    }
?>



<div class="row">		
        <div class="receipt-main col-lg-10 col-lg-offset-1">
            <div class="row">
    			
                <div class="receipt-header">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="receipt-left">
							<img class="img-responsive" alt="iamgurdeeposahan" src="../img_tema/enid_service_logo.jpg" style="width: 101px; border-radius: 43px;">
						</div>
					</div>
					
				</div>
            </div>
			
			<div class="row">
				<div class="receipt-header receipt-header-mid">
					
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="receipt-left">
							<h1>
                                <?=$nombre_servicio?>
                            </h1>
                            <div class="strong">
                            	<span>
						        	Ciclo de facturarión <?=$ciclo;?>
						        </span>
							</div>
							<div>
								<div>
									<span>
										<?=$descripcion?>
									</span>
								</div>
								
								<div style="font-size: .8em;">
									Producto/servicio a Meses 
									<strong>
										<?=$text_meses;?>
									</strong>
								</div>
								<div style="font-size: .8em;">
									Mensualidades
									<strong>
										<?=$text_num_mensualidades;?>
									</strong>
								</div>
							</div>


						</div>
					</div>

					<?=n_row_12()?>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div style="background: #d00;">
		                        <span class="white" style="padding: 5px;">
									TÉRMINOS  
		                        </span> 
							</div>
						</div>
					<?=end_row()?>
					<?=n_row_12()?>
						<br>
						<div class="col-xs-12 col-sm-12 col-md-12">							
							<div class="<?=scroll_terminos($num_terminos)?>" >
								<?=$lista_terminos?>
							</div>
						</div>
						<br>
						<div class="col-xs-12 col-sm-12 col-md-12">
							<?=$this->load->view("servicios/nuevos_terminos" , $data_info)?>
						</div>
					<?=end_row()?>
					
				</div>
            </div>		    
        </div>    
	</div>




<style>
        .text-danger strong {

            color: #001ec3;
        }
        .receipt-main {
            background: #ffffff none repeat scroll 0 0;
            border-bottom: 12px solid #333333;
            border-top: 25px solid #001ec3;            
            margin-bottom: 50px;
            padding: 40px 30px !important;
            position: relative;
            box-shadow: 0 1px 21px #acacac;
            color: #333333;
            
        }
        .receipt-main p {
            color: #333333;            
            line-height: 1.42857;
        }
        .receipt-footer h1{            
            font-weight: 400 !important;
            margin: 0 !important;
        }
        .receipt-main::after {
            background: #414143 none repeat scroll 0 0;
            content: "";
            height: 5px;
            left: 0;
            position: absolute;
            right: 0;
            top: -13px;
        }
        .receipt-main thead {
            background: #414143 none repeat scroll 0 0;
        }
        .receipt-main thead th {
            color:#fff;
        }
        .receipt-right h5 {
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 7px 0;
        }
        .receipt-right p {
            font-size: 12px;
            margin: 0px;
        }
        .receipt-right p i {
            text-align: center;
            width: 18px;
        }
        .receipt-main td {
            padding: 9px 20px !important;
        }
        .receipt-main th {
            padding: 13px 20px !important;
        }
        .receipt-main td {
            font-size: 13px;
            font-weight: initial !important;
        }
        .receipt-main td p:last-child {
            margin: 0;
            padding: 0;
        }   
        .receipt-main td h2 {
            font-size: 20px;
            font-weight: 900;
            margin: 0;
            text-transform: uppercase;
        }
        .receipt-header-mid .receipt-left h1 {
            font-weight: 100;
            margin: 34px 0 0;
            text-align: right;
            text-transform: uppercase;
        }
        .receipt-header-mid {
            margin: 24px 0;
            overflow: hidden;
        }
        
        #container {
            background-color: #dcdcdc;
        }
        .terminos_btn:hover{
            cursor: pointer;
        }
</style>
