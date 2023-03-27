<style>
   #contador {
  display: flex;
  align-items: center;
  justify-content: center;  
}
</style>
</head>
<div class="top_150">
    <div id="contador">
        <div class="tiempo"></div>
    </div>
</div>

<script>
    function actualizarContador() {
        // Calcula el tiempo restante en segundos
        const ahora = new Date().getTime();
        const fechaLimite = localStorage.getItem('fechaLimite');
        if (fechaLimite === null) {
            // Si no hay fecha límite guardada en el almacenamiento local, crea una nueva fecha límite
            const fechaLimite = ahora + 24 * 60 * 60 * 1000;
            localStorage.setItem('fechaLimite', fechaLimite);
        }
        const tiempoRestante = fechaLimite - ahora;
        const segundosRestantes = Math.floor((tiempoRestante / 1000) % 60);
        const minutosRestantes = Math.floor((tiempoRestante / 1000 / 60) % 60);
        const horasRestantes = Math.floor(tiempoRestante / 1000 / 60 / 60);

        // Actualiza el elemento div con el tiempo restante
        const contador = document.getElementById("contador");
        contador.innerText = `Tiempo restante: ${horasRestantes} horas, ${minutosRestantes} minutos, ${segundosRestantes} segundos`;
    }

    // Actualiza el contador cada segundo
    setInterval(actualizarContador, 1000);

    // Ejecuta la función actualizarContador al cargar la página
    actualizarContador();
</script>