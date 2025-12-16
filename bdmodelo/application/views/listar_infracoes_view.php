<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>		
<script type="text/javascript">
$(document).ready(function(){
	
	$( "#limpar" ).click(function() {
		$("#limpar_filtro").submit();
	});
	
	var cidadeBD = $('#cidadeBD').val();
	var estadoBD = $('#estadoBD').val();
	var idLojaBD = $('#idLojaBD').val();
	
	//alert(tipo);
	if(estadoBD !== '0'){
		$('#estado').val(estadoBD);
	}
	
	if(cidadeBD !== '0'){
		$('#municipio').val(cidadeBD);
	}
	
	if(idLojaBD !== '0'){
		$('#imovel').val(idLojaBD);
				$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes/buscaInfraById?id=" + idLojaBD,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						$('#lista').html(data);
						$('#paginacao').hide();
					}
				}
			 });
	}
	
	
$( "#estado" ).change(function() {
		var estado = $('#estado').val();	

		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes/buscaCidadeByEstado?estado=" + estado,
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
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes/buscaInfraByEstado?estado=" + estado,
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



		$.ajax({

				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes/buscaInfracaoByEstado?id=" + estado,

				type : 'GET', /* Tipo da requisição */ 

				contentType: "application/json; charset=utf-8",

	        	dataType: 'json', /* Tipo de transmissão */

				success: function(data){	



					if (data == undefined ) {

						console.log('Undefined');

					} else {



						$('#lista').html(data);

						$('#paginacao').hide();



					}

						

				}

			 }); 						 

				

			

	});

	

$( "#municipio" ).change(function() {



		var municipio = $('#municipio').val();	

		

		$.ajax({

				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes/buscaInfracaoByMunicipio?municipio=" + municipio,

				type : 'GET', /* Tipo da requisição */ 

				contentType: "application/json; charset=utf-8",

	        	dataType: 'json', /* Tipo de transmissão */

				success: function(data){	



					if (data == undefined ) {

						console.log('Undefined');

					} else {



						$('#lista').html(data);
						$('#paginacao').hide();

					}

						

				}

			 }); 



	$.ajax({



				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes/buscaInfraByCidade?municipio=" + municipio,

				type : 'GET', /* Tipo da requisição */ 

				contentType: "application/json; charset=utf-8",

	        	dataType: 'json', /* Tipo de transmissão */

				success: function(data){	



					if (data == undefined ) {

						console.log('Undefined');

					} else {



						$('#imovel').html(data);

						$('#paginacao').hide();


					}

						

				}

			 }); 						 

				

				 

				

			

	});

		

	$( "#imovel" ).change(function() {
		var id = $('#imovel').val();	
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes/buscaInfraById?id=" + id,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						$('#lista').html(data);
						$('#paginacao').hide();
					}
				}
			 }); 			
	});
	

	$( "#export" ).click(function() {

		var id_loja = $('#imovel').val();	

		var municipio = $('#municipio').val();	

		var estado = $('#estado').val();	

		if((id_loja == '0') && (municipio == '0') && (estado == '0'))  {



			$("#id_imovel_export").val(id_loja);

			$("#export_imovel").submit();

		}else{		

			if(id_loja != '0'){

				$("#id_imovel_export").val(id_loja);

				$("#export_imovel").submit();

			}else{

				if(municipio == '0'){	

					$("#id_estado_export").val(estado);

					$( "#export_estado" ).submit();

				}else{

					$("#id_mun_export").val(municipio);

					$( "#export_mun" ).submit();

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
                                <h1>Infra&ccedil;&otilde;es <small>	<?php echo utf8_encode($mensagemInfra);?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/infracoes/listar"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Infra&ccedil;&otilde;es</li>
									
									
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
									<a href="<?php echo $this->config->base_url();?>index.php/infracoes/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Nova Infra&ccedil;&atilde;o</a> 
									&nbsp;				  									
									<a id='export' href="#"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	&nbsp;
									</h4>
									<br>
									<?php
									
									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
									echo form_open('infracoes/listar', $attributes); 
									?>
									<select name="estadoListar" id="estado" class='procuraImovel'>				 
										<option value="0">Escolha um estado</option>	
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
									
								<form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/infracoes/export' method='post'>							
								  <input type='hidden' id='id_imovel_export' name='id_imovel_export'>	
								 </form>												
								 <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/infracoes/export_mun' method='post'>	
								  <input type='hidden' id='id_mun_export' name='id_mun_export'>
								 </form>												
								 <form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/infracoes/export_est' method='post'>
									  <input type='hidden' id='id_estado_export' name='id_estado_export'>	
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
											  <th > Loja</th>
							  				  <th > CPF/CNPJ </th>
											  <th > Infra&ccedil;&atilde;o</th>
											  <th > Tipo Auto</th>
							  				  <th > Classifica&ccedil;&atilde;o</th>
											  <th >A&ccedil;&otilde;es</th>												 
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
											  <th > Loja</th>
							  				  <th > CPF/CNPJ </th>
											  <th > Infra&ccedil;&atilde;o</th>
											  <th > Tipo Auto</th>
							  				  <th > Classifica&ccedil;&atilde;o</th>
											  <th >A&ccedil;&otilde;es</th>									  
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($infracoes) ? '1' : '0';			
										if($isArray == 0){ ?>
										<?php 	
										}else{			
											 foreach($infracoes as $key => $emitente){ 	
											 ?>
												 <tr>
												 <td>
												 <?php echo $emitente->nome_fantasia; ?>									
												  </td>
												  <td ><?php echo $emitente->cpf_cnpj; ?></td>
												  <td ><?php echo $emitente->cod_infracao; ?></td>

												  <td ><?php echo $emitente->auto_desc; ?>  </td>														<td ><?php echo $emitente->desc_classif; ?></td>												  
												  <td >
													<?php if($visitante == 0){ ?>
													
													<a href="<?php echo $this->config->base_url();?>index.php/infracoes/ativar?id=<?php echo $emitente->id_infracao; ?>" class="btn btn-success btn-xs" title='Ativar'><i class="fa fa-check"></i></a>
													<a href="<?php echo $this->config->base_url();?>index.php/infracoes/excluir?id=<?php echo $emitente->id_infracao; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>
													
													<?php } ?>
													<a href="<?php echo $this->config->base_url();?>index.php/infracoes/inserir_responsavel?id=<?php echo $emitente->id_infracao; ?>" class="btn btn-primary btn-xs" title='Respons&aacute;veis'><i class="fa fa-bars"></i></a>
												    <a href="<?php echo $this->config->base_url();?>index.php/infracoes/editar?id=<?php echo $emitente->id_infracao; ?>" class="btn btn-success btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>
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


			