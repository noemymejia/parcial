namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_id', 'productos'];

    public function nombre()
    {
        return $this->belongsTo(nombre::class);
    }
}
