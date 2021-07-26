<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDOException;

class AreaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(){ 

        $areas = DB::table('areas')->get();
        return view("pages.areas", compact('areas')); 
    }
    public function create(){
       
        return view('pages.areas_cadastro');        
    }
    public function store(Request $request){
        $id_area = $request->input('id_area');
        $tem = DB::table('areas')->where('nome', $request->input('nome'))->get();

        if($id_area == ''){
            // CADASTRA
            if(!count($tem) == 0){
                return 'erro, Já existe a área cadastrada no sistema.';
            }
            $area = new Area();
        }else{
            // ATUALIZA
            $area = Area::find($id_area);
        }
        $area->nome = $request->input('nome');
        $area->save();            
        return $area->id;
    }
    public function edit($id){
        $dados_geral = DB::table('areas AS a')
        ->where("a.id", $id)->first();
        return view('pages.areas_cadastro', compact('dados_geral'));    
    }
    public function destroy($id){
        $dados = Area::find($id);
        if(isset($dados)){
            try {
                $dados->delete();
                Session::put('message', 'Removido com sucesso!');
                return redirect("/areas");                
            }catch (PDOException $e) {
                if (isset($e->errorInfo[1]) && $e->errorInfo[1] == '1451') {
                    Session::put('message', 'Erro, essa <b>Area</b> esta em uso em outro relacionamento.');
                    return redirect("/areas");
                }
            }
        } 
    }
}
