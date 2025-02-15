<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateHomeRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'min:5',
                'max:50',
                Rule::unique('homes', 'title')->ignore($this->home),
            ],
            'description' => 'nullable|min:10|max:250|string',
            'beds' => 'required|integer',
            'bathrooms' => 'required|integer',
            'rooms' => 'required|integer',
            'square_metres' => 'required|integer|min:10',
            'address' => 'required|string|min:3|max:75',
            'image' => 'image|max:2048',
            'active' => 'required',
            'services' => 'nullable|exists:services,id'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Il titolo è obbligatorio',
            'title.min' => 'Il titolo deve contenere almeno 5 caratteri',
            'title.max' => 'Il titolo può contenere al massimo 50 caratteri',
            'title.string' => 'Il titolo deve essere una stringa',
            'description.min' => 'La descrizione deve contenere almeno 10 caratteri',
            'description.max' => 'La descrizione può contenere al massimo 250 caratteri',
            'description.string' => 'La descrizione deve essere una stringa',
            'beds.required' => 'Il numero di letti è obbligatorio',
            'beds.integer' => 'Il numero di letti deve essere un numero intero',
            'bathrooms.required' => 'Il numero di bagni è obbligatorio',
            'bathrooms.integer' => 'Il numero di bagni deve essere un numero intero',
            'rooms.required' => 'Il numero di stanze è obbligatorio',
            'rooms.integer' => 'Il numero di stanze deve essere un numero intero',
            'square_metres.required' => 'I metri quadrati sono obbligatori',
            'square_metres.integer' => 'I metri quadrati devono essere un numero intero',
            'square_metres.min' => 'I metri quadrati devono essere almeno 10',
            'address.required' => 'L\'indirizzo è obbligatorio',
            'address.string' => 'L\'indirizzo deve essere una stringa',
            'address.min' => 'L\'indirizzo deve contenere almeno 3 caratteri',
            'address.max' => 'L\'indirizzo può contenere al massimo 75 caratteri',
            'image.required' => 'L\'immagine è obbligatoria',
            'image.image' => 'Il file deve essere un\'immagine',
            'image.max' => 'Il file può essere al massimo di 2048 KB',
            'active.required' => 'Vuoi mostrare il tuo appartamento?',
            'services.exists' => 'I servizi selezionati non sono validi'
        ];
    }
}
