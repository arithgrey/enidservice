    <div 
        class="image-container set-full-height" 
        style="background-image:url('../img_tema/portafolio/Busy-People.jpg')">
      
      <?=n_row_12()?>      
        <div class="container">
            <div class="row">
              <div class="col-sm-8 col-sm-offset-2">
                  <div class="wizard-container">
                      <div class="card wizard-card" data-color="red" id="wizard">                        
                            
                            <div class="wizard-header">
                                <h4 class="wizard-title" style="font-size:1.4em;">
                                   Crea tu cuenta, 
                                   <span class="blue_enid">
                                     comparte nuestros productos en redes sociales,

                                      <i class="fa  strong  icon-s-linkedin">
                                      </i>
                                      <i class="fa fa fa-instagram  strong"></i>                
                                      <i class="fa  strong icon-s-twitter">
                                      </i>
                                      <i class="fa  strong icon-s-facebook">
                                      </i>
                                      <i class="fa fa-pinterest-p  fa">
                                      </i>            
                                      <i class="fa fa-google-plus-square  fa">
                                      </i>
                                      <i class="fa fa-tumblr-square   fa">
                                      </i>          
           
                                   </span>
                                  recibe tu recompensa!
                                </h4>                              
                            </div>

                            <div>
                                <ul>
                                    <li>
                                        <a href="#details" data-toggle="tab">
                                         
                                        </a>
                                    </li>
                                </ul>
                            </div>
                          

                              <div class="tab-content">
                                  <div class="tab-pane" id="details">
                                    <div class="row">
                                                     
                                      <?php 
                                        if($in_session == 0){?>                 
                                          <?=$this->load->view("secciones_2/paginas_web");?>
                                      <?php }else{ ?>

                                          <?=n_row_12()?>
                                            <div class="col-lg-8 col-lg-offset-2">
                                              <div>
                                                <span style="font-size: .8em;">
                                                  <strong>
                                                  Gana dinero hoy
                                                  </strong> haciendo lo que ya haces: Comprar, Sólo debes darte de Alta como y Comprar o Referenciar.
                                                </span>
                                              </div>

                                              <br>
                                              <div>
                                                <span style="font-size: .8em;">
                                                  Para participar sólo requieres Comprar Tú Mismo* o que Otros Compren a través de tu URL de Afiliados localizado en tu cuenta Enid Service.
                                                </span>
                                              </div>
                                              
                                              <br>
                                              <div>
                                                <span style="font-size: .8em;">
                                                Cada compra realizada en dicha URL, 
                                                <strong>
                                                te dará el porcentaje de ganancia sobre cada producto o servicio. ¡Gana dinero hoy!
                                                </strong>
                                                </span>
                                              </div>
                                            </div>


                                          <?=end_row()?>

                                          
                                          <form 

                                            class="form-horizontal afiliar_usuario">                
                                              <div class="form-group">                        
                                                <center>
                                                  <button 
                                                  id="singlebutton" 
                                                  name="singlebutton" 
                                                  class="btn btn-primary"
                                                  style="background: #098A73 !important">
                                                    Quiero ser afiliado!
                                                  </button>
                                                </center>
                                              </div>
                                              <div>
                                                <span class="place_registro_programa_afiliados">
                                                </span>
                                              </div>
                                          </form>

                                        <?php }?>                                    
                                    </div>
                                  </div>

                                  <div class="tab-pane" id="captain">
                                   
                                  </div>
                                  <div class="tab-pane" id="description">
                                     
                                  </div>
                              </div>
                              <div class="wizard-footer">
                                  
                                    <div class="clearfix"></div>
                              </div>                        
                      </div>
                  </div> <!-- wizard container -->
              </div>
            </div> 
        </div>
      <?=end_row()?>      
  </div>




