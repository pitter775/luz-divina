<style>
.borderanexo{border-top: solid 1px #eee; margin-top: 20px} 
.timeline-body label.resumo{ color: #777; text-transform: none; font-weight: 400; font-size: 13px !important;}
.ultd{ position: absolute; bottom: 0; right: 10px;}
/* .resumo{ } */
h6 { font-size: 12px; font-weight: 600 !important; font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif !important; color: #06b7f5 !important; }



</style>


<div class="col-md-12 borderanexo" >
    <p class="card-category" style="margin-top: 20px;">TIMELINE DOS REGISTROS</p> 
</div>  



<div class="card card-timeline card-plain">
    <div class="card-body" style="margin-right: 20px;">
        <ul class="timeline timeline-simple">
            @foreach($andamentos as $key => $value3)
                <li class="timeline-inverted" id="{{ $value3->id }}">
                    <div class="timeline-badge">
                        <b><?php echo date('d-m-Y', strtotime($value3->dt_inicio)); ?></b>
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-body" style="color:#777; ">
                            <label>{{ $value3->servico }}</label> <br> 
                            <label>{{ $value3->atividade }}</label> <br>
                            @if(auth()->user()->acesso !== 'Consulta')
                                @if($value3->valor_andamento != '') 
                                    <label style="color: #c45757;">R$ {{ $value3->valor_andamento }}</label> <br> 
                                @endif
                            @endif

                            <label class="resumo">{!! $value3->resumo !!} </label> <br>                             
                            
                            <div id="carouselExampleCaptions{{ $value3->id }}" class="carousel slide" data-ride="carousell">
                                <!-- <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleCaptions" data-slide-to="1" class=""></li>
                                    <li data-target="#carouselExampleCaptions" data-slide-to="2" class=""></li>
                                </ol> -->
                                <div class="carousel-inner" id="fotos{{ $value3->id }}" > </div>


                                <a class="carousel-control-prev" href="#carouselExampleCaptions{{ $value3->id }}" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleCaptions{{ $value3->id }}" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Próximo</span>
                                </a>
                            </div>


                            <a href="" class="btn btn-primary btn-link bttab" data-toggle="modal" data-target="#myModal3" onclick="ver_fotos('{{ $value3->id }}')"><i class="nc-icon nc-simple-add"></i> Adicionar foto</a>

                            <!-- <div id="fotos{{ $value3->id }}" style="width: 1400px">
                                <a href="" class="btn btn-primary btn-link bttab" data-toggle="modal" data-target="#myModal3" onclick="ver_fotos('{{ $value3->id }}')"><i class="nc-icon nc-simple-add"></i></a>
                            </div>              -->
                        </div>
                        <div  class="ultd"  >
                            <button type="button" class="btn btn-primary btn-link" data-toggle="modal" data-target="#myModal3" onclick="editar_andamento('{{ $value3->id }}')"><i class="nc-icon nc-tag-content"></i></button>
                            <a href="#" class="btn btn-danger btn-link" onclick="return deletar_andamento('{{ $value3->id }}')"><i class="nc-icon nc-simple-remove"></i></a>   
                        </div>
                        <h6>
                            <i class="ti-time"></i> {{ $value3->name }}
                        </h6>
                    </div>
                </li>
            @endforeach  
        </ul>
    </div>
</div>



<script>
    

    function deletar_anexo(id){
        if(confirm('Deseja remover esse anexo? ')){
            $.get(appUrl+'/anexos/delete/'+id, function(retorno){
                buscar_anexo();
            });
        }
    }
    function deletar_andamento(id){
        if(confirm('Deseja remover esse andamento? ')){
            $.get(appUrl+'/ois/andamento/delete/'+id, function(retorno){
                var result = retorno.split(',');
                    if(result[0] == 'Erro'){
                        demo.showNotification('top','center', 'danger', result[1]);
                    }else{
                        demo.showNotification('top','center', 'info', result[0]);
                    }
                buscar_andamento();
            });
        }
    }
    function ver_fotos($id){
        $('#retorno_modal3').html('');
        $.get(appUrl+'/ois/ver_fotos/'+$id, function(retorno){
            $('#retorno_modal3').html(retorno);
        });
    }
    buscar_fotos();

    // function buscar_fotos() {
    //     var i = 0;
    //     $('#tb_fotos > tbody  > tr').each(function() {
    //         i = i+1;
    //         let id = $(this).attr('id');                
    //         $.get(appUrl+'/ois/ver_fotos_tb/'+id, function(retorno){
    //             obj = '#fotos'+id+':last';
    //             $(obj).append(retorno);
    //         });
    //     });
    // }

    function buscar_fotos() {
        var i = 0;
        $('ul.timeline-simple > li').each(function() {
            i = i+1;
            let id = $(this).attr('id');                
            $.get(appUrl+'/ois/ver_fotos_tb/'+id, function(retorno){
                obj = '#fotos'+id+':last';
                $(obj).append(retorno);
            });
        });
    }

    function fechartela2(){
        $('#myModal3').modal('toggle');
        setTimeout(function() {$('#retorno_modal3').html('');}, 500);
    }
    function editar_andamento($id){
        $('#retorno_modal3').html('');
        $.get(appUrl+'/ois/andamento/edit/'+$id, function(retorno){
            $('#retorno_modal3').html(retorno);
        });
    } 


</script>