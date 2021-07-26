<div class="col-md-12" style="border-top: solid 1px #eee; margin-top: 20px">
    <p class="card-category" style="margin-top: 20px;">ANEXOS CADASTRADOS</p>
</div>
<table id="example3" class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Arquivo</th>
            <th>Descrição</th>
            <th>Tipo</th>
            <th>Anexado por</th>
            <th>Data Cadastro</th>
            <th style="width: 40px;"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($anexos as $key => $value2)
        <tr>
            <td><a href="/storage/{{ $value2->arquivo }}" target="_blank" class="btn btn-primary btn-link">{{ $value2->arquivo }}</a> </td>
            <td>{{ $value2->descricao }}</td>
            <td>{{ $value2->tipo }}</td>
            <td>{{ $value2->name }}</td>
            <td>@if(!empty($value2->created_at)){{ date( 'd/m/Y' , strtotime($value2->created_at))}}@endif</td>
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
            if(confirm('Deseja remover esse anexo? ')){
                $.get(appUrl+'/contratos/anexos/delete/'+id, function(retorno){
                    buscar_anexo();
                });
            }
        }

    </script>
