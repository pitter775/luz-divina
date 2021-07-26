@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'ois'
])




@section('content')
<style></style>
<div class="content">

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="retorno_modal"></div>
        </div>
    </div>

    <div class="modal fade" id="myModal3" tabindex="-1" data-teste="oi" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content" id="retorno_modal3"></div>
        </div>
    </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@if(isset($dados_geral->id)) Editar @else Cadastrar @endif OIS </h5>
                    </div>
                    <div class="card-body">

                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">INFORMAÇÕES DA OIS</a></li>
                                    <li class="nav-item"><a class="nav-link endbt" data-toggle="tab" href="#anexos" role="tab" aria-expanded="false">ANEXOS</a></li>
                                    <li class="nav-item"><a class="nav-link endbt" data-toggle="tab" href="#andamentos" role="tab" aria-expanded="false">ANDAMENTO</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="my-tab-content" class="tab-content text-left">
                            <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">
                                <p class="card-category">CADASTRAR OIS</p>   
                                <form name="form_informacoes" id="form_informacoes">
                                    <input type="hidden" id="id_ois" name="id_ois" value="{{$dados_geral->id ?? ''}}">
                                    <div class="row">   
                                        <div class="col-md-3">
                                        <label>Selecione o Cliente</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" id="clientes_id" name="clientes_id" required>
                                                    @if(!isset($dados_geral)) <option value="">Selecione</option> @endif
                                                    @foreach($clientes as $key => $value)
                                                        @if(isset($dados_geral))
                                                            @if($value->id == $dados_geral->clientes_id) <option value="{{ $dados_geral->clientes_id }}" selected>{{ $dados_geral->clnome }}</option> @else
                                                                <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                                            @endif 
                                                        @else
                                                            
                                                            <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                                        @endif 
                                                    @endforeach
                                                </select>
                                            </div>
                                             
                                        </div>
                                        <div class="col-md-3">
                                            <label>Selecione o Contrato</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" id="contratos_id" name="contratos_id" required disabled>
                                                    @if(!isset($dados_geral)) <option value="">Selecione</option> @endif
                                                    @foreach($contratos as $key => $value)
                                                        @if(isset($dados_geral))
                                                            @if($value->id == $dados_geral->contratos_id) <option value="{{ $dados_geral->contratos_id }}" selected>{{ $dados_geral->ctnome }}</option> @else
                                                                <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                                            @endif 
                                                        @else
                                                            <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                        </div> 
                                        <div class="col-md-3">                                

                                            <label>Tipo de Contrato</label>
                                            <div class="form-group">
                                                <input type="text" name="tipo_contrato" id="tipo_contrato" class="form-control" placeholder="Tipo de Contrato" value="" disabled>
                                            </div>                               
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <label>Selecione a área</label>
                                            <div class="form-group" id="recebe_areas">
                                                <input type="text"  class="form-control" placeholder="Área do contrato" value="" disabled>
                                            </div>                                            
                                        </div>  
                                        <div class="col-md-6">
                                            <label>Selecione o Local</label>
                                            <div class="form-group">
                                                <!-- <select class="selefil selectpicker" data-live-search="true"  title="Todos"   data-style='btn-default' name="locals_id" required> -->
                                                <select class="demo-default selectdinamic" name="locals_id"  required>
                                                @if(!isset($dados_geral)) <option value="">Selecione</option> @endif                                                 

                                                    @foreach($locals ?? '' as $key => $value)

                                                        @if(isset($dados_geral))
                                                            @if($value->id == $dados_geral->locals_id) 
                                                                <option value="{{ $value->id }}" selected>{{ $value->nm_local }}</option> 
                                                            @else
                                                                <option value="{{ $value->id }}">{{ $value->nm_local }}</option>  
                                                            @endif
                                                        @else
                                                            <option value="{{ $value->id }}">{{ $value->nm_local }}</option> 
                                                        @endif 
                                                        
                                                    @endforeach
                                                </select>
                                            </div>                                            
                                        </div>      
                                        <div class="col-md-3">
                                            <label>Data</label>
                                            <div class="form-group">
                                                <input type="text" name="dt_ios"  class="form-control datepicker" value="@if(isset($dados_geral))<?php echo date('d/m/Y', strtotime($dados_geral->dt_ios)); ?>@endif ">  
                                            </div>
                                        </div>                          
                                        <div class="col-md-3">
                                            <label>Prazo</label>
                                            <div class="form-group">
                                                <input type="text" name="prazo"  class="form-control datepicker" value="@if(isset($dados_geral))<?php echo date('d/m/Y', strtotime($dados_geral->prazo)); ?>@endif">                                                
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Código Externo</label>
                                            <div class="form-group">
                                            <input type="text" name="codigo_ois" id="codigo_ois" class="form-control" placeholder="" value="{{$dados_geral->codigo_ois ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Valor previsto</label>
                                            <div class="form-group">
                                                <input type="text" name="valor" id="valor" class="form-control" placeholder="R$" value="{{$dados_geral->valor ?? ''}}">
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-3">
                                            <label>Status</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="status"  required>
                                                    @if(isset($dados_geral))
                                                        @if($dados_geral->status == 'Em Execução') <option selected>Em Execução</option> @else <option>Em Execução</option> @endif
                                                        @if($dados_geral->status == 'Não Iniciado') <option selected>Não Iniciado</option> @else <option>Não Iniciado</option> @endif  
                                                        @if($dados_geral->status == 'Paralisado') <option selected>Paralisado</option> @else <option>Paralisado</option> @endif  
                                                        @if($dados_geral->status == 'Concluído') <option selected>Concluído</option> @else <option>Concluído</option> @endif  
                                                    @else                                                            
                                    
                                                    <option data-select="status" >Em Execução</option>
                                                    <option data-select="status" selected>Não Iniciado</option>
                                                    <option data-select="status" >Paralisado</option>
                                                    <option data-select="status" >Concluído</option>
                                                    @endif 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="control-label">Descrição</label>
                                            <textarea id="editor5" placeholder="" class="form-control input-md">{!! $dados_geral->descricao ?? '' !!}</textarea>
                                            <!-- <textarea rows="8" name="descricao" placeholder="" class="form-control input-md" autocomplete="off">{{$dados_geral->descricao ?? ''}}</textarea> -->
                                        </div>
                                    </div>
                                    
                                    <div class="footerint">
                                        <button type="submit" class="btn btn-outline-primary btn-round btn-sm" id='btfiltrar'><i class="fa fa-cloud-upload"></i> Salvar OIS</button>
                                        <a href="/ois" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                    </div> 
                                </form>
                            </div>
                            <div class="tab-pane" id="anexos" role="tabpanel" aria-expanded="false">
                           

                                <p class="card-category">ANEXAR ARQUIVOS</p> 
                                <form name="form_anexo" id="form_anexo" enctype="multipart/form-data">
                                    <input type="hidden" id="id_ois3" name="id_ois" value="{{$dados_geral->id ?? ''}}">                                    
                                    <div class="row">   
                                        <div class="col-md-12" style="padding-top: 18px">
                                            <input type="file" name="arquivo" required>
                                        </div>
                                        <div class="col-md-4" style="padding-top: 5px">
                                            <div class="form-group">
                                                <input type="text" name="descricao" class="form-control" placeholder="Descrição" value="" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4" >
                                            <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Salvar Anexo</button>
                                        </div>                                        
                                    </div>                                     
                                </form> 
                                <div class="row" id="tab_anexos"></div>
                                <div class="footerint">
                                    <a href="/ois" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                </div>
                            </div>
                            <div class="tab-pane" id="andamentos" role="tabpanel" aria-expanded="false">
                                <p class="card-category">CRIAR NOVO ANDAMENTO</p>
                                <form name="form_andamento " id="form_andamento">
                                    <input type="hidden" id="id_ois2" name="id_ois" value="{{$dados_geral->id ?? ''}}">
                                    <div class="row">   
                                        <div class="col-md-2"> 
                                            <label>Serviço</label>
                                            <div id="recebeservico">
                                                <select class="table-group-action-input form-control" name="servico" required>
                                                    <option value="" disabled selected>Selecione</option>
                                                    @foreach($servicos_tipos as $key => $value)
                                                            <option value="{{ $value->snome }}">{{ $value->snome }}</option>                                              
                                                    @endforeach
                                                </select>
                                            </div>                                            
                                        </div>
                                        <div class="col-md-3">
                                            <label>Atividade</label>
                                            <div class="form-group">
                                                <input type="text" name="atividade" id="atividade" class="form-control" placeholder="Atividade" value="" required>
                                            </div>
                                        </div> 

                                        <div class="col-md-3">
                                            <label>Valor</label>
                                            <div class="form-group">
                                                <input type="text" name="valor_andamento" id="valor_andamento" class="form-control" placeholder="R$" value="" >
                                            </div>
                                        </div> 
                                          
                                        <div class="col-md-2">
                                            <label>Data Inicio</label>
                                            <div class="form-group">                                                
                                                <input type="text" name="dt_inicio"  class="form-control datepicker" value="<?php echo date('d/m/Y'); ?>" required>
                                            </div>
                                        </div>                          
                                        <div class="col-md-2">
                                            <label>Data Fim</label>
                                            <div class="form-group">                                                
                                                <input type="text" name="dt_fim"  class="form-control datepicker" value="<?php echo date('d/m/Y'); ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <label class="control-label">Resumo do Andamento</label>
                                            
                                            <textarea id="editor3" placeholder="" class="form-control input-md"></textarea>
                                            
                                        </div>
                                        <div class="col-md-12" style="margin-top: 20px">
                                            <button type="submit" class="btn btn-outline-primary btn-round btn-sm" ><i class="fa fa-cloud-upload"></i> Adicionar Andamento</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="row" id="tab_andamento"></div>
                                <div class="footerint">
                                    <a href="/ois" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
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
    $('#valor').mask('#.##0,00', {reverse: true});
    $('#valor_andamento').mask('#.##0,00', {reverse: true});
    var appUrl ="{{env('APP_URL')}}";
    contratos_id = $('#contratos_id').val();
    if(contratos_id){
        $.get(appUrl+'/ois/gettipocontrato/'+contratos_id, function(data){         
            $('#tipo_contrato').val(data);
        });
        buscar_areas();
       
    }
    if ($(".datepicker").length != 0) {
      $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'pt-br',
        icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-chevron-up",
          down: "fa fa-chevron-down",
          previous: 'fa fa-chevron-left',
          next: 'fa fa-chevron-right',
          today: 'fa fa-screenshot',
          clear: 'fa fa-trash',
          close: 'fa fa-remove'
        }
      });
    }
    if($('#id_ois').val() !== ''){
        $('#contratos_id').removeAttr('disabled');
        $('#servico_tipos_id').removeAttr('disabled');
    }
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.endbt').click(function(event ){
        event.preventDefault();   
        let id_ois = $('#id_ois').val();
        if(id_ois ==''){
            setTimeout(function(){ 
                $('.nav-tabs a:first').tab('show');
                demo.showNotification('top','center','danger','Você precisa cadastrar a <b>OIS</b> primeiro.')
            }, 500);
        }else{
            buscar_anexo();
            buscar_andamento();
        }
        
    }); 
    $("#form_informacoes").submit(function(e) {           
        e.preventDefault(); 
        let form = $(this);
        let id_local = $('#id_ois').val(); 
        const editorData = editor5.getData();
            var dados_serealize = [];
                dados_serealize =  form.serializeArray();
                dados_serealize.push({name: "descricao", value: editorData});
        $.ajax({
            type: "POST",
            url: appUrl+'/ois/cadastro',
            data: dados_serealize, 
            success: function(data)
            {
                if(id_local == ''){
                    demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                    $('#id_ois').val(data);  
                    $('#id_ois2').val(data);  
                    $('#id_ois3').val(data);  
                }else{
                    demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                }                              
            }
        });
    });
    function getcomboservico(){
        contratos_id = $('#contratos_id').val();
        $.get(appUrl+'/ois/getcomboservico/'+contratos_id, function(data){            
            $('#recebeservico').html(data);
        })
    }
    $(document).on('change', '#clientes_id', function() {
        idcliente = $('#clientes_id').val();           
        $.get(appUrl+'/ois/getcontratos/'+idcliente, function(data){
            $('#contratos_id').removeAttr('disabled');
            $('#servico_tipos_id').prop('disabled', true);
            $("#servico_tipos_id option").remove();
            $("#contratos_id option").remove();
            let primeiro = '<option>Selecione</option>';
            $('#contratos_id').append(primeiro);
            for(i=0; i < data.length; i++){
                option = '<option value="'+data[i].id+'">'+data[i].nome+'</option>';  
                $('#contratos_id').append(option);
            }
        })
    });
    $(document).on('change', '#contratos_id', function() {
        contratos_id = $('#contratos_id').val();
        $.get(appUrl+'/ois/gettipocontrato/'+contratos_id, function(data){            
            $('#tipo_contrato').val(data);
            getcomboservico();  
            buscar_areas();
            
        })
    }); 

    $(document).on('change', '#areas', function() {
        buscar_servico();
    }); 
    $("#form_anexo").submit(function(e) {   
        $('#aguarde, #blanket').css('display','block');
        e.preventDefault(); 
        

        let form = $(this);
        var data = new FormData($("form[name='form_anexo']")[0]);
        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            url: appUrl+'/anexos',
            data: data, 
            success: function(retorno)
            {
                demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                buscar_anexo();  
                $('#aguarde').hide('slow');
                $('#blanket').hide();
                // setTimeout(function() {
                //     $('#aguarde').hide('slow');
                //     $('#blanket').hide();
                // }, 5000);
        
                form.trigger("reset");            
            }
        });
    });
    $("#form_andamento").submit(function(e) {   
                e.preventDefault(); 
            let form = $(this);
            let id_local = $('#id_ois').val();  
        const editorData = editor3.getData();
            var dados_serealize = [];
                dados_serealize =  form.serializeArray();
                dados_serealize.push({name: "resumo", value: editorData});
        $.ajax({
            type: "POST",
            url: appUrl+'/ois/andamento/cadastro',
            data: dados_serealize, 
            success: function(data)
            {
                if(id_local == ''){
                    demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                    $('#id_ois').val(data);  
                }else{
                    demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                }
                form.trigger("reset");  
                editor3.setData( '' );
                buscar_andamento();               
            }
        });
    });
    function buscar_anexo(){   
        let id = $('#id_ois').val();
        $.get(appUrl+'/anexos?id_ois='+id, function(retorno){            
            $('#tab_anexos').html(retorno);
        });
    } 
    function buscar_andamento(){             
        let id = $('#id_ois').val();        
        $.get(appUrl+'/ois/andamento/'+id, function(retorno){    
            $('#tab_andamento').html("");   
            $('#tab_andamento').append(retorno);
        });
    }
    function buscar_areas(){
        let id = $('#contratos_id').val();
        let ois = $('#id_ois').val();
        if(ois == ''){ois = 0}
        let dados = id + '-'+ois;
        $.get(appUrl+'/ois/combo_areas/'+dados, function(retorno){   
            $('#recebe_areas').html(retorno);
            setTimeout(function() { buscar_servico();}, 1000);
     
        });
    }
    function buscar_servico(){
        let id = $('#contratos_id').val();
        let areas = $('#areas').val();
        let dados = id + '-'+areas;
        $.get(appUrl+'/ois/combo_servicos/'+dados, function(retorno){   
            $('#recebeservico').html(retorno);
        });
    }
    ClassicEditor.create( document.querySelector( '#editor3' ), {
        // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        }).then( editor3 => {
            window.editor3 = editor3;
        }).catch( err => {
            console.error( err.stack );
    });
    ClassicEditor.create( document.querySelector( '#editor5' ), {
        // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        }).then( editor5 => {
            window.editor5 = editor5;
        }).catch( err => {
            console.error( err.stack );
    });

    $('.selectdinamic').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input
            }
        }
    });



</script>
@endpush