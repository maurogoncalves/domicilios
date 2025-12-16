<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script type="text/javascript">
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

			$('#cnpj_div').hide();

			$( "input" ).on( "click", function() {
			  valor = $("input:checked" ).val();
			  if(valor == 1){
				$("#cpf_div").show();
				$("#cnpj_div").hide();
			  }else if(valor == 2){
				$("#cpf_div").hide();
				$("#cnpj_div").show();
			  }else{
				$("#cpf_div").hide();
				$("#cnpj_div").hide();
			  }
			});

			
			$('#cpf').blur(function(){
			   var cpf = $("#cpf").val();
				   if(cpf != '___.___.___-__'){
						$.ajax({
							url: "<?php echo $this->config->base_url(); ?>index.php/emitente/contaCpf?cpf=" + cpf,
							type : 'get', /* Tipo da requisição */ 
							contentType: "application/json; charset=utf-8",
							dataType: 'json', /* Tipo de transmissão */
							success: function(data){
								if(data !== 0){									
									alert('CPF Existente, tente outro');
									$("#cpf").val('');
									//$("#cpf").focus();
								}
							}
						});
					}		
				})
			 $('#cnpj').blur(function(){
			   var cnpj = $("#cnpj").val();
				   if(cnpj != '___.___.___-__'){
						$.ajax({
							url: "<?php echo $this->config->base_url(); ?>index.php/emitente/contaCnpj?cnpj=" + cnpj,							
							type : 'get', /* Tipo da requisição */ 
							contentType: "application/json; charset=utf-8",
							dataType: 'json', /* Tipo de transmissão */
							success: function(data){
								if(data !== "0"){									
									alert('CNPJ Existente, tente outro');
									$("#cnpj").val('');
									//$("#cpf").focus();
								}
							}
						});
					}		
				})
						var tipoPessoa = $("#tipoPessoa").val();			if(tipoPessoa == 1){				$("#cpf_div").show();				$("#cnpj_div").hide();			}else if(tipoPessoa == 2){				$("#cpf_div").hide();				$("#cnpj_div").show();			}else{				$("#cpf_div").hide();				$("#cnpj_div").hide();			}			var tipoEmitente = $("#tipoEmitente").val();			$('option:eq('+tipoEmitente+')').prop('selected', true).trigger('change');
		});



    </script>      

