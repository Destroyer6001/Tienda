<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarcaRequest extends FormRequest
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

        return [
            'nombre' => 'required|string|max:100|unique:marcas,nombre,' . $id
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'el campo nombre es requerido',
            'nombre.string' => 'el campo nombre debe ser tipo texto',
            'nombre.max' => 'el campo nombre debe tener como maximo 100 caracteres',
            'nombre.unique' => 'el campo nombre debe ser unico'
        ];
    }
}
