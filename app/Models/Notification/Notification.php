<?php

namespace App\Models\Notification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Casts\JsonCast;
use App\Traits\HasFile;
use App\Traits\Scopes;
use App\Models\User;

class Notification extends Model
{
    use HasFactory, HasFile;

    protected $fillable = [
        'title',
        'body',
        'author_id',
        'type',
        'notice_types',
    ];

    // protected function casts()
    // {
    //     return [
    //         'notice_types' => JsonCast::class
    //     ];
    // }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function user_notifications()
    {
        return $this->hasMany(UserNotification::class);
    }
}
