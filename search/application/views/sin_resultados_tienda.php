<main>
  <div class="contenedor_principal_enid_service">
    <?=n_row_12()?>    
      <div class="separador_inicial"></div>
    <?=end_row()?>
    <?=n_row_12()?>          
      <div class="col-lg-6  col-lg-offset-3">
        <center>
          <?=heading_enid("AÚN NO HAS ANUNCIADO PRODUCTOS EN TU TIENDA" , 
          1 , 
          ['class' =>'strong']
          , 
          1)?> 
                 
        <?=div(
          anchor_enid("ANUNCIA TU PRIMER PRODUCTO AQUÍ".icon('fa fa-chevron-right ir'),
          ["href"  =>  "../planes_servicios/?action=nuevo",
            "class" =>  "a_enid_black2 boton_primer_producto",
            "style" =>  "color: white!important"
          ] ,
          1,
          1)
        );?>
        
        </center>
      </div>
    <?=end_row()?>
    <?=place("separador_final")?>
    
  </div>
</main>