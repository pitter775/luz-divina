@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'locals'
])

@section('content')
<style>
.exemplod{ color: #777; font-size: 11px; display: none;}
</style>
    <div class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@if(isset($dados_geral->id)) Editar @else Cadastrar @endif  Local</h5>
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
                                <p class="card-category">CADASTRAR LOCAL</p>   
                                <form name="form_informacoes" id="form_informacoes">
                                    <input type="hidden" id="id_local" name="id_local" value="{{$dados_geral->id ?? ''}}">
                                    <div class="row">   
                                        <div class="col-md-4">
                                            <label>Nome</label>
                                            <div class="form-group">
                                                <input type="text" name="nm_local" id="nm_local" class="form-control" placeholder="Nome do Local" value="{{$dados_geral->nm_local ?? ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Contato</label>
                                            <div class="form-group">
                                                <input type="text" name="contato" id="contato" class="form-control" placeholder="Contato do Local" value="{{$dados_geral->contato ?? ''}}">
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <label>Telefone</label>
                                            <div class="form-group">
                                                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone do Local" value="{{$dados_geral->telefone ?? ''}}">
                                            </div>
                                        </div>                                 
                                        <div class="col-md-10">
                                            <label>Endereço</label>
                                            <div class="form-group">
                                                <input type="text" name="logradouro" id="logradouro" class="form-control" placeholder="Endereço" value="{{$dados_geral->logradouro ?? ''}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Número</label>
                                            <div class="form-group">
                                                <input type="text" name="numero" id="numero" class="form-control" placeholder="Número" value="{{$dados_geral->numero ?? ''}}">
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-3">
                                            <label>CEP</label>
                                            <div class="form-group">
                                                <input type="text" name="cep" id="cep" class="form-control" placeholder="CEP" value="{{$dados_geral->cep ?? ''}}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3">
                                            <label>Complemento</label>
                                            <div class="form-group">
                                                <input type="text" name="complemento" class="form-control" placeholder="Complemento" value="{{$dados_geral->complemento ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Bairro</label>
                                            <div class="form-group">
                                                <input type="text" name="bairro" id="bairro" class="form-control" placeholder="Bairro" value="{{$dados_geral->bairro ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                             <label>Cidade</label>
                                            <div class="form-group">
                                                <select class="table-group-action-input form-control" name="municipios_id" id="municipios_id" required>
                                                    @if(!isset($dados_geral)) <option value="">Selecione</option> @endif
                                                    @foreach($municipios as $key => $value)
                                                        @if(isset($dados_geral))
                                                            @if($value->id == $dados_geral->municipios_id) <option value="{{ $dados_geral->municipios_id }}" selected>{{ $dados_geral->nome }}</option> @else
                                                                <option value="{{ $value->id }}">{{ $value->nome }}</option>
                                                            @endif                                                         
                                                        @else
                                                            <option value="{{ $value->id }}">{{ $value->nome }}</option> 
                                                        @endif 

                                                    @endforeach
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="col-md-8" style="border-top: solid 1px #eee; margin-top: 20px ">
                                            <div class="card card-timeline card-plain" >
                                                <div class="card-body">
                                                <p class="card-category">geolocalização</p>   
                                                <div class="row" >
                                                    <div class="col-md-6">
                                                        <label>Latitude</label>
                                                        <div class="form-group">
                                                            <input type="text" name="latitude"  id="latitude" class="form-control" placeholder="Latitude" value="{{$dados_geral->latitude ?? ''}}" required>
                                                            <div class="exemplod">Exemplo latitude da cidade: <span id="laticid" style="font-weight: bold;">-25.555</span></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Longitude</label> 
                                                        <div class="form-group">
                                                            <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude" value="{{$dados_geral->longitude ?? ''}}" required>
                                                            <div class="exemplod">Exemplo longitude da cidade: <span id="longcid" style="font-weight: bold;">-25.555</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footerint">
                                        <button type="submit" class="btn btn-outline-primary btn-round btn-sm" id='btfiltrar'><i class="fa fa-cloud-upload"></i> Salvar Local</button>
                                        <a href="/locals" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Voltar</a>
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
        $("#telefone").mask("(99) 99999-9999");
        $("#cep").mask("99999-999");
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            }});

        $("#form_informacoes").submit(function(e) {           
            e.preventDefault(); 
            let form = $(this);
            let id_local = $('#id_local').val(); 
            if(validarform()){     
                $.ajax({
                    type: "POST",
                    url: appUrl+'/locals/cadastro',
                    data: form.serialize(), 
                    success: function(data)
                    {
                        console.log(data);
                        if(id_local == ''){
                            demo.showNotification('top','center', 'success', 'Cadastro concluido com sucesso ');
                            $('#id_local').val(data);  
                        }else{
                            demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                        }                        
                    }
                });
            }
        });
        function validarform(){
            let validar = 'true';
            console.log($('#latitude').val().substr(0, 1));
            if($('#latitude').val().substr(0, 1) != '-'){
                demo.showNotification('top','center', 'danger', 'Latitude, invalido, o valor começa negativo');
                validar =  false;
            }
            if($('#longitude').val().substr(0, 1) != '-'){
                demo.showNotification('top','center', 'danger', 'Longitude, invalido, o valor começa negativo');
                validar =  false;
            }
            
            if($('#telefone').val() != '')
            {
                if($('#telefone').val().trim().length < 14) {
                    demo.showNotification('top','center', 'danger', 'Telefone, invalido.');
                    validar =  false;
                }
            }
            

            if($('#cep').val().trim().length < 9) {
                demo.showNotification('top','center', 'danger', 'CEP, invalido.');
                validar =  false;
            }

            if($('#cep').val().trim().length < 9) {
                demo.showNotification('top','center', 'danger', 'CEP, invalido.');
                validar =  false;
            }

           if(!isLatitude($('#latitude').val())) {
                demo.showNotification('top','center', 'danger', 'Latitude, invalido.');
                validar =  false;
            }

            if(!isLongitude($('#longitude').val())) {
                demo.showNotification('top','center', 'danger', 'Longitude, invalido.');
                validar =  false;
            } 

            return validar;    

        }
        function isLatitude(lat) {return isFinite(lat) && Math.abs(lat) <= 90;}
        function isLongitude(lng) {return isFinite(lng) && Math.abs(lng) <= 180;}

        $(document).on('change', '#municipios_id', function() {
            municipios_id = $('#municipios_id').val();           
            $.get(appUrl+'/locals/geo/'+municipios_id, function(data){      
 
                if(data.length > 0){
                    $('.exemplod').show();
                    $('#longcid').html(data[0].longitude);  
                    $('#laticid').html(data[0].latitude); 
                }else{
                    $('.exemplod').hide();
                }
                 
                
            })
        });
    </script>
@endpush