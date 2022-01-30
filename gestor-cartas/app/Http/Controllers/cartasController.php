<?php

namespace App\Http\Controllers;

use App\Models\Carta;
use App\Models\Coleccione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/*public function plantilla(Request $req) {
            $response = ['status'=> 1, 'msg'=>''];
            $JsonData = $req->getContent();
            $Data = json_decode($JsonData);

            try {
                $validator = Validator::make(json_decode($JsonData, true),
                ['nombre' => 'required|unique:usuarios| string',
                'email' => 'required|unique:usuarios| string',
                'password' => 'required',
                'rol' => 'required|in:particular,profesional,administrador',
                'biografia' => 'required']);

                if($validator->fails()){
                $response = ['status'=>0, 'msg'=>$validator->errors()->first()];
                }else {

                    }
            }catch (\Exception $error) {
                $response['msg'] = "Ha ocurrido un error al añadir : ".$error->getMessage();
                $response['status'] = 0;
                }
                return response()->json($response);
            }*/

class cartasController extends Controller
{
    public function crearCarta(Request $req) {
        $response = ['status'=> 0, 'msg'=>''];
        //Pedir la informacion del request
        $JsonData = $req->getContent();
        //pasar el Json al objeto
        $Data = json_decode($JsonData);
        $carta = new Carta();
        try {
            $validator = Validator::make(json_decode($JsonData, true),
            ['nombre_carta' => 'required| string',
            'descripcion_carta' => 'required| string']);

            //Crear carta
            if($validator->fails()){
                $response = ['status'=>0, 'msg'=>$validator->errors()->first()];
            }else {
                $carta->nombre_carta = $Data->nombre_carta;
                $carta->descripcion_carta = $Data->descripcion_carta;
                $carta->save();
                $response['msg'] = "Se ha guardado la carta correctamente. ";
                $response['status'] = 1;
            }
        }catch (\Exception $error) {
            $response['msg'] = "Ha ocurrido un error al añadir : ".$error->getMessage();
            $response['status'] = 0;
        }
        return response()->json($response);
    }

    public function crearColeccion(Request $req) {
            $response = ['status'=> 1, 'msg'=>''];
            $JsonData = $req->getContent();
            $Data = json_decode($JsonData);
            $coleccion = new Coleccione();
            try {
                $validator = Validator::make(json_decode($JsonData, true),
                ['nombre_coleccion' => 'required|unique:colecciones| string',
                'simbolo_coleccion' => 'required| string',
                'fecha_alta_coleccion' => 'required | date']);

                if($validator->fails()){
                $response = ['status'=>0, 'msg'=>$validator->errors()->first()];
                }else {
                    $coleccion->nombre_coleccion = $Data->nombre_coleccion;
                    $coleccion->simbolo_coleccion = $Data->simbolo_coleccion;
                    $coleccion->fecha_alta_coleccion = $Data->fecha_alta_coleccion;
                    $coleccion->save();
                    $response['msg'] = "Se ha guardado la coleccion correctamente. ";
                    $response['status'] = 1;
                    }
            }catch (\Exception $error) {
                $response['msg'] = "Ha ocurrido un error al añadir : ".$error->getMessage();
                $response['status'] = 0;
                }
                return response()->json($response);
            }
}

