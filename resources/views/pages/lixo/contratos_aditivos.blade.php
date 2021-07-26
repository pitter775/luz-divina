
<div class="col-md-12" style="border-top: solid 1px #eee; margin-top: 20px">
    <p class="card-category" style="margin-top: 20px;">ADITIVOS CADASTRADOS</p>  
</div>
<table id="example2" class="table table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Nr Termo</th>
            <th>Objeto</th>
            <th>Data Vigência</th>
            <th>Valor Atual</th>
            <th style="width: 50px;"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($aditivos as $key => $value2)
        <tr>
            <td>{{ $value2->nr_termo }}</td>
            <td>{!! $value2->objeto ?? '' !!}</td>
            <td>@if(!empty($value2->dt_vigencia)){{ date( 'd/m/Y' , strtotime($value2->dt_vigencia))}}@endif</td>
            <td>{{ $value2->vlr_atual }}</td>
            
            <td>
                <a href="#" class="btn btn-primary btn-link" data-toggle="modal" data-target="#myModal3" onclick="editar_aditivo('{{ $value2->id }}')"><i class="nc-icon nc-tag-content"></i></a>
                <a href="#" class="btn btn-danger btn-link" onclick="return deletar_aditivo('{{ $value2->id }}')"><i class="nc-icon nc-simple-remove"></i></a>   
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

        function deletar_aditivo(id){
            if(confirm('Deseja remover esse aditivo? ')){
                $.get(appUrl+'/contratos/aditivos/delete/'+id, function(retorno){
                    buscar_aditivo();
                });
            }
        }

        function editar_aditivo($id){
            $('#retorno_modal3').html('');
            $.get(appUrl+'/contratos/aditivos/edit/'+$id, function(retorno){
                $('#retorno_modal3').html(retorno);
            });
        } 

</script>
