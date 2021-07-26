@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'contratos'
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
                        <h5>Contratos</h5>
                    </div>

                    <div class="card-body">
                        <div class="row" style="margin-bottom: 30px;">
                            <div class="col-md-6" style="padding-top: 18px">
                                <a href="/contratos/cadastro" class="btn btn-outline-primary btn-round btn-sm" @if(auth()->user()->acesso == 'Consulta') style="display: none;" @endif ><i class="fa fa-plus"></i> Cadastrar Contratos</a>
                            </div>
                        </div>
                        <div class="row">
                            <table id="example" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Cliente</th>
                                        <th>Número Contrato</th>
                                        <th>Data Base</th>
                                        <th>Data Assinatura</th>
                                        <th>Valor Atual</th>
                                        <th>Ver Aditivos</th>
                                        <th>Ver Serviços</th>
                                        @if(auth()->user()->acesso !== 'Consulta')<th style="width: 50px;"></th>@endif
                                    </tr>
                                </thead>
                                <tbody>
                             
                                @foreach($contratos as $key => $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->contrato_nome }}</td>
                                        <td>{{ $value->clnome }}</td>
                                        <td>{{ $value->ctcodigo }}</td>                                        
                                        <td>@if(!empty($value->dt_base)){{ date( 'd/m/Y' , strtotime($value->dt_base))}}@endif</td>
                                        <td>@if(!empty($value->dt_assinatura)){{ date( 'd/m/Y' , strtotime($value->dt_assinatura))}}@endif</td>
                                        <td>{{ $value->valor_atual }}</td> 
                                        <td style="text-align: center;">
                                            <a href="" class="btn btn-primary btn-link" data-toggle="modal" data-target="#myModal" onclick="ver_aditivos('{{ $value->id }}')">Aditivos</a>

                                        </td>
                                        <td style="text-align: center;">
                                            <a href="" class="btn btn-primary btn-link" data-toggle="modal" data-target="#myModal" onclick="ver_servicos('{{ $value->id }}')" >Serviços</a>
                                        </td>
                                        @if(auth()->user()->acesso !== 'Consulta')
                                        <td>
                                            <a href="contratos/cadastro/{{ $value->id }}" class="btn btn-primary btn-link"><i class="nc-icon nc-tag-content"></i></a>
                                            <a href="contratos/delete/{{ $value->id }}" class="btn btn-danger btn-link" onclick="return confirm('Deseja mesmo excluir o contrato {{ $value->contrato_nome }} ?');"><i class="nc-icon nc-simple-remove"></i></a>
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
                    },
                    "columnDefs": [{
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }]
            });

        function ver_aditivos($id){
            $.get(appUrl+'/contratos/ver_aditivos/'+$id, function(retorno){
                $('#retorno_modal').html(retorno);
            });
        }
        function ver_servicos($id){
            $.get(appUrl+'/contratos/ver_servicos/'+$id, function(retorno){
                $('#retorno_modal').html(retorno);
            });
        }
        
    </script>
@endpush