<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){var cidadeFiltro = $('#cidadeFiltro').val();			 
		$.ajax({		
		url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaTodasCidades?cidadeFiltro=" + cidadeFiltro,	
		type : 'GET', /* Tipo da requisição */ 	contentType: "application/json; charset=utf-8",	
		dataType: 'json', /* Tipo de transmissão */	
		success: function(data){
			if (data == undefined ) {			
				console.log('Undefined');		
			} else {			
				$('#municipio').html(data);		
			}	
		}
		}); 		
		if(cidadeFiltro !==0){		
			$.ajax({				
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaImovel?id=" + cidadeFiltro,				
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
		}			 
		$( "#estado" ).change(function() {		
			var estado = $('#estado').val();					
			$.ajax({				
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaCidade?estado=" + estado,				
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
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaInscricaoByEstado?id=" + estado,				
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
					url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaEstado?id=" + estado,				
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
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaImovel?id=" + municipio,				
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
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaMunicipio?id=" + municipio,				
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
		$( "#imovel" ).change(function() {		var id = $('#imovel').val();					$.ajax({				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/busca?id=" + id,				type : 'GET', /* Tipo da requisição */ 				contentType: "application/json; charset=utf-8",	        	dataType: 'json', /* Tipo de transmissão */				success: function(data){						if (data == undefined ) {						console.log('Undefined');					} else {						$('#lista').html(data);						$('#paginacao').hide();					}										}			 }); 											});			
		$( "#export" ).click(function() {		var id = $('#imovel').val();			var municipio = $('#municipio').val();			var estado = $('#estado').val();					if((id == 0) && (municipio == 0) && (estado == 0))  {					$("#id_imovel_export").val(id);			$( "#export_imovel" ).submit();					}else{					if(id != 0){				$("#id_imovel_export").val(id);				$( "#export_imovel" ).submit();			}else{				if(municipio == 0){									$("#id_estado_export").val(estado);					$( "#export_estado" ).submit();				}else{					$("#id_mun_export").val(municipio);					$( "#export_mun" ).submit();				}			}		}	});		
		
		$( "#limpar" ).click(function() {		
			location.reload();	
		});	

			
		});		
		
		
		</script>	      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row mt">
                  <div class="col-md-12">				  
					<span class='pull-right' style='font-weight:bold'> 					<?php echo utf8_encode($this->session->flashdata('mensagem')); ?>				  </span>
				                       
					<div class="content-panel">                          
					
					<table id="clientes" class="table table-fixedheader  table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> Dados Agrupados de CND's Imobiliária - <a target='_blank' href="<?php echo $this->config->base_url();?>index.php/documentacao/ler?modulo=cnd_imob">Documenta&ccedil;&atildeo </a></h4>								
							  
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th width="30%"><i class="fa fa-bullhorn"></i> Possui CND?</th>
								  <th width="30%"><i class="fa fa-bookmark"></i> Total </th>                                  
							  								  
                                  <th width="30%">A&ccedil;&otilde;es</th>
                              </tr>
                              </thead>
                              <tbody id='lista'>								
							  <?php 								 								
								$isArray = is_array($iptus) ? '1' : '0';								
								if($isArray == 1){								
									foreach($iptus as $key => $iptu){ 										 
										if($iptu->possui_cnd == 1){										
											$possui ='Sim';				
											$arquivo = 'listarPorTipoSim';		
										}elseif($iptu->possui_cnd == 2){										
											$possui ='Não';										
											$arquivo = 'listarPorTipoNao';
										}elseif($iptu->possui_cnd == 3){										
											$possui ='Pendência';			
											$arquivo = 'listarPorTipoPendencia';			
										}else{
											$possui ='Sem Definição';
											$arquivo = 'listarPorTipo';											
										}
							?>								
							<tr style='color:<?php echo $cor; ?>'>                                 
							
							<td width="30%" class="hidden-phone">	 <?php echo $possui; ?>	</td>								  									
							<td width="30%"><?php echo $iptu->total; ?></td>	
							<td width="30%"><a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/<?php echo $arquivo; ?>" class="btn btn-danger btn-xs">Ver Detalhado</a>									</td>	
							
													  								  
                              
								
                              
									<?php }} ?> 
                             </tbody>
                          </table>						  
								  								
						  <form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/cnd_imob/export' method='post'>	
						  <input type='hidden' id='id_imovel_export' name='id_imovel_export'>													
						  </form>												
						  <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/cnd_imob/export_mun' method='post'>							<input type='hidden' id='id_mun_export' name='id_mun_export'>													</form>												<form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/cnd_imob/export_est' method='post'>							<input type='hidden' id='id_estado_export' name='id_estado_export'>													</form>							
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      