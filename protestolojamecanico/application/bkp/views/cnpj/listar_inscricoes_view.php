<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script><script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script><script type="text/javascript">	$(document).ready(function(){	$( "#export" ).click(function() {				$("#exportForm").submit();	});
});		
</script>		<div id="wrapper">                <div class="content-wrapper container">                    <div class="row">                        <div class="col-sm-12">                            <div class="page-title">                                <h1>Cnpjs <small>	</small></h1>                                <ol class="breadcrumb">                                       <li class="active">Lista de Inscri&ccedil&otilde;es <?php echo$tipoDesc?></li>                                </ol>                            </div>                        </div>                    </div><!-- end .page title-->                    <div class="row">                        <div class="col-md-12">                            <div class="panel panel-card ">                                <!-- Start .panel -->                                <div class="panel-heading">                                    <h4 class="panel-title"> 									<a href="#" title='Nova Inscri&ccedil&atilde;o' data-toggle="modal" data-target="#cadastro" ><i class="fa fa-plus"></i> Nova Inscri&ccedil&atilde;o</a>									&nbsp;				  																		<a id='export' href="#"><i class="fa fa-file-excel-o"></i> Exportar para Excel</a>	&nbsp;									</h4>                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                 <div class="panel-body">
                                    <table id="basic-datatables" class="table table-bordered" cellspacing="0" width="100%">                                        <thead>                                            <tr>												  <th > N&uacute;mero de Inscri&ccedil&otilde;es </th>												  <th > Cnpj</th>												  <th > CNPJ Raiz </th>                                            </tr>
                                        </thead>
                                        <tfoot>                                            <tr>
												  <th > N&uacute;mero de Inscri&ccedil&otilde;es </th>												  <th > Cnpj</th>												  <th > CNPJ Raiz </th>                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($cnpjs) ? '1' : '0';			
										if(!$isArray == 0){											 foreach($cnpjs as $key => $emitente){ 											 ?>
												 <tr>
												 <td ><?php echo $emitente->numero; ?></td>																								 <td ><?php echo $emitente->cnpj; ?></td>																								 <td ><?php echo $emitente->cnpj_raiz; ?></td>												</tr>
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
            </div>			<form  id='exportForm' action='<?php echo $this->config->base_url(); ?>index.php/cnpj/exportInscricoes' method='post'>											<input type="hidden" readonly='yes' name='cnpjExp' id='cnpjExp'  class="form-control" value='<?php echo$idCnpj ?>' > 				<input type="hidden" readonly='yes' name='tipoExp' id='tipoExp'  class="form-control" value='<?php echo$tipo ?>' > 			</form>				<div id="cadastro" class="modal fade" role="dialog">				  <div class="modal-dialog">					<div class="modal-content">					  <div class="modal-header">						<button type="button" class="close" data-dismiss="modal">&times;</button>						<h4 class="modal-title">Cadastro Inscri&ccedil&atilde;o </h4>					  </div>					  <div class="modal-body">						 <?php								$attributes = array('class' => 'form-horizontal style-form');								echo form_open_multipart('cnpj/inserirInscricao', $attributes); 						?>														 <div class="form-group">									<label class="col-lg-2 control-label">N&uacute;mero</label>                                    <div class="col-lg-8">										<input type="text"  name='numero' id='numero'  class="form-control" value='' > 										<input type="hidden" readonly='yes' name='op' id='op'  class="form-control" value='0' > 										<input type="hidden" readonly='yes' name='id' id='id'  class="form-control" value='0' > 										<input type="hidden" readonly='yes' name='idCnpj' id='idCnpj'  class="form-control" value='<?php echo$idCnpj ?>' > 										<input type="hidden" readonly='yes' name='tipo' id='tipo'  class="form-control" value='<?php echo$tipo ?>' >                                     </div>                                </div>															 <button type="submit" class="btn btn-success">Salvar</button>								</form>	  								 						  					  </div>					  <div class="modal-footer">						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>					  </div>					</div>				  </div>				</div>