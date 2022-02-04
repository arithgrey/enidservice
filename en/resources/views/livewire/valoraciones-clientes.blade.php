

                    <div>
                        <div>
                            {!! _titulo('ESCRIBE UNA RESEÑA') !!}
                        <div>
                            Sobre tu servicio
                        </div>

                        {!! Form::open(['url' => route('valoracion.store')]) !!}

                        <div>
                            <div>
                                {!! _subtitulo('¿Qué valoración darías a este artículo?') !!}
                            </div>


                            <div>
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
                                <div>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div>
                            <div>
                                {!! strong('¿Recomendarías este producto?*') !!}
                            </div>
                        </div>

                        <div>
                            <div>
                                {!! a_enid("SI", ["class" => 'recomendaria', "id" => 1]) !!}
                            </div>

                            <div>
                                {!! a_enid("NO", ["class" => 'recomendaria', "id" => 0]) !!}
                            </div>
                        </div>


                        {!! hiddens(["name" => "user_id", "value" => 1]) !!}
                        {!! hiddens(["name" => "recomendaria", "value" => 1]) !!}
                        {!! hiddens(["name" => "id_servicio", "value" => 1]) !!}
                        {!! hiddens(["name" => "calificacion", "value" => 0]) !!}

                        <x-form.input
                            label='Tu opinión en una frase*'
                            name='titulo'
                            placeholder="Me encantó!"
                            required='Agrega una breve descripción'
                            value="{{old('titulo')}}"
                            error='titulo'/>






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

                        <x-form.input
                            label='Tu nombre'
                            type="text"
                            name="nombre"
                            placeholder="Por ejemplo: Jonathan"
                            class="nombre"
                            id="nombre"
                            required='true'
                            value="{{old('nombre')}}"
                            error='nombre'
                            />

                        <x-form.input
                            label="Tu correo electrónico*"
                            type="email"
                            name="email"
                            class="email"
                            id="email"
                            placeholder="Por ejemplo: jmedrano@enidservices.com"
                            value="{{old('email')}}"
                            required
                            error='email'/>



                        <x-form.boton titulo='Envianos tu reseña!'/>
                        @csrf
                        {!! Form::close() !!}
                        </div>
                    </div>

