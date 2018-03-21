<form class="well" 
      id="eleccion-correos"
      style="background: #fff!important;" 
      action="../procesar" method="GET">
          <div class="row">
            <div class="col-lg-12">
              <span class="white strong" style="background: #038798;padding: 5px;">
                Ordenar compra en línea 
              </span>            
            </div>
            <br>
            <div class="col-lg-6">          
              <input type="hidden" name="producto" value="Correo comercial">
              <label>
                Tipo 
              </label>  

              <?=create_select($planes_correos , 
                "plan", 
                "form-control plan", 
                "plan", 
                "nombre_servicio" , 
                "id_servicio" );?>                    
            </div>      
            <div class="col-lg-6">
              <label>
                DURACIÓN
              </label>
              <input type="hidden" name="ciclo_facturacion" value="1">
              <input type="hidden" name="is_servicio" value="1">
              <select id="num_ciclos" name="num_ciclos" class="form-control num_ciclos">
                <option value="1">
                  12 Meses 
                </option>
                <option value="2">
                  24 Meses 
                </option>
                <option value="3">
                  36 Meses 
                </option>
              </select>
            </div>    
            <div class="col-lg-12">
              <label>
                TOTAL EN MXN
              </label>
              <input type="" name="total" class='total' readonly="">              
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
                <span class="text_recomendacion blue_enid_background white strong" 
                      style="font-size: .8em;padding: 5px;">
                </span>
            </div>
          </div>

          <div style="margin-top: 30px;">      
          </div>
            <div class="row">

              
              <div class="col-md-12">

                <table width="100%">
                  <tr>
                    <td>
                     
                      <span>www.</span>
                    </td>
                    <td>                  
                        <input type="text" name="dominio" class='input-sm input' required="" placeholder="Aquí tu negocio">
                    </td>



                    <td>
                <select name="extension_dominio" class="form-control">
                  <option value=".com.mx" selected="selected">.com.mx</option>
                  <option value=".com">.com</option>
                  <option value=".mx">.mx</option>
                  <option value=".net">.net</option>
             
                </select> 
                    </td>


                  </tr>
                </table>
                  
                  

                           
              </div>  

              <div class="col-md-12">
                <button class="btn btn-primary input-sm" type="submit">
                  Iniciar compra
                </button>
              </div>
            </div>
                      
            
      

      
</form>




<a 
href="../contacto/#envio_msj" 
style="font-size: .9em;color: white!important;" 
class="strong white">        
Ó Solicita una visita en tu negocio 
</a>