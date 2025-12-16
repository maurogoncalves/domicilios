<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Matricula_cei extends CI_Controller { 

function __construct(){   
parent::__construct();   

$this->load->model('matricula_cei_model','',TRUE);   
$this->load->model('acomp_cnd_model','',TRUE);   
$this->load->model('licenca_model','',TRUE);   
$this->load->model('log_model','',TRUE);   
$this->load->model('tipo_emitente_model','',TRUE);   
$this->load->model('user','',TRUE);   
$this->load->model('contratante','',TRUE);   
$this->load->model('emitente_model','',TRUE);   
$this->load->model('loja_model','',TRUE);   
$this->load->library('session');   
$this->load->library('form_validation');   
$this->load->helper('url'); 
$this->db->cache_on();
 session_start();

}  

function index(){   
	if( $_SESSION['login']) {     
	$session_data =  $_SESSION['login'];     
	$data['email'] = $session_data['email'];	 
	$data['empresa'] = $session_data['empresa'];	
	$data['perfil'] = $session_data['perfil'];	  
	redirect('home', 'refresh');   
	}else{     
	redirect('login', 'refresh');   
	} 
}    

 function editar_cei(){	  	
	 $session_data =  $_SESSION['login'];	
	 $idContratante = $_SESSION['cliente'] ;	
	 $emitente = $this->input->post('id_emitente');		
	 $imovel = $this->input->post('id_imovel');		
	 $loja = $this->input->post('id_loja');			
	 $id_cei = $this->input->post('id_cei');		
	 $cei = $this->input->post('cei');		
	 $data_abertura_cei = $this->input->post('data_abertura_cei');
	 $data_ini_obra = $this->input->post('data_ini_obra');	 
	 $tipo_empreitada = $this->input->post('tipo_empreitada');	
	 $tipo_obra = $this->input->post('tipo_obra');	
	 $status_obra = $this->input->post('status_obra');	
	 $averbado = $this->input->post('averbado');	
	 $area_existente = $this->input->post('area_existente');	
	 $area_reforma = $this->input->post('area_reforma');	
	 $area_demolicao = $this->input->post('area_demolicao');	
	 $area_acres_nova = $this->input->post('area_acres_nova');		
	 $area_total = $this->input->post('area_total');		
	 $alvara = $this->input->post('alvara');		
	 $projeto = $this->input->post('projeto');		
	 $contr_loc_matr_escr = $this->input->post('contr_loc_matr_escr');		
	 $habitese = $this->input->post('habitese');
	 $contrato_obra = $this->input->post('contrato_obra');	
	 $nota_fiscal = $this->input->post('nota_fiscal');	
	 $gps_2631 = $this->input->post('gps_2631');	
	 $relatorio_sefip = $this->input->post('relatorio_sefip');	

	 $observacoes = $this->input->post('obs');

	 $dataIniArr = explode('/',$data_ini_obra);
	/*
	 $cep = $this->input->post('cep');		
	 $numero = $this->input->post('numero');		
	 $logradouro = $this->input->post('logradouro');		
	 $bairro = $this->input->post('bairro');		
	 $cidade = $this->input->post('cidade');		
	 $estado = $this->input->post('estado');	
*/	 
	 $regional = $this->input->post('regional');		
	 $bandeira = $this->input->post('bandeira');			
	 $dataAberturaArr = explode('/',$data_abertura_cei);		
	 $dados = array('id_contratante' => $idContratante,					
	 'id_emitente' => $emitente,					
	 'id_imovel' => $imovel,							
	 'id_loja' => $loja,					
	 'cei' => $cei,					
	 'data_abertura' => $dataAberturaArr[2].'-'.$dataAberturaArr[1].'-'.$dataAberturaArr[0],
	 'data_inicio_obra' => $dataIniArr[2].'-'.$dataIniArr[1].'-'.$dataIniArr[0],		 
	 'tipo_empreitada' => $tipo_empreitada,					
	 'tipo_obra' => $tipo_obra,					
	 'status_obra' => $status_obra,					
	 'averbado' => $averbado,					
	 'area_existente' => $area_existente,					
	 'area_reforma' => $area_reforma,					
	 'area_acres_nova' => $area_acres_nova,					
	 'area_demolicao' => $area_demolicao,					
	 'area_total' => $area_total,					
	 'alvara' => $alvara,					
	 'projeto' => $projeto,					
	 'contr_loc_matr_escr' => $contr_loc_matr_escr,					
	 'habitese' => $habitese,					
	 'contrato_obra' => $contrato_obra,					
	 'nota_fiscal' => $nota_fiscal,					
	 'gps_2631' => $gps_2631,					
	 'relatorio_sefip' => $relatorio_sefip,						 
	 'regional' => $regional,					
	 'bandeira' => $bandeira,					
	 'observacoes' => $observacoes,
	 'ativo' => 1				
	 );						
	 if($this->matricula_cei_model->atualizar($dados,$id_cei)) {			
		$this->session->set_flashdata('mensagem','Cadastro Atualizado Com Sucesso');		
	 }else{				
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');		
	 }
	
	$dadosCidadeEstado = $this->matricula_cei_model->listarCeiByCodigo( $idContratante,$id_cei);
	
	$_SESSION['cidadeMatCeiBD'] = $dadosCidadeEstado[0]->cidade;
	$_SESSION['estadoMatCeBD'] = $dadosCidadeEstado[0]->estado;
	$_SESSION['idMatCeiBD'] = $id_cei;	
	
	//$modulo = $this->session->userdata('MatCei');

	 redirect('/matricula_cei/listar', 'refresh');  
 }     
 function limpar_filtro(){
	$_SESSION['cidadeMatCeiBD'] = 0;
	$_SESSION['estadoMatCeBD'] = 0;
	$_SESSION['idMatCeiBD'] = 0;	

	redirect('/matricula_cei/listar', 'refresh');  
 }
 function excluir(){	   
	if(! $_SESSION['login']){					
	redirect('login', 'refresh');	  	
	}  			
	$id = $this->input->get('id');	
	$session_data =  $_SESSION['login'];	
	$idContratante = $_SESSION['cliente'] ;	
	$dadosCidadeEstado = $this->matricula_cei_model->listarCeiByCodigo( $idContratante,$id);
	$_SESSION['cidadeMatCeiBD'] = $dadosCidadeEstado[0]->cidade;
	$_SESSION['estadoMatCeBD'] = $dadosCidadeEstado[0]->estado;
	$_SESSION['idMatCeiBD'] = $id;	
	
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	
	if($podeExcluir[0]['total'] == 1){
		$this->user->excluirFisicamente($id,'matricula_cei');
		$_SESSION['mensagemMatricCei'] =  CADASTRO_INATIVO;
	}else{
		if($this->matricula_cei_model->excluir($id)) {	
			$_SESSION['mensagemMatricCei'] =  CADASTRO_INATIVO;
		}else{			
			$_SESSION['mensagemMatricCei'] =  ERRO;
		}
	}	
	

	redirect('/matricula_cei/listar', 'refresh');
	}  
	
	function ativar(){	 	 
		if(! $_SESSION['login']){					
			redirect('login', 'refresh');	  	
		}  			
		$id = $this->input->get('id');	
		$session_data =  $_SESSION['login'];	
		$idContratante = $_SESSION['cliente'] ;	
		
		if($this->matricula_cei_model->ativar($id)) {		
				$_SESSION['mensagemMatricCei'] =  CADASTRO_ATIVO;
			}else{			
				$_SESSION['mensagemMatricCei'] =  ERRO;
			}

	$dadosCidadeEstado = $this->matricula_cei_model->listarCeiByCodigo( $idContratante,$id);
	
	$_SESSION['cidadeMatCeiBD'] = $dadosCidadeEstado[0]->cidade;
	$_SESSION['estadoMatCeBD'] = $dadosCidadeEstado[0]->estado;
	$_SESSION['idMatCeiBD'] = $id;	
	
		redirect('/matricula_cei/listar', 'refresh'); 
	}  
	
	function cadastrar_cei(){	  	
	
	$session_data =  $_SESSION['login'];	
	$idContratante = $_SESSION['cliente'] ;	
	$emitente = $this->input->post('id_emitente');		
	$imovel = $this->input->post('id_imovel');		
	$loja = $this->input->post('id_loja');			
	$cei = $this->input->post('cei');		
	$data_abertura_cei = $this->input->post('data_abertura_cei');		
	$data_ini_obra = $this->input->post('data_ini_obra');		
	$tipo_empreitada = $this->input->post('tipo_empreitada');	
	$tipo_obra = $this->input->post('tipo_obra');	
	$status_obra = $this->input->post('status_obra');	
	$averbado = $this->input->post('averbado');	
	$area_existente = $this->input->post('area_existente');	
	$area_reforma = $this->input->post('area_reforma');	
	$area_demolicao = $this->input->post('area_demolicao');	
	$area_acres_nova = $this->input->post('area_acres_nova');		
	$area_total = $this->input->post('area_total');		
	$alvara = $this->input->post('alvara');		
	$projeto = $this->input->post('projeto');		
	$contr_loc_matr_escr = $this->input->post('contr_loc_matr_escr');		
	$habitese = $this->input->post('habitese');	
	$contrato_obra = $this->input->post('contrato_obra');	
	$nota_fiscal = $this->input->post('nota_fiscal');	
	$gps_2631 = $this->input->post('gps_2631');	
	$relatorio_sefip = $this->input->post('relatorio_sefip');	
	$observacoes = $this->input->post('obs');	
	/*
	$cep = $this->input->post('cep');		
	$numero = $this->input->post('numero');		
	$logradouro = $this->input->post('logradouro');		
	$bairro = $this->input->post('bairro');		
	$cidade = $this->input->post('cidade');		
	$estado = $this->input->post('estado');		
	*/
	$regional = $this->input->post('regional');		
	$bandeira = $this->input->post('bandeira');			
	$dataAberturaArr = explode('/',$data_abertura_cei);		
	$dataIniArr = explode('/',$data_ini_obra);		
	$dados = array('id_contratante' => $idContratante,					
	'id_emitente' => $emitente,					
	'id_imovel' => $imovel,							
	'id_loja' => $loja,					
	'cei' => $cei,					
	'data_abertura' => $dataAberturaArr[2].'-'.$dataAberturaArr[1].'-'.$dataAberturaArr[0],
	'data_inicio_obra' => $dataIniArr[2].'-'.$dataIniArr[1].'-'.$dataIniArr[0],
	'tipo_empreitada' => $tipo_empreitada,					
	'tipo_obra' => $tipo_obra,					
	'status_obra' => $status_obra,					
	'averbado' => $averbado,					
	'area_existente' => $area_existente,					
	'area_reforma' => $area_reforma,					
	'area_acres_nova' => $area_acres_nova,					
	'area_demolicao' => $area_demolicao,					
	'area_total' => $area_total,					
	'alvara' => $alvara,					
	'projeto' => $projeto,					
	'contr_loc_matr_escr' => $contr_loc_matr_escr,					
	'habitese' => $habitese,
	'contrato_obra' => $contrato_obra,					
	'nota_fiscal' => $nota_fiscal,					
	'gps_2631' => $gps_2631,					
	'relatorio_sefip' => $relatorio_sefip,		
	'regional' => $regional,					
	'bandeira' => $bandeira,					
	'observacoes' => $observacoes,
	'ativo' => 1				
	);						
	if($this->matricula_cei_model->add($dados)) {	
	$this->db->cache_off();	
	$this->session->set_flashdata('mensagem','Cadastro Feito Com Sucesso');		
	}else{				
	$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');		
	}		
	
	redirect('/matricula_cei/listar', 'refresh'); 
	}   
 
 function editar(){	
 $id = $this->input->get('id');		
 $session_data =  $_SESSION['login'];	$data['perfil'] = $session_data['perfil'];	
 $session_data =  $_SESSION['login'];	$idContratante = $_SESSION['cliente'] ;			
 $data['regionais'] = $this->loja_model->listarRegional();	
 $data['bandeiras'] = $this->loja_model->listarBandeira();		
 $data['emitentes'] = $this->matricula_cei_model->listarEmitentes($idContratante);	
 $data['estados'] = $this->matricula_cei_model->buscaEstado($idContratante);	
 $data['cidades'] = $this->matricula_cei_model->buscaCidades($idContratante);	
 $data['tipo_emitentes'] = $this->tipo_emitente_model->listarTipoEmitente();	
 $data['tipo_empreitada'] = $this->matricula_cei_model->listarTipoEmpreitada();	
 $data['tipo_obra'] = $this->matricula_cei_model->listarTipoObra();		
 $data['dados_cei'] = $this->matricula_cei_model->listarCeiById($id);	
 
	$_SESSION['cidadeMatCeiBD'] = $data['dados_cei'][0]->cidade;
	$_SESSION['estadoMatCeBD'] = $data['dados_cei'][0]->estado;
	$_SESSION['idMatCeiBD'] = $id;	
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
 
 $this->load->view('header_pages_view',$data);	
 $this->load->view('editar_cei_view', $data);	
 $this->load->view('footer_pages_view');	   
 }    
 
 function converter(){	$total = $this->input->get('total');		$total = number_format($total, 2, ',', '.');	echo json_encode($total);}  
 
 function cadastrar(){	
 $data['regionais'] = $this->loja_model->listarRegional();	
 $data['bandeiras'] = $this->loja_model->listarBandeira();	
 $session_data =  $_SESSION['login'];	
 $idContratante = $_SESSION['cliente'] ;		
 $data['emitentes'] = $this->matricula_cei_model->listarEmitentes($idContratante);	
 $data['estados'] = $this->matricula_cei_model->buscaEstado($idContratante);	
 $data['cidades'] = $this->matricula_cei_model->buscaCidades($idContratante);	
 $data['tipo_emitentes'] = $this->tipo_emitente_model->listarTipoEmitente();	
 $data['tipo_empreitada'] = $this->matricula_cei_model->listarTipoEmpreitada();	
 $data['tipo_obra'] = $this->matricula_cei_model->listarTipoObra(); 	
 $data['perfil'] = $session_data['perfil'];
 if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
 $this->load->view('header_pages_view',$data);  
 $this->load->view('cadastrar_cei_view', $data);	
 $this->load->view('footer_pages_view'); 
 }  
 
 function buscaLojaByEmitente(){	
 $emitente = $this->input->get('emitente');	 
 $dados = $this->matricula_cei_model->listarLojaByEmitente($emitente);	 	 	 
 if($dados[0]->tem == 0){		
	$retorno ="<option value='0'>Não H&Aacute; Loja Cadastrada</option>";	 
 }else{		
	$retorno ="<option value='".$dados[0]->id."'>".$dados[0]->razao_social."</option>";				 
}	 	 
echo json_encode($retorno); 

}   
 
 function buscaCidade(){	  	
	$estado = $this->input->get('estado');	
	$result = $this->matricula_cei_model->listarCidade($estado);	$retorno ='';	
	$isArray =  is_array($result) ? '1' : '0';	
	if($isArray == 0){		
		$retorno .="<option value='0'>Não H&Aacute; Dados</option>";	
	}else{		
		$retorno .="<option value=0>Escolha</option>";		
		foreach($result as $key => $cidade){ 				
			$retorno .="<option value='".$cidade->cidade."'>".$cidade->cidade."</option>";		
		}	
	}		
echo json_encode($retorno);	  
}	    

function buscaCeiByCidade(){	   	

$session_data =  $_SESSION['login'];	
$idContratante = $_SESSION['cliente'] ;			
$cidade = $this->input->get('cidade');	
$result = $this->matricula_cei_model->listarCeiByCidade($idContratante,$cidade);	
$retorno ='';	$isArray =  is_array($result) ? '1' : '0';	if($isArray == 0){		
$retorno .="<option value='0'>Não H&Aacute; Dados</option>";	}else{		
$retorno .="<option value=0>Escolha</option>";		
foreach($result as $key => $cei){ 				
$retorno .="<option value='".$cei->id_cei."'>".$cei->cei."</option>";		
}	
}		
echo json_encode($retorno);	  
}	    

function buscaCeiByEstado(){	   	
$session_data =  $_SESSION['login'];	
$idContratante = $_SESSION['cliente'] ;			
$estado = $this->input->get('estado');	$result = $this->matricula_cei_model->listarCeiByEstado($idContratante,$estado);	
$retorno ='';	$isArray =  is_array($result) ? '1' : '0';	if($isArray == 0){		
$retorno .="<option value='0'>Não H&Aacute; Dados</option>";	}else{		
$retorno .="<option value=0>Escolha</option>";		foreach($result as $key => $cei){ 				
$retorno .="<option value='".$cei->id_cei."'>".$cei->cei."</option>";		}	}		
echo json_encode($retorno);	  }        
function buscaCeiExistente(){	   	
$session_data =  $_SESSION['login'];	$idContratante = $_SESSION['cliente'] ;			$cei = $this->input->get('cei');	$result = $this->matricula_cei_model->buscaCeiExistente($idContratante,$cei);	$retorno['total'] = $result[0]->total;		echo json_encode($retorno);	  }  

 function buscaTodasCeiById(){	   	
 $session_data =  $_SESSION['login'];	$idContratante = $_SESSION['cliente'] ;			
 $cei = $this->input->get('cei');	
 $result = $this->matricula_cei_model->listarCeiByCodigo($idContratante,$cei);	
 $this->criaJson($result);	
 }      
 
 function buscaTodasCeiByCidade(){	   	
 
	$session_data =  $_SESSION['login'];	
	$idContratante = $_SESSION['cliente'] ;			
	$cidade = $this->input->get('cidade');	
	$result = $this->matricula_cei_model->listarCeiByCidade($idContratante,$cidade);	
	$this->criaJson($result);	
}    
 
 function criaJson($result){
	  
  $retorno ='';	$isArray =  is_array($result) ? '1' : '0';		
 $base = $this->config->base_url();	$base .='index.php';
 
	if($isArray == 0){		
		$retorno .="<tr>";		
		$retorno .="<td class='hidden-phone' colspan='5'> Não H&Aacute; Dados </td>";		
		$retorno .="</tr>";	
	}else{		
			foreach($result as $key => $cei){ 					
			$id_cei = $cei->id_cei;		
				if($cei->possui_cnd == 0){				
					$cnd ='Nada Consta';			
					$corCnd = '#990000';										 		
				}else{			
					if($cei->possui_cnd == 1){				
						$cnd ='Sim';				
						$corCnd = '#000099';													
					}elseif($cei->possui_cnd == 2){				
						$cnd ='N&atilde;o';				
						$corCnd = '#000099';			
					}elseif($cei->possui_cnd == 3){				
						$cnd ='Pend&ecirc;ncia';				
						$corCnd = '#000099';			
					}else{				
						$cnd ='Nada Consta';				
						$corCnd = '#990000';			
					}		
				}				
				if($cei->status_obra == 1){			
					$statusObra = 'Aberta';		
				}else{			
					$statusObra = 'Encerrada';			
				}
				if($cei->ativo == 1){			
					$status="Ativo";			
					$cor = '#009900';		
				}else{			
					$status="Inativo";			
					$cor = '#CC0000';		
				}			
				$retorno .="<tr  style='color:".$cor."'>";				
				$retorno .="<td width='12%'>";				
					if( $cnd <> 'Nada Consta') {					
						$retorno .="<a href='$base/cnd_obras/editar?id=$id_cei' >".$cei->cei."</a>";					
					}else{					
						$retorno .="<a href='$base/cnd_obras/cadastrar?id=$id_cei' >".$cei->cei."</a>";				
					}				
				$retorno .="</td>";	
 
								  
				$retorno .="<td  width='11%'>".$cei->data_abertura."</td>";						
				$retorno .="<td  width='9%'>".$cei->descricao."</td>";						
				$retorno .="<td  width='11%'>".$cnd."</td>";						
				$retorno .="<td  width='12%'>".$statusObra."</td>";						
				$retorno .="<td  width='14%'>".$cei->empreitada."</td>";						
				$retorno .="<td  width='17%'>".$cei->imovel."</td>";						
				$retorno .="<td  width='10%'>";				
				$retorno .="<a href='$base/matricula_cei/ativar?id=$id_cei' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";				
				$retorno .="<a href='$base/matricula_cei/editar?id=$id_cei' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";				
				$retorno .="<a href='$base/matricula_cei/excluir?id=$id_cei' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";				
				$retorno .="</td>";								
				$retorno .="</tr>";					
				}	
			}		
			echo json_encode($retorno);	 
			
 }	  
 function buscaTodasCeiByEstado(){	  
 
 $session_data =  $_SESSION['login'];	
 $idContratante = $_SESSION['cliente'] ;			
 $estado = $this->input->get('estado');	
 $result = $this->matricula_cei_model->listarCeiByEstado($idContratante,$estado);	
 $this->criaJson($result);
 
  
}   

 function csv($result){

	  $file="cnd_obras.xls";
	
	if($result == 0){	
		$test="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$test .='</table>';

    }else{
		$test="<table border=1>
			<tr>
			<td>Id</td>
			<td>Im&oacute;vel</td>
			<td>CEI</td>
			<td>Data Abertura</td>
			<td>Tipo Empreitada</td>
			<td>Tipo Obra</td>
			<td>Status Obra</td>
			<td>Regional</td>
			<td>Bandeira</td>
			<td>Cidade CEI</td>
			<td>Estado CEI</td>	
			<td>Possui CND</td>
			<td>Status Obra</td>
			<td>Averbado</td>
			<td>&Aacute;rea Existente</td>
			<td>&Aacute;rea Reforma</td>
			<td>&Aacute;rea Acr&eacute;scimo</td>
			<td>&Aacute;rea Demoli&ccedil;&atilde;o</td>
			<td>&Aacute;rea Resultante</td>
			<td>Alvar&aacute;</td>
			<td>Projeto</td>
			<td>Contrato Loca&ccedil;&atilde;o Matr&iacute;cula Im&oacute;vel Escritura</td>
			<td>Habite-se</td>
			<td>Contrato de Obra</td>
			<td>Nota Fiscal</td>
			<td>GPS 2631</td>
			<td>Relat&oacute;rio SEFIP</td>
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>				
			
			</tr>
			";
			
			
	

	}  
	
	  
			foreach($result as $key => $iptu){ 	
			  $dadosLog = $this->log_model->listarLog($iptu->id_cei,'cnd_obras');				
			  $isArrayLog =  is_array($dadosLog) ? '1' : '0';
			  
				if($iptu->ativo == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->possui_cnd == 1){
					$possui_cnd ='Sim';
					//$dataVArr = explode("-",$iptu->data_vencto);									 
					//$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
				}else if($iptu->possui_cnd == 2){
					$possui_cnd ='Não';
					//$dataVArr = explode("-",$iptu->data_vencto);									 
					//$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
				}else{
					$possui_cnd ='Pendência';
					//$dataVArr = explode("-",$iptu->data_pendencias);									 
					//$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
				}
				
				if($iptu->averbado == 1){
					$averbado = 'Sim';
				}else{
					$averbado = 'Não';
				}
				
				if($iptu->status_obra == 1){
					$statusObra = 'Aberta';
				}else{
					$statusObra = 'Encerrada';
				}			
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".($iptu->id_cei)."</td>";
				$test .= "<td>".utf8_decode($iptu->imovel)."</td>";
				$test .= "<td>".($iptu->cei)."</td>";
				$test .= "<td>".utf8_decode($iptu->data_abertura)."</td>";
				$test .= "<td>".utf8_decode($iptu->empreitada)."</td>";
				$test .= "<td>".utf8_decode($iptu->tipo_obra_desc)."</td>";
				$test .= "<td>".utf8_decode($statusObra)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao_bandeira)."</td>";
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";
				$test .= "<td>".utf8_decode($possui_cnd)."</td>";
				$test .= "<td>".utf8_decode($statusObra)."</td>";
				$test .= "<td>".utf8_decode($averbado)."</td>";
				$test .= "<td>'".utf8_decode($iptu->area_existente)."'</td>";
				$test .= "<td>'".utf8_decode($iptu->area_reforma)."'</td>";
				$test .= "<td>'".utf8_decode($iptu->area_acres_nova)."'</td>";
				$test .= "<td>'".utf8_decode($iptu->area_demolicao)."'</td>";
				$test .= "<td>'".utf8_decode($iptu->area_total)."'</td>";
				$alvara = ($iptu->alvara == 1) ? "Sim" : "Não";
				$projeto = ($iptu->projeto == 1) ? "Sim" : "Não";
				$habitese = ($iptu->habitese == 1) ? "Sim" : "Não";
				$contr_loc_matr_escr = ($iptu->contr_loc_matr_escr == 1) ? "Sim" : "Não";
				$contrato_obra = ($iptu->contrato_obra == 1) ? "Sim" : "Não";
				$nota_fiscal = ($iptu->nota_fiscal == 1) ? "Sim" : "Não";
				$gps_2631 = ($iptu->gps_2631 == 1) ? "Sim" : "Não";
				$relatorio_sefip = ($iptu->relatorio_sefip == 1) ? "Sim" : "Não";
				$test .= "<td>".utf8_decode($alvara)."</td>";
				$test .= "<td>".utf8_decode($projeto)."</td>";
				$test .= "<td>".utf8_decode($contr_loc_matr_escr)."</td>";
				$test .= "<td>".utf8_decode($habitese)."</td>";
				$test .= "<td>".utf8_decode($contrato_obra)."</td>";
				$test .= "<td>".utf8_decode($nota_fiscal)."</td>";
				$test .= "<td>".utf8_decode($gps_2631)."</td>";
				$test .= "<td>".utf8_decode($relatorio_sefip)."</td>";

				if($isArrayLog <> 0){
					 $dataFormatadaArr = explode('-',$dadosLog[0]->data);
					 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
					 $test .="<td>".$dadosLog[0]->email."</td>";
					 $test .="<td>".$dataFormatada."</td>";
					 $test .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";
				}else{
					$test .="<td></td>";
					$test .="<td></td>";
					$test .="<td></td>";
				}				
				$test .= "</tr>";
			
				
			}
		$test .='</table>';		
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
	
  }
