<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use App\Http\Resources\PacienteCollection;
use App\Http\Resources\Paciente as PacienteResource;
use App\Services\PacienteService;
use App\Models\Paciente;
use Inertia\Inertia;
use Redirect;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Paciente::class);
        return Inertia::render(
            'Pacientes/ListPacientes',
            [
                'pacientes' => new PacienteCollection(Paciente::orderBy('id', 'desc')
                    ->paginate(config('openlink.perpage'))),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Paciente::class);
        return Inertia::render("Pacientes/CreatePaciente");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store (StorePacienteRequest $request, PacienteService $pacienteService)
    {
        $this->authorize('create', Paciente::class);
        $paciente = $pacienteService->storePaciente($request);
        return Redirect::route('admin.pacientes/')->banner('Paciente Guardado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function show(Paciente $paciente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paciente  $paciente
     * @return \Inertia\Response
     */
    public function edit(Paciente $paciente)
    {
        $this->authorize('update', Paciente::class);
        return Inertia::render(
            'Pacientes/EditPaciente',
            [
                'paciente' => new PacienteResource($paciente)
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePacienteRequest $request, Paciente $paciente, PacienteService $pacienteService)
    {
        $this->authorize('update', Paciente::class);
        $paciente = $pacienteService->updatePaciente($request,$paciente);
        return Redirect::route('admin.pacientes/')->banner('Paciente Actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paciente $paciente, PacienteService $pacienteService)
    {
        $this->authorize('delete', Paciente::class);
        $pacienteService->deletePaciente($paciente);
        return Redirect::route('admin.pacientes/')->banner('Paciente Eliminado');
    }
}
