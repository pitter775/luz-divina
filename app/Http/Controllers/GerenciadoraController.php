<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gerenciadora;
use App\Models\Municipio;
use App\Models\Gerenciadora_municipio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class GerenciadoraController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
       
        $dados_geral = Gerenciadora::all();
        return view("pages.gerenciadoras", compact('dados_geral'));
    }
    public function create(){
        $municipios = Municipio::all();
        return view('pages.gerenciadoras_cadastro', compact('municipios'));       
    }
    public function store(Request $request){
        $id_gerenciadora = $request->input('id_gerenciadora');
        $tem = DB::table('gerenciadoras')->where('cnpj', $request->input('cnpj'))->get();

        if($id_gerenciadora == ''){
            // CADASTRA
            if(!count($tem) == 0){
              return 'erro, Já existe o CNPJ cadastrada no sistema.';
          }
            $dados = new Gerenciadora();
        }else{
            // ATUALIZA
            $dados = Gerenciadora::find($id_gerenciadora);
        }
        $dados->nome = $request->input('nome');
        $dados->nome_abrev = $request->input('nome_abrev');
        $dados->lote = $request->input('lote');
        $dados->cnpj = $request->input('cnpj');
        $dados->contato = $request->input('contato');
        $dados->celular = $request->input('celular');
        $dados->telefone = $request->input('telefone');
        $dados->email = $request->input('email');
        $dados->status = $request->input('status');
        $dados->cep = $request->input('cep');
        $dados->endereco = $request->input('endereco');
        $dados->numero = $request->input('numero');
        $dados->complemento = $request->input('complemento');
        $dados->bairro = $request->input('bairro');
        $dados->cidade = $request->input('cidade');
        $dados->observacao = $request->input('observacao');
        $dados->estado = 'SP';
        $dados->save();            
        return $dados->id;
    }
    public function edit($id){
        $municipios = Municipio::all();
        $dados_geral = Gerenciadora::find($id);
        return view('pages.gerenciadoras_cadastro', compact('dados_geral','municipios'));    
    }    
    public function destroy($id){
        $dados = Gerenciadora::find($id);
        if(isset($dados)){
          try {
            $dados->delete();
            Session::put('message', 'Removido com sucesso!');
            return redirect("/gerenciadoras");                
          }catch (PDOException $e) {
              if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
                  Session::put('message', 'Erro, essa <b>Gerenciadora</b> esta em uso em outro relacionamento.');
                  return redirect("/gerenciadoras");
              }
          }
        }  
     }

     public function getVinculo($id){
        $dados_vinculos = DB::table('gerenciadora_municipios AS gm')
        ->join('gerenciadoras', 'gerenciadoras.id', '=', 'gm.gerenciadoras_id')
        ->join('municipios', 'municipios.id', '=', 'gm.municipios_id')
        ->join('regiaos', 'regiaos.id', '=', 'municipios.regiaos_id')
        ->where([
           ['gm.gerenciadoras_id', $id]
        ])
        ->select('*', 'gm.id AS id' , 'regiaos.nome As regnome', 'municipios.nome As munome')
        ->get();
        return  view('pages.gerenciadoras_vinculo', compact('dados_vinculos'));       
      }
  
      public function postVinculo(Request $request)
      {
        $tem = DB::table('gerenciadora_municipios')
        ->where([
          ['gerenciadoras_id', $request->input('id_gerenciadora')],
          ['municipios_id', $request->input('municipios_id')]
        ])
        ->get();
        if(count($tem) == 0){
          $regiao = new Gerenciadora_municipio();  
          $regiao->gerenciadoras_id = $request->input('id_gerenciadora');    
          $regiao->municipios_id = $request->input('municipios_id');  
          $regiao->save(); 
        }else{
          return 'erro, Já existe a cidade cadastrada para essa gerenciadora no sistema.';
        }
  
           
      }
      public function getVinculoDelete($id)
      {
  
        $delvinculo = Gerenciadora_municipio::find($id);
        if(isset($delvinculo)){
           $delvinculo->delete();
        }
  
      }
}
