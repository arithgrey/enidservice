<?=n_row_12()?>
  <p class="white strong" style="font-size: 3em;line-height: .8;background: black;padding: 5px;">
    + Nuevo referido
  </p>        
<?=end_row()?>          
<form class='form_referido' id='form_referido'>  
  <?=n_row_12()?>
      <span class='btn_mostrar_mas_campos mas_campos'>
          Mostrar más campos <?=icon("fa fa-angle-double-down")?>
      </span>
      <span class='btn_mostrar_mas_campos menos_campos' style='display:none;'>
                    Ocultar campos
          <?=icon("fa fa-angle-double-up")?>
          
      </span>
  <?=end_row()?>


    <input type='hidden'  name='referido' value="1">
    <input type='hidden' name="referencia_email" class='referencia_email' value='0'>
    <input type="hidden" name="fuente" value="1">    
    <div class="col-lg-4">
      <span >
        Negocio
      </span>
      
      <?=create_select($tipos_negocios_enid , 
        "tipo_negocio" , 
        "tipo_negocio   form-control" , 
        "tipo_negocio" ,
        "nombre", 
        "idtipo_negocio");?>
      
    </div>
  
    <div class="col-lg-4">
      <span >
        Interés
      </span>
     
        <?=create_select(
          $servicios , 
          "servicio" , 
          "form-control", 
          "selectbasic" , 
          "nombre_servicio" , 
          "id_servicio")?>   
     
    </div>
    <div class="col-lg-4">
      <span >
        Sitio web
      </span>  
      <input id="sitio_web" name="sitio_web" placeholder="http://" class="form-control input-sm" type="text">
    </div>


    <div class="col-lg-4">
      <span >
        Nombres
      </span>      
      <input 
        id="nombre" 
        name="nombre" 
        placeholder="Nombre" 
        class="form-control input-sm" 
        required="" 
        type="text">        
    </div>

    <div class="col-lg-4 campo_avanzado">
      <span >
        A.Paterno
      </span>      
      <input id="apellido_paterno" name="apellido_paterno" placeholder="Primer apellido" class="form-control input-sm" type="text">    
    </div>


    <div class="col-lg-4 campo_avanzado">
      <span >
        A. Materno
      </span>      
      <input id="apellido_materno" name="apellido_materno" placeholder="Segundo apellido" class="form-control input-sm" type="text">        
    </div>

    <div class="col-lg-4">
      <span >
        Tel.
      </span>  
      
      <input id="telefono_info_contacto"  
        name="telefono_contacto" 
        placeholder="(55)" 
        class="form-control telefono_info_contacto input-sm"            
        type="tel"
        required>         
    </div>
  
    <div class="col-lg-4 campo_avanzado">
      <span >
        Tel2.
      </span>      
        <input 
        id="telefono_contacto2" 
        name="telefono_contacto2" placeholder="(55)" class="form-control input-sm" type="tel">        
    </div>

    <div class="col-lg-4">
      <span >
        Correo
      </span>  
      <input id="correo" name="correo" placeholder="@" class="form-control input-sm"  type="email">    
      
    </div>

    <div class="col-lg-4 campo_avanzado" >
      <span >
        Correo2
      </span>      
      <input id="correo2" name="correo2" placeholder="@" class="form-control input-sm"  type="email">      
    </div>
    <!--AGENDAR LLAMADA-->    
    <div class='col-lg-12'>            
        <div class='agendar_llamada_btn'>
            Agendar llamada 
          icon('fa fa-clock-o">
          get_titulo_modalidad                    
        </div>
        <input type='hidden' name='idtipo_llamada' value="1">     
    </div>
    <div class='contenedor_form_agenda'>
      
      
      <?=n_row_12()?>
        <div style='margin-top:10px!important;'>
          <?=$this->load->view("../../../view_tema/inputs_agenda")?>
        </div>
      <?=end_row()?>
    </div>

    <div class="col-lg-12">        
        <span>
          Comentarios
        </span>
        <div style='height:60px; overflow:auto;'>
            <textarea  
              class="form-control"       
              id="comentario" 
              rows="4"
              name="comentario">
            </textarea>
        </div>             
    </div>          
    <?=n_row_12()?> 
      <button class='btn'>
        Registrar 
      </button>      
    <?=end_row()?> 
    <?=n_row_12()?> 
      <div class='place_registro_prospecto'>
      </div>      
    <?=end_row()?> 

</form>                








        









































