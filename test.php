<?php 
class NombreClase {

    private $algo;

    public function crearTexto($algo) {
        $this->algo=$algo;
        echo 223;
        return $this;
    }

    public function convertirAMayusculas() {
        $this->algo=strtolower($this->algo);
        echo 2;
        return $this;
    }

    public function hacerOtraCosa(){
    	echo 3344;
        return $this;
    }
}

$NombreClase = new NombreClase();
print_r($NombreClase->crearTexto('algo')->convertirAMayusculas()->hacerOtraCosa());