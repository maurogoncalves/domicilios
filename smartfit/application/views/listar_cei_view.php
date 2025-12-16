<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.js'></script>
<link href='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.css' rel='stylesheet' />
<script type="text/javascript">      
	$(document).ready(function(){	
	
		$( "#limpar" ).click(function() {		
			$( "#limpar_filtro" ).submit();			
		});		
	
					
		$('#estado').change(function(){			
			var estado = $("#estado").val();		
			$.ajax({				
				url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/buscaCidade?estado=" + estado,				
				type : 'GET', /* Tipo da requisição */ 				
				contentType: "application/json; charset=utf-8",	        	
				dataType: 'json', /* Tipo de transmissão */				
				success: function(data){											
					if (data == undefined ) {						
						console.log('Undefined');					
					} else {						
						$('#cidade').html(data);					
					}										
				}		 
			});		 		 
			$.ajax({				
				url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/buscaCeiByEstado?estado=" + estado,				
				type : 'GET', /* Tipo da requisição */ 				
				contentType: "application/json; charset=utf-8",	        	
				dataType: 'json', /* Tipo de transmissão */				
					success: function(data){											
						if (data == undefined ) {						
							console.log('Undefined');					
						} else {							
							$('#cei').html(data);					
						}										
					}		 
				});		 		  
			$.ajax({				
				url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/buscaTodasCeiByEstado?estado=" + estado,
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
		
		$('#cei').change(function(){		
			var cei = $("#cei").val();		 
			$.ajax({				
				url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/buscaTodasCeiById?cei=" + cei,
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
		$('#cidade').change(function(){			
			var cidade = $("#cidade").val();		
				$.ajax({				
					url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/buscaCeiByCidade?cidade=" + cidade,				
					type : 'GET', /* Tipo da requisição */ 				
					contentType: "application/json; charset=utf-8",	        	
					dataType: 'json', /* Tipo de transmissão */				
					success: function(data){											
						if (data == undefined ) {						
							console.log('Undefined');					
						} else {						
							$('#cei').html(data);					
						}										
					}		 
				});		 		  
				$.ajax({				
					url: "<?php echo $this->config->base_url(); ?>index.php/matricula_cei/buscaTodasCeiByCidade?cidade=" + cidade,				
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
					var id = $('#cei').val();						
					var municipio = $('#cidade').val();						
					var estado = $('#estado').val();				
						if((id == '0') && (municipio == '0') && (estado == '0'))  {									
							$("#id_imovel_export").val(id);							
							$( "#export_imovel" ).submit();								
						}else{									
							if(id !== '0'){													
								$("#id_imovel_export").val(id);									
								$( "#export_imovel" ).submit();							
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
				});	});
				</script>        
      
	  <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Matricula Cei <small><?php echo utf8_encode($mensagemMatricCei);?>	</small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/matricula_cei/listar"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Matricula Cei</li>
									
									
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
									<a href="<?php echo $this->config->base_url();?>index.php/matricula_cei/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Nova Matricula Cei</a> 
									&nbsp;				  									
									<a id='export' href="#"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	&nbsp;
									</h4>
									<br>
									<?php
									
									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
									echo form_open('matricula_cei/listar', $attributes); 
									?>
									<select name="estadoListar" id="estado" class='procuraImovel'>				 
										<option value="0" selected>Escolha um estado</option>						
										<?php foreach($estados as $key => $estado){ ?>					 
										<option value="<?php echo $estado->uf ?>"><?php echo $estado->uf?></option>					   
										<?php					
										}								    				  
										?>				 
									</select>	
									 &nbsp;	
									<select name="municipioListar" id="cidade" class='procuraImovel'>				  
										<option value="0" selected>Escolha uma Cidade</option>	 
									</select>
									&nbsp;										

									<select name="idImovelListar" id="cei" class='procuraImovel'>				 
									<option value="0" selected>Todos</option>					 									
									</select>
	
								   					   
								 <button class="btn btn-primary" type="submit">Filtrar</button>
								 </form>
									&nbsp;
									
							<form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/matricula_cei/export' method='post'>							  
							<input type='hidden' id='id_imovel_export' name='id_imovel_export'>							 
							</form>																		  
							<form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/matricula_cei/export_mun' method='post'>								 
							<input type='hidden' id='id_mun_export' name='id_mun_export'>								 
							</form>																		 
							<form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/matricula_cei/export_est' method='post'>							 
							<input type='hidden' id='id_estado_export' name='id_estado_export'>						 
							</form>						  						 
							<form  id='limpar_filtro' action='<?php echo $this->config->base_url(); ?>index.php/matricula_cei/limpar_filtro' method='post'>						 
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
											      <th > Número Cei</th>
												  <th >Data Abertura</th>
												  <th >Região</th>
												  <th > Possui CND</th>
												  <th > Status da Obra</th>
												  <th >Tipo Empreitada</th>
												  <th >A&ccedil;&otilde;es</th>								  
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
												<th > Número Cei</th>
												  <th >Data Abertura</th>
												  <th >Região</th>
												  <th > Possui CND</th>
												  <th > Status da Obra</th>
												  <th >Tipo Empreitada</th>
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
												 if(empty($emitente->cnd)){	
													$cnd ='Nada Consta';
													$corCnd = '#990000';										 
												 }else{
													if($emitente->cnd == 1){
														$cnd ='Sim';
														$corCnd = '#000099';										
													}elseif($emitente->cnd == 2){
														$cnd ='N&atilde;o';
														$corCnd = '#000099';
													}elseif($emitente->cnd == 3){
														$cnd ='Pend&ecirc;ncia';
														$corCnd = '#000099';
													}else{

														$cnd ='Nada Consta';
														$corCnd = '#990000';
													}
												}
											   if($emitente->status_obra == 1){											
												$statusObra = 'Aberta';
											   }else{											
												$statusObra = 'Encerrada';											
											   }																				
											   if($emitente->ativo == 1){											
												   $status="Ativo";											
												   $cor = '#009900';										
											   }else{											
												   $status="Inativo";											
												   $cor = '#CC0000';	
											   }
											 ?>
												 <tr>
												 <td >
													<?php  
													if( $cnd <> 'Nada Consta') {?>
														<a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/editar?id=<?php echo $emitente->id_cnd_obras; ?>"><?php echo $emitente->cei; ?></a>
													<?php  }else{?>
														<a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/cadastrar?id=<?php echo $emitente->id_cei; ?>"><?php echo $emitente->cei; ?></a>
													<?php  }?>											
												  </td>
												  <td ><?php echo $emitente->data_abertura; ?></td>
												  <td ><?php echo $emitente->descricao; ?></td>
												  <td ><?php echo $cnd; ?>  </td>
												  <td ><?php echo $statusObra; ?></td>
												  <td ><?php echo $emitente->empreitada; ?></td>
												  <td >
			  										<a href="<?php echo $this->config->base_url();?>index.php/matricula_cei/ativar?id=<?php echo $emitente->id_cei; ?>" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
													<a href="<?php echo $this->config->base_url();?>index.php/matricula_cei/editar?id=<?php echo $emitente->id_cei; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>										  
													<a href="<?php echo $this->config->base_url();?>index.php/matricula_cei/excluir?id=<?php echo $emitente->id_cei; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>	
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

