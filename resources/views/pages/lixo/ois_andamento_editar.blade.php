<style>
.modal {
    overflow-y:scroll !important;
    /* display: block; */    
}

</style>
<div class="col-md-12" style="margin-top: 20px; display:block">
<p class="card-category">EDITAR ANDAMENTO</p>
<form name="form_andamento_edit " id="form_andamento_edit">
    <input type="hidden" id="andamentos_id" name="andamentos_id" value="{{$dados_geral->id ?? ''}}">
    <div class="row">   
        <div class="col-md-6"> 
            <label>Serviço</label>
                <select class="table-group-action-input form-control" name="servico" required>
                    <option value="" disabled selected>Selecione</option>
                    @foreach($servicos as $key => $value)
                        @if($value->nome == $dados_geral->servico) 
                            <option value="{{ $value->nome }}" selected>{{ $value->nome }}</option> 
                        @else
                            <option value="{{ $value->nome }}">{{ $value->nome }}</option> 
                        @endif
                    @endforeach
                </select>
        </div>
        
        <div class="col-md-6">
            <label>Atividade</label>
            <div class="form-group">
                <input type="text" name="atividade" id="atividade" class="form-control" placeholder="Atividade" value="{{$dados_geral->atividade ?? ''}}">
            </div>
        </div> 
            
        <div class="col-md-4">
            <label>Data Inicio</label>
            <div class="form-group">
                <input type="text" name="dt_inicio"  class="form-control datepicker" value="<?php echo date('d/m/Y', strtotime($dados_geral->dt_inicio)); ?>">
            </div>
        </div>                          
        <div class="col-md-4">
            <label>Data Fim</label>
            <div class="form-group">                                                
                <input type="text" name="dt_fim"  class="form-control datepicker" value="<?php echo date('d/m/Y', strtotime($dados_geral->dt_fim)); ?>">
            </div>
        </div>
        <div class="col-md-3">
            <label>Valor</label>
            <div class="form-group">
                <input type="text" name="valor_andamento" id="valor_andamento" class="form-control" placeholder="R$" value="{{$dados_geral->valor_andamento ?? ''}}" >
            </div>
        </div>
        
        <div class="col-md-12">
            <label class="control-label">Resumo do Andamento</label>
            <textarea id="editor4" placeholder="" class="form-control input-md">{!! $dados_geral->resumo !!}</textarea>
            <!-- <textarea rows="8" name="resumo" placeholder="" class="form-control input-md"></textarea>  -->
        </div>
        <div class="col-md-12" style=" padding-bottom: 20px; margin-top: 30px">
            <button type="submit" class="btn btn-outline-primary btn-round btn-sm" ><i class="fa fa-cloud-upload"></i> Salvar Alterações</button>
            <button type="button" onclick="fechartela2()" class="btn btn-outline-info btn-round btn-sm"><i class="nc-icon nc-minimal-left"></i> Fechar</button>
        </div>
    </div>
</form>
</div>

<script>    
$(document).ready(function () {
    // $('.modal').css('overflow-y', 'auto');
    // $('#FirstModal').focus();
//     setTimeout(function(){ $('#myModal2').modal('show') }, 500);
// $('#myModal1').modal('hide');
    // console.log('add orverflow')
});



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
    
    $("#form_andamento_edit").submit(function(e) {   
        e.preventDefault(); 
        let form = $(this);
        const editorData2 = editor4.getData();
            var dados_serealize = [];
                dados_serealize =  form.serializeArray();
                dados_serealize.push({name: "resumo", value: editorData2});
        $.ajax({
            type: "POST",
            url: appUrl+'/ois/andamento/cadastro',
            data: dados_serealize, 
            success: function(data)
            {
                demo.showNotification('top','center', 'info', 'Atualizado com sucesso ');
                fechartela2();
                buscar_andamento();               
            }
        });
    });

    ClassicEditor
		.create( document.querySelector( '#editor4' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor4 => {
			window.editor4 = editor4;
		} )
		.catch( err => {
			console.error( err.stack );
		} );
</script>