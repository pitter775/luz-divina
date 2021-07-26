<?php

namespace App\Models;
use App\Models\Acesso;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Filtro extends Model
{
    public function sql_filtros($groupBy, $selec)
    {
        $objeto = new Acesso;
        $filtro = $objeto->perfil_acesso();

        $servicos = DB::select( DB::raw(
        "SELECT $selec
            FROM servicos As s
            LEFT JOIN contratos ON contratos.id = s.contratos_id
            LEFT JOIN clientes ON clientes.id = contratos.clientes_id
            LEFT JOIN locals ON locals.id = s.locals_id
            LEFT JOIN municipios ON municipios.id = locals.municipios_id
            LEFT JOIN gerenciadoras ON gerenciadoras.id = municipios.gerenciadora_id
            LEFT JOIN regiaos ON regiaos.id = municipios.regiaos_id
            
            LEFT JOIN servico_tipos ON servico_tipos.id = s.servico_tipos_id            
            LEFT JOIN tipo_contratos ON tipo_contratos.id = contratos.tipo_contratos_id            
            LEFT JOIN areas ON areas.id = contratos.areas_id            
            $filtro
            GROUP BY $groupBy
            ORDER BY $groupBy ASC"
        ));        
        return $servicos;
    }
    
    public function sql_filtros_clientes($groupBy, $selec)
    {
        $objeto = new Acesso;
        $filtro = $objeto->perfil_acesso();
        $dados = DB::select( DB::raw(
        "SELECT $selec
            FROM clientes 
            LEFT JOIN contratos ON contratos.clientes_id = clientes.id            
            LEFT JOIN servicos ON servicos.contratos_id = contratos.id 
            LEFT JOIN locals ON locals.id = servicos.locals_id
            LEFT JOIN municipios ON municipios.id = locals.municipios_id
            LEFT JOIN gerenciadoras ON gerenciadoras.id = municipios.gerenciadora_id
            LEFT JOIN regiaos ON regiaos.id = municipios.regiaos_id            
            LEFT JOIN areas ON areas.id = contratos.areas_id
            $filtro
            GROUP BY $groupBy"
        ));        
        return $dados;
    }
    public function sql_filtros_contratos(){

        $objeto = new Acesso;
        $filtro = $objeto->perfil_acesso();
        $servicos = DB::select( DB::raw(
        "SELECT *, contratos.id As id, contratos.nome As contrato_nome, contratos.codigo As ctcodigo, clientes.nome As clnome, areas.nome As anome, 
        (SELECT aditivos.vlr_atual FROM aditivos WHERE aditivos.contratos_id = contratos.id ORDER BY aditivos.dt_vigencia DESC LIMIT 1) as valor_atual
            FROM contratos             
            LEFT JOIN clientes ON clientes.id = contratos.clientes_id
            LEFT JOIN municipios ON municipios.nome = clientes.cidade
            LEFT JOIN gerenciadoras ON gerenciadoras.id = municipios.gerenciadora_id
            LEFT JOIN regiaos ON regiaos.id = municipios.regiaos_id
            LEFT JOIN areas ON areas.id = contratos.areas_id
            $filtro
            ORDER BY contratos.id desc"
        ));        
        return $servicos;


    }
}