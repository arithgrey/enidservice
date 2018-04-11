<div style='background:#0012dd !important;'>
    <div  class="container inner" >
        <div class="row">        
        <div class="col-md-6">
            <span class="white" style="font-size: .9em;">
                Eje Central Lázaro Cárdenas 38, Centro Histórico C.P. 06000 CDMX local número 406
            </span>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.556617993217!2d-99.14322968509335!3d19.431554086884976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTnCsDI1JzUzLjYiTiA5OcKwMDgnMjcuOCJX!5e0!3m2!1ses!2s!4v1489122764846" width="100%" 
            height="380" frameborder="0" style="border:0" allowfullscreen>
            </iframe>
            <hr>
        </div>
        <div class="col-md-6">
        
        
        
        <form  id="form_contacto"   action="../msj/index.php/api/emp/contacto/format/json"  method="post">


            <div class="row" id='envio_msj'>
                <div class="col-sm-3">
                    <span class='white strong' style='font-size:.9em;'>
                        Departamento 
                    </span>
                </div>
                <div class="col-sm-9">
                    <?=create_select(
                            $departamentos , 
                            "departamento" , 
                            "departamento form-control input_enid" , 
                            "departamento", 
                            "nombre" , 
                            "id_departamento" )?>
                </div>
            </div>

            
            <div class="row" id='envio_msj' style="margin-top: 10px;">
                <div class="col-sm-2">
                    <span class='white strong' style='font-size:.9em;'>
                        Nombre
                    </span>
                </div>
                <div class="col-sm-10">
                    <input 
                    type="text" 
                    id="nombre" 
                    name="nombre" 
                    class="input-sm input input_enid" 
                    placeholder="Nombre"
                    value="<?=$nombre?>">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2">
                        <span class='white strong' style='font-size:.9em;'>
                            Correo
                        </span>
                </div>
                <div class="col-sm-10">
                <input 
                    onkeypress="minusculas(this);"
                    type="email" 
                    id="emp_email"  
                    name="email" 
                    value="<?=$email?>" 
                    class="input-sm input_enid" 
                    placeholder="Email">
                </div>
                <div class='place_mail_contacto' id='place_mail_contacto'>
                </div>
            </div>

        <div class="row">
            <div class="col-sm-2">
                <span class='white strong' style='font-size:.9em;'>
                    Teléfono
                </span>
            </div>
            <div class="col-sm-10">
            <input 
            id="tel" 
            name="tel"  
            type="tel" 
            class="input-sm telefono_info_contacto input_enid" 
            placeholder="Teléfono  de contacto"
            value="<?=$telefono?>" 
            >
            </div>
            <div class='place_tel_contacto' id='place_tel_contacto'>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <span class='white strong' style='font-size:.9em;'>
                    Mensaje
                </span>
            </div>
            <div class="col-sm-12">
            <textarea 
            id="message" 
            name="mensaje" 
            placeholder="Mensaje" 
            style="height: 50px!important"> 
            </textarea>
        </div>
        </div>
            <div class='row'>
                <div class='place_registro_contacto'>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-6">
                    <button type="submit" class="btn input-sm" id='btn_envio_mensaje'>
                        Enviar mensaje 
                    </button>
                </div>
                
            </div>
        </form>    
        
<hr>
</div>


</section>


