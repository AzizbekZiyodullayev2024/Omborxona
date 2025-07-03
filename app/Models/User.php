<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['role_id', 'first_name', 'last_name', 'username', 'email', 'password_hash'];
    protected $hidden = ['password_hash'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function setPasswordHashAttribute($value)
    {
        $this->attributes['password_hash'] = bcrypt($value);
    }
}
