@extends('template.master')
@section('jscss')sss
     
@endsection('jscss')

@section('content')


<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="container">            
            <div class="row">                
                <div class="col bg-white p-2">
                    <div class="row">


<br><br><br>
<i class="fa fa-copy"></i>

<i class="fa fa-save"></i>

<i class="fa fa-trash"></i>

<i class="fa fa-home"></i>
<!-- Regular -->
<i class="far fa-user"></i>

<!-- Solid -->
<i class="fas fa-user"></i>

<!-- Brand -->
<i class="fab fa-dev"></i>

<i class="fas fa-camera"></i>
<i class="far fa-camera"></i>
<i class="fal fa-camera"></i>
<i class="fad fa-camera"></i>


                                                    
                        <div class="col-md-10 offset-1">
                        {!! _titulo('ESCRIBE UNA RESEÑA') !!}
                        <div>
                            Sobre tu servicio
                        </div>

                        {!! Form::open(['url' => route('valoracion.store')]) !!}

                        <div class="row d-flex justify-content-between mt-2">
                            <div class="col-md-8">
                                {!! _subtitulo('¿Qué valoración darías a este artículo?') !!}
                            </div>
                            <div class=" col-md-4">
                                {!! posibles_valoraciones(
                                    [
                                        "",
                                        "Insuficiente",
                                        "Aceptable",
                                        "Promedio",
                                        "Bueno",
                                        "Excelente"
                                    ]
                                )  
                                !!}
                            </div>
                            @error('calificacion')
                                <div class="col-md-12 mensaje-error-campo">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {!! strong('¿Recomendarías este producto?*') !!}
                            </div>
                        </div>

                        <div class="row d-flex justify-content-between mt-2">
                            <div class="col">
                                {!! a_enid("SI", ["class" => 'recomendaria', "id" => 1]) !!}
                            </div>

                            <div class="col ml-auto text-right">
                                {!! a_enid("NO", ["class" => 'recomendaria', "id" => 0]) !!}
                            </div>
                        </div>

                                                
                        {!! hiddens(["name" => "user_id", "value" => 1]) !!}
                        {!! hiddens(["name" => "recomendaria", "value" => 1]) !!}
                        {!! hiddens(["name" => "id_servicio", "value" => 1]) !!}
                        {!! hiddens(["name" => "calificacion", "value" => 0]) !!}


                        {!!
                            input_frm(
                                "mt-5",
                                "Tu opinión en una frase*",
                                [
                                    "type" => "text",
                                    "name" => "titulo",
                                    "class" => "opinion_frase",
                                    "id" => "opinion_frase",
                                    "placeholder" => "Por ejemplo: Me encantó!",
                                    "required" => "Agrega una breve descripción",
                                    "value" => old('titulo')
                                ],
                                "nuevo"
                            )
                        !!}

                        @error('titulo')
                            {{ $message }}
                        @enderror

                

                        {!!
                                input_frm("mt-5", 
                                        "Tu reseña (comentarios)*",
                                        [
                                            "type" => "text",
                                            "name" => "comentario",
                                            "class" => "comentario",
                                            "id" => "comentario",
                                            "placeholder" => "¿Por qué te gusta el producto o por qué no?",
                                            "required" => "Comenta tu experiencia",
                                            "value" => old('comentario')
                                        ]

                                    )


                        !!}
                        
                        @error('comentario')
                            {{ $message }}
                        @enderror


                        {!!

                            input_frm("mt-5", "Tu Nombre", [
                                "type" => "text",
                                "name" => "nombre",
                                "placeholder" => "Por ejemplo: Jonathan",
                                "value" => "",
                                "class" => "nombre",
                                "id" => "nombre",
                                "required" => true,
                                "value" => old('nombre')
                            ]);

                        !!}


                        @error('nombre')
                            {{ $message }}
                        @enderror
                        


                        {!! 
                        
                        input_frm(
                            "mt-5", "Tu correo electrónico*",
                                [
                                    "type" => "email",
                                    "name" => "email",
                                    "class" => "email",
                                    "id" => 'email',
                                    "placeholder" => "Por ejemplo: jmedrano@enidservices.com",
                                    "value" => old('email')
                                ]
                            );

                        !!}
                    
                        
                        {!! submit_format('Enviar reseña', ['class' => 'mt-5']) !!}

                        @csrf
                        {!! Form::close() !!}
                        </div>
                    </div>                                       
                </div>                
            </div>            
        </div>
    </div>
</div>
@endsection
