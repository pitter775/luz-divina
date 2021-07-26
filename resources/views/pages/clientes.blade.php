@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'clientes'
])

@section('content')


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="retorno_modal"></div>
    </div>
</div>
<!-- style="background: linear-gradient(to top, #f2f9ff 0%, #ffffff 100%);" -->

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Clientes</h5>
                    </div>
                    <div class="card-body">                   
                        <form method="#" action="#">
                            @csrf
                            <div class="row" style="margin-bottom: 30px;">
                                <div class="col-md-6" style="padding-top: 18px">
                                    <a href="clientes/cadastro" class="btn btn-outline-primary btn-round btn-sm" @if(auth()->user()->acesso == 'Consulta') style="display: none;" @endif ><i class="fa fa-plus"></i> Cadastrar Cliente</a>
                                </div>
                            
                                
                            </div>
                        </form>
                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="display: none !important;">ID</th>
                                    <th>Nome</th>
                                    <th>CNPJ</th>
                                    <th>E-mail</th>
                                    <th>Telefone</th>
                                    <!-- <th>Ver Contratos</th> -->
                                    @if(auth()->user()->acesso !== 'Consulta') <th style="width: 50px;" ></th>@endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($clientes as $key => $value)
                                <tr>
                                    <td  style="display: none  !important;">{{ $value->id }}</td>
                                    <td>{{ $value->nome }}</td>
                                    <td>{{ $value->cnpj }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>{{ $value->telefone }}</td>
                                    <!-- <td style="text-align: center;">
                                    
                                        <a href="" class="btn btn-primary btn-link" data-toggle="modal" data-target="#myModal" onclick="ver_contratos('{{ $value->id }}')">ver contratos</a>
                                    </td> -->
                                    @if(auth()->user()->acesso !== 'Consulta')
                                    <td>
                                        <a href="clientes/cadastro/{{ $value->id }}" class="btn btn-primary btn-link"><i class="nc-icon nc-tag-content"></i></a>
                                        <a href="clientes/delete/{{ $value->id }}" class="btn btn-danger btn-link" onclick="return confirm('Deseja mesmo excluir o cliente {{ $value->nome }} ?');"><i class="nc-icon nc-simple-remove"></i></a>
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

        function ver_contratos($id){ 
            $.get(appUrl+'/clientes/ver_contratos/'+$id, function(retorno){      
                $('#retorno_modal').html(retorno);
            });}

    </script>
@endpush