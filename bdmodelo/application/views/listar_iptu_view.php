<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>		
<script type="text/javascript">
	$(document).ready(function(){
					 
	
	$( "#estado" ).change(function() {		
		var estado = $('#estado').val();					
			$.ajax({				
			url: "<?php echo $this->config->base_url(); ?>index.php/iptu/buscaCidade?estado=" + estado,				
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
			url: "<?php echo $this->config->base_url(); ?>index.php/iptu/buscaImovelByEstado?id=" + estado,				
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
				url: "<?php echo $this->config->base_url(); ?>index.php/iptu/buscaImovel?id=" + municipio,				
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
			
			var anoEscolhido = $('#ano').val();	
			if((id == 0) && (municipio == 0) && (estado == 0))  {
				$("#anoEscolhidoIm").val(anoEscolhido);			
				$("#id_imovel_export").val(id);			
				$( "#export_imovel" ).submit();		
			}else{				
				if(id !== 'X'){				
					$("#id_imovel_export").val(id);				
					$("#anoEscolhidoIm").val(anoEscolhido);				
					$("#export_imovel").submit();			
				}else{				
					if(municipio == 'X'){						
						$("#id_estado_export").val(estado);					
						$("#anoEscolhidoEst").val(anoEscolhido);					
						$( "#export_estado" ).submit();									
					}else{					
						$("#id_mun_export").val(municipio);					
						$("#anoEscolhidoMun").val(anoEscolhido);					
						$("#export_mun").submit();				
					}			
				}			
			}
				
			});	
			
		$( "#limpar" ).click(function() {		
			$("#limpar_filtro").submit();	
		});	
		
		
	var cidadeBD = $('#cidadeBD').val();			
	var estadoBD = $('#estadoBD').val();
	var idIpBD = $('#idIpBD').val();
	
	$('#estado').val(estadoBD);		
		
		
	
	if(estadoBD !=='0'){
		$.ajax({				
			url: "<?php echo $this->config->base_url(); ?>index.php/iptu/buscaCidade?estado=" + estadoBD,				
			type : 'GET', /* Tipo da requisição */ 				
			contentType: "application/json; charset=utf-8",	        	
			dataType: 'json', /* Tipo de transmissão */				
			success: function(data){						
				if (data == undefined ) {						
					console.log('Undefined');					
				} else {						
					$('#municipio').html(data);
					$('#municipio').val(cidadeBD);		
				}										
			}			 
		}); 				
		$.ajax({				
			url: "<?php echo $this->config->base_url(); ?>index.php/iptu/buscaImovelByEstado?id=" + estadoBD,				
			type : 'GET', /* Tipo da requisição */ 				
			contentType: "application/json; charset=utf-8",	        	
			dataType: 'json', /* Tipo de transmissão */				
			success: function(data){						
				if (data == undefined ) {						
					console.log('Undefined');					
				} else {						
					$('#imovel').html(data);	
					$('#imovel').val(idIpBD);		
				}										
			}			 
		}); 	
	}	
	
	if(cidadeBD !=='0'){
		$.ajax({				
				url: "<?php echo $this->config->base_url(); ?>index.php/iptu/buscaImovel?id=" + cidadeBD,				
				type : 'GET', /* Tipo da requisição */ 				
				contentType: "application/json; charset=utf-8",	        	
				dataType: 'json', /* Tipo de transmissão */				
				success: function(data){						
					if (data == undefined ) {						
						console.log('Undefined');					
					} else {						
					$('#imovel').html(data);
					$('#imovel').val(idIpBD);						
					}										
				}			 
			}); 		
	}	
	
	
	
	});		
	
	</script>	      
	


	
				
	 <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Iptu <small>	<?php if(!empty($_SESSION['mensagemIptu'])){echo utf8_encode($_SESSION['mensagemIptu']);}?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Iptu</li>
									
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
									<a href="<?php echo $this->config->base_url();?>index.php/iptu/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Novo Iptu</a> 
									&nbsp;				  
									<a id='export'  href="#"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	&nbsp;
									</h4>
									<br>
															  
									<input type='hidden' id='cidadeBD' name='cidadeBD' value='<?php echo$cidadeBD ?>'>	
									<input type='hidden' id='estadoBD' name='estadoBD' value='<?php echo$estadoBD ?>'>	
									<input type='hidden' id='idIpBD' name='idIpBD' value='<?php echo$idImIpBD ?>'>
									<?php
									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
									echo form_open('iptu/listar', $attributes); 
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
									
									&nbsp;							  
								  <select name="ano" id="ano"  class='procuraImovel'>							 
								  <option value="0">Filtre por ano</option>									
								  <?php foreach($anos as $key => $ano){ ?>								  
								  <option value="<?php echo $ano ?>">
									<?php echo $ano?></option>									
									<?php								
								   }								  							   
								   ?>							  
								   </select>	
									&nbsp;
								  <select name="status" id="status"  class='procuraImovel'>
								   <option value="0">Filtre por Status</option>	
								   <option value="1">Sim</option>	
								   <option value="2">N&atilde;o</option>	
								   <option value="3">Pend&ecirc;ncia</option>	
								   <option value="4">Nada Consta</option>										
								  </select>									   					   
								 <button class="btn btn-primary" type="submit">Filtrar</button>
								 </form>
									&nbsp;
									
								<form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/iptu/export' method='post'>							
								  <input type='hidden' id='id_imovel_export' name='id_imovel_export'>							
								  <input type='hidden' id='anoEscolhidoIm' name='anoEscolhido'>													
								 </form>												
								 <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/iptu/export_mun' method='post'>	
									<input type='hidden' id='id_mun_export' name='id_mun_export'>							
									<input type='hidden' id='anoEscolhidoMun' name='anoEscolhido'>													
								 </form>												
								 <form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/iptu/export_est' method='post'>
									  <input type='hidden' id='id_estado_export' name='id_estado_export'>							
									  <input type='hidden' id='anoEscolhidoEst' name='anoEscolhido'>													
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
                                                <th>Info. Incl.</th>
                                                <th>Valor</th>
												<th>Ano/Ref</th>
												<th>CND</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Nome Imóvel</th>
                                                <th>Inscrição</th>
                                                <th>Info. Incl.</th>
                                                <th>Valor</th>
												<th>Ano/Ref</th>
												<th>CND</th>
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
										if($iptu->ano_ref <> date('Y')){										
											$cnd ='Nada Consta';										
											$corCnd = '#990000';									 
										}else{										 
											if(empty($iptu->cnd)){												
												$cnd ='Nada Consta';											
												$corCnd = '#990000';										 										 
											}else{											
												if($iptu->cnd == 1){												
													$cnd ='Sim';												
													$corCnd = '#000099';																					
												}elseif($iptu->cnd == 2){												
													$cnd ='Não';												
													$corCnd = '#000099';											
												}else{												
													$cnd ='Pendência';												
													$corCnd = '#000099';											
												}																			
											}									
										}
									 ?>
										 <tr>
										<?php 								 
											$anoAtual = date('Y');								 
												if($iptu->ano_ref < $anoAtual){ ?>                                  
												<td >																	
													<?php if($iptu->cnd){?>											
													<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/editar?id=<?php echo $iptu->id_cnd; ?>"><?php echo $iptu->nome; ?></a>									
													<?php 										
													}else{									
													?>										
													<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/cadastrar?id=<?php echo $iptu->id_iptu; ?>"><?php echo $iptu->nome; ?></a>
													<?php 											
													} ?>								 
												</td>								 
												<?php }else{?>								 
												<td >																	
													<?php if($iptu->cnd){?>											
													<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/editar?id=<?php echo $iptu->id_cnd; ?>"><?php echo $iptu->nome; ?></a>									
													<?php 										
													}else{									
													?>										
													<a href="<?php echo $this->config->base_url();?>index.php/cnd_imob/cadastrar?id=<?php echo $iptu->id_iptu; ?>"><?php echo $iptu->nome; ?></a>
													<?php 											
													} ?>								 
												</td>								 
												<?php }?>
												<td >									
													<?php if(!empty($iptu->capa)){?>										
													<a href="<?php echo $this->config->base_url();?>index.php/iptu/ver?id=<?php echo $iptu->id_iptu; ?>"><?php echo $iptu->inscricao; ?></a>									
													<?php }else{?>											
													<?php echo $iptu->inscricao; ?>									
													<?php }?>									 
												</td>
												<td ><?php echo $iptu->descricao; ?></td>								 
												<td ><?php echo $iptu->valor; ?></td>								 
												<td ><?php echo $iptu->ano_ref; ?></td>	
												<td style='color:<?php echo $corCnd; ?>'> 	<?php echo $cnd; ?>	</td>									                                     
												<td>  
													<a href="<?php echo $this->config->base_url();?>index.php/iptu/upload_iptu?id=<?php echo $iptu->id_iptu; ?>" class="btn btn-success btn-xs" title='Upload de Arquivo'><i class="fa fa-upload"></i></a>
													<a href="<?php echo $this->config->base_url();?>index.php/iptu/editar?id=<?php echo $iptu->id_iptu; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>                                      													<?php if($iptu->ano_ref <> date("Y")){ ?>																													<a href="<?php echo $this->config->base_url();?>index.php/iptu/virar?id=<?php echo $iptu->id_iptu; ?>" class="btn btn-primary btn-xs" title='Virar Ano'><i class="fa fa-circle-o-notch"></i></a>                                      													<?php } ?>																
													<?php if($visitante == 0){ ?>
														<a href="<?php echo $this->config->base_url();?>index.php/iptu/inativar?id=<?php echo $iptu->id_iptu; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>									  
														<a href="<?php echo $this->config->base_url();?>index.php/iptu/ativar?id=<?php echo $iptu->id_iptu; ?>" class="btn btn-primary btn-xs" title='Ativar'><i class="fa fa-check-square-o"></i></a>                                  
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

