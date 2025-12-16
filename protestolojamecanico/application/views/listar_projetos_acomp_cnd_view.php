<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-1.8.3.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
			 
$( "#estado" ).change(function() {
		var estado = $('#estado').val();	
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/listarCidade?estado=" + estado,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						$('#municipio').html(data);
					}						
				}
			 }); 		

	$.ajax({

				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/listarLojasByIdDCidadeEstado?id=" + estado+"&tipo=2",
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	

					if (data == undefined ) {
						console.log('Undefined');
					} else {

						$('#lista').html(data);
						$('#paginacao').hide();
						$('#bandeira').val(0);
					}
						
				}
			 }); 
						 
				
			
	});
	
$( "#municipio" ).change(function() {

		var municipio = $('#municipio').val();	
		
		$.ajax({

				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/listarLojas?cidade=" + municipio,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	

					if (data == undefined ) {
						console.log('Undefined');
					} else {

						$('#imovel').html(data);
					}
						
				}
			 }); 	

	$.ajax({

				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/listarLojasByIdDCidadeEstado?id=" + municipio+"&tipo=3",
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	

					if (data == undefined ) {
						console.log('Undefined');
					} else {

						$('#lista').html(data);
						$('#paginacao').hide();
						$('#bandeira').val(0);
					}
						
				}
			 }); 						 
				
				 
				
			
	});
		
	$( "#imovel" ).change(function() {

		var id = $('#imovel').val();	
	
		
		$.ajax({

				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/listarLojasByIdDCidadeEstado?id="+ id+"&tipo=1",
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	

					if (data == undefined ) {
						console.log('Undefined');
					} else {

						$('#lista').html(data);
						$('#paginacao').hide();
						$('#bandeira').val(0);
					}
						
				}
			 }); 			
				
			
	});
	
	$( "#ano" ).change(function() {

		var id = $('#ano').val();
		var estado = $('#estado').val();	
		var municipio = $('#municipio').val();	
		var imovel = $('#imovel').val();		
		
		$.ajax({

				url: "<?php echo $this->config->base_url(); ?>index.php/loja/buscaBandeira?id=" + id+'&estado='+estado+'&municipio='+municipio+'&imovel='+imovel,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){	

					if (data == undefined ) {
						console.log('Undefined');
					} else {

						$('#lista').html(data);
						$('#paginacao').hide();
						$('#bandeira').val(0);
					}
						
				}
			 }); 

			$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/tipoDebito?area=" + area,
				type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 
				contentType: "application/json; charset=utf-8",
				dataType: 'json', /* Tipo de transmiss&atilde;o */
				success: function(data){
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						$('#tipo_debito').html(data);
					}
				}
			});			 
				
			
	});
	
	
	$( "#limpar" ).click(function() {
		location.reload();
	});
	
	$( "#export" ).click(function() {
		var id_loja = $('#imovel').val();	
		
		var municipio = $('#municipio').val();	
		var estado = $('#estado').val();	
		/*
		alert(id_loja);
		alert(municipio);
		alert(estado);
		*/
		if((id_loja == '0') && (municipio == '0') && (estado == '0'))  {

			$("#id").val(id_loja);
			$("#tipo").val(0);
			$("#export_form").submit();
		}else{		
			if(id_loja != '0'){
				$("#id").val(id_loja);
				$("#tipo").val(1);
				$("#export_form").submit();
			}else{
				if(municipio == '0'){	
					$("#id").val(estado);
					$("#tipo").val(2);
					$( "#export_form" ).submit();
				}else{
					$("#id").val(municipio);
					$("#tipo").val(3);
					$( "#export_form" ).submit();
				}
			}
		}
	});
	
});		
</script>
          <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row mt">
                  <div class="col-md-12">
				  <span class='pull-right' style='font-weight:bold'>
 					<?php echo utf8_encode($this->session->flashdata('mensagem')); ?>
				  </span>
				  <a id='export' href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/cadastrar_proj" class="btn btn-primary btn-xs"><i class="fa fa-file-excel-o"></i> Cadastrar Novo Projeto</a>
				  &nbsp;

                      <div class="content-panel" style='height:500px'>
						 
                          <table class="table table-fixedheader  table-striped table-advance table-hover " >
	                  	  	  <h4><i class="fa fa-angle-right"></i> Lista 
							  &nbsp;

							  </h4>
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th width="25%"> Nome Projeto</th>
                                  <th width="15%">A&ccedil;&otilde;es</th>
                              </tr>
                              </thead>
                              <tbody id='lista'>
                              
								 <?php 	
								$isArray =  is_array($emitentes) ? '1' : '0';
								if($isArray == 0){ ?>
								<tr>
								  <td colspan='7'><a href="#">N&atilde;o H&aacute Registros</td>
								  </tr>
								
								<?php 	
								 }else{
									 foreach($emitentes as $key => $emitente){ 									 
									 ?>
									 <tr>
									  <td width="25%"><?php echo $emitente->descricao; ?></td>
									  
									  <td width="15%">
										  <a href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/ativar?id=<?php echo $emitente->id; ?>" class="btn btn-success btn-xs" title='Ativar'><i class="fa fa-check"></i></a>
										  <a href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/editar_proj?id=<?php echo $emitente->id; ?>" class="btn btn-primary btn-xs" title='Editar'><i class="fa fa-pencil"></i></a>
										  <a href="<?php echo $this->config->base_url();?>index.php/acomp_cnd/excluir?id=<?php echo $emitente->id; ?>" class="btn btn-danger btn-xs" title='Inativar'><i class="fa fa-trash-o "></i></a>
									  </td>
									  </tr>
									  <?php
									  }
								  }
								  ?>
                              
                             
                              </tbody>
                          </table>
						 <p id='paginacao'>	
						  <?php echo$paginacao; ?>
						  </p>
						  
						<form  id='export_form' action='<?php echo $this->config->base_url(); ?>index.php/acomp_cnd/export' method='post'>
							<input type='hidden' id='id' name='id'>							
							<input type='hidden' id='tipo' name='tipo'>
						</form>
	
                      </div><!-- /f
					  -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      
	  