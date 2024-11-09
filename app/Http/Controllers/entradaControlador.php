<?php
// app/Http/Controllers/salidaController.php

namespace App\Http\Controllers;
use App\Models\Entrada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class entradaControlador extends Controller
{
    public function index()
    {
        // Obtener todas las salidas de la base de datos
        $entrada = Entrada::all();
        if ($entrada->isEmpty()){
            $data = [
                'message' => 'No se encontraron Salidas',
                'status' => 200
            ];
        return response()->json($data, 200);
        }

        return response()->json($entrada, 200);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),[
            'fecha_entrada' => 'required',
            'nombre' => 'required',
            'cantidad' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $entrada = Entrada::create([
            'fecha_entrada' => $request->fecha_entrada,
            'nombre' => $request->nombre,
            'cantidad' => $request->cantidad
        ]);

        if (!$entrada) {
            $data=[
                'message' => 'Error al crear una entrada',
                'status'=> 500
            ];
            return response()->json($data, 500);
        }

        $data=[
            'entrada' => $entrada,
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
        $entrada = Entrada::find($id);
        if (!$entrada) {
            $data = [
                'message'=> 'Entrada no encontrada',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }
        $validator = Validator::make($request->all(),[
            'fecha_entrada' => 'required',
            'nombre' => 'required',
            'cantidad' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
        $entrada->fecha_entrada = $request->fecha_entrada;
        $entrada->nombre = $request->nombre;
        $entrada->cantidad = $request->cantidad;

        $entrada->save();

        $data = [
            'message' => 'Entrada actualizado',
            'entrada' => $entrada,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        // Eliminar una salida de la base de datos
        $entrada = Entrada::find($id);
        if (!$entrada) {
            $data = [
                'message'=> 'Entrada no encontrada',
                'status'=> 404
            ];
            return response()->json($data, 404);
        }
        $entrada->delete();
        $data = [
            'message'=> 'Entrada eliminada',
            'status'=> 200
        ];
        return response()->json($data, 200);    }
}
?>