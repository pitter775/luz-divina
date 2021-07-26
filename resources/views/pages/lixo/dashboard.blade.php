@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'home'
])
<style>
    #map { height: 800px;        width: 100%; padding: 0; margin: 0      }
    .cadflut{ padding: 10px;  margin: 0; position: absolute;  top: 100px; left: 0px;  z-index: 999;border-radius: 12px;color: #252422;    border: 0 none;}
    .textbtfil{ margin-left: 5px;}
    .titulocard{text-transform: uppercase; font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif; font-weight: 600; font-size: 10px; color: #000;
    -moz-osx-font-smoothing: grayscale; }

    .textocard{text-transform: uppercase; font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif; font-weight: 400; font-size: 10px; color: #555;
    -moz-osx-font-smoothing: grayscale; -webkit-font-smoothing: antialiased; margin-left: 10px;}
</style>

@section('content')
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 900px !important; height: 800px">
        <div class="modal-content" id="retorno_modal2"></div>
    </div>
</div>

    <div class="cadflut">
        <button class="btn btn-outline-primary btn-round" id="btfiltro" style="background-color: #fff;"><i class="nc-icon nc-zoom-split"></i> <span class="textbtfil">ABRIR FILTRO</span></button>
    </div>

    <div id="map" style="margin-top: 60px;"></div>

    
@endsection

@push('scripts')
<script>
    var infowindow = null;
    var map = null;
    var StartLatLng = null;
    var markers = [];
    let servico = ""; 
    let tipo_contrato = ""; 
    let regiao = "";
    let municipio = "";
    let gerenciadora = "";
    var clientesid = '';
    var status = 'Em Execução';
    var appUrl ="{{env('APP_URL')}}";
 
    
    function initMap() {
            StartLatLng = new google.maps.LatLng(-23.544899, -46.650728);
            var mapOptions = {
                center: StartLatLng,
                streetViewControl: false,
                panControl: false,
                maxZoom:17,
                zoom : 13,
                zoomControl:true,
                zoomControlOptions: {
                    style:google.maps.ZoomControlStyle.SMALL
                }
            };

        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        infowindow = new google.maps.InfoWindow({content: ''});
        // console.log('inicio do mapa');      
        carregar_filtros();     
    }
    function limparallMarkers(){
        $.each(markers, function(key, marker){
            marker.setMap(null);
        })
        markers = [];
    }
    function randomMat(min, max) {
        let valor = Math.random() * (max - min) + min;
        return Math.round(valor);
    }
    function novomarker(){
        // console.log('atualizando pontos');
        let filtros =  { 'servico' : servico, 'regiao': regiao, 'gerenciadora': gerenciadora, 'municipio': municipio, 'clientes':clientesid, 'status': status, 'tipo_contrato': tipo_contrato };

        // console.log(filtros);
        var contador = 0;
        $.get(appUrl+'/home/getpoints', filtros, function(dados){
            if(dados.length == 0){
                StartLatLng = new google.maps.LatLng(-23.544899, -46.650728);
                var mapOptions = {
                    center: StartLatLng,
                    streetViewControl: false,
                    panControl: false,
                    maxZoom:17,
                    zoom : 13,
                    zoomControl:true,
                    zoomControlOptions: {
                        style:google.maps.ZoomControlStyle.SMALL
                    }
            };
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            infowindow = new google.maps.InfoWindow({content: ''});
            }else{
                var bounds = new google.maps.LatLngBounds();
                var cores= ['ec3349','ec33d4','ad33ec','00c6ff','483b10','55ebfe','b72959','f0afa8','575a8e','95b361',
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
                $.each(dados, function(key, point){               
                    // if(contador > 50){
                    // contador = contador +1;
                    // console.log(contador);
                    console.log(key);

                    let position = new google.maps.LatLng(point.lat, point.lng);
                    StartLatLng = new google.maps.LatLng(-23.544899, -46.650728);          
                    var pinColor =  cores[point.clid];
                    var pinImage =  new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter_withshadow&chld="+point.id+"|"+ pinColor+"|000000",                
                                    new google.maps.Size(40, 37),
                                    new google.maps.Point(0,0),
                                    new google.maps.Point(10, 34));
                    var marker = new google.maps.Marker({
                        position: position,
                        bounds: true,                    
                        map: map,
                        icon: pinImage
                    });
                    google.maps.event.addListener(marker, 'click', function() { 
                        // console.log("address " +point.address);
                        infowindow.close();
                        let filtros_local =  { 'servico' : servico, 'regiao': regiao, 'gerenciadora': gerenciadora, 'municipio': municipio, 'clientes':clientesid,'idlocal':point.idlocal, 'status': status, 'tipo_contrato': tipo_contrato };                    
                        $.get(appUrl+'/home/getpoints/local/', filtros_local, function(dados2){                        
                            let contentString = '<div id="accordion" role="tablist" aria-multiselectable="true" class="card-collapse">';
                                contentString +='<img src="<?php echo asset('paper') ?>/img/pinsombra.png" style="float:left; margin-right: 10px"> <span class="titulocard">' 
                                // + point.nomeLocal +'<br/> '+ point.address + point.bairro + ' - '+ point.cidade 
                                + point.nomeLocal +'<br/> '+ point.address + point.bairro + ' - '+ point.cidade 
                                + '</span><br/><br/>';
                            let cont = 0;  

                           // console.log(dados2);

                            $.each(dados2, function(key, point2){
                                
                                cont = cont+1; 
                                let show = '';
                                let expanded = false;
                                let collapsed = 'collapsed';
                                if(cont ==1){show = 'show'; expanded = true; collapsed = '';}
                                contentString +=
                                '<div class="card card-plain">'+                                
                                    '<div class="card-header" role="tab" id="cardunico'+point2.id+'" style="border:none">'+
                                    ' <a  data-toggle="collapse" data-parent="#accordion" href="#collapse'+point2.id+'" aria-expanded="'+expanded+'" aria-controls="collapse'+point2.id+'" class="titulocard '+collapsed+'" style="border:none;">'+
                                        '' + point2.nomeTcontrato +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i style="text-shadow:initial" class="nc-icon nc-minimal-down"></i>'+
                                        '</a>'+
                                    '</div>'+
                                    '<div id="collapse'+point2.id+'" class="collapse '+show+'" role="tabpanel" aria-labelledby="cardunico'+point2.id+'" style="padding:0; border:none">'+
                                        '<div class="card-body" style="padding:0; padding-top: 10px; padding-bottom: 20px; border:none">'+
                                            '<span class="titulocard">Cliente</span><span class="textocard">' + point2.nomeCliente + '</span><br/>'+                                        
                                            '<span class="titulocard">Contrato:</span><span class="textocard">' + point2.nomeContrato + ' ' + point2.codigoContrato +'</span><br/>'+
                                            '<buttom type="buttom" class="btn btn-primary btn-sm" target="_blank" data-toggle="modal" data-target="#myModal2" onclick="ver_ois('+point2.id+')" ><i class="nc-icon nc-zoom-split" ></i> Ver Detalhes</buttom>'+ 
                                        '</div>'+
                                    '</div>'+
                                '</div>'
                            });
                            contentString +='</div>';
                            infowindow.setContent(contentString);
                            infowindow.open(map,marker);
                        });
                    });
                    markers.push(marker);
                    bounds.extend(position);
                   // }
                })
                map.fitBounds(bounds);
        
            }
            
        });
    }
    $(document).on('change', 'select', function() {    
        $( "select option:selected" ).each(function() {   
            datasele = $(this).parent().attr('id');
            valsele = '';
            if(datasele == 'select-municipio'){
                municipio = $(this).val();
            }
            if(datasele == 'select-gerenciadora'){
                gerenciadora = $(this).val();
            }
            if(datasele == 'select-status'){
                status = $(this).val();
            }
            if(datasele == 'select-regiao'){
                regiao = $(this).val();
            }

        });
        limparallMarkers();
        novomarker();
    });    
    $(document).on('click', '#btfiltro', function() {        
        $('.divfiltro').toggleClass('divfiltro2');
        $('.textbtfil').text($('.textbtfil').text() == 'ABRIR FILTRO' ? 'FECHAR FILTRO' : 'ABRIR FILTRO');
    });
    function carregar_filtros(){
        $.get(appUrl+'/home/carregar_filtros', function(dados){
            $('.divfiltro').html(dados);
            // console.log('filtros carregados');
        });
    }
    function fechartela(){
        $('#myModal2').modal('toggle');
        buscar_andamento();  
        setTimeout(function() {$('#retorno_modal2').html('');}, 1000);     
    }
    function ver_ois(id){
        $.get(appUrl+'/home/ver_ois/'+id, function(dados){
            $('#retorno_modal2').html(dados);
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACWYOPbH3gkP_bZXxryNXSPXK6zqYZuDg&callback=initMap&libraries=&v=weekly" defer></script>

@endpush