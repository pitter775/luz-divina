@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'ois'
])

@section('content')

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="retorno_modal"></div>
    </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 900px !important; height: 800px">
        <div class="modal-content" id="retorno_modal2"></div>
    </div>
</div>

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>OIS</h5>
                    </div>

                    <div class="card-body">
                        <div class="row" style="margin-bottom: 30px;">
                            <div class="col-md-6" style="padding-top: 18px">
                                <a href="/ois/cadastro" class="btn btn-outline-primary btn-round btn-sm" @if(auth()->user()->acesso == 'Consulta') style="display: none;" @endif><i class="fa fa-plus"></i> Cadastrar OIS</a>
                            </div>
                        </div>
                        <div class="row">
                            <table id="example" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Contrato</th>
                                        <th>Municípios</th>
                                        <th>Nome do Serviço</th>
                                        <th>Descrição</th>
                                        <th>Local</th>
                                        <th>Data</th>
                                        <th>Prazo</th>
                                        <th>Valor</th>
                                        <th>Detalhe</th>
                                        @if(auth()->user()->acesso !== 'Consulta') <th style="width: 50px;"></th> @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($ois as $key => $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->clnome }}</td>
                                        <td>{{ $value->ctnome }} </td>
                                        <td>{{ $value->mnome }}</td>
                                        <td>{{ $value->stnome }}</td>
                                        <td>{!! $value->descricao ?? '' !!}</td>
                                        <td>{{ $value->nm_local }}</td>
                                        <td>@if(!empty($value->dt_ios)){{ date( 'd/m/Y' , strtotime($value->dt_ios))}}@endif </td>
                                        <td>@if(!empty($value->prazo)){{ date( 'd/m/Y' , strtotime($value->prazo))}}@endif </td>
                                        <td>R$ {{ $value->valor }}</td>
                                        <td style="text-align: center;">
                                            <buttom type="buttom" class="btn btn-primary btn-sm" target="_blank" data-toggle="modal" data-target="#myModal2" onclick="ver_ois(<?php echo $value->id ?>)" ><i class="nc-icon nc-zoom-split" ></i></buttom>
                                        </td>
                                        @if(auth()->user()->acesso !== 'Consulta')
                                        <td>
                                            <a href="ois/cadastro/{{ $value->id }}" class="btn btn-primary btn-link"><i class="nc-icon nc-tag-content"></i></a>
                                            <a href="ois/delete/{{ $value->id }}" class="btn btn-danger btn-link" onclick="return confirm('Deseja mesmo excluir esse local {{ $value->id }} ?');"><i class="nc-icon nc-simple-remove"></i></a>
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

            function ver_ois(id){
                $.get(appUrl+'/home/ver_ois/'+id, function(dados){
                    $('#retorno_modal2').html(dados);
                });
            }

            function fechartela(){
                $('#myModal2').modal('toggle');        
                setTimeout(function() {$('#retorno_modal2').html('');}, 1000);     
            }

    </script>
@endpush