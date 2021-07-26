<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contrato;
use App\Models\Cliente;
use App\Models\Aditivo;
use App\Models\Municipio; 
use App\Models\Contrato_area; 
use App\Models\Anexo;
use App\Models\Area;
use App\Models\Contrato_servico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Tipo_contrato;
use App\Models\Servico_tipo;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Session;
use App\Models\Filtro;
use PDOException;
class ContratoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){
        $filtro = new Filtro();
        $contratos = $filtro->sql_filtros_contratos();
        return view("pages.contratos", compact('contratos')); 
    }
    public function get_comboservicos($id){
        $combo = DB::table('contrato_areas AS ca')
        ->join('areas', 'areas.id', '=', 'ca.areas_id')
        ->where([['ca.contratos_id', $id]])
        ->select('*', 'areas.id AS id')
        ->get();

        $html = '';
        $html .= ' <select class="table-group-action-input form-control"  name="areas" required>';
        foreach($combo as $value){
            $html .= '<option value="'.$value->id.'">'.$value->nome.'</option>   ';
        }
        $html .= '</select>';
        return $html;

    }
    public function create(){
      $clientes = Cliente::all();
      $municipios = Municipio::all();
      $tipo_contrato = Tipo_contrato::all();
      $servicos = Servico_tipo::all();
      $areas = Area::all();
      return view('pages.contratos_cadastro', compact('clientes','municipios','tipo_contrato','servicos','areas'));        
    }
    public function store(Request $request){
        $id_contrato = $request->input('id_contrato');
        
        if($id_contrato == ''){
            // CADASTRA
            $contrato = new Contrato();
        }else{
            // ATUALIZA
            $contrato = Contrato::find($id_contrato);
        }

        $dt_base = $request->input('dt_base');
        $dt_base = explode("/", $dt_base);
        $dt_base = $dt_base[1].'/'.$dt_base[0].'/'.$dt_base[2]. ' 00:00:00';

        $dt_assinatura = $request->input('dt_assinatura');
        $dt_assinatura = explode("/", $dt_assinatura);
        $dt_assinatura = $dt_assinatura[1].'/'.$dt_assinatura[0].'/'.$dt_assinatura[2]. ' 00:00:00';

        $dt_ois = $request->input('dt_ois');
        $dt_ois = explode("/", $dt_ois);
        $dt_ois = $dt_ois[1].'/'.$dt_ois[0].'/'.$dt_ois[2]. ' 00:00:00';

        $contrato->codigo = $request->input('codigo');
        $contrato->clientes_id = $request->input('clientes_id');        
        $contrato->nome = $request->input('nome');
        $contrato->dt_base =  $dt_base;
        $contrato->dt_assinatura = $dt_assinatura;
        $contrato->dt_ois = $dt_ois;
        $contrato->status = $request->input('status');
        $contrato->observacao = $request->input('observacao');
        $contrato->tipo_contratos_id = $request->input('tipo_contrato_id');
        // $contrato->areas_id = $request->input('areas_id');
        $contrato->save();  
        $areas_id =  $request->input('areas_id');
        if(isset($areas_id)){        
            Contrato_area::where('contratos_id', $contrato->id)->delete();   
            foreach ($areas_id as $value){
              $dadoss = new Contrato_area();
              $dadoss->contratos_id = $contrato->id;
              $dadoss->areas_id = $value;
              $dadoss->save();   
            }      
        }
        return $contrato->id;
    }
    public function edit($id){
      $dados_geral = DB::table('contratos AS ct')
      ->join('clientes', 'clientes.id', '=', 'ct.clientes_id')
      ->leftjoin('areas', 'areas.id', '=', 'ct.areas_id')
      ->leftjoin('tipo_contratos', 'tipo_contratos.id', '=', 'ct.tipo_contratos_id')
      ->select('*', 'ct.id AS id','ct.nome AS ctnome','ct.observacao As ctobservacao', 'ct.codigo AS ctcodigo', 'clientes.nome As clnome', 'tipo_contratos.id As tcid', 'tipo_contratos.nome As tcnome','areas.id As aid', 'areas.nome As anome')
      ->orderBy('ct.id', 'desc')
      ->where("ct.id", "=", $id)->first();
      $tipo_contrato = Tipo_contrato::all();
      $clientes = Cliente::all();
      $servicos = Servico_tipo::all();
      $areas = Area::all();
      $contratoAreas = Contrato_area::where('contratos_id', $id)->get();   

      return view('pages.contratos_cadastro', compact('clientes','dados_geral','tipo_contrato','servicos','areas','contratoAreas'));    
    }
    public function destroy_contrato($id){
        $contrato = Contrato::find($id);
        if(isset($contrato)){
            try {
                $contrato->delete();
                Session::put('message', 'Removido com sucesso!');
                return redirect("/contratos");                
            }catch (PDOException $e) {
                if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
                    Session::put('message', 'Erro, esse <b>Contrato</b> esta em uso em outro relacionamento.');
                    return redirect("/contratos");
                }
            }
        }
  
    }
    public function getAditivo($id){
        $aditivos = DB::table('aditivos AS ud')
        ->join('contratos', 'contratos.id', '=', 'ud.contratos_id')
        ->where([
            ['ud.contratos_id', $id]
        ])
        ->select('*', 'ud.id AS id')
        ->get();
        return  view('pages.contratos_aditivos', compact('aditivos'));       
    }
    public function postAditivo(Request $request){ 
        $dt_vigencia = $request->input('dt_vigencia');
        $dt_vigencia = explode("/", $dt_vigencia);
        $dt_vigencia = $dt_vigencia[1].'/'.$dt_vigencia[0].'/'.$dt_vigencia[2]. ' 00:00:00';
        $jatem = false;
        $jatem2 = false;
        $tem = DB::table('aditivos')
            ->where('contratos_id', $request->input('id_contrato'))
            // ->orWhere('aditivos.id', $request->input('aditivos_id'))
            ->get();
        foreach($tem as $value){
            if($value->id == $request->input('aditivos_id')){
                  
            }else{
                 
                if($value->nr_termo == $request->input('nr_termo')){return 'erro, Já existe aditivo com o mesmo Termo, Vignecia ou Valor cadastrado no sistema.';}
                if($value->dt_vigencia == $dt_vigencia){return 'erro, Já existe aditivo com o mesmo Termo, Vignecia ou Valor cadastrado no sistema.';}
                if($value->vlr_atual == $request->input('vlr_atual')){return 'erro, Já existe aditivo com o mesmo Termo, Vignecia ou Valor cadastrado no sistema.';} 
            }
        }

        $aditivos_id = $request->input('aditivos_id');
        
        if($aditivos_id == ''){
            // CADASTRA
            $aditivo = new Aditivo();  
            $aditivo->contratos_id = $request->input('id_contrato');   
        }else{
            // ATUALIZA
            $aditivo = Aditivo::find($aditivos_id);            
        }
        $aditivo->objeto = $request->input('objeto');  
        $aditivo->dt_vigencia = $dt_vigencia;  
        $aditivo->vlr_atual = $request->input('vlr_atual');  
        $aditivo->nr_termo = $request->input('nr_termo');  
        $aditivo->save();    
    }
    public function getAditivoDelete($id){

      $deladitivo = Aditivo::find($id);
      if(isset($deladitivo)){
         $deladitivo->delete();
      }

    }   
    public function getVerAditivos($id){
        $contratos = Contrato::find($id);
        $aditivos = DB::table('aditivos AS ad')
        ->where([
            ['ad.contratos_id', $id]
        ])
        ->get();
        return  view('pages.contratos_modal_veraditivos', compact('aditivos','contratos'));       
    }
    public function getVerServicos($id){
        $contratos = Contrato::find($id);
        $servicos = DB::table('contrato_servicos AS ts')
        ->join('servico_tipos', 'servico_tipos.id', '=', 'ts.servico_tipos_id')
        ->where([
            ['ts.contratos_id', $id]
        ])
        ->select('*', 'ts.id AS id')
        ->get();
        
        return  view('pages.contratos_modal_verservicos', compact('servicos','contratos'));       
    }
    public function postServico(Request $request){

        $tem = DB::table('contrato_servicos As cs')
        ->where([
            ['cs.contratos_id',$request->input('id_contrato')],
            ['cs.servico_tipos_id',$request->input('id_servicos')],
            ['cs.areas_id',$request->input('areas')]
        ])
        ->get();
        if(!count($tem) == 0){
            return 'erro, Já existe o servico para esse tipo de contrato no sistema.';
        }
        $dados = new Contrato_servico();
        $dados->contratos_id = $request->input('id_contrato');
        $dados->servico_tipos_id = $request->input('id_servicos');
        $dados->areas_id = $request->input('areas');
        $dados->save();            
        return $dados->id;
    }
    public function getServico($id){
        $servicos = DB::table('contrato_servicos AS ts')
        ->join('servico_tipos', 'servico_tipos.id', '=', 'ts.servico_tipos_id')
        ->leftjoin('areas', 'areas.id', '=', 'ts.areas_id')
        ->where([
            ['ts.contratos_id', $id]
        ])
        ->select('*', 'ts.id AS id', 'servico_tipos.nome As stnome', 'areas.nome As area_nome')
        ->get();

        


        return   view('pages.contratos_servicos', compact('servicos'));       
    }
    public function getServicoDelete($id){   

        $delanexo = Contrato_servico::find($id);
        if(isset($delanexo)){
           $delanexo->delete();
        }
  
    } 

    public function editaditivo($id){
        $dados_geral = DB::table('aditivos AS ad')->where("ad.id", "=", $id)->first();
        return  view('pages.contratos_aditivo_editar', compact('dados_geral'));     
    }

   
    
}
