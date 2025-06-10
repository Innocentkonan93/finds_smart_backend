<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'birth_date',
        'country',
        'city',
        'experience_years',
        'email',
        'phone',
        'password',
        'image_path',
        'user_type',
        'role',
        'email_verification_code',
        'email_verified_at',
        'is_available',
        'is_active',
        'is_deleted',
        'description',
        'credit_balance',
        'job_category_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    // Dans app/Models/User.php

    public function unlockedProfessionalProfiles()
    {
        return $this->belongsToMany(User::class, 'unlocked_profiles', 'client_id', 'professional_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
