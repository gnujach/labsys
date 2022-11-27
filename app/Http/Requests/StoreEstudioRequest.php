<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEstudioRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre'  => ['required', 'min:4', 'max:255', Rule::unique('estudios')],
            'clave'=> ['required', 'min:2', 'max:255', Rule::unique('estudios')],
            'precio_mostrador'=> ['required', 'min_digits:1', 'max_digits:10'],
            'precio_preferencial'=> ['required', 'min_digits:1', 'max_digits:10'],
            'costo'=> ['required', 'min_digits:1', 'max_digits:10'],
            'ganancia'=> ['required', 'min_digits:1', 'max_digits:10'],
            'tipoventa_id'=> ['exists:tipoventas,id'],
            'grupo_id'=> ['exists:grupos,id'],
            'categoria_id'=> ['exists:categorias,id'],
            'by'=> ['exists:users,id'],
            'activo'=>  ['required','Boolean']
        ];
    }
}
