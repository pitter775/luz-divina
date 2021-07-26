<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Local;
use App\Models\Municipio;
use Illuminate\Support\Facades\Session;
use PDOException;

class LocalController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){

        $locals = DB::table('locals AS l')
        ->join('municipios', 'municipios.id', '=', 'l.municipios_id')
        ->select('*', 'l.id AS id',)
        ->get();
        return view("pages.locals", compact('locals')); 
    }
    public function create(){
      $municipios = Municipio::all();
      return view('pages.locals_cadastro', compact('municipios'));        
    }
    public function store(Request $request){
        $id_local = $request->input('id_local');
        if($id_local == ''){
            // CADASTRA
            $local = new Local();
        }else{
            // ATUALIZA
            $local = Local::find($id_local);
        }
        $local->municipios_id = $request->input('municipios_id');
        $local->nm_local = $request->input('nm_local');
        $local->contato = $request->input('contato');
        $local->telefone = $request->input('telefone');
        $local->cep = $request->input('cep');
        $local->logradouro = $request->input('logradouro');
        $local->numero = $request->input('numero');
        $local->complemento = $request->input('complemento');
        $local->bairro = $request->input('bairro');
        $local->latitude = $request->input('latitude');
        $local->longitude = $request->input('longitude');
        $local->save();            
        return $local->id;         
        
    }
    public function edit($id){
        $dados_geral = DB::table('locals AS lc')
        ->join('municipios', 'municipios.id', '=', 'lc.municipios_id')
        ->select('*', 'lc.id AS id', 'lc.latitude As latitude', 'lc.longitude As longitude')
        ->where("lc.id", "=", $id)->first();

        $municipios = Municipio::all();
        return view('pages.locals_cadastro', compact('municipios','dados_geral'));    
    }
    public function destroy_local($id){
        $dados = Local::find($id);
        if(isset($dados)){
            try {
                $dados->delete();
                Session::put('message', 'Removido com sucesso!');
                return redirect("/locals");                
            }catch (PDOException $e) {
                if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
                    Session::put('message', 'Erro, esse <b>Local</b> esta em uso em outro relacionamento.');
                    return redirect("/locals");
                }
            }
        } 
    }
    public function geo($id){
        $locals = DB::table('municipios')
        ->where("municipios.id", $id)->get();
        
        return $locals;
        
    }
}
