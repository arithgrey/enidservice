<?php

namespace App\Http\Resources\V2;

use Illuminate\Http\Resources\Json\JsonResource\ResourceCollection;

class ValoracionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $collects = ValoracionResource::class;
    public function toArray($request)
    {
        return [

            'data' => $this->collection,
            'meta' => [
                'organización' => 'Enid service'
            ]

        ];
    }
}
