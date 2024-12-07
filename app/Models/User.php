<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'user_id';
    const CREATED_AT = 'user_created_at';
    const UPDATED_AT = 'user_updated_at';
    protected $fillable = [
        'user_id',
        'user_fullname',
        'email',
        'password',
        'user_phone',
        'user_birthday',
        'user_gender',
        'user_avatar',
        'user_weight',
        'user_height',
        'user_ibm',
        'user_is_block',
        'user_is_delete',
        'token_verify_email',
        'email_verified_at',
        'remember_token',
        'user_created_at',
        'user_updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token_verify_email'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function receiverAddresses()
    {
        return $this->hasMany(ReceiverAddress::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
