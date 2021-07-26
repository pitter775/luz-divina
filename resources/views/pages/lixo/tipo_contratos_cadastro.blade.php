@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'tipo_contratos'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@if(isset($dados_geral->id)) Editar @else Cadastrar @endif Tipos de Contrato</h5>
                        @if(isset($dados_geral->id))<h6 class="btn btn-primary btn-round">{{$dados_geral->nome ?? ''}}</h6>@endif
                        
                    </div>
                    <div class="card-body">

                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">INFORMAÇÕES</a></li>
                                    <!-- <li class="nav-item"><a class="nav-link endbt" data-toggle="tab" href="#anexo" role="tab" id="btaddservico" aria-expanded="false" >SERVIÇOS</a></li> -->
                                </ul>
                            </div>
                        </div>
                        <div id="my-tab-content" class="tab-content text-left">
                            <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">
                                <p class="card-category">CADASTRAR TIPO DE CONTRATO</p>   
                                <form name="form_informacoes" id="form_informacoes">
                                    <input type="hidden" id="id_tipo_contrato" name="id_tipo_contrato" value="{{$dados_geral->id ?? ''}}">                                                                         
                                    <div class="row">                                            
                                        <div class="col-md-5">
                                            <label>Tipo de Contrato</label>
                                            <div class="form-group">
                                                <input type="text" name="nome" class="form-control" placeholder="Nome do Tipo de Contrato" value="{{$dados_geral->nome ?? ''}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footerint">
                                        <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Gravar Dados</button>
                                        <a href="/tipo_contratos" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                    </div>                                  
                                </form>
                            </div>
                            <div class="tab-pane" id="anexo" role="tabpanel" aria-expanded="false">
                                <p class="card-category">CADASTRAR SERVIÇO PARA ESTE CONTRATO</p> 
                                <form name="form_anexo" id="form_anexo" enctype="multipart/form-data">
                                    <input type="hidden" id="id_tipo_contrato2" name="id_tipo_contrato" value="{{$dados_geral->id ?? ''}}">                                    
                                    <div class="row">   
                                        <div class="col-md-4" style="padding-top: 5px">
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="id_servicos">
                                                    @if(!isset($clientes)) <option value="">Selecione</option> @endif
                                                    @foreach($servicos as $key => $value)
                                                        @if(isset($clientes))
                                                            @if($value->nome == $clientes->cidade) <option value="{{ $value->id }}" selected>{{ $value->nome }}</option> @else
                                                                <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                                            @endif                                                          
                                                        @else
                                                            <option value="{{ $value->id }}">{{ $value->nome }}</option> 
                                                        @endif 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4" >
                                            <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Adicionar Serviço</button>
                                        </div>                                        
                                    </div>                                     
                                </form>
                                <div class="row" id="tab_anexos"></div>
                                <div class="footerint">
                                    <a href="/tipo_contratos" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
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
    $('#vlr_atual').mask('#.##0,00', {reverse: true});
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});
    $('.endbt').click(function(event ){
        event.preventDefault();   
        let id_contrato = $('#id_tipo_contrato').val();
        if(id_contrato ==''){
            setTimeout(function(){ 
                $('.nav-tabs a:first').tab('show');
                demo.showNotification('top','center','danger','Você precisa cadastrar o <b>Tipo de Contrato</b> primeiro.')
            }, 500);
        }
        console.log('buscando anexo...')
        buscar_anexo();});  
    $("#form_informacoes").submit(function(e) {           
        e.preventDefault(); 
        let form = $(this);
        let id_tipo_contrato = $('#id_tipo_contrato').val(); 
        $.ajax({
            type: "POST",
            url: appUrl+'/tipo_contratos/cadastro',
            data: form.serialize(), 
            success: function(data)
            {
                var result = data.split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{
                    if(id_tipo_contrato == ''){
                        demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso, <br> Agora você pode adiconar os Serviços!  ');
                        $('#id_tipo_contrato').val(data);  
                        $('#id_tipo_contrato2').val(data); 
                        $('#btaddservico').click();
                    }else{
                        demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                    }
                }
            }
        });});


    $("#form_anexo").submit(function(e) {           
        e.preventDefault(); 
        let form = $(this);
        $.ajax({
            type: "POST",
            url: appUrl+'/tipo_contratos/anexos',
            data: form.serialize(),  
            success: function(retorno)
            {
                var result = retorno.split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{
                    demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                    buscar_anexo();  
                    form.trigger("reset"); 
                }      
            }
        });});     
    function buscar_anexo(){
        $.get(appUrl+'/tipo_contratos/anexos/'+$('#id_tipo_contrato').val(), function(retorno){
            $('#tab_anexos').html(retorno);
        });}

        

</script>
@endpush