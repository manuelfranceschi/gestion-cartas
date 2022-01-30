<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;

class usuarioAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $req, Closure $next)
    {
        $response = ['status'=> 0, 'msg'=>''];
        $JsonData = $req->getContent();
        $Data = json_decode($JsonData);

        try{
            $usuario = Usuario::where('api_token',$Data->api_token)->first();

            if($usuario->rol_usuario == 'Administrador'){
                $req->usuario = $usuario;
                return $next($req);
            }else{
                return response( 'El usuario no tiene los permisos necesarios');

            }
        }catch (\Exception $error){
            $response['msg'] = "Ha ocurrido un error ".$error->getMessage();
            $response['status'] = 0;
    } return response()->json($response);
}
}
