@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'areas'
])

@section('content')
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@if(isset($dados_geral->id)) Editar @else Cadastrar @endif  Área</h5>
                    </div>
                    <div class="card-body">

                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <ul id="tabs" class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-expanded="true">INFORMAÇÕES</a></li>
                                </ul>
                            </div>
                        </div>
                        <div id="my-tab-content" class="tab-content text-left">
                            <div class="tab-pane active" id="home" role="tabpanel" aria-expanded="true">
                                <p class="card-category">CADASTRAR ÁREA</p>   
                                <form name="form_informacoes" id="form_informacoes">
                                    <input type="hidden" id="id_area" name="id_area" value="{{$dados_geral->id ?? ''}}">
                                    <div class="row">   
                                        <div class="col-md-6">
                                            <label>Nome</label>
                                            <div class="form-group">
                                                <input type="text" name="nome" id="nome" class="form-control" placeholder="Nome da Área" value="{{$dados_geral->nome ?? ''}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footerint">
                                        <button type="submit" class="btn btn-outline-primary btn-round btn-sm" id='btfiltrar'><i class="fa fa-cloud-upload"></i> Salvar Área</button>
                                        <a href="/areas" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
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
    $("#telefone").mask("(99) 9999-9999");
    $("#cep").mask("99999-999");
    

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            }});

        $("#form_informacoes").submit(function(e) {           
            e.preventDefault(); 
            let form = $(this);
            let id_area = $('#id_area').val(); 
            if(validarform()){  
                $.ajax({
                    type: "POST",
                    url: appUrl+'/areas/cadastro',
                    data: form.serialize(), 
                    success: function(data)
                    {
                        var result = data.split(',');
                        if(result[0] == 'erro'){
                            demo.showNotification('top','center', 'danger', result[1]);
                        }else{
                            if(id_area == ''){
                                demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso');
                                setTimeout(function () {window.location.href = appUrl+"/areas";}, 1000);
                            }else{
                                demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                            }
                        } 
                        
                    }
                });
            }
        });

        function validarform(){
        let validar = 'true';
        if($('#nome').val().trim().length < 2) {
            demo.showNotification('top','center', 'danger', 'Área, invalida.');
            validar =  false;
        }
        return validar;
    }

    </script>
@endpush