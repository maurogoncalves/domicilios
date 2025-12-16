<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>		
<script type="text/javascript">
	$(document).ready(function(){
			var tipo = <?php echo $tipo?>;				var situacao = <?php echo $situacao?>;				
			$( "#estado" ).change(function() {		
				var estado = $('#estado').val();					
				$.ajax({				
					url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaCidade?estado=" + estado+"&tipo="+tipo+"&situacao="+situacao,				
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
					url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaInscricaoByEstado?id=" + estado+"&tipo="+tipo+"&situacao="+situacao,				
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
				
			$( "#municipio" ).change(function() {		
				var municipio = $('#municipio').val();								
				$.ajax({				
					url: "<?php echo $this->config->base_url(); ?>index.php/cnd_imob/buscaImovel?id=" + municipio+"&tipo="+tipo+"&situacao="+situacao,							
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
				$("#limpar_filtro").submit();
			});	
			
		
		
		
		
		
		
		
		});		
	

			
		
		</script>	     


		<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>CND Imobiliária <small>	<?php if(!empty($_SESSION['mensagemCNDIMOB'])){echo utf8_encode($_SESSION['mensagemCNDIMOB']);}?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/dados_agrupados"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de CND Imobiliária</li>
									
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
									<a id='export' href="#"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	&nbsp;
									</h4>
									<br>
									
									<input type='hidden' id='cidadeBD' name='' value='<?php echo$cidadeBD ?>'>	
									<input type='hidden' id='estadoBD' name='' value='<?php echo$estadoBD ?>'>	
									<input type='hidden' id='idCNDIBD' name='' value='<?php echo$idCNDIBD ?>'>	
																
									<?php
									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
									echo form_open('cnd_imob/listarVigentes', $attributes); 
									?>								   <input type='hidden' id='situacao' name='situacao' value='<?php echo$situacao ?>'>
									<select name="estadoListar" id="estado" class='procuraImovel'>				 
										<option value="0" selected>Escolha um estado</option>						
										<?php foreach($estados as $key => $estado){ ?>					 
										<option value="<?php echo $estado->uf ?>"><?php echo $estado->uf?></option>					   
										<?php					
										}								    				  
										?>				 
									</select>	
									 &nbsp;	
									<select name="municipioListar" id="municipio" class='procuraImovel'>				  
										<option value="0" selected>Escolha uma Cidade</option>	
										<?php foreach($cidades as $key => $cidade){ ?>					 
										<option value="<?php echo $cidade->cidade ?>"><?php echo $cidade->cidade?></option>					   
										<?php					
										}								    				  
										?>												
									</select>
									&nbsp;										

									<select name="idImovelListar" id="imovel" class='procuraImovel'>				 
									<option value="0" selected>Todos</option>
										<?php foreach($imoveis as $key => $im){ ?>					 
										<option value="<?php echo $im->id ?>"><?php echo $im->nome?></option>					   
										<?php					
										}								    				  
										?>											
									</select>
								   					   
								 <button class="btn btn-primary" type="submit">Filtrar</button>
								 </form>
									&nbsp;
									
								<form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/cnd_imob/export' method='post'>							
								  <input type='hidden' id='id_imovel_export' name='id_imovel_export'>	
								  <input type='hidden' id='tipo' name='possuiCnd' value='<?php echo$tipo ?>'>									 <input type='hidden' id='situacao' name='situacao' value='<?php echo$situacao ?>'>
								 </form>												
								 <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/cnd_imob/export_mun' method='post'>	
								  <input type='hidden' id='id_mun_export' name='id_mun_export'>	
								  <input type='hidden' id='tipo' name='possuiCnd' value='<?php echo$tipo ?>'>										<input type='hidden' id='situacao' name='situacao' value='<?php echo$situacao ?>'>								  

								 </form>												
								 <form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/cnd_imob/export_est' method='post'>
									  <input type='hidden' id='id_estado_export' name='id_estado_export'>							
									  <input type='hidden' id='tipo' name='possuiCnd' value='<?php echo$tipo ?>'>											<input type='hidden' id='situacao' name='situacao' value='<?php echo$situacao ?>'>	
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
                                                <th>Nome Imóvel</th>
                                                <th>Inscrição</th>
                                                <th>Possui CND?</th>
                                                <th>Data Vecto/Verificação</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
												<th>Nome Imóvel</th>
                                                <th>Inscrição</th>
                                                <th>Possui CND?</th>
                                                <th>Data Vecto/Verificação</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($iptus) ? '1' : '0';			
										if($isArray == 0){ ?>
										<?php 	
										}else{								 
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
												 <tr>
												 <td ><a href="#"><?php echo $iptu->nome; ?></a></td>	
												 <td >								  									
												<?php 										
												if(($iptu->possui_cnd == 1 )) {											
													if(!empty($iptu->arquivo)){?>												
														<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/ver?id=<?php echo $iptu->id_cnd; ?>"><?php echo $iptu->inscricao; ?></a>											
													<?php }else{?>													
														<?php echo $iptu->inscricao; ?>											
													<?php }										
												}else{											
													if(!empty($iptu->arquivo_pendencias)){?>											
														<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/ver?id=<?php echo $iptu->id_cnd; ?>"><?php echo $iptu->inscricao; ?></a>											
													<?php }else{?>													
													<?php echo $iptu->inscricao ?>											
													<?php }} ?>																	 
												</td>	
												<td ><?php echo $possui; ?></td>
												<td ><?php echo $dataV; ?></td>	
												<td >   
												<?php 										
													if( ($iptu->possui_cnd == 1 )) {?>										
														<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/upload_cnd?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-success btn-xs" title='Upload de CND'><i class="fa fa-upload"></i></a>									  										
												<?php }else{?>											
															<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/upload_cnd_pend?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-danger btn-xs" title='Upload de Pendência'><i class="fa fa-upload"></i></a>									  										 
												<?php }?> 
												<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/editar?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>                                      
												<?php if($visitante == 0){ ?>		
                                     
																
																<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/inativar?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>									  
																<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/ativar?id=<?php echo $iptu->id_cnd; ?>" class="btn btn-primary btn-xs" title='Ativar'><i class="fa fa-check-square-o"></i></a>                                  
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

