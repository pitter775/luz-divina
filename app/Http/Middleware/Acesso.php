<?php

namespace App\Http\Middleware;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;

class Acesso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // public function handle(Request $request, Closure $next)
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $pagina_atual = Route::getFacadeRoot()->current()->uri();
        $acesso = true;
        $urls = [];

        //echo "<script>console.log('$pagina_atual')</script>";

        // Route::get('/home/getpoints', 'App\Http\Controllers\HomeController@getpoints');
        // Route::get('/home/getpoints/local', 'App\Http\Controllers\HomeController@getpointslocal');
        // Route::get('/home/carregar_filtros', 'App\Http\Controllers\HomeController@carregar_filtros');
        // Route::get('/home/ver_ois/{id}', 'App\Http\Controllers\HomeController@ver_ois');

        if(Auth::user()->acesso == 'Admin'){ 
            $acesso = true;
        }
        if(Auth::user()->acesso == 'Consulta'){
            $urls = ['clientes', 'ver_contrato', 'clientes/ver_contratos/{id}', 'ois','home',
            'ois',  'ois/cadastro','ois/cadastro/{id}', 'ois/delete', 'anexos','ois/gettipocontrato/{id}',
            'home/ver_ois','home/carregar_filtros', 'home/ver_ois/{id}',            
            'clientes','clientes/cadastro', 'ver_contrato', 'clientes/cadastro/{id}', 'clientes/delete', 'clientes/ver_contratos','clientes/ver_contratos/{id}',
            'ois/andamento','ois/andamento/{id}','ois/andamento/cadastro','ois/andamento/edit/{id}','ois/andamento/delete/{id}', 'ois/ver_fotos/{id}', 'ois/getcomboservico/{id}', 'ois/ver_fotos_tb/{id}',];
        }
        if(Auth::user()->acesso == 'Vendedor'){
            if(Auth::user()->tipo_gestor == 'GestorADM' || Auth::user()->tipo_gestor == 'CDHU'){
                $urls = [
                    'home','home/ver_ois','home/carregar_filtros', 'home/ver_ois/{id}',   
                    'clientes','clientes/cadastro', 'ver_contrato', 'clientes/cadastro/{id}', 'clientes/delete', 'clientes/ver_contratos','clientes/ver_contratos/{id}',
                    'contratos', 'contratos/cadastro','contratos/cadastro/{id}', 'contratos/delete', 
                                 'contratos/anexos/{id}','contratos/anexos/delete/{id}','contratos/anexos','anexos','anexos/delete/{id}',
                                 'contratos/ver_aditivos','contratos/ver_aditivos/{id}','contratos/aditivos/{id}','contratos/aditivos','contratos/aditivos/delete/{id}', 'contratos/aditivos/edit/{id}',  
                                 'contratos/servicos','contratos/servicos/{id}','contratos/ver_servicos/{id}', 
                    'locals', 'locals/cadastro','locals/cadastro/{id}', 'locals/delete', 
                    'areas', 'areas/cadastro','areas/cadastro/{id}', 'areas/delete', 
                    'ois',  'ois/cadastro','ois/cadastro/{id}', 'ois/delete', 'ois/gettipocontrato/{id}','ois/getcontratos/{id}',
                            'ois/andamento','ois/andamento/{id}','ois/andamento/cadastro','ois/andamento/edit/{id}','ois/andamento/delete/{id}', 'ois/ver_fotos/{id}','ois/ver_fotos_tb/{id}','ois/getcomboservico/{id}',
                    'servico_tipos', 'servico_tipos/cadastro','servico_tipos/cadastro/{id}', 'servico_tipos/delete',                     
                    'regiaos', 'regiaos/cadastro','regiaos/cadastro/{id}', 'regiaos/delete', 'regiaos/vinculos', 'regiaos/vinculos/delete', 'regiaos/tabela',
                    'gerenciadoras', 'gerenciadoras/cadastro','gerenciadoras/cadastro/{id}', 'gerenciadoras/delete', 'gerenciadoras/vinculos', 'gerenciadoras/vinculos/delete', 
                    'tipo_contratos', 'tipo_contratos/cadastro','tipo_contratos/cadastro/{id}', 'tipo_contratos/delete', 
                                      'tipo_contratos/anexos/{id}','tipo_contratos/anexos/delete/{id}','tipo_contratos/anexos',                    
                ];
            }
            if(Auth::user()->tipo_gestor == 'Gestor' || Auth::user()->tipo_gestor == 'Técnico'){
                $urls = [
                    'home','ois', 'ois/cadastro','ois/cadastro/{id}', 'ois/delete',
                    'ois',  'ois/cadastro','ois/cadastro/{id}', 'ois/delete', 'ois/gettipocontrato/{id}','ois/getcontratos/{id}',
                            'ois/andamento','ois/andamento/{id}','ois/andamento/cadastro','ois/andamento/edit/{id}','ois/andamento/delete/{id}', 'ois/ver_fotos/{id}','ois/ver_fotos_tb/{id}','ois/getcomboservico/{id}',
                    'servico_tipos', 'servico_tipos/cadastro','servico_tipos/cadastro/{id}', 'servico_tipos/delete',  
                    'contratos', 'contratos/cadastro','contratos/cadastro/{id}', 'contratos/delete', 
                            'contratos/anexos/{id}','contratos/anexos/delete/{id}','contratos/anexos','anexos','anexos/delete/{id}',
                            'contratos/ver_aditivos','contratos/ver_aditivos/{id}','contratos/aditivos/{id}','contratos/aditivos','contratos/aditivos/delete/{id}', 'contratos/aditivos/edit/{id}',  
                            'contratos/servicos','contratos/servicos/{id}','contratos/ver_servicos/{id}',           
                ];
            }
        }        
        foreach($urls as $value){
            if($pagina_atual == $value){
                $acesso = true;
            }
        }
        if($acesso){
            return $next($request);
        }else{
            return redirect()->route('home');
        }
    }
}
