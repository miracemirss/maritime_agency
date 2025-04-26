<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Modelin mass assignment'a açık alanları
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Modelin gizlenecek alanları (JSON çıktılarda gösterilmez)
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Otomatik dönüşüm yapılacak alanlar
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Şifreyi her atamada otomatik olarak hash'ler
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
