<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.mask.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script> <script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script><script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script><script type="text/javascript">jQuery(function($) {    $('.auto').autoNumeric('init');});</script>
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row mt">
                  <div class="col-lg-12">
				  
				  <a  href="listar" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Listar Im&oacute;vel</a>
				  <span class='pull-right' style='font-weight:bold'>
						<?php if(!empty($mensagem)){
							echo utf8_encode($mensagem); 
						}		
						?>
					</span>
					
                      <div class="form-panel">
					
							 <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open_multipart('iptu/atualizar_iptu', $attributes); 
							 ?>							 <div class="form-group">                              <label class="col-sm-2 col-sm-2 control-label">Nome Im&oacute;vel</label>                              <div class="col-sm-4">                                 <?php echo $imovel[0]->nome ?>                              </div>							  							  <label class="col-sm-2 col-sm-2 control-label">Informa&ccedil;&otilde;es Inclusas</label>                              <div class="col-sm-4">									                                    <select name="informacoes" id="informacoes" required="">									  <option value="0">Escolha</option>										  <?php foreach($info_inc as $key => $info){ ?>										  										 <?php if($imovel[0]->info_inclusas == $info->id){ ?>										  											<option value="<?php echo $info->id ?>" selected ><?php echo $info->descricao?></option>											  <?php }else{ ?>										  											<option value="<?php echo $info->id ?>" selected ><?php echo $info->descricao?></option>											  										  <?php } ?>									  <?php									  }								  									  ?>									</select>								                                </div>							</div>														<div class="form-group">                              <label class="col-sm-2 col-sm-2 control-label">N&#186; Inscri&ccedil;&atilde;o</label>                              <div class="col-sm-4">                                  <input type="text"  id='inscricao' name='inscricao' class="form-control" required="" value='<?php echo $imovel[0]->inscricao ?>'   >								                                </div>							<label class="col-sm-2 col-sm-2 control-label">Valor do Carn&ecirc;</label>                              <div class="col-sm-4">                                  <input type="text" id='valor' name='valor' data-a-dec="," data-a-sep="."  class="auto form-control" value='<?php echo $imovel[0]->valor ?>' >                              </div>							  							</div>														
							 <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">&Aacute;rea Total (Mt)</label>
                              <div class="col-sm-4">
                                  <input type="text"  id='areaTotal' name='areaTotal' data-a-dec="," data-a-sep="." class="auto form-control" value='<?php echo $imovel[0]->area_total; ?>'  >								  
                              </div>							<label class="col-sm-2 col-sm-2 control-label">&Aacute;rea Construida (Mt)</label>                              <div class="col-sm-4">                                  <input type="text" id='areaConstruida' name='areaConstruida' data-a-dec="," data-a-sep="."  class="auto form-control"  value='<?php echo $imovel[0]->area_construida ?>' >                              </div>							  
							</div>							 							<div class="form-group">                              <label class="col-sm-2 col-sm-2 control-label">Nome Propriet&aacute;rio</label>                              <div class="col-sm-4">                                  <input type="text"  id='nome' name='nome' class="form-control" value='<?php echo $imovel[0]->nome_proprietario ?>'    >								                                </div>							<label class="col-sm-2 col-sm-2 control-label">Status na Prefeitura</label>                              <div class="col-sm-4">                                  <input type="text" id='status' name='status'  class="form-control" value='<?php echo $imovel[0]->status_prefeitura ?>'>                              </div>							  							</div>														<div class="form-group">                              <label class="col-sm-4 col-sm-4 control-label">Observa&ccedil;&otilde;es</label>                              <div class="col-sm-8">                                  <input type="text"  id='observacoes' name='observacoes' class="form-control"  value='<?php echo $imovel[0]->observacoes ?>'   >								                                </div>						  							</div>							
							<div class="form-group">
                              <label class="col-sm-4 col-sm-4 control-label"></label>
                              <div class="col-sm-8">									<input type="hidden"  id='id' name='id' class="form-control"  value='<?php echo $imovel[0]->id ?>'   >
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
      