<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Iptu extends CI_Controller {
 
 function __construct(){	
 parent::__construct();    
 session_start();
 
 $this->load->model('emitente_imovel_model','',TRUE);	
 $this->load->model('log_model','',TRUE);    
 $this->load->model('tipo_emitente_model','',TRUE);    
 $this->load->model('situacao_imovel_model','',TRUE);    
 $this->load->model('informacoes_inclusas_iptu_model','',TRUE);    
 $this->load->model('user','',TRUE);    
 $this->load->model('contratante','',TRUE);    
 $this->load->model('emitente_model','',TRUE);    
 $this->load->model('imovel_model','',TRUE);    
 $this->load->model('iptu_model','',TRUE);    
 $this->load->library('Cep');    
 $this->load->library('session');       
 $this->load->library('form_validation');    
 $this->load->helper('url');	
 $this->load->helper('general_helper');	
  
 }
 
 function index(){
   if($_SESSION['login']){
     $session_data = $_SESSION['login'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];	 	 
     $this->load->view('home_view', $data);
   }else{
     
     redirect('login', 'refresh');
   }
 }
 
 function cadastrar(){ 
 
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];
	$anos = anos();		
	
	
	$idContratante = $_SESSION['cliente'] ;	
	$data['imoveis'] = $this->iptu_model->listarTodosImoveis($idContratante);		
	$data['status_iptu'] = $this->iptu_model->status_iptu();		
	$data['emitentes'] = $this->iptu_model->listarEmitentes($idContratante);		
	$data['info_inc'] = $this->informacoes_inclusas_iptu_model->listar();				
	$data['anos'] = anos();		 	
	$data['perfil'] = $session_data['perfil'];
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	

	
	$this->load->view('header_pages_view',$data);
    $this->load->view('cadastrar_iptu_view', $data);
	$this->load->view('footer_pages_view');
 }  
 
 function enviar(){		

	$id = $this->input->get('id');		
	$file = $_FILES["userfile"]["name"];				
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './assets/capas/';		
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = $id.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";				
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{			
		$dados = array('capa' => $id.'.'.$extensao);							
		$this->iptu_model->atualizar($dados,$id);						
		$data = array('upload_data' => $this->upload->data($field_name));			
		$_SESSION['mensagemIptu'] =  UPLOAD;
		echo'1';
		
		
	}

//redirect('/iptu/listar', 'refresh');		 
} 
 	 
 function upload_iptu(){		  
	if(!$_SESSION['login']) {
		redirect('login', 'refresh');
	 }
	 $session_data = $_SESSION['login'];
	 $id = $this->input->get('id');    
	 $data['imovel'] = $this->iptu_model->listarImovelByIdIptu($id);
	 
	 if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	 $this->load->view('header_pages_view',$data);
	 $this->load->view('upload_iptu', $data);
	 $this->load->view('footer_pages_view');
			  
 } 

 function ver(){		  
 $session_data = $_SESSION['login'];	  
	if(!$_SESSION['login']){		
		redirect('login', 'refresh');  
	}    
 $id = $this->input->get('id');    
 $data['imovel'] = $this->iptu_model->listarImovelByIdIptu($id);	  
 $data['perfil'] = $session_data['perfil'];  
 $this->load->view('header_pages_view',$data);
 $this->load->view('ver', $data);  
 $this->load->view('footer_pages_view');		  
 }  
 
 function virar_iptu(){    
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$idIptuVirada = $this->input->post('id_iptu_virada');	
	
	
	$dadosIPTUCND = $this->iptu_model->listarIPTUCND($idIptuVirada,$idContratante);
	
	$conta = count($dadosIPTUCND);
	
	if($conta <> 0){
		//$idIptuNovo = $this->iptu_model->inserirIptuIgual($idIptuVirada);
		$id_imovel = $this->input->post('id_imovel');			
		$inscricao = $this->input->post('inscricao');			
		$valor = $this->input->post('valor');	
		$areaTotal = $this->input->post('areaTotal');	
		$areaConstruida = $this->input->post('areaConstruida');	
		$nome = $this->input->post('nome');		
		$status = $this->input->post('status');			
		$informacoes = $this->input->post('informacoes');			
		$observacoes = $this->input->post('observacoes');			
		$ano_ref = $this->input->post('ano_ref');		
		$dados = array(
					'id_imovel' => $id_imovel,
					'inscricao' => $inscricao,										
					'nome_proprietario' => $nome,
					'status_prefeitura' => $status,
					'info_inclusas' => $informacoes,
					'observacoes' => $observacoes,										
					'ano_ref' => $ano_ref,

		);
		$idIptuNovo = $this->iptu_model->add($dados);
	
		if(!empty($valor)){					
			$dados = array(	'valor' => $valor,);		
			$this->iptu_model->atualizar($dados,$idIptuNovo);				
		}else{
			$valor = $this->input->post('valorAntigo');
			$dados = array(	'valor' => $valor,);		
			$this->iptu_model->atualizar($dados,$idIptuNovo);
		}		
		if(!empty($areaTotal)){		
			$dados = array('area_total' => $areaTotal,);		
			$this->iptu_model->atualizar($dados,$idIptuNovo);	
		}else{
			$areaTotal = $this->input->post('areaTotalAntigo');
			$dados = array('area_total' => $areaTotal,);		
			$this->iptu_model->atualizar($dados,$idIptuNovo);
		}		
		
		if(!empty($areaConstruida)){		
			$dados = array('area_construida' => $areaConstruida,);		
			$this->iptu_model->atualizar($dados,$idIptuNovo);
		}else{
			$areaConstruida = $this->input->post('areaConstruidaAntigo');
			$dados = array('area_construida' => $areaConstruida,);		
			$this->iptu_model->atualizar($dados,$idIptuNovo);
		}
	
		$this->iptu_model->transfereCND($idIptuNovo,$dadosIPTUCND[0]['id_cnd']);
		$_SESSION['mensagemIptu'] =  'IPTU para o ano atual foi cadastrado e CND foi transferida';
		
	}else{
		$_SESSION['mensagemIptu'] =  'IPTU para o ano anterior não existe, deve ser cadastrado';
	}
	
	
	redirect('/iptu/listar', 'refresh');
				
 } 
 function cadastrar_iptu(){    
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$id_imovel = $this->input->post('id_imovel');			
	$inscricao = $this->input->post('inscricao');			
	$valor = $this->input->post('valor');	
	$areaTotal = $this->input->post('areaTotal');	
	$areaConstruida = $this->input->post('areaConstruida');	
	$nome = $this->input->post('nome');		
	$status = $this->input->post('status');			
	$informacoes = $this->input->post('informacoes');			
	$observacoes = $this->input->post('observacoes');			
	$ano_ref = $this->input->post('ano_ref');		
	$dados = array(
					'id_imovel' => $id_imovel,
					'inscricao' => $inscricao,										
					'valor' => $valor,					
					'area_total' => $areaTotal,					
					'area_construida' => $areaConstruida,
					'nome_proprietario' => $nome,
					'status_prefeitura' => $status,
					'info_inclusas' => $informacoes,
					'observacoes' => $observacoes,										
					'ano_ref' => $ano_ref,

				);
	$id = $this->iptu_model->add($dados);			
	if($id) {
		redirect('cnd_imob/cadastrar?id='.$id, 'refresh');
	}else{	

		$_SESSION['mensagemIptu'] =  ERRO;
		redirect('/iptu/listar', 'refresh');
	}
	
				
 }  
 
 function buscaInscricao(){	$inscricao = $this->input->get('inscricao');	
 $id_imovel = $this->input->get('id_imovel');	
 $ano_ref = $this->input->get('ano_ref');		
 $tem = $this->iptu_model->buscaInscricao($inscricao,$id_imovel,$ano_ref);		
 $obj = array();	$obj['total']=$tem[0]->total;	
 echo json_encode($obj);	
 }    
 
 function excluir(){	
	if(!$_SESSION['login']){			
	redirect('login', 'refresh');	  
	}  	
	
	$id = $this->input->get('id');	
	$session_data = $_SESSION['login'];	
	$idContratante = $_SESSION['cliente'] ;	
	$dados = array('ativo' => 0);	
	if($this->iptu_model->atualizar($dados,$id)) {	 	
		$_SESSION['mensagemIptu'] =  CADASTRO_INATIVO;
	}else{			
		$_SESSION['mensagemIptu'] =  ERRO;
	
	 }	redirect('/iptu/listar', 'refresh');				 
 } 
 
 function inativar(){	
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$id = $this->input->get('id');	
	$session_data = $_SESSION['login'];
	
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	
	if($podeExcluir[0]['total'] == 1){
		$this->user->excluirFisicamente($id,'iptu');
		$_SESSION['mensagemImovel'] =  CADASTRO_INATIVO;
	}else{
		$dados = array('ativo' => 1);	
		 if($this->iptu_model->atualizar($dados,$id)) { 	
			 $_SESSION['mensagemIptu'] =  CADASTRO_ATUALIZADO;
		 }else{			
			$_SESSION['mensagemIptu'] =  ERRO;
		 }		
	}	

	  redirect('/iptu/listar', 'refresh');					 
  } 
  
  function ativar(){	
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];
	
  $id = $this->input->get('id');	
  $dados = array('ativo' => 0);	
  if($this->iptu_model->atualizar($dados,$id)){	
	 $_SESSION['mensagemIptu'] =  CADASTRO_ATUALIZADO;
  }else{			
     $_SESSION['mensagemIptu'] =  ERRO;
  }		
  redirect('/iptu/listar', 'refresh');				 
  } 
  
 function atualizar_iptu(){	
 
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];
	
	$id = $this->input->post('id');		
	
	$idContratante = $_SESSION['cliente'] ;	
	$idUsuario = $session_data['id'];	
	$id_imovel = $this->input->post('id_imovel');		
	$inscricao = $this->input->post('inscricao');		
	$valor = $this->input->post('valor');		
	$areaTotal = $this->input->post('areaTotal');	
	$areaConstruida = $this->input->post('areaConstruida');		
	$nome = $this->input->post('nome');
	$status = $this->input->post('status');		
	$informacoes = $this->input->post('informacoes');		
	$observacoes = $this->input->post('observacoes');	
	$ano_ref = $this->input->post('ano_ref');

	$dadosAtuais = $this->iptu_model->listarImovelByImovelSemAno($id);	
	
		
	$dadosStatusIptu = $this->iptu_model->listarStatusIptu($dadosAtuais[0]->status_prefeitura);	
	$dadosNomeProprietario = $this->iptu_model->listarEmitenteById($dadosAtuais[0]->nome_proprietario,$idContratante);		
	
	$dados = array(			
		'id_imovel' => $id_imovel,			
		'inscricao' => $inscricao,							
		'nome_proprietario' => $nome,			
		'status_prefeitura' => $status,			
		'info_inclusas' => $informacoes,			
		'observacoes' => $observacoes,			
		'ano_ref' => $ano_ref,			
		);		
	$dadosAlterados = '';		
	
	
	if($dadosAtuais[0]->id_imovel <> $id_imovel){		
		$dadosAlterados .= ' - Imóvel: '.$dadosImovel[0]->nome;	
	}	
	if($dadosAtuais[0]->inscricao <> $inscricao){		
		$dadosAlterados .= ' - Inscrição: '.$dadosAtuais[0]->inscricao;	}	
	if($dadosAtuais[0]->nome_proprietario <> $nome){	
		if(empty($dadosNomeProprietario[0]->razao_social)){
				$dadosAlterados .= ' - Nome Proprietário: Sem Nome';	
		}else{
				$dadosAlterados .= ' - Nome Proprietário: '.$dadosNomeProprietario[0]->razao_social;	
				
		}
		
	}	
	if($dadosAtuais[0]->status_prefeitura <> $status){	
		if($dadosAtuais[0]->status_prefeitura == 0){
			$dadosAlterados .= ' - Status Prefeitura: Sem Descrição';		
		}else{
			$dadosAlterados .= ' - Status Prefeitura: '.$dadosStatusIptu[0]->descricao;		
		}
		
	}	
	if($dadosAtuais[0]->info_inclusas <> $informacoes){		
		$dadosAlterados .= ' - Informações: '.$dadosAtuais[0]->info_inclusas;	
	}	
	if($dadosAtuais[0]->observacoes <> $observacoes){		
	$dadosAlterados .= ' - Observações: '.$dadosAtuais[0]->observacoes;	
	}	
	
	$dadosLog = array(	
		'id_contratante' => $idContratante,	
		'tabela' => 'iptu',	
		'id_usuario' => $idUsuario,	
		'id_operacao' => $id,	
		'tipo' => 2,	
		'texto' => $dadosAlterados,	
		'data' => date("Y-m-d"),	);	
	$this->log_model->log($dadosLog);		
	$this->iptu_model->atualizar($dados,$id);
	
 	if(!empty($valor)){		
		$dados = array(	'valor' => $valor,);		
		$this->iptu_model->atualizar($dados,$id);	
		
	}		
	if(!empty($areaTotal)){		
		$dados = array('area_total' => $areaTotal,);		
		$this->iptu_model->atualizar($dados,$id);	
	}		
	
	if(!empty($areaConstruida)){		
		$dados = array('area_construida' => $areaConstruida,);		
		$this->iptu_model->atualizar($dados,$id);
	}		
	$dadosImovel = $this->iptu_model->listarImovelByImovelSemAno($id);	
	
	$_SESSION['cidadeIpBD'] = $dadosImovel[0]->cidade;
	$_SESSION['estadoIpBD'] =  $dadosImovel[0]->estado;
	$_SESSION['idImIpBD'] = $dadosImovel[0]->id_imovel;
	
	$_SESSION['mensagemIptu'] =  CADASTRO_ATUALIZADO;
	
	
	
	
	redirect('/iptu/listar', '');		
	
				
 } 
  function editar(){	    
	if(!$_SESSION['login']) {
		redirect('login', 'refresh');
	}
	$anos = anos();
	$id = $this->input->get('id');
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->iptu_model->listarImovelByIdIptu($id);
	
	
	$this->session->set_userdata('cidadeIpBD', $result[0]->cidade);
	$this->session->set_userdata('estadoIpBD', $result[0]->estado);
	$this->session->set_userdata('idImIpBD', $result[0]->id_imovel);
	
	$data['status_iptu'] = $this->iptu_model->status_iptu();			
	$data['imoveis'] = $this->iptu_model->listarTodosImoveis($idContratante);	
	$data['emitentes'] = $this->iptu_model->listarEmitentes($idContratante);
	$data['anos'] = anos();
	$data['imovel'] = $result;		
	$data['info_inc'] = $this->informacoes_inclusas_iptu_model->listar();
	$data['perfil'] = $session_data['perfil'];
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_iptu_view', $data);
	$this->load->view('footer_pages_view');


 } 
 
  function virar(){	    
	if(!$_SESSION['login']) {
		redirect('login', 'refresh');
	}
	$anos = anos();

	$id = $this->input->get('id');
	$session_data = $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->iptu_model->listarImovelByIdIptu($id);
	
	
	$this->session->set_userdata('cidadeIpBD', $result[0]->cidade);
	$this->session->set_userdata('estadoIpBD', $result[0]->estado);
	$this->session->set_userdata('idImIpBD', $result[0]->id_imovel);
	
	$data['status_iptu'] = $this->iptu_model->status_iptu();			
	$data['imoveis'] = $this->iptu_model->listarTodosImoveis($idContratante);	
	$data['emitentes'] = $this->iptu_model->listarEmitentes($idContratante);
	$data['anos'] = anos();
	$data['imovel'] = $result;		
	$data['info_inc'] = $this->informacoes_inclusas_iptu_model->listar();
	$data['perfil'] = $session_data['perfil'];
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('virar_iptu_view', $data);
	$this->load->view('footer_pages_view');


 } 
 function export_mun(){	    
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}
	 $id = $this->input->post('id_mun_export');
	  $session_data = $_SESSION['login'];
	 $idContratante = $_SESSION['cliente'] ;	
	 $anoEscolhido = $this->input->post('anoEscolhido');	
	 $result = $this->iptu_model->listarIptuCsvByCidade($idContratante,$id,$anoEscolhido);
	 $this->csv($result);	  	
} 
	
