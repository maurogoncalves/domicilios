<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.mask.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script> 
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script><script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script><script type="text/javascript">jQuery(function($) {    $('.auto').autoNumeric('init');});</script>
    <script>		
		$(document).ready(function(){			//$('#areaTotal').bind('keypress',mask.money);			//$('#areaConstruida').bind('keypress',mask.money);			
			$('#cep').blur(function(){
				
			   var cep = $("#cep").val();
				   if(cep != '__.___-___'){
						$.ajax({
							url: "<?php echo $this->config->base_url(); ?>index.php/imovel/buscaCep?cep=" + cep,
							type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 
							contentType: "application/json; charset=utf-8",
							dataType: 'json', /* Tipo de transmiss&atilde;o */
							success: function(data){
								if(data !== 0){									
									$("#logradouro").val(data.rua);									$("#bairro").val(data.bairro);									$("#cidade").val(data.cidade);									$("#estado").val(data.estado);
								}
							}
						});
					}		
				})
				
		});

    </script>      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row mt">
                  <div class="col-lg-12">
				  
				  <a  href="listar" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Listar Im&oacute;vel com Iptu</a>
				  <span class='pull-right' style='font-weight:bold'>
						<?php if(!empty($mensagem)){
							echo utf8_encode($mensagem); 
						}		
						?>
					</span>
					
                      <div class="form-panel">
					
							 <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open_multipart('iptu/enviar', $attributes); 
							 ?>							 <div class="form-group">                              <label class="col-sm-2 col-sm-2 control-label">Nome Im&oacute;vel</label>                              <div class="col-sm-4">								<input type="text"  id='nome' readonly='yes' name='nome' class="form-control" value=' <?php echo $imovel[0]->nome?>'   >                                                                                                </div>							                                <div class="col-sm-4">								                              </div>							</div>														<div class="form-group">														 <div class="col-sm-12">								<a href="<?php echo $this->config->base_url(); ?>assets/capas/<?php echo $imovel[0]->capa?>" download> Baixar Inscri&ccedil;&atilde;o</a>																					<!-- <img src="<?php //echo $this->config->base_url(); ?>assets/capas/<?php //echo $imovel[0]->id?>.jpg" width='400' height='400'> -- !>													</div>							</div>

														
							  </form>	  
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      