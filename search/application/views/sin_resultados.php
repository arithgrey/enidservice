<main>
  <div class="contenedor_principal_enid_service">
    <?=place("separador_inicial")?>
    <?=n_row_12()?>    
      <div class="inf_sugerencias">
        <?=heading_enid("NO HAY PRODUCTOS QUE COINCIDAN CON TU BÚSQUEDA" , 3 , ["class"=>"info_sin_encontrar"])?>
        <?=div("SUGERENCIAS" , ["class"=>"contenedor_sugerencias sugerencias"])?>
        <div class="info_sugerencias">
          <ul>
            <li>
              - REVISA LA
              <?=strong("ORTOGRAFÍA DE LA PALABRA")?>
            </li>
            <li>            
              - UTILIZA PALABRAS
              <?=strong("MÁS SIMPLES")?>
            
            </li>
            <li>
              - NAVEGA POR CATEGORÍAS
            </li>
            <li class="anunciar_btn">
                <?=anchor_enid("ANUNCIA ESTE PRODUCTO!" .icon('fa fa-chevron-right ir') , 
                  [ "href"  =>  "../login",
                   "class"  =>  "a_enid_black2"
                 ],
                 1,
                 1)?>
            </li>
          </ul>
        </div>        
      </div>
    <?=end_row()?>
    <?=n_row_12()?>    
      <div class="separador_final"></div>
    <?=end_row()?>
  </div>
</main>