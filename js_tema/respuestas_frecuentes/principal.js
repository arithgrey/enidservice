$(document).ready(function () {

  $('.input_busqueda_respuesta_frecuente').keydown(function (event) {
    
    let $q = $('.input_busqueda_respuesta_frecuente').val();
    let url = "../q/index.php/api/respuesta_frecuente/q/format/json/";
    let data_send = { "q": $q };

    request_enid("GET", data_send, url, operaciones_repuesta_sugerida);

  });
});

let operaciones_repuesta_sugerida = function (data) {


  $('.sugerencias_respuestas_frecuentes').html(data);
  $('.item_respuesta').click(function (e) {

    const selectedOption = $(this).text(); // Obtener el texto de la opción seleccionada
    $('.input_busqueda_respuesta_frecuente').val(selectedOption); // Copiar el texto en el campo de entrada

    // Copiar el texto en el portapapeles
    navigator.clipboard.writeText(selectedOption).then(function () {
      console.log('Texto copiado en el portapapeles');
    }, function () {
      console.log('Error al copiar el texto en el portapapeles');
    });


  });

}