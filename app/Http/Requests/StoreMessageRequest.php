<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            'name' => 'required|min:5|max:50|string',
            'email' => 'required|min:10|max:250|string',
            'content' => 'required|min:10|max:1000|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Il nome è obbligatorio',
            'name.min' => 'Il nome deve contenere almeno 5 caratteri',
            'name.max' => 'Il nome può contenere al massimo 50 caratteri',
            'email.string' => 'L\'email deve essere una stringa',
            'email.min' => 'L\'email deve contenere almeno 5 caratteri',
            'email.max' => 'L\'email può contenere al massimo 250 caratteri',
            'content.min' => 'La descrizione deve contenere almeno 10 caratteri',
            'content.max' => 'La descrizione può contenere al massimo 1000 caratteri',
            'content.string' => 'La descrizione deve essere una stringa',
        ];
    }
}
