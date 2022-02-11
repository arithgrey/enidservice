<div>
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        {{ $valoraciones->links() }}
    </div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-10">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full">
                        <tbody class="">
                            @foreach ($valoraciones as $valoracion)
                                <x-valoracion-listado-elemento :valoracion="$valoracion" />
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        {{ $valoraciones->links() }}
    </div>
</div>
