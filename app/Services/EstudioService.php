<?php

namespace App\Services;

use App\Models\Estudio;
//use App\Models\
use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstudioService
{
    public function storeEstudio(Request $request)
    {
        return Estudio::create([
            'nombre'=> $request->input('nombre'),
            'clave'=> $request->input('clave'),
            'precio_mostrador'=> $request->input('precio_mostrador'),
            'precio_preferencial'=> $request->input('precio_preferencial'),
            'costo'=> $request->input('costo'),
            'ganancia'=> $request->input('ganancia'),
            'tipoventa_id'=> 1,
            'grupo_id'=> $request->input('grupo_id'),
            'categoria_id'=> $request->input('categoria_id'),
            'corte_id'=> 1,
            'by' => Auth::id(),
            'activo'=> $request->input('activo'),
        ]);
    }

    public function storePaquete (Request $request)
    {
        DB::beginTransaction();
        try {
            $estudio = Estudio::create([
                'nombre'=> $request->input('nombre'),
                'clave'=> $request->input('clave'),
                'precio_mostrador'=> $request->input('precio_mostrador'),
                'precio_preferencial'=> $request->input('precio_preferencial'),
                'costo'=> $request->input('costo'),
                'ganancia'=> $request->input('ganancia'),
                'tipoventa_id'=> 2,
                'grupo_id'=> $request->input('grupo_id'),
                'categoria_id'=> $request->input('categoria_id'),
                'corte_id'=> 1,
                'by' => Auth::id(),
                'activo'=> $request->input('activo'),
            ]);
            foreach ($request->items as $item) {
                Paquete::create([
                    'estudio_id' => $estudio->id,
                    'cantidad' => $item['cantidad'],
                    ]);
            }
            DB::commit();
            return $estudio;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function updateEstudio (Request $request, Estudio $estudio)
    {
        return $estudio->update(attributes: [
            'nombre'=> $request->input('nombre'),
            'clave'=> $request->input('clave'),
            'precio_mostrador'=> $request->input('precio_mostrador'),
            'precio_preferencial'=> $request->input('precio_preferencial'),
            'costo'=> $request->input('costo'),
            'ganancia'=> $request->input('ganancia'),
            'tipoventa_id'=> $request->input('tipoventa_id'),
            'grupo_id'=> $request->input('grupo_id'),
            'categoria_id'=> $request->input('categoria_id'),
            'corte_id'=> 1,
            'by' => Auth::id(),
            'activo'=> $request->input('activo'),
        ]);
    }

    public function deleteEstudio (Estudio $estudio)
    {
        return $estudio->delete();
    }
}