function export(){	
	  
	  if(! $_SESSION['login']){
			redirect('login', 'refresh');
	  }
	  
  	$id = $this->input->post('id_imovel_export');
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	if($id == 0){
	
		$result = $this->matricula_cei_model->listarTodasCeiExport($idContratante,$id);
	}else{

		$result = $this->matricula_cei_model->listarCeiByCodigo($idContratante);
	}

	$this->csv($result);
	
  }
  
  function export_total(){	
	  
	  if(! $_SESSION['login']){
			redirect('login', 'refresh');
	  }
	  
  	$id = 0;

	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->matricula_cei_model->listarTodasCeiExport($idContratante,$id);
	
	$this->csv($result);
	
  }
  
  function export_mun(){	
	  
	  if(! $_SESSION['login']){
			redirect('login', 'refresh');
	  }
	  
  	$cidade = $this->input->post('id_mun_export');

	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->matricula_cei_model->listarCeiByCidade($idContratante,$cidade);
	
	$this->csv($result);
	
  }
  
    function export_est(){	
	  
	  if(! $_SESSION['login']){
			redirect('login', 'refresh');
	  }
	  
  	$estado = $this->input->post('id_estado_export');

	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->matricula_cei_model->listarCeiByEstado($idContratante,$estado);
	
	$this->csv($result);
	
  }
  
  