function export_est(){	    
		if(!$_SESSION['login']){		
		redirect('login', 'refresh');  
		}	
		
		$id = $this->input->post('id_estado_export');	
		$anoEscolhido = $this->input->post('anoEscolhido');	
		

		 $session_data = $_SESSION['login'];
		$idContratante = $_SESSION['cliente'] ;			
		$result = $this->iptu_model->listarIptuCsvByEstado($idContratante,$id,$anoEscolhido);
		 $this->csv($result);	  
 	
}  

 function export_todos(){	   
	if(!$_SESSION['login']) {
			redirect('login', 'refresh');
	}

	 $session_data = $_SESSION['login'];	
	 $idContratante = $_SESSION['cliente'] ;			
	 $result = $this->iptu_model->listarIptuCsv($idContratante);
	 $this->csv($result);	   
	 
 } 
 function csvGraficoReg($result){

  $file="iptu.xls";	
	if($result == 0){			
		$test="
		<table border=1>		<tr>		
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>				</tr>		";		
		$test .='</table>';    
	}else{				
		$test="<table border=1>			
			<tr>			
			<td>Nome Im&oacute;vel</td>			
			<td>Inscri&ccedil;&atilde;o</td>			
			<td>Valor</td>			
			<td>Cidade</td>			
			<td>Estado</td>			
			<td>Regional</td>			
			<td>Informa&ccedil;&otilde;es Inclusas</td>			
			<td>Nome Propriet&aacute;rio</td>			
			<td>CPF/CNPJ</td>			
			<td>Status Prefeitura</td>			
			<td>Ano Refer&ecirc;ncia</td>			
			<td>Possui CND?</td>			
			</tr>			
			";							 			  
			foreach($result as $key => $iptu){ 				  
				$dadosLog = $this->log_model->listarLog($iptu->id_iptu,'iptu');							  
				$isArrayLog =  is_array($dadosLog) ? '1' : '0';				  			  				
				if($iptu->ativo == 0){					
					$ativo='Ativo';				
				}else{					
					$ativo='Inativo';				
				}						 
				if($iptu->cnd == 1){					
					$possuiCnd ='Sim';					
					$dataVArr = explode("-",$iptu->data_vencto);									 					
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];				 
				}elseif($iptu->cnd == 2){					
					$possuiCnd ='Não';					
					$dataVArr = explode("-",$iptu->data_vencto);									 					
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					 
				}elseif($iptu->cnd == 3){					
					$possuiCnd ='Pendência';					
					$dataVArr = explode("-",$iptu->data_pendencias);									 					
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}else{					
					$possuiCnd ='Nada Consta';					
					$dataV = 'Sem Data de Vencimento ou Pendência';					
				}									 				
				$cor='#fff';				
				$test .= "<tr >";				
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";				
				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'.</td>";				
				$test .= "<td>".utf8_encode($iptu->valor)."</td>";				
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";				
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";				
				$test .= "<td>".utf8_decode($iptu->reg_desc)."</td>";	
				$test .= "<td>".utf8_encode($iptu->descricao)."</td>";				
				$test .= "<td>".utf8_decode($iptu->razao_social)."</td>";				
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				
				$test .= "<td>".utf8_decode($iptu->status_pref)."</td>";				
				$test .= "<td>".utf8_decode($iptu->ano_ref)."</td>";				
				$test .= "<td>".utf8_decode($possuiCnd)."</td>";				
				$test .= "</tr>";										
			}			
			$test .='</table>';
			}			
			header("Content-type: application/vnd.ms-excel");		
			header("Content-Disposition: attachment; filename=$file");		
			echo $test;	
			
  }	 
 function csvGrafico($result){

  $file="iptu.xls";	
	if($result == 0){			
		$test="
		<table border=1>		<tr>		
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>				</tr>		";		
		$test .='</table>';    
	}else{				
		$test="<table border=1>			
			<tr>			
			<td>Nome Im&oacute;vel</td>			
			<td>Inscri&ccedil;&atilde;o</td>			
			<td>Valor</td>			
			<td>Cidade</td>			
			<td>Estado</td>			
			<td>Informa&ccedil;&otilde;es Inclusas</td>			
			<td>Nome Propriet&aacute;rio</td>			
			<td>CPF/CNPJ</td>			
			<td>Status Prefeitura</td>			
			<td>Ano Refer&ecirc;ncia</td>			
			<td>Possui CND?</td>			
			</tr>			
			";							 			  
			foreach($result as $key => $iptu){ 				  
				$dadosLog = $this->log_model->listarLog($iptu->id_iptu,'iptu');							  
				$isArrayLog =  is_array($dadosLog) ? '1' : '0';				  			  				
				if($iptu->ativo == 0){					
					$ativo='Ativo';				
				}else{					
					$ativo='Inativo';				
				}						 
				if($iptu->cnd == 1){					
					$possuiCnd ='Sim';					
					$dataVArr = explode("-",$iptu->data_vencto);									 					
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];				 
				}elseif($iptu->cnd == 2){					
					$possuiCnd ='Não';					
					$dataVArr = explode("-",$iptu->data_vencto);									 					
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					 
				}elseif($iptu->cnd == 3){					
					$possuiCnd ='Pendência';					
					$dataVArr = explode("-",$iptu->data_pendencias);									 					
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}else{					
					$possuiCnd ='Nada Consta';					
					$dataV = 'Sem Data de Vencimento ou Pendência';					
				}									 				
				$cor='#fff';				
				$test .= "<tr >";				
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";				
				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'.</td>";				
				$test .= "<td>".utf8_encode($iptu->valor)."</td>";				
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";				
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";				
				$test .= "<td>".utf8_encode($iptu->descricao)."</td>";				
				$test .= "<td>".utf8_decode($iptu->razao_social)."</td>";				
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				
				$test .= "<td>".utf8_decode($iptu->status_pref)."</td>";				
				$test .= "<td>".utf8_decode($iptu->ano_ref)."</td>";				
				$test .= "<td>".utf8_decode($possuiCnd)."</td>";				
				$test .= "</tr>";										
			}			
			$test .='</table>';
			}			
			
			header("Content-type: application/vnd.ms-excel");		
			header("Content-Disposition: attachment; filename=$file");		
			echo $test;	
			
  }	  
 
 
  function csv($result){

  $file="iptu.xls";	
	if($result == 0){			
		$test="
		<table border=1>		<tr>		
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>				</tr>		";		
		$test .='</table>';    
	}else{				
		$test="<table border=1>			<tr >			<td colspan='18'>Filtro por Im&oacute;vel</td>			</tr>			<tr>			<td>Id</td>			<td>Nome Im&oacute;vel</td>			<td>Inscri&ccedil;&atilde;o</td>			<td>Area Total</td>			<td>Area Construida</td>			<td>Valor</td>			<td>Cidade</td>			<td>Estado</td>			<td>Informa&ccedil;&otilde;es Inclusas</td>			<td>Observa&ccedil;&otilde;es</td>			<td>Nome Propriet&aacute;rio</td>			<td>CPF/CNPJ</td>			<td>Status Prefeitura</td>			<td>Ativo</td>			<td>Ano Refer&ecirc;ncia</td>			<td>Possui CND?</td>			<td>Data</td>			<td>Alterado Por </td>			<td>Data Altera&ccedil;&atilde;o </td>			<td>Dados Alterados </td>							</tr>			";							 			  
			foreach($result as $key => $iptu){ 				  
				$dadosLog = $this->log_model->listarLog($iptu->id_iptu,'iptu');							  
				$isArrayLog =  is_array($dadosLog) ? '1' : '0';				  			  				
				if($iptu->ativo == 0){					
					$ativo='Ativo';				
				}else{					
					$ativo='Inativo';				
				}						 
				if($iptu->cnd == 1){					
					$possuiCnd ='Sim';					
					$dataVArr = explode("-",$iptu->data_vencto);									 					
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];				 
				}elseif($iptu->cnd == 2){					
					$possuiCnd ='Não';					
					$dataVArr = explode("-",$iptu->data_vencto);									 					
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					 
				}elseif($iptu->cnd == 3){					
					$possuiCnd ='Pendência';					
					$dataVArr = explode("-",$iptu->data_pendencias);									 					
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];					
				}else{					
					$possuiCnd ='Nada Consta';					
					$dataV = 'Sem Data de Vencimento ou Pendência';					
				}									 				
				$cor='#fff';				
				$test .= "<tr >";				
				$test .= "<td>".utf8_decode($iptu->id_iptu)."</td>";				
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";				
				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'.</td>";				
				$test .= "<td>".utf8_decode($iptu->area_total)."</td>";						
				$test .= "<td>".utf8_encode($iptu->area_construida)."</td>";				
				$test .= "<td>".utf8_encode($iptu->valor)."</td>";				
				$test .= "<td>".utf8_decode($iptu->cidade)."</td>";				
				$test .= "<td>".utf8_decode($iptu->estado)."</td>";				
				$test .= "<td>".utf8_encode($iptu->descricao)."</td>";				
				$test .= "<td>".utf8_decode($iptu->observacoes)."</td>";				
				$test .= "<td>".utf8_decode($iptu->razao_social)."</td>";				
				$test .= "<td>".utf8_decode($iptu->cpf_cnpj)."</td>";				
				$test .= "<td>".utf8_decode($iptu->status_pref)."</td>";				
				$test .= "<td>".utf8_encode($ativo)."</td>";				
				$test .= "<td>".utf8_decode($iptu->ano_ref)."</td>";				
				$test .= "<td>".utf8_decode($possuiCnd)."</td>";				
				$test .= "<td>".utf8_decode($dataV)."</td>";					
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
			}			
			
			header("Content-type: application/vnd.ms-excel");		
			header("Content-Disposition: attachment; filename=$file");		
			echo $test;	
			
  }	  
  function export(){	   
	if(!$_SESSION['login']) {
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];		
	
	$id = $this->input->post('id_imovel_export');	
	$anoEscolhido = $this->input->post('anoEscolhido');
	$idContratante = $_SESSION['cliente'] ;			
	
	if($id == 0){			
		$result = $this->iptu_model->listarIptuCsv($idContratante,$anoEscolhido);	
	}else{				
		$result = $this->iptu_model->listarIptuCsvById($idContratante,$id,$anoEscolhido);	
	}	
		
	$this->csv($result);	
}  

  function export_total_valores(){	   
	if(!$_SESSION['login']) {
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];		
	
	$hoje = date("Y-m-d");
	$hojeMenosUm = strtotime("-1 year", strtotime($hoje));
	
	$anoAtual =  date("Y");
	$esseAnoMenosUm =  date("Y", $hojeMenosUm);
	
	
	$idContratante = $_SESSION['cliente'] ;			
	
	$result = $this->iptu_model->listarIptuCsvAno($idContratante,$anoAtual,$esseAnoMenosUm);	
	
	$this->csvGrafico($result);	
} 	

