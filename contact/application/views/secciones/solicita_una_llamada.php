<div style='background:#0012dd !important;'>
    <div  class="container inner" >
        <div class="row">        
        <div class="col-md-6">
            
        </div>
        <div class="col-md-6">
        <form  id="form_contacto"   action="../msj/index.php/api/emp/contacto/format/json"  method="post">
            <div class="row" id='envio_msj'>
                <div class="col-sm-3">
                    <span class='white strong'>
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
                    <?=span("Nombre")?>
                </div>
                <div class="col-sm-10">
                    <?=input([
                        "type"            => "text" ,
                        "id"              => "nombre" ,
                        "name"            => "nombre" ,
                        "class"           => "input-sm input input_enid" ,
                        "placeholder"     => "Nombre",
                        "value"           => $nombre
                    ])?>
                    
                </div>
            </div>

            <div class="row">
                <div class="col-sm-2">
                    <?=span("Correo")?>
                </div>
                <div class="col-sm-10">
                    <?=input([
                        "onkeypress"    =>  "minusculas(this);",
                        "type"          =>  "email" ,
                        "id"            =>  "emp_email"  ,
                        "name"          =>  "email" ,
                        "value"         =>   $email,
                        "class"         =>  "input-sm input_enid" ,
                        "placeholder"   =>  "Email"
                    ])?>
                
                </div>
                <?=place("place_mail_contacto" , ["id"=>"place_mail_contacto"])?>
            </div>

        <div class="row">
            <div class="col-sm-2">
                <?=span("Teléfono")?>
            </div>
            <div class="col-sm-10">
                <?=input([
                    "id"              =>"tel" ,
                    "name"            =>"tel"  ,
                    "type"            =>"tel" ,
                    "class"           =>"input-sm telefono_info_contacto input_enid" ,
                    "placeholder"     =>"Teléfono  de contacto",
                    "value"           =>$telefono  
                ])?> 
            </div>
            <?=place("place_tel_contacto" ,  ["id"=>'place_tel_contacto'])?>
            
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?=span("Mensaje")?>
            </div>
            <div class="col-sm-12">
            <textarea 
                    id="message" 
                    name="mensaje" 
                    placeholder="Mensaje"> 
            </textarea>
        </div>
        </div>
            <?=place("place_registro_contacto" )?>
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