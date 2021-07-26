<div class="col-md-12" style="border-top: solid 1px #eee; margin-top: 20px">
    <p class="card-category" style="margin-top: 20px;">REGIÕES DESSE USUÁRIO</p>
</div>
<table id="example2" class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Região</th>
            <th style="width: 20px;"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($users_regiaos as $key => $value2)
        <tr>
            <td>{{ $value2->nome }}</td>
            <td>
                <a href="#" class="btn btn-danger btn-link" onclick="return deletar_vinculo('{{ $value2->id }}')"><i class="nc-icon nc-simple-remove"></i></a>   
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
       $('#example2').DataTable({
            "pagingType": "full_numbers",
                responsive: true,
                language: {
                search: "_INPUT_",
                searchPlaceholder: "Buscar",
            }
        });

        function deletar_vinculo(id){
            if(confirm('Deseja remover esse vinculo? ')){
                $.get(appUrl+'/usuarios/vinculos/delete/'+id, function(retorno){
                    buscar_vinculo();
                });
            }
        }

    </script>
