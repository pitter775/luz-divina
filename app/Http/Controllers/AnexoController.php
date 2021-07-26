<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Anexo;
use Illuminate\Support\Facades\Auth;

class AnexoController extends Controller
{

    public function store(Request $request)
    {
        $nameFile = null;
        // $servicos_id = $request->input('id_ois');
        // $contratos_id = $request->input('contratos_id');

        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
            $name = uniqid(date('HisYmd'));
            $extension = $request->arquivo->extension();
            $nameFile = "{$name}.{$extension}";
            $upload = $request->arquivo->storeAs('public',$nameFile); 
 
            $anexo = new Anexo(); 
            $anexo->descricao = $request->input('descricao');  
            $anexo->tipo = $request->arquivo->getMimeType(); 
            $anexo->users_id = Auth::user()->id; 
            $anexo->arquivo = $nameFile;
            $anexo->contratos_id = $request->input('id_contrato'); 
            $anexo->servicos_id = $request->input('id_ois'); 
            $anexo->andamentos_id = $request->input('andamentos_id'); 
   
            $anexo->save();
            return $upload;            
        }
    }

    public function show(Request $request)
    {


        $filtro = '';
        $and = '';
 
        //por contrato
        if($request->contratos_id != null){
            if($filtro != null){ $and = 'AND';}
            if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
            $filtro .="$and $where ud.contratos_id = '$request->contratos_id' ";
        }

        //por serviço
        if($request->id_ois != null){
            if($filtro != null){ $and = 'AND';}
            if($filtro == null){ $where = 'WHERE';}else{$where = ''; }
            $filtro .="$and $where ud.servicos_id = '$request->id_ois' ";
        }

        $anexos = DB::select( DB::raw(
            "SELECT *, ud.descricao As uddescricao, ud.id As udid, ud.created_at As created_att
              FROM anexos As ud
                     JOIN users ON users.id = ud.users_id
                LEFT JOIN contratos ON contratos.id = ud.contratos_id
                LEFT JOIN servicos ON servicos.id = ud.servicos_id
                $filtro"            
            ) );

        return  view('pages.anexos', compact('anexos'));     
    }


    public function destroy($id)
    {
        $delanexo = Anexo::find($id);
        if(isset($delanexo)){
            $delanexo->delete();
        }
    }
}
