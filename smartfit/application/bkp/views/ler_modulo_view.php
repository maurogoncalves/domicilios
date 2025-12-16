<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
   
   
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row mt">
                  <div class="col-lg-12">
				  
				  <span class='pull-right' style='font-weight:bold'>
						<?php if(!empty($mensagem)){
							echo utf8_encode($mensagem); 
						}		
						?>
					</span>
					
                      <div class="form-panel">
					
							 <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open('emitente/atualizar_emitente', $attributes); 
							 ?>
							 <div class="form-group">
                              <label class="col-sm-12 col-sm-12 control-label"> <h2>M&oacute;dulo <?php echo $info[0]->modulo; ?> </h2></label>
							</div>
							 <div class="form-group">
                              <label class="col-sm-12 col-sm-12 control-label">
							  <?php echo $info[0]->conteudo;?>
							  </label>
							</div>		
			
														
							  </form>	  
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      