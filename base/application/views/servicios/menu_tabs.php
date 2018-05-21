      <div style="margin-bottom: 40px;"></div>
      <ul class="nav nav-tabs">
              <li <?=valida_active($num , 1);?> >                    
                  <a 
                    href="#tab_imagenes"  
                    data-toggle="tab">
                    <i class="fa fa-picture-o">                    
                    </i>
                  </a>
              </li>        
              <li  <?=valida_active($num , 4 );?>  <?=valida_existencia_imagenes($imgs)?> >
                      <a href="#tab_info_precios"  data-toggle="tab">
                        <i class="fa fa-credit-card"></i>
                      </a>
                   
              </li>
              <li <?=valida_existencia_imagenes($imgs)?>>      
                      <a 
                        href="#tab_info_producto" 
                        data-toggle="tab" 
                        id="tab_info_producto_seccion">
                        <i class="fa fa-info"></i>
                      </a>
              </li>

              <li  <?=valida_active($num , 3);?>  
                    <?=valida_existencia_imagenes($imgs)?>>          
                      <a href="#tab_terminos_de_busqueda"  
                      
                      data-toggle="tab">                
                            <i class="fa fa-fighter-jet">                
                            </i>                
                      </a>
              </li>
                
              <li <?=valida_existencia_imagenes($imgs)?> >                    
                      <a href="<?=$url_productos_publico?>" target="_blank"
                        style='background: black;color: white!important;'>
                        <i class="fa fa-shopping-bag">                    
                        </i>
                        <span style="font-size: .9em;">
                            VER PUBLICACIÓN
                        </span>
                      </a>                   
              </li>                 
      </ul>
      