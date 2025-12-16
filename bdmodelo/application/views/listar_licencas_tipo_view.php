<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var tipo = $('#tipo').val();	
	
	$( "#limpar" ).click(function() {
		$("#limpar_filtro").submit();	
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
				$("#export_tipo").submit();			
			}	
	});	
	
	$( "#tipo_licenca" ).change(function() {	
		var tipo_licenca = $('#tipo_licenca').val();					
			$.ajax({				
				url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaLicencaByTipo?id=" + tipo_licenca+"&tipo="+tipo,					
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
			url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaLicencaByEmitente?id=" + emitente+"&tipo="+tipo,				
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
				url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaLicencaByCidade?id=" + cidade+"&tipo="+tipo,		
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
			url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaEmitenteByCidade?cidade=" + cidade+"&tipo="+tipo,					
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
			url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaCidade?estado=" + estado+"&tipo="+tipo,						
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
			url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaEmitente?estado=" + estado+"&tipo="+tipo,					
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
			url: "<?php echo $this->config->base_url(); ?>index.php/licencas/buscaLicenca?id=" + estado+"&tipo="+tipo,					
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
</script>	      
<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Lojas X Licenças <small> <?php if(!empty($_SESSION['mensagemCNDEST'])){echo utf8_encode($_SESSION['mensagemCNDEST']);}?>
								</small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/cnd_mob/dados_agrupados"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Licenças</li>
									
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
									echo form_open('licencas/'.$licMod, $attributes); 
									?>
								  <select name="estadoListar" id="estado" required="" class='procuraImovel'>				  
									<option value="0">Estado</option>
										<?php foreach($estados as $key => $estado){ ?>					 
											<option value="<?php echo $estado->estado ?>"><?php echo $estado->estado?></option>	
										<?php					
										}								    				  
										?>				  
									</select>		
									 &nbsp;	
									<select name="municipioListar" id="municipio" class='procuraImovel'>				  
										<option value="0" selected>Escolha uma Cidade</option>	 
									</select>
									&nbsp;										

									<select name="idImovelListar" id="emitente" class='procuraImovel'>				 
									<option value="0" selected>Todos</option>					 									
									</select>
								   	&nbsp;		
									<select name="tipo_licenca" id="tipo_licenca" required="" class='procuraImovel'>
									<option value="0">Tipo</option>					  
									<?php foreach($tipos_licencas as $key => $licenca){ ?>				 
									<option value="<?php echo $licenca->id ?>"><?php echo $licenca->descricao?></option>	
									<?php				  
									}								  				  
									?>
									</select>									
									&nbsp;
								 <button class="btn btn-primary" type="submit">Filtrar</button>
								 </form>
									&nbsp;
									
					     <form  id='export_emitente' action='<?php echo $this->config->base_url(); ?>index.php/licencas/export' method='post'>
						  <input type='hidden' id='id_emitente_export' name='id_emitente_export'>													
							<input type='hidden' id='tipo' name='tipo' value='<?php echo$tipo ?>'>	
						  </form>																
						  <form  id='export_tipo' action='<?php echo $this->config->base_url(); ?>index.php/licencas/export_tipo' method='post'>
						  <input type='hidden' id='id_tipo_export' name='id_tipo_export'>
							<input type='hidden' id='tipo' name='tipo' value='<?php echo$tipo ?>'>							  
						  </form>												
						  <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/licencas/export_mun' method='post'>	
						  <input type='hidden' id='id_mun_export' name='id_mun_export'>
							<input type='hidden' id='tipo' name='tipo' value='<?php echo$tipo ?>'>							  
						  </form>												
						  <form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/licencas/export_est' method='post'>
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
												<th>Nome Imóvel</th>
                                                <th>Descrição</th>
                                                <th>Data Vecto</th>
												<th>Cidade/Estado</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
												<th>Nome Imóvel</th>
                                                <th>Descrição</th>
                                                <th>Data Vecto</th>
												<th>Cidade/Estado</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($licencas) ? '1' : '0';			
										if($isArray == 0){ ?>
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
											  <td > <?php echo $licenca->nome_fantasia; ?> </td>		 
											  <td ><?php echo $licenca->descricao; ?></td>
											  <td ><?php echo $dataFormatada; ?></td>
											  <td ><?php echo $licenca->cidade.'&nbsp;'.$licenca->estado; ?></td>
											  <td > 
												<?php if($visitante == 0){ ?>
											  <a href="<?php echo $this->config->base_url();?>index.php/licencas/editar_loja_licenca?id_licenca=<?php echo $licenca->id_licenca; ?>&id_loja=<?php echo $licenca->id_loja; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>										  
											  <a href="<?php echo $this->config->base_url();?>index.php/licencas/inativar?id=<?php echo $licenca->id_licenca; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>
											  <a href="<?php echo $this->config->base_url();?>index.php/licencas/ativar?id=<?php echo $licenca->id_licenca; ?>" class="btn btn-primary btn-xs" title='Ativar'><i class="fa fa-check-square-o"></i></a>									  
											  <?php } ?>
											  </td>									  
											  </tr>									  
											  <?php									  
											  }								  
										  }								  								  
										  ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- End .panel -->  
                        </div><!--end .col-->
                    </div><!--end .row-->


                </div> 
            </div>

