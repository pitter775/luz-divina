@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'servico_tipos'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@if(isset($dados_geral->id)) Editar @else Cadastrar @endif Serviço </h5>
                    </div>
                    <div class="card-body">

                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">INFORMAÇÕES DO SERVIÇO</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="my-tab-content" class="tab-content text-left"> 
                            <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">
                                <p class="card-category">CADASTRAR SERVIÇO</p>   
                                <form name="form_informacoes" id="form_informacoes">
                                    <input type="hidden" id="id_servico" name="id_servico" value="{{$dados_geral->id ?? ''}}">
                                    <div class="row">   
                                                              
                                        <div class="col-md-5">
                                            <label>Nome</label>
                                            <div class="form-group">
                                                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome do Serviço" value="{{$dados_geral->nome ?? ''}}"> 
                                            </div>
                                        </div>


                                    
                                    </div>
                                    
                                    <div class="footerint">
                                        <button type="submit" class="btn btn-outline-primary btn-round btn-sm" id='btfiltrar'><i class="fa fa-cloud-upload"></i> Salvar Serviço</button>
                                        <a href="/servico_tipos" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
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

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }});

    $("#form_informacoes").submit(function(e) {           
        e.preventDefault(); 
        let form = $(this);
        let id_local = $('#id_servico').val(); 
        $.ajax({
            type: "POST",
            url: appUrl+'/servico_tipos/cadastro',
            data: form.serialize(), 
            success: function(data)
            {
                var result = data.split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{
                    if(id_local == ''){
                        demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                        $('#id_servico').val(data);  
                        setTimeout(function () {
                            window.location.href = appUrl+"/servico_tipos";
                        }, 1000);
                    }else{
                        demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                    }
                }                    
            }
        });
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