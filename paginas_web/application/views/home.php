<main>
                    
        
        <?=$this->load->view("secciones_2/slider");?>        

        <div class="row" style="background: #07007e;">            
            <br><br>
            <div  class="col-lg-6 col-lg-offset-3">                
                <h1 class="text-center">
                    <div style="color: white!important;" >
                        Logra más
                    </div>
                    <a  style="color: white!important;" 
                        class="white typewrite white" data-period="2000" data-type='[ "llamadas", "cotizaciones", "ventas!" ]'>
                        <span class="wrap">                                        
                        </span>
                    </a>
                </h1>                                 
            </div>
            <br>
            <br>            
        </div>             


        <?=$this->load->view("secciones_2/form_sitio_web")?>
   
        
                   
        <script type="text/javascript" src="<?=base_url('application')?>/revolution/js/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="<?=base_url('application')?>/revolution/js/jquery.themepunch.revolution.min.js"></script>
        

        <script type="text/javascript" src="<?=base_url('application')?>/revolution/js/extensions/revolution.extension.actions.min.js"></script>
        
        <script type="text/javascript" src="<?=base_url('application')?>/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
        
        <script type="text/javascript" src="<?=base_url('application')?>/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
        

        <script type="text/javascript" src="<?=base_url('application')?>/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
        
        <script type="text/javascript" src="<?=base_url('application')?>/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
        <script type="text/javascript" src="<?=base_url('application')?>/revolution/js/extensions/revolution.extension.video.min.js"></script>
        
</main>

<script type="text/javascript" src="<?=base_url('application')?>/js/principal.js"></script>
<script type="text/javascript" src="<?=base_url('application')?>/js/wizard.js"></script>
<script type="text/javascript" src="<?=base_url('application')?>/js/sha1.js"></script>









<script type="text/javascript">
            //made by vipul mirajkar thevipulm.appspot.com
var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

        var that = this;
        var delta = 200 - Math.random() * 100;

        if (this.isDeleting) { delta /= 2; }

        if (!this.isDeleting && this.txt === fullTxt) {
        delta = this.period;
        this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
        this.isDeleting = false;
        this.loopNum++;
        delta = 500;
        }

        setTimeout(function() {
        that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i=0; i<elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
              new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
        document.body.appendChild(css);
    };
          </script>
          
          <style type="text/css">
            .cont-w{
                background-color:#ce3635;
                text-align: center;
                color:#fff;
                padding-top:10em;
              }
              
          </style>