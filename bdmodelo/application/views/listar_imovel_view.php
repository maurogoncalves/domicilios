<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>		
		
<script type="text/javascript">
	$(document).ready(function(){
		
	
	 
	$( "#estado" ).change(function() {	
		var estado = $('#estado').val();		
			$.ajax({		
				url: "<?php echo $this->config->base_url(); ?>index.php/imovel/buscaCidade?estado=" + estado,		
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
				url: "<?php echo $this->config->base_url(); ?>index.php/imovel/buscaImovelByEstado?id=" + estado,		
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
			url: "<?php echo $this->config->base_url(); ?>index.php/imovel/buscaImovel?id=" + municipio,				
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
	
	
	var cidadeBD = $('#cidadeBD').val();			
	var estadoBD = $('#estadoBD').val();			
	var idIMBD = $('#idIMBD').val();
	$('#estado').val(estadoBD);		
		
	

	if(estadoBD !=='0'){
		$.ajax({		
				url: "<?php echo $this->config->base_url(); ?>index.php/imovel/buscaCidade?estado=" + estadoBD,		
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
				url: "<?php echo $this->config->base_url(); ?>index.php/imovel/buscaImovelByEstado?id=" + estadoBD,		
				type : 'GET', /* Tipo da requisição */ 		
				contentType: "application/json; charset=utf-8",       	
				dataType: 'json', /* Tipo de transmissão */		
				success: function(data){				
						if (data == undefined ) {				
							console.log('Undefined');			
						} else {				
							$('#imovel').html(data);
							$('#imovel').val(idIMBD);			
						}		
					}	 
				});
	}
	
	if(cidadeBD !=='0'){
			$.ajax({				
			url: "<?php echo $this->config->base_url(); ?>index.php/imovel/buscaImovel?id=" + cidadeBD,				
			type : 'GET', /* Tipo da requisição */ 				
			contentType: "application/json; charset=utf-8",	        	
			dataType: 'json', /* Tipo de transmissão */				
				success: function(data){						
				if (data == undefined ) {						
					console.log('Undefined');					
				} else {						
					$('#imovel').html(data);
					$('#imovel').val(idIMBD);			
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
                                <h1>Imóveis </h1>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Imóveis</li>
									
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
									<a href="<?php echo $this->config->base_url();?>index.php/imovel/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Novo Imóvel</a> 
									&nbsp;				  
									<a  href="<?php echo $this->config->base_url();?>index.php/imovel/export"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>				&nbsp;				 
									</h4>
									<br>
									
									<input type='hidden' id='cidadeBD' name='municipioListar' value='<?php echo$idImovelMunBD ?>'>	
									<input type='hidden' id='estadoBD' name='estadoListar' value='<?php echo$idImovelUFBD ?>'>	
									<input type='hidden' id='idIMBD' name='idImovelListar' value='<?php echo$idImovelBD ?>'>	
									<?php
									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
									echo form_open('imovel/listar', $attributes); 
									?>
									<select name="estadoListar" id="estado" required="" class='procuraImovel'>				 
										<option value="0" selected>Escolha um estado</option>						
										<?php foreach($estados as $key => $estado){ ?>					 
										<option value="<?php echo $estado->uf ?>"><?php echo $estado->uf?></option>					   
										<?php					
										}								    				  
										?>				 
									</select>	
									 &nbsp;	
									<select name="municipioListar" id="municipio" required="" class='procuraImovel'>				  
										<option value="0" selected>Escolha uma Cidade</option>	
										<?php foreach($cidades as $key => $cidade){ ?>					 
										<option value="<?php echo $cidade->cidade ?>"><?php echo $cidade->cidade?></option>					   
										<?php					
										}								    				  
										?>												
									</select>
									&nbsp;										

									<select name="idImovelListar" id="imovel" required="" class='procuraImovel'>				 
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
                                                <th>Situação</th>
                                                <th>Área Total</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
												<th>Nome Imóvel</th>
                                                <th>Situação</th>
                                                <th>Área Total</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 												$isArray =  is_array($imoveis) ? '1' : '0';														if($isArray == 0){ 
											}else{								 
												foreach($imoveis as $key => $emitente){ 	
												 if($emitente->combo >= 2){										
													$combo ='Sim';									
												 }else{										
													$combo ='Não';									
												 }	
												if($emitente->ativo == 0){													$ativo = "Ativo";												}else{													$ativo = "Inativo";												}										?>
									  <tr>
									  <td><?php echo ($emitente->nome); ?></td>
									  <td><?php echo $emitente->descricao; ?></td>
									  <td><?php echo $emitente->area_total; ?></td>

									  <td>
										<a href="<?php echo $this->config->base_url();?>index.php/imovel/emitente_imovel?id=<?php echo $emitente->id; ?>" class="btn btn-success btn-xs" title='Empresas'><i class="fa fa-bars"></i></a>									  
										<a href="<?php echo $this->config->base_url();?>index.php/imovel/editar?id=<?php echo $emitente->id; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>
										
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
