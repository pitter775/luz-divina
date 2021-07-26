<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Regiao;
use App\Models\Tipo_contrato;
use App\Models\Gerenciadora;
use App\Models\Cliente;
use App\Models\Users_regiao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;



class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(User $model){
       // return view('users.index', ['users' => $model->paginate(15)]);
       $usuarios = User::all(); 
       return view("pages.usuarios", compact('usuarios'));

    }
    public function create(){
      $regiao = Regiao::all();
      $tipo_contrato = Tipo_contrato::all();
      $gerenciadora = Gerenciadora::all();
      $cliente = Cliente::all();
      $areas = Area::all();
      return view('pages.usuarios_cadastro', compact('regiao','tipo_contrato','gerenciadora','cliente','areas'));         
    } 
    public function store(Request $request){
      $id_usuario = $request->input('id_usuario');
      $tem = DB::table('users')->where('email', $request->input('email'))->get();      
      $password = $request->input('password');
      $regioes = $request->input('regiaos_id');    
     
      
      if($id_usuario == ''){
        // CADASTRA
        if(!count($tem) == 0){
          return 'erro, Já existe o email cadastrado no sistema.';
        }
        $dados = new User();
      }else{
        // ATUALIZA
        $dados = User::find($id_usuario);
        
      }
      $dados->name = $request->input('name');
      $dados->telefone = $request->input('telefone');
      $dados->email = $request->input('email');
      if(isset($password)){
        $dados->password = Hash::make($request->input('password')); 
      }
      $dados->acesso = $request->input('acesso');        
      $dados->status = $request->input('status');

      //cadastrar regioes
      // $dados->regiaos_id = $request->input('regiaos_id');
      
      $dados->clientes_id = $request->input('clientes_id');
      $dados->gerenciadoras_id = $request->input('gerenciadoras_id');
      $dados->tipo_contratos_id = $request->input('tipo_contratos_id');
      $dados->tipo_consulta = $request->input('tipo_consulta');
      $dados->tipo_gestor = $request->input('tipo_gestor');
      $dados->areas_id = $request->input('areas_id');
      $dados->save();     
      
      if(isset($regioes)){
        
        Users_regiao::where('users_id', $dados->id)->delete();   
        foreach ($regioes as $value){
          $dadoss = new Users_regiao();
          $dadoss->users_id = $dados->id;
          $dadoss->regiaos_id = $value;
          $dadoss->save();   
        }      
      }
      return $dados->id;
    }


    public function edit($id){
      $dados_geral = User::find($id);
      // $users_regiaos = Users_regiao::where('users_id', $id)->get();   
      $regiao = Regiao::all();
      $tipo_contrato = Tipo_contrato::all();
      $gerenciadora = Gerenciadora::all();
      $cliente = Cliente::all();
      $areas = Area::all();

      $users_regiaos = DB::table('users_regiaos AS ur')
      ->join('regiaos', 'regiaos.id', '=', 'ur.regiaos_id')
      ->join('users', 'users.id', '=', 'ur.users_id')
      ->where([
         ['ur.users_id', $id]
      ])
      ->select('*', 'ur.id AS id','ur.regiaos_id As regiaos_id')
      ->get();

      //return $users_regiaos;
      




      return view('pages.usuarios_cadastro', compact('regiao','dados_geral','tipo_contrato','gerenciadora','cliente','areas','users_regiaos'));     
    }
    public function getVinculo($id){
      $users_regiaos = DB::table('users_regiaos AS ur')
      ->join('regiaos', 'regiaos.id', '=', 'ur.regiaos_id')
      ->where([
         ['ur.users_id', $id]
      ])
      ->select('*', 'ur.id AS id')
      ->get();
      return  view('pages.usuarios_vinculo', compact('users_regiaos'));       
    }
    public function postVinculo(Request $request){
      $tem = DB::table('users_regiaos')
      ->where([
        ['regiaos_id', $request->input('regiaos_id')],
        ['users_id', $request->input('id_usuario')]
      ])
      ->get();
      if(count($tem) == 0){
        $regiao = new Users_regiao();  
        $regiao->regiaos_id = $request->input('regiaos_id');    
        $regiao->users_id = $request->input('id_usuario');  
        $regiao->save(); 
      }else{
        return 'erro, Já existe a região cadastrada para esse usuário no sistema.';
      }

         
    }
    public function getVinculoDelete($id){

      $delvinculo = Users_regiao::find($id);
      if(isset($delvinculo)){
         $delvinculo->delete();
      }

    }
    public function destroy_user($id){
      $dados = User::find($id);
      if(isset($dados)){
          try {
              $dados->delete();
              Session::put('message', 'Removido com sucesso!');
              return redirect("/usuarios");                
          }catch (PDOException $e) {
              if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
                  Session::put('message', 'Erro, esse <b>Usuário</b> esta em uso em outro relacionamento.');
                  return redirect("/usuarios");
              }
          }
      }
    }
}
