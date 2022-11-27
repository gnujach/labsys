<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Grupo as GrupoResource;
use App\Http\Resources\Categoria as CategoriaResource;
use App\Http\Resources\Tipoventa as TipoventaResource;
class Estudio extends JsonResource
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
                'type' => 'Estudios',
                'id' => $this->id,
                'uuid' => $this->uuid,
                'grupo' => new GrupoResource($this->whenLoaded('grupo')),
                'categoria' => new CategoriaResource($this->whenLoaded('categoria')),
                'tipoventa' => new TipoventaResource($this->whenLoaded('tipoventa')),
                'attributes' => [
                    'nombre'=> $this->nombre,
                    'clave'=> $this->clave,
                    'precio_mostrador'=> $this->precio_mostrador,
                    'precio_preferencial'=> $this->precio_preferencial,
                    'costo'=> $this->costo,
                    'ganancia'=> $this->ganancia,
                    'tipoventa_id'=> $this->tipoventa_id,
                    'grupo_id'=> $this->grupo_id,
                    'categoria_id'=> $this->categoria_id,
                    'corte_id'=> $this->corte_id,
                    'by'=> $this->by,
                    'activo'=> $this->activo
                    ]
                ],
            'links' => [
                'self' => url('/admin/estudios/' . $this->uuid . '/edit'),
            ]
            ];
    }
}
