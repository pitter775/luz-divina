<?php

namespace App\Http\Controllers;

use App\Models\Acesso;
use App\Models\Filtro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Contrato;
use App\Models\Cliente;
use App\Models\Local;
use App\Models\Aditivo;
use App\Models\Municipio;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('pages.home'); 
    }

    public function getservicos(){
        $tem = DB::table('servico_tipos')->orderBy('servico_tipos.nome', 'desc')->get();
        return $tem;
    }



    public function teste($id = 64){
        $servicos = DB::table('contrato_servicos AS ts')
        ->join('servico_tipos', 'servico_tipos.id', '=', 'ts.servico_tipos_id')
        ->leftjoin('areas', 'areas.id', '=', 'ts.areas_id')
        ->where([
            ['ts.contratos_id', $id]
        ])
        ->select('*', 'ts.id AS id', 'servico_tipos.nome As stnome', 'areas.nome As area_nome')
        ->get();

        return $servicos;
    }

    public function ver_ois($id){
        $dados_geral = DB::table('servicos AS o')
        ->leftjoin('servico_tipos', 'servico_tipos.id', '=', 'o.servico_tipos_id')
        // ->join('contrato_servicos', 'contrato_servicos.id', '=', 'o.servico_tipos_id')
        ->leftjoin('locals', 'locals.id', '=', 'o.locals_id')
        ->leftjoin('contratos', 'contratos.id', '=', 'o.contratos_id')
        ->leftjoin('tipo_contratos', 'tipo_contratos.id', '=', 'contratos.tipo_contratos_id')
        
        ->leftjoin('clientes', 'clientes.id', '=', 'contratos.clientes_id')
        ->select('*', 'o.id AS id', 'o.status As status', 'tipo_contratos.nome As tcnome', 'clientes.id As clid','locals.bairro As lbairro', 'clientes.nome As clnome','contratos.id As ctiid', 'contratos.nome As ctnome', 'servico_tipos.nome As stnome' )
        ->where("o.id", $id)->first();

        $contratos = DB::table('contratos AS ct')
        ->join('clientes', 'clientes.id', '=', 'ct.clientes_id')
        ->select('ct.id As id', 'ct.nome As nome')
        ->where("ct.clientes_id", "=", $dados_geral->clid)->get();

        $servicos_tipos = DB::table('contrato_servicos AS ts')
        ->join('servico_tipos', 'servico_tipos.id', '=', 'ts.servico_tipos_id')
        ->where([
            ['ts.contratos_id', $dados_geral->ctiid]
        ])
        ->select('servico_tipos.nome As stnome')
        ->get();



        $clientes = Cliente::all();        
        $locals = Local::all();        

        return view('pages.dashboard_modal_ois', compact('dados_geral','servicos_tipos','locals','contratos','clientes'));   
        

    }

    public function carregar_filtros(){ 
        $filtro = new Filtro;
        $servicos = $filtro->sql_filtros('servico_tipos.nome','servico_tipos.id AS id , servico_tipos.nome AS nome');
        $regiaos = $filtro->sql_filtros('regiaos.nome','regiaos.id AS id , regiaos.nome AS nome');
        $municipios = $filtro->sql_filtros('municipios.nome','municipios.id AS id , municipios.nome AS nome');        
        $gerenciadoras = $filtro->sql_filtros('gerenciadoras.nome','gerenciadoras.id AS id , gerenciadoras.nome AS nome');
        $clientes = $filtro->sql_filtros('clientes.nome','clientes.nome_abrev As nomeabrev, clientes.id AS id , clientes.nome AS nome');       
        $tipo_contratos = $filtro->sql_filtros('tipo_contratos.nome','tipo_contratos.nome As tcnome, tipo_contratos.id AS tid');       

        // $tipo_contratos = DB::table('servicos AS sv')
        // ->join('contratos', 'contratos.id', '=', 'sv.contratos_id')
        // ->join('tipo_contratos', 'tipo_contratos.id', '=', 'contratos.tipo_contratos_id')
        // ->where([
        //     ['ts.contratos_id', $dados_geral->ctiid]
        // ])
        // ->select('*', 'ts.id AS id', 'servico_tipos.id As sid')
        // ->get();







        return view('pages.dashboard_filtros', compact('servicos','regiaos','municipios','gerenciadoras', 'clientes','tipo_contratos')); 
    }

    public function getpointslocal(Request $request){
        //quando clica no alfinete para abrir o card 

        $filtro = '';
        $and = '';

              
        // filtro de perfil de acesso
        $objeto = new Acesso;
        $filtro .= $objeto->perfil_acesso();

        

        if($request->idlocal != null){
            if($filtro != null){ $and = ' AND';}
            if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
            $filtro .="$and $where locals.id = '$request->idlocal' ";
        }

        // if($request->servico != null){
        //     if($filtro != null){ $and = ' AND';}
        //     if($filtro == null){ $where = 'WHERE ';}else{$where = ''; }
        //     $filtro .=" $and $where servico_tipos.id IN ($request->servico) ";
        // }

        if($request->tipo_contrato != null){
            if($filtro != null){ $and = 'AND';}
            if($filtro == null){ $where = 'WHERE ';}else{$where = ''; }
            $filtro .=" $and $where tipo_contratos.id IN ($request->tipo_contrato) ";
        }

        if($request->regiao != null){
            if($filtro != null){ $and = ' AND';}
            if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
            $filtro .=" $and $where regiaos.id = '$request->regiao' ";
        }

        if($request->municipio != null){
            if($filtro != null){ $and = ' AND';}
            if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
            $filtro .=" $and $where municipios.id = '$request->municipio' ";
        }

        // if($request->status != null){
        //     if($filtro != null){ $and = ' AND';}
        //     if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
        //     $filtro .=" $and $where s.status = '$request->status' ";
        // }
 
        if($request->status != null){
            if($filtro != null){ $and = 'AND';}
            if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
            $filtro .=" $and $where s.status = '$request->status' ";
        }

        if($request->gerenciadora != null){
            if($filtro != null){ $and = ' AND';}
            if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
            $filtro .=" $and $where gerenciadoras.id = '$request->gerenciadora' ";
        }

        if($request->clientes != null){
            if($filtro != null){ $and = ' AND';}
            if($filtro == null){ $where = 'WHERE ';}else{$where = ''; }
            $filtro .=" $and $where clientes.id IN ($request->clientes) ";
        } 


        $servicos = DB::select( DB::raw(
            "SELECT *,
            s.id AS id, 
            clientes.nome As clnome,
            clientes.nome_abrev As nomeabrev,
            clientes.id As clid,
            servico_tipos.nome AS snome,
            tipo_contratos.nome AS tcnome,
            contratos.nome AS ctnome,
            contratos.codigo As codigo,
            locals.latitude As latitude,
            locals.longitude As longitude,
            locals.bairro As lbairro,
            locals.numero As lnumero,
            municipios.nome As mnome,
            locals.id As idlocal,
            servico_tipos.id As idserv
              FROM servicos As s
               LEFT JOIN locals ON locals.id = s.locals_id
               LEFT JOIN municipios ON municipios.id = locals.municipios_id
               LEFT JOIN users_regiaos ON users_regiaos.id = municipios.regiaos_id
               LEFT JOIN gerenciadoras ON gerenciadoras.id = municipios.gerenciadora_id
               LEFT JOIN regiaos ON regiaos.id = municipios.regiaos_id
               LEFT JOIN servico_tipos ON servico_tipos.id = s.servico_tipos_id
               LEFT JOIN contratos ON contratos.id = s.contratos_id
               LEFT JOIN tipo_contratos ON tipo_contratos.id = contratos.tipo_contratos_id
               LEFT JOIN areas ON areas.id = contratos.areas_id
               LEFT JOIN clientes ON clientes.id = contratos.clientes_id
           
                $filtro 
                ORDER BY s.id desc "            
            ) );
        
        $dados = [];
        foreach($servicos as $value){
            $address = '';
            $address .= $value->logradouro;
            if(isset($value->lnumero)){
                if($value->lnumero != '0'){
                    $address .= ', '.$value->lnumero;
                }
            }
            $bairro = '';
            if(isset($value->lbairro)){
                if($value->lbairro != '' && $value->lbairro != '0'){
                    $bairro = ' - '.$value->lbairro;
                }                
            }

            $dado = [
                "id" => $value->id,
                "nomeServico" => $value->snome, 
                "nomeTcontrato" => $value->tcnome, 
                "nomeLocal" => $value->nm_local, 
                "address" =>  $address, 
                "bairro" => $bairro,
                "nomeContrato" => $value->ctnome,
                "nomeCliente" => $value->clnome,
                "cidade" => $value->mnome,
                "lat" => $value->latitude, 
                "lng" => $value->longitude, 
                "type" =>'DESTAQUE', 
                "codigoContrato" => $value->codigo, 
                "frente" => 7,
                "idlocal" => $value->idlocal,
                'idserv' => $value->idserv,
                'clid' => $value->clid
            ];
            array_push($dados, $dado);
        }       
        return response()->json($dados);
        
    }

    public function getpoints(Request $request){

        //remontar o array para agrupar as informações que estão repetindo a longitude e latitude

        $filtro = '';
        $and = '';
        $objeto = new Acesso;
        $filtro .= $objeto->perfil_acesso();

        // if($request->servico != null){
        //     if($filtro != null){ $and = 'AND';}
        //     if($filtro == null){ $where = 'WHERE ';}else{$where = ''; }
        //     $filtro .=" $and $where servico_tipos.id IN ($request->servico) ";
        // }

        if($request->tipo_contrato != null){
            if($filtro != null){ $and = 'AND';}
            if($filtro == null){ $where = 'WHERE ';}else{$where = ''; }
            $filtro .=" $and $where tipo_contratos.id IN ($request->tipo_contrato) ";
        }

        if($request->regiao != null){
            if($filtro != null){ $and = 'AND';}
            if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
            $filtro .=" $and $where regiaos.id = '$request->regiao' ";
        }

        if($request->status != null){
            if($filtro != null){ $and = 'AND';}
            if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
            $filtro .=" $and $where s.status = '$request->status' ";
        }

        if($request->municipio != null){
            if($filtro != null){ $and = 'AND';}
            if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
            $filtro .=" $and $where municipios.id = '$request->municipio' ";
        }

        // if($request->status != null){
        //     if($filtro != null){ $and = 'AND';}
        //     if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
        //     $filtro .=" $and $where s.status = '$request->status' ";
        // }

        if($request->gerenciadora != null){
            if($filtro != null){ $and = 'AND';}
            if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
            $filtro .=" $and $where gerenciadoras.id = '$request->gerenciadora' ";
        }

        if($request->clientes != null){
            if($filtro != null){ $and = 'AND';}
            if($filtro == null){ $where = 'WHERE ';}else{$where = ''; }
            $filtro .=" $and $where clientes.id IN ($request->clientes) ";
        }

        // // filtro de perfil de acesso
        // $objeto = new Acesso;
        // $filtro .= ' ';
        // $filtro .= $objeto->perfil_acesso();
       

        $servicos = DB::select( DB::raw(
            "SELECT *,
            s.id AS id, 
            clientes.nome As clnome,
            clientes.id As clid,
            servico_tipos.nome AS snome,
            contratos.nome AS ctnome,
            contratos.codigo As codigo,
            tipo_contratos.nome AS tcnome,
            locals.latitude As latitude,
            locals.longitude As longitude,
            locals.bairro As lbairro,
            locals.numero As lnumero,
            municipios.nome As mnome,
            locals.id As idlocal,
            servico_tipos.id As idserv
              FROM servicos As s
               LEFT JOIN locals ON locals.id = s.locals_id
               LEFT JOIN municipios ON municipios.id = locals.municipios_id
               LEFT JOIN users_regiaos ON users_regiaos.id = municipios.regiaos_id
               LEFT JOIN gerenciadoras ON gerenciadoras.id = municipios.gerenciadora_id
               LEFT JOIN regiaos ON regiaos.id = municipios.regiaos_id
               LEFT JOIN servico_tipos ON servico_tipos.id = s.servico_tipos_id
               LEFT JOIN contratos ON contratos.id = s.contratos_id
               LEFT JOIN tipo_contratos ON tipo_contratos.id = contratos.tipo_contratos_id
               LEFT JOIN areas ON areas.id = contratos.areas_id
               LEFT JOIN clientes ON clientes.id = contratos.clientes_id
               
                $filtro LIMIT 10000"            
            ) );




        
        $dados = [];
        foreach($servicos as $value){
            $address = '';
            $address .= $value->logradouro;
            if(isset($value->lnumero)){
                if($value->lnumero != '0'){
                    $address .= ', '.$value->lnumero;
                }
                
            }
            $bairro = '';
            if(isset($value->lbairro)){
                if($value->lbairro != '' && $value->lbairro != '0'){
                    $bairro = ' - '.$value->lbairro;
                    //$bairro = '';
                }                
            }


            $dado = [
                "id" => $value->id,
                "nomeServico" => $value->snome, 
                "nomeTcontrato" => $value->tcnome, 
                "nomeLocal" => $value->nm_local, 
                "address" => $address, 
                "bairro" =>  $bairro,
                "nomeContrato" => $value->ctnome,
                "nomeCliente" => $value->clnome,
                "cidade" => $value->mnome,
                "lat" => $value->latitude, 
                "lng" => $value->longitude, 
                "type" =>'DESTAQUE', 
                "codigoContrato" => $value->codigo, 
                "frente" => 7,
                "idlocal" => $value->idlocal,
                'idserv' => $value->idserv,
                'clid' => $value->clid
            ];
            array_push($dados, $dado);
        }       
        return response()->json($dados);
    }

}
