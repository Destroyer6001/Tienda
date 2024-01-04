<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'nombre' => 'required|string|max:100|unique:productos,nombre,' . $id,
            'precio' => 'required|numeric|between:0,999999.99',
            'cantidad_disponible' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
            'marca_id' => 'required|exists:marcas,id'
        ];
    }

    public function messages(){
        return[
            'nombre.required' => 'el campo nombre es requerido',
            'nombre.string' => 'el campo nombre debe ser tipo texto',
            'nombre.max' => 'el campo nombre debe tener como maximo 100 caracteres',
            'nombre.unique' => 'el campo nombre debe ser unico',
            'precio.required' => 'el campo precio es requerido',
            'precio.numeric' => 'el campo precio debe ser un campo tipo numerico',
            'precio.between' => 'el campo precio solo puede tener 8 decimales',
            'cantidad_disponible.required' => 'el campo cantidad es requerido',
            'cantidad_disponible.integer' => 'el campo cantidad debe ser un numero entero',
            'categoria_id.required' => 'el campo categoria es requerido',
            'categoria_id.exists' => 'la categoria seleccionada no existe',
            'marca_id.required' => 'la marca es requerida',
            'marca_id.exists' => 'la marca seleccionada no existe' 
        ];
    }
}
