<div style="background: white;padding: 5px;">
  <?=n_row_12()?>    
    <div class="modo_servicios_enid">
      <?=div("Promover servicios".icon('fa fa-chevron-right') ,
      [
        "class" =>  "modo_servicios "
      ])?>
      <?=div(p("Productos" , 
      [
        "style"=>"font-size: 2em;line-height: .8;background: black;padding: 5px;"
      ]))?>  
        
    </div>

    <div class="modo_productos_enid" style="display: none;">      
      <?=div("Promover productos" . icon('fa fa-chevron-right') , 
        [
          "class" =>  "strong modo_productos "
        ])?>
      <?=div("Servicios" , 
        [
          "class" =>  "white strong blue_enid_background2 " ,
          "style" =>  "font-size: 2em;line-height: .8;padding: 5px;"
        ])?>          
    </div>
     
      <div class="row">          
          <div class="col-lg-6">
            <div class="form-group">              
                <div class="input-group">
                  <?=span(icon('fa fa-search') , 
                  [
                    "class" =>  "input-group-addon"
                  ])?>
                  
                  <?=input([

                    "id"            =>  "prependedtext" ,
                    "name"          =>  "prependedtext" ,
                    "class"         =>  "form-control keyword" ,
                    "placeholder"   =>  "Mensaje, producto, servicio" ,
                    "type"          =>  "text"
                  ])?>                  
                </div>            
            </div>      
          </div>        
          <div class="col-lg-6">
            <div class="btn-group" style="width: 100%">                                  
              <div style="border-style: solid;border-width: 1px;padding: 1px;background: white;">
                
                <?=label(
                  icon('fa fa-facebook-official'),
                  [
                    "href"        =>  "#mensajeria_facebook" ,
                    "data-toggle" =>  "tab" ,
                    "class"       =>  " btn_tareas_fb active m_facebook blue_active"
                ])?>

                <?=label(icon('fa fa-shopping-bag') ,  
                [
                  "href"          =>  "#profile" ,
                  "data-toggle"   =>  "tab" ,
                  "class"         =>  " btn_tareas_mercado_libre m_mercado_libre"
                ])?>
                
                <?=label(
                  icon('fa fa-linkedin-square'),
                  [
                    "href"          =>  "#contact" ,
                    "data-toggle"   =>  "tab" ,
                    "class"         =>  " btn_tareas_linkedin m_linkedin" 
                ])?>
                                              
                <?=label(icon('fa fa-twitter') , 
                [
                  "href"            =>  "#education" ,
                  "data-toggle"     =>  "tab" ,
                  "class"           =>  " btn_tareas_twitter m_twitter" 
                ])?>

                <?=label(icon('fa fa-google-plus') , 
                [
                  "href"            =>  "#tab_gplus" ,
                  "data-toggle"     =>  "tab" ,
                  "class"           =>  " btn_tareas_gplus m_gplus" 
                ])?>
                

                <?=label(icon('fa  fa-pinterest') , 
                [
                  "href"            =>  "#tab_pinterest" ,
                  "data-toggle"     =>  "tab" ,
                  "class"           =>  " btn_tareas_pinterest m_pinteres" 
                ])?>
                
                <?=label(icon('fa fa-instagram') , 
                [
                  "href"            =>  "#tab_instagram" ,
                  "data-toggle"     =>  "tab" ,
                  "class"           =>  " btn_tareas_instagram m_instagram" 
                ])?>
                
                <?=label(icon('fa fa-envelope') , 
                [
                  "href"            =>  "#tab_email" ,
                  "data-toggle"     =>  "tab" ,
                  "class"           =>  "btn_tareas_email m_email" 
                ])?>
                
                
                <?=label(icon('fa fa-whatsapp') , 
                [
                  "href"            =>  "#tab_whatsapp" ,
                  "data-toggle"     =>  "tab" ,
                  "class"           =>  "btn_tareas_whatsapp m_whatsapp" 
                ])?>

                <?=label(icon('fa fa-tumblr') , 
                [
                  "href"            =>  "#tab_tumlr" ,
                  "data-toggle"     =>  "tab" ,
                  "class"           =>  "btn_tareas_tumblr m_tumblr" 
                ])?>
                            
              
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
