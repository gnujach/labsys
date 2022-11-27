<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    use HasFactory, HasUuid;
    protected $fillable = [
        'uuid',
        'estudio_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Estudio()
    {
        return $this->belongsTo(Estudio::class);
    }
}
