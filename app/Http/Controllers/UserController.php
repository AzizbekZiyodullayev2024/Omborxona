<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Traits\ResponseHelper;
use App\Http\Requests\User\UserRequest;
use App\Http\Resources\User\UserEditResource;
use App\Http\Resources\User\UserListResource;
use App\Http\Resources\User\UserResource;
use App\Services\User\Contracts\iUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseHelper;

    public function index(Request $request, iUserService $service)
    {
        return $this->success_response(UserResource::collection(User::query()->paginate(10)));
    }

    public function list(Request $request, iUserService $service)
    {
        return $this->success_response(UserListResource::collection($service->filter($request)));
    }

    public function store(UserRequest $request, iUserService $service)
    {
        $service->cStore($request);
        return $this->success_response(__('message.Successfully created'));
    }

    public function edit($id, iUserService $service)
    {
        return $this->success_response(new UserEditResource($service->cEdit($id)));
    }

    public function update(UserRequest $request, $id, iUserService $service)
    {
        $service->cUpdate($request, $id);
        return $this->success_response(__('message.Successfully updated'));
    }

    public function destroy($id, iUserService $service)
    {
        $service->cDelete($id);
        return $this->success_response(__('message.Successfully deleted'));
    }
}