<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$( "#estado" ).change(function() {
		var estado = $('#estado').val();	

		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes_vencidas/buscaCidadeByEstado?estado=" + estado,
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
				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes_vencidas/buscaInfraByEstado?estado=" + estado,
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

				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes_vencidas/buscaInfracaoByEstado?id=" + estado,

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

				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes_vencidas/buscaInfracaoByMunicipio?municipio=" + municipio,

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



				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes_vencidas/buscaInfraByCidade?municipio=" + municipio,

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



				url: "<?php echo $this->config->base_url(); ?>index.php/infracoes_vencidas/buscaInfraById?id=" + id,

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

	



	$( "#limpar" ).click(function() {

		location.reload();

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

          <!-- **********************************************************************************************************************************************************

      MAIN CONTENT

      *********************************************************************************************************************************************************** -->

      <!--main content start-->

      <section id="main-content">

          <section class="wrapper">

              <div class="row mt">

                  <div class="col-md-12">

				  

				  <a  href="<?php echo $this->config->base_url();?>index.php/infracoes/cadastrar" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Nova Infra&ccedil;&atilde;o</a>

				  &nbsp;

				  <a id='export' href="#" class="btn btn-primary btn-xs"><i class="fa fa-file-excel-o"></i> Exportar</a>

				  &nbsp;

				  <a id='limpar' href="#" class="btn btn-primary btn-xs"> Limpar Filtro</a>

				  &nbsp;

				  <select name="estado" id="estado" required="" class='procuraImovel'>

				  <option value="0">Escolha um estado</option>	

					<?php foreach($estados as $key => $estado){ ?>

					  <option value="<?php echo $estado->estado ?>"><?php echo $estado->estado?></option>	

				    <?php

					}								  

  				   ?>



				  </select>

				  &nbsp;

				  <select name="municipio" id="municipio" required="" class='procuraImovel'>

				  <option value="0">Todos</option>	

				  <?php foreach($cidades as $key => $cidade){ ?>

				  <option value="<?php echo $cidade->cidade ?>"><?php echo $cidade->cidade?></option>	

				  <?php

				  }								  

				  ?> 

				  </select>		

				  

				 <select name="id_imovel" id="imovel" required="" class='procuraImovel'>

				  <option value="0">Todos</option>	

				  <?php foreach($lojas as $key => $loja){ ?>

				  <option value="<?php echo $loja->id ?>"><?php echo $loja->nome_fantasia?></option>	

				  <?php

				  }								  

				  ?>

				</select>

                      <div class="content-panel" style='height:500px'>

						 

                          <table class="table table-fixedheader  table-striped table-advance table-hover " >

	                  	  	  <h4><i class="fa fa-angle-right"></i> Lista de Infra&ccedil;&otilde;es

							  &nbsp;							  							 

							  </h4>

	                  	  	  <hr>

                              <thead>

                              <tr>

                                  <th width="20%"> Loja</th>
								  
								  <th width="20%"> CPF/CNPJ </th>

								  <th width="15%"> Infra&ccedil;&atilde;o</th>

								  <th width="15%"> Tipo Auto</th>
								  
								  <th width="15%"> Classifica&ccedil;&atilde;o</th>


                                  <th width="15%">A&ccedil;&otilde;es</th>

                              </tr>

                              </thead>

                              <tbody id='lista'>

                              

								 <?php 	

								$isArray =  is_array($infracoes) ? '1' : '0';

								if($isArray == 0){ ?>

								<tr>

								  <td colspan='7'><a href="#">N&atilde;o H&aacute Registros</td>

								  </tr>

								

								<?php 	

								 }else{

									 foreach($infracoes as $key => $emitente){ 

								 

									 ?>

									 <tr>

									  <td width="20%"><a href="#"><?php echo $emitente->nome_fantasia; ?></a></td>
									  
									  <td width="20%" class="hidden-phone"><?php echo $emitente->cpf_cnpj; ?></td>

									  <td width="15%"><a href="#"><?php echo $emitente->cod_infracao; ?></a></td>

									  <td width="15%"><span style='font-weight:bold' label-mini"><?php echo $emitente->desc_classif; ?></span></td>
									  <td width="15%"><span style='font-weight:bold' label-mini"><?php echo $emitente->auto_desc; ?></span></td>

									  <td width="15%">

									  	  <a href="<?php echo $this->config->base_url();?>index.php/infracoes/inserir_responsavel?id=<?php echo $emitente->id_infracao; ?>" class="btn btn-primary btn-xs"><i class="fa fa-bars"></i></a>

										  <a href="<?php echo $this->config->base_url();?>index.php/infracoes/ativar?id=<?php echo $emitente->id_infracao; ?>" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>

										  <a href="<?php echo $this->config->base_url();?>index.php/infracoes/excluir?id=<?php echo $emitente->id_infracao; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>

										  
										  <a href="<?php echo $this->config->base_url();?>index.php/infracoes/editar?id=<?php echo $emitente->id_infracao; ?>" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a>

									  </td>

									  </tr>

									  <?php

									  }

								  }

								  ?>

                              

                             

                              </tbody>

                          </table>

						 <p id='paginacao'>	

						  <?php echo$paginacao; ?>

						  </p>

						  

						<form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/infracoes/export' method='post'>

							<input type='hidden' id='id_imovel_export' name='id_imovel_export'>							

						</form>

						

						<form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/infracoes/export_mun' method='post'>

							<input type='hidden' id='id_mun_export' name='id_mun_export'>							

						</form>

						

						<form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/infracoes/export_est' method='post'>

							<input type='hidden' id='id_estado_export' name='id_estado_export'>							

						</form>		

                      </div><!-- /f

					  -->

                  </div><!-- /col-md-12 -->

              </div><!-- /row -->



		</section><! --/wrapper -->

      </section><!-- /MAIN CONTENT -->



      <!--main content end-->

      
