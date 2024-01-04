<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRequest;
use App\Responses\apiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProductoController extends Controller
{

    public function show()
    {
        try{

            $productos = Producto::with([
                'categorias' => function($query){
                    $query->select('id','nombre');
                },
                'marcas' => function($query){
                    $query->select('id','nombre');
                }
            ])->get();
    
            return apiResponse::success('Lista de productos encontrada', 200, $productos);

        }catch(Exception $e)
        {
            return apiResponse::error('Lo sentimos ha ocurrido un error inesperado',500);
        }
    }

    public function store(ProductoRequest $request)
    {
        try{

            $producto = new Producto();
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->precio = $request->precio;
            $producto->cantidad_disponible = $request->cantidad_disponible;
            $producto->categoria_id = $request->categoria_id;
            $producto->marca_id = $request->marca_id;
            $producto->save();
            return apiResponse::success('Producto creado correctamente',201,$producto);

        }catch(Exception $e)
        {
            return apiResponse::error('Lo sentimos ha ocurrido un error inesperado',500);
        }
    }

    public function showById($id)
    {
        try{

            $producto = Producto::find($id);
            return apiResponse::success('Producto encontrado correctamente',200,$producto);

        }catch(ModelNotFoundException $e)
        {
            return apiResponse::error('Lo sentimos pero el producto buscado no esta registrado',404);
        }
    }

    public function update(Request $request, $id)
    {
        try{

            $producto = Producto::find($id);
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->precio = $request->precio;
            $producto->cantidad_disponible = $request->cantidad_disponible;
            $producto->categoria_id = $request->categoria_id;
            $producto->marca_id = $request->marca_id;
            $producto->save();

            return apiResponse::success('Producto actualizado con exito',200,$producto);

        }catch(Exception $e)
        {
            return apiResponse::error('Lo sentimos ha ocurrido un error inesperado',500);

        }catch(ModelNotFoundException $e)
        {
            return apiResponse::error('Lo sentimos pero el producto buscado no esta registrado',404);
        }
    }


    public function destroy($id)
    {
        try{

            $producto = Producto::find($id);
            $producto->delete();

            return apiResponse::success('Producto eliminado con exito',200,$producto);

        }catch(Exception $e)
        {
            return apiResponse::error('Lo sentimos ha ocurrido un error inesperado',500);

        }catch(ModelNotFoundException $e)
        {
            return apiResponse::error('Lo sentimos pero el producto buscado no esta registrado',404);
        }
    }
}
