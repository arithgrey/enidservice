@extends('template.master')
@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="container">
            <div class="row mt-4">
                {{$valoraciones->links()}}
            </div>
            <div class="row row-cols-1">
                 @foreach($valoraciones as $valoracion)                 
                    <div class="col bg-white p-2 border-bottom  border-dark">
                        <div class="row">
                            <div class="col-md-2">
                                <h3 class="display-3 rounded-circle">{{$valoracion->calificacion}}</h3>
                            </div>                   
                            <div class="col-md-10">
                                <p class="text-xs text-right">{{$valoracion->fecha_registro}}</p>
                                <h4 class="">
                                    <a class='font-weight-bold text-body' 
                                    href="{{route('valoracion.show', $valoracion)}}">
                                            {{$valoracion->titulo}}
                                    </a>
                                </h4>
                                <p class="text-xs">{{$valoracion->excerpt}}</p>     

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mt-4">
                {{$valoraciones->links()}}
            </div>
        </div>
    </div>
</div>
@endsection


