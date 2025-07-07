<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = ['table_name', 'field_name', 'field_id', 'field_value', 'language_url'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_url', 'url');
    }
}
