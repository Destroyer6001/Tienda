<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompraRequest extends FormRequest
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
            'productos' => 'required|array',
            'productos.*.producto_id' => 'required|integer|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'productos.required' => 'Los productos son requeridos',
            'productos.array' => 'El campo productos debe de ser un arreglo',
            'productos.*.producto_id.required' => 'Debe haber al menos un producto en el arreglo',
            'productos.*.producto_id.integer' => 'El id de los productos debe ser un valor entero',
            'productos.*.producto_id.exists' => 'El producto debe existir',
            'productos.*.cantidad.required'=> 'La cantidad del producto es requrida',
            'productos.*.cantidad.integer' => 'la cantidad del producto debe ser un valor entero',
            'productos.*.cantidad.min' => 'la cantidad del producto debe ser mayor o igual a 1' 
        ];
    }
}
