<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    // Les champs qui peuvent être remplis par l'utilisateur
    protected $fillable = [
        'file_path',
        'original_name',
        'user_id',
        'type',
        'is_validated',
    ];

    // Relation avec le modèle User (un utilisateur peut avoir plusieurs documents)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
