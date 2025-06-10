<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'salary',
        'start_date',
        'city',
        'mode',
        'description',
        'image_path',
    ];

    /**
     * Relation avec l'utilisateur (le professionnel qui propose le service).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function professional()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Relation avec la catégorie (job_categories).
     */
    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }
}