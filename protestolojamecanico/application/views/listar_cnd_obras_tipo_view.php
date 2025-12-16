<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript">      
$(document).ready(function(){	
	var cidadeBD = $('#cidadeBD').val();	
	var estadoBD = $('#estadoBD').val();	
	var idCNDOBD = $('#idCNDOBD').val();	
	var tipo = $('#tipo').val();		
	
				
	$( "#limpar" ).click(function() {		
	location.reload();	});		
	$('#estado').change(function(){			
	var estado = $("#estado").val();		
	$.ajax({				
		url: "<?php echo $this->config->base_url(); ?>index.php/cnd_obras/buscaCidade?estado=" + estado+"&tipo="+tipo,					
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
		url: "<?php echo $this->config->base_url(); ?>index.php/cnd_obras/buscaCeiByEstado?estado=" + estado+"&tipo="+tipo,					
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
		 			
	});		
			
	$('#cidade').change(function(){			
		var cidade = $("#cidade").val();		
		$.ajax({				
		url: "<?php echo $this->config->base_url(); ?>index.php/cnd_obras/buscaCeiByCidade?cidade=" + cidade+"&tipo="+tipo,					
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
			 				
	});	
	$( "#export" ).click(function() {			
			var id = $('#cei').val();						
			var municipio = $('#cidade').val();						
			var estado = $('#estado').val();							
			if((id == 0) && (municipio == 0) && (estado == 0))  {
				$("#id_imovel_export").val(id);							
				$( "#export_imovel" ).submit();								
			}else{									
				if(id !== 0){									
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
			});
			</script>   

		<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Cnd Obras <small>	</small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/dados_agrupados"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Cnd Obras</li>
									
									
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
									<?php
									
									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
									echo form_open('cnd_obras/'.$CNDObras, $attributes); 
									?>
									<select name="estadoListar" id="estado" required="" class='procuraImovel'>				 					
									  <option value="0">Escolha um estado</option>												
									  <?php foreach($estados as $key => $estado){ ?>					  							
									  <option value="<?php echo $estado->estado ?>"><?php echo $estado->estado?></option>	
									  <?php } ?>				 				 
									</select>	
				  
									
									 &nbsp;	
									
								  <select name="municipioListar" id="cidade" required="" class='procuraImovel'>
								  <option value="0">Escolha uma cidade</option>												
								 
								  </select>
				  
									&nbsp;										

									<select name="idImovelListar" id="cei" class='procuraImovel'>				 
									<option value="0" selected>Todos</option>					 									
									</select>
									
										
									
								  </select>		
								   					   
								 <button class="btn btn-primary" type="submit">Filtrar</button>
								 </form>
									&nbsp;
									
							<form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/cnd_obras/export' method='post'>							  
						  <input type='hidden' id='id_imovel_export' name='id_imovel_export'>								  
						  <input type='hidden' id='tipo' name='tipo' value='<?php echo$tipo ?>'>							  						  
						  </form>																		 
						  <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/cnd_obras/export_mun' method='post'>								  
						  <input type='hidden' id='id_mun_export' name='id_mun_export'>									  
						  <input type='hidden' id='tipo' name='tipo' value='<?php echo$tipo ?>'>	
						  </form>																		  
						  <form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/cnd_obras/export_est' method='post'>							  
						  <input type='hidden' id='id_estado_export' name='id_estado_export'>							 
						  <input type='hidden' id='tipo' name='tipo' value='<?php echo$tipo ?>'>
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
													<th>Nome Im&oacute;vel/Loja</th>
												  <th>N&uacute;mero Cei</th>
												  <th>Possui CND</th>
												  <th>Data Vecto/Verifica&ccedil;&atilde;o</th>
												  <th>A&ccedil;&otilde;es</th>     												  
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
												  <th>Nome Im&oacute;vel/Loja</th>
												  <th>N&uacute;mero Cei</th>
												  <th>Possui CND</th>
												  <th>Data Vecto/Verifica&ccedil;&atilde;o</th>
												  <th>A&ccedil;&otilde;es</th>								  
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($cnds) ? '1' : '0';			
										if($isArray == 0){ ?>
										<?php 	
										}else{			
											  foreach($cnds as $key => $emitente){ 	
												 if(empty($emitente->possui_cnd)){												
													$cnd ='Nada Consta';											
													$corCnd = '#990000';													
													$data = '00/00/0000';										 
												  }else{											
													  if($emitente->possui_cnd == 1){												
														  $cnd ='Sim';												
														  $corCnd = '#000099';													
														  $dataVArr = explode("-",$emitente->data_vencto);
														  $data = 	$dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
														  $link = 'cnd_obras/ver?id='. $emitente->id_cnd;	
													  }elseif($emitente->possui_cnd == 2){												
														  $cnd ='N&atilde;o';												
														  $corCnd = '#000099';												
														  $dataVArr = explode("-",$emitente->data_vencto);
														  $data = 	$dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
														  $link = 'cnd_obras/ver?id='. $emitente->id_cnd;
													  }elseif($emitente->possui_cnd == 3){												
														  $cnd ='Pend&ecirc;ncia';												
														  $corCnd = '#000099';												
														  $dataVArr = explode("-",$emitente->data_pendencias);
														  $data = 	$dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
														  $link = 'cnd_obras/ver?id='. $emitente->id_cnd;
													  }else{												
													  $cnd ='Nada Consta';												
													  $corCnd = '#990000';												
													  $data =  '00/00/0000';											
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
												 <td> <?php echo $emitente->imovel; ?> </td>		
												  <td ><a href="<?php echo $this->config->base_url();?>index.php/<?php echo $link;?>"><?php echo $emitente->cei; ?></a></td>
												  <td ><?php echo $cnd; ?></td>
												  <td ><?php echo $data; ?> </td>
												  <td >
													<?php if($emitente->possui_cnd == 3 ){?>
													  <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/upload_cnd_pend?id=<?php echo $emitente->id_cnd; ?>" class="btn btn-danger btn-xs" title='Upload Pend&ecirc;ncia'><i class="fa fa-upload"></i></a>
													  <?php }else{?>												
													  <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/upload_cnd?id=<?php echo $emitente->id_cnd; ?>" class="btn btn-success btn-xs" title='Upload CND'><i class="fa fa-upload"></i></a>
													  <?php }?>		
													  <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/editar?id=<?php echo $emitente->id_cnd; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>
													<?php if($visitante == 0){ ?>	
													  <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/ativar?id=<?php echo $emitente->id_cnd; ?>" class="btn btn-success btn-xs" title='Ativar'><i class="fa fa-check"></i></a>										 

													  <a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/excluir?id=<?php echo $emitente->id_cnd; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>												  
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

