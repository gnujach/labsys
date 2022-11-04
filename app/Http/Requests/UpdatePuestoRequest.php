<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePuestoRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre' => ['required', 'min:4', 'max:255', Rule::unique('puestos')->ignore($this->id)],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}