<style type="text/css">
.image-container {
  min-height: 100vh;
  background-position: center center;
  background-size: cover;
  position: relative;
}
.made-with-mk:hover, .made-with-mk:active, .made-with-mk:focus {
  width: 218px;
  color: #FFFFFF;
  transition-duration: .55s;
  padding: 10px 19px;
}
.made-with-mk:hover .made-with, .made-with-mk:active .made-with, .made-with-mk:focus .made-with {
  opacity: 1;
}
.made-with-mk:hover .brand, .made-with-mk:active .brand, .made-with-mk:focus .brand {
  left: 0;
}
.made-with-mk .brand,
.made-with-mk .made-with {
  float: left;
}
.made-with-mk .brand {
  position: relative;
  top: 4px;
  left: -1px;
  letter-spacing: 1px;
  vertical-align: middle;
  font-size: 16px;
  font-weight: 600;
}
.made-with-mk .made-with {
  color: rgba(255, 255, 255, 0.6);
  position: absolute;
  left: 58px;
  top: 14px;
  opacity: 0;
  margin: 0;
  -webkit-transition: 0.55s cubic-bezier(0.6, 0, 0.4, 1);
  -moz-transition: 0.55s cubic-bezier(0.6, 0, 0.4, 1);
  -o-transition: 0.55s cubic-bezier(0.6, 0, 0.4, 1);
  transition: 0.55s cubic-bezier(0.6, 0, 0.4, 1);
}
.made-with-mk .made-with strong {
  font-weight: 400;
  color: rgba(255, 255, 255, 0.9);
}

.wizard-container {
  padding-top: 100px;
  z-index: 3;
}
.wizard-container .wizard-navigation {
  position: relative;
}



.title,
.card-title,
.wizard-title {
  font-weight: 700;
}
.title,
.title a,
.card-title,
.card-title a,
.wizard-title,
.wizard-title a {
  color: #3C4858;
  text-decoration: none;
}

.description,
.card-description,
.footer-big p {
  color: #999999;
}

.text-warning {
  color: #ff9800;
}


.text-danger {
  color: #f44336;
}

.text-success {
  color: #4caf50;
}

.text-info {
  color: #00bcd4;
}

.card {
  background-color: #FFFFFF;
  padding: 10px 0;
  width: 100%;
  border-radius: 6px;
  color: rgba(0,0,0, 0.87);
  background: #fff;
}

