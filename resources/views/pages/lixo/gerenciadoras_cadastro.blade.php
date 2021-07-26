@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'gerenciadoras'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@if(isset($dados_geral->id)) Editar @else Cadastrar @endif Gerenciadora </h5>
                        @if(isset($dados_geral->id))<h6 class="btn btn-primary btn-round">{{$dados_geral->nome ?? ''}}</h6>@endif
                    </div>
                    <div class="card-body">
                    <form name="form_informacoes" id="form_informacoes">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">INFORMAÇÕES</a></li>
                                    <li class="nav-item"><a class="nav-link endbt" data-toggle="tab" href="#ende" role="tab" aria-expanded="true">ENDEREÇO</a></li>
                                    <li class="nav-item"><a class="nav-link endbt" data-toggle="tab" href="#cidad" role="tab" aria-expanded="true">CIDADES</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="my-tab-content" class="tab-content text-left">
                        
                            <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">
                                <p class="card-category">CADASTRAR INFORMAÇÕES DA GERENCIADORA</p>   
                                
                                    <input type="hidden" id="id_gerenciadora" name="id_gerenciadora" value="{{$dados_geral->id ?? ''}}">
                                    <div class="row">   
                                        <div class="col-md-2">
                                            <label>Abrev.</label>
                                            <div class="form-group">
                                                <input type="text" name="nome_abrev" id="nome_abrev" class="form-control" placeholder="Nome Abreviado" value="{{$dados_geral->nome_abrev ?? ''}}"> 
                                            </div>
                                        </div>                      
                                        <div class="col-md-8">
                                            <label>Nome</label>
                                            <div class="form-group">
                                                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome da Gerenciadora" value="{{$dados_geral->nome ?? ''}}" required> 
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2">
                                            <label>Lote</label>
                                            <div class="form-group">
                                                <input type="text" name="lote" id="lote" class="form-control" placeholder="Lote" value="{{$dados_geral->lote ?? ''}}"> 
                                            </div>
                                        </div> 
                                        <div class="col-md-3">
                                            <label>CNPJ</label>
                                            <div class="form-group">
                                                <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="CNPJ" value="{{$dados_geral->cnpj ?? ''}}" required> 
                                            </div>
                                        </div>        
                                        <div class="col-md-9">
                                            <label>Contato</label>
                                            <div class="form-group">
                                                <input type="text" name="contato" id="contato" class="form-control" placeholder="Nome do contato" value="{{$dados_geral->contato ?? ''}}"> 
                                            </div>
                                        </div>  
                                        <div class="col-md-3">
                                            <label>Celular</label>
                                            <div class="form-group">
                                                <input type="text" name="celular" id="celular" class="form-control" placeholder="Celular" value="{{$dados_geral->celular ?? ''}}"> 
                                            </div>
                                        </div>  
                                        <div class="col-md-3">
                                            <label>Telefone</label>
                                            <div class="form-group">
                                                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone" value="{{$dados_geral->telefone ?? ''}}"> 
                                            </div>
                                        </div>  
                                        <div class="col-md-4">
                                            <label>E-mail</label>
                                            <div class="form-group">
                                                <input type="email" name="email" id="email" class="form-control" placeholder="E-Mail" value="{{$dados_geral->email ?? ''}}"> 
                                            </div>
                                        </div>  
                                        
                                        <div class="col-md-2">
                                            <label>Status</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="status"  required>
                                                    @if(isset($dados_geral))
                                                        @if($dados_geral->status == 'Ativo') <option selected>Ativo</option> @else <option>Ativo</option> @endif
                                                        @if($dados_geral->status == 'Inativo') <option selected>Inativo</option> @else <option>Inativo</option> @endif                                                        
                                                    @else
                                                        <option>Ativo</option>
                                                        <option>Inativo</option>
                                                     @endif 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="control-label">Observações</label>
                                            <textarea rows="8" name="observacao" placeholder="" class="form-control input-md" autocomplete="off">{{$dados_geral->observacao ?? ''}}</textarea>
                                        </div>  
                                    </div>
                                    
                                    <div class="footerint">
                                        <button type="submit" class="btn btn-outline-primary btn-round btn-sm" id='btfiltrar'><i class="fa fa-cloud-upload"></i> Gravar Dados</button>
                                        <a href="/gerenciadoras" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                    </div> 
                                
                            </div>
                            <div class="tab-pane" id="ende" role="tabpanel" aria-expanded="true">
                                <p class="card-category">CADASTRAR O ENDEREÇO</p>   
                                  
                                    <div class="row">   
                                        
                                        <div class="col-md-2">
                                            <label>Cep</label>
                                            <div class="form-group">
                                                <input type="text" name="cep" id="cep" class="form-control" placeholder="Cep" value="{{$dados_geral->cep ?? ''}}"> 
                                            </div>
                                        </div>  
                                        <div class="col-md-8">
                                            <label>Endereço</label>
                                            <div class="form-group">
                                                <input type="text" name="endereco" id="endereco" class="form-control" placeholder="Endereço" value="{{$dados_geral->endereco ?? ''}}"> 
                                            </div>
                                        </div>  
                                        <div class="col-md-2">
                                            <label>Número</label>
                                            <div class="form-group">
                                                <input type="text" name="numero" id="numero" class="form-control" placeholder="Número" value="{{$dados_geral->numero ?? ''}}"> 
                                            </div>
                                        </div>  
                                        <div class="col-md-3">
                                            <label>Complemento</label>
                                            <div class="form-group">
                                                <input type="text" name="complemento" id="complemento" class="form-control" placeholder="Complemento" value="{{$dados_geral->complemento ?? ''}}"> 
                                            </div>
                                        </div>  
                                        <div class="col-md-4">
                                            <label>Bairro</label>
                                            <div class="form-group">
                                                <input type="text" name="bairro" id="bairro" class="form-control" placeholder="Bairro" value="{{$dados_geral->bairro ?? ''}}"> 
                                            </div>
                                        </div>  
                                        <div class="col-md-3">
                                             <label>Cidade</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="cidade">
                                                    @if(!isset($dados_geral)) <option value="">Selecione</option> @endif
                                                    @foreach($municipios as $key => $value)
                                                        @if(isset($dados_geral))
                                                            @if($value->nome == $dados_geral->cidade) <option value="{{ $value->nome }}" selected>{{ $value->nome }}</option> @else
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
                                        <button type="submit" class="btn btn-outline-primary btn-round btn-sm" id='btfiltrar'><i class="fa fa-cloud-upload"></i> Gravar Dados</button>
                                        <a href="/gerenciadoras" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                    </div> 
                          
                            </div>
                            <div class="tab-pane" id="cidad" role="tabpanel" aria-expanded="true">
                                <p class="card-category">CADASTRAR CIDADES</p>                                  
                                    <form name="form_vinculo" id="form_vinculo">
                                        <input type="hidden" id="id_gerenciadora2" name="id_gerenciadora" value="{{$dados_geral->id ?? ''}}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Selecione a Cidade</label>
                                                <div class="form-group">
                                                    <select class="table-group-action-input form-control" id="municipios_id" name="municipios_id" required>
                                                        <option>Selecione</option>
                                                        @foreach($municipios as $key => $value)
                                                            <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                                        @endforeach
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="padding-top: 18px">
                                                <button type="button" id="btenviarcidade" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Salvar Cidade</button>
                                            </div>
                                        </div>                                             
                                    </form>                            
                                <div class="row" id="tab_vinculos">
                                    
                                </div>
                                <div class="footerint">
                                    <a href="/gerenciadoras" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
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
    $("#telefone").mask("(99) 9999-9999");
    $("#celular").mask("(99) 99999-9999");
    $("#cep").mask("99999-999");

    $('.endbt').click(function(event ){
            event.preventDefault();   
            let id_cliente = $('#id_gerenciadora').val();
            if(id_cliente ==''){
                setTimeout(function(){ 
                    $('.nav-tabs a:first').tab('show');
                    demo.showNotification('top','center','danger','Você precisa cadastrar a <b>Gerenciadora</b> primeiro.')
                }, 500);
            }
            buscar_vinculo();
        });

        function buscar_vinculo(){
            $.get(appUrl+'/gerenciadoras/vinculos/'+$('#id_gerenciadora').val(), function(retorno){
                $('#tab_vinculos').html(retorno);
            });
        }

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

        $("#form_informacoes").submit(function(e) {           
            e.preventDefault(); 
            let form = $(this);
            let id_gerenciadora = $('#id_gerenciadora').val(); 
            $.ajax({
                type: "POST",
                url: appUrl+'/gerenciadoras/cadastro',
                data: form.serialize(), 
                success: function(data)
                {
                    var result = data.split(',');
                    if(result[0] == 'erro'){
                        demo.showNotification('top','center', 'danger', result[1]);
                    }else{
                        if(id_gerenciadora == ''){
                            demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                            $('#id_gerenciadora').val(data);  
                            $('#id_gerenciadora2').val(data);  
                        }else{
                            demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                        }
                    }
                }
            });});


            $( "#btenviarcidade" ).on( "click", function(e) {
                e.preventDefault(); 
                let form = $("#form_vinculo");
                //alert(form.serialize());
                $.ajax({
                    type: "POST",
                    url: appUrl+'/gerenciadoras/vinculos',
                    data: { municipios_id : $('#municipios_id option:selected').val(), id_gerenciadora : $('#id_gerenciadora2').val() },
                    success: function(retorno)
                    {
                        var result = retorno.split(',');
                        if(result[0] == 'erro'){
                            demo.showNotification('top','center', 'danger', result[1]);
                        }else{
                            demo.showNotification('top','center', 'success', 'Região cadastrada com sucesso ');
                            form.trigger("reset");
                            buscar_vinculo();    
                            form.trigger("reset"); 
                        }         
                    }
                });
            });

        // $("#form_vinculo").submit(function(e) {     

             
        //     e.preventDefault(); 
        //     let form = $(this);
        //     alert(form.serialize());
        //     // console.log(form.serialize());
        //     $.ajax({
        //         type: "POST",
        //         url: appUrl+'/gerenciadoras/vinculos',
        //         data: form.serialize(), 
        //         success: function(retorno)
        //         {
        //             var result = retorno.split(',');
        //             if(result[0] == 'erro'){
        //                 demo.showNotification('top','center', 'danger', result[1]);
        //             }else{
        //                 demo.showNotification('top','center', 'success', 'Região cadastrada com sucesso ');
        //                 form.trigger("reset");
        //                 buscar_vinculo();    
        //                 form.trigger("reset"); 
        //             }         
        //         }
        //     });
        // });


    </script>
@endpush