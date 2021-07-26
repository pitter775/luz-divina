@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'contratos'
]) 

@section('content')

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content" id="retorno_modal3"></div>
    </div>
</div>



    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@if(isset($dados_geral->id)) Editar @else Cadastrar @endif Contratos</h5>
                        @if(isset($dados_geral->id))<h6 class="btn btn-primary btn-round">{{$dados_geral->ctnome ?? ''}}</h6>@endif
                    </div>
                    <div class="card-body">
                        
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">INFORMAÇÕES</a></li>
                                    <li class="nav-item"><a class="nav-link endbt" data-toggle="tab" href="#profile" role="tab" aria-expanded="false" >ADITIVOS</a></li>
                                    <li class="nav-item"><a class="nav-link endbt" data-toggle="tab" href="#anexo" role="tab" aria-expanded="false" >ANEXOS</a></li>
                                    <li class="nav-item"><a class="nav-link endbt" data-toggle="tab" href="#servico" role="tab" id="btaddservico" aria-expanded="false" >SERVIÇOS</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="my-tab-content" class="tab-content text-left">
                            <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">
                                <p class="card-category">CADASTRAR CONTRATOS</p>   
                                <form name="form_informacoes" id="form_informacoes">
                                    <input type="hidden" id="id_contrato" name="id_contrato" value="{{$dados_geral->id ?? ''}}">                                                                         
                                    <div class="row">                                            
                                        <div class="col-md-3">
                                            <label>Cliente</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="clientes_id"  required>
                                                    @if(!isset($dados_geral)) <option value="">Selecione</option> @endif
                                                    @foreach($clientes ?? '' as $key => $value)
                                                        @if(isset($dados_geral))
                                                            @if($value->id == $dados_geral->clientes_id) 
                                                                <option value="{{ $value->id }}" selected>{{ $value->nome }}</option> 
                                                            @else
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
                                            <label>Nome Contrato</label>
                                            <div class="form-group">
                                                <input type="text" name="nome" class="form-control" placeholder="Nome do Contrato" value="{{$dados_geral->ctnome ?? ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Tipo de Contrato</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="tipo_contrato_id"  required>
                                                    <option value="" disabled selected>Selecione</option>  
                                                    @foreach($tipo_contrato ?? '' as $key => $value)
                                                        @if(isset($dados_geral))
                                                            @if($value->id == $dados_geral->tipo_contratos_id) 
                                                                <option value="{{ $value->id }}" selected>{{ $value->nome }}</option> 
                                                            @else
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
                                            <label>Área</label>
                                            <div class="form-group">
                                                <!-- <select class="table-group-action-input form-control" name="areas_id"  required>  -->
                                                <select class="demo-default selectdinamic" multiple name="areas_id[]"  required >
                                                    @foreach($areas ?? '' as $key => $value)
                                                            <?php $selected = ''; ?>
                                                            @if(isset($contratoAreas))
                                                                @foreach($contratoAreas ?? '' as $key => $value2)
                                                                    <?php 
                                                                    if($value->id == $value2->areas_id){
                                                                        $selected = 'selected';
                                                                    }  
                                                                    ?>
                                                                @endforeach
                                                            @endif
                                                            <option value="{{ $value->id }}" {{$selected}}>{{ $value->nome }}</option>                                                         
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <label>Número</label>
                                            <div class="form-group">
                                                <input type="text" name="codigo" class="form-control" placeholder="Número do Contrato" value="{{$dados_geral->codigo ?? ''}}">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Data Base</label> 
                                            <div class="form-group">
                                                
                                                <input type="text" name="dt_base"  class="form-control datepicker" value="@if(isset($dados_geral))<?php echo date('d/m/Y', strtotime($dados_geral->dt_base)); ?>@endif">   
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Data Assinatura</label>
                                            <div class="form-group">
                                                
                                                <input type="text" name="dt_assinatura"  class="form-control datepicker" value="@if(isset($dados_geral))<?php echo date('d/m/Y', strtotime($dados_geral->dt_assinatura)); ?>@endif">   
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Data OIS</label>
                                            <div class="form-group">
                                                
                                                <input type="text" name="dt_ois"  class="form-control datepicker" value="@if(isset($dados_geral))<?php echo date('d/m/Y', strtotime($dados_geral->dt_ois)); ?>@endif">   
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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
                                            <textarea id="editor6" placeholder="" class="form-control input-md">{!!$dados_geral->ctobservacao ?? ''!!}</textarea>
                                            <!-- <textarea rows="8" name="observacao" placeholder="" class="form-control input-md" autocomplete="off">{{$dados_geral->ctobservacao ?? ''}}</textarea> -->
                                        </div>
                                        
                                    </div>
                                    <div class="footerint">
                                        <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Gravar Dados</button>
                                        <a href="/contratos" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                        
                                    </div>                                  
                                </form> 
                            </div>
                            <div class="tab-pane" id="profile" role="tabpanel" aria-expanded="false">
                                <p class="card-category">CADASTRAR ADITIVOS</p>                                  
                                <form name="form_aditivo" id="form_aditivo">
                                    <input type="hidden" id="id_contrato2" name="id_contrato" value="{{$dados_geral->id ?? ''}}">
                                    <div class="row"> 
                                        <div class="col-md-4">
                                            <label>Nr Termo</label>
                                            <div class="form-group">
                                                <input type="text" name="nr_termo" id="nr_termo" class="form-control" placeholder="Nr Termo" value="{{$dados_geral->nr_termo ?? ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Data Vigência</label>
                                            <div class="form-group">
                                                <input type="text" name="dt_vigencia"  class="form-control datepicker" value="">   
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Valor Atual <b>R$</b></label>
                                            <div class="form-group">
                                                <input type="text" name="vlr_atual" id="vlr_atual" class="form-control" placeholder="R$" value="{{$dados_geral->vlr_atual ?? ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label>Objeto do Aditivo</label>
                                            <div class="form-group">
                                                <!-- <input type="text" name="objeto" class="form-control" placeholder="Objeto do Aditivo:" value="{{$dados_geral->objeto ?? ''}}"> -->
                                                <textarea id="editor7" placeholder="" class="form-control input-md">{!!$dados_geral->objeto ?? ''!!}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="padding-top: 18px">
                                            <button type="submit" class="btn btn-outline-primary btn-round btn-sm" ><i class="fa fa-cloud-upload"></i> Salvar Aditivo</button>
                                        </div>
                                        
                                    </div>                                                                                    
                                </form>                            
                                <div class="row" id="tab_aditivos"></div>
                                <div class="footerint">
                                    <a href="/contratos" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                </div>
                            </div>                            
                            <div class="tab-pane" id="anexo" role="tabpanel" aria-expanded="false">
                                <p class="card-category">ANEXAR ARQUIVOS</p> 
                                <form name="form_anexo" id="form_anexo" enctype="multipart/form-data">
                                    <input type="hidden" id="id_contrato3" name="id_contrato" value="{{$dados_geral->id ?? ''}}">                                    
                                    <div class="row">   
                                        <div class="col-md-4" style="padding-top: 18px">
                                            <input type="file" name="arquivo">
                                        </div>
                                        <div class="col-md-4" style="padding-top: 5px">
                                            <div class="form-group">
                                                <input type="text" name="descricao" class="form-control" placeholder="Descrição" value="{{$dados_geral->descricao ?? ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4" >
                                            <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Salvar Anexo</button>
                                        </div>                                        
                                    </div>                                     
                                </form>
                                <div class="row" id="tab_anexos"></div>
                                <div class="footerint">
                                    <a href="/contratos" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                </div>
                            </div>
                            <div class="tab-pane" id="servico" role="tabpanel" aria-expanded="false">
                                <p class="card-category">CADASTRAR SERVIÇO PARA ESTE CONTRATO</p> 
                                <form name="form_servico" id="form_servico" enctype="multipart/form-data">                                                                    
                                    <input type="hidden" id="id_contrato4" name="id_contrato" value="{{$dados_geral->id ?? ''}}">                                    
                                    <div class="row">   
                                        <div class="col-md-4" style="padding-top: 5px">
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="id_servicos">                                                   
                                                    <option value="" disabled selected>Selecione</option>
                                                    @foreach($servicos as $key => $value)
                                                            <option value="{{ $value->id }}">{{ $value->nome }}</option>                                              
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="padding-top: 5px">
                                            <div class="form-group" id="recebeareas">

                                            </div>
                                        </div>

                                        <div class="col-md-4" >
                                            <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Adicionar Serviço</button>
                                        </div>                                        
                                    </div>                                     
                                </form>
                                <div class="row" id="tab_servicos"></div>
                                <div class="footerint">
                                    <a href="/contratos" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
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
    $("#nr_termo").mask("9999999999999");
    
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }});
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
    $('.endbt').click(function(event ){
        event.preventDefault();   
        let id_contrato = $('#id_contrato').val();
        if(id_contrato ==''){
            setTimeout(function(){ 
                $('.nav-tabs a:first').tab('show');
                demo.showNotification('top','center','danger','Você precisa cadastrar o <b>Contrato</b> primeiro.')
            }, 500);
        }else{
            buscar_aditivo();
            buscar_anexo();
            buscar_servico();
            buscar_areas();
        }        
    });
    $("#form_informacoes").submit(function(e) {           
        e.preventDefault(); 
        let form = $(this);
        let id_contrato = $('#id_contrato').val(); 
        const editorData = editor6.getData();
            var dados_serealize = [];
                dados_serealize =  form.serializeArray();
                dados_serealize.push({name: "observacao", value: editorData});
        $.ajax({
            type: "POST",
            url: appUrl+'/contratos/cadastro',
            data: dados_serealize, 
            success: function(data)
            {
                var result = data.split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{
                    if(id_contrato == ''){
                        demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                        $('#id_contrato').val(data);  
                        $('#id_contrato2').val(data); 
                        $('#id_contrato3').val(data); 
                        $('#id_contrato4').val(data); 
                    }else{
                        demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                    }
                }
            }
        });
    });
    $("#form_aditivo").submit(function(e) {           
        e.preventDefault(); 
        let form = $(this);
        const editorData = editor6.getData();
        var dados_serealize = [];
            dados_serealize =  form.serializeArray();
            dados_serealize.push({name: "objeto", value: editorData});
        $.ajax({
            type: "POST",
            url: appUrl+'/contratos/aditivos',
            data: dados_serealize, 
            success: function(retorno)
            {
                
                var result = retorno.split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{
                    demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                    buscar_aditivo();  
                    form.trigger("reset");
                    editor6.setData( '' );
                    $('#editor7').html('');
                }         
            }
        });
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
                form.trigger("reset");            
            }
        });
    });     
    function buscar_aditivo(){
        $.get(appUrl+'/contratos/aditivos/'+$('#id_contrato').val(), function(retorno){
            $('#tab_aditivos').html(retorno);
        });
    }
    function buscar_anexo(){   
        let id = $('#id_contrato').val();
        $.get(appUrl+'/anexos?contratos_id='+id, function(retorno){            
            $('#tab_anexos').html(retorno);
        });
    }
    function buscar_areas(){
        let id = $('#id_contrato').val();
        $.get(appUrl+'/contratos/combo_servicos/'+id, function(retorno){            
            $('#recebeareas').html(retorno);
        });
    }
    $("#form_servico").submit(function(e) {           
        e.preventDefault(); 
        let form = $(this);
        var dados_serealize = [];
            dados_serealize =  form.serializeArray();
            dados_serealize.push({"_token": "{{ csrf_token() }}"});
        $.ajax({
            type: "POST",
            url: appUrl+'/contratos/servicos',
            data: form.serialize(),  
            success: function(retorno)
            {
                var result = retorno.split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{
                    demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                    buscar_servico();  
                    form.trigger("reset"); 
                }      
            }
        });
    });     
    function buscar_servico(){
        $.get(appUrl+'/contratos/servicos/'+$('#id_contrato4').val(), function(retorno){
            $('#tab_servicos').html(retorno);
        });
    }
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

    ClassicEditor.create( document.querySelector( '#editor6' ), {}).then( editor6 => {
        window.editor6 = editor6; }).catch( err => {console.error( err.stack );
    });  
    ClassicEditor.create( document.querySelector( '#editor7' ), {}).then( editor7 => {
        window.editor6 = editor7; }).catch( err => {console.error( err.stack );
    });  

    </script>
@endpush