@extends('layouts.web')
@section('content')

    <div class="bg-white rounded mt-4  py-6">                            
        <div class="px-8 mt-4">
            <div class="flex items-end justify-between">
                <x-valoracion-recomendaria :valoracion="$valoracion"/>                        
                <x-valoracion-puntuacion :valoracion="$valoracion"/>                
            </div>
            
        </div>
        <div class="flex flex-col px-8 mt-2">      
            <div>
                <x-titulo-seccion :titulo="$valoracion->titulo"/>                
            </div>      
            <div>
                {{$valoracion->comentario}}
            </div>
            <div>
                <span class="text-xs">
                    {{$valoracion->fecha_registro}}
                </span>
            </div>
        </div>
        <div class="flex flex-col mt-8">                    
            <div class="flex items-center justify-center bg-blue-600 text-sm font-medium w-full h-10 rounded text-blue-50 hover:bg-blue-700">
                <select class="text-sm focus:outline-none -ml-1" name="" id="">
                    <option value="">Mostrar en reseñas</option>
                    <option value="">Ocultar esta reseña al público</option>
                </select>                        
            </div>
                    
        </div>
    </div>

@endsection

