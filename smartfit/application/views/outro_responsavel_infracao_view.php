<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.mask.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>


<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Inserir Responsável <small> <?php echo utf8_encode($mensagemInfra);?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/infracoes/listar"><i class="fa fa-home"></i>Listar Infra&ccedil;&atilde;o</a></li>
                                    <li class="active">Inserir Responsável</li>
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
								echo form_open('infracoes/inserir_responsavel_infracao', $attributes); 
								?>
                                <div class="panel-body">
                                <div class="form-group">
								 <strong>        
								<div class="col-lg-12">									 
								 <label class="col-lg-4 control-label">Nome Loja : <?php echo $infracao[0]->nome_fantasia ?></label>							 								 
								 <label class="col-lg-4 control-label">CNPJ : <?php echo $infracao[0]->cpf_cnpj ?> </label>
								 </div>
								 </strong>		
								 <strong>        
								<div class="col-lg-12">									 
								 <label class="col-lg-3 control-label"> C&oacute;digo 1 : <?php echo $infracao[0]->cod1 ?></label>
								 <label class="col-lg-3 control-label">Bandeira : <?php echo $infracao[0]->bandeira ?> </label>
								 <label class="col-lg-3 control-label"> Regional : <?php echo $infracao[0]->regional ?></label>
								 </div>
								 </strong>		
								
                                </div>
								
								<div class="form-group">
								 </div>
                                <div class="form-group">
									<label class="col-lg-2 control-label">Nome Respons&aacute;vel</label>
                                    <div class="col-lg-6">
										<input type="text" id='emitente' name='emitente' class="form-control"   required=""  >										<!--
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
                                      	<input type="text" data-masked="" data-inputmask="'mask': '99/99/9999' " id='data_envio' name='data_envio' class="form-control"    >
                                    </div>
									
                                </div>
								
								<div class="form-group">
									<label class="col-lg-2 control-label">Posicionamento do Respons&aacute;vel</label>
                                    <div class="col-lg-4">

									<select name="posicionamento" id="posicionamento"  class='custom-select' style='width:350px;height:30px'>											
									  <option value="0">Escolha</option>									
									  <?php foreach($posicionamento as $pos){ ?>									
									  <option value="<?php echo $pos->id ?>"><?php echo $pos->descricao ?></option>									
									  <?php										  									  
									  }								 
									  ?>									
									</select>	
							  
                                    </div>
									<label class="col-lg-2 control-label">Probabilidade de &Ecirc;xito</label>
									<div class="col-lg-4">
									 <select name="probabilidade" id="probabilidade"  class='custom-select' style='width:350px;height:30px'>
									  <option value="0">Escolha</option>									
									  <?php foreach($probabilidade as $prob){ ?>									
									  <option value="<?php echo $prob->id ?>"><?php echo $prob->descricao ?></option>	
									  <?php										  									  
									  }								 
									  ?>									
									  </select>	
									</div>
									
                                </div>
				
								
								
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if($visitante == 0){ ?>
										<input type="hidden" id='id' name='id'  value='<?php echo $infracao[0]->id_infracao; ?>'>  
                                        <button class="btn btn-white" type="submit">Cancelar</button>
                                        <button class="btn btn-primary" type="submit">Salvar</button>
										<?php } ?>
                                    </div>
                                </div>
                            </form>
							 <table class="table table-fixedheader  table-striped table-advance table-hover " >
	                  	  	  <h4><i class="fa fa-angle-right"></i> Lista de Respons&aacute;veis
							  &nbsp;			
							  </h4>	                  	  	 
							  <hr>                              
							  <thead>                             
							  <tr>								  
							  <th width="10%"> Infra&ccedil;&atilde;o</th>	                                  
							  <th width="20%"> Nome</th>
							  <th width="15%"> Posic. Resp.</th>								  
							  <th width="13%"> Prob. &Ecirc;xito</th>	
							  <th width="12%"> Data Envio</th>                                  
							  <th width="10%">A&ccedil;&otilde;es</th>                              
							  </tr>                              
							  </thead>                              
							  <tbody id='lista'>                              								
							  <?php 									
								$isArray =  is_array($dadosResp) ? '1' : '0';								
									if($isArray == 0){ ?>								
									<tr>								 
									<td colspan='7'><a href="#">N&atilde;o H&aacute Registros</td>
									</tr>																
									<?php 									 
									}else{									 
									foreach($dadosResp as $key => $emitente){ 
									?>									 
									<tr>									  
									<td width="10%"><a href="#"><?php echo $emitente->cod_infracao; ?></a></td>	
									<td width="20%"><a href="#"><?php echo $emitente->responsavel; ?></a></td>
									<td width="15%"><a href="#"><?php echo $emitente->posicao; ?></a></td>
									<td width="13%"><a href="#"><?php echo $emitente->probal; ?></a></td>	
									<td width="12%"><span style='font-weight:bold' label-mini"><?php echo $emitente->data_envio_br; ?></span></td>									  
									<td width="10%">										  
										<a href="<?php echo $this->config->base_url();?>index.php/infracoes/excluir_resp?id=<?php echo $emitente->id_resp; ?>" class="btn btn-danger btn-xs" title='Excluir'><i class="fa fa-trash-o "></i></a>										  
										<a href="<?php echo $this->config->base_url();?>index.php/infracoes/editar_responsavel?id=<?php echo $emitente->id_resp; ?>" class="btn btn-success btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>									  
										</td>									  
										</tr>									  
										<?php									  
										}								  
										}								  
										?>                                                                                         
										</tbody>                          
										</table>	
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div> 
            </div>
      