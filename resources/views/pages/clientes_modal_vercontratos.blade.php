<div class="modal-header justify-content-center">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="nc-icon nc-simple-remove"></i>
    </button>
    <h4 class="title title-up">{{$clientes->nome}}</h4>
</div>
<div class="modal-body" style="padding: 20px 0;">
    <table id="example3" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nome do contrato</th>
                <th>Código</th>

                @if(auth()->user()->acesso !== 'Consulta')<th style="width: 50px;"></th>@endif
            </tr>
        </thead>
        <tbody>
        @foreach($contratos_mod as $key => $value)
            <tr>
                <td>{{ $value->ctnome }}</td>
                <td>{{ $value->codigo }}</td>
                @if(auth()->user()->acesso !== 'Consulta') <td><a href="/contratos/cadastro/{{ $value->ct }}" class="btn btn-primary btn-link"><i class="nc-icon nc-tag-content"></i></a></td>@endif
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