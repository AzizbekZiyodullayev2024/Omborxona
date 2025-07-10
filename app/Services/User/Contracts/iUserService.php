<?php

namespace App\Services\User\Contracts;

use Illuminate\Http\Request;

interface iUserService
{
    public function filter(Request $request);
    public function store(Request $request);
    public function edit($id);
    public function update(Request $request, $id);
    public function delete($id);
}
