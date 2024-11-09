<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class productoControlador extends Controller
{
    public function index(){
        $productos = Producto::all();

        if ($productos->isEmpty()){
            $data = [
                'message' => 'No se encontraron productos',
                'status' => 200
            ];
        return response()->json($data, 200);
        }

        return response()->json($productos, 200);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'nombre' => 'required',
            'color' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'color' => $request->color
        ]);

        if (!$producto) {
            $data=[
                'message' => 'Error al crear un producto',
                'status'=> 500
            ];
            return response()->json($data, 500);
        }

        $data=[
            'producto' => $producto,
            'status'=> 201
        ];
        return response()->json($data, 201);

    }

    public function destroy($id){
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message'=> 'Producto no encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }
        
        $producto->delete();
        $data = [
            'message'=> 'Producto eliminado',
            'status'=> 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message'=> 'Producto no encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(),[
            'nombre' => 'required',
            'color' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $producto->nombre = $request->nombre;
        $producto->color = $request->color;

        $producto->save();

        $data = [
            'message' => 'Producto actualizado',
            'producto' => $producto,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id){
        $producto = Producto::find($id);

        if (!$producto) {
            $data = [
                'message'=> 'Producto no encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(),[
            'nombre' => 'max:30',
            'color' => 'max:30'
        ]);
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('nombre')) {
            $producto->nombre = $request->nombre;
        }
        if ($request->has('color')) {
            $producto->color = $request->color;
        }

        $producto->save();
        $data = [
            'message' => 'Producto actualizado',
            'producto' => $producto,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}
