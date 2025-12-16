<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script> 
<script type="text/javascript">
jQuery(function($) {    
	$('.auto').autoNumeric('init');	});

	$(document).ready(function(){				
		$('input').keypress(function (e) {        
			var code = null;        
			code = (e.keyCode ? e.keyCode : e.which);                        
			return (code == 13) ? false : true;		
		});				
		
		$('#form').submit(function(event){		  
			if (form.checkValidity()) {			
				send.attr('disabled', 'disabled');		  
			}		
		});				
		


		$( "#id_estado" ).change(function() {				
			var id_estado = $('#id_estado').val();									
			$.ajax({					
				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaCidadeImByEstado?id_estado=" + id_estado,
				type : 'GET', /* Tipo da requisição */ 					
				contentType: "application/json; charset=utf-8",					
				dataType: 'json', /* Tipo de transmissão */					
				success: function(data){							
					if (data == undefined ) {							
						console.log('Undefined');						
					} else {							
						$('#id_cidade').html(data);						
					}
				}				 
			}); 				 				 
			
		
		});			
		 
		$( "#id_cidade" ).change(function() {	
			
				var id_cidade = $('#id_cidade').val();		
				$.ajax({					
					url: "<?php echo $this->config->base_url(); ?>index.php/notificacao/buscaLojasByCidadeNotificacao?id_cidade=" + id_cidade,
					type : 'GET', /* Tipo da requisição */ 					
					contentType: "application/json; charset=utf-8",					
					dataType: 'json', /* Tipo de transmissão */					
						success: function(data){							
							if (data == undefined ) {							
								console.log('Undefined');						
							} else {							
								$('#id_loja').html(data);						
							}												
						}				 
				});
		});	

$( "#data_atendimento" ).blur(function() {							
		var dtAtendi = $('#data_atendimento').val();					
		var dataEnvio = $('#data_envio').val();	
			if(dataEnvio == 0){					
				alert('Digite a Data de Envio');					
				//$('#vigencia').focus();				
			}

			if(dtAtendi == 0){					
				alert('Digite a Data de Atendimento');					
				//$('#vigencia').focus();				
			}
			
		$.ajax({					
			url: "<?php echo $this->config->base_url(); ?>index.php/notificacao/calcularDias?dtAtendi=" + dtAtendi +'&dataEnvio='+dataEnvio ,					
			type : 'GET', /* Tipo da requisição */ 					
			contentType: "application/json; charset=utf-8",					
			dataType: 'json', /* Tipo de transmissão */					
			success: function(data){							
				if (data == undefined ) {							
					console.log('Undefined');						
				} else {							
					if(data.status == 1){
						alert('Data Envio não pode ser maior que a data de atendimento');
					}else{
						$('#dias_atendimento').val(data.dias);							
					}
					//$('#dtfim').val(data);	
					//$('#dtvenc').val(data);		
					
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
                                <h1>Editar Notificação<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/notificacao/listar"><i class="fa fa-home"></i>Listar Notificação</a></li>
                                    <li class="active">Editar Notificação</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da Loja</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('notificacao/atualiza_noti', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                <div class="form-group">
									<label class="col-lg-2 control-label">Estado</label>
                                    <div class="col-lg-4">
										<select name="id_estado" id="id_estado" required=""  class='custom-select' style='width:350px;height:30px'>
											 <option value="0">Escolha</option>										  
											 <?php foreach($estados as $key => $estado){ ?>		
												<?php if($dados[0]->estado == $estado->uf){
														$selected='selected';
												}else{
														$selected='';
												}
												?>
												<option value="<?php echo $estado->uf ?>" <?php echo $selected?> ><?php echo $estado->uf?></option>											 
											 
											 <?php									  
											 }								  									 
											 ?>									
											 </select>     
                                    </div>
									<label class="col-lg-2 control-label">Cidade</label>
                                    <div class="col-lg-4">
										<select name="id_cidade" id="id_cidade" required=""  class='custom-select' style='width:320px;height:30px'>	
											<option value="0">Escolha</option>										
											<?php foreach($cidades as $key => $cidade){ ?>	
											<?php if($dados[0]->cidade == $cidade->cidade){
														$selected='selected';
												}else{
														$selected='';
												}
												?>	
											<option value="<?php echo $cidade->cidade ?>" <?php echo $selected?>><?php echo $cidade->cidade?></option>	
											<?php									  
											}								  									  
											?>								
											</select>      
										</div>									
                                </div>
                                <div class="form-group">
									<label class="col-lg-2 control-label">Loja</label>
                                    <div class="col-lg-4">
									<select name="id_loja" id="id_loja" required=""  class='custom-select' style='width:350px;height:30px'>
										<option value="0">Escolha</option>										 
										<?php foreach($lojas as $key => $loja){ ?>
											<?php if($dados[0]->id_loja == $loja->id_loja){
													$selected='selected';
											}else{
													$selected='';
											}
											?>													
										<option value="<?php echo $loja->id_loja ?>" <?php echo $selected?>><?php echo $loja->razao_social?></option>		
										<?php									  
										}								  									  
										?>									
										</select>          
                                    </div>	

									<label class="col-sm-2 control-label">Nome da empresa</label>
										<div class="col-lg-4">
											<input type="text"  name='nome_empresa' id='nome_empresa' class="form-control"  required="" value='<?php echo $dados[0]->nome_empresa_notificada; ?>'> 
										</div>									
									</div>
								
                                <div class="form-group">
								
								
								
									<label class="col-lg-2 control-label">Data da Ciência da Notificação</label>
                                    <div class="col-lg-4">
									<input type="text" id='data_ciencia' name='data_ciencia' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo $dados[0]->data_ciencia_notificacao_br; ?>'>  
                                    </div>
									
									<label class="col-lg-2 control-label">Esfera</label>
                                    <div class="col-lg-2">
									<select name="esfera" id="esfera" required=""  class='custom-select' style='width:350px;height:30px'>	
									<option value="0">Escolha</option>								  
									<?php foreach($esferas as $key => $esfera){ ?>	
										<?php if($dados[0]->id_esfera == $esfera->id){
												$selected='selected';
										}else{
												$selected='';
											}
										?>										
									<option value="<?php echo $esfera->id ?>" <?php echo $selected?>><?php echo $esfera->descricao_esfera?></option>	
									<?php								  
									}								  							 
									?>								
									</select>   
									
									</div>
									
                                </div>	

                                <div class="form-group">
									<label class="col-lg-2 control-label">Ano Competência</label>
                                    <div class="col-lg-2"><input type="text" name='ano_competencia' id='ano_competencia'  placeholder="Competência" class="form-control" data-masked="" data-inputmask="'mask': '9999' " value='<?php echo $dados[0]->competencia; ?>'  > 
                                    </div>
									<label class="col-lg-4 control-label">Nº do processo/Notificação</label>
                                    <div class="col-lg-4"><input type="text" name='numero_processo' id='numero_processo'  placeholder="Nº do processo/Notificação" class="form-control" value='<?php echo $dados[0]->numero_processo; ?>'  > 
                                    </div>
									
                                </div>	
		
                                <div class="form-group">
									<label class="col-lg-2 control-label">Descrição da solicitação</label>
                                    <div class="col-lg-4"><input type="text" name='descr_solic' id='descr_solic'  placeholder="Descrição da solicitação" class="form-control" value='<?php echo $dados[0]->descricao_solicitacao; ?>'  > 
                                    </div>
									<label class="col-lg-2 control-label">Tipo de solicitação</label>
                                    <div class="col-lg-4"><input type="text" name='tipo_solic' id='tipo_solic'  placeholder="Tipo de solicitação" class="form-control"  value='<?php echo $dados[0]->tipo_solicitacao; ?>' > 
                                    </div>
                                </div>
								
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Ação a ser tomada</label>
                                    <div class="col-lg-4"><input type="text" name='acoes' class="form-control" placeholder="Ação a ser tomada" value='<?php echo $dados[0]->plano_acao; ?>'>   
                                    </div>
									<label class="col-lg-2 control-label">Responsável</label>
                                    <div class="col-lg-4"><input type="text" name='resp' class="form-control" placeholder="Responsável pelo atendimento" value='<?php echo $dados[0]->responsavel; ?>'>   
                                    </div>

									
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Prazo de atendimento</label>
                                    <div class="col-lg-4">
									<input type="text" id='prazo_atendimento' name='prazo_atendimento' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo $dados[0]->data_prazo_atendimento_br; ?>'>  
                                    </div>
									
									<label class="col-lg-2 control-label">Alerta no prazo</label>
                                    <div class="col-lg-2">
									<select name="alerta" id="alerta" required=""  class='custom-select' style='width:350px;height:30px'>	
									<option value="0">Escolha</option>								  
									<?php foreach($alertas as $key => $alerta){ ?>	
										<?php if($dados[0]->alerta_prazo_atendimento == $alerta->id){
												$selected='selected';
										}else{
												$selected='';
											}
										?>		
										
									<option value="<?php echo $alerta->id ?>" <?php echo $selected?>><?php echo $alerta->descricao?></option>	
									<?php								  
									}								  							 
									?>								
									</select>   
									
									</div>
								
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Direcionado para</label>
                                    <div class="col-lg-4"><input type="text" name='direcionado' class="form-control" placeholder="Direcionado para" value='<?php echo $dados[0]->direcionado_para; ?>'>   
                                    </div>
									<label class="col-lg-2 control-label">Data de Envio</label>
                                    <div class="col-lg-4">
									<input type="text" id='data_envio' name='data_envio' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo $dados[0]->data_envio_br; ?>'>  
                                    </div>

									
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Data de atendimento</label>
                                    <div class="col-lg-4">
									<input type="text" id='data_atendimento' name='data_atendimento' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo $dados[0]->data_atendimento_br; ?>'>  
                                    </div>
									
									<label class="col-lg-2 control-label">Dias de atendimento</label>
                                    <div class="col-lg-2">
									<input type="text" readonly='yes' id='dias_atendimento' name='dias_atendimento' class="form-control" maxlength="3" value='<?php echo $dados[0]->dias_atendimento; ?>'>  
									
									</div>
								
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Número da solicitação</label>
                                    <div class="col-lg-4"><input type="text" name='num_solic' id='num_solic'  placeholder="Número da solicitação" class="form-control"  value='<?php echo $dados[0]->numero_solicitacao; ?>' > 
                                    </div>
									
									<label class="col-lg-2 control-label">Prioridade</label>
                                    <div class="col-lg-2">
									<select name="prioridade" id="prioridade" required=""  class='custom-select' style='width:350px;height:30px'>	
									<option value="0">Escolha</option>								  
									<?php foreach($prioridades as $key => $prior){ ?>
										<?php if($dados[0]->prioridade == $prior->id){
												$selected='selected';
										}else{
												$selected='';
											}
										?>		
										
									<option value="<?php echo $prior->id ?>" <?php echo $selected?>><?php echo $prior->descricao?></option>	
									<?php								  
									}								  							 
									?>								
									</select>   
									
									</div>
								
                                </div>
								
								
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Nome do auditor</label>
                                    <div class="col-lg-4"><input type="nome_auditor" name='nome_auditor' class="form-control" placeholder="Nome do auditor" value='<?php echo $dados[0]->nome_auditor; ?>'>   
                                    </div>
									<label class="col-lg-2 control-label">Contato do auditor</label>
                                    <div class="col-lg-4"><input type="contato_auditor" name='contato_auditor' class="form-control" placeholder="Contato do auditor" value='<?php echo $dados[0]->contato_auditor; ?>'>   
                                    </div>

									
                                </div>
								
								<div class="form-group">
									
									
									<label class="col-lg-2 control-label">Risco da autuação</label>
                                    <div class="col-lg-4">
									<select name="risco" id="risco" required=""  class='custom-select' style='width:350px;height:30px'>	
									<option value="0">Escolha</option>	
							  
									<?php foreach($prioridades as $key => $prior){ ?>	
									<?php if($dados[0]->risco_atuacao == $prior->id){
												$selected='selected';
										}else{
												$selected='';
											}
										?>			
									<option value="<?php echo $prior->id ?>" <?php echo $selected?> ><?php echo $prior->descricao?></option>	
									<?php								  
									}								  							 
									?>								
									</select>   
									
									</div>
									
									<label class="col-lg-2 control-label">Status</label>
                                    <div class="col-lg-4">
									<select name="status" id="status" required=""  class='custom-select' style='width:350px;height:30px'>	
									<option value="0">Escolha</option>								  
									<?php foreach($status as $key => $st){ ?>	
									<?php if($dados[0]->status == $st->id){
												$selected='selected';
										}else{
												$selected='';
											}
										?>												
									<option value="<?php echo $st->id ?>" <?php echo $selected?>><?php echo $st->descricao?></option>	
									<?php								  
									}								  							 
									?>								
									</select>   
									
									</div>
								
                                </div>
								
								<div class="form-group">
									
									
									
									<label class="col-lg-2 control-label">Data de encerramento fiscalização</label>
                                    <div class="col-lg-4">
									<input type="text" id='data_encerra' name='data_encerra' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo $dados[0]->data_encerr_br; ?>'>  
                                    </div>
									
									<label class="col-lg-2 control-label">Data de recebimento do Termo de Encerramento</label>
                                    <div class="col-lg-4">
									<input type="text" id='data_recebe_termo' name='data_recebe_termo' class="form-control"  data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo $dados[0]->data_receb_term_encerr_br; ?>'>  
                                    </div>
								
                                </div>
								
								<div class="form-group">
									
									<label class="col-lg-2 control-label">Observações/Tratativas</label>
                                    <div class="col-lg-10">
									<input type="text" name='observacao' id='observacao'  placeholder="Nova Observação / Tratativa" class="form-control"  value=''> 
                                    </div>
								
                                </div>
								<div class="form-group">
									
									<label class="col-lg-2 control-label">Histórico : Observações/Tratativas</label>
                                    <div class="col-lg-10">
									<?php foreach($obs as $key => $ob){ 

										echo $ob->data.' - '.$ob->hora.' - '.$ob->email.' - '.$ob->observacao;
										echo '<BR>';	
										}								    				  

										?>			
                                    </div>
								
                                </div>
								
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if($visitante == 0){ ?>
											<input type="hidden" id='id_not' name='id_not' class="form-control"  value='<?php echo $id_not; ?>'>  
											<button class="btn btn-white" type="submit">Cancelar</button>
											<button class="btn btn-primary" type="submit">Salvar</button>
										<?php } ?>
                                    </div>
                                </div>
                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div> 
            </div>
