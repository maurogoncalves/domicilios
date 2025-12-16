<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$( "#limpar" ).click(function() {		
		location.reload();
	});
	$( "#export" ).click(function() {		
		var id = $('#emitente').val();			
		var tipo_licenca = $('#tipo_licenca').val();			
		var municipio = $('#municipio').val();			
		var estado = $('#estado').val();			
			if(tipo_licenca == 0){			
				if((id == 0) && (municipio == 0) && (estado == 0))  {							
					$("#id_emitente_export").val(id);				
					$( "#export_emitente" ).submit();							
				}else{									
					if(id != 0){										
						$("#id_emitente_export").val(id);					
						$( "#export_emitente" ).submit();				
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
			}else{						
				$("#id_tipo_export").val(tipo_licenca);			
				$("#export_tipo").submit()		
			}	
	});	
	$( "#tipo_licenca" ).change(function() {	
		var tipo_licenca = $('#tipo_licenca').val();					
			$.ajax({				
			url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaLicencaByTipo?id=" + tipo_licenca,				
			type : 'GET', /* Tipo da requisição */ 				
			contentType: "application/json; charset=utf-8",	        	
			dataType: 'json', /* Tipo de transmissão */				
			success: function(data){							
				if (data == 0 ) {						
					$('#lista').html('Não Há Dados');					
				} else {						
					$('#lista').html(data);					
				}										
			}			 
			}); 
	});
	$( "#emitente" ).change(function() {	
		$('#tipo_licenca').val("0");	
		var emitente = $('#emitente').val();		
		$.ajax({		
		url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaLicencaByEmitente?id=" + emitente,		
		type : 'GET', /* Tipo da requisição */ 		
		contentType: "application/json; charset=utf-8",       	
		dataType: 'json', /* Tipo de transmissão */		
		success: function(data){				
			if (data == undefined ) {				
				console.log('Undefined');			
			} else {				
				$('#lista').html(data);			
			}		
		}	 
		});
	});
	$( "#municipio" ).change(function() {	
		$('#tipo_licenca').val("0");	
		var cidade = $('#municipio').val();		
			$.ajax({		
			url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaLicencaByCidade?id=" + cidade,		
			type : 'GET', /* Tipo da requisição */ 		
			contentType: "application/json; charset=utf-8",       	
			dataType: 'json', /* Tipo de transmissão */		
			success: function(data){				
			if (data == undefined ) {				
				console.log('Undefined');			
			} else {				
				$('#lista').html(data);			
			}		
			}	 
			});
			
	$.ajax({				
			url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaEmitenteByCidade?cidade=" + cidade,					
			type : 'GET', /* Tipo da requisição */ 				
			contentType: "application/json; charset=utf-8",	        	
			dataType: 'json', /* Tipo de transmissão */				
			success: function(data){						
				if (data == undefined ) {						
					console.log('Undefined');					
				} else {						
					$('#emitente').html(data);					
				}										
			}			 
		});		
	});
	$( "#estado" ).change(function() {		
		$('#tipo_licenca').val("0");		
		var estado = $('#estado').val();			
		$.ajax({				
		url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaCidade?estado=" + estado,				
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
		url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaEmitente?estado=" + estado,				
		type : 'GET', /* Tipo da requisição */ 				
		contentType: "application/json; charset=utf-8",	        	
		dataType: 'json', /* Tipo de transmissão */				
		success: function(data){						
			if (data == undefined ) {						
				console.log('Undefined');					
			} else {						
				$('#emitente').html(data);					
			}										
		}			 
		}); 		
		$.ajax({				
		url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaLicenca?id=" + estado,				
		type : 'GET', /* Tipo da requisição */ 				
		contentType: "application/json; charset=utf-8",	        	
		dataType: 'json', /* Tipo de transmissão */				
		success: function(data){											
			if (data == undefined ) {						
				console.log('Undefined');					
			} else {						
				$('#lista').html(data);					
			}										
		}			 
		}); 			 							 								
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
				  
				  <a id='export' href="#" class="btn btn-primary btn-xs"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>				  &nbsp;				   &nbsp;				  <a id='limpar' href="#" class="btn btn-primary btn-xs"> Limpar Filtro</a>				  &nbsp;				  <select name="estado" id="estado" required="" class='procuraImovel'>				  <option value="0">Estado</option>						<?php foreach($estados as $key => $estado){ ?>					  <option value="<?php echo $estado->estado ?>"><?php echo $estado->estado?></option>					    <?php					}								    				   ?>				  </select>				  &nbsp;				  <select name="municipio" id="municipio" required="" class='procuraImovel'>				  <option value="0">Cidade</option>	 				  <?php foreach($cidades as $key => $cidade){ ?>					  <option value="<?php echo $cidade->cidade ?>"><?php echo $cidade->cidade?></option>					    <?php					}								    				   ?>				  </select>					  &nbsp;				  <select name="emitente" id="emitente" required="" class='procuraImovel'>				  <option value="0">Emitente</option>	 				  <?php foreach($emitentes as $key => $emitente){ ?>					  <option value="<?php echo $emitente->id ?>"><?php echo $emitente->nome_fantasia?></option>					    <?php					}								    				   ?>				  </select>					  				   &nbsp;				 <select name="tipo_licenca" id="tipo_licenca" required="" class='procuraImovel'>				  <option value="0">Tipo</option>					  <?php foreach($tipos_licencas as $key => $licenca){ ?>				  <option value="<?php echo $licenca->id ?>"><?php echo $licenca->descricao?></option>					  <?php				  }								  				  ?>				</select>
                      <div class="content-panel">
						 
                          <table id="clientes" class="table table-fixedheader table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> Lista de Licenças - <a target='_blank' href="<?php echo $this->config->base_url();?>index.php/documentacao/ler?modulo=licencas">Documenta&ccedil;&atildeo </a></h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th width="20%"><i class="fa fa-bullhorn"></i> Nome </th>
								  <th width="15%"><i class="fa fa-bookmark"></i> Tipo </th>								                                    
								  <th width="20%" class="hidden-phone"><i class="fa fa-info-circle"></i> Data Vencimento</th>								 
								  <th width="20%" class="hidden-phone"><i class="fa fa-info-circle"></i> Cidade</th>								 
								  <th width="10%" class="hidden-phone"><i class="fa fa-info-circle"></i> UF</th> 
								  
                                  <th width="15%">A&ccedil;&otilde;es</th>
								  
                              </tr>
                              </thead>
                              <tbody id='lista'>								
								<?php 								 								
									$isArray =  is_array($licencas) ? '1' : '0';											 
									if($isArray == 0){ ?>								
									<tr>								  
									<td colspan='5'><a href="#">N&atilde;o H&aacute Registros</td>								 
									</tr>																
									<?php 									
									}else{									 
									foreach($licencas as $key => $licenca){ 											 
										if($licenca->status == 0){											
											$status ='Ativo';											
											$cor = '#009900';										
										}else{											
											$status ='Inativo';											
											$cor = '#CC0000';										 
										}										
											$dataFormatadaArr = explode('-',$licenca->data_vencimento);										
											$dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
									?>																		 
											<tr style='color:<?php echo $cor; ?>'>									  
											<td width="20%"> <?php echo $licenca->nome_fantasia; ?> </td>		  									  
											<td width="15%"class="hidden-phone"><?php echo $licenca->descricao; ?></td>									 
											<td width="20%" class="hidden-phone"><?php echo $dataFormatada; ?></td>
											<td width="20%"class="hidden-phone"><?php echo $licenca->cidade; ?></td>									  
											<td width="10%"class="hidden-phone"><?php echo $licenca->estado; ?></td>
											<td width="15%">      										
											<a href="<?php echo $this->config->base_url();?>index.php/licencas/editar_loja_licenca?id_licenca=<?php echo $licenca->id_licenca; ?>&id_loja=<?php echo $licenca->id_loja; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>										 
											<a href="<?php echo $this->config->base_url();?>index.php/licencas/inativar?id=<?php echo $licenca->id_licenca; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>										 
											<a href="<?php echo $this->config->base_url();?>index.php/licencas/ativar?id=<?php echo $licenca->id_licenca; ?>" class="btn btn-primary btn-xs" title='Ativar'><i class="fa fa-check-square-o"></i></a>									 
											</td>									  
											</tr>									 
											<?php									  
												}								 
												}								  								  
									?>
                              
								
                              
                             
                              </tbody>
                          </table>						  <p id='paginacao'>	
						  <?php echo$paginacao; ?>						  </p>						
						  <form  id='export_emitente' action='<?php echo $this->config->base_url(); ?>index.php/licencas/export' method='post'>	
						  <input type='hidden' id='id_emitente_export' name='id_emitente_export'>													
						  </form>																
						  <form  id='export_tipo' action='<?php echo $this->config->base_url(); ?>index.php/licencas/export_tipo' method='post'>	
						  <input type='hidden' id='id_tipo_export' name='id_tipo_export'>													
						  </form>												
						  <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/licencas/export_mun' method='post'>
						  <input type='hidden' id='id_mun_export' name='id_mun_export'>													
						  </form>												
						  <form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/licencas/export_est' method='post'>
						  <input type='hidden' id='id_estado_export' name='id_estado_export'>													
						  </form>							
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      