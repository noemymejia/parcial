namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Mostrar solo las órdenes del usuario logueado
        $orders = Order::where('user_id', auth()->id())->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
}
