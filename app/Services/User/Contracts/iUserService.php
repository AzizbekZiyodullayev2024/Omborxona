<?php

namespace App\Services\User\Contracts;

use Illuminate\Http\Request;

interface iUserService
{
    public function filter(Request $request);
    public function cStore(Request $request);
    public function cEdit($id);
    public function cUpdate(Request $request, $id);
    public function cDelete($id);
}
