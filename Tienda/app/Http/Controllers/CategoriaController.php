<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Responses\apiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoriaController extends Controller
{
    
    public function show()
    {
        try{

            $categorias = Categoria::all();
            return apiResponse::success('Listado de categorias',200,$categorias);

        }catch(Exception $e)
        {
            return apiResponse::error('Lo sentimos ha ocurrido un error inexperado',500);
        }
    }


    public function store(CategoriaRequest $request)
    {
        try{

            $categoria = new Categoria();
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->save();

            return apiResponse::success('Categoria creada con exito',201,$categoria);

        }catch(Exception $e)
        {
            return apiResponse::error('Lo sentimos ha ocurrido un error inexperado',500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showById($id)
    {
        try{

            $categoria = Categoria::find($id);
            return apiResponse::success('Categoria encontrada',200,$categoria);

        }catch(ModelNotFoundException $e)
        {
            return apiResponse::error('Lo sentimos pero la categoria no ha sido encontrada', 404);
        }
    }


    public function update(CategoriaRequest $request, $id)
    {
        try{

            $categoria = Categoria::find($id);
            $categoria->nombre = $request->nombre;
            $categoria->descripcion = $request->descripcion;
            $categoria->save();

            return apiResponse::success('Categoria correctamente actualizada',200,$categoria);

        }catch(ModelNotFoundException $e)
        {
            return apiResponse::error('Lo sentimos pero la categoria no ha sido encontrada',404);

        }catch(Exception $e)
        {
            return apiResponse::error('Lo sentimos pero ha ocurrido un error inexperado',500);
        }
    }


    public function destroy($id)
    {
        try{

            $categoria = Categoria::find($id);
            $categoria->delete();
            return apiResponse::success('Categoria eliminada correctamente',200,$categoria);
        }catch(Exception $e)
        {
            return apiResponse::error('Lo sentimos pero ha ocurrido un error inexperado',500);

        }catch(ModelNotFoundException $e)
        {
            return apiResponse::error('Lo sentimos pero la categoria no ha sido encontrada',404);
        }
    }

    public function productosPorCategoria($id)
    {
        try{
            $categoria = Categoria::with('productos')->findOrFail($id);
            return apiResponse::success('Categoria y lista de productos',200,$categoria);

        }catch(ModelNotFoundException $e)
        {
            return apiResponse::error('Lo sentimos pero la categoria no ha sido encontrada',404);
        }
    }
}
