<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
class Estudio extends Model
{
    use HasFactory, HasUuid, SoftDeletes, Searchable;
    protected $fillable = [
        'uuid',
        'nombre',
        'clave',
        'precio_mostrador',
        'precio_preferencial',
        'costo',
        'ganancia',
        'tipoventa_id',
        'grupo_id',
        'categoria_id',
        'corte_id',
        'by',
        'activo',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Tipoventa()
    {
        return $this->belongsTo(Tipoventa::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Corte()
    {
        return $this->belongsTo(Corte::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

}
