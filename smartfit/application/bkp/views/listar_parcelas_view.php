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
                                <h1>SubLoca&ccedil;&atilde;o <small>		</small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/sublocacoes/listar"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Parcelas</li>
									
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
									<a id='export' href="<?php echo $this->config->base_url();?>index.php/sublocacoes/export_detalhado?id=<?php echo$idsublocacao;?>"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	&nbsp;
									</h4>
									<br>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                 <div class="panel-body">
                                     <table class="table  table-striped table-advance table-hover " >
                              <thead>
							  
                              <tr>
								<th width="15%"> &nbsp; </th>
								<?php
								
								foreach($meses as $key => $mes){  ?>	
								 <th width="12%"><?php echo$mes->data_vencimento  ?>	</th>

								<?php } ?>	
                              </tr>							 
                              </thead>
							<?php 	
								$tab = $maiorReceita[0]->maior_receita;	
								
								$isArray =  count($aluguel);			
								 if($isArray == 0){ ?>								
								<?php 									
								}else{ ?>
								<tr>									
										<?php 
										//print_r($aluguel);exit;
										$i=1;
										foreach($aluguel as $key => $alu){
											if(empty($alu[0]->descricao_receita)){
												$receita = '';	
											}else{
												$receita = $alu[0]->descricao_receita;										
												
											echo"<th width='12%' >$receita</th>";
											$j = $i;
												foreach($alu as $k => $l){
													if($l->status == 0){
														$status ='Em Aberto';
														$cor = '#CC0000';
														$dataPagamento = '';	
														$valor = 0;
													}else{
														$status ='Pago';
														$dataPagamento = $l->data_pagamento;
														$cor = '#009900';
														$valor = $l->valor_pago;
													}
													?>	
													<th width='12%' style='color:<?php echo$cor;?>' >
														<?php echo $valor; ?>
													</th>
													<?php 	
												$j=$j+$tab;												
												}
											echo"</tr>";
											$i++;	
											}											
										}
									
									} ?>	
                              
								<tr>
								<th width="15%" class='soma' > Total da Composi&ccedil;&atildeo</th>
								<?php	
/*								
									$primeiro_mes =  (empty($meses[0])) ? "0" : str_replace('/', '_',$meses[0]);									 
									$segundo_mes =  (empty($meses[1])) ? "0" : str_replace('/', '_',$meses[1]);
									$terceiro_mes =  (empty($meses[2])) ? "0" : str_replace('/', '_',$meses[2]);
									$quarto_mes =  (empty($meses[3])) ? "0" : str_replace('/', '_',$meses[3]);
									$quinto_mes =  (empty($meses[4])) ? "0" : str_replace('/', '_',$meses[4]);
									$sexto_mes =  (empty($meses[5])) ? "0" : str_replace('/', '_',$meses[5]);
									
								?>	
								<input type="hidden" id='primeiro_mes' value="<?php echo $primeiro_mes; ?>" >
								<input type="hidden" id='segundo_mes' value="<?php echo $segundo_mes; ?>" >
								<input type="hidden" id='terceiro_mes' value="<?php echo $terceiro_mes; ?>" >
								<input type="hidden" id='quarto_mes' value="<?php echo $quarto_mes; ?>" >
								<input type="hidden" id='quinto_mes' value="<?php echo $quinto_mes; ?>" >
								<input type="hidden" id='sexto_mes' value="<?php echo $sexto_mes; ?>" >
								<?php
								*/
								foreach($totalComposicao as $tot){
									if($tot->soma){
										$totalPago = number_format($tot->soma, 2, ',', '.') ;
									}else{
										$totalPago = 0;
									}
								 ?>	
								
								 <th width="12%"><?php echo $totalPago; ?></th>

								<?php } ?>	
								</tr>
								
								<th width="15%" class='soma' > Valor Pago </th>
								<?php
								
								foreach($totais as $tot){
									
									if($tot->valor_pago){
										$totalPago = $tot->valor_pago ;
									}else{
										$totalPago = 0;
									}
								 ?>	
								
								 <th width="12%"><?php echo $totalPago; ?></th>

								<?php } ?>	
								</tr>
							  
                          </table>
                                </div>
                            </div><!-- End .panel -->  
                        </div><!--end .col-->
                    </div><!--end .row-->


                </div> 
            </div>


			
          