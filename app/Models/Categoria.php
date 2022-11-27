<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use HasFactory, HasUuid, SoftDeletes;
    protected $fillable = [
        'uuid',
        'nombre',
        'activo'
    ];

    public function estudios():\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Estudio::class);
    }


}
