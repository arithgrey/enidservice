<div id='info_antes_de_ayuda'>        
    <div class="col-lg-2">
        <?=heading_enid("TEMAS DE AYUDA" , 3)?>                    
        <?=heading_enid("¿Tienes alguna duda?" , 4)?>    
        <?=p("¡Llámanos! Podemos ayudarte.".icon('fa icon-mobile contact'))?>
        <?=anchor_enid(
            "(55)5296-7027" ,  
            [   
            "class"     => "black strong",
            "target"    => "_blank" ,
            "href"      => "tel:5552967027"
            ])?>        
        <?=div("De Lunes a Viernes de 8:00 a 19:00 y Sábados de 09:00 a 18:00." , 1)?>
        <?=div("Podemos utilizar tu correo para mantenerte informado.." , 1)?>        
        <?=div("O si lo prefieres Comunícate directamente" , 1)?>                    
        <?=anchor_enid(
            "Preguntas frecuentes", 
            ["href" =>   "http://enidservice.com/inicio/faq/?categoria=5"   ],
            1,
            1
        )?>
        
    </div>
    <div class='col-lg-10'>
        <div class="tab-content">            
            <?=place("info_articulo" , ["id"    => 'info_articulo'])?>
            <?=$this->load->view("secciones_2/paginas_web")?>
        </div>
    </div>
</div>        
