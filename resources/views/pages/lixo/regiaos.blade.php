@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'regiaos'
])

@section('content')

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="retorno_modal"></div>
    </div>
</div>


    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Regiões</h5>
                    </div>

                    <div class="card-body">
                        <div class="row" style="margin-bottom: 30px;">
                            <div class="col-md-6" style="padding-top: 18px">
                                <a href="/regiaos/cadastro" class="btn btn-outline-primary btn-round btn-sm" @if(auth()->user()->acesso == 'Consulta') style="display: none;" @endif><i class="fa fa-plus"></i> Cadastrar Região</a>
                            </div>
                        </div>
                        <div class="row">
                            <table id="example" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome da Região</th>
                                        @if(auth()->user()->acesso !== 'Consulta')<th style="width: 50px;"></th>@endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($dados_geral as $key => $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->nome }}</td>
                                        @if(auth()->user()->acesso !== 'Consulta')
                                        <td>
                                            <a href="regiaos/cadastro/{{ $value->id }}" class="btn btn-primary btn-link"><i class="nc-icon nc-tag-content"></i></a>
                                            <a href="regiaos/delete/{{ $value->id }}" class="btn btn-danger btn-link" onclick="return confirm('Deseja mesmo excluir essa região {{ $value->nome }} ?');"><i class="nc-icon nc-simple-remove"></i></a>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach                            
                                </tbody>
                            </table> 
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
       var appUrl ="{{env('APP_URL')}}";
       $('#example').DataTable({
                "order": [[ 0, "desc" ]],
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
                    // "columnDefs": [{
                    //     "targets": [ 0 ],
                    //     "visible": false,
                    //     "searchable": false
                    // }]
            });

    </script>
@endpush