@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'clientes'
])

@section('content')
    <div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>@if(isset($clientes->id)) Editar @else Cadastrar @endif Clientes</h5>

                    @if(isset($clientes->id)) <h6 class="btn btn-primary btn-round">{{$clientes->nome ?? ''}}</h6> @endif 

                    
                    
                </div>
                <div class="card-body">
                    <form name="form_informacoes" id="form_informacoes">
                        <input type="hidden" id="id_cliente" name="id_cliente" value="{{$clientes->id ?? ''}}">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">INFORMAÇÕES</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link endbt" data-toggle="tab" href="#profile" role="tab" aria-expanded="false" >ENDEREÇO</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="my-tab-content" class="tab-content text-left">
                            <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">
                                <p class="card-category">CADASTRAR CLIENTE</p>
                                
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>Nome do Cliente</label>
                                            <div class="form-group">
                                                <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome do Cliente" value="{{$clientes->nome ?? ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>CNPJ</label>
                                            <div class="form-group">
                                                <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ" value="{{$clientes->cnpj ?? ''}}" >
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>CPF</label>
                                            <div class="form-group">
                                                <input type="text" name="cpf" id="cpf" class="form-control" placeholder="CPF" value="{{$clientes->cpf ?? ''}}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>DDD Cel</label>
                                            <div class="form-group">
                                                <input type="telefone" name="celular" id="celular" class="form-control" placeholder="DDD Cel" value="{{$clientes->celular ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Telefone</label>
                                            <div class="form-group">
                                                <input type="telefone" name="telefone" id="telefone" class="form-control" placeholder="Telefone" value="{{$clientes->telefone ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Email</label>
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{$clientes->email ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Status</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="status" value="{{$clientes->status ?? ''}}" required>
                                     

                                                    @if(isset($clientes))
                                                        @if($clientes->status == 'Ativo') <option selected>Ativo</option> @else <option>Ativo</option> @endif
                                                        @if($clientes->status == 'Inativo') <option selected>Inativo</option> @else <option>Inativo</option> @endif  
                                                    @else
                                                        <option >Ativo</option> 
                                                        <option >Inativo</option> 
                                                    @endif 
                                                
              

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="control-label">Observações</label>
                                            <textarea rows="8" name="observacao" placeholder="" class="form-control input-md" autocomplete="off">{{$clientes->observacao ?? ''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="footerint">
                                        <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Gravar Dados</button>
                                        <a href="/clientes" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                    </div>                                  
                            
                            </div>
                            <div class="tab-pane" id="profile" role="tabpanel" aria-expanded="false">
                                    <p class="card-category">CADASTRAR ENDEREÇO DO CLIENTE</p>
                                    <div class="row">                                        
                                        <div class="col-md-10">
                                            <label>Endereço</label>
                                            <div class="form-group">
                                                <input type="text" name="endereco" id="endereco" class="form-control" placeholder="Endereço" value="{{$clientes->endereco ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Número</label>
                                            <div class="form-group">
                                                <input type="text" name="numero" id="numero" class="form-control" placeholder="Número" value="{{$clientes->numero ?? ''}}">
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-3">
                                            <label>CEP</label>
                                            <div class="form-group">
                                                <input type="text" name="cep" id="cep" class="form-control" placeholder="CEP" value="{{$clientes->cep ?? ''}}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label>Complemento</label>
                                            <div class="form-group">
                                                <input type="text" name="complemento" class="form-control" placeholder="Complemento" value="{{$clientes->complemento ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Bairro</label>
                                            <div class="form-group">
                                                <input type="text" name="bairro" id="bairro" class="form-control" placeholder="Bairro" value="{{$clientes->bairro ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Cidade</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="cidade">
                                                    @if(!isset($clientes)) <option value="">Selecione</option> @endif
                                                    @foreach($municipios as $key => $value)
                                                        @if(isset($clientes))
                                                            @if($value->nome == $clientes->cidade) <option value="{{ $value->nome }}" selected>{{ $value->nome }}</option> @else
                                                                <option value="{{ $value->nome }}">{{ $value->nome }}</option>
                                                            @endif                                                          
                                                        @else
                                                            <option value="{{ $value->nome }}">{{ $value->nome }}</option> 
                                                        @endif 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="footerint">
                                        <button class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Gravar Dados</button>
                                        <a href="/clientes" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                    </div>                                  
                            
                            </div>
                        </div>
                    </form>
                </div>                  
            </div>         
        </div>
    </div>

    </div>
@endsection

@push('scripts')
    <script>
    var appUrl ="{{env('APP_URL')}}";

    $("#cnpj").mask("99.999.999/9999-99");
    $("#cpf").mask("999.999.999-99");
    $("#celular").mask("(99) 99999-9999");
    $("#telefone").mask("(99) 9999-9999");
    $("#cep").mask("99999-999");

    
        $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
        $('.endbt').click(function(event ){
            event.preventDefault();   
            let id_cliente = $('#id_cliente').val();
            if(id_cliente ===''){
                setTimeout(function(){ 
                    $('.nav-tabs a:first').tab('show');
                    demo.showNotification('top','center','danger','Você precisa cadastrar o <b>Cliente</b> primeiro.')
                }, 500);
            }
        });

        $("#form_informacoes").submit(function(e) {           
            e.preventDefault(); 
            let form = $(this);
            let id_cliente = $('#id_cliente').val(); 
            $.ajax({
                type: "POST",
                url: appUrl+'/clientes/cadastro',
                data: form.serialize(), 
                success: function(data)
                {
                    var result = data.split(',');
                    if(result[0] == 'erro'){
                        demo.showNotification('top','center', 'danger', result[1]);
                    }else{
                        if(id_cliente === ''){
                            demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                            $('#id_cliente').val(data);  
                        }else{
                            demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                        }
                    }
                }
            });
        });

        // $("#form_endereco").submit(function(e) {           
        //     e.preventDefault(); 
        //     let form = $(this);
        //     var data = form.serializeArray();
        //         data.push( $("#form_informacoes").serializeArray());
        //     $.ajax({
        //         type: "POST",
        //         url: '/clientes/cadastro',
        //         data: form.serialize(), 
        //         success: function(data)
        //         {
        //             demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
        //         }
        //     });
        // });
    </script>
@endpush