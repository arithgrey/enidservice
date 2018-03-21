<form class='text-left form_referido' id='form_referido'>

<div class="row" style="display: none;">
  <div class="col-lg-4">  
      <span class="strong">
        Tipo de contacto
      </span>
      <select class="form-control select_tipo_contactos" name='flag_tipo_persona'>
        <option value='1'>
          Posible cliente
        </option>        
        <option value='7'>
          Contacto
        </option>

      </select>
  </div>
</div>
                                                                
<?=n_row_12()?>
  <span class='btn_mostrar_mas_campos mas_campos'>
      Mostrar más campos 
      <i class="fa fa-angle-double-down">
      </i>
  </span>
  <span class='btn_mostrar_mas_campos menos_campos' style='display:none;'>
      Ocultar campos
      <i class="fa fa-angle-double-up">
      </i>
  </span>                                                                                                        
<?=end_row()?>
            <br>
<div class='row'>
  <input type='hidden'  name='referido' value="1">
  <input type='hidden' name="referencia_email" class='referencia_email' value='0'>
  

  <div class="col-lg-4 seccion_contacto_externo" style="display: none;" >    
    <div>
      <span class="lb_form">
        Tipo contacto
      </span>
      <?=create_select($tipo_contactos_relacion_externa , "tipo_persona" , "form-control",
       "selectbasic" , "tipo" , "idtipo_persona")?>   
    </div>
  </div>
  

  <div class="col-lg-12">     
    <div class="lb_form">
      <label for="tipo_negocio_b">
        Tipo de negocio:
      </label>      
      <input 
      list="info-tipos-negocios" id='tipo_negocio_b' class="form-control tipo_negocio_b" required="">
      <datalist id="info-tipos-negocios">          
      </datalist>
    </div>    
  </div>

  <input type="hidden" name="fuente" value="1" >
  <input type="hidden" name="servicio" value="21" >
  <input type="hidden" name="tipo_negocio" value='0' class="tipo_negocio">      
  

  
  

  

  <div class="col-lg-4">    
    <div>
      <span class="lb_form">
        Nombres
      </span>  
      <input id="nombre" name="nombre" placeholder="Nombre" class="form-control input-sm" required="" type="text">    
    </div>
  </div>

  <div class="col-lg-4 campo_avanzado">        
      <span class="lb_form">
        A. Paterno
      </span>  
      <input id="apellido_paterno" name="apellido_paterno" placeholder="Primer apellido" class="form-control input-sm" type="text">        
  </div>
  <div class="col-lg-4 campo_avanzado">    
    <div>
      <span class="lb_form">
        A. Materno
      </span>  
      <input id="apellido_materno" name="apellido_materno" placeholder="Segundo apellido" class="form-control input-sm" type="text">    
    </div>
  </div>
  <div class="col-lg-4">    
    <div>
      <span class="lb_form">
        Tel.
      </span>  
      <input         
        id="telefono_info_contacto"  
        name="telefono_contacto" 
        placeholder="(55)" 
        class="form-control telefono_info_contacto input-sm"            
        type="tel"
        required>      
    </div>
  </div>
  <div class="col-lg-4 campo_avanzado">  
    <div>
      <span class="lb_form">
        Tel2.
      </span>  
      <input 
      id="telefono_contacto2" 
      name="telefono_contacto2" placeholder="(55)" class="form-control input-sm" type="tel">    
    </div>
  </div>
  <div class="col-lg-4">    
    <div>
      <span  class="lb_form">
        Correo
      </span>  
      <input 
        id="correo" 
        name="correo" 
        placeholder="@" 
        class="form-control input-sm correo"  
        type="email" 
        required>    
    </div>
  </div>
  <div class="col-lg-4 campo_avanzado">  
    <div>
      <span class="lb_form">
        Correo2
      </span>  
      <input id="correo2" name="correo2" placeholder="@" class="form-control input-sm"  type="email">    
    </div>
  </div>
  <div class="col-lg-12 campo_avanzado">  
    <div>
      <span class="lb_form">
        Sitio web  
      </span>  
      <input 
          id="sitio_web" name="sitio_web" placeholder="www" class="form-control input-sm" 
          type="text">      
    </div>
  </div>



  <!--AGENDAR LLAMADA-->    

  <div style="display: none;">
    <div class='col-lg-12'>            
        <div class='agendar_llamada_btn'>
            Agendar llamada 
          <i class="fa fa-clock-o" aria-hidden="true">
          </i>                    
        </div>
        <input type='hidden' name='idtipo_llamada' value="1">     
    </div>
    <div class='contenedor_form_agenda'>
      <br>
      <br>
      <?=n_row_12()?>
        <div style='margin-top:10px!important;'>
          <?=$this->load->view("../../../view_tema/inputs_agenda")?>
        </div>
      <?=end_row()?>
    </div>
  </div>


    <div class="col-lg-12" style="display: none;">        
        <span>
          Comentarios
        </span>     
        <div id="summernote" class="summernote">        
        -
        </div>   
        
        <textarea  
          class="form-control"       
          id="comentario" 
          rows="4"
          name="comentario"
          style="display: none;" 
          >
        </textarea>        
    </div>      
    <div class="col-lg-12">        
      <button class='btn'>
        Registrar 
      </button>      
        <div class='place_registro_prospecto'>
        </div>      
    </div>
</div>
            
</form>                


<style type="text/css">
  .lb_form{
    font-size: .8em;
  }
</style>
