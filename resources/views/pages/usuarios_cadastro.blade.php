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
                        <h5>@if(isset($dados_geral->id)) Editar @else Cadastrar @endif Usuários</h5>
                        @if(isset($dados_geral->id))<h6 class="btn btn-primary btn-round">{{$dados_geral->name ?? ''}}</h6>@endif
                    </div>
                    <div class="card-body">                    
                            
                            <div class="nav-tabs-navigation">
                                <div class="nav-tabs-wrapper">
                                    <ul id="tabs" class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">INFORMAÇÕES</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="my-tab-content" class="tab-content text-left">
                                <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">
                                    <form name="form_informacoes" id="form_informacoes">
                                        <input type="hidden" id="id_usuario" name="id_usuario" value="{{$dados_geral->id ?? ''}}">
                                        <p class="card-category">CADASTRAR USUÁRIO</p>                                    
                                        <div class="row">                                            
                                            <div class="col-md-9">
                                                <label>Nome</label>
                                                <div class="form-group">
                                                    <input type="text" id="name" name="name" class="form-control" placeholder="Nome do Usuário" value="{{$dados_geral->name ?? ''}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Celular</label>
                                                <div class="form-group">
                                                    <input type="telefone" name="telefone" id="telefone" class="form-control" placeholder="Telefone" value="{{$dados_geral->telefone ?? ''}}" required>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Login</label>
                                                <div class="form-group">
                                                    <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" value="{{$dados_geral->email ?? ''}}" required>
                                                </div>
                                            </div>
                                            @if(!isset($dados_geral))
                                            <div class="col-md-3">
                                                <label>Senha</label>
                                                <div class="form-group">
                                                    <input type="text" name="password" id="password" class="form-control" placeholder="Senha" value="">
                                                </div>
                                            </div>
                                           @else
                                           <div class="col-md-3">
                                                <label>Nova Senha</label>
                                                <div class="form-group">
                                                    <input type="text" name="password" id="password" class="form-control" placeholder="Nova Senha" value="">
                                                </div>
                                            </div>
                                            @endif

                                            <div class="col-md-3">
                                                <label>Tipo de Acesso</label>
                                                <div class="form-group">
                                                    <select class="table-group-action-input form-control" name="acesso" id="acesso" value="{{$dados_geral->acesso ?? ''}}" >   
                                                        <option value="" disabled selected>Selecione</option>
                                                        @if(isset($dados_geral))
                                                            @if($dados_geral->acesso == 'Vendedor') <option selected>Vendedor</option> @else <option>Vendedor</option> @endif                                                            
                                                            @if($dados_geral->acesso == 'Admin') <option selected>Admin</option> @else <option>Admin</option> @endif   
                                                        @else  
                                                                                                           
                                                            <option selected>Vendedor</option>
                                                            <option>Admin</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Status</label>
                                                <div class="form-group">
                                                    <select class="table-group-action-input form-control" name="status" value="{{$dados_geral->status ?? ''}}" required>
                                                        
                                                        @if(isset($dados_geral))
                                                            @if($dados_geral->status == 'Ativo') <option selected>Ativo</option> @else <option>Ativo</option> @endif
                                                            @if($dados_geral->status == 'Inativo') <option selected>Inativo</option> @else <option>Inativo</option> @endif 
                                                        @else                                                            
                                                            <option selected>Ativo</option>
                                                            <option>Inativo</option>
                                                        @endif   
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="card" id="divconsulta" style=" width: 100%; margin: 20px; display:none">
                                                <p class="tit2" style="margin-left: 20px; font-size: 13px; color: #777">Configuração de Acesso do tipo Consulta</p>
                                                <div class="row" style="padding: 20px">    
                                                
                                                    <div class="col-md-3">
                                                        <label>Tipo - consulta</label>
                                                        <div class="form-group">
                                                            <select class="table-group-action-input form-control" name="tipo_consulta" id="sele_tipo">
                                                                <option value="" disabled selected>Selecione</option>
                                                                @if(isset($dados_geral))
                                                                <option  @if($dados_geral->tipo_consulta == 'Cliente') selected @endif >Cliente</option>
                                                                <option  @if($dados_geral->tipo_consulta == 'Região') selected @endif >Região</option>
                                                                <option  @if($dados_geral->tipo_consulta == 'Gerenciadora') selected @endif >Gerenciadora</option>
                                                                @else
                                                                <option selected>Cliente</option>
                                                                <option>Região</option>
                                                                <option>Gerenciadora</option>
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3" id="sele_cli" style="display: none;">
                                                        <label>Cliente</label>
                                                        <div class="form-group">
                                                            <select class="table-group-action-input form-control" name="clientes_id" id="clientes_id">
                                                                <option value="" disabled selected>Selecione</option>
                                                                @foreach($cliente ?? '' as $key => $value)
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

                                                    <div class="col-md-9" id="sele_reg" style="display: none;">
                                                        <label>Região</label>
                                                        <div class="form-group">
                                                            <!-- <select class="table-group-action-input form-control" name="regiaos_id" id="regiaos_id_cons" > -->
                                                            <!-- <select name="regiaos_id[]" id="regiaos_id_cons" title="Selecione" class="selectpicker" data-style='btn-default' multiple > -->
                                                            <select class="demo-default selectdinamic" multiple name="regiaos_id[]"  id="regiaos_id_cons" >
                                                                @foreach($regiao ?? '' as $key => $value)
                                                                    <?php $selected = ''; ?>
                                                                    @if(isset($users_regiaos))
                                                                        @foreach($users_regiaos ?? '' as $key => $value2)
                                                                            <?php if($value->id == $value2->regiaos_id && $value2->acesso == 'Consulta'){
                                                                                $selected = 'selected';
                                                                            }  ?>
                                                                        @endforeach
                                                                    @endif
                                                                    <option value="{{ $value->id }}" {{$selected}}>{{ $value->nome }}</option>                                                             
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>                                                    

                                                    <div class="col-md-3" id="sele_geren" style="display: none;">
                                                        <label>Gerenciadora</label>
                                                        <div class="form-group">
                                                            <select class="table-group-action-input form-control" name="gerenciadoras_id" id="gerenciadoras_id">
                                                                <option value="" disabled selected>Selecione</option>
                                                                @foreach($gerenciadora ?? '' as $key => $value)
                                                                    @if(isset($dados_geral))
                                                                        @if($value->id == $dados_geral->gerenciadoras_id) 
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
                                                </div>
                                            </div>

                                            <div class="card" id="divoperacional" style=" width: 100%; margin: 20px;">
                                                <p class="tit2" style="margin-left: 20px; font-size: 13px; color: #777">Configuração de Acesso do tipo Operacional</p>
                                                <div class="row" style="padding: 20px">                                                
                                                    <div class="col-md-3">
                                                        <label>Tipo - Operacional</label>
                                                        <div class="form-group">
                                                            <select class="table-group-action-input form-control" name="tipo_gestor" id="sele_operacional"  >
                                                                <option value="" disabled selected>Selecione</option>
                                                                @if(isset($dados_geral))
                                                                <option @if($dados_geral->tipo_gestor == 'GestorADM') selected @endif >GestorADM</option>
                                                                <option @if($dados_geral->tipo_gestor == 'CDHU') selected @endif >CDHU</option>
                                                                <option @if($dados_geral->tipo_gestor == 'Gestor') selected @endif >Gestor</option>
                                                                <option @if($dados_geral->tipo_gestor == 'Técnico') selected @endif >Técnico</option>
                                                                @else                                                   
                                                                <option>GestorADM</option>
                                                                <option>CDHU</option>
                                                                <option>Gestor</option>
                                                                <option>Técnico</option>
                                                                @endif
                                                                
                                                            </select> 
                                                        </div>
                                                    </div>

                                                    <div class="col-md-9" id="opregiao" style="display: none;">
                                                        <label>Região</label>
                                                        <div class="form-group">
                                                            <!-- <select class="table-group-action-input form-control" name="regiaos_id" id="regiaos_id_oper" > -->
                                                            <!-- <select name="regiaos_id[]" id="regiaos_id_oper"  title="Selecione" class="selectpicker" data-style='btn-default' multiple > -->
                                                            <select class="demo-default selectdinamic" multiple name="regiaos_id[]"  id="regiaos_id_oper" >
                                                                @foreach($regiao ?? '' as $key => $value)
                                                                    <?php $selected = ''; ?>
                                                                    @if(isset($users_regiaos))
                                                                        @foreach($users_regiaos ?? '' as $key => $value2)
                                                                            <?php 
                                                                            if($value->id == $value2->regiaos_id && $value2->acesso == 'Operacional'){
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

                                                    <div class="col-md-3" id='oparea' style="display: none;" >
                                                        <label>Area</label>
                                                        <div class="form-group">
                                                            <select class="table-group-action-input form-control" name="areas_id" id="areas_id" >                                                              
                                                                <option value="" disabled selected>Selecione</option>
                                                                @foreach($areas ?? '' as $key => $value)
                                                                    @if(isset($dados_geral))
                                                                        @if($value->id == $dados_geral->areas_id) 
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

                                                    <div class="col-md-3" id='optipocont' style="display: none;" >
                                                        <label>Tipo de Contrato</label>
                                                        <div class="form-group">
                                                            <select class="table-group-action-input form-control" name="tipo_contratos_id" id="tipo_contratos_id">
                                                              
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
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="footerint">
                                            <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Gravar Dados</button>
                                            <a href="/usuarios" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>                                            
                                        </div>                                  
                                    </form>
                                </div>
                                <div class="tab-pane" id="profile" role="tabpanel" aria-expanded="false">
                                    <p class="card-category">CADASTRAR A REGIÃO DO USUÁRIO</p>                                  
                                        <form name="form_vinculo" id="form_vinculo">
                                            <input type="hidden" id="id_usuario2" name="id_usuario" value="{{$dados_geral->id ?? ''}}">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label>Região</label>
                                                    <div class="form-group">
                                                        <select class="table-group-action-input form-control" name="regiaos_id" >
                                                            <option>Selecione</option>
                                                            @foreach($regiao ?? '' as $key => $value)
                                                                <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="padding-top: 18px">
                                                    <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Salvar Vinculo</button>
                                                </div>
                                            </div>                                             
                                        </form>                            
                                    <div class="row" id="tab_vinculos">
                                        
                                    </div>
                                    <div class="footerint">
                                            <a href="/usuarios" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
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
        }
    });
    $("#telefone").mask("(99) 99999-9999");
    $('#divoperacional').hide();
    $('#divconsulta').hide("fast");
    $('#divoperacional').hide("fast");  

    let tipouser = $('#acesso').val();
    console.log(tipouser);

    if($('#id_usuario').val() == ''){
        $("#password").prop('required',true);
    }
    // switch(tipouser) {
    //     case 'Consulta':          
    //         $('#divconsulta').show("fast");
    //         $("#sele_tipo").prop('required',true);  
    //         let sele_tipo = $('#sele_tipo').val();            
    //         console.log(sele_tipo);
    //         switch(sele_tipo) {
    //             case 'Cliente':
    //                 $('#sele_cli').show();
    //                 $('#sele_reg').hide();
    //                 $('#sele_geren').hide();
    //                 $("#clientes_id").prop('required',true);
    //                 break;
    //             case 'Região':
    //                 $('#sele_cli').hide();
    //                 $('#sele_reg').show();
    //                 $('#sele_geren').hide();
    //                 $("#regiaos_id_cons").prop('required',true);
    //                 break;
    //             case 'Gerenciadora':
    //                 $('#sele_cli').hide();
    //                 $('#sele_reg').hide();
    //                 $('#sele_geren').show();
    //                 $("#gerenciadoras_id").prop('required',true);
    //                 break;
    //             }
    //         break;
    //     case 'Operacional':
    //         $('#divoperacional').show("fast");
    //         $("#sele_operacional").prop('required',true); 
    //         let acessoOper = $('#sele_operacional').val();
    //         console.log(acessoOper);
    //         switch(acessoOper) {
    //             case 'GestorADM':
    //                 $('#opregiao').hide();
    //                 $('#optipocont').hide();
    //                 $('#oparea').hide();
    //                 break;
    //             case 'CDHU':
    //                 console.log('oper - CDHU');
    //                 $('#opregiao').hide();
    //                 $('#optipocont').hide();
    //                 $('#oparea').show();
    //                 $("#areas_id").prop('required',true);
    //                 break;
    //             case 'Gestor':                
    //                 $('#optipocont').hide();
    //                 $('#oparea').hide();
    //                 $('#opregiao').show();    
    //                 $("#regiaos_id_oper").prop('required',true);              
    //                 break;
    //             case 'Técnico':                
    //                 $('#optipocont').hide();
    //                 $('#oparea').hide();
    //                 $('#opregiao').show();  
    //                 $("#regiaos_id_oper").prop('required',true);                
    //                 break;
    //         }
    //         break;
    //     case 'Admin':
    //         $('#divconsulta').hide("fast");
    //         $('#divoperacional').hide("fast");
    //         break;
    // }
    $(document).on('change', '#acesso', function() {   
        limparcamposAll();
        $('#divoperacional').hide();
        $('#divconsulta').hide();
        let acesso = $(this).val();
        switch(acesso) {
            case 'Consulta':
                $('#divconsulta').show("fast");
                $('#sele_cli').hide("fast");
                $('#sele_reg').hide("fast");
                $('#sele_geren').hide("fast");
                $("#sele_tipo").prop('required',true);
                
                break;
            case 'Operacional':
                $('#divoperacional').show("fast");
                $("#sele_operacional").prop('required',true);
                break;
            case 'Admin':
                $('#divconsulta').hide("fast");
                $('#divoperacional').hide("fast");
                break;

            default:
            $('#divconsulta').hide("fast");
            $('#divoperacional').hide("fast");
        }
    });
    $(document).on('change', '#sele_tipo', function() { 
 
        let acesso = $(this).val();
        console.log(acesso);
        limparcampos();
        switch(acesso) {
            case 'Cliente':
                $('#sele_cli').show();
                $('#sele_reg').hide();
                $('#sele_geren').hide();
                $("#clientes_id").prop('required',true);
                break;
            case 'Região':
                $('#sele_cli').hide();
                $('#sele_reg').show();
                $('#sele_geren').hide();
                $("#regiaos_id_cons").prop('required',true);
                break;
            case 'Gerenciadora':
                $('#sele_cli').hide();
                $('#sele_reg').hide();
                $('#sele_geren').show();
                $("#gerenciadoras_id").prop('required',true);
                break;            
        }


    });
    $(document).on('change', '#sele_operacional', function() {              
        let acesso = $(this).val();
        limparcampos();  
        switch(acesso) {
            case 'GestorADM':
                $('#opregiao').hide();
                $('#optipocont').hide();
                $('#oparea').hide();
                
                break;
            case 'CDHU':
                $('#opregiao').hide();
                $('#optipocont').hide();
                $('#oparea').show();
                $("#areas_id").prop('required',true);
                
                break;
            case 'Gestor':                
                $('#optipocont').hide();
                $('#oparea').hide();
                $('#opregiao').show();  
                $("#regiaos_id_oper").prop('required',true);              
                break;
            case 'Técnico':                
                $('#optipocont').hide();
                $('#oparea').hide();
                $('#opregiao').show();  
                $("#regiaos_id_oper").prop('required',true);              
                break;

            default:
                $('#opregiao').hide();
                $('#optipocont').hide();            
                $('#oparea').hide();            
        }
    });    
    $('.endbt').click(function(event ){
        event.preventDefault();   
        let id_cliente = $('#id_usuario').val();
        if(id_cliente ==''){
            setTimeout(function(){ 
                $('.nav-tabs a:first').tab('show');
                demo.showNotification('top','center','danger','Você precisa cadastrar o <b>Usuário</b> primeiro.')
            }, 500);
        }
        buscar_vinculo();
    });
    function buscar_vinculo(){
        $.get(appUrl+'/usuarios/vinculos/'+$('#id_usuario').val(), function(retorno){
            $('#tab_vinculos').html(retorno);
        });
    }
    $("#form_informacoes").submit(function(e) {           
        e.preventDefault();
        if(validarform()){     
            let form = $(this);
            let id_usuario = $('#id_usuario').val(); 
            $.ajax({
                type: "POST",
                url: appUrl+'/usuarios/cadastro',
                data: form.serialize(), 
                success: function(data)
                {
                    var result = data.split(',');
                    if(result[0] == 'erro'){
                        demo.showNotification('top','center', 'danger', result[1]);
                    }else{
                        if(id_usuario == ''){
                            demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                            $('#id_usuario').val(data);  
                            $('#id_usuario2').val(data); 
                            window.location.href = appUrl+'/usuarios';
                        }else{
                            demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                        }
                    }
                    
                }
            });
        }
    });
    function deletar_usuario(id){
        if(confirm('Deseja remover esse vinculo? ')){
            $.get(appUrl+'/usuarios/vinculos/delete/'+id, function(retorno){
                buscar_vinculo();
            });
        }
    }
    function limparcampos(){
        console.log('limpando campos select ')
        $('#regiaos_id_cons').val('');
        $('#clientes_id').val('');
        $('#areas_id').val('');
        $('#gerenciadoras_id').val('');
        $('#tipo_contratos_id').val('');
        
        

        // $("#regiaos_id_oper option:selected").each(function () {
        //     console.log('entrandndo ');
        //        $(this).removeAttr('selected'); 
        //        });

        // $('option:selected', this).removeAttr('selected');
        // $('#regiaos_id_oper option:not(:selected)').remove();

        $("#regiaos_id_oper option:selected").each(function() {
            console.log('oi');
            console.log($(this));
            $(this).remove();
            
        });
        $('.selectize-input div').remove();


        // $('#regiaos_id_oper').val('');


        $('#regiaos_id_cons').val('');
        $('#tipo_gestor').val('');

        $(".filter-option-inner-inner").text('Selecione');

        $("#regiaos_id_cons").prop('required',false);
        $("#sele_operacional").prop('required',false);
        $("#clientes_id").prop('required',false);
        $("#areas_id").prop('required',false);
        $("#gerenciadoras_id").prop('required',false);
        $("#tipo_contratos_id").prop('required',false);
        $("#regiaos_id_oper").prop('required',false);
        $("#regiaos_id_cons").prop('required',false); 
        $("#sele_tipo").prop('required',false);
    }
    function limparcamposAll(){
        $('#regiaos_id_cons').val('');
        $('#clientes_id').val('');
        $('#areas_id').val('');
        $('#gerenciadoras_id').val('');
        $('#tipo_contratos_id').val('');
        $('#regiaos_id_oper').val('');
        $('#regiaos_id_cons').val('');
        $('#tipo_consulta').val('');
        $('#tipo_gestor').val('');
        $('#sele_tipo').val('');
        $('#sele_operacional').val('');
        $("#regiaos_id_oper").trigger('reset');
        $("#regiaos_id_oper").val('');
        $(".filter-option-inner-inner").text('Selecione');

        $('#opregiao').hide();
        $('#sele_reg').hide();
        $('#optipocont').hide();
        $('#oparea').hide();
        $('#sele_geren').hide();
        $('#sele_cli').hide();
        $("#regiaos_id_cons").prop('required',false);
        $("#sele_operacional").prop('required',false);
        $("#clientes_id").prop('required',false);
        $("#areas_id").prop('required',false);
        $("#gerenciadoras_id").prop('required',false);
        $("#tipo_contratos_id").prop('required',false);
        $("#regiaos_id_oper").prop('required',false);
        $("#regiaos_id_cons").prop('required',false);
        $("#sele_tipo").prop('required',false);

        
    }
    function validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
    function validaCelular (celular) {
        celular1 = celular.replace('(', ''); celular2 = celular1.replace(')', ''); celular3 = celular2.replace(' ', ''); celular = celular3.replace('-', ''); 
        var regex = new RegExp('^((1[1-9])|([2-9][0-9]))((3[0-9]{3}[0-9]{4})|(9[0-9]{3}[0-9]{5}))$'); 
        return regex.test(celular);
    }
    function validarform(){   
        
        let validar = 'true';

        if($('#telefone').val().trim().length < 15) {
            demo.showNotification('top','center', 'danger', 'Telefone, invalido.');
            validar =  false;
        }
        if(!validateEmail($('#email').val())){
            demo.showNotification('top','center', 'danger', 'Email, invalido.');
            validar =  false;
        }
        if(!validaCelular($('#telefone').val())){
            demo.showNotification('top','center', 'danger', 'Celular, invalido.');
            validar =  false;
        }
        if($('#email').val().trim().length < 9) {
            demo.showNotification('top','center', 'danger', 'Email, invalido.');
            validar =  false;
        }
        if($('#password').val())
        {
            if($('#password').val().trim().length < 3) {
                demo.showNotification('top','center', 'danger', 'Senha, invalida.');
                validar =  false;
            }
        }       

        console.log('validarform->'+validar);

        return validar


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
</script>
@endpush