<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;

class checkApiToken
{
    public function handle(Request $request, Closure $next)
    {
        try{
            if($request->has('api_token')){
                $token = $request->input('api_token');
                $user = Usuario::where('api_token',$token->first());
                if(!$user){
                    return response('No tienes un api token valido');
                }else{
                    return response('No se ha encontrado un api token valido');
                }
            }
        }
        catch (\Exception $error){
            $response['msg'] = "Ha ocurrido un error al añadir el usuario: ".$error->getMessage();
            $response['status'] = 0;
        }
    }
}
