<?php

namespace App\Http\Requests;

use App\Enums\PacienteGeneroEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdatePacienteRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre'  => ['required', 'min:2', 'max:65'],
            'ap1'  => ['nullable', 'min:2', 'max:65'],
            'ap2'  => ['nullable', 'min:2', 'max:65'],
            'tel'  => ['nullable', 'min_digits:10', 'max_digits:10'],
            'correo'  => ['nullable', 'email'],
            'genero' => [new Enum(PacienteGeneroEnum::class)],
            'direccion' => ['nullable', 'min:2', 'max:65'],
            'edad'  => ['required', 'min:0', 'max:120'],
        ];
    }
}
