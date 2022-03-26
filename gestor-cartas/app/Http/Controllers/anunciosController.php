<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class anunciosController extends Controller
{
   public function crearPublicacion(Request $req) {
            $response = ['status'=> 0, 'msg'=>''];
            $JsonData = $req->getContent();
            $Data = json_decode($JsonData);
            $venta = new Venta();
            try {
                $validator = Validator::make(json_decode($JsonData, true),
                ['carta_id' => 'required|integer|exists:cartas,id',
                'cantidad_cartas_venta' => 'required|integer ',
                'precio_venta' => 'required|integer']);

                if($validator->fails()){
                $response = ['status'=>0, 'msg'=>$validator->errors()->first()];
                } else {
                $venta->carta_id = $Data->carta_id;
                $usuario = $req->usuario;
                $venta->usuario_id = $usuario->id;
                $venta->cantidad_cartas_venta = $Data->cantidad_cartas_venta;
                $venta->precio_venta = $Data->precio_venta;
                $venta->save();
                $response['msg'] = "Se ha creado la publicacion correctamente. ";
                $response['status'] = 1;
                }
            }catch (\Exception $error) {
                $response['msg'] = "Ha ocurrido un error al añadir : ".$error->getMessage();
                $response['status'] = 0;
                }
                return response()->json($response);
            }

    public function verVentas(Request $req) {
            $response = ['status'=> 0, 'msg'=>''];
            $JsonData = $req->getContent();
            $Data = json_decode($JsonData);

        try {
            $validator = Validator::make(json_decode($JsonData, true),
            ['nombre_carta' => 'required|string']);
            if($validator->fails()){
            $response = ['status'=>0, 'msg'=>$validator->errors()->first()];
            }else {
                $cartas = DB::table("ventas")
                        ->select(['cartas.nombre_carta','ventas.cantidad_cartas_venta','ventas.precio_venta','usuarios.nombre_usuario'])
                        ->where('nombre_carta','like','%'.$Data->nombre_carta.'%' )
                        ->join("cartas","ventas.carta_id","=","cartas.id")
                        ->join("usuarios","ventas.usuario_id","=","usuarios.id")
                        ->orderBy("ventas.precio_venta","asc")
                        ->get(); //Buscar nombre_carta
                $response['msg'] = $cartas;
                $response['status'] = 1;
                }
        }catch (\Exception $error) {
            $response['msg'] = "Ha ocurrido un error al añadir : ".$error->getMessage();
            $response['status'] = 0;
            }
            return response()->json($response);
        }

}
