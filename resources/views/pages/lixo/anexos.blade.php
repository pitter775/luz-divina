<style>.borderanexo{border-top: solid 1px #eee; margin-top: 20px} </style>
<div class="col-md-12 borderanexo" >
    <p class="card-category" style="margin-top: 20px;">ANEXOS CADASTRADOS</p>
</div>
<table id="example3" class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Arquivo</th>
            <th>Descrição</th>
            <th>Tipo</th>
            <th>Por</th>
            <th>Data</th>
            
            <th  style="width: 40px;"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($anexos as $key => $value2)
        <tr>
            <td><a href="/storage/{{ $value2->arquivo }}" target="_blank" class="btn btn-primary btn-link">{{ $value2->arquivo }}</a> </td>
            <td>{{ $value2->uddescricao }}</td>
            <td>{{ $value2->tipo }}</td>
            <td>{{ $value2->name }}</td>
            <td><?php echo date('d/m/Y', strtotime($value2->created_att)); ?></td>
            <td>
                <a href="#" class="btn btn-danger btn-link" onclick="return deletar_anexo('{{ $value2->udid }}')"><i class="nc-icon nc-simple-remove"></i></a>   
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
            console.log(id);
            if(confirm('Deseja remover esse anexo? ')){
                $.get(appUrl+'/anexos/delete/'+id, function(retorno){
                    buscar_anexo();
                });
            }
        }

    </script>
