<?php

namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class login extends FormRequest
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

    //  defines the validation rules for the login request
    public function rules(): array
    {
        return [
        "email" => "required|email",
        "password" => "required"
        ];
    }

    // This method defines custom error messages for the validation rules
    // It returns an array where the keys are the field names and the values are the error
    public function messages(){
        return[  

            'email.required'=>'Email is required',
            
            'password.regex'=>'password must be at least 8 characters long including alphabet speacial char and numbers '
        ];
    }
}
