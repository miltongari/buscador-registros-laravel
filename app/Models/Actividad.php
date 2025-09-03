<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';
    public $incrementing = false;
    public $timestamps = false;

    public function empresas()
    {
        return $this->belongsToMany(Empresa::class, 'empresa_actividad', 'actividad_id', 'empresa_id');
    }
}
