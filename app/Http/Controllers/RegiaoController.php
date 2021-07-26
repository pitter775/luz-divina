<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use Illuminate\Http\Request;

use App\Models\Regiao;
use App\Models\Regiao_cidade;
use App\Models\Gerenciadora_municipio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class RegiaoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){       
        $dados_geral = Regiao::all();
        return view("pages.regiaos", compact('dados_geral'));
    }
    public function create(){

        $cidades = Municipio::all();        
        return view('pages.regiaos_cadastro', compact('cidades'));        
    }
    public function store(Request $request){
        $id_regiao = $request->input('id_regiao');
        $tem = DB::table('regiaos')->where('nome', $request->input('nome'))->get();
        if($id_regiao == ''){
            // CADASTRA
            if(!count($tem) == 0){
                return 'erro, Já existe a região cadastrada no sistema.';
            }
            $dados = new Regiao();
        }else{
            // ATUALIZA
            $dados = Regiao::find($id_regiao);
        }
        $dados->nome = $request->input('nome');
        $dados->save();            
        return $dados->id;
    }
    public function edit($id){

        $dados_geral = Regiao::find($id);
        $cidades = DB::table('municipios')->orderBy('nome','asc')->get();
        return view('pages.regiaos_cadastro', compact('dados_geral','cidades'));    
    }
    public function postVinculo(Request $request){
      $tem = DB::table('regiao_cidades')
      ->where([
        ['regiaos_id', $request->input('id_regiao')],
        ['municipios_id', $request->input('id_cidade')]
      ])
      ->get();
      if(count($tem) == 0){
        $regiao = new Regiao_cidade();  
        $regiao->regiaos_id = $request->input('id_regiao');    
        $regiao->municipios_id = $request->input('id_cidade');  
        $regiao->save(); 
      }else{
        return 'erro, Já existe a Cidade cadastrada para essa Região no sistema.';
      }

         
    }
    public function getVinculo($id){
        $regiaos_cidades = DB::table('regiao_cidades AS rc')
        ->join('regiaos', 'regiaos.id', '=', 'rc.regiaos_id')
        ->join('municipios', 'municipios.id', '=', 'rc.municipios_id')
        ->where([
           ['regiaos.id', $id]
        ])
        ->select('*', 'rc.id As id', 'municipios.nome As nome') 
        ->get();
        return  view('pages.regiaos_cidades', compact('regiaos_cidades'));
    }    
    public function destroy($id){
        $dados = Regiao::find($id);
        if(isset($dados)){
            try {
                $dados->delete();
                Session::put('message', 'Removido com sucesso!');
                return redirect("/regiaos");                
            }catch (PDOException $e) {
                if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
                    Session::put('message', 'Erro, essa <b>Região</b> esta em uso em outro relacionamento.');
                    return redirect("/regiaos");
                }
            }
        }  
    }
    public function getVinculoDelete($id){

      $delvinculo = Regiao_cidade::find($id);
      if(isset($delvinculo)){
         $delvinculo->delete();
      }

    }

    public function tabelateste(){     
        // $cidades = DB::table('municipios')->get();
        // $cont = 0;
        // foreach($cidades as $value){
        //     $tem = DB::table('regiao_cidades')
        //     ->where([['regiaos_id', $value->regiaos_id],['municipios_id', $value->id]])->get();
        //     if(count($tem) == 0){
        //         $regiao = new Regiao_cidade();  
        //         $regiao->regiaos_id = $value->regiaos_id;    
        //         $regiao->municipios_id = $value->id;  
        //         $regiao->save(); 
        //         $cont = $cont + 1; 
        //       }            
        // }
        // return 'feito! -> '.$cont;

        $cidades = DB::table('municipios')->get();
        $cont = 0;
        foreach($cidades as $value){
            $tem = DB::table('gerenciadora_municipios')
            ->where([['gerenciadoras_id', $value->gerenciadora_id],['municipios_id', $value->id]])->get();
            if(count($tem) == 0){
                $regiao = new Gerenciadora_municipio();  
                $regiao->gerenciadoras_id = $value->gerenciadora_id;    
                $regiao->municipios_id = $value->id;  
                $regiao->save(); 
                $cont = $cont + 1; 
              }            
        }
        return 'feito gerenciadoras! -> '.$cont;
    }
}
