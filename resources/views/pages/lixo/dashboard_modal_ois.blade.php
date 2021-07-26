<style>
    .modal-md span{ font-weight: 600; color: #0f61ad; padding-right: 10px; font-size: 10px;}
    .modal-md p{ line-height: .5;}
    .mddescri p{ line-height: 1.5 !important;}    
    .bttab{ display: none;}
    .ultd{ display: none;}
    p.heitlock{line-height: 1.5 !important;}    
</style>
<div class="content">
        <div class="row">
            <div class="col-md-12">
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
                            <input type="hidden" id="id_ois" name="id_ois" value="{{$dados_geral->id ?? ''}}">
                            <div class="row modal-md">
                                <div class="col-md-12 ">
                                <p>
                                    <span>TIPO DE CONTRATO: </span>                          
                                    <span class="badge badge-default" style="background-color:#0f61ad; color: #fff ">{{ $dados_geral->tcnome ?? '' }}</span>
                                </p>
                                <p><span>CLIENTE </span>{{ $dados_geral->clnome ?? '' }}</p>
                                <p><span>CONTRATO </span>{{ $dados_geral->ctnome ?? '' }}</p>
                                <p class="heitlock"><span>LOCAL </span>{{ $dados_geral->nm_local ?? '' }} - {{$dados_geral->logradouro ?? '' }}, {{ $dados_geral->numero ?? '' }} @if($dados_geral->lbairro) - @endif {{ $dados_geral->lbairro ?? '' }}</p>
                                </div>
                                <div class="col-md-6 ">
                                    <p><span>DATA </span><?php echo date('d/m/Y', strtotime($dados_geral->dt_ios)); ?> </p>
                                </div>
                                <div class="col-md-6 ">
                                    <p><span>PRAZO </span><?php echo date('d/m/Y', strtotime($dados_geral->prazo)); ?> </p>
                                </div>
                                <div class="col-md-6 ">
                                    <p><span>VALOR </span>{{$dados_geral->valor ?? ''}} </p>
                                </div>
                                <div class="col-md-6 ">
                                    <p><span>STATUS </span>{{$dados_geral->status ?? ''}} </p>
                                </div>
                                <div class="col-md-12 mddescri ">
                                    <div class="card">
                                        <div class="card-body">
                                            <p>{!!$dados_geral->descricao ?? ''!!}</p>
                                        </div>
                                    </div>                                    
                                </div>   
                            </div>
                            <div class="footerint">                                    
                                <button type="button" onclick="fechartela()" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Fechar</button>
                            </div> 
                        </div>
                        <style>.borderanexo{ border: none !important; margin-top: -20px !important}</style>
                        <div class="tab-pane" id="anexos" role="tabpanel" aria-expanded="false">
                            <input type="hidden" id="id_ois3" name="id_ois" value="{{$dados_geral->id ?? ''}}">
                            <div class="row" id="tab_anexos"></div>
                            <div class="footerint">
                                <button type="button" onclick="fechartela()" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Fechar</button>
                            </div>
                        </div>
                        <div class="tab-pane" id="andamentos" role="tabpanel" aria-expanded="false">                         
                            <input type="hidden" id="id_ois2" name="id_ois" value="{{$dados_geral->id ?? ''}}">                           
                            <div class="row" id="tab_andamento"></div>
                            <div class="footerint">
                                <button type="button" onclick="fechartela()" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Fechar</button>
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
<script>
    var appUrl ="{{env('APP_URL')}}";
    $('#valor').mask('#.##0,00', {reverse: true});
    var appUrl ="{{env('APP_URL')}}";
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
        $.ajax({
            type: "POST",
            url: appUrl+'/ois/cadastro',
            data: form.serialize(), 
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
        $.get(appUrl+'/ois/getservicos/'+contratos_id, function(data){
            console.log(data);
            $('#servico_tipos_id').removeAttr('disabled');
            $("#servico_tipos_id option").remove();
            for(i=0; i < data.length; i++){
                option = '<option value="'+data[i].servico_tipos_id+'">'+data[i].nome+'</option>';  
                $('#servico_tipos_id').append(option);
            }
        })
    }); 
    $("#form_anexo").submit(function(e) {   
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
                form.trigger("reset");            
            }
        });
    });
    $("#form_andamento").submit(function(e) {   
        e.preventDefault(); 
        let form = $(this);
        let id_local = $('#id_ois').val(); 
        $.ajax({
            type: "POST",
            url: appUrl+'/ois/andamento/cadastro',
            data: form.serialize(), 
            success: function(data)
            {
                if(id_local == ''){
                    demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                    $('#id_ois').val(data);  
                }else{
                    demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                }
                form.trigger("reset");  
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
            $('#tab_andamento').html(retorno);
        });
    } 
</script>
