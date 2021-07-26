
<div class="col-md-12" style="margin-top: 20px; display:block">
<p class="card-category">EDITAR ADITIVO</p>
<form name="form_aditivo_edit" id="form_aditivo_edit">
    <input type="hidden" id="aditivos_id" name="aditivos_id" value="{{$dados_geral->id ?? ''}}">
    <div class="row"> 
        <div class="col-md-4">
            <label>Nr Termo</label>
            <div class="form-group">
                <input type="text" id="nr_termo" name="nr_termo" class="form-control" placeholder="Nr Termo" value="{{$dados_geral->nr_termo ?? ''}}" required>
            </div>
        </div>
        <div class="col-md-4">
            <label>Data Vigência</label>
            <div class="form-group">
                <!-- <input class="form-control datepicker" name="dt_vigencia"  placeholder="Select date" type="date" data-date-format="dd-mm-yyyy" value=""> -->
                <!-- <input type="text" name="dt_vigencia"  class="form-control datepicker" value="">    -->
                <input type="text"  name="dt_vigencia"  class="form-control datepicker" value="@if(isset($dados_geral))<?php echo date('d/m/Y', strtotime($dados_geral->dt_vigencia)); ?>@endif" required>   
            </div>
        </div>
        <div class="col-md-4">
            <label>Valor Atual</label>
            <div class="form-group">
                <input type="text" id="vlr_atual" name="vlr_atual" class="form-control" placeholder="Valor Atual" value="{{$dados_geral->vlr_atual ?? ''}}" required>
            </div>
        </div>
        <div class="col-md-12">
            <label>Objeto do Aditivo</label>
            <div class="form-group">
                <!-- <input type="text" name="objeto" class="form-control" placeholder="Objeto do Aditivo:" value="{{$dados_geral->objeto ?? ''}}"> -->
                <textarea id="editor77" placeholder="" class="form-control input-md">{!!$dados_geral->objeto ?? ''!!}</textarea>
            </div>
        </div>
        
    </div>
    <div class="footerint" style="margin-bottom: 20px;">
        <button type="submit" class="btn btn-outline-primary btn-round btn-sm"><i class="fa fa-cloud-upload"></i> Salvar Edição</button>
        <a href="#" class="btn btn-outline-info btn-round btn-sm" onclick="fechartela()"><i class="nc-icon nc-minimal-left"></i> Fechar</a>
    </div>                                                
</form> 

</div>

<script>

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

    $("#form_aditivo_edit").submit(function(e) {   
        e.preventDefault(); 
        let form = $(this);
        id_contrato = $('#id_contrato').val();
        console.log(id_contrato);
        const editorData = editor77.getData();
            var dados_serealize = [];
                dados_serealize =  form.serializeArray();
                dados_serealize.push({name: "objeto",  value: editorData});
                dados_serealize.push({name: "id_contrato",  value: id_contrato});
                console.log(dados_serealize);
        $.ajax({
            type: "POST",
            url: appUrl+'/contratos/aditivos',
            data: dados_serealize, 
            success: function(data)
            {
                var result = data.split(',');
                if(result[0] == 'erro'){
                    demo.showNotification('top','center', 'danger', result[1]);
                }else{
                    demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                    buscar_aditivo();  
                    fechartela();
                }              
            }
        });
    });
    function fechartela(){        
        $('#myModal3').modal('toggle');        
        setTimeout(function() {$('#retorno_modal3').html('');}, 1000);     
    }
    ClassicEditor.create( document.querySelector( '#editor77' ), {}).then( editor77 => {
        window.editor77 = editor77; }).catch( err => {console.error( err.stack );
    });  
</script>


    