<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    //
    protected $fillable = ['name', 'price', 'duration', 'highlight', 'type', 'coins'];

    public function benefits()
    {
        return $this->hasMany(PackBenefit::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

}
