<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriaRequest extends FormRequest
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
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $id
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es requerido',
            'nombre.max' => 'El campo nombre debe tener como maximo 100 caracteres',
            'nombre.unique' => 'El campo nombre debe ser unico',
            'nombre.string' => 'El campo nombre debe ser un campo tipo texto'
        ];
    }
}
