<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>			<script type="text/javascript">				function Reset(){					$('#progress .progress-bar').css('width', '0%');				}				$(function () {					$('#fileupload').fileupload({						dataType: 'json',						done: function (e, data) {							alert('Fez Upload');							$('#progress .progress-bar').css('width', '0%');							window.location.reload();													},						progressall: function (e, data) {							var progress = parseInt(data.loaded / data.total * 100, 10);							$('#progress .progress-bar').css('width', progress + '%');													}					});				});				function fsClean() {					$('#progress .progress-bar').css('width', '0%');				}			</script>			<div id="wrapper">
	<div class="content-wrapper container">
		 <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Ver Imagem Ocorr&ecirc;ncia<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/ocorrencia/listar"><i class="fa fa-home"></i>Listar Ocorr&ecirc;ncia</a></li>
                                    <li class="active">Ver Imagem Ocorr&ecirc;ncia</li>
                                </ol>
                            </div>
                        </div>
						
						<div class="row">

					<?php

						$attributes = array('class' => 'form-horizontal style-form');

						echo form_open_multipart('ocorrencia/enviar', $attributes); 							

					?>

						<div class="col-md-12">

							<div class="panel panel-card margin-b-30">

								<div class="form-group">


										<div class="col-lg-12">
											Ocorr&ecirc;ncia
											<BR>
											<?php echo $dados[0]->texto_ocorrencia;	?>

											

										</div>

									</div>	



									</div>

							</div>

						

						 </div>
						 
						<div class="row">
							<div class="col-lg-12">
								<a href="<?php echo $this->config->base_url(); ?>assets/ocorrencia/<?php echo $dados[0]->img?>" download> Baixar Arquivo</a>
							</div>
						</div> 
         </div>
	</div>
 </div>