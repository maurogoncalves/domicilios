<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cnd_obras extends CI_Controller {
	 function __construct(){
		parent::__construct();
		$this->load->model('cnd_obras_model','',TRUE);	
		$this->load->model('matricula_cei_model','',TRUE);	
		$this->load->model('cnd_obras_model','',TRUE);	
		$this->load->model('log_model','',TRUE);
		$this->load->model('cnd_obras_model','',TRUE);
		$this->load->model('emitente_imovel_model','',TRUE);
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
		
		session_start();

	 }
  function index(){
   if( $_SESSION['login']){
     $session_data =  $_SESSION['login'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
     $this->load->view('home_view', $data);
   }else{
     redirect('login', 'refresh');
   }


 }
 
  function limpar_filtro(){
	$_SESSION['cidadeCNDOBD'] = 0;
	$_SESSION['estadoCNDOBD'] = 0;
	$_SESSION['idCNDOBD'] = 0;	
	$modulo = $_SESSION['CNDObras'];

	redirect('/cnd_obras/'.$modulo, 'refresh');  
 }
 
 function dados_agrupados(){	
 
 if(! $_SESSION['login']){
		redirect('login', 'refresh');
  }
  
	$cidade = '0';
	$estado = '0';
	
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data =  $_SESSION['login'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

		
	$_SESSION['cidadeCNDOBD'] = 0;
	$_SESSION['estadoCNDOBD'] = 0;
	$_SESSION['idCNDOBD'] = 0;	


    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data =  $_SESSION['login'];
	$ultimoDia = date('Y').'-12-31';
	//$result = $this->cnd_obras_model->contaCndReg($idContratante,$ultimoDia);

	$regionais = $this->cnd_obras_model->regionais();
	$regionalSim = array();
	$regionalNao = array();
	$regionalPend = array();
	$regionalTodos = array();
	$regionalNC = array();
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_obras_model->contaCndReg($idContratante,$ultimoDia,1,$reg->id);
		$regionalSim[$i]['regional'] = $reg->descricao;
		$regionalSim[$i]['total'] = $result[0]->total;
		$i++;
	}

	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_obras_model->contaCndReg($idContratante,$ultimoDia,2,$reg->id);
		$regionalNao[$i]['regional'] = $reg->descricao;
		$regionalNao[$i]['total'] = $result[0]->total;
		$i++;
	}

	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_obras_model->contaCndReg($idContratante,$ultimoDia,3,$reg->id);
		$regionalPend[$i]['regional'] = $reg->descricao;
		$regionalPend[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_obras_model->contaCndReg($idContratante,$ultimoDia,4,$reg->id);
		$regionalNC[$i]['regional'] = $reg->descricao;
		$regionalNC[$i]['total'] = $result[0]->total;
		$i++;
	}
	
	$i=1;
	foreach($regionais as $reg){
		$result = $this->cnd_obras_model->contaCndReg($idContratante,$ultimoDia,0,$reg->id);
		$regionalTodos[$i]['regional'] = $reg->descricao;
		$regionalTodos[$i]['total'] = $result[0]->total;
		$i++;
	}
	
		$data['regionalSim'] = $regionalSim ;
	$data['regionalNao'] = $regionalNao;
	$data['regionalPend'] = $regionalPend;
	$data['regionalNC'] = $regionalNC;
	$data['regionalTodos'] = $regionalTodos;
	
	$data['modulo'] = 'cnd_obras';
	$data['nome_modulo'] = 'CND Obras';
	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->load->view('header_pages_view',$data);

    $this->load->view('dados_agrupados_cnd_obras_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
  function cadastrar(){
	if(! $_SESSION['login']){
		redirect('login', 'refresh');
	}
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$id = $this->input->get('id');
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$data['dados_cei'] = $this->matricula_cei_model->listarCeiById($id);
 	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('cadastrar_cnd_obras_view', $data);
	$this->load->view('footer_pages_view');
 }
 function enviar_pend(){
		
		$id = $this->input->post('id');
		
		$dadosCidadeEstado = $this->cnd_obras_model->listarCidadeEstadoById($id);
		
		$_SESSION['cidadeCNDOBD'] = $dadosCidadeEstado['0']->cidade;
		$_SESSION['estadoCNDOBD'] = $dadosCidadeEstado['0']->estado;
		$_SESSION['idCNDOBD'] = $id;
	
		$modulo = $_SESSION['CNDObras'];
	
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/cnd_obras_pend/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'.'.$extensao;
		
		$this->load->library('upload', $config);

		$this->upload->initialize($config);
		$field_name = "userfile";
		
		$dadosArquivo = $this->cnd_obras_model->listarCndById($id);
		if($dadosArquivo[0]->arquivo_pendencias){
			$b = getcwd();
			$a = @unlink($b.'/assets/cnd_obras_pend/'.$dadosArquivo[0]->arquivo_pendencias);
		}
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			
			$data['mensagem'] = $this->upload->display_errors();exit;
		}else{
			$dados = array('arquivo_pendencias' => $id.'.'.$extensao);
				
			$this->cnd_obras_model->atualizar($dados,$id);
			$data = array('upload_data' => $this->upload->data($field_name));
			$this->session->set_flashdata('mensagem','Upload Feito com Sucesso');
		}
		redirect('/cnd_obras/'.$modulo);		
 }
 
 function enviar(){
		
		$id = $this->input->get('id');		
		$file = $_FILES["userfile"]["name"];				
		$extensao = str_replace('.','',strrchr($file, '.'));						
		$base = base_url();		        
		$config['upload_path'] = './assets/cnd_obras/';		
		$config['allowed_types'] = '*';		
		$config['overwrite'] = 'true';				
		$config['file_name'] = $id.'.'.$extensao;				
		$this->load->library('upload', $config);	
		$this->upload->initialize($config);		
		$field_name = "userfile";	
		$dadosArquivo = $this->cnd_obras_model->listarCndById($id);	
		if($dadosArquivo[0]->arquivo_cnd){
			$b = getcwd();
			$a = @unlink($b.'/assets/cnd_obras/'.$dadosArquivo[0]->arquivo_cnd);
		}
		
		if (!$this->upload->do_upload($field_name)){			
			$error = array('error' => $this->upload->display_errors());						
			$_SESSION['mensagemCndObras'] =  $this->upload->display_errors();
			echo '0'; 
		}else{	
		
			$dados = array(
			'arquivo_cnd' => $id.'.'.$extensao,
			'possui_cnd' => 1
			);
				
			$this->cnd_obras_model->atualizar($dados,$id);
			
			$data = array('upload_data' => $this->upload->data($field_name));		
			$_SESSION['mensagemCndObras'] =  UPLOAD;
			echo'1';
			
			
		}
		
 }
 function upload_cnd(){
	
	
  $session_data =  $_SESSION['login'];	
 
  if(! $_SESSION['login']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  
  $data['dados_cei'] = $this->cnd_obras_model->listarCndById($id);
  $data['dataEmissao'] = $this->cnd_obras_model->listarTodasDataEmissao($id,'obras');		
  
  $data['perfil'] = $session_data['perfil'];

  if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
  $this->load->view('header_pages_view',$data);

  $this->load->view('upload_cnd_obras', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
  function export(){	
	  
	  if(! $_SESSION['login']){
			redirect('login', 'refresh');
	  }
	  
  	$id = $this->input->post('id_imovel_export');
	$tipo = $this->input->post('tipo');
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	if($id == 0){
	
		$result = $this->cnd_obras_model->listarTodasCnds($idContratante,$tipo);
	}else{

		$result = $this->cnd_obras_model->listarCndByIdCnd($id,$tipo);
	}
	
	$this->csv($result);
	
  }
  
    function export_est(){	
	  
	  if(! $_SESSION['login']){
			redirect('login', 'refresh');
	  }
	  
  	$id = $this->input->post('id_estado_export');
	$tipo = $this->input->post('tipo');
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$result = $this->cnd_obras_model->listarCndByEstado($idContratante,$id,$tipo);
	$this->csv($result);
	
  }
  
    function export_mun(){	
	  
	  if(! $_SESSION['login']){
			redirect('login', 'refresh');
	  }
	  
  	$id = $this->input->post('id_mun_export');
	$tipo = $this->input->post('tipo');
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	
	$result = $this->cnd_obras_model->listarCndByCidade($idContratante,$id,$tipo);
	$this->csv($result);
	
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
			<td>Observa&ccedil;&otilde;es</td>	
			<td>Plano de A&ccedil;&atilde;o</td>				
			<td>Possui CND</td>
			<td>Data</td>
			<td>Data de Emiss&atilde;o</td>
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>				
			
			</tr>
			";
			
			
	

	}  
	  
			foreach($result as $key => $iptu){ 	
			  $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_obras');				
			  $isArrayLog =  is_array($dadosLog) ? '1' : '0';
			  
			$datasEmissao = $this->cnd_obras_model->listarTodasDataEmissao($iptu->id_cnd,'obras');
			$isdatasEmissao=  is_array($datasEmissao) ? '1' : '0';
				
				if($iptu->ativo == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->possui_cnd == 1){
					$possui_cnd ='Sim';
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
				}else if($iptu->possui_cnd == 2){
					$possui_cnd ='Não';
					$dataVArr = explode("-",$iptu->data_vencto);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
				}else{
					$possui_cnd ='Pendência';
					$dataVArr = explode("-",$iptu->data_pendencias);									 
					$dataV = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
				}
				
				if($iptu->status_obra == 1){
					$statusObra = 'Aberta';
				}else{
					$statusObra = 'Encerrada';
				}
				
				
				$arrDataVencto = explode("-",$iptu->data_vencto);
				$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".($iptu->id_cnd)."</td>";
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
				$test .= "<td>".utf8_decode($iptu->observacoes)."</td>";
				$test .= "<td>".utf8_decode($iptu->plano)."</td>";
				$test .= "<td>".utf8_decode($possui_cnd)."</td>";
				$test .= "<td>".($dataV)."</td>";
				if($isdatasEmissao <> 0){
					$test .="<td>";					
					foreach($datasEmissao as $dataE){ 					
						$test .= $dataE->data_emissao.' ';					
					}	
					$test .="</td>";				
				}else{
					$test .="<td>";
					$test .="</td>";						
				}
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
 function upload_cnd_pend(){
	
	
  $session_data =  $_SESSION['login'];	
 
  if(! $_SESSION['login']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  $data['imovel'] = $this->cnd_obras_model->listarCndById($id);
  
	
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_pages_view',$data);

  $this->load->view('upload_cnd_pend_obras', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
 function ver(){
	
	
  $session_data =  $_SESSION['login'];	
 
  if(! $_SESSION['login']){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  $data['imovel'] = $this->cnd_obras_model->listarCndById($id);

	
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_pages_view',$data);

  $this->load->view('ver-cnd-obras', $data);

  $this->load->view('footer_pages_view');
				
 
 }
 
 

 function cadastrar_cnd_obras(){
 
   if(! $_SESSION['login']){
		redirect('login', 'refresh');
  }


	$session_data =  $_SESSION['login'];


	$idContratante = $_SESSION['cliente'] ;

	$possui_cnd = $this->input->post('possui_cnd');	
	

	$id = $this->input->post('id');	
	
	if(empty($id)){
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
		redirect('/cnd_obras/listar');
	}
	
	$data_vencto = $this->input->post('data_vencto');
	
	if(!empty($data_vencto )){
		$arrDataVencto = explode("/",$data_vencto);
		$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
	}else{
		$dataVencto ='0000-00-00';
	}
	


	
	$observacoes = $this->input->post('observacoes');	
	$plano = $this->input->post('plano');	
	
	if($possui_cnd == 1){

		$dados = array(
			'id_cei' => $id,
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,

		);
		
		$data_emissao = $this->input->post('data_emissao');
	
		if(!empty($data_emissao )){
			$arrDataEmissao = explode("/",$data_emissao);
			$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		}else{
			$dataEmissao ='0000-00-00';
		}
		
		
	}elseif ($possui_cnd == 2){
		$dados = array(
			'id_cei' => $id,
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
		);
	
	}else{

	$dados = array(
			'id_cei' => $id,
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
		);
	}

    $id = $this->cnd_obras_model->add($dados);
	if($id){
		$this->session->set_flashdata('mensagem','Cadastro Feito com sucesso');
		if($possui_cnd == 1){
			
			$dadosDataEmissao = array(
			'id_cnd' => $id,
			'modulo' => 'obras',
			'data_emissao' =>$dataEmissao,
			);
			
			$this->cnd_obras_model->addDataEmissao($dadosDataEmissao,$id,'obras');
			redirect('/cnd_obras/upload_cnd?id='.$id, 'refresh');
		}elseif ($possui_cnd == 2){
			redirect('/cnd_obras/listar', 'refresh');
		}else{
			redirect('/cnd_obras/upload_cnd_pend?id='.$id, 'refresh');
		}
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}
	redirect('/cnd_obras/listar', 'refresh');

 }

 
 function inativar(){
	if(! $_SESSION['login']){
			redirect('login', 'refresh');
	  }

	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	
	$id = $this->input->get('id');

	$dados = array('ativo' => 0);

	$dadosAlterados ='';
	
	$dadosAlterados .= ' - Status Inativo';
	
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'cnd_obras',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => $dadosAlterados,
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	
		$dadosCidadeEstado = $this->cnd_obras_model->listarCidadeEstadoById($id);
		
		$_SESSION['cidadeCNDOBD'] = $dadosCidadeEstado['0']->cidade;
		$_SESSION['estadoCNDOBD'] = $dadosCidadeEstado['0']->estado;
		$_SESSION['idCNDOBD'] = $id;
		$modulo = $_SESSION['CNDObras'];
	
	if($this->cnd_obras_model->atualizar($dados,$id)) {
		$this->session->set_flashdata('mensagem','Cadastro Inativado com Sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}
	redirect('/cnd_obras/'.$modulo, 'refresh');

 }
 
 function ativar(){
	if(! $_SESSION['login']){
			redirect('login', 'refresh');
	  }

	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	
	$id = $this->input->get('id');

	$dados = array('ativo' => 1);

	$dadosAlterados ='';
	
	$dadosAlterados .= ' - Status Inativo';
	
	
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'cnd_obras',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => $dadosAlterados,
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	
		$dadosCidadeEstado = $this->cnd_obras_model->listarCidadeEstadoById($id);
		
		$_SESSION['cidadeCNDOBD'] = $dadosCidadeEstado['0']->cidade;
		$_SESSION['estadoCNDOBD'] = $dadosCidadeEstado['0']->estado;
		$_SESSION['idCNDOBD'] = $id;
		$modulo = $_SESSION['CNDObras'];
	
	if($this->cnd_obras_model->atualizar($dados,$id)) {
		$this->session->set_flashdata('mensagem','Cadastro Atualizado com Sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}
	redirect('/cnd_obras/'.$modulo, 'refresh');

 }
 

 function atualizar_cnd(){
	if(! $_SESSION['login']){
			redirect('login', 'refresh');
	  }
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	$id = $this->input->post('id_cnd');	
	$possui_cnd = $this->input->post('possui_cnd');
	$data_vencto = $this->input->post('data_vencto');		
	$arrDataVencto = explode("/",$data_vencto);	
	$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
	$observacoes = $this->input->post('observacoes');	
	$plano = $this->input->post('plano');
	
	if($possui_cnd == 1){
		$dados = array(
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
		);
		
		$data_emissao = $this->input->post('data_emissao');	
		if(empty($data_emissao)){
			$this->session->set_flashdata('mensagem','Data de Emiss&atilde;o n&atilde;o pode ser vazia');
			redirect('/cnd_mob/'.$modulo);	
			exit;
		}
		$arrDataEmissao = explode("/",$data_emissao);	
		$dataEmissao = $arrDataEmissao[2].'-'.$arrDataEmissao[1].'-'.$arrDataEmissao[0];
		
		$dadosDataDb = $this->cnd_obras_model->listarDataEmissao($id,'obras');
		
		$dadosDataEmissao = array(
			'id_cnd' => $id,
			'modulo' => 'obras',
			'data_emissao' =>$dataEmissao,
			);
        $isArray =  is_array($dadosDataDb) ? '1' : '0';
		if($isArray == 1){
			$this->db->cache_off();
			if($dadosDataDb[0]->data_emissao <> $dataEmissao ){
				$this->cnd_obras_model->addDataEmissao($dadosDataEmissao);
			}
			
			
		}else{
			$this->cnd_obras_model->addDataEmissao($dadosDataEmissao);
		}
		
	}elseif ($possui_cnd == 2){
		$dados = array(
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
		);
	
	}else{
	$dados = array(
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
			'plano' => $plano,
		);
	}

	$dadosCidadeEstado = $this->cnd_obras_model->listarCidadeEstadoById($id);
		
	$_SESSION['cidadeCNDOBD'] = $dadosCidadeEstado['0']->cidade;
	$_SESSION['estadoCNDOBD'] = $dadosCidadeEstado['0']->estado;
	$_SESSION['idCNDOBD'] = $id;
	
	$modulo = $_SESSION['CNDObras'];
	
	$dadosAtuais = $this->cnd_obras_model->listarCNDById($id);
	$dadosAlterados ='';
	
	
	$arrDataAtual = explode("-",$dadosAtuais[0]->data_vencto);	
	$dataAtual = $arrDataAtual[2].'/'.$arrDataAtual[1].'/'.$arrDataAtual[0];
	$arrDataPAtual = explode("-",$dadosAtuais[0]->data_pendencias);	
	$dataPAtual = $arrDataPAtual[2].'/'.$arrDataPAtual[1].'/'.$arrDataPAtual[0];
	
	if($dadosAtuais[0]->possui_cnd <> $possui_cnd){
		if($dadosAtuais[0]->possui_cnd == 1){
			$dadosAlterados .= ' - Possui CND: Sim';
			if($dadosAtuais[0]->data_vencto <> $dataVencto){
				$dadosAlterados .= ' - Data Vencimento: '.$dataAtual;
			
			}
		}else if($dadosAtuais[0]->possui_cnd == 2){
			$dadosAlterados .= ' - Possui CND: Não';
			if($dadosAtuais[0]->data_vencto <> $dataVencto){
				$dadosAlterados .= ' - Data Vencimento: '.$dataAtual;
			
			}			
		}
		else{
			$dadosAlterados .= ' - Possui CND: Pendência';
			
			if($dadosAtuais[0]->data_pendencias <> $dataVencto){
				$dadosAlterados .= ' - Data Pendência: '.$dataPAtual;
			
			}

		}
	}
	if($dadosAtuais[0]->observacoes <> $observacoes){
		$dadosAlterados .= ' - Observações: '.$dadosAtuais[0]->observacoes;	
	}

	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'cnd_obras',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => $dadosAlterados,
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	
	
	$this->cnd_obras_model->atualizar($dados,$id);
	
		

	if($possui_cnd == 1){
		redirect('/cnd_obras/upload_cnd?id='.$id);
	}elseif ($possui_cnd == 2){
		$this->session->set_flashdata('mensagem','Cadastro Atualizado com sucesso');
		redirect('/cnd_obras/'.$modulo);	
	}else{
		redirect('/cnd_obras/upload_cnd_pend?id='.$id);
	}
	

 }


 

  function editar(){	
  
  if(! $_SESSION['login']){
		redirect('login', 'refresh');
  }

	$id = $this->input->get('id');
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->iptu_model->listarImovelByIdIptu($id);
	$data['imovel'] = $this->cnd_obras_model->listarCndByIdCei($id);

	$dadosDataDb = $this->cnd_obras_model->listarDataEmissao($data['imovel'][0]->id_cnd,'obras');
	
	$data['data_emissao'] = $dadosDataDb;
	
	
	$_SESSION['cidadeCNDOBD'] = $data['imovel']['0']->cidade;
	$_SESSION['estadoCNDOBD'] = $data['imovel']['0']->estado;
	$_SESSION['idCNDOBD'] = $id;	
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_cnd_obras_view', $data);
	$this->load->view('footer_pages_view');

 }

  function listarPorRegional(){	
  
		  if(! $_SESSION['login']){
				redirect('login', 'refresh');
		  }
		$tipo  = $this->input->get('tipo');
		$regional  = $this->input->get('reg');
	
		$cidade = '0';
		$estado = '0';
		$data['cidadeFiltro'] = $cidade;
		$data['estadoFiltro'] = $estado;
		
		$session_data =  $_SESSION['login'];
		$idContratante = $_SESSION['cliente'] ;
		$data['perfil'] = $session_data['perfil'];
		$data['estados'] = $this->cnd_obras_model->listarEstado($idContratante,$tipo);
		$data['cidades'] = $this->cnd_obras_model->listarCidade($idContratante,$tipo);
		$data['todas_cei'] = $this->cnd_obras_model->listarCeis($idContratante,$tipo);
		$result =  $this->cnd_obras_model->listarCndTipoReg($idContratante,$regional,$tipo);
		
		//print_r($this->db->last_query());exit;
		$data['cnds'] = $result;
		$data['perfil'] = $session_data['perfil'];
		$data['tipo'] = $tipo;
		
		
		if(empty($_SESSION['cidadeCNDOBD'])){
			$data['cidadeBD'] = 0;
		}else{
			$data['cidadeBD'] = $_SESSION['cidadeCNDOBD'];
		}
		if(empty($_SESSION['estadoCNDOBD'])){
			$data['estadoBD'] = 0;	
		}else{
			$data['estadoBD'] = $_SESSION['estadoCNDOBD'];
		}
		if(empty($_SESSION['idCNDOBD'])){
			$data['idCNDOBD'] = 0;
		}else{
			$data['idCNDOBD'] = $_SESSION['idCNDOBD'];
		}
		$_SESSION['CNDObras'] = 'listarPorTipoSim';
		$data['CNDObras'] = 'listarPorTipoSim';
		if(empty($session_data['visitante'])){
			$data['visitante'] = 0;
		}else{
			$data['visitante'] = $session_data['visitante'];	
		}
		$this->load->view('header_pages_view',$data);
		$this->load->view('listar_cnd_obras_tipo_view', $data);
		$this->load->view('footer_pages_view');
		
  }
 function listarPorTipoSim(){	
 
 if(! $_SESSION['login']){
		redirect('login', 'refresh');
  }
	$tipo = '1';
	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$data['perfil'] = $session_data['perfil'];
	$data['estados'] = $this->cnd_obras_model->listarEstado($idContratante,$tipo);
	$data['cidades'] = $this->cnd_obras_model->listarCidade($idContratante,$tipo);
	$data['todas_cei'] = $this->cnd_obras_model->listarCeis($idContratante,$tipo);
	
	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->cnd_obras_model->listarCndTipo($idContratante,$tipo);
	}else{
		
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result = $this->cnd_obras_model->listarCeiByCidade($idContratante,$municipioListar,$tipo);				
			}else if($estadoListar <> '0'){
				$result = $this->cnd_obras_model->listarCeiByEstado($idContratante,$estadoListar,$tipo);				
			}else{
				$result = $this->cnd_obras_model->listarCndTipo($idContratante,$tipo);
			}
		}else{	
			$result = $this->cnd_obras_model->listarCndById($idImovelListar);
			
		}
	
	}
	//print_r($this->db->last_query());exit;
	$data['cnds'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$data['tipo'] = $tipo;
	
	
	if(empty($_SESSION['cidadeCNDOBD'])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION['cidadeCNDOBD'];
	}
	if(empty($_SESSION['estadoCNDOBD'])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] = $_SESSION['estadoCNDOBD'];
	}
	if(empty($_SESSION['idCNDOBD'])){
		$data['idCNDOBD'] = 0;
	}else{
		$data['idCNDOBD'] = $_SESSION['idCNDOBD'];
	}
	$_SESSION['CNDObras'] = 'listarPorTipoSim';
	$data['CNDObras'] = 'listarPorTipoSim';
	$this->load->view('header_pages_view',$data);
    $this->load->view('listrar_cnd_obras_tipo_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function listarPorTipoPendencia(){	
 
 if(! $_SESSION['login']){
		redirect('login', 'refresh');
  }
	$tipo = '3';
	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$data['perfil'] = $session_data['perfil'];
	$data['estados'] = $this->cnd_obras_model->listarEstado($idContratante,$tipo);
	$data['cidades'] = $this->cnd_obras_model->listarCidade($idContratante,$tipo);
	$data['todas_cei'] = $this->cnd_obras_model->listarCeis($idContratante,$tipo);
	
	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->cnd_obras_model->listarCndTipo($idContratante,$tipo);
	}else{
		
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result = $this->cnd_obras_model->listarCeiByCidade($idContratante,$municipioListar,$tipo);				
			}else if($estadoListar <> '0'){
				$result = $this->cnd_obras_model->listarCeiByEstado($idContratante,$estadoListar,$tipo);				
			}else{
				$result = $this->cnd_obras_model->listarCndTipo($idContratante,$tipo);
			}
		}else{	
			$result = $this->cnd_obras_model->listarCndById($idImovelListar);
			
		}
	
	}
	//print_r($this->db->last_query());exit;
	$data['cnds'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$data['tipo'] = $tipo;
	
	
	if(empty($_SESSION['cidadeCNDOBD'])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION['cidadeCNDOBD'];
	}
	if(empty($_SESSION['estadoCNDOBD'])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] = $_SESSION['estadoCNDOBD'];
	}
	if(empty($_SESSION['idCNDOBD'])){
		$data['idCNDOBD'] = 0;
	}else{
		$data['idCNDOBD'] = $_SESSION['idCNDOBD'];
	}
	$_SESSION['CNDObras'] = 'listarPorTipoPendencia';
	$data['CNDObras'] = 'listarPorTipoPendencia';
	$this->load->view('header_pages_view',$data);
    $this->load->view('listrar_cnd_obras_tipo_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function listarPorTipoNao(){	
 
 if(! $_SESSION['login']){
		redirect('login', 'refresh');
  }
	$tipo = '2';
	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$data['perfil'] = $session_data['perfil'];
	$data['estados'] = $this->cnd_obras_model->listarEstado($idContratante,$tipo);
	$data['cidades'] = $this->cnd_obras_model->listarCidade($idContratante,$tipo);
	$data['todas_cei'] = $this->cnd_obras_model->listarCeis($idContratante,$tipo);
	
	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->cnd_obras_model->listarCndTipo($idContratante,$tipo);
	}else{
		
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result = $this->cnd_obras_model->listarCeiByCidade($idContratante,$municipioListar,$tipo);				
			}else if($estadoListar <> '0'){
				$result = $this->cnd_obras_model->listarCeiByEstado($idContratante,$estadoListar,$tipo);				
			}else{
				$result = $this->cnd_obras_model->listarCndTipo($idContratante,$tipo);
			}
		}else{	
			$result = $this->cnd_obras_model->listarCndById($idImovelListar);
			
		}
	
	}
	//print_r($this->db->last_query());exit;
	$data['cnds'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$data['tipo'] = $tipo;
	
	
	if(empty($_SESSION['cidadeCNDOBD'])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION['cidadeCNDOBD'];
	}
	if(empty($_SESSION['estadoCNDOBD'])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] = $_SESSION['estadoCNDOBD'];
	}
	if(empty($_SESSION['idCNDOBD'])){
		$data['idCNDOBD'] = 0;
	}else{
		$data['idCNDOBD'] = $_SESSION['idCNDOBD'];
	}
	$_SESSION['CNDObras'] = 'listarPorTipoNao';
	$data['CNDObras'] = 'listarPorTipoNao';
	$this->load->view('header_pages_view',$data);
    $this->load->view('listrar_cnd_obras_tipo_view', $data);
	$this->load->view('footer_pages_view');
 }


 function listar(){	
 
 if(! $_SESSION['login']){
		redirect('login', 'refresh');
  }
  
	$cidade = '0';
	$estado = '0';
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;
	$data['perfil'] = $session_data['perfil'];
	$data['estados'] = $this->cnd_obras_model->listarEstado($idContratante,'X');
	$data['cidades'] = $this->cnd_obras_model->listarCidade($idContratante,'X');
	$data['todas_cei'] = $this->cnd_obras_model->listarCeis($idContratante,'X');
	$this->load->helper('Paginate_helper');        
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	$session_data =  $_SESSION['login'];
	$result = $this->cnd_obras_model->listarCnd($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado,'X');
	$total = $this->cnd_obras_model->somarTodos($idContratante,0,0);
	$data['paginacao'] = createPaginate('cnd_obras', $total[0]->total) ;
	
	
	$data['cnds'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_cnd_obras_view', $data);
	$this->load->view('footer_pages_view');
 }

  function buscaCidade(){
	  
	$estado = $this->input->get('estado');
	$tipo = $this->input->get('tipo');
	$result = $this->cnd_obras_model->buscarCidade($estado,$tipo);
	$retorno ='';
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
		$retorno .="<option value=0>Escolha</option>";
		foreach($result as $key => $cidade){ 	
			$retorno .="<option value='".$cidade->cidade."'>".$cidade->cidade."</option>";
		}
	}
	echo json_encode($retorno);
  }	
  
    function buscaTodasCeiByEstado(){
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;	
	 $base = $this->config->base_url().'index.php';
	$estado = $this->input->get('estado');
	$tipo = $this->input->get('tipo');
	$result = $this->cnd_obras_model->listarCeiByEstado($idContratante,$estado,$tipo);
	
	$retorno ='';
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno .="<tr><td></td></tr>";
	}else{
		foreach($result as $key => $res){ 	
			if($res->possui_cnd == 1){
				$possui_cnd = "Sim";
				$arrDataVencto = explode("-",$res->data_vencto);
				$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
		
			}else if($res->possui_cnd == 2){
				$possui_cnd = "Não";
				$arrDataVencto = explode("-",$res->data_vencto);
				$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
			}else{
				$possui_cnd = "Pendência";
				$arrDataVencto = explode("-",$res->data_pendencias);
				$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
			}
			if($res->ativo == 1){
				$cor = '#009900';
			}else{
				$cor = '#CC0000';
			}
			
			$retorno .="<tr style='color:$cor;'><td width='10%'> <a href='#'>".$res->imovel."</a></td>";
			$retorno .="<td width='10%'> ".$res->cei."</td>";
			$retorno .="<td width='10%'> ".$possui_cnd."</td>";
			$retorno .="<td width='10%'> ".$dataVencto."</td>";
			$retorno .="<td width='15%'>";            
			if( ($res->possui_cnd <> 3 )) {
				$retorno .="<a href='$base/cnd_obras/upload_cnd?id=$res->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  
			}else{
				$retorno .="<a href='$base/cnd_obras/upload_cnd_pend?id=$res->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  								
			}		
			$retorno .="<a href='$base/cnd_obras/editar?id=$res->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="<a href='$base/cnd_obras/inativar?id=$res->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
			$retorno .="<a href='$base/cnd_obras/ativar?id=$res->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
			$retorno .="</td>";
			$retorno .="</tr>";
		}
	}
	
	echo json_encode($retorno);
  }
  
  function buscaTodasCeiById(){
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;	
	 $base = $this->config->base_url().'index.php';
	$cei = $this->input->get('cei');
	$tipo = $this->input->get('tipo');
	$result = $this->cnd_obras_model->listarCndById($cei);
	
	$retorno ='';
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno .="<tr><td></td></tr>";
	}else{
		foreach($result as $key => $res){ 	
			if($res->possui_cnd == 1){
				$possui_cnd = "Sim";
				$arrDataVencto = explode("-",$res->data_vencto);
				$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
		
			}else if($res->possui_cnd == 2){
				$possui_cnd = "Não";
				$arrDataVencto = explode("-",$res->data_vencto);
				$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
			}else{
				$possui_cnd = "Pendência";
				$arrDataVencto = explode("-",$res->data_pendencias);
				$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
			}
			if($res->ativo == 1){
				$cor = '#009900';
			}else{
				$cor = '#CC0000';
			}
			
			$retorno .="<tr style='color:$cor;'><td width='10%'> <a href='#'>".$res->imovel."</a></td>";
			$retorno .="<td width='10%'> ".$res->cei."</td>";
			$retorno .="<td width='10%'> ".$possui_cnd."</td>";
			$retorno .="<td width='10%'> ".$dataVencto."</td>";
			$retorno .="<td width='15%'>";            
			if( ($res->possui_cnd <> 3 )) {
				$retorno .="<a href='$base/cnd_obras/upload_cnd?id=$res->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  
			}else{
				$retorno .="<a href='$base/cnd_obras/upload_cnd_pend?id=$res->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  								
			}		
			$retorno .="<a href='$base/cnd_obras/editar?id=$res->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="<a href='$base/cnd_obras/inativar?id=$res->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
			$retorno .="<a href='$base/cnd_obras/ativar?id=$res->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
			$retorno .="</td>";
			$retorno .="</tr>";
		}
	}
	
	echo json_encode($retorno);
  }
  
    function buscaTodasCeiByCidade(){
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;	
	 $base = $this->config->base_url().'index.php';
	$cidade = $this->input->get('cidade');
	$tipo = $this->input->get('tipo');
	$result = $this->cnd_obras_model->listarCeiByCidade($idContratante,$cidade,$tipo);
	
	$retorno ='';
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno .="<tr><td></td></tr>";
	}else{
		foreach($result as $key => $res){ 	
			if($res->possui_cnd == 1){
				$possui_cnd = "Sim";
				$arrDataVencto = explode("-",$res->data_vencto);
				$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
				$cor = '';
		
			}else if($res->possui_cnd == 2){
				$possui_cnd = "Não";
				$arrDataVencto = explode("-",$res->data_vencto);
				$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
				$cor = '';
			}else{
				$possui_cnd = "Pendência";
				$arrDataVencto = explode("-",$res->data_pendencias);
				$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
				$cor = '';
			}
			
			if($res->ativo == 1){
				$cor = '#009900';
			}else{
				$cor = '#CC0000';
			}
										
			$retorno .="<tr style='color:$cor;'><td width='10%'> <a href='#'>".$res->imovel."</a></td>";
			$retorno .="<td width='10%'> ".$res->cei."</td>";
			$retorno .="<td width='10%'> ".$possui_cnd."</td>";
			$retorno .="<td width='10%'> ".$dataVencto."</td>";
			$retorno .="<td width='15%'>";            
			if( ($res->possui_cnd <> 3 )) {
				$retorno .="<a href='$base/cnd_obras/upload_cnd?id=$res->id_cnd' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  
			}else{
				$retorno .="<a href='$base/cnd_obras/upload_cnd_pend?id=$res->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  								
			}		
			$retorno .="<a href='$base/cnd_obras/editar?id=$res->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="<a href='$base/cnd_obras/inativar?id=$res->id_cnd' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
			$retorno .="<a href='$base/cnd_obras/ativar?id=$res->id_cnd' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
			$retorno .="</td>";
			$retorno .="</tr>";
		}
	}
	
	echo json_encode($retorno);
  }
  
   function buscaCeiByCidade(){
	   
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$cidade = $this->input->get('cidade');
	$tipo = $this->input->get('tipo');
	$result = $this->cnd_obras_model->listarCeiByCidade($idContratante,$cidade,$tipo);
	$retorno ='';
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
		$retorno .="<option value=0>Escolha</option>";
		foreach($result as $key => $cei){ 	
			$retorno .="<option value='".$cei->id_cnd."'>".$cei->cei."</option>";
		}
	}

	

	echo json_encode($retorno);
	
  }

function buscaCeiByEstado(){
	   
	$session_data =  $_SESSION['login'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$estado = $this->input->get('estado');
	$tipo = $this->input->get('tipo');
	$result = $this->cnd_obras_model->listarCeiByEstado($idContratante,$estado,$tipo);
	$retorno ='';
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
		$retorno .="<option value=0>Escolha</option>";
		foreach($result as $key => $cei){ 	
			$retorno .="<option value='".$cei->id_cnd."'>".$cei->cei."</option>";
		}
	}

	

	echo json_encode($retorno);
	
  }  
  

}

