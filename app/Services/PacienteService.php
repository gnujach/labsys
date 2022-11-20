<?php

namespace App\Services;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteService
{
    public function storePaciente(Request $request)
    {
        return Paciente::create([
            'nombre' => $request->input('nombre'),
            'ap1'=> $request->input('ap1'),
            'ap2'=> $request->input('ap2'),
            'tel'=> $request->input('tel'),
            'correo'=> $request->input('correo'),
            'genero'=> $request->input('genero'),
            'edad'=> $request->input('edad'),
            'direccion'=> $request->input('direccion'),
            'by'=> $request->input('by'),
            'activo'=> $request->input('activo'),
            ]);
    }

    public function updatePaciente(Request $request, Paciente $paciente)
    {
        return $paciente->update(attributes: [
            'nombre' => $request->input('nombre'),
            'ap1'=> $request->input('ap1'),
            'ap2'=> $request->input('ap2'),
            'tel'=> $request->input('tel'),
            'correo'=> $request->input('correo'),
            'genero'=> $request->input('genero'),
            'edad'=> $request->input('edad'),
            'direccion'=> $request->input('direccion'),
            'by'=> $request->input('by'),
            'activo'=> $request->input('activo'),
            'by' => Auth::id(),
        ]);
    }

    public function deletePaciente (Paciente $paciente)
    {
        return $paciente->delete();
    }
}
