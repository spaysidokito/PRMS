

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'status',
        'location',
        'quantity',
        'cost',
        'purchase_date',
        'last_maintenance',
        'specifications',
        'attachments',
        'created_by'
    ];

    protected $casts = [
        'specifications' => 'array',
        'attachments' => 'array',
        'cost' => 'decimal:2',
        'purchase_date' => 'date',
        'last_maintenance' => 'date'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_resources')
            ->withTimestamps()
            ->withPivot(['quantity', 'notes']);
    }

    public function bookings()
    {
        return $this->hasMany(ResourceBooking::class);
    }
}
