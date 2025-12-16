<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$( "#limpar" ).click(function() {
		$("#limpar_filtro").submit();
	});
	
	
			 
$( "#estado" ).change(function() {
		var estado = $('#estado').val();	
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/listarCidade?estado=" + estado,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						$('#municipio').html(data);
					}						
				}
			 }); 		

					
			
	});
	
$( "#municipio" ).change(function() {

		var municipio = $('#municipio').val();	
		
		$.ajax({

				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/listarLojas?cidade=" + municipio,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	

					if (data == undefined ) {
						console.log('Undefined');
					} else {

						$('#imovel').html(data);
					}
						
				}
			 }); 	

	});
		
	
	
	
	$( "#limpar" ).click(function() {
		location.reload();
	});
	
	$( "#export" ).click(function() {
		var id_loja = $('#imovel').val();	
		
		var municipio = $('#municipio').val();	
		var estado = $('#estado').val();	
		/*
		alert(id_loja);
		alert(municipio);
		alert(estado);
		*/
		if((id_loja == '0') && (municipio == '0') && (estado == '0'))  {

			$("#id").val(id_loja);
			$("#tipo").val(0);
			$("#export_form").submit();
		}else{		
			if(id_loja != '0'){
				$("#id").val(id_loja);
				$("#tipo").val(1);
				$("#export_form").submit();
			}else{
				if(municipio == '0'){	
					$("#id").val(estado);
					$("#tipo").val(2);
					$( "#export_form" ).submit();
				}else{
					$("#id").val(municipio);
					$("#tipo").val(3);
					$( "#export_form" ).submit();
				}
			}
		}
	});
	
});		
</script>
         <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Acompanhamento de CND <small>	<?php echo utf8_encode($mensagemAcomp);?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/listar"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Acompanhamentos</li>
									
									
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-card ">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> 
									<a href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Novo Acompanhamento</a> 
									&nbsp;				  									
									<a id='export' href="#"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	&nbsp;
									</h4>
									<br>
									<?php
									
									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
									echo form_open('acomp_cnd/listar', $attributes); 
									?>
									<select name="estadoListar" id="estado" class='procuraImovel'>				 
										<option value="0" selected>Escolha um estado</option>						
										<?php foreach($estados as $key => $estado){ ?>
										  <option value="<?php echo $estado->estado ?>"><?php echo $estado->estado?></option>	
										<?php
										}								  
									   ?>		 
									</select>	
									 &nbsp;	
									<select name="municipioListar" id="municipio" class='procuraImovel'>				  
										<option value="0" selected>Escolha uma Cidade</option>	 
									</select>
									&nbsp;										

									<select name="idImovelListar" id="imovel" class='procuraImovel'>				 
									<option value="0" selected>Todos</option>					 									
									</select>
									
									&nbsp;
								  
								   					   
								 <button class="btn btn-primary" type="submit">Filtrar</button>
								 </form>
									&nbsp;
									
										<form  id='export_form' action='<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/export' method='post'>
										<input type='hidden' id='id' name='id'>							
										<input type='hidden' id='tipo' name='tipo'>
										</form>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                 <div class="panel-body">
                                    <table id="basic-datatables" class="table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
												  <th > Nome</th>
												  <th > Cidade</th>
												  <th > CND Mob.</th>
												  <th >&Aacute;rea / Sigla / Sub&Aacute;rea</th>
												  <th >A&ccedil;&otilde;es</th>								  
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
													<th > Nome</th>
												  <th > Cidade</th>
												  <th > CND Mob.</th>
												  <th >&Aacute;rea / Sigla / Sub&Aacute;rea</th>
												  <th >A&ccedil;&otilde;es</th>								  
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($emitentes) ? '1' : '0';			
										if($isArray == 0){ ?>
										<?php 	
										}else{			
											 foreach($emitentes as $key => $emitente){ 	
										 ?>
												 <tr>
												  <td ><?php echo $emitente->nome_fantasia; ?></td>
												  <td ><?php echo $emitente->cidade; ?></td>
												  <td ><?php echo $emitente->ins_cnd_mob; ?></td>
												  <td ><?php echo  $emitente->nome_area.'-'.$emitente->sigla_sub_area.'-'.$emitente->nome_etapa; ?>  </td>
												  
												  
												  <td width="15%">
												  <?php if($visitante == 0){ ?>
													<a href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/ativar?id=<?php echo $emitente->id_acomp; ?>" class="btn btn-success btn-xs" title='Ativar'><i class="fa fa-check"></i></a>												
													<a href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/excluir?id=<?php echo $emitente->id_acomp; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>												  

												  <?php } ?>
												    <a href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/editar?id=<?php echo $emitente->id_acomp; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>
													
													</td>							  										
												</tr>

											  <?php
											}//fim foreach
										  }//fim if
										  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- End .panel -->  
                        </div><!--end .col-->
                    </div><!--end .row-->

									

                </div> 
            </div>

