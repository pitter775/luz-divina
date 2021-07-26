@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'ois'
])

@section('content')
    <div class="content">

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
                                            <label>Selecione o Serviço</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" id="servico_tipos_id" name="servico_tipos_id" required disabled>
                                                    <option value="{{ $dados_geral->servico_tipos_id ?? '' }}">{{ $dados_geral->stnome  ?? 'Selecione'}}</option>
                                                    @foreach($servicos_tipos as $key => $value)
                                                        <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                        </div>  
                                        <div class="col-md-3">
                                            <label>Selecione o Local</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="locals_id" required>
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
                                                <input class="form-control datepicker" name="dt_ios"  placeholder="Select date" type="date" data-date-format="dd-mm-yyyy" value="{{$dados_geral->dt_ios ?? ''}}">
                                            </div>
                                        </div>                          
                                        <div class="col-md-3">
                                            <label>Prazo</label>
                                            <div class="form-group">
                                                
                                                <input class="form-control datepicker" name="prazo"  placeholder="Select date" type="date" data-date-format="dd-mm-yyyy" value="{{$dados_geral->prazo ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Valor</label>
                                            <div class="form-group">
                                                <input type="text" name="valor" id="valor" class="form-control" placeholder="R$" value="{{$dados_geral->valor ?? ''}}">
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
                                            <label class="control-label">Descrição</label>
                                            <textarea rows="8" name="descricao" placeholder="" class="form-control input-md" autocomplete="off">{{$dados_geral->descricao ?? ''}}</textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="footerint">
                                        <button type="submit" class="btn btn-outline-primary btn-round btn-sm" id='btfiltrar'><i class="fa fa-cloud-upload"></i> Salvar OIS</button>
                                        <a href="/ois" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
                                    </div> 
                                </form>
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
     if($('#id_ois').val() !== ''){
        $('#contratos_id').removeAttr('disabled');
        $('#servico_tipos_id').removeAttr('disabled');
     }

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }});

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
                    // console.log(data);
                    if(id_local == ''){
                        demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                        $('#id_ois').val(data);  
                    }else{
                        demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                    }
                    
                }
            });});

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
                console.log(data);
            })
        });

        $(document).on('change', '#contratos_id', function() {
            contratos_id = $('#contratos_id').val();

            console.log('contrato id->'+contratos_id);

            $.get(appUrl+'/ois/getservicos/'+contratos_id, function(data){
                console.log(data);
                $('#servico_tipos_id').removeAttr('disabled');
                $("#servico_tipos_id option").remove();
                for(i=0; i < data.length; i++){
                    option = '<option value="'+data[i].id+'">'+data[i].nome+'</option>';  
                    $('#servico_tipos_id').append(option);
                }
            })
        });

    </script>
@endpush