 <?=n_row_12()?>                                    
  <p 
    class="white strong" 
    style="font-size: 3em;line-height: .8;
    background: black;padding: 5px;">                        
    Perfiles / permisos
  </p>                      
<?=end_row()?>


<?=n_row_12()?>  
  <br>                  
  <div class="row">
    <div class="col-lg-3" >       
        <nav class="nav-sidebar">
            <ul class="nav tabs">                                  
                <h2 
                  class="blue_enid_background white" 
                  style="padding: 10px;">
                    <i class="fa fa-space-shuttle" >
                    </i>
                    Perfil
                </h2>                                  
                <li>                                      
                  <?=create_select($perfiles_enid_service , "perfil" , "form-control perfil_enid_service" , "perfil_enid_service" , "nombreperfil" , "idperfil" )?>
                </li>
            </ul>
        </nav>        
    </div>
                    
    <div class='col-lg-9'>
        <div class="tab-content">                            
            <div class="tab-pane active " id="sec_0">      
              <h2 class="blue_enid_background white" 
                  style="padding: 10px;">
                  Recurso
              </h2>
              <a href="#tab_agregar_recursos"
                data-toggle="tab" 
                style="background: black!important;" 
                class="btn input-sm">
                + Agregar Recurso
              </a>
              <div class="place_perfilles_permisos">
              </div>
            </div>                            
        </div>
    </div>
  </div>           
<?=end_row()?>  
