<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $this->config->base_url(); ?>assets/js/autoNumeric.js"></script>
<script type="text/javascript">
jQuery(function($) {
    $('.auto').autoNumeric('init');
});		

$(document).ready(function(){	

	 $('input').keypress(function (e) {
        var code = null;
        code = (e.keyCode ? e.keyCode : e.which);                
        return (code == 13) ? false : true;
   });

   $('#form').submit(function(event){
		  if (form.checkValidity()) {
			send.attr('disabled', 'disabled');
		  }
		});
		
		
		
	var mask = {
		 money: function() {
		var el = this,exec = function(v) {
			v = v.replace(/\D/g,"");
			v = new String(Number(v));
			var len = v.length;
			if (1== len)
				v = v.replace(/(\d)/,"0.0$1");
			else if (2 == len)
				v = v.replace(/(\d)/,"0.$1");
			else if (len > 2) {
				v = v.replace(/(\d{2})$/,'.$1');
			}
		return v;
		};
		setTimeout(function(){
		el.value = exec(el.value);
		},1);
	}}
	
	var maiorReceita  = $("#maiorReceita").val();
	

	$("#<?php echo $maiorReceita[0]->maior_receita;?>" ).blur(function() {
		switch(<?php echo $maiorReceita[0]->maior_receita;?>) {
		case 1:
			var primeiro = $("#1").val();
			if(primeiro=="" || primeiro == undefined){
				primeiro = '0,00';
			}
			primeiro = primeiro.replace(".","");
			primeiro = primeiro.replace(",",".");
			primeiro = parseFloat( primeiro );

			var total = primeiro;
total = total.toFixed(2);
			
			 $.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/converter?total=" + total,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){						
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						//$('#totalVlrPago').val(data);
						$("#totalComposicao").val(data);
					}
						
				}
			 });
		break;
		case 2:
			var primeiro = $("#1").val();
			var segundo = $("#2").val();	
			if(primeiro=="" || primeiro == undefined){
				primeiro = '0,00';
			}
			if(segundo=="" || segundo == undefined){
				segundo = '0,00';
			}
			
			primeiro = primeiro.replace(".","");
			primeiro = primeiro.replace(",",".");
			segundo = segundo.replace(".","");
			segundo = segundo.replace(",",".");			
			
			primeiro = parseFloat( primeiro );
			segundo = parseFloat( segundo );
			
			
			var total = primeiro + segundo ;
total = total.toFixed(2);
			
			 $.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/converter?total=" + total,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){						
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						//$('#totalVlrPago').val(data);
						$("#totalComposicao").val(data);
					}
						
				}
			 });			
			break;
		case 3:
			var primeiro = $("#1").val();
			var segundo = $("#2").val();	
			var terceiro = $("#3").val();
			
			
			if(primeiro=="" || primeiro == undefined){
				primeiro = '0,00';
			}
			if(segundo=="" || segundo == undefined){
				segundo = '0,00';
			}
			
			if(terceiro=="" || terceiro == undefined){
				terceiro = '0,00';
			}
			
			primeiro = primeiro.replace(".","");
			primeiro = primeiro.replace(",",".");
			
			segundo = segundo.replace(".","");
			segundo = segundo.replace(",",".");			
			
			terceiro = terceiro.replace(".","");
			terceiro = terceiro.replace(",",".");			
			
			primeiro = parseFloat( primeiro );
			segundo = parseFloat( segundo );
			terceiro = parseFloat( terceiro );
			
			var total =primeiro + segundo + terceiro  ;
			$("#totalComposicao").val(total);
			$("#totalComposicao").trigger('blur');				
			break;
		case 4:
			var primeiro = $("#1").val();
			var segundo = $("#2").val();	
			var terceiro = $("#3").val();
			var quarto = $("#4").val();
			
			
			if(primeiro=="" || primeiro == undefined){
				primeiro = '0,00';
			}
			if(segundo=="" || segundo == undefined){
				segundo = '0,00';
			}
			
			if(terceiro=="" || terceiro == undefined){
				terceiro = '0,00';
			}
			
			if(quarto=="" || quarto == undefined){
				quarto = '0,00';
			}
			
			primeiro = primeiro.replace(".","");
			primeiro = primeiro.replace(",",".");
			
			segundo = segundo.replace(".","");
			segundo = segundo.replace(",",".");			
			
			terceiro = terceiro.replace(".","");
			terceiro = terceiro.replace(",",".");			

			quarto = quarto.replace(".","");
			quarto = quarto.replace(",",".");			
			
			primeiro = parseFloat( primeiro );
			segundo = parseFloat( segundo );
			terceiro = parseFloat( terceiro );
			quarto = parseFloat( quarto );
			
			var total =primeiro + segundo + terceiro + quarto ;
