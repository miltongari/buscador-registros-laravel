<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresasController extends Controller
{
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));
        $page = max(1, (int)$request->query('page', 1));
        $limit = max(1, min(100, (int)$request->query('limit', 20)));
        $offset = ($page - 1) * $limit;

        $params = [];
        $where = '';

        if ($q !== '') {
            $term = "%{$q}%";
            $where = "WHERE (
                e.razon_social ILIKE ? OR
                e.municipio ILIKE ? OR
                e.departamento ILIKE ? OR
                a.nombre ILIKE ?
            )";
            $params = [$term, $term, $term, $term];
        }

        // Conteo
        $countSQL = "
            SELECT COUNT(DISTINCT e.id)::int AS total
            FROM empresas e
            LEFT JOIN empresa_actividad ea ON ea.empresa_id = e.id
            LEFT JOIN actividades a ON a.id = ea.actividad_id
            {$where};
        ";
        $countResult = DB::select($countSQL, $params);
        $total = $countResult[0]->total ?? 0;

        // Datos paginados con agregación de actividades
        $dataSQL = "
            SELECT
              e.id,
              e.razon_social,
              e.departamento,
              e.municipio,
              e.direccion_comercial,
              e.fecha_matricula,
              e.rep_legal,
              COALESCE(string_agg(DISTINCT a.nombre, ', '), '') AS actividades
            FROM empresas e
            LEFT JOIN empresa_actividad ea ON ea.empresa_id = e.id
            LEFT JOIN actividades a ON a.id = ea.actividad_id
            {$where}
            GROUP BY e.id
            ORDER BY e.razon_social ASC
            LIMIT ? OFFSET ?;
        ";

        $dataParams = array_merge($params, [$limit, $offset]);
        $rows = DB::select($dataSQL, $dataParams);

        return response()->json([
            'ok' => true,
            'total' => $total,
            'page' => $page,
            'pageSize' => $limit,
            'rows' => $rows
        ]);
    }
}
