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
                                                        <a style="font-size: .9em!important;
                                                                color: black!important;" 
                                                                href="../faq" 
                                                                class="black strong" 
                                                                >
                                                                
                                                            Categorías
                                                        </a>
                                                        
                                                    </li>
                                                    <li class="active li_menu">  
                                                        <a style="font-size: .9em!important;
                                                                color: black!important;" 
                                                                href="#tab1default" 
                                                                class="black strong" 
                                                                data-toggle="tab">
                                                                <?=icon("fa fa-question-circle")?>
                                                            Preguntas frecuentes
                                                        </a>
                                                    </li>
                                                    
                                                    <?=get_btn_registro_faq($in_session , $perfil);?>     
                                               </ul>
                                        </div>
                                        <div class="panel-body">
                                            <div class="tab-content">
                                                    
                                                        <div class="" id='info_articulo'></div>
                                                        
                                                        <div class="tab-pane fade in active" id="tab1default">
                                                            <div class="row">
                                                                <?=$this->load->view("secciones_2/principal_faqs")?>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="tab2default">
                                                            <div class="row">
                                                                <?php 

                                                                    if ($in_session ==  1) {
                                                                        $this->load->view("secciones_2/form");        
                                                                    }
                                                                ?>   
                                                            </div>
                                                            
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
                                    <div class="panel">
                                        <div class="panel-content">
                                            <?=n_row_12()?>
                                                <div class="col-lg-12">
                                                    <p class="white strong" 
                                                    style="
                                                            background: black;
                                                            padding: 10px;">
                                                        ¿Tienes alguna duda o consulta?
                                                    </p>
                                                    <span >
                                                        Si no la encuentras, envíala a 
                                                        <span 
                                                            class="blue_enid_background white" 
                                                            style="padding:5px;">
                                                            soporte@enidservice.com
                                                        </span>
                                                    </span>
                                                </div>
                                            <?=end_row()?>
                                            
                                            <div > </div>
                                            <?=n_row_12()?>  
                                                <div class="col-lg-12">
                                                    <form >  
                                                        <input id="q" 
                                                        name="faqs" 
                                                        placeholder="Tema o pregunta" 
                                                        class="form-control input-md" 
                                                        required 
                                                        type="text">
                                                        <button id="busqueda" class="btn input-sm" style="background: black!important;">
                                                                Buscar
                                                        </button>
                                                    </form>
                                                </div>                                          
                                            <?=end_row()?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?=end_row()?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