total = total.toFixed(2);
			
			 $.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/converter?total=" + total,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){						
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						//$('#totalVlrPago').val(data);
						$("#totalComposicao").val(data);
					}
						
				}
			 });

			break;		
		case 5:
			var primeiro = $("#1").val();
			var segundo = $("#2").val();	
			var terceiro = $("#3").val();
			var quarto = $("#4").val();
			var quinto = $("#5").val();
			
			
			if(primeiro=="" || primeiro == undefined){
				primeiro = '0,00';
			}
			if(segundo=="" || segundo == undefined){
				segundo = '0,00';
			}
			
			if(terceiro=="" || terceiro == undefined){
				terceiro = '0,00';
			}
			
			if(quarto=="" || quarto == undefined){
				quarto = '0,00';
			}
			
			if(quinto=="" || quinto == undefined){
				quinto = '0,00';
			}
			
			primeiro = primeiro.replace(".","");
			primeiro = primeiro.replace(",",".");
			
			segundo = segundo.replace(".","");
			segundo = segundo.replace(",",".");			
			
			terceiro = terceiro.replace(".","");
			terceiro = terceiro.replace(",",".");			

			quarto = quarto.replace(".","");
			quarto = quarto.replace(",",".");			
			
			quinto = quinto.replace(".","");
			quinto = quinto.replace(",",".");			
			
			primeiro = parseFloat( primeiro );
			segundo = parseFloat( segundo );
			terceiro = parseFloat( terceiro );
			quarto = parseFloat( quarto );
			quinto = parseFloat( quinto );
			
			var total =primeiro + segundo + terceiro + quarto + quinto;
			total = total.toFixed(2);
			
			 $.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/converter?total=" + total,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){						
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						//$('#totalVlrPago').val(data);
						$("#totalComposicao").val(data);
					}
						
				}
			 });
			break;		
		case 6:
			var primeiro = $("#1").val();
			var segundo = $("#2").val();	
			var terceiro = $("#3").val();
			var quarto = $("#4").val();
			var quinto = $("#5").val();
			var sexto = $("#6").val();
			
			
			if(primeiro=="" || primeiro == undefined){
				primeiro = '0,00';
			}
			if(segundo=="" || segundo == undefined){
				segundo = '0,00';
			}
			
			if(terceiro=="" || terceiro == undefined){
				terceiro = '0,00';
			}
			
			if(quarto=="" || quarto == undefined){
				quarto = '0,00';
			}
			
			if(quinto=="" || quinto == undefined){
				quinto = '0,00';
			}

			if(sexto=="" || sexto == undefined){
				sexto = '0,00';
			}
			
			primeiro = primeiro.replace(".","");
			primeiro = primeiro.replace(",",".");
			
			segundo = segundo.replace(".","");
			segundo = segundo.replace(",",".");			
			
			terceiro = terceiro.replace(".","");
			terceiro = terceiro.replace(",",".");			

			quarto = quarto.replace(".","");
			quarto = quarto.replace(",",".");			
			
			quinto = quinto.replace(".","");
			quinto = quinto.replace(",",".");			

			sexto = sexto.replace(".","");
			sexto = sexto.replace(",",".");			
			
			primeiro = parseFloat( primeiro );
			segundo = parseFloat( segundo );
			terceiro = parseFloat( terceiro );
			quarto = parseFloat( quarto );
			quinto = parseFloat( quinto );
			sexto = parseFloat( sexto );

			
			var total = primeiro + segundo + terceiro + quarto + quinto + sexto;
			//total = total.replace(".","");
			//total = total.replace(",",".");		
			total = total.toFixed(2);
			
			
			 $.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/converter?total=" + total,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){						
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						//$('#totalVlrPago').val(data);
						$("#totalComposicao").val(data);
					}
						
				}
			 });
			 
			//$("#totalComposicao").val(total);

			//$("#totalComposicao").trigger('blur');			
			break;		
		}
		

			
	}); 	
	
	$( "#mes" ).change(function() {
	
		var mes = $('#mes').val();	
		var idSubLocacao = $('#idSubLocacao').val();	
		var campo = 1;
		var soma = 0;
		$.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/buscaValores?mes=" + mes+'&idSubLoc='+idSubLocacao,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){						
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						$.each(data, function(i, item) {
							
							$('#'+item.receita).val(item.valor_pago);	
							campo++;
							
							
							if(item.valor_pago=="" || item.valor_pago == undefined){
								valor = '0,00';
								$('#totalComposicao').val(valor);	
								$('#totalVlrPago').val(valor);	
							}else{
							
								var valor = item.valor_pago.replace(".","");
								valor = item.valor_pago.replace(",",".");
								valor = parseFloat( valor );
								
								soma = soma + valor;
								//soma = soma.toFixed(2);
								$('#totalComposicao').val(soma);	
								
								
							
							}
							
							$("#<?php echo $maiorReceita[0]->maior_receita;?>").trigger('blur');							
							$('#totalComposicao').focus();	
							$("#totalComposicao").trigger('blur');
							$('#1').focus();	
							
						});
						//$('#dados_formulario').html(data);
					}
						
				}
			 }); 	
			 
			 $.ajax({
				url: "<?php echo $this->config->base_url(); ?>index.php/sublocacoes/buscarTotal?mes=" + mes+'&idSubLoc='+idSubLocacao,
				type : 'GET', /* Tipo da requisição */ 
				contentType: "application/json; charset=utf-8",
	        	dataType: 'json', /* Tipo de transmissão */
				success: function(data){						
					if (data == undefined ) {
						console.log('Undefined');
					} else {
						$('#totalVlrPago').val(data);
					}
						
				}
			 });
	
	});


});	
</script>

         
		 