<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Editar Empresa<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/emitente/listar"><i class="fa fa-home"></i>Listar Empresa</a></li>
                                    <li class="active">Editar Empresa</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da Empresa</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('emitente/atualizar_emitente', $attributes); 
								?>
                                <div class="panel-body">
                                 <form class="form-horizontal">
                                <div class="form-group"><label class="col-lg-2 control-label">Raz&atilde;o Social</label>
                                    <div class="col-lg-10"><input type="text" name='razaoSocial'  placeholder="Raz&atilde;o Social" class="form-control" required="" value='<?php echo $emitentes[0]->razao_social; ?>' > 
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-lg-2 control-label">Nome Fantasia</label>
                                    <div class="col-lg-10"><input type="text" name='nomeFantasia'  placeholder="Nome Fantasia" class="form-control" required="" value='<?php echo $emitentes[0]->nome_fantasia; ?>'> 
                                    </div>
                                </div>								<input type="hidden" id='tipoPessoa' class="form-control" value='<?php echo $emitentes[0]->tipo_pessoa ?>'>
								<div class="form-group"><label class="col-sm-2 control-label">Tipo Pessoa</label>
                                    <div class="col-lg-10">										<?php if ($emitentes[0]->tipo_pessoa == 1){ ?>
											<div><label> <input type="radio" id="tipoPessoaPF" name='tipoPessoa' value="1" checked="" > Fisica </label> &nbsp;&nbsp;&nbsp; <label> <input type="radio" id="tipoPessoaPJ" name='tipoPessoa' value="2"> Juridica</label> &nbsp;&nbsp;&nbsp; <label> <input type="radio" id="tipoPessoaInt" name='tipoPessoa' value="3"> Departamento Interno</label> </div>										<?php }elseif ($emitentes[0]->tipo_pessoa == 2){ ?>											<div><label> <input type="radio" id="tipoPessoaPF" name='tipoPessoa' value="1"  > Fisica </label> &nbsp;&nbsp;&nbsp; <label> <input type="radio" id="tipoPessoaPJ" name='tipoPessoa' value="2" checked=""> Juridica</label> &nbsp;&nbsp;&nbsp; <label> <input type="radio" id="tipoPessoaInt" name='tipoPessoa' value="3"> Departamento Interno</label></div>										<?php }elseif ($emitentes[0]->tipo_pessoa == 3){ ?>												<div><label> <input type="radio" id="tipoPessoaPF" name='tipoPessoa' value="1"  > Fisica </label> &nbsp;&nbsp;&nbsp; <label> <input type="radio" id="tipoPessoaPJ" name='tipoPessoa' value="2" > Juridica</label> &nbsp;&nbsp;&nbsp; <label> <input type="radio" id="tipoPessoaInt" name='tipoPessoa' value="3" checked=""> Departamento Interno</label></div>										<?php } ?>	
                                    </div>
                                </div>
								
                                <div class="form-group" id='cpf_div'>
									<label class="col-lg-2 control-label">CPF</label>
                                    <div class="col-lg-10"> <input type="text" id='cpf' name='cpf' class="form-control" data-masked="" data-inputmask="'mask': '999.999.999-99' " value='<?php echo $emitentes[0]->cpf_cnpj; ?>'></div>
                                </div>

																
                                <div class="form-group" id='cnpj_div'>
									<label class="col-lg-2 control-label">CNPJ</label>
                                    <div class="col-lg-10"><input type="text" id='cnpj' name='cnpj' class="form-control" data-masked="" data-inputmask="'mask': '99.999.999/9999-99' " value='<?php echo $emitentes[0]->cpf_cnpj; ?>'></div>
                                </div>
								<div class="form-group"><label class="col-sm-2 control-label">Matriz / Filial </label>                                    <div class="col-lg-10">                                        <div>										<?php if( $emitentes[0]->matriz_filial==2){ ?>											<label> <input type="radio" id="matrizFilial" name='matrizFilial' value="1"  > Matriz </label> &nbsp;&nbsp;&nbsp; 											<label> <input type="radio" id="matrizFilial" name='matrizFilial' value="2" checked=""> Filial</label>										<?php }else{ ?>											<label> <input type="radio" id="matrizFilial" name='matrizFilial' value="1" checked="" > Matriz </label> &nbsp;&nbsp;&nbsp; 											<label> <input type="radio" id="matrizFilial" name='matrizFilial' value="2"> Filial</label>										<?php } ?>										</div>                                    </div>                                </div>
								 <div class="form-group"><label class="col-lg-2 control-label">Tipo de Empresa</label>
                                    <div class="col-lg-10">									<input type="hidden" id='tipoEmitente' class="form-control" value='<?php echo $emitentes[0]->tipo_emitente ?>'>									<select class="fancy-select form-control" name="tipoEmitente" id="tipoEmitente">
									  <option value="0">Escolha</option>	
									 	 <?php 							  									  foreach($tipo_emitentes as $key => $emitente){ ?>										  <?php if ($emitentes[0]->tipo_emitente == $emitente->id){ ?>
											<option value="<?php echo $emitente->id ?>"><?php echo $emitente->descricao?></option>											  <?php }else{ ?>												<option value="<?php echo $emitente->id ?>"><?php echo $emitente->descricao?></option>											  <?php } ?>	
									  <?php  } ?> 
									</select>
                                    </div>
                                </div>
								
								 <div class="form-group" >
									<label class="col-lg-2 control-label">Telefone</label>
                                    <div class="col-lg-10"><input type="text" id='tel' name='tel' class="form-control" data-masked="" data-inputmask="'mask': '(99)9999-9999' " value='<?php echo $emitentes[0]->telefone; ?>'></div>
                                </div>
								 <div class="form-group" >
									<label class="col-lg-2 control-label">Celular</label>
                                    <div class="col-lg-10"><input type="text" id='cel' name='cel' class="form-control" data-masked="" data-inputmask="'mask': '(99)99999-9999' "  value='<?php echo $emitentes[0]->celular; ?>'></div>
                                </div>
								 <div class="form-group" >
									<label class="col-lg-2 control-label">Nome Respons&aacute;vel</label>
                                    <div class="col-lg-10"><input type="text" id='nomeResp' name='nomeResp' class="form-control" value='<?php echo $emitentes[0]->nome_resp; ?>' ></div>
                                </div>
								
								<div class="form-group" >
									<label class="col-lg-2 control-label">Email Respons&aacute;vel</label>
                                    <div class="col-lg-10"><input type="email" id='emailResp' name='emailResp' class="form-control" value='<?php echo $emitentes[0]->email_resp; ?>' ></div>
                                </div>
								
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if($visitante == 0){ ?>										<input type="hidden" id='id' name='id'  value='<?php echo $emitentes[0]->id; ?>'>
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
