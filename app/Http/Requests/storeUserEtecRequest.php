<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class storeUserEtecRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
     public function rules(): array
     {
 
 
 
         return [
             'username' => "required|string|unique:users,username",
             'email' => [
                'required',
                'email',
                'unique:users,email',
                'regex:/^[a-zA-Z0-9._%+-]+@(etec\.sp\.gov\.br|aluno\.cps\.sp\.gov\.br|cps\.sp\.gov\.br)$/i'
                
             ],
             'image' => "nullable|image|mimes:jpeg,png,jpg",
             'password' => "required|string|min:6",
             'name' => "required|string",
             'role' => "required|string|in:user,student,professor",
             'school_id' => "nullable|integer|exists:schools,id",
             
         ];
     }
 
     public function messages(): array
     {
         return [
             'school_id.exists' => "A escola não existe",
             'email.unique' => "Este email já está cadastrado",
             'email.regex' => "Este e-mail deve ser de um endereço institucional relacionado a ETEC (@etec, @cps ou @aluno.cps)"
 
         ];
     }
}
