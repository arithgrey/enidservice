<div style='background:#0012dd !important;'>
    <div  class="container inner" >
        <div class="row">        
            <?=div("" , ["class"=>"col-lg-6"])?>
            <div class="col-lg-6">
                <form  id="form_contacto"   action="../msj/index.php/api/emp/contacto/format/json"  method="post">
                    <div class="row" id='envio_msj'>
                        <?=div( span("Departamento " , ["class"=>'white strong']), ["class"=>"col-sm-3"])?>
                        <?=div(create_select(
                            $departamentos , 
                            "departamento" , 
                            "departamento form-control input_enid" , 
                            "departamento", 
                            "nombre" , 
                            "id_departamento" ), ["class"=>"col-sm-9"])?>
                    </div>
                    <div class="row" id='envio_msj' style="margin-top: 10px;">
                        <?=div(span("Nombre") , ["class"=>"col-sm-2"])?>
                        <?=div(input([
                                "type"            => "text" ,
                                "id"              => "nombre" ,
                                "name"            => "nombre" ,
                                "class"           => "input-sm input input_enid" ,
                                "placeholder"     => "Nombre",
                                "value"           => $nombre
                        ]), ["class"=>"col-sm-10"])?>
                    </div>
                    <div class="row">
                        <?=div(span("Correo") , ["class"=>"col-sm-2"] )?>
                        <?=div(input([
                                "onkeypress"    =>  "minusculas(this);",
                                "type"          =>  "email" ,
                                "id"            =>  "emp_email"  ,
                                "name"          =>  "email" ,
                                "value"         =>   $email,
                                "class"         =>  "input-sm input_enid" ,
                                "placeholder"   =>  "Email"
                        ]), ["class"=>"col-sm-10"])?>
                        <?=place("place_mail_contacto" , ["id"=>"place_mail_contacto"])?>
                    </div>
                    <div class="row">
                        <?=div(span("Teléfono") , ["class"=>"col-sm-2"])?>
                        <?=div(input([
                            "id"              =>"tel" ,
                            "name"            =>"tel"  ,
                            "type"            =>"tel" ,
                            "class"           =>"input-sm telefono_info_contacto input_enid" ,
                            "placeholder"     =>"Teléfono  de contacto",
                            "value"           =>$telefono  
                        ]), ["class" => "col-sm-10"] )?> 
                        <?=place("place_tel_contacto" ,  ["id"=>'place_tel_contacto'])?>
                    </div>
                    <div class="row">
                        <?=div(span("Mensaje") , ["class"=>"col-sm-12"])?>
                        <div class="col-sm-12">
                            <textarea id="message" name="mensaje" placeholder="Mensaje"> 
                            </textarea>
                        </div>
                    </div>
                    <?=place("place_registro_contacto" )?>
                    <div class="row">
                        <?=div(guardar("Enviar mensaje" , ["type"=>"submit" , "class"=>"btn input-sm", "id"=>'btn_envio_mensaje']) ,  
                            ["class"=>"col-lg-6"])?>
                    </div>
                </form>    
                <hr>
            </div>
        </div>
    </div>
</div>
    