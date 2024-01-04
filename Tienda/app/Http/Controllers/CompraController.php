<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\CompraRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Responses\apiResponse;

class CompraController extends Controller
{
    public function index()
    {
        try{

            $compras = Compra::with('productos')->get();
            $resultado = [];

            foreach ($compras as $compra)
            {
                $infoCompra = [
                    'id_compra' => $compra->id,
                    'sub_total' => $compra->subtotal,
                    'total' => $compra->total,
                    'productos' => []
                ];

                foreach($compra->productos as $producto)
                {
                    $nombreProducto = $producto->nombre;
                    $precio = $producto->pivot->precio;
                    $cantidad = $producto->pivot->cantidad;
                    $subtotal = $producto->pivot->subtotal;

                    $infoCompra['productos'][] = [
                        'nombreProducto' => $nombreProducto,
                        'precio' => $precio,
                        'cantidad' => $cantidad,
                        'subtotal' => $subtotal
                    ];
                }

                $resultado[] = $infoCompra;
            }

            
            return apiResponse::success('Listado de compras',200,$resultado);

        }catch(Exception $e)
        {
            return apiResponse::error('Lo sentimos ha ocurrido un error interno en el servidor',500);
        }
    }

    
    public function store(CompraRequest $request)
    {
        return DB::transaction(function() use ($request) {

            try{

                $productos = $request->input('productos');
    
                if(empty($productos))
                {
                    return apiResponse::error('Lo sentimos pero no se proporcionaron productos para la compra',400);   
                }

                $productoIds = array_column($productos,'producto_id');

                if(count($productoIds) != count(array_unique($productoIds)))
                {
                    return apiResponse::error('Lo sentimos pero hay productos duplicados en la compra',400);
                }
                
                $totalPagar = 0;
                $compraItems = [];
                $subTotal = 0;

                foreach($productos as $producto)
                {
                    $productoB = Producto::find($producto['producto_id']);

                    if(!$productoB)
                    {
                        return apiResponse::error('Lo sentimos pero el productos no ha sido encontrado',400);
                    }

                    if($productoB->cantidad_disponible < $producto['cantidad'])
                    {
                        return apiResponse::error('Lo sentimo per no contamos con las existencias para poder procesar la venta',400);
                    }

                    $productoB->cantidad_disponible = $productoB->cantidad_disponible - $producto['cantidad'];
                    $productoB->save();

                    $subTotal = $productoB->precio * $producto['cantidad'];
                    $totalPagar = $totalPagar + $subTotal;

                    $compraItems[] = [
                        'producto_id' => $productoB->id,
                        'precio' => $productoB->precio,
                        'cantidad' => $producto['cantidad'],
                        'subtotal' => $subTotal
                    ];
                }

                $compra = new Compra();
                $compra->subtotal = $totalPagar;
                $compra->total = $totalPagar + ($totalPagar * 0.19);
                $compra->save();

                $compra->productos()->attach($compraItems);
                return apiResponse::success('Compra registrada en el sistema',200,$compra);

            }
            catch(Exception $e)
            {
                return apiResponse::error('Ha surgido un error inesperado',500);
            }
        });
        
    }

   
    public function show($id)
    {
        try{
            $compra = Compra::with('productos')->find($id);
            $resultado = [
                'id_compra' => $compra->id,
                'subtotal' => $compra->subtotal,
                'total' => $compra->total,
                'productos' => []
            ];

            foreach($compra->productos as $producto)
            {
                $nombreProducto = $producto->nombre;
                $precio = $producto->pivot->precio;
                $cantidad = $producto->pivot->cantidad;
                $subtotal = $producto->pivot->subtotal;

                $resultado['productos'][] = [
                    'nombreDelProducto' => $nombreProducto,
                    'precio' => $precio,
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal
                ];
            }

            return apiResponse::success('compra y listado de productos',200,$resultado);
        }catch(ModelNotFoundException $e)
        {
            return apiResponse::error('lo sentimos pero el id ingresado no corresponde a  ningun productos registrado en el sistema',400);
        }

    }

}
