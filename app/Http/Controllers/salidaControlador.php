<?php
// app/Http/Controllers/salidaController.php

namespace App\Http\Controllers;
use App\Models\Salida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class salidaControlador extends Controller
{
    public function index()
    {
        // Obtener todas las salidas de la base de datos
        $salida = Salida::all();
        if ($salida->isEmpty()){
            $data = [
                'message' => 'No se encontraron Salidas',
                'status' => 200
            ];
        return response()->json($data, 200);
        }

        return response()->json($salida, 200);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'fecha_salida' => 'required',
            'nombre' => 'required',
            'precio' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $salida = Salida::create([
            'fecha_salida' => $request->fecha_salida,
            'nombre' => $request->nombre,
            'precio' => $request->precio
        ]);

        if (!$salida) {
            $data=[
                'message' => 'Error al crear un producto',
                'status'=> 500
            ];
            return response()->json($data, 500);
        }

        $data=[
            'salida' => $salida,
            'status'=> 201
        ];
        return response()->json($data, 201);

    }


    public function show($id)
    {
        // Obtener un solo salida por el código 
        return response()->json(salida::find($id));
    }

    public function update(Request $request, $id)
    {
        // Actualizar los datos de una salida
        $salida = Salida::find($id);
        if (!$salida) {
            $data = [
                'message'=> 'Salida no encontrada',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(),[
            'fecha_salida' => 'required',
            'nombre' => 'required',
            'precio' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $salida->fecha_salida = $request->fecha_salida;
        $salida->nombre = $request->nombre;
        $salida->precio = $request->precio;

        $salida->save();

        $data = [
            'message' => 'Salida actualizado',
            'salida' => $salida,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        // Eliminar una salida de la base de datos
        $salida = Salida::find($id);
        if (!$salida) {
            $data = [
                'message'=> 'Producto no encontrado',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }
        $salida->delete();
        $data = [
            'message'=> 'Salida eliminado',
            'status'=> 200
        ];
        return response()->json($data, 200);    }
}
?>