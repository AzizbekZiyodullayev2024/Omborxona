<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Warehouse;

class User extends Model
{
protected $fillable = ['role_id', 'first_name', 'last_name', 'username', 'email', 'password_hash', 'warehouse_id'];

public function role()
{
return $this->belongsTo(Role::class);
}

public function warehouse()
{
return $this->belongsTo(Warehouse::class);
}
}