<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image_path',
        'color',
        'is_active',
        'is_deleted'
    ];
    
}
