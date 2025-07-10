<?php

namespace App\Services\User;

use App\Services\User\Contracts\iUserService;
use App\Models\Notification\UserNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use App\Traits\Crud;

class ProductService implements iUserService
{
    use Crud;

    public $modelClass = User::class;

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
        $request->offsetSet('password_hash', Hash::make($request->get('password')));
        $model = $this->cStore($request);
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
            'seen_at' => now()->toDateTimeString()
        ]);
        return $model;
    }

    public function edit($id)
    {
        return $this->cEdit($id);
    }

    public function update(Request $request, $id)
    {
        $model = $this->modelClass::findOrFail($id);
        $data = $request->only($this->onlySaveFields($model));

        if ($request->has('password') && !empty($request->password)) {
            $data['password_hash'] = Hash::make($request->password);
        }

        $model->update($data);
        $model = $this->attachTranslates($model, $request);
        $this->attachFiles($model, $request);

        return $model;
    }

    public function delete($id)
    {
        return $this->cDelete($id);
    }
}
