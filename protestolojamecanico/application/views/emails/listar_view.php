<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script><script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>		<div id="wrapper">                <div class="content-wrapper container">                    <div class="row">                        <div class="col-sm-12">                            <div class="page-title">                                <h1>Emails <small>	</small></h1>                                <ol class="breadcrumb">                                                                        <li class="active">Lista de Emails </li>                                </ol>                            </div>                        </div>                    </div><!-- end .page title-->                    <div class="row">                        <div class="col-md-12">                            <div class="panel panel-card ">                                <!-- Start .panel -->                                <div class="panel-heading">                                    <h4 class="panel-title"> 									<a href="<?php echo $this->config->base_url();?>index.php/email/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Novo Email</a> 									</h4>                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                 <div class="panel-body">
                                    <table id="basic-datatables" class="table table-bordered" cellspacing="0" width="100%">                                        <thead>                                            <tr>												  <th > Nome  </th>												  <th > Email  </th>												  <th > Cargo </th>												  <th > A&ccedil;&otilde;es</th>								  
                                            </tr>
                                        </thead>
                                        <tfoot>                                            <tr>
												   <th > Nome  </th>												  <th > Email  </th>												  <th > Cargo </th>												  <th > A&ccedil;&otilde;es</th>						                                              </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($deptos) ? '1' : '0';			
										if(!$isArray == 0){											 foreach($deptos as $key => $emitente){ 											 ?>
												 <tr>
												 <td ><?php echo $emitente->nome; ?></td>																								 <td ><?php echo $emitente->email; ?></td>												<td ><?php echo $emitente->cargo; ?></td>													 												<td >												<a href="<?php echo $this->config->base_url();?>index.php/email/editar?id=<?php echo $emitente->id; ?>" class="btn"><i class="fa fa-pencil"></i></a>												<a href="<?php echo $this->config->base_url();?>index.php/email/excluir?id=<?php echo $emitente->id; ?>" class="btn"><i class="fa fa-trash"></i></a>												</td>													
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
                    </div><!--end .row-->                </div> 
            </div><form  id='exportForm' action='<?php echo $this->config->base_url(); ?>index.php/cnpj/export' method='post'>							<input type='hidden' id='estadoExp' name='estado'>	<input type='hidden' id='cidadeExp' name='cidade' >		<input type='hidden' id='cnpjExp' name='cnpj' value=''>				  						  		  						  </form>
