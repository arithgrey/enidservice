<br>
<?php  
	$l ="";
	$tipo = 0;
	foreach ($info as $row) {	

		$tipo =  $row["tipo"];
		$id_persona =  $row["id_persona"];
		$nombre =  $row["nombre"];
		$a_paterno =  $row["a_paterno"];
		$a_materno =  $row["a_materno"];
		$tel =  $row["tel"];
		$tel_2 =  $row["tel_2"];		
		$correo =  $row["correo"];
		$nombre_fuente =  $row["nombre_fuente"];		
		$tipo_negocio =  $row["tipo_negocio"];		 		

    /**/
    $id_usuario_enid_service = $row["id_usuario_enid_service"];

		$nombre = $nombre . " " . $a_paterno . " " . $a_materno; 						
		
		$extra_persona =  "<i class='info_persona fa fa-history fa-2x' 
								id='".$id_persona."'>

							</i>";
	
		$l .="<div class='card' style='background: #0920ce;'>			
					<div class='row'>
						<div class='col-md-1'>
							<img src='http://placekitten.com/400/252' />	
						</div>
						<div class='details col-md-11 text-left'>
							<p class='product-title white'>
								".$nombre."
							</p>
							<div>							
								<span style='font-size:.8em;'>
									<i class='fa fa-mobile' ></i>
									".$tel."
									<br>
									".$correo."
								</span>
							</div>
							<p class='product-description white'>
								".$extra_persona ."
							<p>
							
						</div>

					</div>		
			</div>

			";						
		
	}
 	
?>

<?=$l;?>








<style type="text/css">

.preview {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }
  @media screen and (max-width: 996px) {
    .preview {
      margin-bottom: 20px; } }

.preview-pic {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.preview-thumbnail.nav-tabs {
  border: none;
  margin-top: 15px; }
  .preview-thumbnail.nav-tabs li {
    width: 18%;
    margin-right: 2.5%; }
    .preview-thumbnail.nav-tabs li img {
      max-width: 100%;
      display: block; }
    .preview-thumbnail.nav-tabs li a {
      padding: 0;
      margin: 0; }
    .preview-thumbnail.nav-tabs li:last-of-type {
      margin-right: 0; }

.tab-content {
  overflow: hidden; }
  .tab-content img {
    width: 100%;
    -webkit-animation-name: opacity;
            animation-name: opacity;
    -webkit-animation-duration: .3s;
            animation-duration: .3s; }

.card {
  margin-top: 10px;
  background: #eee;
  padding: 3em;
  line-height: 1.5em; 
}

@media screen and (min-width: 997px) {
  .wrapper {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex; } }

.details {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -webkit-flex-direction: column;
      -ms-flex-direction: column;
          flex-direction: column; }

.colors {
  -webkit-box-flex: 1;
  -webkit-flex-grow: 1;
      -ms-flex-positive: 1;
          flex-grow: 1; }

.product-title, .price, .sizes, .colors {
  text-transform: UPPERCASE;
  font-weight: bold; }

.checked, .price span {
  color: #ff9f1a; }


.product-title {
  margin-top: 0; }

.size {
  margin-right: 10px; }
  .size:first-of-type {
    margin-left: 40px; }

.color {
  display: inline-block;
  vertical-align: middle;
  margin-right: 10px;  
  width: 2em;
  border-radius: 2px; }
  .color:first-of-type {
    margin-left: 20px; }

.add-to-cart, .like {
  background: #ff9f1a;
  padding: 1.2em 1.5em;
  border: none;
  text-transform: UPPERCASE;
  font-weight: bold;
  color: #fff;
  -webkit-transition: background .3s ease;
          transition: background .3s ease; }
  .add-to-cart:hover, .like:hover {
    background: #b36800;
    color: #fff; }

.not-available {
  text-align: center;
  line-height: 2em; }
  .not-available:before {
    font-family: fontawesome;
    content: "\f00d";
    color: #fff; }

.orange {
  background: #ff9f1a; }

.green {
  background: #85ad00; }

.blue {
  background: #0076ad; }

.tooltip-inner {
  padding: 1.3em; }

@-webkit-keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

@keyframes opacity {
  0% {
    opacity: 0;
    -webkit-transform: scale(3);
            transform: scale(3); }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
            transform: scale(1); } }

/*# sourceMappingURL=style.css.map */
</style>
