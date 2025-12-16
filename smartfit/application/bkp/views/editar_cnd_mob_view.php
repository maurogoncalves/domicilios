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
		$("#data_vecto_cnd").text('Data Vencimento');
		$("#data_emissao_div").show();
		$("#data_emissao").prop('required',true);
	}else  if(possui ==2){			
		$("#data_vecto_cnd").text('Data Vencimento');
		$("#data_emissao_div").hide();
		$("#data_emissao").prop('required',false);

	}else{			
		$("#data_vecto_cnd").text('Data Upload Pend\u00eancias');
		$("#data_emissao_div").hide();
		$("#data_emissao").prop('required',false);	

	}	
	
	$( "input" ).on( "click", function() {			  
		var valor = $("input:checked" ).val();			  		  
		if(valor == 1){			
			$("#data_vecto_cnd").text('Data Vencimento');
			$("#data_emissao_div").show();
			$("#data_emissao").prop('required',true);
		}else  if(valor ==2){			
			$("#data_vecto_cnd").text('Data Vencimento');
			$("#data_emissao_div").hide();
			$("#data_emissao").prop('required',false);	
		}else{			
			$("#data_vecto_cnd").text('Data Upload Pend\u00eancias');
			$("#data_emissao_div").hide();
			$$("#data_emissao").prop('required',false);
			
		}		
	});	
});	
    </script>      
    <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Editar CND Mobili&aacuteria <small>	
									<?php 				  
										if(!empty($_SESSION['msgCNDMob'])){ 						
											echo utf8_encode($_SESSION['msgCNDMob']);				  
										} 
									?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/cnd_mob/<?php echo $modulo;	?>"><i class="fa fa-home"></i>Listar CND Mobili&aacuteria</a></li>
                                    <li class="active">Editar CND Mobili&aacuteria </li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da CND Mobili&aacuteria </h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								 <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open_multipart('cnd_mob/atualizar_cnd', $attributes); 
								?>		
								<input type="hidden" readonly='yes' name='id' id='id'  value='<?php echo $dados_loja[0]->id ?>'>
                                <div class="panel-body">
                                 <form class="form-horizontal">
									<div class="form-group">
										<label class="col-lg-2 control-label"></label>
										<div class="col-lg-4">
											<?php if(!empty($imovel[0]->loja_acomp)){ ?>
												<a style='color:#ff0000' href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/painel?id=<?php echo $imovel[0]->loja_acomp; ?>"> Verificar Acompanhamento	 </a>		
										  <?php }else{ ?>								  									
												<a style='color:#ff0000' href="<?php echo $this->config->base_url();?>index.php/loja/acomp?id=<?php echo $imovel[0]->id_loja; ?>">  Criar Acompanhamento</a>								  									
										 <?php } ?>									
										</div>
										<label class="col-lg-2 control-label"></label>
										<div class="col-lg-4">
											
										<?php if($imovel[0]->possui_cnd == 1){ ?>									
											<a style='color:#ff0000' href="<?php echo $this->config->base_url();?>index.php/cnd_mob/upload_cnd?id=<?php echo $imovel[0]->id_cnd; ?>">	Fazer Upload da CND	</a>								
										 <?php }elseif($imovel[0]->possui_cnd == 2){ ?>
											<a style='color:#ff0000' href="<?php echo $this->config->base_url();?>index.php/cnd_mob/upload_cnd?id=<?php echo $imovel[0]->id_cnd; ?>"> Fazer Upload da CND	</a>								 
										 <?php }else{ ?>								   	
											<a style='color:#ff0000' href="<?php echo $this->config->base_url();?>index.php/cnd_mob/upload_pend?id=<?php echo $imovel[0]->id_cnd; ?>">	Fazer Upload de Pendência  </a>								
										 <?php } ?>			
									
											</div>									
									</div>
									<div class="form-group">
										<label class="col-lg-2 control-label">CPF/CNPJ do Emitente</label>
										<div class="col-lg-4">
											<input type="text" readonly='yes' name='cpf_cnpj' id='cpf_cnpj' class="form-control"  required="" value='<?php echo $imovel[0]->cpf_cnpj;?>'>                              
										</div>
										
										<label class="col-lg-2 control-label">Inscri&ccedil;&atilde;o Mobili&aacute;ria</label>
										<div class="col-lg-4">
											<input type="text" readonly='yes'  id='inscricao' name='inscricao' class="form-control" value='<?php echo $imovel[0]->ins_cnd_mob;?>'>								
											 <input type="hidden"  id='id' name='id' class="form-control" value='<?php echo $imovel[0]->id_cnd;?>'>								 
											 <input type="hidden"  id='id_emitente' name='id_emitente' class="form-control" value='<?php echo $imovel[0]->id_loja;?>'>								 
											 <?php if($imovel[0]->possui_cnd == 1){ ?>									
											 <input type="hidden"  id='possui' name='possui' class="form-control" value='1'>
											 <?php }elseif($imovel[0]->possui_cnd == 2){ ?>	
											 <input type="hidden"  id='possui' name='possui' class="form-control" value='2'>								 
											 <?php }else{ ?>								   
											 <input type="hidden"  id='possui' name='possui' class="form-control" value='3'>
											 <?php } ?>     
											
										</div>
										
									</div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label">Possui CND?</label>
										<div class="col-lg-8">
											 <?php if($imovel[0]->possui_cnd == 1){ ?>									 
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="1" checked> Sim &nbsp;&nbsp;&nbsp;									
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="2" > N&atilde;o &nbsp;&nbsp;&nbsp;									 
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="3"> Pend&ecirc;ncia
											 <?php }elseif($imovel[0]->possui_cnd == 2){ ?>	
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="1" > Sim &nbsp;&nbsp;&nbsp;									 
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="2" checked > N&atilde;o &nbsp;&nbsp;&nbsp;									 
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="3" > Pend&ecirc;ncia
											 <?php }else{ ?>									
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="1" > Sim &nbsp;&nbsp;&nbsp;									
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="2" > N&atilde;o &nbsp;&nbsp;&nbsp;									 
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="3" checked> Pend&ecirc;ncia
											 <?php } ?>      
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label">Data de Emissão</label>
										<div class="col-lg-8">
											<?php 
												  if($data_emissao <> 0){ 
											  ?>								  
												<input type='text' id='data_emissao' name='data_emissao' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo $data_emissao[0]->data_emissao_br ?>'  >
											 <?php 
												  }else{ 
											  ?>	
											  <input type='text' id='data_emissao' name='data_emissao' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' " value=''  >
												  <?php }?>
										</div>
									</div>

									<div class="form-group">
										<label class="col-lg-2 control-label" id='data_vecto_cnd'>Data de Emissão</label>
										<div class="col-lg-8">
											<?php 																	  
												 if($imovel[0]->possui_cnd == 1){ 									
												 $dataVArr = explode("-",$imovel[0]->data_vencto);									
												 $dataV = $dataVArr[2].'/'.$dataVArr[1].'/'.$dataVArr[0];	
											?>		
												 <input type='text' id='data_vencto' name='data_vencto' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo$dataV?>' >																	 
											<?php 																	  	 
												 }else if($imovel[0]->possui_cnd == 2){ 									
												 $dataVArr = explode("-",$imovel[0]->data_vencto);									
												 $dataV = $dataVArr[2].'/'.$dataVArr[1].'/'.$dataVArr[0];							
											?>		
												<input type='text' id='data_vencto' name='data_vencto' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo$dataV?>' >
											<?php	 
												 }else{								 
												 $dataVArr = explode("-",$imovel[0]->data_pendencias);									
												 $dataV = $dataVArr[2].'/'.$dataVArr[1].'/'.$dataVArr[0];								
											?>	 
												 <input type='text' id='data_vencto' name='data_vencto' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' " value='<?php echo$dataV?>' >
											<?php	 	 
												 }								
												 ?>       
										</div>
									</div>

									<div class="form-group">
										<label class="col-lg-2 control-label" >Observa&ccedil;&otilde;es</label>
										<div class="col-lg-8">
											<input type="text"  id='observacoes' name='observacoes' class="form-control" value='<?php echo $imovel[0]->observacoes  ?>'    >	
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" >Plano de A&ccedil;&atilde;o</label>
										<div class="col-lg-8">
											<input type="text"  id='plano' name='plano' class="form-control" value='<?php echo $imovel[0]->plano  ?>'    >	
										</div>
									</div>
									
		
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if($visitante == 0){ ?>
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
