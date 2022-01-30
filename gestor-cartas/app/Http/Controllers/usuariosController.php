<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class usuariosController extends Controller
{
    //Registrar usuario
    public function registrar(Request $req) {
        $response = ['status'=> 0, 'msg'=>''];
        //Pedir la informacion del request
        $JsonData = $req->getContent();
        //pasar el Json al objeto
          $Data = json_decode($JsonData);
          $user = new Usuario();
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
                      if (preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{6,}/", $Data->password_usuario)){
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

    //2. Login mediante usuario y contraseña.
    public function login(Request $req){
        $response = ['status'=> 1, 'msg'=>''];
        $JsonData = $req->getContent();
        $Data = json_decode($JsonData);
        $user = Usuario::where('nombre_usuario', $Data->nombre_usuario)->first();

        try {
            if(isset($user)){
                if(Hash::check($Data->password_usuario, $user->password_usuario)) {
                    $user->api_token = Hash::make($user->nombre_usuario);
                    $user->save();
                    $response["msg"] = "Sesión iniciada.";
                    $response["token"] = $user->api_token;
                }else{
                    $response["msg"] = "Sesión incorrecta.";
                }
            } else {
                $response["msg"] = "Usuario incorrecto incorrecto";
            }
        } catch (\Exception $e) {
            $response["msg"] = "Error: " . $e->getMessage();
        }
        return response()->json($response);
    }

    //Recuperar contraseña

    public function recuperarPassword(Request $req) {
        $response = ['status'=> 1, 'msg'=>''];
        $JsonData = $req->getContent();
        $Data = json_decode($JsonData);
        $user = Usuario::where('email_usuario', $Data->email_usuario)->first();

        if($user) {
         $password = Str::random(15);
         $user->password_usuario = Hash::make($password);
         $user->save();
         $response['msg'] = 'Contraseña enviada';
         $response['contraseña'] = $password;
        }
        return response()->json($response);
    }

}