.wizard-card {
  min-height: 410px;
  box-shadow: 0 16px 24px 2px rgba(0, 0, 0, 0.14), 0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);
}
.wizard-card .picture-container {
  position: relative;
  cursor: pointer;
  text-align: center;
}
.wizard-card .picture {
  width: 106px;
  height: 106px;
  background-color: #999999;
  border: 4px solid #CCCCCC;
  color: #FFFFFF;
  border-radius: 50%;
  margin: 5px auto;
  overflow: hidden;
  transition: all 0.2s;
  -webkit-transition: all 0.2s;
}
.wizard-card .picture:hover {
  border-color: #2ca8ff;
}
.wizard-card[data-color="purple"] .moving-tab {
  position: absolute;
  text-align: center;
  padding: 12px;
  font-size: 12px;
  text-transform: uppercase;
  -webkit-font-smoothing: subpixel-antialiased;  
  top: -4px;
  left: 0px;
  border-radius: 4px;
  color: #FFFFFF;
  cursor: pointer;
  font-weight: 500;
  box-shadow: 0 16px 26px -10px rgba(156, 39, 176, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(156, 39, 176, 0.2);
}
.wizard-card[data-color="purple"] .picture:hover {
  border-color: #9c27b0;
}
.wizard-card[data-color="purple"] .choice:hover .icon, .wizard-card[data-color="purple"] .choice.active .icon {
  border-color: #9c27b0;
  color: #9c27b0;
}
.wizard-card[data-color="purple"] .form-group .form-control {
  background-image: linear-gradient(#9c27b0, #9c27b0), linear-gradient(#D2D2D2, #D2D2D2);
}
.wizard-card[data-color="purple"] .checkbox input[type=checkbox]:checked + .checkbox-material .check {
  background-color: #9c27b0;
}
.wizard-card[data-color="purple"] .radio input[type=radio]:checked ~ .check {
  background-color: #9c27b0;
}
.wizard-card[data-color="purple"] .radio input[type=radio]:checked ~ .circle {
  border-color: #9c27b0;
}
.wizard-card[data-color="green"] .moving-tab {
  position: absolute;
  text-align: center;
  padding: 12px;
  font-size: 12px;
  text-transform: uppercase;
  -webkit-font-smoothing: subpixel-antialiased;
  background-color: #4caf50;
  top: -4px;
  left: 0px;
  border-radius: 4px;
  color: #FFFFFF;
  cursor: pointer;
  font-weight: 500;
  box-shadow: 0 16px 26px -10px rgba(76, 175, 80, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(76, 175, 80, 0.2);
}
.wizard-card[data-color="green"] .picture:hover {
  border-color: #4caf50;
}
.wizard-card[data-color="green"] .choice:hover .icon, .wizard-card[data-color="green"] .choice.active .icon {
  border-color: #4caf50;
  color: #4caf50;
}
.wizard-card[data-color="green"] .form-group .form-control {
  background-image: linear-gradient(#4caf50, #4caf50), linear-gradient(#D2D2D2, #D2D2D2);
}
.wizard-card[data-color="green"] .checkbox input[type=checkbox]:checked + .checkbox-material .check {
  background-color: #4caf50;
}
.wizard-card[data-color="green"] .radio input[type=radio]:checked ~ .check {
  background-color: #4caf50;
}
.wizard-card[data-color="green"] .radio input[type=radio]:checked ~ .circle {
  border-color: #4caf50;
}
.wizard-card[data-color="blue"] .moving-tab {
  position: absolute;
  text-align: center;
  padding: 12px;
  font-size: 12px;
  text-transform: uppercase;
  -webkit-font-smoothing: subpixel-antialiased;
  background-color: #00bcd4;
  top: -4px;
  left: 0px;
  border-radius: 4px;
  color: #FFFFFF;
  cursor: pointer;
  font-weight: 500;
  box-shadow: 0 16px 26px -10px rgba(0, 188, 212, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 188, 212, 0.2);
}
.wizard-card[data-color="blue"] .picture:hover {
  border-color: #00bcd4;
}
.wizard-card[data-color="blue"] .choice:hover .icon, .wizard-card[data-color="blue"] .choice.active .icon {
  border-color: #00bcd4;
  color: #00bcd4;
}
.wizard-card[data-color="blue"] .form-group .form-control {
  background-image: linear-gradient(#00bcd4, #00bcd4), linear-gradient(#D2D2D2, #D2D2D2);
}
.wizard-card[data-color="blue"] .checkbox input[type=checkbox]:checked + .checkbox-material .check {
  background-color: #00bcd4;
}
.wizard-card[data-color="blue"] .radio input[type=radio]:checked ~ .check {
  background-color: #00bcd4;
}
.wizard-card[data-color="blue"] .radio input[type=radio]:checked ~ .circle {
  border-color: #00bcd4;
}
.wizard-card[data-color="orange"] .moving-tab {
  position: absolute;
  text-align: center;
  padding: 12px;
  font-size: 12px;
  text-transform: uppercase;
  -webkit-font-smoothing: subpixel-antialiased;
  background-color: #ff9800;
  top: -4px;
  left: 0px;
  border-radius: 4px;
  color: #FFFFFF;
  cursor: pointer;
  font-weight: 500;
  box-shadow: 0 16px 26px -10px rgba(255, 152, 0, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(255, 152, 0, 0.2);
}
.wizard-card[data-color="orange"] .picture:hover {
  border-color: #ff9800;
}
.wizard-card[data-color="orange"] .choice:hover .icon, .wizard-card[data-color="orange"] .choice.active .icon {
  border-color: #ff9800;
  color: #ff9800;
}
.wizard-card[data-color="orange"] .form-group .form-control {
  background-image: linear-gradient(#ff9800, #ff9800), linear-gradient(#D2D2D2, #D2D2D2);
}
.wizard-card[data-color="orange"] .checkbox input[type=checkbox]:checked + .checkbox-material .check {
  background-color: #ff9800;
}
.wizard-card[data-color="orange"] .radio input[type=radio]:checked ~ .check {
  background-color: #ff9800;
}
.wizard-card[data-color="orange"] .radio input[type=radio]:checked ~ .circle {
  border-color: #ff9800;
}
.wizard-card[data-color="red"] .moving-tab {
  position: absolute;
  text-align: center;
  padding: 12px;
  font-size: 12px;
  text-transform: uppercase;
  -webkit-font-smoothing: subpixel-antialiased;
  background-color: #f44336;
  top: -4px;
  left: 0px;
  border-radius: 4px;
  color: #FFFFFF;
  cursor: pointer;
  font-weight: 500;
  box-shadow: 0 16px 26px -10px rgba(244, 67, 54, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(244, 67, 54, 0.2);
}
.wizard-card[data-color="red"] .picture:hover {
  border-color: #f44336;
}
.wizard-card[data-color="red"] .choice:hover .icon, .wizard-card[data-color="red"] .choice.active .icon {
  border-color: #f44336;
  color: #f44336;
}
.wizard-card[data-color="red"] .form-group .form-control {
  background-image: linear-gradient(#f44336, #f44336), linear-gradient(#D2D2D2, #D2D2D2);
}
.wizard-card[data-color="red"] .checkbox input[type=checkbox]:checked + .checkbox-material .check {
  background-color: #f44336;
}
.wizard-card[data-color="red"] .radio input[type=radio]:checked ~ .check {
  background-color: #f44336;
}
.wizard-card[data-color="red"] .radio input[type=radio]:checked ~ .circle {
  border-color: #f44336;
}
.wizard-card .picture input[type="file"] {
  cursor: pointer;
  display: block;
  height: 100%;
  left: 0;
  opacity: 0 !important;
  position: absolute;
  top: 0;
  width: 100%;
}
.wizard-card .picture-src {
  width: 100%;
}
.wizard-card .tab-content {
  min-height: 340px;
  padding: 20px 15px;
}
.wizard-card .wizard-footer {
  padding: 0 15px;
}
.wizard-card .wizard-footer .checkbox {
  margin-top: 16px;
}
.wizard-card .disabled {
  display: none;
}
.wizard-card .wizard-header {
  text-align: center;
  padding: 25px 0 35px;
}
.wizard-card .wizard-header h5 {
  margin: 5px 0 0;
}
.wizard-card .nav-pills > li {
  text-align: center;
}
.wizard-card .btn {
  text-transform: uppercase;
}
.wizard-card .info-text {
  text-align: center;
  font-weight: 300;
  margin: 10px 0 30px;
}
.wizard-card .choice {
  text-align: center;
  cursor: pointer;
  margin-top: 20px;
}
.wizard-card .choice .icon {
  text-align: center;
  vertical-align: middle;
  height: 116px;
  width: 116px;
  border-radius: 50%;
  color: #999999;
  margin: 0 auto 20px;
  border: 4px solid #CCCCCC;
  transition: all 0.2s;
  -webkit-transition: all 0.2s;
}
.wizard-card .choice i {
  font-size: 40px;
  line-height: 111px;
}
.wizard-card .choice:hover .icon, .wizard-card .choice.active .icon {
  border-color: #2ca8ff;
}
.wizard-card .choice input[type="radio"],
.wizard-card .choice input[type="checkbox"] {
  position: absolute;
  left: -10000px;
  z-index: -1;
}
.wizard-card .btn-finish {
  display: none;
}
.wizard-card .description {
  color: #999999;
  font-size: 14px;
}
.wizard-card .wizard-title {
  margin: 0;
}



@media screen and (-webkit-min-device-pixel-ratio: 0) {
  input[type="date"].form-control,
  input[type="time"].form-control,
  input[type="datetime-local"].form-control,
  input[type="month"].form-control {
    line-height: 36px;
  }
  input[type="date"].input-sm, .input-group-sm input[type="date"],
  input[type="time"].input-sm, .input-group-sm
  input[type="time"],
  input[type="datetime-local"].input-sm, .input-group-sm
  input[type="datetime-local"],
  input[type="month"].input-sm, .input-group-sm
  input[type="month"] {
    line-height: 24px;
  }
  input[type="date"].input-lg, .input-group-lg input[type="date"],
  input[type="time"].input-lg, .input-group-lg
  input[type="time"],
  input[type="datetime-local"].input-lg, .input-group-lg
  input[type="datetime-local"],
  input[type="month"].input-lg, .input-group-lg
  input[type="month"] {
    line-height: 44px;
  }
}
.radio label,
.checkbox label {
  min-height: 20px;
}

.form-control-static {
  padding-top: 8px;
  padding-bottom: 8px;
  min-height: 34px;
}

.input-sm .input-sm {
  height: 24px;
  padding: 3px 0;
  font-size: 11px;
  line-height: 1.5;
  border-radius: 0;
}
.input-sm select.input-sm {
  height: 24px;
  line-height: 24px;
}
.input-sm textarea.input-sm,
.input-sm select[multiple].input-sm {
  height: auto;
}

.form-group-sm .form-control {
  height: 24px;
  padding: 3px 0;
  font-size: 11px;
  line-height: 1.5;
}
.form-group-sm select.form-control {
  height: 24px;
  line-height: 24px;
}
.form-group-sm textarea.form-control,
.form-group-sm select[multiple].form-control {
  height: auto;
}
.form-group-sm .form-control-static {
  height: 24px;
  min-height: 31px;
  padding: 4px 0;
  font-size: 11px;
  line-height: 1.5;
}

.input-lg .input-lg {
  height: 44px;
  padding: 9px 0;
  font-size: 18px;
  line-height: 1.33333;
  border-radius: 0;
}
.input-lg select.input-lg {
  height: 44px;
  line-height: 44px;
}
.input-lg textarea.input-lg,
.input-lg select[multiple].input-lg {
  height: auto;
}

.form-group-lg .form-control {
  height: 44px;
  padding: 9px 0;
  font-size: 18px;
  line-height: 1.33333;
}
.form-group-lg select.form-control {
  height: 44px;
  line-height: 44px;
}
.form-group-lg textarea.form-control,
.form-group-lg select[multiple].form-control {
  height: auto;
}
.form-group-lg .form-control-static {
  height: 44px;
  min-height: 38px;
  padding: 10px 0;
  font-size: 18px;
  line-height: 1.33333;
}

.form-horizontal .radio,
.form-horizontal .checkbox,
.form-horizontal .radio-inline,
.form-horizontal .checkbox-inline {
  padding-top: 8px;
}
.form-horizontal .radio,
.form-horizontal .checkbox {
  min-height: 28px;
}
@media (min-width: 768px) {
  .form-horizontal .control-label {
    padding-top: 8px;
  }
}
@media (min-width: 768px) {
  .form-horizontal .form-group-lg .control-label {
    padding-top: 13.0px;
    font-size: 18px;
  }
}
@media (min-width: 768px) {
  .form-horizontal .form-group-sm .control-label {
    padding-top: 4px;
    font-size: 11px;
  }
}

.label {
  border-radius: 3px;
}
.label, .label.label-default {
  background-color: #FFFFFF;
}
.label.label-inverse {
  background-color: #212121;
}
.label.label-primary {
  background-color: #9c27b0;
}
.label.label-success {
  background-color: #4caf50;
}
.label.label-info {
  background-color: #00bcd4;
}
.label.label-warning {
  background-color: #ff9800;
}
.label.label-danger {
  background-color: #f44336;
}
.label.label-rose {
  background-color: #e91e63;
}

.form-control,
.form-group .form-control {
  border: 0;
  background-image: linear-gradient(#9c27b0, #9c27b0), linear-gradient(#D2D2D2, #D2D2D2);
  background-size: 0 2px, 100% 1px;
  background-repeat: no-repeat;
  background-position: center bottom, center calc(100% - 1px);
  background-color: transparent;
  transition: background 0s ease-out;
  float: none;
  box-shadow: none;
  border-radius: 0;
  font-weight: 400;
}
.form-control::-moz-placeholder,
.form-group .form-control::-moz-placeholder {
  color: #AAAAAA;
  font-weight: 400;
}
.form-control:-ms-input-placeholder,
.form-group .form-control:-ms-input-placeholder {
  color: #AAAAAA;
  font-weight: 400;
}
.form-control::-webkit-input-placeholder,
.form-group .form-control::-webkit-input-placeholder {
  color: #AAAAAA;
  font-weight: 400;
}
.form-control[readonly], .form-control[disabled], fieldset[disabled] .form-control,
.form-group .form-control[readonly],
.form-group .form-control[disabled], fieldset[disabled]
.form-group .form-control {
  background-color: transparent;
}
.form-control[disabled], fieldset[disabled] .form-control,
.form-group .form-control[disabled], fieldset[disabled]
.form-group .form-control {
  background-image: none;
  border-bottom: 1px dotted #D2D2D2;
}

.form-group {
  position: relative;
}
.form-group.label-static label.control-label, .form-group.label-placeholder label.control-label, .form-group.label-floating label.control-label {
  position: absolute;
  pointer-events: none;
  transition: 0.3s ease all;
}
.form-group.label-floating label.control-label {
  will-change: left, top, contents;
}
.form-group.label-placeholder:not(.is-empty) label.control-label {
  display: none;
}
.form-group .help-block {
  position: absolute;
  display: none;
}
.form-group.is-focused .form-control {
  outline: none;
  background-image: linear-gradient(#9c27b0, #9c27b0), linear-gradient(#D2D2D2, #D2D2D2);
  background-size: 100% 2px, 100% 1px;
  box-shadow: none;
  transition-duration: 0.3s;
}
.form-group.is-focused .form-control .material-input:after {
  background-color: #9c27b0;
}
.form-group.is-focused.form-info .form-control {
  background-image: linear-gradient(#00bcd4, #00bcd4), linear-gradient(#D2D2D2, #D2D2D2);
}
.form-group.is-focused.form-success .form-control {
  background-image: linear-gradient(#4caf50, #4caf50), linear-gradient(#D2D2D2, #D2D2D2);
}
.form-group.is-focused.form-warning .form-control {
  background-image: linear-gradient(#ff9800, #ff9800), linear-gradient(#D2D2D2, #D2D2D2);
}
.form-group.is-focused.form-danger .form-control {
  background-image: linear-gradient(#f44336, #f44336), linear-gradient(#D2D2D2, #D2D2D2);
}
.form-group.is-focused.form-rose .form-control {
  background-image: linear-gradient(#e91e63, #e91e63), linear-gradient(#D2D2D2, #D2D2D2);
}
.form-group.is-focused.form-white .form-control {
  background-image: linear-gradient(#FFFFFF, #FFFFFF), linear-gradient(#D2D2D2, #D2D2D2);
}
.form-group.is-focused.label-placeholder label,
.form-group.is-focused.label-placeholder label.control-label {
  color: #AAAAAA;
}
.form-group.is-focused .help-block {
  display: block;
}
.form-group.has-warning .form-control {
  box-shadow: none;
}
.form-group.has-warning.is-focused .form-control {
  background-image: linear-gradient(#ff9800, #ff9800), linear-gradient(#D2D2D2, #D2D2D2);
}
.form-group.has-warning label.control-label,
.form-group.has-warning .help-block {
  color: #ff9800;
}
.form-group.has-error .form-control {
  box-shadow: none;
}
.form-group.has-error.is-focused .form-control {
  background-image: linear-gradient(#f44336, #f44336), linear-gradient(#D2D2D2, #D2D2D2);
}
.form-group.has-error label.control-label,
.form-group.has-error .help-block {
  color: #f44336;
}
.form-group.has-success .form-control {
  box-shadow: none;
}
.form-group.has-success.is-focused .form-control {
  background-image: linear-gradient(#4caf50, #4caf50), linear-gradient(#D2D2D2, #D2D2D2);
}
.form-group.has-success label.control-label,
.form-group.has-success .help-block {
  color: #4caf50;
}
.form-group.has-info .form-control {
  box-shadow: none;
}
.form-group.has-info.is-focused .form-control {
  background-image: linear-gradient(#00bcd4, #00bcd4), linear-gradient(#D2D2D2, #D2D2D2);
}
.form-group.has-info label.control-label,
.form-group.has-info .help-block {
  color: #00bcd4;
}
.form-group textarea {
  resize: none;
}
.form-group textarea ~ .form-control-highlight {
  margin-top: -11px;
}
.form-group select {
  appearance: none;
}
.form-group select ~ .material-input:after {
  display: none;
}

.form-control {
  margin-bottom: 7px;
}
.form-control::-moz-placeholder {
  font-size: 14px;
  line-height: 1.42857;
  color: #AAAAAA;
  font-weight: 400;
}
.form-control:-ms-input-placeholder {
  font-size: 14px;
  line-height: 1.42857;
  color: #AAAAAA;
  font-weight: 400;
}
.form-control::-webkit-input-placeholder {
  font-size: 14px;
  line-height: 1.42857;
  color: #AAAAAA;
  font-weight: 400;
}

.checkbox label,
.radio label,
label {
  font-size: 14px;
  line-height: 1.42857;
  color: #AAAAAA;
  font-weight: 400;
}

label.control-label {
  font-size: 11px;
  line-height: 1.07143;
  color: #AAAAAA;
  font-weight: 400;
  margin: 16px 0 0 0;
}

.help-block {
  margin-top: 0;
  font-size: 11px;
}

.form-group {
  padding-bottom: 7px;
  margin: 27px 0 0 0;
}
.form-group .form-control {
  margin-bottom: 7px;
}
.form-group .form-control::-moz-placeholder {
  font-size: 14px;
  line-height: 1.42857;
  color: #AAAAAA;
  font-weight: 400;
}
.form-group .form-control:-ms-input-placeholder {
  font-size: 14px;
  line-height: 1.42857;
  color: #AAAAAA;
  font-weight: 400;
}
.form-group .form-control::-webkit-input-placeholder {
  font-size: 14px;
  line-height: 1.42857;
  color: #AAAAAA;
  font-weight: 400;
}
.form-group .checkbox label,
.form-group .radio label,
.form-group label {
  font-size: 14px;
  line-height: 1.42857;
  color: #AAAAAA;
  font-weight: 400;
}
.form-group label.control-label {
  font-size: 11px;
  line-height: 1.07143;
  color: #AAAAAA;
  font-weight: 400;
  margin: 16px 0 0 0;
}
.form-group .help-block {
  margin-top: 0;
  font-size: 11px;
}
.form-group.label-floating label.control-label, .form-group.label-placeholder label.control-label {
  top: -7px;
  font-size: 14px;
  line-height: 1.42857;
}





.text_enid_contact{
    color: white;
    font-weight: bold;
}
.intro::before{
  background: black!important;
}
</style>


    

