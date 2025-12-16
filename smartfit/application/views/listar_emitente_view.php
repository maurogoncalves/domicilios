	
     <?php include('header_include.php');?>
        <section class="page">

               <?php include('sidebar.php');?>


            <div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Empresas <small> <?php echo utf8_encode($mensagemEmitente);?></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Lista de Empresas</li>
									
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-card ">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Lista de Empresas 
									&nbsp;&nbsp; 
									<a href="<?php echo $this->config->base_url();?>index.php/emitente/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Nova Empresa</a>
									&nbsp;&nbsp; 
									<a href="<?php echo $this->config->base_url();?>index.php/emitente/export"> <i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;Export</a>
									</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table id="basic-datatables" class="table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th> Raz&atilde;o Social</th>
                                                <th>Nome Fantasia</th>
                                                <th>Tipo de Emitente</th>
                                                <th>Ativo</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
												<th> Raz&atilde;o Social</th>
                                                <th>Nome Fantasia</th>
                                                <th>Tipo de Emitente</th>
                                                <th>Ativo</th>
                                                <th>A&ccedil;&otilde;es</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 	
								
								$isArray =  is_array($emitentes) ? '1' : '0';			
								if($isArray == 0){ 
	
								 }else{								 
								 foreach($emitentes as $key => $emitente){ 	

								if($emitente->ativo == 1){
									$ativo = "Sim";
								}else{
									$ativo = "N&atilde;o";
								}
									
								 ?>
								  <tr>
                                                <td><?php echo $emitente->razao_social.'-'.$emitente->id_contratante ?></td>
                                                <td><?php echo ($emitente->nome_fantasia); ?></td>
                                                <td><?php echo $emitente->descricao; ?></td>
                                                <td><?php echo $ativo; ?></td>
                                                <td>
													
													<a href="<?php echo $this->config->base_url();?>index.php/emitente/editar?id=<?php echo $emitente->id; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>
												</td>
                                            </tr>
											
								 
								  <?php
								  }//fim foreach
								  }//fim if
								  ?>
								  
                                           
                                          

                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- End .panel -->  
                        </div><!--end .col-->
                    </div><!--end .row-->


                </div> 
            </div>
        </section>