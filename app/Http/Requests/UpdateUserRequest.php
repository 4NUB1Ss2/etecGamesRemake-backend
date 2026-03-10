<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'username' => "sometimes|string|unique:users,username,$id",
            'email' => "sometimes|email|unique:users,email,$id",
            'password' => "sometimes|string|min:6",
            'name' => "sometimes|string|unique:users,name",
            'school_id' => "sometimes|integer|exists:schools,id",
        ];
    }
}
