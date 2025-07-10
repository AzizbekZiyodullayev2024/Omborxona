<?php

namespace App\Models\Notification;

use App\Models\Notification\Notification as NotificationNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\NotificationStatusEnum;
use Kyslik\ColumnSortable\Sortable;
use App\Traits\Scopes;
use App\Models\User;

class UserNotification extends Model
{
    use HasFactory;

    const MAX_ATTEMPTS = 3, ALL_USERS = 'all_users';

    protected $fillable = [
        'user_id',
        'device_token',
        'notification_id',
        'seen_at',
        'attempts',
        'queue',
        'status',
        'by_firebase'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notification()
    {
        return $this->belongsTo(NotificationNotification::class);
    }

    // public function scopeProcess($query)
    // {
    //     $query->where('status', NotificationStatusEnum::PROCESS->value);
    // }

}
