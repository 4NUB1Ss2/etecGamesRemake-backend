<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
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
        $id = $this->route('id');
        return  [
            "name" => "sometimes|string|unique:games,name,$id",
            "description" => "sometimes|string",
            "link" => "sometimes|string",
            "image" => "sometimes|string",
            "user_id" => "sometimes|exists:users,id",
            "school_id" => "sometimes|exists:schools,id",

        ];
    }
}
