<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var tipo = $('#tipo').val();
	
	$.ajax({				
		url: "<?php echo $this->config->base_url(); ?>index.php/cnd_mob/buscaTodasCidades?tipo="+tipo,				
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
	$( "#estado" ).change(function() {		
	var estado = $('#estado').val();					
	$.ajax({				
		url: "<?php echo $this->config->base_url(); ?>index.php/cnd_mob/buscaCidade?estado=" + estado+"&tipo="+tipo,				
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
		url: "<?php echo $this->config->base_url(); ?>index.php/cnd_mob/buscaInscricaoByEstado?id=" + estado+"&tipo="+tipo,					
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
		url: "<?php echo $this->config->base_url(); ?>index.php/cnd_mob/buscaEstado?id=" + estado+"&tipo="+tipo,				
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
			url: "<?php echo $this->config->base_url(); ?>index.php/cnd_mob/buscaLoja?id=" + municipio+"&tipo="+tipo,				
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
			url: "<?php echo $this->config->base_url(); ?>index.php/cnd_mob/buscaMunicipio?id=" + municipio+"&tipo="+tipo,					
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
				url: "<?php echo $this->config->base_url(); ?>index.php/cnd_mob/busca?id=" + id+"&tipo="+tipo,						
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

});		</script>	      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row mt">
                  <div class="col-md-12">				  				  
				  <span class='pull-left' style='font-weight:bold'> 					
					<?php echo utf8_encode($this->session->flashdata('mensagem')); ?>				  
					</span>
					<br>
				  
				  <a id='export' href="#" class="btn btn-primary btn-xs"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>				  &nbsp;				  <a id='limpar' href="#" class="btn btn-primary btn-xs"> Limpar Filtro</a>				  &nbsp;				  <select name="estado" id="estado" required="" class='procuraImovel'>				  <option value="0">Escolha um estado</option>						<?php foreach($estados as $key => $estado){ ?>					  <option value="<?php echo $estado->uf ?>"><?php echo $estado->uf?></option>					    <?php					}								    				   ?>				  </select>				  &nbsp;				  <select name="municipio" id="municipio" required="" class='procuraImovel'>				  <option value="0">Escolha uma Cidade</option>	 				   <?php foreach($cidades as $key1 => $cidade){ ?>				  <option value="<?php echo $cidade->cidade ?>"><?php echo $cidade->cidade?></option>					  <?php				  }								  				  ?>				  </select>				  				 <select name="id_imovel" id="imovel" required="" class='procuraImovel'>				  <option value="0">Todos</option>					  <?php foreach($lojas as $key2 => $loja){ ?>				  <option value="<?php echo $loja->id ?>"><?php echo $loja->nome?></option>					  <?php				  }								  				  ?>				</select>				
				  <span class='pull-right' style='font-weight:bold'> 
						<?php if(!empty($mensagem)){
							echo utf8_encode($mensagem); 
						}		
					?>
				  </span>
				  <br><br>
                      <div class="content-panel">
						 
                          <table id="clientes" class="table table-fixedheader table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> Lista de CND's - 							  <a target='_blank' href="<?php echo $this->config->base_url();?>index.php/documentacao/ler?modulo=cnd_mob">Documenta&ccedil;&atildeo </a>							  -							  <a target='_blank' href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/painel">Painel de Acompanhamento</a>							  </h4>							  							  <h5>								&nbsp;&nbsp;Legenda								&nbsp;								<span style='color:#009900'>Ativo </span>								&nbsp;								<span style='color:#CC0000'>Inativo </span>										&nbsp;								<span style='color:#428bca'>Possui CND </span>																  </h5>
	                  	  	  <hr>								
                              <thead>
                              <tr>
                                  <th width="18%"><i class="fa fa-bullhorn"></i> Razão Social</th>								  								  <th width="14%"><i class="fa fa-bullhorn"></i> CPF/CNPJ</th>
								  <th width="14%"><i class="fa fa-bookmark"></i> Inscrição </th>                                  <th width="15%"><i class="fa fa-bookmark"></i> Possui CND?</th>                                  
								  <th width="24%"><i class="fa fa-bookmark"></i> Data Vecto/Verificação</th>								                                    <th width="14%">A&ccedil;&otilde;es</th>
                              </tr>
                              </thead>
                              <tbody id='lista'>								
							  <?php 								 								
							  $isArray = is_array($iptus) ? '1' : '0';								
							  if($isArray == 1){								 
							  foreach($iptus as $key => $iptu){ 
												print$iptu->possui_cnd;
												print'-';
												print$iptu->arquivo;							  
							  if($iptu->possui_cnd == 1){									
								$possui ='Sim';									
								$dataVArr = explode("-",$iptu->data_vencto);									 									
								$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];								 
							}elseif($iptu->possui_cnd == 2){									
								$possui ='Não';									
								$dataVArr = explode("-",$iptu->data_vencto);									 									
								$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									 
							}else{									
								$possui ='Pendência';									
								$dataVArr = explode("-",$iptu->data_pendencias);									 									
								$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];									 
							}									 									 
							if($iptu->status_insc == 0){										
								$status ='Ativo';										
								$cor = '#009900';									 
							}else{										
								$status ='Inativo';										
								$cor = '#CC0000';									 
							}									 									 																	 
							?>								
							<tr style='color:<?php echo $cor; ?>'>                                  
							<td width="18%"><a href="#"><?php echo $iptu->raz_soc; ?></a></td>								  
							<td width="14%">								  
								<?php if($iptu->loja_acomp){ ?>								  
									<a href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/painel?id=<?php echo $iptu->loja_acomp; ?>">									<?php echo $iptu->cpf_cnpj_loja; ?>								  </a>								  
									<?php }else{ ?>								  
									<a style='color:#000' href="<?php echo $this->config->base_url();?>index.php/loja/acomp?id=<?php echo $iptu->id_loja; ?>">									<?php echo $iptu->cpf_cnpj_loja; ?>								  </a>								  
									<?php } ?>																
							</td>                                  
							<td width="14%" class="hidden-phone">								  									
								<?php 	
									
									if(($iptu->possui_cnd == 1 )) {											
										if(!empty($iptu->arquivo_cnd)){?>												
											<a href="<?php echo $this->config->base_url();?>index.php/cnd_mob/ver?id=<?php echo $iptu->id_cnd; ?>"><?php echo $iptu->ins_cnd_mob; ?></a>											
										<?php }else{?>													
											<?php echo $iptu->ins_cnd_mob; ?>											
										<?php } 
									}else{											
										if(!empty($iptu->arquivo_pendencias)){?>											
										<a href="<?php echo $this->config->base_url();?>index.php/cnd_mob/ver?id=<?php echo $iptu->id_cnd; ?>"><?php echo $iptu->ins_cnd_mob; ?></a>											
										<?php }else{?>													
										<?php echo $iptu->ins_cnd_mob; ?>											
										<?php }
									} ?>																	
							</td>								  
							<td width="15%" class="hidden-phone"><?php echo $possui; ?></td>								 
							<td width="24%" class="hidden-phone"><?php echo $dataV; ?></td>			  							                                    
							<td width="14%"> <?php 	if(($iptu->possui_cnd == 3 )){	?>	 <a href="<?php echo $this->config->base_url();?>index.php/cnd_mob/upload_pend?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-danger btn-xs" title='Upload de Pendência '><i class="fa fa-upload"></i></a>									  										<?php  }else{ ?>									  <a href="<?php echo $this->config->base_url();?>index.php/cnd_mob/upload_cnd?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-success btn-xs" title='Upload de Arquivo'><i class="fa fa-upload"></i></a>									  									<?php  } ?>                                        <a href="<?php echo $this->config->base_url();?>index.php/cnd_mob/editar?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>                                      <a href="<?php echo $this->config->base_url();?>index.php/cnd_mob/inativar?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-danger btn-xs" title='Inativar' ><i class="fa fa-trash-o "></i></a>									  <a href="<?php echo $this->config->base_url();?>index.php/cnd_mob/ativar?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-primary btn-xs" title='Ativar'><i class="fa fa-check-square-o"></i></a>                                  </td>								  </tr>								  <?php								  }								  }else{								  								   ?>								 <tr >                                  <td>Não Há Registros</td>                                  <td class="hidden-phone">  </td>								  <td class="hidden-phone"></td>			  								  <td class="hidden-phone"></td>								  <td class="hidden-phone"></td>			  							                                     <td>            									                                    </td>								  </tr>								  <?php								  								  }								  								  ?>
                              
								
                              
                             
                              </tbody>
                          </table>						  
						  	  								
						  <form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/cnd_mob/export' method='post'>
						  <input type='hidden' id='id_imovel_export' name='id_imovel_export'>	
						  <input type='hidden' id='tipo' name='tipo' value='X'>				
						  </form>												
						  <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/cnd_mob/export_mun' method='post'>
						  <input type='hidden' id='id_mun_export' name='id_mun_export'>			
						  <input type='hidden' id='tipo' name='tipo' value='X'>										  
						  </form>												
						  <form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/cnd_mob/export_est' method='post'>
						  <input type='hidden' id='id_estado_export' name='id_estado_export'>													
						  <input type='hidden' id='tipo' name='tipo' value='X'>				
						  </form>	
						  
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      