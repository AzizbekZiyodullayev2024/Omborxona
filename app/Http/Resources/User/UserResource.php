<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'username'   => $this->username,
            'email'      => $this->email,
            'role_id'    => $this->role_id,
            'created_at' => $this->created_at->toISOString(),
        ];
    }

    /**
     * Format a successful JSON response with the resource data.
     *
     * @param  mixed  $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function success_response($data)
    {
        return response()->json(['success' => true, 'data' => $data]);
    }
}
