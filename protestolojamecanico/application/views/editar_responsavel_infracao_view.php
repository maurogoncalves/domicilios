<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.mask.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>


<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Atualizar Responsável <small> </small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/infracoes/listar"><i class="fa fa-home"></i>Listar Infra&ccedil;&atilde;o</a></li>
                                    <li class="active">Atualizar Responsável</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Inserir Outro Responsável </h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('infracoes/editar_responsavel_infracao', $attributes); 
								?>
                                <div class="panel-body">
                           
								
								<div class="form-group">
								 </div>
                                <div class="form-group">
									<label class="col-lg-2 control-label">Nome Respons&aacute;vel</label>
                                    <div class="col-lg-6">
										<input type="text" id='emitente' name='emitente' class="form-control"   required=""  value='<?php echo $dadosResp[0]->responsavel ?>' >										<!--
										<select name="emitente" id="emitente"  class='custom-select' style='width:350px;height:30px'>	
									  <option value="0">Escolha</option>									
									  <?php foreach($emitentes as $emitente){ ?>										
									  <option value="<?php echo $emitente->id ?>"><?php echo $emitente->nome_fantasia ?></option>																		
									  <?php										  									  
									  }								 
									  ?>									
									  </select> -->
							  
                                    </div>
									<label class="col-sm-2 control-label">Data de Envio ao Respons&aacute;vel</label>
                                    <div class="col-lg-2">
                                      	<input type="text" data-masked="" data-inputmask="'mask': '99/99/9999' " id='data_envio' name='data_envio' class="form-control" value='<?php echo $dadosResp[0]->data_envio_br; ?>'   >
                                    </div>
									
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Posicionamento do Respons&aacute;vel</label>
                                    <div class="col-lg-4">

									<select name="posicionamento" id="posicionamento"  class='custom-select' style='width:350px;height:30px'>											
									  <option value="0">Escolha</option>									
									  <?php foreach($posicionamento as $pos){ 									
										if($dadosResp[0]->posicao_resp == $pos->id ){									?>																			<option value="<?php echo $pos->id ?>" selected><?php echo $pos->descricao ?></option>																				<?php }else{?>																			<option value="<?php echo $pos->id ?>" ><?php echo $pos->descricao ?></option>																			<?php										  																			}}				
									  ?>									
									</select>	
							  
                                    </div>
									<label class="col-lg-2 control-label">Probabilidade de &Ecirc;xito</label>
									<div class="col-lg-4">
									 <select name="probabilidade" id="probabilidade"  class='custom-select' style='width:350px;height:30px'>
									  <option value="0">Escolha</option>									
									  <?php foreach($probabilidade as $prob){ 										if($dadosResp[0]->probabilidade_exito == $prob->id ){?>																			<option value="<?php echo $prob->id ?>"selected><?php echo $prob->descricao ?></option>																			<?php }else{?>																			<option value="<?php echo $prob->id ?>"><?php echo $prob->descricao ?></option>																		<?php										  									  										}}			
									  ?>									
									  </select>	
									</div>
									
                                </div>
				
								
								
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if($visitante == 0){ ?>
										<input type="hidden" id='id' name='id'  value='<?php echo $dadosResp[0]->id_resp; ?>'>  
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
      