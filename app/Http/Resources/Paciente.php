<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Paciente extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'Pacientes',
                'id' => $this->id,
                'uuid' => $this->uuid,
                'attributes' => [
                    'nombre' => $this->nombre,
                    'ap1' => $this->ap1,
                    'ap2' => $this->ap2,
                    'correo' => $this->correo,
                    'tel' => $this->tel,
                    'edad' => $this->edad,
                    'genero' => $this->genero,
                    'direccion' => $this->direccion,
                    'activo' => $this->activo,
                    'by' => $this->by,
                    ]
                ]
            ];
    }
}
