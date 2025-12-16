<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>		
<script type="text/javascript">
	$(document).ready(function(){
					 
	
	$( "#estado" ).change(function() {		
		var estado = $('#estado').val();					
			$.ajax({				
			url: "<?php echo $this->config->base_url(); ?>index.php/protesto/buscaCidade?estado=" + estado,				
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
			url: "<?php echo $this->config->base_url(); ?>index.php/protesto/buscaprotesto?id=" + estado+'&op=1',				
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
				url: "<?php echo $this->config->base_url(); ?>index.php/protesto/buscaprotesto?id=" + municipio+'&op=2',				
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
			
	$( "#export" ).click(function() {				var id = $('#imovel').val();					var municipio = $('#municipio').val();					var estado = $('#estado').val();								if((id == 0) && (municipio == 0) && (estado == 0))  {									$("#id_imovel_export").val(id);							$( "#export_imovel" ).submit();								}else{									if(id != 0){									$("#id_imovel_export").val(id);									$( "#export_imovel" ).submit();							}else{									if(municipio == 0){															$("#id_estado_export").val(estado);											$( "#export_estado" ).submit();									}else{												$("#id_mun_export").val(municipio);											$( "#export_mun" ).submit();									}							}					}		});		
			
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
                                <h1>Protesto <small>	<?php if(!empty($_SESSION['mensagemIptu'])){echo utf8_encode($_SESSION['mensagemIptu']);}?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Protesto</li>
									
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
									<a href="<?php echo $this->config->base_url();?>index.php/protesto/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Novo Protesto</a> 
									&nbsp;				  
									<a id='export'  href="#"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	&nbsp;
									</h4>
									<?php
									$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
									echo form_open('protesto/listar', $attributes); 
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
										<?php foreach($notificacoes as $key => $not){ ?>					 
										<option value="<?php echo $not->id ?>"><?php echo $not->razao_social?></option>					   
										<?php					
										}								    				  
										?>											
									</select>						   					   
								 <button class="btn btn-primary" type="submit">Filtrar</button>
								 </form>
									&nbsp;
									
								<form  id='export_imovel' action='<?php echo $this->config->base_url(); ?>index.php/protesto/export' method='post'>							
								  <input type='hidden' id='id_imovel_export' name='id_imovel_export'>							

								 </form>												
								 <form  id='export_mun' action='<?php echo $this->config->base_url(); ?>index.php/protesto/export_mun' method='post'>	
									<input type='hidden' id='id_mun_export' name='id_mun_export'>							

								 </form>												
								 <form  id='export_estado' action='<?php echo $this->config->base_url(); ?>index.php/protesto/export_est' method='post'>
									  <input type='hidden' id='id_estado_export' name='id_estado_export'>							

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
												<th>Nome Loja</th>                                                <th>Empresa Notificada</th>                                                <th>Esfera</th>                                                <th>Nº do processo/Notificação</th>												<th>Competência</th>												<th>Descrição da solicitação</th>                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Nome Loja</th>
                                                <th>Empresa Notificada</th>
                                                <th>Esfera</th>
                                                <th>Nº do processo/Notificação</th>
												<th>Competência</th>
												<th>Descrição da solicitação</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($dados) ? '1' : '0';			
										if($isArray == 0){ ?>
										<?php 	
								 }else{								 
									 foreach($dados as $key => $linha){ 	
										
									 ?>
										 <tr>
												<td ><?php echo $linha->nome; ?></td>								 
												<td ><?php echo $linha->nome_empresa_notificada; ?></td>								 
												<td ><?php echo $linha->descricao_esfera; ?></td>	
												<td ><?php echo $linha->numero_processo; ?></td>																									<td ><?php echo $linha->ano_competencia; ?></td>																									<td ><?php echo $linha->descricao_solicitacao; ?></td>	
												<td>  
													<a href="<?php echo $this->config->base_url();?>index.php/protesto/upload?id=<?php echo $linha->id_notif; ?>" class="btn btn-success btn-xs" title='Upload de Arquivo'><i class="fa fa-upload"></i></a>
													<a href="<?php echo $this->config->base_url();?>index.php/protesto/editar?id=<?php echo $linha->id_notif; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>                                      																										<a href="<?php echo $this->config->base_url();?>index.php/protesto/ver?id=<?php echo $linha->id_notif; ?>" class="btn btn-primary btn-xs" title='Ver'><i class="fa fa-eye"></i></a>                                      
													
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

