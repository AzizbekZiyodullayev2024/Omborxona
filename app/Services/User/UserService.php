<?php

namespace App\Services\User;

use App\Models\User;
use App\Traits\Crud;
use App\Services\User\Contracts\iUserService;
use Illuminate\Http\Request;

class UserService implements iUserService
{
    use Crud;

    public $modelClass = User::class;

    public function filter(Request $request)
    {
        return $this->modelClass::whereSearch(['first_name', 'last_name', 'username', 'email']);
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
