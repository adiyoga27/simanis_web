<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
        return [
            'name' => ['required'],
            'username' => ['required', 'unique:users'],
            'password' => ['required','min:8'],
            'password_confirmation' => ['required','same:password'],
            'email' => ['required', 'unique:users', 'email'],
            'avatar' => ['nullable', 'image','mimes:jpeg,png,jpg'] ,// add this rule if you want to validate avatar image,
            'role' => ['nullable', 'in:admin,user'],
            'birthdate' => ['required', 'date'],
            'phone' => ['required','min:8'],
            'jk' => ['required', ],
            'is_smoke' => ['required', 'boolean'],
           'medical_history' => ['nullable','string'],
            'province' => ['required','string'],
            'city' => ['required','string'],
           'subdistrict' => ['required','string'],
            'village' => ['required','string'],
            'address' => ['required','string'],
            'kode_pos' => ['nullable','max:10'],
        ];
    }
}
