<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'title', 'body', 'sent_at', 'is_read', 'notification_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
