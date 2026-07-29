<?php

namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class register extends FormRequest
{
    
    // This method checks if the user is authorized to make this request
    // It returns true, allowing all users to proceed with the registration request
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // This method defines the validation rules for the registration request
    public function rules(): array
    {
        return [
            "name" => ["required", "regex:/^([a-z A-Z]{1,20})$/"],
            "email" => "required|email|unique:users,email",
            "password" => ["required","confirmed","regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%?&])[A-Za-z\d@$!%?&]{8,}$/"]
    
        ];
    }
    // This method defines custom error messages for the validation rules
    public function messages(){
        return[
            'name.required'=>'TRY OTHER NAME',
            'email.required'=>'Email is required',
            
            'password.regex'=>'password must be atleast 8 characters long including alphabet speacial char and numbers '
        ];
    }
}
