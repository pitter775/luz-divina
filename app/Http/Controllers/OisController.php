<?php

namespace App\Http\Controllers;

use App\Models\Andamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Local;
use App\Models\Acesso;
use App\Models\Area;
use App\Models\Municipio;
use App\Models\Servico_area;
use App\Models\Servico;
use App\Models\Contrato;
use App\Models\Cliente;
use App\Models\Servico_tipo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Session;
use PDOException;

class OisController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){  
        $objeto = new Acesso;
        $filtro = $objeto->perfil_acesso();
        $servicos = Servico_tipo::all();

        $ois = DB::select( DB::raw(
            "SELECT *, s.id AS id,  
            clientes.nome As clnome,
            servico_tipos.nome AS stnome,
            contratos.nome AS ctnome,
            contratos.codigo As codigo,
            locals.latitude As latitude,
            locals.longitude As longitude,
            municipios.nome As mnome
              FROM servicos As s
                LEFT JOIN locals ON locals.id = s.locals_id
                LEFT JOIN municipios ON municipios.id = locals.municipios_id
                LEFT JOIN gerenciadoras ON gerenciadoras.id = municipios.gerenciadora_id
                LEFT JOIN regiaos ON regiaos.id = municipios.regiaos_id
                LEFT JOIN servico_tipos ON servico_tipos.id = s.servico_tipos_id
                LEFT JOIN contratos ON contratos.id = s.contratos_id
                LEFT JOIN areas ON areas.id = contratos.areas_id
                LEFT JOIN clientes ON clientes.id = contratos.clientes_id                
                $filtro"            
            ) );
        return view("pages.ois", compact('ois','servicos'));
    }
    public function create(){
        $municipios = Municipio::all();
        $servicos_tipos = Servico_tipo::all();
        $locals = Local::all();
        $contratos = Contrato::all();
        $clientes = Cliente::all();
        $servicos = Servico_tipo::all();
        $areas = Area::all();
        return view('pages.ois_cadastro', compact('municipios','servicos_tipos', 'servicos', 'locals','contratos','clientes','areas'));        
    }
    public function store(Request $request){
        $id_ois = $request->input('id_ois');
        if($id_ois == ''){
            // CADASTRA
            $ois = new Servico();
        }else{
            // ATUALIZA
            $ois = Servico::find($id_ois);
        }
        $dt_ios = $request->input('dt_ios');
        $dt_ios = explode("/", $dt_ios);
        $dt_ios = $dt_ios[1].'/'.$dt_ios[0].'/'.$dt_ios[2]. ' 00:00:00';

        $prazo = $request->input('prazo');
        $prazo = explode("/", $prazo);
        $prazo = $prazo[1].'/'.$prazo[0].'/'.$prazo[2]. ' 00:00:00';


        $ois->descricao = $request->input('descricao');
        $ois->locals_id = $request->input('locals_id');
        $ois->servico_tipos_id = $request->input('servico_tipos_id');
        $ois->contratos_id = $request->input('contratos_id');
        $ois->dt_ios = (new DateTime($dt_ios))->format('Y-m-d H:i:s');
        $ois->prazo = (new DateTime($prazo))->format('Y-m-d H:i:s');
        $ois->valor = $request->input('valor');
        $ois->codigo_ois = $request->input('codigo_ois');
        $ois->descricao = $request->input('descricao');
        $ois->status = $request->input('status');
        $ois->areas_id = $request->input('areas');
        $ois->save();   
        // $areas =  $request->input('areas');

        // if(isset($areas)){        
        //     Servico_area::where('servicos_id', $ois->id)->delete();   
        //     foreach ($areas as $value){
        //       $dadoss = new Servico_area();
        //       $dadoss->servicos_id = $ois->id;
        //       $dadoss->areas_id = $value;
        //       $dadoss->save();   
        //     }      
        // }

        return $ois->id;
    }

    public function get_comboareas($id){

        $ids = explode("-", $id);

        $idcontrato = $ids[0];
        $idservico = $ids[1];
        if($idservico == 0){
            $idservico = null;
        }


        $combo = DB::table('contrato_areas AS ca')
        ->join('areas', 'areas.id', '=', 'ca.areas_id')
        ->where([['ca.contratos_id', $idcontrato]])
        ->select('*', 'areas.id AS id')
        ->get();

        

        if(isset($idservico)){
            $dados = Servico::find($idservico);
        }

        // return $dados;
        

        $html = '';
        $html .= ' <select class="table-group-action-input form-control" id="areas"  name="areas" required>';
        foreach($combo as $value){
            $select = '';
            if(isset($dados)){                
                if($value->id == $dados->areas_id){$select = 'selected';}
            }
           
            $html .= '<option dads="" value="'.$value->id.'" '.$select.'>'.$value->nome.'</option>   ';
        }
        $html .= '</select>';
        return $html;

    }

    public function get_comboservicos($id){

        $ids = explode("-", $id);

        $idcontrato = $ids[0];
        $idarea = $ids[1];


        $combo = DB::table('contrato_servicos AS ts')
        ->join('servico_tipos', 'servico_tipos.id', '=', 'ts.servico_tipos_id')
        ->join('areas', 'areas.id', '=', 'ts.areas_id')
        ->where([
            ['ts.contratos_id', $idcontrato],
            ['areas.id', $idarea]
        ])
        ->select('*', 'ts.id AS id', 'servico_tipos.nome As stnome', 'areas.nome As area_nome')
        ->get();      

        

        $html = '';
        $html .= ' <select class="table-group-action-input form-control"  name="areas" required>';
        foreach($combo as $value){           
            $html .= '<option dads="" value="'.$value->id.'">'.$value->stnome.'</option>   ';
        }
        $html .= '</select>';
        return $html;

    }
    public function store_andamento(Request $request){
        $andamentos_id = $request->input('andamentos_id');
        if($andamentos_id == ''){
            // CADASTRA
            $andamento = new Andamento();
            $andamento->servicos_id = $request->input('id_ois');
        }else{
            // ATUALIZA
            $andamento = Andamento::find($andamentos_id);
        }
        $dt_inicio = $request->input('dt_inicio');
        $dt_inicio = explode("/", $dt_inicio);
        $dt_inicio = $dt_inicio[1].'/'.$dt_inicio[0].'/'.$dt_inicio[2]. ' 00:00:00';


        $dt_fim = $request->input('dt_fim');
        $dt_fim = explode("/", $dt_fim);
        $dt_fim = $dt_fim[1].'/'.$dt_fim[0].'/'.$dt_fim[2]. ' 00:00:00';
        
        $andamento->servico = $request->input('servico');        
        $andamento->atividade = $request->input('atividade');
        if($request->input('valor_andamento') != ''){$andamento->valor_andamento = $request->input('valor_andamento');}
        $andamento->dt_inicio = (new DateTime($dt_inicio))->format('Y-m-d H:i:s');
        $andamento->dt_fim = (new DateTime($dt_fim))->format('Y-m-d H:i:s');
        $andamento->resumo = $request->input('resumo');
        $andamento->users_id = Auth::user()->id; 
        $andamento->save();



        return $andamento->id;
    }
    public function edit($id){

        $dados_geral = DB::table('servicos AS o')
        ->leftjoin('servico_tipos', 'servico_tipos.id', '=', 'o.servico_tipos_id')
        // ->join('contrato_servicos', 'contrato_servicos.id', '=', 'o.servico_tipos_id')
        ->leftjoin('locals', 'locals.id', '=', 'o.locals_id')
        ->join('contratos', 'contratos.id', '=', 'o.contratos_id')
        ->join('clientes', 'clientes.id', '=', 'contratos.clientes_id')
        ->select('*', 'o.id AS id', 'o.status As status', 'clientes.id As clid', 'clientes.nome As clnome','contratos.id As ctiid', 'contratos.nome As ctnome', 'servico_tipos.nome As stnome' )
        ->where("o.id", "=", $id)->first();

        $contratos = DB::table('contratos AS ct')
        ->join('clientes', 'clientes.id', '=', 'ct.clientes_id')
        ->select('ct.id As id', 'ct.nome As nome')
        ->where("ct.clientes_id", "=", $dados_geral->clid)
        ->get();

        $servicos_tipos = DB::table('contrato_servicos AS ts')
        ->join('servico_tipos', 'servico_tipos.id', '=', 'ts.servico_tipos_id')
        ->where([
            ['ts.contratos_id', $dados_geral->ctiid]
        ])
        ->select('*', 'ts.id AS id', 'servico_tipos.id As sid', 'servico_tipos.nome As snome')
        ->get();

        $contrato_areas = DB::table('contrato_areas AS ca')
        ->join('contratos', 'contratos.id', '=', 'ca.contratos_id')
        ->where([
            ['ca.contratos_id', $dados_geral->ctiid]
        ])
        ->select('*', 'ca.contratos_id AS id')
        ->get();

        // $servico_areas = DB::table('servico_areas AS sa')
        // ->where([['sa.servicos_id', $id]])
        // ->get();

        // $servicos = Servico_tipo::all();
        // $areas = Area::all();
       
        $clientes = Cliente::all();        
        $locals = Local::all();        

        return view('pages.ois_cadastro', compact('dados_geral','servicos_tipos','locals','contratos','clientes','contrato_areas'));    
    }    
    public function getContratos($id){
        $contratos = DB::table('contratos')->where('clientes_id', $id)->get();
        return $contratos;
    }
    public function getservicos($id){
        // $tipo_servicos = DB::table('servico_tipos As st')
        //   ->join('contrato_servicos', 'contrato_servicos.servico_tipos_id', '=', 'st.id')
        // //   ->join('tipo_contratos', 'tipo_contratos.id', '=', 'tipocontrato_servicos.tipo_contratos_id')
        //   ->join('contratos', 'contratos.id', '=', 'contrato_servicos.id')
        // ->where([
        //     ['contratos.id',$id]
        // ])       
        //  ->select('st.id As id', 'st.nome As nome')
        // ->get();

        $tipo_servicos = DB::table('contrato_servicos AS ts')
        ->join('servico_tipos', 'servico_tipos.id', '=', 'ts.servico_tipos_id')
        ->where([
            ['ts.contratos_id', $id]
        ])
        ->select('*', 'ts.id AS id')
        ->get();
        return $tipo_servicos;
    }  
    public function destroy_ois_andamento($id){
        $dados = Andamento::find($id);
        if(isset($dados)){
            try {
                $dados->delete();
                return 'Removido com sucesso!';       
            }catch (PDOException $e) {
                if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
                    return 'Erro, esse <b>Andamento</b> esta em uso em outro relacionamento.';
                }
            }
        }
    }  
    public function destroy_ois($id){
        $dados = Servico::find($id);
        if(isset($dados)){
            try {
                $dados->delete();
                Session::put('message', 'Removido com sucesso!');
                return redirect("/ois");                
            }catch (PDOException $e) {
                if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
                    Session::put('message', 'Erro, essa <b>Ordem de serviço</b> esta em uso em outro relacionamento.');
                    return redirect("/ois");
                }
            }
        }  
    }
    public function getandamento($id){
        $andamentos = DB::table('andamentos AS an')
        ->join('users', 'users.id', '=', 'an.users_id')
        ->where([
            ['an.servicos_id', $id] 
        ])
        ->select('*', 'an.id AS id')
        ->orderBy('an.id', 'desc')
        ->get();
        return  view('pages.ois_andamento', compact('andamentos'));       
    }
    public function getVerFotos($id){
        $andamentos_id = $id;

        $fotos = DB::table('anexos AS ax')        
        ->where([
            ['ax.andamentos_id', $id]
        ])
        ->get();
        return  view('pages.ois_andamento_fotos', compact('fotos','andamentos_id')); 
    
    }
    public function getVerFotosTb($id){
        $fotos = DB::table('anexos AS ax')        
        ->where([
            ['ax.andamentos_id', $id]
        ])
        ->get();
        $htmlimg = '';
        $cont = 0;
        foreach($fotos as $value){
            $active = '';
            if($cont == 0){
                $active = 'active'; 
            }

            $htmlimg .= '<div class="carousel-item '.$active.'">
                            <img class="d-block w-100" data-src="holder.js/800x400?auto=yes&amp;bg=777&amp;fg=555&amp;text=Primeiro Slide" alt="Primeiro Slide [800x400]" 
                            src="/storage/'.$value->arquivo.'" data-holder-rendered="true">
                        </div>';
            $cont = $cont + 1;

            // $htmlimg .= "<a href='/storage/".$value->arquivo."' target='_blank'><img class='imgtb zoom ' src='/storage/".$value->arquivo."' alt='...'></a>";
        }
        return  $htmlimg;    
    }
    public function editandamento($id){
        $dados_geral = DB::table('andamentos AS ad')->where("ad.id", "=", $id)->first();
        // $servicos = Servico_tipo::all();
        $ois = DB::table('servicos AS s')->where("s.id", "=", $dados_geral->servicos_id)->first();

        $servicos = DB::table('contrato_servicos AS ts')
        ->join('servico_tipos', 'servico_tipos.id', '=', 'ts.servico_tipos_id')
        ->where([
            ['ts.contratos_id', $ois->contratos_id]
        ])
        ->select('*', 'ts.id AS id')
        ->get();
        


        return  view('pages.ois_andamento_editar', compact('dados_geral','servicos'));     
    }
    public function gettipocontrato($id){
        $contratos = DB::table('contratos AS ct')
        ->join('tipo_contratos', 'tipo_contratos.id', '=', 'ct.tipo_contratos_id')
        ->select('tipo_contratos.nome As tiponome')
        ->where("ct.id", "=", $id)->first();
        $nome = 'Não Cadastrado';
        if(isset($contratos->tiponome))
        {
            $nome = $contratos->tiponome;
        }
        return $nome;
    }
    public function getcomboservico($id){

        $servicos_tipos = DB::table('contrato_servicos AS ts')
        ->join('servico_tipos', 'servico_tipos.id', '=', 'ts.servico_tipos_id')
        ->where([
            ['ts.contratos_id', $id]
        ])
        ->select('*', 'ts.id AS id', 'servico_tipos.id As sid', 'servico_tipos.nome As snome')
        ->get();

        $html = '';       
        $html .= '<select class="table-group-action-input form-control" name="servico" required>';       
        $html .= '<option value="" disabled selected>Selecione</option>';        
        foreach($servicos_tipos as $value){
            $html .= '<option value="'.$value->snome.'">'.$value->snome.'</option>';
        }
        $html .='</select>';
        return $html;
    }
    
}
