<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $roles = ['warehouse_staff', 'sales_consultant']; // Assuming these are role names in the roles table
        return [
            'first_name'    => ['nullable', 'string', 'max:255'],
            'last_name'     => ['nullable', 'string', 'max:255'],
            'username'      => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($this->user)],
            'email'         => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user)],
            'password'      => ['required', 'string', 'min:5'],
            'role_id'       => ['required', 'integer', 'exists:roles,id'],
        ];
    }
}
