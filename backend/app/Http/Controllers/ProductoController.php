<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Atributo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ProductoController extends BaseController
{
	public function get()
	{
		try
		{
			$productos = Producto::with('categoria', 'atributos')->orderBy('id', 'desc')->get();
			return response()->json(["productos" => $productos], 200);

		}catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
	}

	public function new(Request $request)
	{
		try{

			$validated = $request->validate(
				[
			        'producto.Nombre' => 'required',
			        'producto.SKU' => 'required',
			        'producto.Marca' => 'required',
			        'producto.Costo' => 'required|numeric',
			        'producto.categoria_id' => 'required|numeric'
				]
			);

			$productoId = producto::insertGetId($request->producto);

			if(isset($request->atributos)){				
				$atributos = $request->atributos;

				foreach ($atributos as $atributo) {
					$atributo["producto_id"] = $productoId;				
					Atributo::insert($atributo);
				}
				
			}

			return response()->json(['success'],200);

		}catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
	}

	public function update(Request $request)
	{
		try{
			if(isset($request->producto["id"])){
				$producto = Producto::where('id',$request->producto["id"])->update($request->producto);				
			}else{
				return response()->json(["error" => "producto id es requerido"], 403);
			}

			return response()->json(['success'],200);

		}catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
	}

	public function delete($id)
	{
		try{

			if($id){
				$producto = producto::where('id',$id)->delete();				
			}else{
				return response()->json(["error" => "producto id es requerido"], 403);
			}

			return response()->json(['success'],200);

		}catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
	}
}
