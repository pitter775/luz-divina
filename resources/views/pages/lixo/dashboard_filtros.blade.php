<?php
    use Illuminate\Support\Facades\Auth;
    $display_cliente = 'block'; 
    $display_regiao = 'block'; 
    $display_gerenciadora = 'block'; 
    $display_oper_gest = 'block';
    
    if(Auth::user()->tipo_consulta == 'Cliente'){ $display_cliente = 'none'; }
    // if(Auth::user()->tipo_consulta == 'Região' || Auth::user()->tipo_gestor == 'Gestor' || Auth::user()->tipo_gestor == 'Técnico'){$display_regiao = 'none';}
    if(Auth::user()->tipo_consulta == 'Gerenciadora'){ $display_gerenciadora = 'none';}


?>
<style>
    .quadradinho{ width: 10px; height: 10px; border-radius: 3px; float: left; margin-top: 3px; margin-right: 10px; margin-left: -5px; box-shadow: 0 6px 10px -4px rgba(0, 0, 0, 0.15);}
    .quadradinho2{ width: 10px; height: 10px; border-radius: 3px;  float: left; margin-right: 10px;}
    .formcheck{ font-weight: 400; color: #000; margin-top: 5px; cursor: pointer;}
    .formcheck2{ font-weight: 400; color: #777; margin-top: 5px; cursor: pointer; }

    
</style>

<p class="tit" style="color: #0f5697" >Filtrar dados do Mapa</p>    
<?php
$cores = ['ec3349','ec33d4','ad33ec','00c6ff','483b10','55ebfe','b72959','f0afa8','575a8e','95b361',
'df7f7a','c3d278','adb2dc','7f3624','4ee524','e56f5d','86efaa','5d2221','bd2a16','5660b3',
'860cff','9ba6c5','ede1e0','cb89d9','455ad3','ebdafa','ffe0f1','721c53','8d9919','dbf000',
'014d92','629dd3','19c3d2','3d7479','7ff2b3','269457','31ee1e','ddee1e','e2bd27','e68733',
'91b9ba','e9d9d8','aaa5a4','f2dbd5','aa513c','6b667a','007ead','dde8f1','006896','006896',
'ec3349','ec33d4','ad33ec','00c6ff','483b10','55ebfe','b72959','f0afa8','575a8e','95b361',
'df7f7a','c3d278','adb2dc','7f3624','4ee524','e56f5d','86efaa','5d2221','bd2a16','5660b3',
'860cff','9ba6c5','ede1e0','cb89d9','455ad3','ebdafa','ffe0f1','721c53','8d9919','dbf000',
'014d92','629dd3','19c3d2','3d7479','7ff2b3','269457','31ee1e','ddee1e','e2bd27','e68733',
'91b9ba','e9d9d8','aaa5a4','f2dbd5','aa513c','6b667a','007ead','dde8f1','006896','006896',
'ec3349','ec33d4','ad33ec','00c6ff','483b10','55ebfe','b72959','f0afa8','575a8e','95b361',
'df7f7a','c3d278','adb2dc','7f3624','4ee524','e56f5d','86efaa','5d2221','bd2a16','5660b3',
'860cff','9ba6c5','ede1e0','cb89d9','455ad3','ebdafa','ffe0f1','721c53','8d9919','dbf000',
'014d92','629dd3','19c3d2','3d7479','7ff2b3','269457','31ee1e','ddee1e','e2bd27','e68733',
'91b9ba','e9d9d8','aaa5a4','f2dbd5','aa513c','6b667a','007ead','dde8f1','006896','006896'];
?> 



<!-- <p class="tit2" style="padding-bottom:0; margin-bottom:-5px">POR MUNICÍPIO</p> -->
<p class="tit2">POR MUNICÍPIO</p>
<!-- <select class="table-group-action-input form-control form-2" class="sele_filtro"  name="sele_municipio" > -->
<!-- <select class="selectpicker selefil" data-live-search="true"  title="Selecione"   data-style='btn-default' name="sele_municipio" > -->
<select id="select-municipio" class="demo-default" name="sele_municipio" >
    <option data-select="municipio" value="">Todos</option>
    @foreach($municipios as $key => $value)                           
        <option data-select="municipio" value="{{ $value->id }}">{{ $value->nome }}</option> 
    @endforeach
</select>


<div style="display:<?php echo $display_gerenciadora ?>;">
<p class="tit2" >POR GERENCIADORAS</p>
<!-- <select class="table-group-action-input form-control form-2" class="sele_filtro"  name="sele_gerenciadora"> -->
<!-- <select class="selectpicker selefil" data-live-search="true"  title="Todos"   data-style='btn-default' name="sele_gerenciadora" > -->
<select id="select-gerenciadora" class="demo-default" name="sele_gerenciadora" >
    <option data-select="gerenciadora"  value="">Todos</option>
    @foreach($gerenciadoras as $key => $value)                           
        <option data-select="gerenciadora" value="{{ $value->id }}">{{ $value->nome }}</option> 
    @endforeach
</select>    
</div>   



<div style="display:<?php echo $display_regiao ?>;">
<p class="tit2" >POR REGIÃO</p>
<!-- <select class="table-group-action-input form-control form-2" class="sele_filtro"  name="sele_regiao" required> -->
<!-- <select class="selectpicker selefil" data-live-search="true"  title="Todos"   data-style='btn-default' name="sele_regiao" > -->
<select id="select-regiao" class="demo-default" name="sele_regiao" >
    sele_gerenciadora
    <option data-select="regiao" value="">Todos</option>
    @foreach($regiaos as $key => $value)                           
        <option data-select="regiao" value="{{ $value->id }}">{{ $value->nome }}</option> 
    @endforeach
</select>
</div>


<!-- <p class="tit2">POR STATUS</p>
<div class="form-check-radio" style="float:left; width: 80px">
    <label class="form-check-label formcheck">
        <input class="form-check-input" type="radio" name="status_ois" value="Ativo" checked=""> Ativo
        <span class="form-check-sign"></span>
    </label>
</div>

<div class="form-check-radio" style="float:left">
    <label class="form-check-label formcheck2" >
        <input class="form-check-input" type="radio" name="status_ois"  value="Inativo" > Inativo
        <span class="form-check-sign"></span>
    </label>
</div>
<br style="clear: both;"> -->


<p class="tit2" >POR STATUS</p>
<!-- <p class="tit2" style="padding-bottom:0; margin-bottom:-5px; margin-top: 10px">POR STATUS</p> -->
<!-- <select class="table-group-action-input form-control form-2" class="sele_filtro"  name="sele_status" > -->
<!-- <select class="selectpicker selefil" data-live-search="true"  title="Selecione"   data-style='btn-default' name="sele_status" > -->
<select id="select-status" class="demo-default" name="sele_status" >
    <option data-select="status" value="">Todas</option>
    <option data-select="status" selected>Em Execução</option>
    <option data-select="status" >Não Iniciado</option>
    <option data-select="status" >Paralisado</option>
    <option data-select="status" >Concluído</option>

</select>  



<div style="display:<?php echo $display_cliente ?>;">
<p class="tit2">POR CLIENTES</p>
<input type="hidden" id="idclientes" name="idclientes" value="">
<div id="divclientes">
    @foreach($clientes as $key => $value)                           
        <div class="form-check">
            <label class="form-check-label" title="{{ $value->nome }}" data-toggle="tooltip" data-placement="left">
                <input class="form-check-input" name="chklista" value="{{ $value->id }}" type="checkbox">
                <span class="form-check-sign"></span><div class="quadradinho" style="background: #<?php echo $cores[$value->id] ?>"></div>
                {{ $value->nomeabrev }}
            </label>
        </div>
    @endforeach
</div>
</div>

<p class="tit2">POR TIPO DE CONTRATO</p>
<input type="hidden" id="idservico" name="idservico" value=""> 
<div id="divservicos">
    @foreach($tipo_contratos as $key => $value)  
        @if($value->tcnome)                         
        <div class="form-check">
            <label class="form-check-label" >
                <input class="form-check-input" name="sele_servico" value="{{ $value->tid }}" type="checkbox">
                <span class="form-check-sign"></span>
                {{ $value->tcnome }}
            </label>
        </div>
        @endif
    @endforeach
</div>




<script>   

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
}); 
var windowWidth = window.innerWidth;


