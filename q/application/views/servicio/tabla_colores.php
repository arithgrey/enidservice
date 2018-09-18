<?php

	$colores_esp = ["Turquesa","Emerland","Peterriver","Amatista","Wetasphalt","Mar verde","Nefritis","Belizehole","Glicinas","Medianoche azul","Girasol","Zanahoria","Alizarina","Nubes","Hormigón","Naranja","Calabaza","Granada","Plata","Amianto" , "Blanco" ,"Blue" , "Cafe" , "Morado" , "Morado 2" , "Azul" , "Azul" , "Verde" , "Verde" , "Verde 2" , "Amarillo", "Amarillo 2" , "Amarillo 3" , "Amarillo 4" , "Amarillo 5 " , "Gris" , "Gris 2" , "Gris 3" , "Gris 4" , "Gris 5" , "Gris 6"];
				
	$codigo_colores =["#1abc9c","#2ecc71","#3498db","#9b59b6","#34495e","#16a085","#27ae60","#2980b9","#8e44ad","#2c3e50","#f1c40f","#e67e22","#e74c3c","#ecf0f1","#95a5a6","#f39c12","#d35400",
	"#c0392b","#bdc3c7","#7f8c8d" , "#fbfcfc", "#1b4f72" , "#641e16", "#512e5f" , "#4a235a" , "#154360" , 
  "#1b4f72" , " #0e6251" , " #0b5345"  , " #186a3b" , " #7d6608" , " #7e5109" , "#784212" , 
  "#6e2c00", "#626567" , "#7b7d7d" , "#626567" , "#4d5656" , " #424949" , " #1b2631" , "#17202a"];


	for($a=0; $a <count($colores_esp); $a++){ 		

    $estylos ="style='background:$codigo_colores[$a]'";
		echo "<center>
				<div 
				class='colores ".$colores_esp[$a]."' 
        ".$estylos."
				id='".$codigo_colores[$a]."'> 
        
        </div>
			 </center>";
	}		
	
?>
<style>
.colores {
  float: left;
  display: block;
  color: #fff;
  width: 200px;
  height: 100px;
  position: relative;
  transition: opacity 0.5s ease;
}
.colores:hover {
  opacity: 0.85;
  cursor: pointer;
}
.colores p{  
  font-size: 1em;
  position: absolute;
  bottom: 0;
  padding-left: 0.5em;
  margin-bottom: 0.3em;
  text-transform: uppercase;
}
</style>