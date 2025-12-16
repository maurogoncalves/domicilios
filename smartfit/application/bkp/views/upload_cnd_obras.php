
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>

			<script type="text/javascript">
				function Reset(){
					$('#progress .progress-bar').css('width', '0%');
				}
				$(function () {
					$('#fileupload').fileupload({
						dataType: 'json',
						done: function (e, data) {
							alert('Fez Upload');
							$('#progress .progress-bar').css('width', '0%');
							window.location.reload();
							
						},
						progressall: function (e, data) {
							var progress = parseInt(data.loaded / data.total * 100, 10);
							$('#progress .progress-bar').css('width', progress + '%');
							
						}
					});
				});
				function fsClean() {
					$('#progress .progress-bar').css('width', '0%');
				}
			</script>
			
		<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Upload CND Obras<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/cnd_obras/dados_agrupados"><i class="fa fa-home"></i>Listar CND Obras</a></li>
                                    <li class="active">Upload CND Obras</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
					<div class="row">
					<?php
						$attributes = array('class' => 'form-horizontal style-form');
						echo form_open_multipart('cnd_obras/enviar', $attributes); 							
					?>
						<div class="col-md-12">
							<div class="panel panel-card margin-b-30">
								<?php
								$isArray =  is_array($dataEmissao) ? '1' : '0';							
									if($isArray == 0){								
										}else{							
										foreach($dataEmissao as $data){ 										
									?>	
									<div class="form-group">
									<label class="col-lg-2 control-label" >Data de Emissão</label>
										<div class="col-lg-8">
											<input type="text"  id='' readonly='yes' name='' class="form-control" value='<?php echo $data->data_emissao;	?>'  >												
										</div>
									</div>
								<?php }}?>			
									<div class="form-group">
									<label class="col-lg-2 control-label" >N&uacute;mero Inscri&ccedil;&atilde;o</label>
										<div class="col-lg-4">
											<input type="text"  id='' name='' readonly='yes' class="form-control" value='<?php echo $dados_cei[0]->cei?>'    >
											<input type="hidden"  id='id'  name='id' class="form-control" value='<?php echo $dados_cei[0]->id_cnd?>'   > 											
											
										</div>
										<label class="col-lg-2 control-label" >Data Vencimento</label>
										<div class="col-lg-4">
											<input type="text"  id='nome' readonly='yes' name='nome' class="form-control" value=' <?php echo $dados_cei[0]->data_abertura?>'   > 
												
										</div>										
									</div>	
									
									</div>
							</div>
						
						 </div>
	                   <div class="row">
					   <?php if($visitante == 0){ ?>
                        <span class="btn btn-success fileinput-button">
							<i class="glyphicon glyphicon-plus"></i>
							<span>Escolha o Arquivo</span>
							<input id="fileupload"  type="file" name="userfile" data-url="<?php echo $this->config->base_url();?>index.php/cnd_obras/enviar?id=<?php echo $dados_cei[0]->id_cnd?>">
						</span>
						<?php }else{ ?>
								<span class="btn btn-success fileinput-button">
								<?php  echo MENSAGEM_VISITANTE;  ?>
								</span>
						<?php } ?>
						<br>
						<div id="progress" class="progress">
							<div class="progress-bar progress-bar-success"></div>
						</div>
						<br>
						<div id="files" class="files"></div>
						<!---->
						<div class="row" id="rowFotos"></div>

                    </div>

                </div> 
            </div>
			