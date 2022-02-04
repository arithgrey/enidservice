<tr>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-10 w-10">
                <img class="h-10 w-10 rounded-full" src="{{$valoracion->imagen }}" alt="">
            </div>
            <div class="ml-4">
                <x-valoracion-puntuacion :valoracion="$valoracion"/>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <a href="{{route('valoracion-detalle', $valoracion->slug)}}">
            <div class="text-sm text-gray-900">{{$valoracion->titulo}}</div>
        </a>
        <div class="text-sm text-gray-500">
            {{$valoracion->excerpt}}
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
        <a href="{{route('valoracion-detalle', $valoracion->slug)}}">
            <x-valoracion-recomendaria :valoracion="$valoracion"/>
        </a>
    </td>
</tr>
