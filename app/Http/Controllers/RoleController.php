<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Traits\ResponseHelper;
use App\Http\Requests\Role\RoleRequest;
use App\Http\Resources\Role\RoleEditResource;
use App\Http\Resources\Role\RoleListResource;
use App\Http\Resources\Role\RoleResource;
use App\Services\Role\Contracts\iRoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use ResponseHelper;
    public function index(Request $request, iRoleService $service)
    {
        return $this->success_response(RoleResource::collection(Role::query()->paginate(10)));
    }

    public function list(Request $request, iRoleService $service)
    {
        return $this->success_response(RoleListResource::collection($service->filter($request)));
    }
    public function store(RoleRequest $request, iRoleService $service)
    {
        $service->cStore($request);
        return $this->success_response(__('message.Successfully created'));
    }

    public function edit($id, iRoleService $service)
    {
        return $this->success_response(new RoleEditResource($service->cEdit($id)));
    }

    public function update(RoleRequest $request, $id, iRoleService $service)
    {
        $service->cUpdate($request, $id);
        return $this->success_response(__('message.Successfully updated'));
    }

    public function destroy($id, iRoleService $service)
    {
        $service->cDelete($id);
        return $this->success_response(__('message.Successfully deleted'));
    }
}
