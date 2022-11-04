<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserTrabajoRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'departamento_id' => ['exists:departamentos,id'],
            'puesto_id' => ['exists:puestos,id'],
        ];
    }
}
