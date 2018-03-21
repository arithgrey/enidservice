<div style="background: white;padding: 5px;">
  <?=n_row_12()?>    
    
    
      <div class="modo_servicios_enid">
        <div>
            <span class="strong modo_servicios " style="font-size: .8em!important;">
                Promover servicios
                <i class="fa fa-chevron-right">          
                </i>
            </span>        
        </div>
        <div>
            <p class="white strong" 
            style="font-size: 2em;line-height: .8;background: black;padding: 5px;"> 
              Productos              
            </p>      
        </div>
        
        

      </div>

      <div class="modo_productos_enid" style="display: none;">      
          <div>          
            <span class="strong modo_productos " style="font-size: .8em!important;" >
              Promover productos
              <i class="fa fa-chevron-right">          
              </i>
            </span>      
          </div>      
          <div>
              <p class="white strong blue_enid_background2 " style="font-size: 2em;line-height: .8;padding: 5px;"> 
                Servicios                
              </p>                    
          </div>
          
      </div>
      




      <div class="row">
          <br>
          <div class="col-lg-6">


            <div class="form-group">
              
              <div>
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-search"></i>
                  </span>
                  <input id="prependedtext" name="prependedtext" class="form-control keyword" placeholder="Mensaje, producto, servicio" type="text">
                </div>
                
              </div>
            </div>

                   
          </div>        
          <div class="col-lg-6">
            <div class="btn-group" style="width: 100%">                    
              
              <div style="border-style: solid;border-width: 1px;padding: 1px;background: white;">
                <label 
                  title="Actividad en Facebook" 
                  href="#mensajeria_facebook" 
                  data-toggle="tab" 
                  class=" btn_tareas_fb active m_facebook blue_active">
                  <i class="fa fa-facebook-official">                       
                  </i>                      
                </label>

                <label  
                  title="Actividad en Mercado libre" 
                  href="#profile" data-toggle="tab" 
                  class=" btn_tareas_mercado_libre m_mercado_libre">
                  <i class="fa fa-shopping-bag">                        
                  </i>                      
                </label>
                              
                <label 
                  title="Actividad en Linkeding" 
                  href="#contact" 
                  data-toggle="tab" 
                  class=" btn_tareas_linkedin m_linkedin" 
                  >
                  <i class="fa fa-linkedin-square">                        
                  </i>                      
                </label>

                <label 
                  title="Actividad en Twitter" 
                  href="#education" 
                  data-toggle="tab" 
                  class=" btn_tareas_twitter m_twitter" 
                  >
                  <i class="fa fa-twitter">                        
                  </i>                      
                </label>

                <label 
                  title="Actividad en Gplus" 
                  href="#tab_gplus" 
                  data-toggle="tab" 
                  class=" btn_tareas_gplus m_gplus">
                  <i class="fa fa-google-plus">                        
                  </i>                      
                </label>

                <label 
                  title="Actividad en Pinterest" 
                  href="#tab_pinterest" 
                  data-toggle="tab" 
                  class=" btn_tareas_pinterest m_pinteres" 
                  >
                  <i class="fa  fa-pinterest">                        
                  </i>                      
                </label>

                <label 
                  title="Actividad en Instagram" 
                  href="#tab_instagram" 
                  data-toggle="tab" 
                  class=" btn_tareas_instagram m_instagram">
                  <i class="fa fa-instagram">                        
                  </i>                      
                </label>
                <label 
                  title="Actividad en email " 
                  href="#tab_email" 
                  data-toggle="tab" 
                  class="btn_tareas_email m_email">
                  <i class="fa fa-envelope">              
                  </i>
                </label>

                <label 
                  title="Actividad en email " 
                  href="#tab_whatsapp" 
                  data-toggle="tab" 
                  class="btn_tareas_whatsapp m_whatsapp">
                  <i class="fa fa-whatsapp">              
                  </i>
                </label>

                <label 
                  title="Actividad en email " 
                  href="#tab_tumlr" 
                  data-toggle="tab" 
                  class="btn_tareas_tumblr m_tumblr">
                  <i class="fa fa-tumblr" aria-hidden="true"></i>
                </label>
              
              </div>
            </div>                          
          </div>
          
        </div>
      
      <?=n_row_12()?>  
        <div class="tab-content"> 


                                      
            <div class="tab-pane  active" id="mensajeria_facebook">                    
              <?=$this->load->view("secciones/tareas_sociales/facebook")?>            
            </div>
            <div class="tab-pane fade" id="profile">
                  <?=$this->load->view("secciones/tareas_sociales/mercado_libre")?>            
            </div>                
            <div class="tab-pane fade" id="contact">
                <?=$this->load->view("secciones/tareas_sociales/linkeding")?>            
            </div>
            <div class="tab-pane fade" id="education">
              <?=$this->load->view("secciones/tareas_sociales/twitter")?>            
            </div>           
            <div class="tab-pane fade" id="tab_gplus">
              <?=$this->load->view("secciones/tareas_sociales/g_plus")?>            
            </div>                             
            <div class="tab-pane fade" id="tab_pinterest">
              <?=$this->load->view("secciones/tareas_sociales/pinterest")?>            
            </div>                  
            <div class="tab-pane fade" id="tab_instagram">
              <?=$this->load->view("secciones/tareas_sociales/instagram")?>            
            </div>
            <div class="tab-pane fade" id="tab_email">
              <?=$this->load->view("secciones/tareas_sociales/email")?>            
            </div>
            <div class="tab-pane fade" id="whatsapp">
              <?=$this->load->view("secciones/tareas_sociales/whatsapp")?>            
            </div>
             <div class="tab-pane fade" id="tumblr">
              <?=$this->load->view("secciones/tareas_sociales/tumblr")?>            
            </div>      
        </div>     
      <?=end_row()?>                                           
      
    

  <?=end_row()?>
</div>
<style type="text/css">
.btn_social_fb,
.btn_img_social{
  display: inline-block;
}
.btn_social_fb,
.btn_img_social{
  display: inline-block;
}
.btn_social_fb,
.btn_img_social{
  display: inline-block;
}
.btn_social_fb,
.btn_img_social{
  display: inline-block;
}
.btn_social_fb,
.btn_img_social{
  display: inline-block;
}
.btn_social_fb,
.btn_img_social{
  display: inline-block;
}.blue_active{
  background: #0254bd !important;
  padding: 5px;
  color: white;
}
.place_mensaje_mensaje_social{
  background: #0254bd !important;
  padding: 5px;
  color: white;
}
/**/
.busqueda_avanzada:hover{
  cursor: pointer;
}.modo_productos:hover{
    cursor: pointer;
}
.modo_servicios:{
  cursor: pointer;
}
</style>