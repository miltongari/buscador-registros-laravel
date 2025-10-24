<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Empresa;
use Illuminate\Http\Request;

class EmpresasController extends Controller
{
    public function index(Request $request)
    {
        $query = Empresa::with('actividades');

        // Filtro de búsqueda
        if ($request->has('q') && !empty($request->q)) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('razon_social', 'ILIKE', "%$q%")
                    ->orWhere('municipio', 'ILIKE', "%$q%")
                    ->orWhere('departamento', 'ILIKE', "%$q%")
                    ->orWhere('direccion', 'ILIKE', "%$q%")
                    ->orWhere('rep_legal', 'ILIKE', "%$q%")
                    // Buscar en fecha de matrícula (como texto)
                    ->orWhere('fecha_matricula', 'ILIKE', "%$q%")
                    // Buscar en actividades relacionadas
                    ->orWhereHas('actividades', function ($actividadQuery) use ($q) {
                        $actividadQuery->where('nombre', 'ILIKE', "%$q%")
                                      ->orWhere('descripcion', 'ILIKE', "%$q%");
                    });
            });
        }

        // Paginación
        $limit = $request->input('limit', 20);
        $empresas = $query->paginate($limit);

        // Respuesta en el formato que espera App.vue
        return response()->json([
            'ok' => true,
            'rows' => $empresas->items(),
            'total' => $empresas->total(),
            'page' => $empresas->currentPage(),
            'totalPages' => $empresas->lastPage(),
        ]);
    }
}