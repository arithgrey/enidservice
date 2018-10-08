<section id="hero" 
style="background-image: url(../img_tema/portafolio/llamada_gratis_2.png);">
    <div class="container ">
        <div class="row">
            <div class="col-md-3">
                <div style="background: #000 !important;opacity: .85;padding: .1px;opacity: .8">                
                    <ul >                
                        <li> 
                            <?=heading_enid(
                                "SABER MAS SOBRE EVENTOS ESPECIALES" , 
                                3,
                                ["class"=>"white strong"
                            ]);?>
                            <?=$this->load->view("../../../view_tema/social_enid")?>          
                        </li>            
                    </ul>                
                </div>
            </div>    
        </div>
    </div>
</section>
<div style='background:#0012dd !important;'>
    <div  class="container inner" >
        <div class="row">        
        <div class="col-md-6">
            <?=span("Eje Central Lázaro Cárdenas 38, Centro Histórico C.P. 06000 CDMX" , ["class" => "white"])?>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.556617993217!2d-99.14322968509335!3d19.431554086884976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTnCsDI1JzUzLjYiTiA5OcKwMDgnMjcuOCJX!5e0!3m2!1ses!2s!4v1489122764846" width="100%" 
            height="380" frameborder="0" style="border:0" allowfullscreen>
            </iframe>
            <hr>
        </div>
        <div class="col-md-6">
        <form  id="form_contacto"   action="../q/index.php/api/contacto"  method="post">
            <div class="row" id='envio_msj'>
                <?=div(p("Departamento " , ['class'=> 'white'] ) , ["class"=>"col-sm-3"])?>
                <?=div(create_select(
                    $departamentos , 
                    "departamento" , 
                    "departamento form-control input_enid" , 
                    "departamento", 
                    "nombre" , 
                    "id_departamento" ) , ["class"=>"col-sm-9"])?>
                
            </div>
            <div class="row" id='envio_msj' >
                <?=div(p("Nombre" , ['class'=> 'white'] ) , ["class"=>"col-sm-2"])?>
                <?=div(input([
                        "type"            =>   "text" 
                        ,"id"              =>   "nombre" 
                        ,"name"            =>   "nombre" 
                        ,"class"           =>   "input-sm input input_enid" 
                        ,"placeholder"     =>   "Nombre"
                        ,"value"           =>   $nombre
                ]) , ["class" =>  "col-sm-10"])?>
            </div>

            <div class="row">
                <?=div(p("Correo" , ['class'=> 'white'] ) , ["class"=>"col-sm-2"])?>                        
                <?=div(input([
                    "onkeypress"  =>  "minusculas(this);",
                    "type"        =>  "email" ,
                    "id"          =>  "emp_email"  ,
                    "name"        =>  "email" ,
                    "value"       =>  $email ,
                    "class"       =>  "input-sm input_enid" ,
                    "placeholder" =>  "Email"
                ]) , ["class"=>"col-sm-10"])?>
                <?=place('place_mail_contacto',  ["id"=>'place_mail_contacto'])?>
            </div>

        <div class="row">
            <?=div(p("Teléfono" , ['class'=> 'white'] ) ,  ["class"=>"col-sm-2"])?>
            <?=div(input([
                    "id"          => "tel" ,
                    "name"        => "tel"  ,
                    "type"        => "tel" ,
                    "class"       => "input-sm telefono_info_contacto input_enid" ,
                    "placeholder" => "Teléfono  de contacto",
                    "value"       => $telefono
            ]) , ["class"=>"col-sm-10"])?>
            <?=place('place_tel_contacto',  ["id"=>'place_tel_contacto'])?>
        </div>
        <?=n_row_12()?>
            <?=p("Mensaje" , ['class'=> 'white'] )?>
            <textarea  id="message" name="mensaje" placeholder="Mensaje"> 
            </textarea>
        <?=end_row()?> 
        <?=n_row_12()?>
            <?=place("place_registro_contacto")?>            
            <?=guardar("Enviar mensaje",  ["id" =>  'btn_envio_mensaje'])?>
        <?=end_row()?>        
        
    </form>    
    <hr>
    </div>
</section>
