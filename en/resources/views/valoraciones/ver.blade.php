@extends('template.master')
@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="container">            
            <div class="row">                
                <div class="col bg-white p-2">
                    <div class="row">
                        <div class="col-md-2">
                            <h3 class="display-3 rounded-circle">
                                {{$valoracion->calificacion}}
                            </h3>
                            <p>Puntuación</p>
                        </div>
                        <div class="col-md-10">                               
                            <p class="text-xs text-right">{{$valoracion->fecha_registro}}</p>
                            <h4 class="font-weight-bold">{{$valoracion->titulo}}</h4>
                            <p class="text-xs">{{$valoracion->comentario}}</p>                
                            <p class="font-weight-bold mt-3 text-right">
                                Cliente {{$valoracion->nombre}}
                            </p>
                            @if($valoracion->recomendaria)
                                <p class="font-weight-bold">
                                    Nos recomendaria!
                                </p>
                            @else
                                <p class="alert alert-danger">
                                    No le agradó nuestro servicio :(
                                </p>
                            @endif
                        </div>
                    </div>
                                        
                </div>                
            </div>            
        </div>
    </div>
</div>
@endsection


