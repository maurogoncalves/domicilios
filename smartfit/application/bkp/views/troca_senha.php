<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script><script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script> 
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script><script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script><script src='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.js'></script><link href='<?php echo $this->config->base_url(); ?>assets/js/jquery-customselect.css' rel='stylesheet' />	<script type="text/javascript">      jQuery(function($) { $('input').keypress(function (e) {        var code = null;        code = (e.keyCode ? e.keyCode : e.which);                        return (code == 13) ? false : true;   });    $('.auto').autoNumeric('init');		 $("#imovel").customselect();	 $("#proprietario").customselect();	 	 	});});</script>
    <script>		
		$(document).ready(function(){			 var possui = $("#possui" ).val();	 		if(possui == 1){			$("#data_vecto_cnd").text('Data Vencimento');		 }else  if(valor ==2){			$("#data_vecto_cnd").text('Data Vencimento');		 }else{			$("#data_vecto_cnd").text('Data Upload Pend\u00eancias');		 }						$( "input" ).on( "click", function() {			  var valor = $("input:checked" ).val();			  		  if(valor == 1){			$("#data_vecto_cnd").text('Data Vencimento');		  }else  if(valor ==2){			$("#data_vecto_cnd").text('Data Vencimento');					  }else{			$("#data_vecto_cnd").text('Data Upload Pend\u00eancias');		  }		});				//$('#areaTotal').bind('keypress',mask.money);			//$('#areaConstruida').bind('keypress',mask.money);			
			$('#cep').blur(function(){
				
			   var cep = $("#cep").val();
				   if(cep != '__.___-___'){
						$.ajax({
							url: "<?php echo $this->config->base_url(); ?>index.php/imovel/buscaCep?cep=" + cep,
							type : 'get', /* Tipo da requisi&ccedil;&atilde;o */ 
							contentType: "application/json; charset=utf-8",
							dataType: 'json', /* Tipo de transmiss&atilde;o */
							success: function(data){
								if(data !== 0){									
									$("#logradouro").val(data.rua);									$("#bairro").val(data.bairro);									$("#cidade").val(data.cidade);									$("#estado").val(data.estado);
								}
							}
						});
					}		
				})
				
		});

    </script>      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row mt">
                  <div class="col-lg-12">
				  
				  <span class='pull-right' style='font-weight:bold'>						<?php if(!empty($mensagem)){							echo utf8_encode($mensagem); 						}								?>						<bR>					</span>
				
                      <div class="form-panel">
					
							 <?php
								$attributes = array('class' => 'form-horizontal style-form');
								echo form_open_multipart('home/atualizar_senha', $attributes); 
							 ?>							 <div class="form-group">                              <label class="col-sm-4 col-sm-4 control-label">Nova Senha</label>                              <div class="col-sm-8">                                  									</select>									<input type="password" id='senha' name='senha' class="form-control"  value='' required=''>                              </div>							   </div>																	
							<div class="form-group">
                              <label class="col-sm-4 col-sm-4 control-label"></label>
                              <div class="col-sm-8">									<input type="hidden"  id='id' name='id' class="form-control"  value='<?php echo $id ?>'   >
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
      