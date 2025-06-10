<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Page.php
class Page extends Model
{
    protected $fillable = ['title', 'slug', 'content', 'is_active'];
}