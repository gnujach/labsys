<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
class EstudioventaCollection extends ResourceCollection
{
    public $collects = Estudio::class;
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'message'       => 'Todos los Estudios',
            'estudios'     =>  $this->collection,
        ];
    }
}
