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
                                <h1>Cadastrar CND Imobili&aacuteria <small>	
									<?php 				  
										if(!empty($_SESSION['msgCNDIMob'])){ 						
											echo utf8_encode($_SESSION['msgCNDIMob']);				  
										} 
									?></small></h1>
                                <ol class="breadcrumb">
                                    <li class="active">Cadastrar CND Imobili&aacuteria </li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da CND Imobili&aacuteria </h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								 <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open_multipart('cnd_imob/cadastrar_cnd_imob', $attributes); 
								?>		
                                <div class="panel-body">
                                 <form class="form-horizontal">									
									<div class="form-group">
										<label class="col-lg-2 control-label">N&uacute;mero Inscri&ccedil;&atilde;o</label>
										<div class="col-lg-4">
											<input type="text"  id='inscricao' name='inscricao' class="form-control" value='<?php echo $inscricao[0]->inscricao;?>'>											<input type="hidden"  id='id_iptu' name='id_iptu' class="form-control" value='<?php echo $inscricao[0]->id;?>'>
										</div>
										
										
									</div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label">Possui CND?</label>
										<div class="col-lg-8">
											 <input type="radio" id="possui_cnd" name="possui_cnd" value="1" checked> Sim &nbsp;&nbsp;&nbsp;											<input type="radio" id="possui_cnd" name="possui_cnd" value="2"> N&atilde;o &nbsp;&nbsp;&nbsp;											<input type="radio" id="possui_cnd" name="possui_cnd" value="3"> Pend&ecirc;ncia
										</div>
									</div>
									
									<div class="form-group" id='data_emissao_div'>
										<label class="col-lg-2 control-label">Data de Emissão</label>
										<div class="col-lg-8">
											<input type='text' id='data_emissao' name='data_emissao' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' "   >
										</div>
									</div>

									<div class="form-group">
										<label class="col-lg-2 control-label" id='data_vecto_cnd'>Data de Emissão</label>
										<div class="col-lg-8">
										<input type='text' id='data_vencto' name='data_vencto' class='form-control' data-masked="" data-inputmask="'mask': '99/99/9999' " value='' >																	 
										</div>
									</div>

									<div class="form-group">
										<label class="col-lg-2 control-label" >Observa&ccedil;&otilde;es</label>
										<div class="col-lg-8">
											<input type="text"  id='observacoes' name='observacoes' class="form-control" value=''     >	
										</div>
									</div>
									
									<div class="form-group">
										<label class="col-lg-2 control-label" >Plano de A&ccedil;&atilde;o</label>
										<div class="col-lg-8">
											<input type="text"  id='plano' name='plano' class="form-control"  value=''   >	
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
