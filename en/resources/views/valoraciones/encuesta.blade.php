@extends('layouts.web')
@section('content')
    <div class="grid mt-5">
        <div class="mx-auto">

            @if (session('status'))
                <div class="mb-3">
                    <x-form.alerta-card notificacion='Super! recibimos tus comentarios!' />
                </div>
            @endif


            <div>
                {!! _titulo('ESCRIBE UNA RESEÑA') !!}
            </div>
            <div>
                Sobre tu servicio
            </div>
            <div>
                {!! Form::open([
    'url' => route('valoracion.store'),
    'class' => 'form_valoracion',
]) !!}

                <div class="flex flex-col">
                    <div class="mt-3">
                        <h2 class="font-semibold text-xl">
                            ¿Qué valoración darías a este artículo?
                        </h2>
                    </div>
                    <div class="mr-auto">
                        <p class="clasificacion">
                            <input id="radio1" type="radio" name="calificacion" value="5">
                            <label class="text-5xl" for="radio1">★</label>
                            <input id="radio2" type="radio" name="calificacion" value="4">
                            <label class="text-5xl" for="radio2">★</label>
                            <input id="radio3" type="radio" name="calificacion" value="3">
                            <label class="text-5xl" for="radio3">★</label>
                            <input id="radio4" type="radio" name="calificacion" value="2">
                            <label class="text-5xl" for="radio4">★</label>
                            <input id="radio5" type="radio" name="calificacion" value="1">
                            <label class="text-5xl" for="radio5">★</label>
                        </p>
                    </div>
                </div>

                <x-form.alerta error='calificacion' />
                <div class="mt-3">
                    <label class="font-semibold">
                        ¿Recomendarías este producto?*
                    </label>
                </div>

                <div class="flex flex-row justify-between mt-4">
                    <div>
                        {!! a_enid('SI', [
    'class' => old('recomendaria') > 0 ? 'format_selector_seleccionado recomendaria' : 'format_selector recomendaria',
]) !!}
                    </div>
                    <div>

                        {!! a_enid('NO', [
    'class' => old('recomendaria') === '0' ? 'format_selector_seleccionado sin_recomendacion' : 'format_selector sin_recomendacion',
]) !!}
                    </div>
                </div>
                <div class="flex mt-2">
                    <x-form.alerta error='recomendaria' />
                </div>

                <div class="mt-3 mb-3">
                    <x-form.input required label='Tu opinión en una frase*' type='text' name='titulo'
                        placeholder="Me encantó!" value="{{ old('titulo') }}" error='titulo' />
                </div>

                <div class="mt-3">
                    <x-form.textarea label='Tu reseña (comentarios)*' name='comentario' class="comentario"
                        id='comentario' placeholder='¿Cual fué tu experiencia?' texto="{{ old('comentario') }}"
                        error="comentario" />
                </div>

                <x-form.input label='Tu nombre' type="text" name="nombre" placeholder="ejemplo: Jonathan" id="nombre"
                    required value="{{ old('nombre') }}" error='nombre' />

                <x-form.input label="Tu email*" type="email" name="email" class="email mt-2" id="email"
                    placeholder="ejemplo: jmedrano@enidservices.com" value="{{ old('email') }}" required error='email' />

                <div>
                    @csrf


                    {!! hiddens([
    'name' => 'recomendaria',
    'class' => 'input_recomendaria',
    'value' => old('recomendaria'),
]) !!}
                    {!! hiddens(['name' => 'id_servicio', 'value' => $id_servicio]) !!}

                </div>

                <div class="flex mt-5">
                    <x-form.boton titulo='Envíanos tu reseña!' class="mx-auto" />
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
@section('cssJs')
    <script src="{{ asset('js/valoracion/crear.js') }}" defer></script>
    <link href="{{ asset('css/valoraciones/encuesta.css') }}" rel="stylesheet">
@endsection
