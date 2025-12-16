      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row mt">
                  <div class="col-md-12">
				  
				  <a  href="<?php echo $this->config->base_url();?>index.php/loja/cadastrar" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Nova Loja</a>
				  &nbsp;
				  <a  href="<?php echo $this->config->base_url();?>index.php/loja/export" class="btn btn-primary btn-xs"><i class="fa fa-file-excel-o"></i> Exportar para CSV</a>
				  <span class='pull-right' style='font-weight:bold'>
						<?php if(!empty($mensagem)){
							echo utf8_encode($mensagem); 
						}		
					?>
				  </span>
                      <div class="content-panel">
						 
						  <table class="table table-fixedheader  table-striped table-advance table-hover " >
	                  	  	  <h4><i class="fa fa-angle-right"></i> Lista de Lojas - <a target='_blank' href="<?php echo $this->config->base_url();?>index.php/documentacao/ler?modulo=loja">Documenta&ccedil;&atildeo </a></h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th><i class="fa fa-bullhorn"></i> Nome</th>
								  <th><i class="fa fa-bookmark"></i> CPF/CNPJ</th>
                                  <th><i class="fa fa-bookmark"></i> C&oacute;d. 1</th>
								  <th><i class="fa fa-bookmark"></i> Bandeira</th>
								  <th><i class="fa fa-bookmark"></i> Tipo de Emitente</th>
								  <th><i class=" fa fa-bookmark"></i> CND Mobili&aacute;ria</th>
                                  <th><i class=" fa fa-edit"></i> Status</th>
                                  <th>A&ccedil;&otilde;es</th>
                              </tr>
                              </thead>
                              <tbody>
                              
								 <?php 	
								$isArray =  is_array($emitentes) ? '1' : '0';
								if($isArray == 0){ ?>
								<tr>
								  <td colspan='7'><a href="#">N&atilde;o H&aacute Registros</td>
								  </tr>
								
								<?php 	
								 }else{
									 foreach($emitentes as $key => $emitente){ 
									 //print($emitente->cnd);
									 if(empty($emitente->cnd)){	
										$cnd ='Nada Consta';
										$corCnd = '#990000';										 
									 }else{
										if($emitente->cnd == 1){
											$cnd ='Sim';
											$corCnd = '#000099';										
										}elseif($emitente->cnd == 2){
											$cnd ='N&atilde;o';
											$corCnd = '#000099';
										}elseif($emitente->cnd == 3){
											$cnd ='Pend&ecirc;ncia';
											$corCnd = '#000099';
										}else{
											$cnd ='Nada Consta';
											$corCnd = '#990000';
										}
									}
									 
									 ?>
									 <tr>
									  <td>
										<?php  
										if( $cnd <> 'Nada Consta') {?>
											<a href="<?php echo $this->config->base_url();?>index.php/cnd_mob/editar?id=<?php echo $emitente->id_cnd; ?>"><?php echo $emitente->razao_social; ?></a>
										<?php  }else{?>
											<a href="<?php echo $this->config->base_url();?>index.php/cnd_mob/cadastrar?id=<?php echo $emitente->id; ?>"><?php echo $emitente->razao_social; ?></a>
										<?php  }?>											
									  </td>
									  <td><a href="#"><?php echo $emitente->cpf_cnpj; ?></a></td>
									  <td class="hidden-phone"><?php echo $emitente->cod1; ?></td>
									  <td class="hidden-phone"><?php echo $emitente->bandeira; ?></td>
									  <td> <span style='font-weight:bold' label-mini"><?php echo $emitente->descricao; ?></span></td>
									  <td class="hidden-phone"><?php echo $cnd ; ?>  </td>
									  <td class="hidden-phone">
										<?php if($emitente->ativo == 1){
												echo"Ativo";
											}else{
												echo"Inativo";
											}
										?>
									  </td>
									  
									  <td>
										  <a href="<?php echo $this->config->base_url();?>index.php/loja/ativar?id=<?php echo $emitente->id; ?>" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
										  <a href="<?php echo $this->config->base_url();?>index.php/loja/editar?id=<?php echo $emitente->id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
										  <a href="<?php echo $this->config->base_url();?>index.php/loja/excluir?id=<?php echo $emitente->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
									  </td>
									  </tr>
									  <?php
									  }
								  }
								  ?>
                              
                             
                              </tbody>
                          </table>
						  <?php echo$paginacao; ?>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      