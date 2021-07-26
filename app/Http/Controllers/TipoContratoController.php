<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipo_contrato;
use App\Models\Servico_tipo;
use App\Models\Tipocontrato_servico;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class TipoContratoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index() {
        $dados_geral = Tipo_contrato::all();
        return view("pages.tipo_contratos", compact('dados_geral'));
    }
    public function create(){        
        $servicos = Servico_tipo::all();
        return view('pages.tipo_contratos_cadastro', compact('servicos'));   
    }
    public function store(Request $request){
        $id_tipo_contrato = $request->input('id_tipo_contrato');
        $tem = DB::table('tipo_contratos')->where('nome', $request->input('nome'))->get();       

        if($id_tipo_contrato == ''){
            // CADASTRA
            if(!count($tem) == 0){
                return 'erro, Já existe o tipo de contrato cadastrado no sistema.';
            }
            $dados = new Tipo_contrato();
        }else{
            // ATUALIZA
            $dados = Tipo_contrato::find($id_tipo_contrato);
        }
        $dados->nome = $request->input('nome');
        $dados->save();            
        return $dados->id;
    }
    public function edit($id){
        $dados_geral = Tipo_contrato::find($id);
        $servicos = Servico_tipo::all();
        return view('pages.tipo_contratos_cadastro', compact('dados_geral','servicos'));  
    }
    public function postAnexo(Request $request){

        $tem = DB::table('tipocontrato_servicos As ts')
        ->where([
            ['ts.servico_tipos_id',$request->input('id_servicos')],
            ['ts.tipo_contratos_id',$request->input('id_tipo_contrato')]
        ])
        ->get();
        if(!count($tem) == 0){
            return 'erro, Já existe o servico para esse tipo de contrato no sistema.';
        }
        $dados = new Tipocontrato_servico();
        $dados->tipo_contratos_id = $request->input('id_tipo_contrato');
        $dados->servico_tipos_id = $request->input('id_servicos');
        $dados->save();            
        return $dados->id;
    }
    public function getAnexo($id){
        //$anexos = Tipocontrato_servico::where('tipo_contratos_id', $id)->get();
        $anexos = DB::table('tipocontrato_servicos AS ts')
        ->join('servico_tipos', 'servico_tipos.id', '=', 'ts.servico_tipos_id')
        ->where([
            ['ts.tipo_contratos_id', $id]
        ])
        ->select('*', 'ts.id AS id')
        ->get();
        return   view('pages.tipo_contratos_cadastro_anexo', compact('anexos'));       
    }
    public function getAnexoDelete($id){   

        $delanexo = Tipocontrato_servico::find($id);
        if(isset($delanexo)){
           $delanexo->delete();
        }
  
      } 
    public function destroy($id)
    {
        $dados = Tipo_contrato::find($id);
        if(isset($dados)){
            try {
                $dados->delete();
                Session::put('message', 'Removido com sucesso!');
                return redirect("/tipo_contratos");                
            }catch (PDOException $e) {
                if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
                    Session::put('message', 'Erro, esse <b>Tipo de Contratos</b> esta em uso em outro relacionamento.');
                    return redirect("/tipo_contratos");
                }
            }
        }
    }
}
