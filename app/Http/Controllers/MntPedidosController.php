// app/Http/Controllers/MntPedidosController.php

namespace App\Http\Controllers;

use App\Models\MntPedidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ApiResponse;

class MntPedidosController extends Controller
{
    public function filterPedidosByClienteAndProduct(Request $request)
    {
        try {
            // Validación de los parámetros recibidos
            $validator = Validator::make($request->all(), [
                'client_id' => 'required|exists:mnt_clientes,id',
                'categoria_id' => 'nullable|exists:ctl_categoria,id',
                'producto_id' => 'nullable|exists:ctl_productos,id',
            ], [
                'client_id.required' => 'El ID del cliente es obligatorio',
                'client_id.exists' => 'El cliente debe estar registrado',
                'categoria_id.exists' => 'La categoría debe estar registrada',
                'producto_id.exists' => 'El producto debe estar registrado',
            ]);

            if ($validator->fails()) {
                return ApiResponse::error($validator->errors(), 422);
            }

            // Iniciar la consulta con el cliente
            $query = MntPedidos::with([
                'detallePedido.producto.categoria',
                'cliente'
            ])->where('client_id', $request->client_id);

            // Aplicar filtros en la relación detallePedido
            if ($request->filled('categoria_id') || $request->filled('producto_id')) {
                $query->whereHas('detallePedido.producto', function ($q) use ($request) {
                    // Filtrar por producto si se proporciona un ID de producto
                    if ($request->filled('producto_id')) {
                        $q->where('id', $request->producto_id);
                    }

                    // Filtrar por categoría si se proporciona un ID de categoría
                    if ($request->filled('categoria_id')) {
                        $q->whereHas('categoria', function ($qc) use ($request) {
                            $qc->where('id', $request->categoria_id);
                        });
                    }
                });
            }

            $pedidos = $query->paginate(10);

            return ApiResponse::success('Pedidos filtrados', 200, $pedidos);
        } catch (\Exception $e) {
            return ApiResponse::error('Error al filtrar los pedidos: ' . $e->getMessage(), 422);
        }
    }
}



