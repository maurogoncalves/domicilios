<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script><script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-editable.min.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/moment-with-locales.min.js"></script>		<script type="text/javascript">	$(document).ready(function(){		$( "#export" ).click(function() {		var estado = $('#estado').val();			var cidade = $('#cidade').val();			var cnpj = $('#cnpj').val();				$("#estadoExp").val(estado);		$("#cidadeExp").val(cidade);		$("#cnpjExp").val(cnpj);		$("#exportForm").submit();	});
});		
</script>		<div id="wrapper">                <div class="content-wrapper container">                    <div class="row">                        <div class="col-sm-12">                            <div class="page-title">                                <h1>Cnpjs Raiz <small>	</small></h1>                                <ol class="breadcrumb">                                                                        <li class="active">Lista de Cnpjs Raiz  </li>                                </ol>                            </div>                        </div>                    </div><!-- end .page title-->                    <div class="row">                        <div class="col-md-12">                            <div class="panel panel-card ">                                <!-- Start .panel -->                                <div class="panel-heading">                                    <h4 class="panel-title"> 										<a href="<?php echo $this->config->base_url();?>index.php/cnpj/cadastrar"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Novo CNPJ Raiz</a> 									&nbsp;		<?php if(!empty($mensagem)){ echo($mensagem); }?>											                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
                                 <div class="panel-body">
                                    <table id="basic-datatables" class="table table-bordered" cellspacing="0" width="100%">                                        <thead>                                            <tr>												  <th > CNPJ Raiz</th>												  <th > Empresa</th>                                            </tr>
                                        </thead>
                                        <tfoot>                                            <tr>
												<th > CNPJ Raiz</th>												<th > Empresa</th>                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php 		
										$isArray =  is_array($cnpjs) ? '1' : '0';			
										if(!$isArray == 0){											 foreach($cnpjs as $key => $emitente){ 											 ?>
												 <tr>
												 <td ><?php echo $emitente->cnpj_raiz; ?></td>																								 <td ><?php echo $emitente->empresa; ?></td>																								</td>																										 
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
