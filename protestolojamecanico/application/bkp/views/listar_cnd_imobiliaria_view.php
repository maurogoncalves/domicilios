<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var cidadeFiltro = $('#cidadeFiltro').val();			 
		var tipo = $('#tipo').val();

		$.ajax({		
		url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaTodasCidades?cidadeFiltro=" + cidadeFiltro+"&tipo="+tipo,	
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
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaImovel?id=" + cidadeFiltro+"&tipo="+tipo,					
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
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaCidade?estado=" + estado+"&tipo="+tipo,				
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
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaInscricaoByEstado?id=" + estado+"&tipo="+tipo,			
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
					url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaEstado?id=" + estado+"&tipo="+tipo,				
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
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaImovel?id=" + municipio+"&tipo="+tipo,						
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
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaMunicipio?id=" + municipio+"&tipo="+tipo,						
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
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/busca?id=" + id+"&tipo="+tipo,						
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
			var id = $('#imovel').val();			
			var municipio = $('#municipio').val();			
			var estado = $('#estado').val();					
			if((id == 0) && (municipio == 0) && (estado == 0))  {					
				$("#id_imovel_export").val(id);			
				$( "#export_imovel" ).submit();					
			}else{					
				if(id != 0){				
					$("#id_imovel_export").val(id);				
					$( "#export_imovel" ).submit();			
				}else{				
					if(municipio == 0){									
						$("#id_estado_export").val(estado);					
						$( "#export_estado" ).submit();				
					}else{					
						$("#id_mun_export").val(municipio);					
						$( "#export_mun" ).submit();				
					}			
				}		
			}	
		});		
		
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
					<span class='pull-left' style='font-weight:bold'> 					
						<?php echo utf8_encode($this->session->flashdata('mensagem')); ?>				  </span>
					<br>
				    <a id='export' href="#" class="btn btn-primary btn-xs"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>				  
					&nbsp;				 
					<a id='limpar' href="#" class="btn btn-primary btn-xs"> Limpar Filtro</a>				  
					&nbsp;				  
					<select name="estado" id="estado" required="" class='procuraImovel'>				 
						<option value="0">Escolha um estado</option>						
							<?php foreach($estados as $key => $estado){ 						
								if($estadoFiltro == $estado->uf){					
							?>					  
									<option value="<?php echo $estado->uf ?>" selected><?php echo $estado->uf?></option>					   
							<?php					
								}else{								    				   
							?>					
									<option value="<?php echo $estado->uf ?>" ><?php echo $estado->uf?></option>					   
									<?php					
							}
								}  				   
							?>				  
					</select>				  
					&nbsp;				  
					<input type='hidden' id='cidadeFiltro' name='cidadeFiltro' value='<?php echo$cidadeFiltro ?>'>				  
					<select name="municipio" id="municipio" required="" class='procuraImovel'>				  
						<option value="0">Escolha uma Cidade</option>	 
					</select>				  				
					<select name="id_imovel" id="imovel" required="" class='procuraImovel'>				 
						<option value="0">Todos</option>					 
						<?php foreach($imoveis as $key => $imovel){ ?>				  
							<option value="<?php echo $imovel->id ?>"><?php echo $imovel->nome?></option>					 
						<?php				  
							}								  				 
						?>				
					</select>                      
					<div class="content-panel">                          
					
					<table id="clientes" class="table table-fixedheader  table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> Lista de CND's - <a target='_blank' href="<?php echo $this->config->base_url();?>index.php/documentacao/ler?modulo=cnd_imob">Documenta&ccedil;&atildeo </a></h4>								<h5>								&nbsp;&nbsp;Legenda								&nbsp;								<span style='color:#009900'>Ativo </span>								&nbsp;								<span style='color:#CC0000'>Inativo </span>										&nbsp;								<span style='color:#428bca'>Possui Arquivo </span>																  </h5>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th width="30%"><i class="fa fa-bullhorn"></i> Nome Imóvel</th>
								  <th width="17%"><i class="fa fa-bookmark"></i> Inscrição </th>                                  
								  <th width="14%"><i class="fa fa-bookmark"></i> Possui CND?</th>                                  
								  <th width="24%"><i class="fa fa-bookmark"></i> Data Vecto/Verificação</th>								  								  
                                  <th width="13%">A&ccedil;&otilde;es</th>
                              </tr>
                              </thead>
                              <tbody id='lista'>								
							  <?php 								 								
								$isArray = is_array($iptus) ? '1' : '0';								
									if($isArray == 1){								
									foreach($iptus as $key => $iptu){ 										 
										if($iptu->ativo == 0){										
											$status ='Ativo';										
											$cor = '#009900';									 
										}else{										
											$status ='Inativo';										
											$cor = '#CC0000';									 
										}									 
										if($iptu->possui_cnd == 1){										
											$possui ='Sim';										
											$dataVArr = explode("-",$iptu->data_vencto);
											$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									 
										}elseif($iptu->possui_cnd == 2){										
											$possui ='Não';										
											$dataVArr = explode("-",$iptu->data_vencto);	
											$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];										 
										}elseif($iptu->possui_cnd == 3){										
											$possui ='Pendência';										
											$dataVArr = explode("-",$iptu->data_pendencias);
											$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];										 
										}else{
											$possui ='Sem Definição';
											$dataV = '00-00-0000';
										}									 															 
										?>								 
										<tr style='color:<?php echo $cor; ?>'>                                  
											<td width="30%"><a href="#"><?php echo $iptu->nome; ?></a></td>								  								  
											<td width="17%" class="hidden-phone">											
											<?php 	

												if( ($iptu->possui_cnd == 1 )) {											
													if(!empty($iptu->arquivo)){?>												
														<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/ver?id=<?php echo $iptu->id_cnd; ?>"><?php echo $iptu->inscricao; ?></a>											
													<?php }else{?>													
														<?php echo $iptu->inscricao; ?>											
													<?php }										
												
												}else{											
												if(!empty($iptu->arquivo_pendencias)){?>											
													<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/ver?id=<?php echo $iptu->id_cnd; ?>"><?php echo $iptu->inscricao; ?></a>											
													<?php }else{?>													
													<?php echo $iptu->inscricao; ?>											
												<?php }
												} ?>																	 
											</td>								
													<!--                                  <td class="hidden-phone">								  									<?php if($iptu->possui_cnd){?>										<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/ver?id=<?php echo $iptu->id_cnd; ?>"><?php echo $iptu->inscricao; ?></a>									<?php }else{?>											<?php echo $iptu->inscricao; ?>									<?php }?>									  </td>								  !-->								  <td width="14%" class="hidden-phone"><?php echo $possui; ?></td>								  <td width="24%" class="hidden-phone"><?php echo $dataV; ?></td>			  							                                     <td width="13%">        									<?php 										if( ($iptu->possui_cnd == 1 )) {?>											<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/upload_cnd?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-success btn-xs" title='Upload de CND'><i class="fa fa-upload"></i></a>									  										<?php }else{?>											<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/upload_cnd_pend?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-danger btn-xs" title='Upload de Pendência'><i class="fa fa-upload"></i></a>									  										  <?php }?>                                      <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/editar?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>                                      <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/inativar?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>									  <a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/ativar?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-primary btn-xs" title='Ativar'><i class="fa fa-check-square-o"></i></a>                                  </td>								  </tr>								  <?php								  }								  }else{								  								   ?>								 <tr >                                  <td>Não Há Registros</td>                                  <td class="hidden-phone">  </td>								  <td class="hidden-phone"></td>			  								  <td class="hidden-phone"></td>								  <td class="hidden-phone"></td>			  							                                     <td>            									                                    </td>								  </tr>								  <?php								  								  }								  								  ?>
                              
								
                              
                             
                              </tbody>
                          </table>						  
						  <p id='paginacao'>	
						  <?php echo$paginacao; ?>						  
						  </p>						  								
						  <form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/cnd_imob/export' method='post'>	
						  <input type='hidden' id='id_imovel_export' name='id_imovel_export'>
							<input type='hidden' id='tipo' name='possuiCnd' value='<?php echo$tipo ?>'>						  
						  </form>												
						  <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/cnd_imob/export_mun' method='post'>	
						  <input type='hidden' id='id_mun_export' name='id_mun_export'>
						  <input type='hidden' id='tipo' name='possuiCnd' value='<?php echo$tipo ?>'>	
						  </form>												
						  <form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/cnd_imob/export_est' method='post'>
						  <input type='hidden' id='id_estado_export' name='id_estado_export'>		
						  <input type='hidden' id='tipo' name='possuiCnd' value='<?php echo$tipo ?>'>						  
						  </form>							
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      