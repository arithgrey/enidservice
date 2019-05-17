$(document).ready(function(){

    $(".form_tags").submit(parsea_text);



});
let parsea_text = function (e) {

    $(".texto_convertido").empty();
    let text =  get_parameter(".tags_text");
    if (text.length >  10 ){


        $(".notificacion_tags").empty();
        let arrayText =  text.split(" ");
        let texto_tags_array =  [];
        let texto =  "";
        for (var a in arrayText ){

            let  tag ="#"+arrayText[a].trim();

            if(texto_tags_array.indexOf(tag) == -1 && tag.length >  3 ){

                texto_tags_array.push(tag);
                texto +=  tag + "<br>";
            }
        }

        if (texto.length > 6){


            let nuevo  = "<button class='btn btn-info copy_text pull-right' data-clipboard-action='copy' data-clipboard-target='#copy-target'>Copiar</button>" + "<div id='copy-target'>"+ texto+ "</div>";
            $(".texto_convertido").addClass("shadow padding_10  cursor_pointer");
            llenaelementoHTML(".texto_convertido" , nuevo);
            $(".copy_text").click(copia_texto);

        }



    }else{

        format_error(".notificacion_tags", "INGRESA TEXTO A CONVERTIR" );

    }

    e.preventDefault();

}
let copia_texto = function () {

    var clipboard = new Clipboard('.copy_text');

}
