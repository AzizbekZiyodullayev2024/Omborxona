<?php

namespace App\Services\Role;

use App\Models\Role;
use App\Traits\Crud;
use App\Services\Role\Contracts\iRoleService;
use Illuminate\Http\Request;

class RoleService implements iRoleService
{
    use Crud;

    public $modelClass = Role::class;

    public function filter(Request $request)
    {
        return $this->modelClass::whereSearch(['name', 'description']);
    }

    public function store(Request $request)
    {
        return $this->cStore($request);
    }

    public function edit($id)
    {
        return $this->cEdit($id);
    }

    public function update(Request $request, $id)
    {
        return $this->cUpdate($request, $id);
    }

    public function delete($id)
    {
        return $this->cDelete($id);
    }
}