function listar(){	
			
	 if(! $_SESSION['login']){
		redirect('login', 'refresh');
	 }
	  
	$cidade = '0';	$estado = '0';	
	$data['cidadeFiltro'] = $cidade;	
	$data['estadoFiltro'] = $estado;	
	
	$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;	
	$session_data =  $_SESSION['login'];	
	$idContratante = $_SESSION['cliente'] ;	
	
	$data['estados'] = $this->matricula_cei_model->listarEstado($idContratante);	
	$data['cidades'] = $this->matricula_cei_model->listarCidade(0,$idContratante);	
	$data['bandeiras'] = $this->matricula_cei_model->listarBandeira();	
	$data['todas_cei'] = $this->matricula_cei_model->listarTodasCei($idContratante);	
	
	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->matricula_cei_model->listarTodasCei($idContratante);	
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result = $this->matricula_cei_model->listarCeiByCidade($idContratante,$municipioListar);
			}else if($estadoListar <> '0'){
				$result = $this->matricula_cei_model->listarCeiByEstado($idContratante,$estadoListar);				
			}else{
				$result = $this->matricula_cei_model->listarTodasCei($idContratante);
			}
		}else{	
			$result = $this->matricula_cei_model->listarCeiByCodigo($idContratante,$idImovelListar);
		}	
	}
	
	$data['emitentes'] = $result;	
	$data['perfil'] = $session_data['perfil'];	
	
	
	if(empty($_SESSION['cidadeMatCeiBD'])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION['cidadeMatCeiBD'];
	}
	if(empty($_SESSION['estadoMatCeBD'])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] = $_SESSION['estadoMatCeBD'];
	}
	if(empty($_SESSION['idMatCeiBD'])){
		$data['idMatCeiBD'] = 0;
	}else{
		$data['idMatCeiBD'] = $_SESSION['idMatCeiBD'];
	}
	$this->session->set_userdata('modulo', 'MatCei');
	
	if(empty($_SESSION["mensagemMatricCei"])){
		$data['mensagemMatricCei'] = '';
	}else{
		$data['mensagemMatricCei'] = $_SESSION['mensagemMatricCei'];
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);   
	$this->load->view('listar_cei_view', $data);	
	$this->load->view('footer_pages_view');
}
}
?>