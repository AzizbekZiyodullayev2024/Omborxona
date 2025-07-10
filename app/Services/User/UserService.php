<?php

namespace App\Services\User;

use App\Services\User\Contracts\iUserService;
use App\Models\Notification\UserNotification;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserService implements iUserService
{
    protected $modelClass = User::class;

    public function filter(Request $request)
    {
        // return $this->modelClass::whereSearch(['first_name', 'last_name', 'username', 'email'])
        //     ->whereEqual('role_id')
        //     ->whereNot('id', auth()->id())
        //     ->sort()
        //     ->customPaginate();
    }

    public function store(Request $request)
    {
        $data = $request->only(['first_name', 'last_name', 'username', 'email', 'role_id']);
        $data['password_hash'] = Hash::make($request->password);
        $model = $this->modelClass::create($data);
        return $model;
    }

    public function noticeCount(Request $request)
    {
        $id = PersonalAccessToken::findToken(preg_replace('/Bearer\s/', '', $request->header('authorization')))?->tokenable_id;
        return UserNotification::when($id, function ($query) use ($id) {
            $query->where('user_id', $id);
        })
            ->where('device_token', $request->get('device_token'))
            ->sent()
            ->count();
    }

    public function notices(Request $request)
    {
        $id = PersonalAccessToken::findToken(preg_replace('/Bearer\s/', '', $request->header('authorization')))?->tokenable_id;
        return UserNotification::with(['notification'])
            ->when($id, function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->where('device_token', $request->get('device_token'))
            ->onlySent()
            ->sort()
            ->paginate(15);
    }

    public function noticeShow($id)
    {
        $model = UserNotification::findOrFail($id);
        $model->update([
            'seen_at' => now()->format('Y-m-d H:i:s')
        ]);
        return $model;
    }

    public function edit($id)
    {
        return $this->modelClass::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $model = $this->modelClass::findOrFail($id);
        $data = $request->only(['first_name', 'last_name', 'username', 'email', 'role_id']);
        if ($request->password) {
            $data['password_hash'] = Hash::make($request->password);
        }
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        $model = $this->modelClass::findOrFail($id);
        $model->delete();
        return $model;
    }
}
