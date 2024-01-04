<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use App\Http\Requests\MarcaRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Responses\apiResponse;

class MarcaController extends Controller
{
    
    public function show()
    {
        try{

            $marcas = Marca::all();
            return apiResponse::success("Lista de marcas obtenidas",200,$marca);
            
        }catch(Exception $e)
        {
            return apiResponse::error("Lo sentimos ha ocurrido un error inesperado",500);
        }

    }

    public function store(MarcaRequest $request)
    {
        try{

            $marca = new Marca();
            $marca->nombre = $request->nombre;
            $marca->descripcion = $request->descripcion;
            $marca->save();
            return apiResponse::success("Marca creada correctamente",201,$marca);

        }catch(Excepcion $e)
        {
            return apiResponse::error("Lo sentimos ha ocurrido un error inesperado",500);
        }
    }


    public function showById($id)
    {
        try{

            $marca = Marca::find($id);
            return apiResponse::success('Marca encontrada exitosamente',200,$marca);

        }catch(ModelNotFoundException $e)
        {
            return apiResponse::error("Lo sentimos pero la marca buscada no se encuentra registrada en el sistema",500);
        }
    }

  
    public function update(MarcaRequest $request, $id)
    {
        try{

            $marca = Marca::find($id);
            $marca->nombre = $request->nombre;
            $marca->descripcion = $request->descripcion;
            $marca->save();
            return apiResponse::success('Marca actualizada exitosamente',200,$marca);

        }catch(ModelNotFoundException $e){

            return apiResponse::error("Lo sentimos pero la marca buscada no se encuentra registrada en el sistema",500);

        }catch(Exception $e)
        {
            return apiResponse::error("Lo sentimos ha ocurrido un error inesperado",500);
        }
    }


    public function destroy($id)
    {
        try{

            $marca = Marca::find($id);
            $marca->delete();
            return apiResponse::success("Marca eliminada exitosamente",200,$marca);

        }catch(ModelNotFoundException  $e)
        {
            return apiResponse::error("Lo sentimos pero la marca buscada no se encuentra registrada en el sistema",500);

        }catch(Exception $e)
        {
            return apiResponse::error("Lo sentimos ha ocurrido un error inesperado",500);
        }
    }

    public function productosPorMarca($id)
    {
        try{
            $marca = Marca::with('productos')->findOrFail($id);
            return apiResponse::success('Marca y lista de productos',200,$marca);
        }catch(ModelNotFoundException $e)
        {
            return apiResponse::error('Lo sentimos pero la marca buscada no se encuentra registrada en el sistema');
        }
    }
}
