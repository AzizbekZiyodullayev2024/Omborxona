<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'url', 'image', 'status', 'default'];

    public function translations()
    {
        return $this->hasMany(Translation::class, 'language_url', 'url');
    }
}
