<div class="col-md-12" style="border-top: solid 1px #eee; margin-top: 20px">
    <p class="card-category" style="margin-top: 20px;">SERVIÇOS CADASTRADOS</p>
</div>
<table id="example3" class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th style="width: 40px;"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($anexos as $key => $value2)
        <tr>
            <td>{{ $value2->id }}</a> </td>
            <td>{{ $value2->nome }}</td>         
            <td>
                <a href="#" class="btn btn-danger btn-link" onclick="return deletar_anexo('{{ $value2->id }}')"><i class="nc-icon nc-simple-remove"></i></a>   
            </td>
        </tr>
    @endforeach                            
    </tbody>
</table>

<style>
    .dataTables_length{ display: none;}
</style>
<script>
var appUrl ="{{env('APP_URL')}}";
       $('#example3').DataTable({
            "pagingType": "full_numbers",
                responsive: true,
                language: {
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
            }
        });

        function deletar_anexo(id){
            if(confirm('Deseja remover esse servido do tipo do contrato? ')){
                $.get(appUrl+'/tipo_contratos/anexos/delete/'+id, function(retorno){
                    buscar_anexo();
                });
            }
        }

    </script>
