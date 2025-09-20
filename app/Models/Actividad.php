<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Relación Many-to-Many con Empresas
    public function empresas()
    {
        return $this->belongsToMany(
            Empresa::class,
            'empresa_actividad',
            'actividad_id',
            'empresa_id'
        );
    }
}
