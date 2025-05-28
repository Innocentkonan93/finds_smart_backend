<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackBenefit extends Model
{
    protected $fillable = ['pack_id', 'benefit'];

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }
}
