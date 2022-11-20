<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'nombre',
        'ap1',
        'ap2',
        'tel',
        'correo',
        'genero',
        'edad',
        'direccion',
        'by',
        'activo',
        ];
}
