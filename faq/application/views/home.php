<?=n_row_12()?>
	<div class="contenedor_principal_enid">
		<div class='row' id='info_antes_de_ayuda' style="background: white!important;">
		    <div class='container'>      
		        <div class="row">
		            <div class="col-lg-2">
		                <div class="row">
		                    <?=$this->load->view("../../../view_tema/izquierdo.php")?>
		                </div>
		            </div>            
		            <div class='col-lg-10'>
		                <div class="tab-content">
		                    <div class="tab-pane active text-style" id="tab1">                                        
		                        <?=n_row_12()?>
		                                <div class="row" >
		                                    <div  class="col-lg-10 col-lg-offset-1">
		                                        <div class="panel-heading">
		                                            <ul class="nav nav-tabs">
		                                                <li>
		                                                    <?=anchor_enid("CATEGORIAS" , 
		                                                    ["href"=>"../faq" , "class"=>"text_categorias" ])?>
		                                                </li>
		                                                <li class="active li_menu">  
		                                                    <?=anchor_enid(
		                                                    	icon("fa fa-question-circle") . 
		                                                    	"Preguntas frecuentes" , 
		                                                    [
		                                                        "href"          =>  "#tab1default" ,
		                                                        "class"         =>  "black strong" ,
		                                                        "data-toggle"   =>  "tab"
		                                                    ] )?>                                                    
		                                                </li>
		                                                <?=get_btn_registro_faq($in_session , $perfil);?>     
		                                            </ul>
		                                        </div>
		                                        <div class="panel-body">
		                                            <div class="tab-content">
		                                                <?=place("" , ["id" => "info_articulo"])?>        
		                                                <div class="tab-pane fade in active" id="tab1default">
		                                                    <?=$this->load->view("secciones_2/principal_faqs")?>
		                                                </div>
		                                                <div class="tab-pane fade" id="tab2default">
		                                                    <?php if ($in_session ==  1) {
		                                                        $this->load->view("secciones_2/form"); 
		                                                    }?>   
		                                                </div>                                              
		                                            </div>
		                                        </div>      
		                                    </div>
		                                </div>    
		                        <?=end_row()?>
		                        <?=n_row_12()?>
		                            <div class="row">
		                                <div class="col-lg-10 col-lg-offset-1">
		                                    <hr>
		                                    <?=div("¿Tienes alguna duda o consulta?" , 1)?>
		                                    <?=div("Si no la encuentras, envíala a soporte@enidservice.com", 1)?>                                            
		                                    <?=n_row_12()?>  
		                                        <form>  
		                                            <?=input([
		                                                        "id"            => "q" ,
		                                                        "name"          => "faqs" ,
		                                                        "placeholder"   => "Tema o pregunta" ,
		                                                        "class"         => "form-control input-md" ,
		                                                        "required"      => true  ,
		                                                        "type"          => "text"
		                                                    ])?>
		                                            <?=guardar("Buscar" , ["id"=>"busqueda"])?>
		                                        </form>
		                                    <?=end_row()?>
		                                </div>
		                            </div>
		                        <?=end_row()?>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>     
	</div>
<?=end_row()?>
    



