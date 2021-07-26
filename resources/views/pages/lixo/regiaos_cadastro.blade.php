@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'regiaos'
])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@if(isset($dados_geral->id)) Editar @else Cadastrar @endif Região </h5>
                        @if(isset($dados_geral->id))<h6 class="btn btn-primary btn-round">{{$dados_geral->nome ?? ''}}</h6>@endif
                    </div>
                    <div class="card-body">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">INFORMAÇÕES DA REGIÃO</a></li>
                                    <li class="nav-item"><a class="nav-link endbt" data-toggle="tab" href="#anexo" role="tab" id="btaddservico" aria-expanded="false" >CIDADES</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="my-tab-content" class="tab-content text-left">
                            <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">
                                <p class="card-category">CADASTRAR REGIÃO</p>   
                                <form name="form_informacoes" id="form_informacoes">
                                    <input type="hidden" id="id_regiao" name="id_regiao" value="{{$dados_geral->id ?? ''}}">
                                    <div class="row">                                                                 
                                        <div class="col-md-8">
                                            <label>Nome</label>
                                            <div class="form-group">
                                                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome da Região" value="{{$dados_geral->nome ?? ''}}" required> 
                                            </div>
                                        </div>                                     
                                    </div>                                    
                                    <div class="footerint">
                                        <button type="submit" class="btn btn-outline-primary btn-round btn-sm" id='btfiltrar'><i class="fa fa-cloud-upload"></i> Salvar Região</button>
                                        <a href="/regiaos" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                    </div> 
                                </form>
                            </div>
                            <div class="tab-pane" id="anexo" role="tabpanel" aria-expanded="false">
                                <p class="card-category">CADASTRAR CIDADES PARA ESSA REGIAO</p> 
                                <form name="form_vinculo" id="form_vinculo">
                                    <input type="hidden" id="id_regiao2" name="id_regiao" value="{{$dados_geral->id ?? ''}}">                                    
                                    <div class="row">   
                                        <div class="col-md-4" style="padding-top: 5px">
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="id_cidade" required>
                                                <option value="">Selecione</option>
                                                    @foreach($cidades as $key => $value)
                                                        
                                                            <option value="{{ $value->id }}">{{ $value->nome }}</option> 
                                                     
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4" >
                                            <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Adicionar Cidade</button>
                                        </div>                                        
                                    </div>                                     
                                </form>
                                <div class="row" id="tab_vinculos"></div>
                                <div class="footerint">
                                    <a href="/regiaos" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                </div>
                            </div>
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

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});

        $('.endbt').click(function(event ){
            event.preventDefault();   
            let id_cliente = $('#id_regiao').val();
            if(id_cliente ==''){
                setTimeout(function(){ 
                    $('.nav-tabs a:first').tab('show');
                    demo.showNotification('top','center','danger','Você precisa cadastrar o <b>Usuário</b> primeiro.')
                }, 500);
            }
            buscar_vinculo();
        });

        function buscar_vinculo(){
            $.get(appUrl+'/regiaos/vinculos/'+$('#id_regiao').val(), function(retorno){
                $('#tab_vinculos').html(retorno);
            });
        }

        $("#form_vinculo").submit(function(e) {           
            e.preventDefault(); 
            let form = $(this);
            $.ajax({
                type: "POST",
                url: appUrl+'/regiaos/vinculos',
                data: form.serialize(), 
                success: function(retorno)
                {
                    var result = retorno.split(',');
                    if(result[0] == 'erro'){
                        demo.showNotification('top','center', 'danger', result[1]);
                    }else{
                        demo.showNotification('top','center', 'success', 'Cidade adicionada com sucesso ');
                        form.trigger("reset");
                        buscar_vinculo();  
                    }         
                }
            });
        });

        $("#form_informacoes").submit(function(e) {           
            e.preventDefault(); 
            let form = $(this);
            let id_local = $('#id_regiao').val(); 
            $.ajax({
                type: "POST",
                url: appUrl+'/regiaos/cadastro',
                data: form.serialize(),  
                success: function(data)
                {
                    var result = data.split(',');
                    if(result[0] == 'erro'){
                        demo.showNotification('top','center', 'danger', result[1]);
                    }else{
                        if(id_local == ''){
                            demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso, <br> Agora você pode adiconar as Cidades! ');
                            $('#id_regiao').val(data);  
                            $('#id_regiao2').val(data);  
                            $('#btaddservico').click();
                        }else{
                            demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                        }
                    }                    
                }
            });});


    </script>
@endpush