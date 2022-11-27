<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Services\EstudioService;
use App\Http\Requests\StoreEstudioRequest;
use App\Http\Requests\UpdateEstudioRequest;
use App\Http\Resources\EstudioCollection;
use App\Http\Resources\EstudioventaCollection;
use App\Http\Resources\Estudio as EstudioResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Redirect;

class EstudioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $this->authorize('viewAny', Estudio::class);
        return Inertia::render('Estudios/ListEstudios',
            [
                'estudios' => new EstudioCollection(Estudio::orderBy('id','desc')
                    ->paginate((config('openlink.perpage')))
                )
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize('create', Estudio::class);
        return Inertia::render("Estudios/CreateEstudio",[
            'grupos' => DB::table('grupos')->select('id', 'nombre')->get(),
            'tipoventas' => DB::table('tipoventas')->select('id', 'nombre')->get(),
            'categorias' => DB::table('categorias')->select('id', 'nombre')->get(),
    ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEstudioRequest $request, EstudioService $estudioService)
    {
        $this->authorize('create', Estudio::class);
        $estudioService->storeEstudio($request);
        return Redirect::route('admin.estudios/')->banner('Estudio Guardado');
    }

    /** Store a paquete
     *@param StoreEstudioRequest $request
     *@param EstudioService $estudioService
     *@returns \Illuminate\Http\Response
     */
    public function storePaquete (StoreEstudioRequest $request, EstudioService $estudioService)
    {
//        dd($request);
        $this->authorize('create', Estudio::class);
        $res = $estudioService->storePaquete($request);
        return Redirect::route('admin.estudios/')->banner('Paquete de estudio Guardado');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estudio  $estudio
     * @return \Illuminate\Http\Response
     */
    public function show(Estudio $estudio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estudio  $estudio
     * @return \Inertia\Response
     */
    public function edit(Estudio $estudio)
    {
        $this->authorize('update', Estudio::class);
        return Inertia::render(
            'Estudios/EditEstudio',
            [
                'estudio'=> new EstudioResource($estudio),
                'grupos' => DB::table('grupos')->select('id', 'nombre')->get(),
                'tipoventas' => DB::table('tipoventas')->select('id', 'nombre')->get(),
                'categorias' => DB::table('categorias')->select('id', 'nombre')->get(),
            ]);
    }
   /**
     * Show the form for editing the specified resource.
     *
     * @return \Inertia\Response
     */
    public function createPaquete()
    {
        $this->authorize('create', Estudio::class);
        return Inertia::render(
            'Estudios/CreateEstudioPaquete',
            [
                'items' => new EstudioventaCollection(Estudio::where( 'tipoventa_id' , 1)->where('activo',true)->get()),
                'grupos' => DB::table('grupos')->select('id', 'nombre')->get(),
                'categorias' => DB::table('categorias')->select('id', 'nombre')->get(),
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estudio  $estudio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEstudioRequest $request, Estudio $estudio, EstudioService $estudioService)
    {
        $this->authorize('update', Estudio::class);
        $estudioService->updateEstudio($request, $estudio);
        return Redirect::route('admin.estudios/')->banner('Estudio Actualizado');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estudio  $estudio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estudio $estudio, EstudioService $estudioService)
    {
        $this->authorize('delete', Estudio::class);
        $estudioService->deleteEstudio($estudio);
        return Redirect::route('admin.estudios/')->banner('Estudio Eliminado');
    }

    /**
     * Display a listing of the resource by search.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $keyword = $request['term'];
        $result = Estudio::search($keyword)->take(10)->get();
        return response()->json($result, 200);
    }
}
