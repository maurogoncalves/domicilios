<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cnd_imob extends CI_Controller {
 function __construct(){
	parent::__construct();
	$this->load->model('cnd_imobiliaria_model','',TRUE);	
	$this->load->model('log_model','',TRUE);
	$this->load->model('cnd_imobiliaria_model','',TRUE);
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

 }
  function index(){


   if($this->session->userdata('logged_in')){

     $session_data = $this->session->userdata('logged_in');

     $data['email'] = $session_data['email'];


	 $data['empresa'] = $session_data['empresa'];


	 $data['perfil'] = $session_data['perfil'];
	 
	 


     $this->load->view('home_view', $data);


   }else{


     //If no session, redirect to login page


     redirect('login', 'refresh');


   }


 }
  function cadastrar(){
 
 if(!$this->session->userdata('logged_in')){
		redirect('login', 'refresh');
  }



	$session_data = $this->session->userdata('logged_in');
	
	$idContratante = $_SESSION['cliente'] ;
	
	$id_iptu = $this->input->get('id');

	$data['inscricao'] = $this->cnd_imobiliaria_model->listarInscricaoByIptu($id_iptu);
	//print_r($this->db->last_query());exit;
	$data['emitentes'] = $this->iptu_model->listarEmitentes($idContratante);
	
	//$data['info_inc'] = $this->informacoes_inclusas_iptu_model->listar();
		
 	$data['perfil'] = $session_data['perfil'];


	$this->load->view('header_view',$data);


    $this->load->view('cadastrar_cnd_imob_view', $data);


	$this->load->view('footer_view');


 }
 function enviar_pend(){
		
		$id = $this->input->post('id');
		
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/cnd_imob_pend/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'.'.$extensao;
		
		$this->load->library('upload', $config);

		// Alternativamente você pode configurar as preferências chamando a função initialize. É útil se você auto-carregar a classe:
		$this->upload->initialize($config);
		$field_name = "userfile";
		
		$dadosArquivo = $this->cnd_imobiliaria_model->listarInscricaoById($id);
		if($dadosArquivo[0]->arquivo_pendencias){
			$b = getcwd();
			//unlink("teste.txt");
			//$this->config->base_url().'assets/cnd_imob_pend/'.$dadosArquivo[0]->arquivo_pendencias;exit;
			$a = @unlink($b.'/assets/cnd_imob_pend/'.$dadosArquivo[0]->arquivo_pendencias);
		}
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			
			$data['mensagem'] = $this->upload->display_errors();exit;
		}else{
			$dados = array('arquivo_pendencias' => $id.'.'.$extensao);
				
			$this->cnd_imobiliaria_model->atualizar($dados,$id);
			$data = array('upload_data' => $this->upload->data($field_name));
			$data['mensagem'] = 'Upload Feito com Sucesso';
			
			
		}
		
		redirect('/cnd_imob/listar', 'refresh');
		
 }
 
 function enviar(){
		
		$id = $this->input->post('id');
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/cnds/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'.'.$extensao;
		
		$this->load->library('upload', $config);

		// Alternativamente você pode configurar as preferências chamando a função initialize. É útil se você auto-carregar a classe:
		$this->upload->initialize($config);
		$field_name = "userfile";
		
		$dadosArquivo = $this->cnd_imobiliaria_model->listarInscricaoById($id);
		if($dadosArquivo[0]->arquivo){
			$b = getcwd();
			//unlink("teste.txt");
			//$this->config->base_url().'assets/cnd_imob_pend/'.$dadosArquivo[0]->arquivo_pendencias;exit;
			$a = @unlink($b.'/assets/cnds/'.$dadosArquivo[0]->arquivo);
		}
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			
			$data['mensagem'] = $this->upload->display_errors();exit;
		}else{
			$dados = array(
			'arquivo' => $id.'.'.$extensao,
			'possui_cnd' => 1
			);
				
			$this->cnd_imobiliaria_model->atualizar($dados,$id);
			$data = array('upload_data' => $this->upload->data($field_name));
			$data['mensagem'] = 'Upload Feito com Sucesso';
			
			
		}
		
		redirect('/cnd_imob/listar', 'refresh');
		
 }
 function upload_cnd(){
	
	
  $session_data = $this->session->userdata('logged_in');	
 
  if(!$this->session->userdata('logged_in')){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  $data['imovel'] = $this->cnd_imobiliaria_model->listarInscricaoById($id);
  
	
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_view',$data);

  $this->load->view('upload_cnd', $data);

  $this->load->view('footer_view');
				
 
 }
 
 function upload_cnd_pend(){
	
	
  $session_data = $this->session->userdata('logged_in');	
 
  if(!$this->session->userdata('logged_in')){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  $data['imovel'] = $this->cnd_imobiliaria_model->listarInscricaoById($id);
  
	
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_view',$data);

  $this->load->view('upload_cnd_pend', $data);

  $this->load->view('footer_view');
				
 
 }
 
 function ver(){
	
	
  $session_data = $this->session->userdata('logged_in');	
 
  if(!$this->session->userdata('logged_in')){
		redirect('login', 'refresh');
  }
  
  $id = $this->input->get('id');
  
  $data['imovel'] = $this->cnd_imobiliaria_model->listarInscricaoById($id);

	
  $data['perfil'] = $session_data['perfil'];

  $this->load->view('header_view',$data);

  $this->load->view('ver-cnd', $data);

  $this->load->view('footer_view');
				
 
 }
 
 

 function cadastrar_cnd_imob(){
 
   if(!$this->session->userdata('logged_in')){
		redirect('login', 'refresh');
  }


	$session_data = $this->session->userdata('logged_in');


	$idContratante = $_SESSION['cliente'] ;

	$possui_cnd = $this->input->post('possui_cnd');	
	

	$id_iptu = $this->input->post('id_iptu');	
	
	$data_vencto = $this->input->post('data_vencto');

	$arrDataVencto = explode("/",$data_vencto);
	
	$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
	
	$observacoes = $this->input->post('observacoes');	
	
	
	if($possui_cnd == 1){

		$dados = array(

			'id_iptu' => $id_iptu,
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,

			'observacoes' => $observacoes,

		);
	}elseif ($possui_cnd == 2){
		$dados = array(
			'id_iptu' => $id_iptu,
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
		);
	
	}else{

	$dados = array(
			'id_iptu' => $id_iptu,
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
		);
	}

    $id = $this->cnd_imobiliaria_model->add($dados);
	if($id){
		echo "<script>alert('Cadastro Feito com sucesso')</script>";
		redirect('/cnd_imob/upload_cnd?id='.$id, 'refresh');
	}else{	
		echo "<script>alert('Algum Erro Aconteceu')</script>";
	}
	



 }

  function excluir(){
	if(!$this->session->userdata('logged_in')){
			redirect('login', 'refresh');
	  }

  
	$id = $this->input->get('id');

	$session_data = $this->session->userdata('logged_in');

	$idContratante = $_SESSION['cliente'] ;


	$dados = array('ativo' => 0);

	if($this->iptu_model->atualizar($dados,$id)) {
//	print_r($this->db->last_query());exit;
		$data['mensagem'] = 'Cadastro Inativo com Sucesso';

	}else{	

		$data['mensagem'] = 'Algum Erro Aconteceu';

	}


	$session_data = $this->session->userdata('logged_in');
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];
	
	
	redirect('/cnd_imob/listar', 'refresh');
	exit;


				

 }
 

 function inativar(){
	if(!$this->session->userdata('logged_in')){
			redirect('login', 'refresh');
	  }
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
  
	$id = $this->input->get('id');

	$dados = array('ativo' => 1);
	$dadosAlterados ='';
	
	$dadosAlterados .= ' - Status Ativo';
	
	//print'-'.$dadosAlterados;exit;
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'cnd_imob',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => $dadosAlterados,
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	
	if($this->cnd_imobiliaria_model->atualizar($dados,$id)) {
//	print_r($this->db->last_query());exit;
	echo "<script>alert('Cadastro Atualizado com sucesso')</script>";
	}else{	
		echo "<script>alert('Algum Erro Aconteceu')</script>";
	}

	redirect('/cnd_imob/listar', 'refresh');
				

 }
 
 function ativar(){
	if(!$this->session->userdata('logged_in')){
			redirect('login', 'refresh');
	  }

	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	
	$id = $this->input->get('id');

	$dados = array('ativo' => 0);

	$dadosAlterados ='';
	
	$dadosAlterados .= ' - Status Inativo';
	
	//print'-'.$dadosAlterados;exit;
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'cnd_imob',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => $dadosAlterados,
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	
	if($this->cnd_imobiliaria_model->atualizar($dados,$id)) {
//	print_r($this->db->last_query());exit;
		echo "<script>alert('Cadastro Atualizado com sucesso')</script>";

	}else{	

		echo "<script>alert('Algum Erro Aconteceu')</script>";
	}

		redirect('/cnd_imob/listar', 'refresh');


				

 }
 

 function atualizar_cnd(){
	if(!$this->session->userdata('logged_in')){
			redirect('login', 'refresh');
	  }

	
	
	$session_data = $this->session->userdata('logged_in');

	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	
	
	$id = $this->input->post('id_cnd');	
	$possui_cnd = $this->input->post('possui_cnd');
	
	$data_vencto = $this->input->post('data_vencto');		
	$arrDataVencto = explode("/",$data_vencto);	
	$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
	
	$observacoes = $this->input->post('observacoes');	
	
	if($possui_cnd == 1){
		$dados = array(
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
		);
	}elseif ($possui_cnd == 2){
		$dados = array(
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_vencto' => $dataVencto,
			'observacoes' => $observacoes,
		);
	
	}else{
	$dados = array(
			'id_contratante' => $idContratante,
			'possui_cnd' => $possui_cnd,
			'ativo' => 0,
			'data_pendencias' => $dataVencto,
			'observacoes' => $observacoes,
		);
	}

	
	$dadosAtuais = $this->cnd_imobiliaria_model->listarCNDById($id);
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
	//print'-'.$dadosAlterados;exit;
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'cnd_imob',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => $dadosAlterados,
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	
	
	$this->cnd_imobiliaria_model->atualizar($dados,$id);
	
	//print_r($this->db->last_query());exit;

	echo "<script>alert('Cadastro Atualizado com sucesso')</script>";
    redirect('/cnd_imob/upload_cnd?id='.$id, 'refresh');






				


 }


 

  function editar(){	
  
  if(!$this->session->userdata('logged_in')){
		redirect('login', 'refresh');
  }



	$id = $this->input->get('id');


	$session_data = $this->session->userdata('logged_in');


	$idContratante = $_SESSION['cliente'] ;


	$result = $this->iptu_model->listarImovelByIdIptu($id);
	
	//print_r($this->db->last_query());exit;
	
	$data['emitentes'] = $this->iptu_model->listarEmitentes($idContratante);
	//$data['inscricoes'] = $this->cnd_imobiliaria_model->listarTodasInscricoes($idContratante);
	$data['imovel'] = $this->cnd_imobiliaria_model->listarInscricaoById($id);
	//print_r($this->db->last_query());exit;

	//print_r($data['imovel']);exit;


	
	
	$data['info_inc'] = $this->informacoes_inclusas_iptu_model->listar();


	$data['perfil'] = $session_data['perfil'];




	$this->load->view('header_view',$data);


    $this->load->view('editar_cnd_imob_view', $data);


	$this->load->view('footer_view');





 }
function export_mun(){	
  
  if(!$this->session->userdata('logged_in')){
		redirect('login', 'refresh');
  }

	$id = $this->input->post('id_mun_export');
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	
	$result = $this->cnd_imobiliaria_model->listarIptuCsvByCidade($id);
	//print_r($this->db->last_query());exit;
	//$result = $this->iptu_model->listarIptuCsv($idContratante);
	
	//print_r($result);exit;
	$file="cnd_imob.xls";

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
			<td>Nome Im&oacute;vel</td>
			<td>Inscri&ccedil;&atilde;o</td>
			<td>Possui CND</td>
			<td>Data Vencimento CND</td>
			<td>Observa&ccedil;&otilde;es da CND</td>
			<td>Area Total</td>
			<td>Area Construida</td>
			<td>Valor</td>
			<td>Informa&ccedil;&otilde;es Inclusas</td>
			<td>Observa&ccedil;&otilde;es</td>
			<td>Nome Propriet&aacute;rio</td>
			<td>Status Prefeitura</td>						
			<td>Ativo</td>
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>					
			
			</tr>
			";
			
			
	 
			  foreach($result as $key => $iptu){ 	
			  
			  $dadosLog = $this->log_model->listarLog($iptu->id,'cnd_imob');				
			  $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
			  
				if($iptu->ativo == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->cnd == 1){									
					$possuiCnd ='Sim, sem Pend&ecirc;ncias';
					$arrDataVencto = explode("-",$iptu->data_vencto);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}elseif($iptu->cnd == 2){
					$possuiCnd ='Sim, com Pend&ecirc;ncias';	
					$arrDataVencto = explode("-",$iptu->data_pendencias);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}else{
					$possuiCnd ='Sem registro de cnd ou pend&ecirc;ncias';
					$dataVencto ='';
				}
					/*
				if($iptu->cnd){									
					if($iptu->cnd == 1){									
						$possuiCnd ='Sim, sem Pend&ecirc;ncias';
						$arrDataVencto = explode("-",$iptu->data_vencto);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}else{
						$possuiCnd ='Sim, com Pend&ecirc;ncias';	
						$arrDataVencto = explode("-",$iptu->data_pendencias);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}
				}else{
					$possuiCnd ='Sem registro de cnd ou pend&ecirc;ncias';
					$dataVencto ='';
				}
				*/
				
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->id)."</td>";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'</td>";
				$test .= "<td>".utf8_decode($possuiCnd)."</td>";
				$test .= "<td>".$dataVencto."</td>";
				$test .= "<td>".utf8_decode($iptu->obs_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->area_total)."</td>";		
				$test .= "<td>".utf8_encode($iptu->area_construida)."</td>";
				$test .= "<td>".utf8_encode($iptu->valor)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->observacoes)."</td>";
				$test .= "<td>".utf8_decode($iptu->razao_social)."</td>";
				$test .= "<td>".utf8_decode($iptu->status_pref)."</td>";
				
				$test .= "<td>".utf8_encode($ativo)."</td>";
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
 
 function export_est(){	
  
  if(!$this->session->userdata('logged_in')){
		redirect('login', 'refresh');
  }

	$id = $this->input->post('id_estado_export');
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	
	$result = $this->cnd_imobiliaria_model->listarIptuCsvByEstado($id);
	//print_r($this->db->last_query());exit;
	//$result = $this->iptu_model->listarIptuCsv($idContratante);
	
	//print_r($result);exit;
	$file="cnd_imob.xls";

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
			<td>Nome Im&oacute;vel</td>
			<td>Inscri&ccedil;&atilde;o</td>
			<td>Possui CND</td>
			<td>Data Vencimento CND</td>
			<td>Observa&ccedil;&otilde;es da CND</td>
			<td>Area Total</td>
			<td>Area Construida</td>
			<td>Valor</td>
			<td>Informa&ccedil;&otilde;es Inclusas</td>
			<td>Observa&ccedil;&otilde;es</td>
			<td>Nome Propriet&aacute;rio</td>
			<td>Status Prefeitura</td>
			<td>Ativo</td>
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>				
			
			
			
			</tr>
			";
			
			
	 
			  foreach($result as $key => $iptu){ 	
			  $dadosLog = $this->log_model->listarLog($iptu->id_iptu,'cnd_imob');
			  
			  $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
			  
				if($iptu->ativo == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->cnd == 1){									
					$possuiCnd ='Sim, sem Pend&ecirc;ncias';
					$arrDataVencto = explode("-",$iptu->data_vencto);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}elseif($iptu->cnd == 2){
					$possuiCnd ='Sim, com Pend&ecirc;ncias';	
					$arrDataVencto = explode("-",$iptu->data_pendencias);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}else{
					$possuiCnd ='Sem registro de cnd ou pend&ecirc;ncias';
					$dataVencto ='';
				}
					/*
				if($iptu->cnd){									
					if($iptu->cnd == 1){									
						$possuiCnd ='Sim, sem Pend&ecirc;ncias';
						$arrDataVencto = explode("-",$iptu->data_vencto);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}else{
						$possuiCnd ='Sim, com Pend&ecirc;ncias';	
						$arrDataVencto = explode("-",$iptu->data_pendencias);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}
				}else{
					$possuiCnd ='Sem registro de cnd ou pend&ecirc;ncias';
					$dataVencto ='';
				}
				*/
				
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->id)."</td>";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'</td>";
				$test .= "<td>".utf8_decode($possuiCnd)."</td>";
				$test .= "<td>".$dataVencto."</td>";
				$test .= "<td>".utf8_decode($iptu->obs_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->area_total)."</td>";		
				$test .= "<td>".utf8_encode($iptu->area_construida)."</td>";
				$test .= "<td>".utf8_encode($iptu->valor)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->observacoes)."</td>";
				$test .= "<td>".utf8_decode($iptu->razao_social)."</td>";
				$test .= "<td>".utf8_decode($iptu->status_pref)."</td>";
				
				$test .= "<td>".utf8_encode($ativo)."</td>";
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
  
  if(!$this->session->userdata('logged_in')){
		redirect('login', 'refresh');
  }

	$id = $this->input->post('id_imovel_export');
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	
	if($id == 0){
		
		$result = $this->cnd_imobiliaria_model->listarIptuCsv($idContratante);
	}else{
		$result = $this->cnd_imobiliaria_model->listarIptuCsvById($id);
	}
	
	//$result = $this->iptu_model->listarIptuCsv($idContratante);
	
	//print_r($result);exit;
	$file="cnd_imob.xls";

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
			<td>Nome Im&oacute;vel</td>
			<td>Inscri&ccedil;&atilde;o</td>
			<td>Possui CND</td>
			<td>Data Vencimento CND</td>
			<td>Observa&ccedil;&otilde;es da CND</td>
			<td>Area Total</td>
			<td>Area Construida</td>
			<td>Valor</td>
			<td>Informa&ccedil;&otilde;es Inclusas</td>
			<td>Observa&ccedil;&otilde;es</td>
			<td>Nome Propriet&aacute;rio</td>
			<td>Status Prefeitura</td>
			<td>Ativo</td>
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>								
			
			
			
			</tr>
			";
			
			
	 
			  foreach($result as $key => $iptu){ 	
			   $dadosLog = $this->log_model->listarLog($iptu->id_cnd,'cnd_imob');
			  
			  $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
				if($iptu->ativo == 0){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				if($iptu->cnd == 1){									
					$possuiCnd ='Sim';
					$arrDataVencto = explode("-",$iptu->data_vencto);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}elseif($iptu->cnd == 2){
					$possuiCnd ='Não';	
					$arrDataVencto = explode("-",$iptu->data_pendencias);
					$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
				}else{
					$possuiCnd ='Pend&ecirc;ncias';
					$dataVencto ='';
				}
					/*
				if($iptu->cnd){									
					if($iptu->cnd == 1){									
						$possuiCnd ='Sim, sem Pend&ecirc;ncias';
						$arrDataVencto = explode("-",$iptu->data_vencto);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}else{
						$possuiCnd ='Sim, com Pend&ecirc;ncias';	
						$arrDataVencto = explode("-",$iptu->data_pendencias);
						$dataVencto = $arrDataVencto[2].'/'.$arrDataVencto[1].'/'.$arrDataVencto[0];
					}
				}else{
					$possuiCnd ='Sem registro de cnd ou pend&ecirc;ncias';
					$dataVencto ='';
				}
				*/
				
				$cor='#fff';
				$test .= "<tr >";
				$test .= "<td>".utf8_decode($iptu->id_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->nome)."</td>";
				$test .= "<td>"."'".utf8_decode($iptu->inscricao)."'</td>";				
				$test .= "<td>".utf8_decode($possuiCnd)."</td>";
				$test .= "<td>".$dataVencto."</td>";
				$test .= "<td>".utf8_decode($iptu->obs_cnd)."</td>";
				$test .= "<td>".utf8_decode($iptu->area_total)."</td>";		
				$test .= "<td>".utf8_encode($iptu->area_construida)."</td>";
				$test .= "<td>".utf8_encode($iptu->valor)."</td>";
				$test .= "<td>".utf8_decode($iptu->descricao)."</td>";
				$test .= "<td>".utf8_decode($iptu->observacoes)."</td>";
				$test .= "<td>".utf8_decode($iptu->razao_social)."</td>";
				$test .= "<td>".utf8_decode($iptu->status_pref)."</td>";
				
				$test .= "<td>".utf8_encode($ativo)."</td>";
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
		//print$test;exit;
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
	
		
 }
 
 function buscaCidade(){	
	$id = $this->input->get('estado');
	
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarCidadeByEstado($id);
	
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value='".$iptu->cidade."'>".$iptu->cidade."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaTodasCidades(){	
	
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarTodasCidades();
	
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value='".$iptu->cidade."'>".$iptu->cidade."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 function buscaInscricaoByEstado(){	
	$id = $this->input->get('id');
	
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarImovelByEstado($id);
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha um Imóvel</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaImovel(){	
	$id = $this->input->get('id');
	
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarImovelByCidade($id);
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha um Imóvel</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function busca(){	
	$id = $this->input->get('id');
	
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarImovelByImovel($id);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	if($iptu->status_inscr == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	 
	if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}
	 
								
	  $base = $this->config->base_url().'index.php';	
	  $retorno .="<tr style='color:$cor'>";
     $retorno .="<td width='30%'><a href='#'>".$iptu->nome."</a></td>";
      $retorno .="<td width='17%'class='hidden-phone'>";
		if(!empty($iptu->arquivo)){
			$retorno .= "<a href='$base/cnd_imob/ver?id=$iptu->id'> $iptu->inscricao</a>";
		}else{	
			$retorno .=$iptu->inscricao;
		}
		$retorno .="</td>";
		$retorno .="<td width='14%'class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%'class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='13%'>";            
		if( ($iptu->possui_cnd == 1 )) {
			$retorno .="<a href='$base/cnd_imob/upload_cnd?id=$iptu->id' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  
		}else{
			$retorno .="<a href='$base/cnd_imob/upload_cnd_pend?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  								
		}		
		$retorno .="<a href='$base/cnd_imob/editar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_imob/inativar?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_imob/ativar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
  function buscaEstado(){	
	$id = $this->input->get('id');
	
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarImovelByUf($id);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='6'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	 if($iptu->status_inscr == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	 
	 
	if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}
									 
	
	 $base = $this->config->base_url().'index.php';
	  $retorno .="<tr style='color:$cor'>";
      $retorno .="<td width='30%'><a href='#'>".$iptu->nome."</a></td>";
      $retorno .="<td width='17%'class='hidden-phone'>";
		if(!empty($iptu->arquivo)){
			$retorno .= "<a href='$base/cnd_imob/ver?id=$iptu->id'> $iptu->inscricao</a>";
		}else{	
			$retorno .=$iptu->inscricao;
		}
		$retorno .="</td>";
		$retorno .="<td width='14%'class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%'class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='13%'>";            
		if( ($iptu->possui_cnd == 1 )) {
			$retorno .="<a href='$base/cnd_imob/upload_cnd?id=$iptu->id' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  
		}else{
			$retorno .="<a href='$base/cnd_imob/upload_cnd_pend?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  								
		}		
		$retorno .="<a href='$base/cnd_imob/editar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_imob/inativar?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_imob/ativar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaMunicipio(){	
	$id = $this->input->get('id');
	
	$retorno ='';
	$result = $this->cnd_imobiliaria_model->listarImovelByMunicipio($id);
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $iptu){ 	
	 
	if($iptu->status_inscr == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	 
	 if($iptu->possui_cnd == 1){
		$possui_cnd ='Sim';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	}elseif($iptu->possui_cnd == 2){
		$possui_cnd ='Não';
		$dataVArr = explode("-",$iptu->data_vencto);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}else{
		$possui_cnd ='Pendência';
		$dataVArr = explode("-",$iptu->data_pendencias);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];	
	}
	 
	

								
	  $base = $this->config->base_url().'index.php';	
	  $retorno .="<tr style='color:$cor'>";
      $retorno .="<td width='30%'><a href='#'>".$iptu->nome."</a></td>";
      $retorno .="<td width='17%'class='hidden-phone'>";
		if(!empty($iptu->arquivo)){
			$retorno .= "<a href='$base/cnd_imob/ver?id=$iptu->id'> $iptu->inscricao</a>";
		}else{	
			$retorno .=$iptu->inscricao;
		}
		$retorno .="</td>";
		$retorno .="<td width='14%'class='hidden-phone'>".$possui_cnd."</td>";			  
		$retorno .="<td width='24%'class='hidden-phone'>".$dataVencto."</td>";			  
		$retorno .="<td width='13%'>";            
		if( ($iptu->possui_cnd == 1 )) {
			$retorno .="<a href='$base/cnd_imob/upload_cnd?id=$iptu->id' class='btn btn-success btn-xs'><i class='fa fa-upload'></i></a>";  
		}else{
			$retorno .="<a href='$base/cnd_imob/upload_cnd_pend?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-upload'></i></a>";  								
		}		
		$retorno .="<a href='$base/cnd_imob/editar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/cnd_imob/inativar?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		$retorno .="<a href='$base/cnd_imob/ativar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		$retorno .="</td>";
		$retorno .="</tr>";
	
	
	 
	}
	
	}
	echo json_encode($retorno);
	
 }
 

 function listar(){	
 
 if(!$this->session->userdata('logged_in')){
		redirect('login', 'refresh');
  }

	$session_data = $this->session->userdata('logged_in');
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	$data['imoveis'] = $this->cnd_imobiliaria_model->listarImovel($idContratante);
	
	$data['estados'] = $this->cnd_imobiliaria_model->listarEstado();
	
	
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $this->session->userdata('logged_in');
	
	$result = $this->cnd_imobiliaria_model->listarCnd($idContratante,numRegister4PagePaginate(), $page);
	
	
	////print_r($this->db->last_query());exit;
	$total = $this->cnd_imobiliaria_model->somarTodos($idContratante);
	$data['paginacao'] = createPaginate('cnd_imob', $total[0]->total) ;

	

	$data['iptus'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->load->view('header_view',$data);

    $this->load->view('listar_cnd_imobiliaria_view', $data);

	$this->load->view('footer_view');
	


 }





}
 ?>
