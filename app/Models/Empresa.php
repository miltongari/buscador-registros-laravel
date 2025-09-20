<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'razon_social',
        'municipio',
        'departamento',
        'fecha_matricula',
        'direccion',
        'rep_legal',
    ];

    protected $casts = [
        'fecha_matricula' => 'date',
    ];

    // Relación Many-to-Many con Actividades
    public function actividades()
    {
        return $this->belongsToMany(
            Actividad::class,
            'empresa_actividad', // tabla pivote
            'empresa_id',        // FK en la pivote hacia Empresa
            'actividad_id'       // FK en la pivote hacia Actividad
        );
    }
}
