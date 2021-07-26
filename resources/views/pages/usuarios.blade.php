@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'usuarios'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Usuários</h5>
                    </div>
                    <div class="card-body">
                        <div class="row" style="margin-bottom: 30px;">
                            <div class="col-md-6" style="padding-top: 18px">
                                <a href="/usuarios/cadastro" class="btn btn-outline-primary btn-round btn-sm" @if(auth()->user()->acesso == 'Consulta') style="display: none;" @endif><i class="fa fa-plus"></i> Cadastrar Usuários</a>
                            </div>
                        </div>
                        <div class="row">
                            <table id="example" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Telefone</th>
                                        <th>Data Inicio</th>
                                        @if(auth()->user()->acesso !== 'Consulta')<th style="width: 50px;"></th>@endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($usuarios as $key => $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->telefone }}</td>
                                        <td>@if(!empty($value->created_at)){{ date( 'd/m/Y' , strtotime($value->created_at))}}@endif</td>
                                        @if(auth()->user()->acesso !== 'Consulta')
                                        <td>
                                            <a href="usuarios/cadastro/{{ $value->id }}" class="btn btn-primary btn-link"><i class="nc-icon nc-tag-content"></i></a>
                                            <a href="usuarios/delete/{{ $value->id }}" class="btn btn-danger btn-link" onclick="return confirm('Deseja mesmo excluir o usuario {{ $value->name }} ?');"><i class="nc-icon nc-simple-remove"></i></a>
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
       $('#example').DataTable({
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
@endpush