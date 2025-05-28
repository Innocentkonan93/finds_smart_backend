<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'professional_id',
        'status',
        'total_price',
        'city',
        'district',
        'start_date',
        'description',
        'notes',
        'order_date',
    ];

    // Relation avec le client
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relation avec le service commandé
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relation avec le professionnel qui offre le service
    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }
}