<div class='col-lg-12'>
  <div class="container">
   <div class="row"  style="margin-top:20px;">
          <div>
              <div class="btn-group date-block "
               data-toggle="buttons">
                  <label href="#mensajeria_email" data-toggle="tab" 
                  class="btn date-buttons btn-default text-right semiBold btn_correo_e" 
                  style="background:#04213B!important;" >
                      <i class="fa fa-envelope-o">
                      </i>                                    
                  </label>
                  <label href="#mensajeria_facebook" data-toggle="tab" 
  	                class="btn btn-default  next font-small semiBold btn_tareas_fb" title="" 
  	                style="background:#04213B!important;">
                     <i class="fa fa-facebook-official"></i>
                     	
                  </label>
                  <label  href="#profile" data-toggle="tab" 
                  class="btn btn-default previous text-right font-small semiBold btn_tareas_mercado_libre" title="" 
                  style="background:#04213B!important;">
                      <i class="fa fa-shopping-bag"></i>
                      
                  </label>
                  
                  <label href="#contact" data-toggle="tab" 
                  class="btn date-buttons btn-default text-right semiBold" 
                  style="background:#04213B!important;">
                      <i class="fa fa-linkedin-square"></i>
                      
                  </label>

                  <label href="#education" data-toggle="tab" 
                  class="btn date-buttons btn-default text-right semiBold" 
                  style="background:#04213B!important;">
                      <i class="fa fa-twitter"></i>
                      
                  </label>
                  <label href="#my_blog" data-toggle="tab" 
                  class="btn date-buttons btn-default text-right semiBold" 
                  style="background:#04213B!important;">
                    <i class="fa fa-rss" >
                    </i>
                      Blog
                  </label>
              </div>          
          </div>
          <div id="myTabContent" class="tab-content">            
              <div class="tab-pane fade active in" id="mensajeria_email">
                <?=$this->load->view("secciones/tareas_sociales/email")?>            
              </div>
              <div class="tab-pane fade" id="mensajeria_facebook">
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
            <div class="tab-pane fade" id="my_blog">
              <?=$this->load->view("secciones/tareas_sociales/blog")?>            
            </div>           

          </div>
      </div>
  </div>
</div>