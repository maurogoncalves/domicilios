<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.mask.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script> 
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script><script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script><script type="text/javascript">jQuery(function($) {    $('.auto').autoNumeric('init');});</script>
    <script>		
		$(document).ready(function(){			//$('#areaTotal').bind('keypress',mask.money);			//$('#areaConstruida').bind('keypress',mask.money);
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
				  
				  <a  href="listar" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Listar CND's</a>
				  <span class='pull-right' style='font-weight:bold'>
						<?php if(!empty($mensagem)){
							echo utf8_encode($mensagem); 
						}		
						?>
					</span>
					
                      <div class="form-panel">
					
							 <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open_multipart('loja/enviar_acomp', $attributes); 
							 ?>							 <div class="form-group">                              <label class="col-sm-2 col-sm-2 control-label">Nome Emitente</label>                              <div class="col-sm-4">								<input type="text" name='nomeImovel' class="form-control"  required="" value='<?php echo $dados_acomp[0]->nome_fantasia; ?>'>								<input type="hidden"  id='id' name='id' class="form-control" value='<?php echo $imovel[0]->id?>'   >                                                                </div>							  							   <label class="col-sm-2 col-sm-2 control-label">CPF/CNPJ</label>                              <div class="col-sm-4">								<input type="text" name='nomeImovel' class="form-control"  required="" value='<?php echo $dados_acomp[0]->cpf_cnpj; ?>'>							    <input type="hidden" id='loja' name='loja'  value='<?php echo $dados_acomp[0]->id_loja; ?>'>								<input type="hidden" id='id' name='id'  value='<?php echo $dados_acomp[0]->id_acomp; ?>'>								</div>							</div>																									<div class="form-group">												  							  <label class="col-sm-2 col-sm-2 control-label">Inscri&ccedil;&atilde;o</label>                              <div class="col-sm-4">                                  <input type="text" name='nomeImovel' class="form-control"  required="" value='<?php echo $dados_acomp[0]->ins_cnd_mob; ?>'>                              </div>                                <div class="col-sm-4">								Upload CND (apenas pdf)								<input type="file" name="userfile" size="40">                              </div>							</div>								
							<div class="form-group">
                              <label class="col-sm-4 col-sm-4 control-label"></label>
                              <div class="col-sm-8">
                                  <button type="submit" class="btn btn-success">Salvar</button>	
                              </div>
							</div>	
														
							  </form>	  
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      