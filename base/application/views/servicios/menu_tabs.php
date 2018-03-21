      <div style="margin-bottom: 40px;">
        <ul class="nav nav-tabs">
            <li <?=valida_active($num , 1);?> >      
              <center>
                  <a 
                    href="#tab_imagenes"  
                    data-toggle="tab">
                    <i class="fa fa-picture-o">                    
                    </i>
                  </a>
              </center>
            </li <?=valida_active($num , 2);?>>        
                <li <?=valida_existencia_imagenes($imgs)?>>      
                  <center>
                      <a 
                        href="#tab_info_producto" 
                        data-toggle="tab" 
                        id="tab_info_producto_seccion">
                       <i class="fa fa-info"></i>
                      </a>
                  </center>  
                </li>
                <li  <?=valida_active($num , 3);?>  <?=valida_existencia_imagenes($imgs)?>>          
                    <center>
                      <a href="#tab_terminos_de_busqueda"  data-toggle="tab">                
                            <i class="fa fa-fighter-jet">                
                            </i>                
                      </a>
                    </center>
                </li>
                <li  <?=valida_active($num , 4 );?>  <?=valida_existencia_imagenes($imgs)?>>
                    <center>
                      <a href="#tab_info_precios"  data-toggle="tab">
                        <i class="fa fa-credit-card"></i>
                      </a>
                    </center>
                </li>
                <li <?=valida_existencia_imagenes($imgs)?>>
                    <center>
                      <a href="<?=$url_productos_publico?>" target="_blank">
                        <i class="fa fa-shopping-bag">                    
                        </i>
                        <span style="font-size: .9em;">
                            Ir a la publicación
                        </span>
                      </a>
                    </center>
                </li>     
            
        </ul>
      </div>