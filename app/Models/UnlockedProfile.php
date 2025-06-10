<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnlockedProfile extends Model
{
    //
    protected $fillable = ['client_id', 'professional_id'];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    
}
