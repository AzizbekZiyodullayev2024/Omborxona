<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = ['role_id', 'first_name', 'last_name', 'username', 'email', 'password_hash'];
    protected $hidden = ['password_hash','remember_token',];
    protected $casts = ['email_verified_at' => 'datetime','password' => 'hashed',];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function setPasswordHashAttribute($value)
    {
        $this->attributes['password_hash'] = bcrypt($value);
    }
}