<div id="wrapper">
					<div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>SubLoca&ccedil;&atilde;o <small>		</small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo $this->config->base_url();?>index.php/sublocacoes/listar"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Composi&ccedil;&atilde;o</li>
									
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->
            
                    <div class="row">                       
                        <div class="col-md-12">
                            <div class="panel panel-card margin-b-30">
                                <!-- Start .panel -->
                                <div class="panel-heading">
                                    <h4 class="panel-title"> Informa&ccedil;&otilde;es da Composi&ccedil;&atilde;o</h4>
                                    <div class="panel-actions">
                                        <a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
                                        <a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
                                    </div>
                                </div>
								<?php
								$attributes = array('class' => 'form-horizontal style-form','id' => 'form' );
								echo form_open('sublocacoes/baixar_parcela', $attributes); 
								?>
                                <div class="panel-body">
								    
                                <div class="form-group">
									<label class="col-lg-2 control-label">Dados</label>
                                    <div class="col-lg-8">
										Locador:
										  <?php echo $dados[0]->locador; ?>							  
										  <br>
										  Locat&aacuterio:
										  <?php echo $dados[0]->locatario; ?>							  
										  <br>
										  Vig&ecirc;ncia:
										  <?php echo $dados[0]->data_ini_vigencia_br; ?> a <?php echo $dados[0]->data_fim_vigencia_br; ?>				  
											<BR>
										  <?php if(!empty($ultimaAlteracao[0]->email)){ ?> 
											Criado/Alterado por: &nbsp;
											<?php echo $ultimaAlteracao[0]->email;} ?> 				  
										  <BR>
										   <?php if(!empty($ultimaAlteracao[0]->data)){ ?> 
											Data Cria&ccedil;&atilde;o/Altera&ccedil;&atilde;o : &nbsp;
											<?php echo $ultimaAlteracao[0]->data;} ?>
										  <BR>	
										  <BR>							
                                    </div>
								
                                </div>
								 
								  <div class="form-group">
									<label class="col-lg-2 control-label">M&ecirc;s de Vencimento</label>
                                    <div class="col-lg-4">
										<select name="mes" id="mes" required=""  class='custom-select' style='width:350px;height:30px'>
										<option value="0" selected>Escolha</option>	
										  <?php foreach($meses as $key => $mes){ ?>
												<option value="<?php echo $mes->data_vencimento ?>"><?php echo $mes->mes_vencimento?></option>
										  <?php
											  }								  
										  ?>
										</select>     										
                                    </div>
									
                                </div>
											
											
								  <div id='dados_formulario' >
									  <?php 
									
									
									$isArray =  count($receitas);			
									if($isArray == 0){ 					
									}else{ 
										$j=1;
										foreach($receitas as $key => $rec){
										?>
										<div class="form-group" >										
										<label class="col-lg-2 control-label"><?php echo $rec->descricao_receita; ?></label>
										<div class="col-lg-4">
											<input type="text" tabindex="<?php echo $j; ?>" id='<?php echo $rec->id; ?>' name='receita_<?php echo $rec->id; ?>'  data-a-dec="," data-a-sep="."  class="auto form-control" value="" >
										</div>
										</div>
										<?php 	
										$j++;
										}
									} ?>
								
								   </div>
								
                               		 <div class="form-group">
									
									<label class="col-lg-2 control-label">Total Composi&ccedil;&atilde;o</label>
									<div class="col-lg-4">
										<input type="text" id='totalComposicao'  name='totalComposicao'  tabindex="<?php echo $maiorReceita[0]->maior_receita+1; ?>"   class="form-control" value="" >
                                    </div>
									
									</div>
									
									<div class="form-group">
									<label class="col-lg-2 control-label">Total Valor Pago </label>
									<div class="col-lg-4">
									<input type="text" id='totalVlrPago' name='totalVlrPago' tabindex="<?php echo $maiorReceita[0]->maior_receita+2; ?>"  data-a-dec="," data-a-sep="."  class="auto form-control" value="" >
									</div>							
									</div>	
								
								<div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
										<?php if($visitante == 0){ ?>
										<input type="hidden"  id='idSubLocacao' name='idSubLocacao' value="<?php echo $dados[0]->idsub; ?>" >	
										<input type="hidden"  id='maiorReceita' name='maiorReceita' value="<?php echo $maiorReceita[0]->maior_receita; ?>" >	
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
