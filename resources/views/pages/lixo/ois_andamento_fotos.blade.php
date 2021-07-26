<style>
    .imgtb2{ height: 100px;}
    .imgtbdiv{ float: left; padding: 5px; text-align: center; margin: 10px; border-radius: 4px; box-shadow: 0 2px 5px #FFFFFF inset, 
                0 2px 5px rgba(0, 0, 0, 0.4); cursor: pointer;}
</style>
<div class="col-md-12">
    <p class="card-category" style="margin-top: 20px;">NOVA FOTO</p>
    <form name="form_anexo_foto" id="form_anexo_foto" enctype="multipart/form-data">
        <input type="hidden" id="andamentos_id" name="andamentos_id" value="{{$andamentos_id ?? ''}}">                                    
        <div class="row">   
            <div class="col-md-12" style="padding-top: 18px">
                <input type="file" name="arquivo" required>
            </div>
            
            <div class="col-md-12" >
                <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Enviar Foto</button>
            </div>                                        
        </div>                                     
    </form>
    
    <div class="col-md-12" style="display: table; border-top: solid 1px #eee; padding-top:20px; margin-bottom: 20px">
        @foreach($fotos as $key => $value4)
            <div class="imgtbdiv zoom2">
                <img class="imgtb2" src="/storage/{{ $value4->arquivo }}" alt="..."><br>
                <a href="#" class="btn btn-danger btn-link" onclick="return deletar_anexo('{{ $value4->id }}')"><i class="nc-icon nc-simple-remove"></i></a>   
            </div>
        @endforeach      
        
    </div>

    <div class="footerint" style="text-align: center !important; margin-bottom: 20px">
    <button type="button" onclick="fechartela5()" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Fechar</button>
    </div>
</div>   

<script>
    var appUrl ="{{env('APP_URL')}}";

    $("#form_anexo_foto").submit(function(e) {   
        $('#aguarde, #blanket').css('display','block');
        e.preventDefault(); 
        let form = $(this);
        var data = new FormData($("form[name='form_anexo_foto']")[0]);
        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            url: appUrl+'/anexos',
            data: data, 
            success: function(retorno)
            {    
                demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                ver_fotos($('#andamentos_id').val());
                form.trigger("reset");
               // setTimeout(function() {
                    $('#aguarde').hide('slow');
                    $('#blanket').hide();
                //}, 5000);   
                //buscar_andamento();            
            }
        });
    });

    function deletar_anexo(id){
        console.log(id);
        if(confirm('Deseja remover esse anexo? ')){
            $.get(appUrl+'/anexos/delete/'+id, function(retorno){
                ver_fotos($('#andamentos_id').val());
                //buscar_andamento();
            });
        }
    }

    function fechartela5(){
        $('#myModal3').modal('toggle');        
        buscar_andamento();  
       // setTimeout(function() {$('#retorno_modal3').html('');}, 1000);     
              
    }

        

    </script>
