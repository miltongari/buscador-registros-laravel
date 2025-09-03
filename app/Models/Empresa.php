<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    public $incrementing = false; // porque usamos id integer fijo
    public $timestamps = false;   // si no tienes created_at / updated_at
    protected $fillable = [/* ...campos que quieras asignar masivamente... */];

    public function actividades()
    {
        return $this->belongsToMany(Actividad::class, 'empresa_actividad', 'empresa_id', 'actividad_id');
    }
}
