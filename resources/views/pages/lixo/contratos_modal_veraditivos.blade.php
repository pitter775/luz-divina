<div class="modal-header justify-content-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="nc-icon nc-simple-remove"></i>
    </button>
    <h4 class="title title-up">{{$contratos->nome}}</h4>
</div>
<div class="modal-body" style="padding: 20px 0;">
    <table id="example3" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Objeto</th>
                <th>Vigência</th>
                <th>Valor Atual</th>
                <th style="width: 50px;"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($aditivos as $key => $value)
            <tr>
                <td>{!! $value->objeto !!}</td>
                <td>@if(!empty($value->dt_vigencia)){{ date( 'd/m/Y' , strtotime($value->dt_vigencia))}}@endif</td>
                <td>{{ $value->vlr_atual }}</td>
                <td>
                    <a href="/contratos/cadastro/{{ $value->contratos_id }}" class="btn btn-primary btn-link"><i class="nc-icon nc-tag-content"></i></a>                    
                </td>
            </tr>
        @endforeach                            
        </tbody>
    </table>
</div>
<style>
    .dataTables_info{display:none}
</style>
<script>
    $('#example3').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                        ],
                    responsive: true,
                    language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Buscar",
                }
            });
</script>