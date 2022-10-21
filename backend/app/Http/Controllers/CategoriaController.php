<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CategoriaController extends BaseController
{
	public function get()
	{
		try
		{
			$categorias = Categoria::all();
			return response()->json(["categorias" => $categorias], 200);

		}catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
	}
}