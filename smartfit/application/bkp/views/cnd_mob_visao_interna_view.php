<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script> 

<script type="text/javascript">      	
$(document).ready(function(){	 
	$('input').keypress(function (e) {			
		var code = null;			
		code = (e.keyCode ? e.keyCode : e.which);                			
		return (code == 13) ? false : true;	   
	});	 
	var possui = $("#possui").val();
	
	if(possui == 1){			
		$("#data_vecto_cnd").text('Vencimento');		
		$("#fileupload_possui").show();		$("#fileupload_pend").hide();		$("#data_emissao_div").show();
		$("#data_emissao").prop('required',true);
	}else  if(possui ==2){			
		$("#data_vecto_cnd").text('Vencimento');				
		$("#data_emissao_div").hide();		$("#fileupload_pend").hide();		$("#fileupload_possui").show();
		$("#data_emissao").prop('required',false);

	}else{			
		$("#data_vecto_cnd").text('Upload Pend\u00eancias');
		$("#data_emissao_div").hide();		$("#fileupload_possui").hide();		$("#fileupload_pend").show();
		$("#data_emissao").prop('required',false);	

	}	
	
	$( "input" ).on( "click", function() {			  
		var valor = $("input:checked" ).val();			  		  
		if(valor == 1){			
			$("#data_vecto_cnd").text('Vencimento');
			$("#data_emissao_div").show();
			$("#data_emissao").prop('required',true);						$("#fileupload_pend").hide();			$("#fileupload_possui").show();
		}else  if(valor ==2){			
			$("#data_vecto_cnd").text('Vencimento');
			$("#data_emissao_div").hide();
			$("#data_emissao").prop('required',false);							$("#fileupload_pend").hide();			$("#fileupload_possui").show();
		}else{			
			$("#data_vecto_cnd").text('Upload Pend\u00eancias');
			$("#data_emissao_div").hide();			$("#fileupload_possui").hide();			$("#fileupload_pend").show();
			$$("#data_emissao").prop('required',false);
			
		}		
	});	
});	function Reset(){					$('#progress .progress-bar').css('width', '0%');				}				$(function () {					$('#fileupload_pdf').fileupload({						dataType: 'json',						done: function (e, data) {							alert('Fez Upload');							$('#progress .progress-bar').css('width', '0%');							window.location.reload();																				},						progressall: function (e, data) {							var progress = parseInt(data.loaded / data.total * 100, 10);							$('#progress .progress-bar').css('width', progress + '%');													}					});				});								$(function () {					$('#fileupload_xls').fileupload({						dataType: 'json',						done: function (e, data) {							alert('Fez Upload');							$('#progress .progress-bar').css('width', '0%');							window.location.reload();																				},						progressall: function (e, data) {							var progress = parseInt(data.loaded / data.total * 100, 10);							$('#progress .progress-bar').css('width', progress + '%');													}					});				});				$(function () {					$('#fileupload_obs').fileupload({						dataType: 'json',						done: function (e, data) {							alert('Fez Upload');							$('#progress .progress-bar').css('width', '0%');							window.location.reload();													},						progressall: function (e, data) {							var progress = parseInt(data.loaded / data.total * 100, 10);							$('#progress .progress-bar').css('width', progress + '%');													}					});				});				$(function () {					$('#fileupload_possui').fileupload({						dataType: 'json',						done: function (e, data) {							alert('Fez Upload');							$('#progress .progress-bar').css('width', '0%');							window.location.reload();													},						progressall: function (e, data) {							var progress = parseInt(data.loaded / data.total * 100, 10);							$('#progress .progress-bar').css('width', progress + '%');													}					});				});				$(function () {					$('#fileupload_pend').fileupload({						dataType: 'json',						done: function (e, data) {							alert('Fez Upload');							$('#progress .progress-bar').css('width', '0%');							window.location.reload();													},						progressall: function (e, data) {							var progress = parseInt(data.loaded / data.total * 100, 10);							$('#progress .progress-bar').css('width', progress + '%');													}					});				});								function fsClean() {					$('#progress .progress-bar').css('width', '0%');				}				
    </script>      
    <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Editar <?php echo$nome_modulo ?> <small>	
									<?php 				  
										if(!empty($_SESSION['msgCNDMob'])){ 						
											echo utf8_encode($_SESSION['msgCNDMob']);				  
										} 
									?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/<?php echo$controller ?>/<?php echo $modulo;	?>"><i class="fa fa-home"></i>Listar <?php echo$nome_modulo ?></a></li>
                                    <li class="active">Editar <?php echo$nome_modulo ?> </li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                               
								 <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open_multipart($controller.'/atualizar_cnd', $attributes); 
								?>		
								<input type="hidden" readonly='yes' name='id' id='id'  value='<?php echo $imovel[0]->id ?>'>
                                <div class="panel-body">
                                 <form class="form-horizontal">                                    <h4 class="panel-title" style='color:#002060'> Dados da Unidade de Negócio									<span style='float:right' id='nova-tratativa'> 									<a  class="btn btn-primary" style='color:#fff' href="<?php echo $this->config->base_url(); ?>index.php/<?php echo$controller ?>/listarTodos"> Tela de Pesquisa </a> 									</span>									</h4>									<BR>									<div class="form-group">										<div class="col-lg-2">											&nbsp;&nbsp;&nbsp;Estado										</div>										<div class="col-lg-5">											&nbsp;&nbsp;&nbsp;Cidade										</div>																				<div class="col-lg-5">											&nbsp;&nbsp;&nbsp;Bairro										</div>																																							</div>									
								<div class="form-group">										<div class="col-lg-2">											<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->estado;?>'>                              										</div>										<div class="col-lg-5">											<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->cidade;?>'>                              										</div>																				<div class="col-lg-5">											<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->bairro;?>'>                              										</div>																																							</div>									<div class="form-group">										<div class="col-lg-7">											&nbsp;&nbsp;&nbsp;Endereço										</div>										<div class="col-lg-1">											&nbsp;&nbsp;&nbsp;Número										</div>										<div class="col-lg-4">											&nbsp;&nbsp;&nbsp;Cep										</div>									</div>									<div class="form-group">										<div class="col-lg-7">											<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->endereco;?>'>                              										</div>										<div class="col-lg-1">											<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->numero;?>'>                              										</div>										<div class="col-lg-4">											<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->cep;?>'>                              										</div>									</div>																		<div class="form-group">										<div class="col-lg-4">											&nbsp;&nbsp;&nbsp;Nome										</div>																														<div class="col-lg-4">											&nbsp;&nbsp;&nbsp;Nome Fantasia										</div>																														<div class="col-lg-4">											&nbsp;&nbsp;&nbsp;CPF / CNPJ										</div>																			</div>																		<div class="form-group">										<div class="col-lg-4">											<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->nome;?>'>                              										</div>																														<div class="col-lg-4">											<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->nome_fantasia;?>'>                              										</div>																														<div class="col-lg-4">											<input type="text" readonly='yes' class="form-control"  style='color:#00B0F2' value='<?php echo $imovel[0]->cpf_cnpj;?>'>                              										</div>																			</div>																		<div class="form-group">																					<div class="col-lg-4">   											&nbsp;&nbsp;&nbsp;Inscrição?										</div>										<div class="col-lg-4">											&nbsp;&nbsp;&nbsp;Regional										</div>																				<div class="col-lg-4">											&nbsp;&nbsp;&nbsp;Bandeira										</div>																			</div>									
									<div class="form-group">
																					<div class="col-lg-4">
											<input type="text" readonly='yes'  id='inscricao' name='inscricao' style='color:#00B0F2'  class="form-control" value='<?php echo $imovel[0]->ins_cnd_mob;?>'>								
											 <input type="hidden"  id='id' name='id' class="form-control" value='<?php echo $imovel[0]->id_cnd;?>'>								 
											 <input type="hidden"  id='id_emitente' name='id_emitente' class="form-control" value='<?php echo $imovel[0]->id_loja;?>'>								 
											 <?php if($imovel[0]->possui_cnd == 1){ ?>									
											 <input type="hidden"  id='possui' name='possui' class="form-control" value='1'>
											 <?php }elseif($imovel[0]->possui_cnd == 2){ ?>	
											 <input type="hidden"  id='possui' name='possui' class="form-control" value='2'>								 
											 <?php }else{ ?>								   
											 <input type="hidden"  id='possui' name='possui' class="form-control" value='3'>
											 <?php } ?>     
											
										</div>										<div class="col-lg-4">											<input type="text" readonly='yes'  style='color:#00B0F2'  class="form-control" value='<?php echo $imovel[0]->desc_regional;?>'>																		</div>																				<div class="col-lg-4">											<input type="text" readonly='yes'  style='color:#00B0F2'  class="form-control" value='<?php echo $imovel[0]->descricao_bandeira;?>'>																		</div>
										
									</div>									<div class="form-group">										<div class="col-lg-4">											&nbsp;&nbsp;&nbsp;Centro de Custo										</div>																				<div class="col-lg-4">											&nbsp;&nbsp;&nbsp;Código 1										</div>										<div class="col-lg-4">											&nbsp;&nbsp;&nbsp;Código 2										</div>									</div>									<div class="form-group">										<div class="col-lg-4">											<input type="text" readonly='yes'  style='color:#00B0F2'  class="form-control" value='<?php echo $imovel[0]->cc;?>'>																		</div>																				<div class="col-lg-4">											<input type="text" readonly='yes'  style='color:#00B0F2'  class="form-control" value='<?php echo $imovel[0]->cod1;?>'>																		</div>										<div class="col-lg-4">											<input type="text" readonly='yes'  style='color:#00B0F2'  class="form-control" value='<?php echo $imovel[0]->cod2;?>'>																		</div>									</div>									<BR>                                    <h4 class="panel-title" style='color:#002060'> <?php echo$nome_modulo ?> 									&nbsp;&nbsp;									<a class="btn btn-success" style='color:#fff' href="<?php echo $this->config->base_url(); ?>index.php/<?php echo$controller ?>/export_tratativas?id=<?php echo $id_cnd?>" > <i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Exportar</a>									</h4>									<BR>									
									<div class="form-group">										<div class="col-lg-5">											Possui CND?	&nbsp;		
											 <?php if($imovel[0]->possui_cnd == 1){ ?>									 
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="1" checked> Emitida &nbsp;&nbsp;								
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="2" > N&atilde;o Emitida &nbsp;&nbsp;
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="3"> Pendente
											 <?php }elseif($imovel[0]->possui_cnd == 2){ ?>	
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="1" > Emitida &nbsp;&nbsp;								 
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="2" checked > N&atilde;o Emitida&nbsp;&nbsp;							 
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="3" > Pendente
											 <?php }else{ ?>									
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="1" > Emitida &nbsp;&nbsp;								
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="2" > N&atilde;o Emitida &nbsp;&nbsp;							 
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="3" checked> Pendente
											 <?php } ?>      
										</div>										<label class="col-lg-1 control-label">Emissão</label>										<div class="col-lg-2">											<?php 												  if($data_emissao <> 0){ 											  ?>								  												<input type='text' id='data_emissao' name='data_emissao' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo $data_emissao[0]->data_emissao_br ?>'  >											 <?php 												  }else{ 											  ?>																								  <input type='text' id='data_emissao' name='data_emissao' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' " value=''  >												  <?php }?>										</div>										<label class="col-lg-2 control-label" id='data_vecto_cnd'>Vencimento</label>										<div class="col-lg-2">											<?php 																	  												 if($imovel[0]->possui_cnd == 1){ 																						$dataVArr = explode("-",$imovel[0]->data_vencto);																						$dataV = $dataVArr[2].'/'.$dataVArr[1].'/'.$dataVArr[0];												?>														 <input type='text' id='data_vencto' name='data_vencto' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo$dataV?>' >																	 											<?php 																	  	 												 }else if($imovel[0]->possui_cnd == 2){ 																						$dataVArr = explode("-",$imovel[0]->data_vencto);																						$dataV = $dataVArr[2].'/'.$dataVArr[1].'/'.$dataVArr[0];																		?>														<input type='text' id='data_vencto' name='data_vencto' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo$dataV?>' >											<?php	 												 }else{								 													$dataVArr = explode("-",$imovel[0]->data_pendencias);																						$dataV = $dataVArr[2].'/'.$dataVArr[1].'/'.$dataVArr[0];																			?>	 												 <input type='text' id='data_vencto' name='data_vencto' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo$dataV?>' >											<?php	 	 												 }																			 ?>       										</div>										
									</div>
									

									<div class="form-group">										<div class="col-lg-2">											<span class="btn btn-success fileinput-button">																						<i class="glyphicon glyphicon-plus"></i>												<span>Anexar CND - PDF</span>																								<?php if($local == 1){?>													<input id="fileupload_possui"  type="file" name="userfile" data-url="<?php echo $this->config->base_url();?>index.php/<?php echo$controller ?>/enviar?id=<?php echo $imovel[0]->id_cnd?>">													<input id="fileupload_pend"  type="file" name="userfile" data-url="<?php echo $this->config->base_url();?>index.php/<?php echo$controller ?>/enviar_pend?id=<?php echo $imovel[0]->id_cnd?>">												<?php }?>											</span>																																																<br>											<div id="files" class="files"></div>											<!---->											<div class="row" id="rowFotos"></div>										</div>										<div class="col-lg-2">											<?php if($imovel[0]->possui_cnd == 1){  ?>													<a href="<?php echo $this->config->base_url(); ?>assets/cnds_mob/<?php echo $imovel[0]->arquivo_cnd?>" download> <i class="fa fa-eye" aria-hidden="true"></i> &nbsp; Ver Arquivo</a>											<?php }else{  ?>													<a href="<?php echo $this->config->base_url(); ?>assets/cnd_pend/<?php echo $imovel[0]->arquivo_pendencias?>" download> <i class="fa fa-eye" aria-hidden="true"></i> &nbsp; Ver Arquivo</a>											<?php }  ?>										</div>										
										<label class="col-lg-2 control-label" >Observa&ccedil;&otilde;es</label>
										<div class="col-lg-5">
											<input type="text"  id='observacoes' name='observacoes' class="form-control" value='<?php echo $imovel[0]->observacoes  ?>'    >	
										</div>
									</div>									<BR>									<h4 class="panel-title" style='color:#002060'> Extrato de Pendências									<?php if($local == 1){?>																	<span class="btn btn-primary" id='salvar' style='background-color:#002060!important;border: 1px solid #002060 !important;float:right'  data-toggle="modal" data-target="#enviarEmail" >Enviar Notificação</span>										<?php }  ?>									</h4>									<BR>									<div class="form-group">										<div class="col-lg-6">											<span class="btn btn-success fileinput-button">												<i class="glyphicon glyphicon-plus"></i>												<span>Anexar Extrato - PDF</span>												<?php if($local == 1){?>													<input id="fileupload_pdf"  type="file" name="userfile" data-url="<?php echo $this->config->base_url();?>index.php/<?php echo $controller ?>/enviar_extrato?id=<?php echo $imovel[0]->id_cnd?>&tipo=1">												<?php }?>											</span>												&nbsp;&nbsp;&nbsp;												<?php if(!empty($imovel[0]->extrato_pend_pdf)){  ?>													<a href="<?php echo $this->config->base_url(); ?>assets/cnd_mob_extrato_pdf/<?php echo $imovel[0]->extrato_pend_pdf?>" download> <i class="fa fa-eye" aria-hidden="true"></i> &nbsp; Ver PDF</a>												<?php }  ?>																																																<br>											<div id="files" class="files"></div>											<!---->											<div class="row" id="rowFotos"></div>										</div>																				<div class="col-lg-6">											<span class="btn btn-success fileinput-button">												<i class="glyphicon glyphicon-plus"></i>												<span>Anexar Análise do Extrato - XLS</span>												<?php if($local == 1){?>													<input id="fileupload_xls"  type="file" name="userfile" data-url="<?php echo $this->config->base_url();?>index.php/<?php echo$controller?>/enviar_extrato?id=<?php echo $imovel[0]->id_cnd?>&tipo=2">												<?php }?>											</span>												&nbsp;&nbsp;&nbsp;												<?php if(!empty($imovel[0]->extrato_pend_xls)){  ?>													<a href="<?php echo $this->config->base_url(); ?>assets/cnd_mob_extrato_xls/<?php echo $imovel[0]->extrato_pend_xls?>" download> <i class="fa fa-eye" aria-hidden="true"></i> &nbsp; Ver XLS</a>												<?php }  ?>																																																<br>											<div id="files" class="files"></div>											<!---->											<div class="row" id="rowFotos"></div>										</div>									</div>										<!--									<BR>									<h4 class="panel-title" style='color:#002060'>									<a class="btn btn-primary" style='color:#fff' href="<?php echo $this->config->base_url(); ?>index.php/<?php echo$controller?>/visao_externa?id=<?php echo $id_cnd?>"> Tratativas - <?php echo$empresa?> </a> 									</h4>									!-->									<BR>									<h4 class="panel-title" style='color:#002060'> Tratativas </h4>									<BR>									<div class="form-group">										<div class="col-lg-6">											<select name="resp_int" id="resp_int" required="" class="form-control select2">												  <option value="0">Escolha Responsável Interno</option>													  <?php foreach($respInterno as $key => $respInt){ ?>													  <?php if($imovel[0]->id_resp_interno == $respInt->id){  ?>														<option value="<?php echo $respInt->id ?>" selected><?php echo $respInt->nome_usuario?></option>														  <?php }else{  ?>															<option value="<?php echo $respInt->id ?>" ><?php echo $respInt->nome_usuario?></option>														  <?php }  												  													  }								  												  ?>											</select>										</div>										<div class="col-lg-6">											<select name="resp_ext" id="resp_ext" required="" class="form-control select2">												  <option value="0">Escolha Responsável Externo</option>													  <?php foreach($respExterno as $key => $respExt){ ?>													  <?php if($imovel[0]->id_resp_externo == $respExt->id){  ?>													  <option value="<?php echo $respExt->id ?>" selected><?php echo $respExt->nome_usuario?></option>														  <?php }else{  ?>														  <option value="<?php echo $respExt->id ?>"><?php echo $respExt->nome_usuario?></option>														  <?php													  }												  }								  												  ?>											</select>                            										</div>									</div>									<BR>									<div class="form-group">										<label class="col-lg-2 control-label">Observações/Tratativas</label>										<div class="col-lg-10">										<input type="text" name='observacao_tratativa' id='observacao_tratativa'  placeholder="Nova Observação / Tratativa" class="form-control"  value=''> 										</div>									</div>									<div class="form-group">																		<label class="col-lg-2 control-label">Histórico : Observações/Tratativas</label>                                    <div class="col-lg-10">									<?php foreach($obs as $key => $ob){ 										echo $ob->data.' - '.$ob->hora.' - '.$ob->email.' - '.$ob->observacao;										echo '<BR>';											}								    				  										?>			                                    </div>								                                </div>

		
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if(($visitante == 0)){ ?>
                                        <button class="btn btn-white" type="submit">Cancelar</button>
                                        <button class="btn btn-primary" id='salvar' style='background-color:#002060!important;border: 1px solid #002060 !important' type="submit">Salvar</button>
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
<!-- Modal - enviar email -->				<div id="enviarEmail" class="modal fade" role="dialog">				  <div class="modal-dialog">					<!-- Modal content-->					<div class="modal-content">					  <div class="modal-header">						<button type="button" class="close" data-dismiss="modal">&times;</button>						<h4 class="modal-title">Envio de Email</h4>					  </div>					   <?php								$attributes = array('class' => 'form-horizontal style-form');								echo form_open_multipart($controller.'/enviar_email', $attributes); 						?>					  <div class="modal-body">						<p>Escolher responsável que receberá o email.</p>						<input type='hidden' value='<?php echo $id_cnd ?>' id='id-cnd-mob' name='id-cnd-mob' />						<?php foreach($respExterno as $key => $respExt){ ?>							  <div class="i-checks"><label> <input type="checkbox" name="email[]" value='<?php echo$respExt->id ?>' ><i></i> &nbsp; <?php echo $respExt->nome_usuario.' - '.$respExt->email ?> </label></div>						 <?php						  }								  						?>						<button type="submit" class="btn btn-primary">Enviar</button>						  </div>					  					  </form>	  						  <div class="modal-footer">					  </div>					</div>				  </div>				</div>