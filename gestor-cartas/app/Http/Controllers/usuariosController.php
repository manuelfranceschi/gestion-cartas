<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class usuariosController extends Controller
{
    //Registrar usuario
    public function register(Request $req) {
        $response = ['status'=> 1, 'msg'=>''];
        //Pedir la informacion del request
        $JsonData = $req->getContent();
        //pasar el Json al objeto
          $Data = json_decode($JsonData);
          $user = new User();
          try {
              $validator = Validator::make(json_decode($JsonData, true), //Verifica el tipo de dato que le pasamos desde el JSON
              ['nombre_usuario' => 'required|unique:usuarios| string',
              'email_usuario' => 'required|unique:usuarios| string | email:rfc,dns', //verifica que el email tenga el formato
              'password_usuario' => 'required',
              'rol_usuario' => 'required|in:Particular,Profesional,Administrador']);

                //Crear usuario
                if($validator->fails()){
                  $response = ['status'=>0, 'msg'=>$validator->errors()->first()];}
                  else {
                      $user->nombre_usuario = $Data->nombre_usuario;
                      $user->email_usuario = $Data->email_usuario;
                      if (preg_match("/(?=.[a-z])(?=.[A-Z])(?=.[0-9])(?=.[^A-Za-z0-9]).{6,}/",$Data->password_usuario)){
                        $user->password_usuario = Hash::make($Data->password_usuario);
                      } else {
                        $response["msg"] = "Contraseña debil.";
                        return response()->json($response);
                      }
                      $user->rol_usuario = $Data->rol_usuario;
                      $user->save();
                      $response['msg'] = "Se ha guardado el usuario correctamente. ";
                        $response['status'] = 1;}
                    } catch (\Exception $error) {
                        $response['msg'] = "Ha ocurrido un error al añadir : ".$error->getMessage();
                        $response['status'] = 0;}
                        return response()->json($response);
                    }

    public function login(Request $req){
        $response = ['status'=> 1, 'msg'=>''];
        $JsonData = $req->getContent();

        $Data = json_decode($JsonData);
        $user = new User();
          try {
              $validator = Validator::make(json_decode($JsonData, true),
              ['nombre_usuario' => 'required|unique:usuarios| string',
              'email_usuario' => 'required|unique:usuarios| string | email:rfc,dns',
              'password_usuario' => 'required',
              'rol_usuario' => 'required|in:Particular,Profesional,Administrador']);

                //Crear usuario
                if($validator->fails()){
                  $response = ['status'=>0, 'msg'=>$validator->errors()->first()];}
                  else {
                      $user->nombre_usuario = $Data->nombre_usuario;
                      $user->email_usuario = $Data->email_usuario;
                      if (preg_match("/(?=.[a-z])(?=.[A-Z])(?=.[0-9])(?=.[^A-Za-z0-9]).{6,}/",$Data->password_usuario)){
                        $user->password_usuario = Hash::make($Data->password_usuario);
                      } else {
                        $response["msg"] = "Contraseña debil.";
                        return response()->json($response);
                      }
                      $user->rol_usuario = $Data->rol_usuario;
                      $user->save();
                      $response['msg'] = "Se ha guardado el usuario correctamente. ";
                        $response['status'] = 1;}
                    } catch (\Exception $error) {
                        $response['msg'] = "Ha ocurrido un error al añadir : ".$error->getMessage();
                        $response['status'] = 0;}
                        return response()->json($response);
                    }
    }






