<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$( "#limpar" ).click(function() {		
			$("#limpar_filtro").submit();
		});	
	
	var cidadeBD = $('#cidadeBD').val();
	var estadoBD = $('#estadoBD').val();
	var idSubL = $('#idSubL').val();
		
	if(estadoBD !== '0'){			
		$('#estado').val(estadoBD);
	}
	if(cidadeBD !== '0'){			
		$('#municipio').val(cidadeBD);
	}
	if(idSubL !== '0'){			
		$('#imovel').val(idSubL);	
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/buscaSubLocacaoById?id=" + idSubL,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						$('#lista').html(data);
						$('#paginacao').hide();
						$('#bandeira').val(0);
					}
				}
			 }); 
	}
	
		
$( "#estado" ).change(function() {
		var estado = $('#estado').val();	
		
		
		

		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/buscaCidadeByEstado?estado=" + estado,
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
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/buscaSubByEstado?estado=" + estado,
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

				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/buscaSubLocacaoByEstado?id=" + estado,

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

				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/buscaSubByMunicipio?municipio=" + municipio,

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



				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/buscaSubLocacaoByCidade?municipio=" + municipio,

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

		

	$( "#imovel" ).change(function() {



		var id = $('#imovel').val();	

	

		

		$.ajax({



				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/buscaSubLocacaoById?id=" + id,

				type : 'GET', /* Tipo da requisição */ 

				contentType: "application/json; charset=utf-8",

	        	dataType: 'json', /* Tipo de transmissão */

				success: function(data){	



					if (data == undefined ) {

						console.log('Undefined');

					} else {



						$('#lista').html(data);

						$('#paginacao').hide();

						$('#bandeira').val(0);

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
                                <h1>SubLoca&ccedil;&atilde;o <small>	<?php echo utf8_encode($mensagemSub);?>	</small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/sublocacoes/listar"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de SubLoca&ccedil;&atilde;o</li>
									
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
									<a href="<?php echo $this->config->base_url();?>index.php/sublocacoes/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Nova SubLoca&ccedil;&atilde;o</a> 
									&nbsp;				  									
									<a id='export' href="#"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	&nbsp;
									</h4>
									<br>
									<?php
									
									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
									echo form_open('sublocacoes/listar', $attributes); 
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
								   					   
								 <button class="btn btn-primary" type="submit">Filtrar</button>
								 </form>
									&nbsp;
									
								<form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/sublocacoes/export' method='post'>							
								  <input type='hidden' id='id_imovel_export' name='id_imovel_export'>	
								 </form>												
								 <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/sublocacoes/export_mun' method='post'>	
								  <input type='hidden' id='id_mun_export' name='id_mun_export'>	
								 </form>												
								 <form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/sublocacoes/export_est' method='post'>
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
                                                <th>Locador</th>
                                                <th>Locat&aacute;rio</th>
                                                <th>Prazo Contrato</th>
                                                <th>Tipo</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
							                    <th>Locador</th>
                                                <th>Locat&aacute;rio</th>
                                                <th>Prazo Contrato</th>
                                                <th>Tipo</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($sublocacoes) ? '1' : '0';			
										if($isArray == 0){ ?>
										<?php 	
										}else{								 
											 foreach($sublocacoes as $key => $sub){ 													
											 ?>
												 <tr>
												 <td ><?php echo $sub->locador; ?></td>	
												 <td ><?php echo $sub->locatario; ?></td>	
												 <td ><?php echo $sub->prazo; ?></td>	
												 <td ><?php echo $sub->descricao_receita; ?></td>	
							  					 <td>
													<a href="<?php echo $this->config->base_url();?>index.php/sublocacoes/parcelas?id=<?php echo $sub->idsub; ?>" class="btn btn-primary btn-xs" title='Mostrar Meses'><i class="fa fa-bars"></i></a>
													<a href="<?php echo $this->config->base_url();?>index.php/sublocacoes/composicao?id=<?php echo $sub->idsub; ?>" class="btn btn-primary btn-xs" title='Inserir'><i class="fa fa-rss"></i></a>
													<a href="<?php echo $this->config->base_url();?>index.php/sublocacoes/editar?id=<?php echo $sub->idsub; ?>" class="btn btn-success btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>

													<?php if($visitante == 0){ ?>
													<a href="<?php echo $this->config->base_url();?>index.php/sublocacoes/ativar?id=<?php echo $sub->idsub; ?>" class="btn btn-success btn-xs" title='Ativar'><i class="fa fa-check"></i></a>
													<a href="<?php echo $this->config->base_url();?>index.php/sublocacoes/excluir?id=<?php echo $sub->idsub; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>
													<?php } ?>
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


			
          