if(windowWidth < 960){
    // console.log('menor');
    $('.selefil').addClass( 'table-group-action-input form-control form-2' );
    $('.selefil').removeClass( 'selectpicker' );   
}
// console.log(windowWidth);
    $(function() {
        $('#divclientes input').click(updateTextArea);
        $('#divservicos input').click(updateTextArea2);
        // $('.form-check-radio input').click(updateTextArea3);
        updateTextArea(false);
        updateTextArea2(true);
    });
    function updateTextArea(novo) {         
        var dados = [];
        $('#divclientes :checked').each(function() {
            dados.push($(this).val());     
        });
        $('#idclientes').val(dados);
        clientesid = $('#idclientes').val();
        if(novo){
            limparallMarkers();           
            novomarker(); 
        }
                 
    }
    function updateTextArea2(novo) {   
        var dados = [];
        $('#divservicos :checked').each(function() {
            dados.push($(this).val());     
        });
        $('#idservico').val(dados);
        servico = $('#idservico').val();
        tipo_contrato = servico;
        if(novo){
            limparallMarkers();
            novomarker();  
        }              
    }

    $('#select-gerenciadora').selectize({
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
    $('#select-regiao').selectize({
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
    $('#select-status').selectize({
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
    $('#select-municipio').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        persist: false,
        create: function(input) {
            return {
                value: input,
                text: input,
                data: input
            }
        }
    });

    

    
</script>