function export_total_regiao(){	   
	if(!$_SESSION['login']) {
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];		
	
	$hoje = date("Y-m-d");
	$hojeMenosUm = strtotime("-1 year", strtotime($hoje));
	
	$anoAtual =  date("Y");
	$esseAnoMenosUm =  date("Y", $hojeMenosUm);
	
	
	$idContratante = $_SESSION['cliente'] ;			
	
	$result = $this->iptu_model->listarIptuCsvAnoReg($idContratante,$anoAtual,$esseAnoMenosUm);	
	$this->csvGraficoReg($result);	
} 	

  function export_estado(){	   
	if(!$_SESSION['login']) {
		redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login'];		
	
	$hoje = date("Y-m-d");
	$hojeMenosUm = strtotime("-1 year", strtotime($hoje));
	
	$anoAtual =  date("Y");
	$esseAnoMenosUm =  date("Y", $hojeMenosUm);
	
	
	$idContratante = $_SESSION['cliente'] ;			
	
	$result = $this->iptu_model->listarIptuCsvAnoEst($idContratante,$anoAtual,$esseAnoMenosUm);	
	
	$this->csv($result);	
} 	
		
	function buscaCidade(){		
			$id = $this->input->get('estado');		
			$retorno ='';	
			$result = $this->iptu_model->listarCidadeByEstado($id);			
			if($result == 0){		
				$retorno .="<option value='0'>Não Há Dados</option>";	
			}else{			
				$retorno .="<option value='0'>Escolha uma Cidade</option>";		
					foreach($result as $key => $iptu){ 			 			
						$retorno .="<option value='".$iptu->cidade."'>".$iptu->cidade."</option>";		 		
					}		
			}	
			echo json_encode($retorno);	 
			}  
			
			function buscaTodasCidades(){			$retorno ='';	$result = $this->iptu_model->listarTodasCidades();			if($result == 0){		$retorno .="<option value='X'>Não Há Dados</option>";	}else{			$retorno .="<option value='X'>Escolha uma Cidade</option>";		foreach($result as $key => $iptu){ 			 			$retorno .="<option value='".$iptu->cidade."'>".$iptu->cidade."</option>";		 		}		}	echo json_encode($retorno);	 } 
			
			function buscaImovelByEstado(){		
				$id = $this->input->get('id');		
				$retorno ='';	
				$result = $this->iptu_model->listarImovelByEstado($id);		
					if($result == 0){		
						$retorno .="<option value='0'>Não Há Dados</option>";	
					}else{			
						$retorno .="<option value='0'>Escolha um Imóvel</option>";		
							foreach($result as $key => $iptu){ 			 			
							$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";		 		
							}		
					}	
				echo json_encode($retorno); 
			}  
			
			function buscaImovel(){		
			
			$id = $this->input->get('id');		
			$retorno ='';	
			$result = $this->iptu_model->listarImovelByCidade($id);		
			if($result == 0){		
				$retorno .="<option value='0'>Não Há Dados</option>";	
			}else{			
				$retorno .="<option value='0'>Escolha um Imóvel</option>";		
				foreach($result as $key => $iptu){ 			 			
				$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";		 		
				}		
			}	
			echo json_encode($retorno);	 
			}  
			
			function buscaStatus(){	
			
				$session_data = $_SESSION['login'];	
				$idContratante = $_SESSION['cliente'] ;
	
				$status = $this->input->get('id');		
				$ano = $this->input->get('ano');		
				$estado = $this->input->get('estado');	
				$municipio = $this->input->get('municipio');	
				$imovel = $this->input->get('imovel');	
				if($ano == 0){
					$ano = date('Y');
				}	
				
				$retorno ='';		
				$result = $this->iptu_model->listarImovelByStatus($status,$estado,$municipio,$imovel,$ano,$idContratante);				
				
					if(empty($result)){		
						$retorno .="<tr>";		
						$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";		
						$retorno .="</tr>";	
					}else{		
						$base = $this->config->base_url();	$base .='index.php';	  	
						foreach($result as $key => $iptu){ 		 		 	
							if($iptu['ativo'] == 0){		
								$status ='Ativo';		
								$cor = '#009900';	 
							}else{		
								$status ='Inativo';		
								$cor = '#CC0000';	
							}	 
							if($iptu['ano_ref'] <> date('Y')){		
								$cnd ='Nada Consta';		
								$corCnd = '#990000';									
							}else{			
								if(empty($iptu['cnd'])){				
									$cnd ='Nada Consta';			
									$corCnd = '#990000'; 		
								}else{			
									if($iptu['cnd'] == 1){				
										$cnd ='Sim';				
										$corCnd = '#000099';		
									}elseif($iptu['cnd'] == 2){				
										$cnd ='Não';				
										$corCnd = '#000099';			
									}elseif($iptu['cnd'] == 3){				
										$cnd ='Pendência';				
										$corCnd = '#000099';			
									}else{				
										$cnd ='Nada Consta';				
										$corCnd = '#000099';			
									}	
									
								}	
							}	  	  
							$retorno .="<tr style='color:$cor'>";	
							if($iptu['ano_ref'] < date('Y')){	
								if($iptu['cnd']){			
									$retorno .="<td width='25%'>".$iptu['nome']."</td>";			
								}else{			
									$retorno .="<td width='25%'>".$iptu['nome']."</td>";			
								}
							}else{
								$id_iptu = $iptu['id_iptu'];
								$id_cnd = $iptu['id_cnd'];
								if($iptu['cnd'] <> '4'){	
									
									$retorno .="<td width='25%'><a href='$base/cnd_imob/editar?id=$id_cnd '>".$iptu['nome']."</a></td>";			
								}else{	
									
									$retorno .="<td width='25%'><a href='$base/cnd_imob/cadastrar?id=$id_iptu'>".$iptu['nome']."</a></td>";			
								}
							}
								
								$retorno .="<td width='15%' class='hidden-phone'>";		
									if(!empty($iptu['capa'])){			
										$retorno .= "<a href='$base/iptu/ver?id=".$iptu['id_iptu']."'> ".$iptu['inscricao']."</a>";		
									}else{				
										$retorno .=$iptu['inscricao'];		
									}		
								$retorno .="</td>";		
								$retorno .="<td width='15%' class='hidden-phone'>".$iptu['descricao']."</td>";				
								$retorno .="<td width='10%' class='hidden-phone'>".$iptu['valor']."</td>";		
								$retorno .="<td width='12%' class='hidden-phone'>".$iptu['ano_ref']."</td>";			  		
								$retorno .="<td width='10%' class='hidden-phone' style='color:$corCnd;'>".$cnd."</td>";			
								$retorno .="<td width='13%'>";            		
								$retorno .="<a href='$base/iptu/upload_iptu?id=$id_iptu' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  		
								$retorno .="<a href='$base/iptu/editar?id=$id_iptu' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";		
								$retorno .="<a href='$base/iptu/inativar?id=$id_iptu' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";		
								$retorno .="<a href='$base/iptu/ativar?id=$id_iptu' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";		
								$retorno .="</td>";		
								$retorno .="</tr>";			 	
						}		
						}	
						echo json_encode($retorno);	 
						}  
			function buscaAno(){		
				$id = $this->input->get('id');		
				$estado = $this->input->get('estado');	
				$municipio = $this->input->get('municipio');	
				$imovel = $this->input->get('imovel');		
				$retorno ='';		
				$result = $this->iptu_model->listarImovelByAno($id,$estado,$municipio,$imovel);				
					if($result == 0){		
						$retorno .="<tr>";		
						$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";		
						$retorno .="</tr>";	
					}else{		
						$base = $this->config->base_url();	$base .='index.php';	  	
						foreach($result as $key => $iptu){ 		 		 	
							if($iptu->ativo == 0){		
								$status ='Ativo';		
								$cor = '#009900';	 
							}else{		
								$status ='Inativo';		
								$cor = '#CC0000';	
							}	 
							if($iptu->ano_ref <> date('Y')){		
								$cnd ='Nada Consta';		
								$corCnd = '#990000';									
							}else{			
								if(empty($iptu->cnd)){				
									$cnd ='Nada Consta';			
									$corCnd = '#990000'; 		
								}else{			
									if($iptu->cnd == 1){				
										$cnd ='Sim';				
										$corCnd = '#000099';		
									}elseif($iptu->cnd == 2){				
										$cnd ='Não';				
										$corCnd = '#000099';			
									}else{				
										$cnd ='Pendência';				
										$corCnd = '#000099';			
									}											
								}	
							}	  	  
							$retorno .="<tr style='color:$cor'>";	
							if($iptu->ano_ref < date('Y')){	
								if($iptu->cnd){			
									$retorno .="<td width='25%'>".$iptu->nome."</td>";			
								}else{			
									$retorno .="<td width='25%'>".$iptu->nome."</td>";			
								}
							}else{
								if($iptu->cnd){			
									$retorno .="<td width='25%'><a href='$base/cnd_imob/editar?id=$iptu->id_cnd'>".$iptu->nome."</a></td>";			
								}else{			
									$retorno .="<td width='25%'><a href='$base/cnd_imob/cadastrar?id=$iptu->id_iptu'>".$iptu->nome."</a></td>";			
								}
							}
								
								$retorno .="<td width='15%' class='hidden-phone'>";		
									if(!empty($iptu->capa)){			
										$retorno .= "<a href='$base/iptu/ver?id=$iptu->id_iptu'> $iptu->inscricao</a>";		
									}else{				
										$retorno .=$iptu->inscricao;		
									}		
								$retorno .="</td>";		
								$retorno .="<td width='15%' class='hidden-phone'>".$iptu->descricao."</td>";				
								$retorno .="<td width='10%' class='hidden-phone'>".$iptu->valor."</td>";		
								$retorno .="<td width='12%' class='hidden-phone'>".$iptu->ano_ref."</td>";			  		
								$retorno .="<td width='10%' class='hidden-phone' style='color:$corCnd;'>".$cnd."</td>";			
								$retorno .="<td width='13%'>";            		
								$retorno .="<a href='$base/iptu/upload_iptu?id=$iptu->id_iptu' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  		
								$retorno .="<a href='$base/iptu/editar?id=$iptu->id_iptu' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";		
								$retorno .="<a href='$base/iptu/inativar?id=$iptu->id_iptu' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";		
								$retorno .="<a href='$base/iptu/ativar?id=$iptu->id_iptu' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";		
								$retorno .="</td>";		
								$retorno .="</tr>";			 	
						}		
						}	
						echo json_encode($retorno);	 
						}  
			
			function busca(){		
				$id = $this->input->get('id');		
				$retorno ='';	
				$result = $this->iptu_model->listarImovelByImovel($id);		
					if($result == 0){		
						$retorno .="<tr>";		
						$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";		
						$retorno .="</tr>";	
					}else{		
						$base = $this->config->base_url();	
						$base .='index.php';	  
						foreach($result as $key => $iptu){ 		 		 
							if($iptu->ativo == 0){		
								$status ='Ativo';		
								$cor = '#009900';	
							}else{		
								$status ='Inativo';		
								$cor = '#CC0000';	 
							}	  	
							if($iptu->ano_ref <> date('Y')){		
								$cnd ='Nada Consta';		
								$corCnd = '#990000';									
							}else{			
								if(empty($iptu->cnd)){				
									$cnd ='Nada Consta';			
									$corCnd = '#990000'; 		
								}else{			
									if($iptu->cnd == 1){				
										$cnd ='Sim';				
										$corCnd = '#000099';			
									}elseif($iptu->cnd == 2){				
										$cnd ='Não';				
										$corCnd = '#000099';		
									}else{				
										$cnd ='Pendência';				
										$corCnd = '#000099';			
									}											
								}	
							}	  	  
							$retorno .="<tr style='color:$cor'>";
							if($iptu->ano_ref < date('Y')){	
								if($iptu->cnd){			
									$retorno .="<td width='25%'>".$iptu->nome."</td>";			
								}else{			
									$retorno .="<td width='25%'>".$iptu->nome."</td>";			
								} 	
							}else{
								if($iptu->cnd){			
									$retorno .="<td width='25%'><a href='$base/cnd_imob/editar?id=$iptu->id_cnd'>".$iptu->nome."</a></td>";			
								}else{			
									$retorno .="<td width='25%'><a href='$base/cnd_imob/cadastrar?id=$iptu->id_iptu'>".$iptu->nome."</a></td>";			
								} 	
							
							}
							
							$retorno .="<td width='15%'  class='hidden-phone'>";		
								if(!empty($iptu->capa)){			
									$retorno .= "<a href='$base/iptu/ver?id=$iptu->id_iptu'> $iptu->inscricao</a>";		
								}else{				
									$retorno .=$iptu->inscricao;		
								}	
								
							$retorno .="</td>";		
							$retorno .="<td width='15%' class='hidden-phone'>".$iptu->descricao."</td>";				
							$retorno .="<td width='10%' class='hidden-phone'>".$iptu->valor."</td>";		
							$retorno .="<td width='12%' class='hidden-phone'>".$iptu->ano_ref."</td>";			  		
							$retorno .="<td width='10%' class='hidden-phone' style='color:$corCnd;'>".$cnd."</td>";			
							$retorno .="<td width='13%'>";            		
							$retorno .="<a href='$base/iptu/upload_iptu?id=$iptu->id_iptu' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  		
							$retorno .="<a href='$base/iptu/editar?id=$iptu->id_iptu' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";		
							$retorno .="<a href='$base/iptu/inativar?id=$iptu->id_iptu' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";		
							$retorno .="<a href='$base/iptu/ativar?id=$iptu->id_iptu' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";		
							$retorno .="</td>";		
							$retorno .="</tr>";				 	
		}		
	}	echo json_encode($retorno);	 }   
	
	function buscaEstado(){		
		$id = $this->input->get('id');		
		$retorno ='';	
		$result = $this->iptu_model->listarImovelByUf($id);		
		if($result == 0){		
			$retorno .="<tr>";		
			$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";		
			$retorno .="</tr>";	
		}else{		
			$base = $this->config->base_url();	  
			$base .='index.php';	
			foreach($result as $key => $iptu){ 		 	  
				if($iptu->ativo == 0){		
					$status ='Ativo';		
					$cor = '#009900';	 
				}else{		
					$status ='Inativo';		
					$cor = '#CC0000';	 
				}									 	 
				/*	if($iptu->cnd){		$cnd ='Sim';		$corCnd = '#000099';	}else{		$cnd ='Não';		$corCnd = '#990000';	}	  */	
				if($iptu->ano_ref <> date('Y')){		
					$cnd ='Nada Consta';		
					$corCnd = '#990000';									
				}else{			
					if(empty($iptu->cnd)){				
						$cnd ='Nada Consta';			
						$corCnd = '#990000'; 		
					}else{			
						if($iptu->cnd == 1){				
							$cnd ='Sim';				
							$corCnd = '#000099';			
						}elseif($iptu->cnd == 2){				
							$cnd ='Não';				
							$corCnd = '#000099';			
						}else{				
							$cnd ='Pendência';				
							$corCnd = '#000099';			
						}											
					}	
				}	  	  	 
				$retorno .="<tr style='color:$cor'>";
				if($iptu->ano_ref < date('Y')){		
					if($iptu->cnd){			
						$retorno .="<td width='25%'>".$iptu->nome."</td>";			
					}else{			
						$retorno .="<td width='25%'>".$iptu->nome."</td>";
					} 
				}else{
					if($iptu->cnd){			
						$retorno .="<td width='25%'><a href='$base/cnd_imob/editar?id=$iptu->id_cnd'>".$iptu->nome."</a></td>";			
					}else{			
						$retorno .="<td width='25%'><a href='$base/cnd_imob/cadastrar?id=$iptu->id_iptu'>".$iptu->nome."</a></td>";
					} 

				}
				$retorno .="<td width='15%'  class='hidden-phone'>";		
					if(!empty($iptu->capa)){			
						$retorno .= "<a href='$base/iptu/ver?id=$iptu->id_iptu'> $iptu->inscricao</a>";		
					}else{				
						$retorno .=$iptu->inscricao;		
					}			
				$retorno .="</td>";		
				$retorno .="<td width='15%' class='hidden-phone'>".$iptu->descricao."</td>";				
				$retorno .="<td width='10%' class='hidden-phone'>".$iptu->valor."</td>";		
				$retorno .="<td width='12%' class='hidden-phone'>".$iptu->ano_ref."</td>";			  		
				$retorno .="<td width='10%' class='hidden-phone' style='color:$corCnd;'>".$cnd."</td>";			
				$retorno .="<td width='13%'>";            		
				$retorno .="<a href='$base/iptu/upload_iptu?id=$iptu->id_iptu' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  		
				$retorno .="<a href='$base/iptu/editar?id=$iptu->id_iptu' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";		
				$retorno .="<a href='$base/iptu/inativar?id=$iptu->id_iptu' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";		
				$retorno .="<a href='$base/iptu/ativar?id=$iptu->id_iptu' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";		
				$retorno .="</td>";		
				$retorno .="</tr>";			 	
				}		
			}	
			echo json_encode($retorno);	 
	}  
			
	function buscaMunicipio(){		
		$id = $this->input->get('id');		
		$retorno ='';	
		$result = $this->iptu_model->listarImovelByMunicipio($id);		
		if($result == 0){		
			$retorno .="<tr>";		
			$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";		
			$retorno .="</tr>";	
		}else{		
			$base = $this->config->base_url();	$base .='index.php';		
			foreach($result as $key => $iptu){ 		 	 
				if($iptu->ativo == 0){		
					$status ='Ativo';		
					$cor = '#009900';	 
				}else{		
					$status ='Inativo';		
					$cor = '#CC0000';	 
				}		
				if($iptu->ano_ref <> date('Y')){		
					$cnd ='Nada Consta';		
					$corCnd = '#990000';									
				}else{			
					if(empty($iptu->cnd)){				
						$cnd ='Nada Consta';			
						$corCnd = '#990000'; 		
					}else{			
						if($iptu->cnd == 1){				
							$cnd ='Sim';				
							$corCnd = '#000099';			
						}elseif($iptu->cnd == 2){				
							$cnd ='Não';				
							$corCnd = '#000099';			
						}else{				
							$cnd ='Pendência';				
							$corCnd = '#000099';			
						}											
					}	
				}	  	   
				$retorno .="<tr style='color:$cor'>";
				if($iptu->ano_ref < date('Y')){	
					if($iptu->cnd){			
						$retorno .="<td width='25%'>".$iptu->nome."</td>";			
					}else{			
						$retorno .="<td width='25%'>".$iptu->nome."</td>";			
					} 
				}else{
					if($iptu->cnd){			
						$retorno .="<td width='25%'><a href='$base/cnd_imob/editar?id=$iptu->id_cnd'>".$iptu->nome."</a></td>";			
					}else{			
						$retorno .="<td width='25%'><a href='$base/cnd_imob/cadastrar?id=$iptu->id_iptu'>".$iptu->nome."</a></td>";			
					} 

				}
					
				$retorno .="<td width='15%'  class='hidden-phone'>";		
					if(!empty($iptu->capa)){			
						$retorno .= "<a href='$base/iptu/ver?id=$iptu->id_iptu'> $iptu->inscricao</a>";		
					}else{				
						$retorno .=$iptu->inscricao;		
					}			
				$retorno .="</td>";		
				$retorno .="<td width='15%' class='hidden-phone'>".$iptu->descricao."</td>";				
				$retorno .="<td width='10%' class='hidden-phone'>".$iptu->valor."</td>";		
				$retorno .="<td width='12%' class='hidden-phone'>".$iptu->ano_ref."</td>";			  		
				$retorno .="<td width='10%' class='hidden-phone' style='color:$corCnd;'>".$cnd."</td>";			
				$retorno .="<td width='13%'>";            		
				$retorno .="<a href='$base/iptu/upload_iptu?id=$iptu->id_iptu' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  		
				$retorno .="<a href='$base/iptu/editar?id=$iptu->id_iptu' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";		
				$retorno .="<a href='$base/iptu/inativar?id=$iptu->id_iptu' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";		
				$retorno .="<a href='$base/iptu/ativar?id=$iptu->id_iptu' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";		
				$retorno .="</td>";		
				$retorno .="</tr>";		 	
				}		
			}	
		echo json_encode($retorno);	 
	} 
	
 function listar(){	  
	if(!$_SESSION['login']) {
		redirect('login', 'refresh');
	}
	
	$ano = date('Y');
	
	$session_data = $_SESSION['login'];		
	
	$idContratante = $_SESSION['cliente'] ;					
	
	$data['perfil'] = $session_data['perfil'];		
	$data['imoveis'] = $this->iptu_model->listarImovel($idContratante);		
	$data['estados'] = $this->iptu_model->listarEstado($idContratante);		
	$data['cidades'] = $this->iptu_model->listarCidade($idContratante);		
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}

	$total = $this->iptu_model->somarTodos($idContratante);	
	
	$data['perfil'] = $session_data['perfil'];	
	
	$hoje = date("Y-m-d");	
	$hojeMenosUm = strtotime("-1 year", strtotime($hoje));	
	$hojeMenosDois = strtotime("-2 year", strtotime($hoje));	
	$hojeMenosTres = strtotime("-3 year", strtotime($hoje));	
	$hojeMenosQuatro = strtotime("-4 year", strtotime($hoje));		
	$anoAtual =  date("Y");	
	$esseAnoMenosUm =  date("Y", $hojeMenosUm);	
	$esseAnoMenosDois =  date("Y", $hojeMenosDois);	
	$esseAnoMenosTres =  date("Y", $hojeMenosTres);	
	$esseAnoMenosQuatro =  date("Y", $hojeMenosQuatro);		
	$anos = array($anoAtual,$esseAnoMenosUm,$esseAnoMenosDois,$esseAnoMenosTres,$esseAnoMenosQuatro);	
	$data['anos']  = $anos;
	
	
	if(empty($_POST)){
		$data['cidadeBD'] = 0;
		$data['status_iptu'] = 0;
		$data['estadoBD'] = 0;
		$data['idImIpBD'] = 0;
	
		
		$data['iptus'] = $this->iptu_model->listarTodosIptu($idContratante,$ano);
		
	}else{
		
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		$ano = $_POST['ano'];
		$status = $_POST['status'];

		$data['cidadeBD'] = $municipioListar;
		$data['status_iptu'] = $status;
		$data['estadoBD'] = $estadoListar;
		$data['idImIpBD'] = $idImovelListar;
		
		if($ano == 0){
			$ano = date('Y');
		}
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result =  $this->iptu_model->listarImovelByMunicipio($idContratante,$municipioListar,$ano,$status);							
			}else{
				$result =  $this->iptu_model->listarImovelByUf($idContratante,$estadoListar,$ano,$status);							
			}
		}else{	
			$result = $this->iptu_model->listarImovelByImovel($idImovelListar,$ano,$status);				
		}
		
	   
	   	$data['iptus'] = $result;	
		

	}
	
		
	$this->load->view('header_pages_view',$data);
	$this->load->view('listar_iptu_view', $data);
	$this->load->view('footer_pages_view');
	
 }
 
  function limpar_filtro(){	  
	$this->session->set_userdata('cidadeIpBD', 0);
	$this->session->set_userdata('estadoIpBD',  0);
	$this->session->set_userdata('idImIpBD', 0);
	$_SESSION["status_iptu"]=0;
	redirect('/iptu/listar', '');		
 }
 
   function listarComParametro(){	
 
	$uf = $this->input->get('uf');	
	
	$this->session->set_userdata('cidadeIpBD', 0);
	$this->session->set_userdata('estadoIpBD', $uf);
	$this->session->set_userdata('idImIpBD', 0);

	redirect('/iptu/listar', '');

 }
 

}
 
?>