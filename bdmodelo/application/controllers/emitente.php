<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Emitente extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('log_model','',TRUE);
   $this->load->model('tipo_emitente_model','',TRUE);
   $this->load->model('user','',TRUE);
   $this->load->model('contratante','',TRUE);
   $this->load->model('emitente_model','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->helper('url');
   $this->db->cache_on();
   session_start();
   
  
 }
 
 function index()
 {
   if($this->session->userdata('logged_in'))
   {
	
     $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
	 
     $this->load->view('home_view', $data);
   }
   else
   {
     redirect('login', 'refresh');
   }
 }
 
 function cadastrar(){
	$session_data = $_SESSION['login_walmart'];
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	$result = $this->tipo_emitente_model->listarTipoEmitente();
	$data['tipo_emitentes'] = $result;
 	$data['perfil'] = $session_data['perfil'];
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('cadastrar_emitente_view', $data);
	$this->load->view('footer_pages_view');

 }
 
 function ativar(){
 
	$id = $this->input->get('id');
	
	if($this->emitente_model->ativar($id)) {
		$_SESSION['mensagemEmitente'] =  CADASTRO_ATIVO;
	}else{	
		$_SESSION['mensagemEmitente'] =  ERRO;
	}
	
	redirect('/emitente/listar', 'refresh');
	
 }
 
 function excluir(){
 
	$id = $this->input->get('id');
	$session_data = $_SESSION['login_walmart'];
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	
	if($podeExcluir[0]['total'] == 1){
		$this->user->excluirFisicamente($id,'emitente');
		$_SESSION['mensagemEmitente'] =  CADASTRO_INATIVO;
		
	}else{
		if($this->emitente_model->excluir($id)) {
			$_SESSION['mensagemEmitente'] = 'Emitente foi inativado';		
		}else{	
			$_SESSION['mensagemEmitente'] = ERRO;		

		}
	}	
	
	redirect('/emitente/listar', 'refresh');
	
 }
 function cadastrar_emitente(){

	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$razaoSocial = $this->input->post('razaoSocial');	
	$nomeFantasia = $this->input->post('nomeFantasia');	
	$tipoPessoa = $this->input->post('tipoPessoa');	
	$tipoPessoa = $this->input->post('tipoPessoa');	
	$matrizFilial = $this->input->post('matrizFilial');	
	if($tipoPessoa == 1){
		$cpfCnpj = $this->input->post('cpf');	
	}else{
		$cpfCnpj = $this->input->post('cnpj');	
	}	
	$tipoEmitente = $this->input->post('tipoEmitente');	
	
	if($tipoEmitente == 0){
		echo "<script>alert('Escolha um emitente'); window.history.go(-1);</script>";
		exit;
	}
	
	$tel = $this->input->post('tel');	
	$cel = $this->input->post('cel');	
	$nomeResp = $this->input->post('nomeResp');	
	$emailResp = $this->input->post('emailResp');	
	
	if($cpfCnpj){
		$temCnpj = $this->emitente_model->verificarCnpjCpf($idContratante,$cpfCnpj);
	
		if($temCnpj[0]->total <> 0){
			echo "<script>alert('CPF/CNPJ já existe'); window.history.go(-1);</script>";
			exit;
		}
	}
	
	$dados = array('id_contratante' => $idContratante,
					'razao_social' => $razaoSocial,
					'nome_fantasia' => $nomeFantasia,
					'tipo_pessoa' => $tipoPessoa,
					'tipo_emitente' => $tipoEmitente,
					'cpf_cnpj' => $cpfCnpj,
					'telefone' => $tel,
					'celular' => $cel,
					'nome_resp' => $nomeResp,
					'email_resp' => $emailResp,
					'matriz_filial' =>  $matrizFilial
				);
	if($this->emitente_model->add($dados)) {
		$this->session->set_flashdata('mensagem','Cadastro Realizado com Sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}
	
	redirect('/emitente/listar', 'refresh');
				
 }
 
 function atualizar_emitente(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	
	$id = $this->input->post('id');
	$razaoSocial = $this->input->post('razaoSocial');	
	$nomeFantasia = $this->input->post('nomeFantasia');	
	$tipoPessoa = $this->input->post('tipoPessoa');	
	$tipoEmitente = $this->input->post('tipoEmitente');	
	if($tipoPessoa == 1){
		$cpfCnpj = $this->input->post('cpf');	
	}else{
		$cpfCnpj = $this->input->post('cnpj');	
	}	
	$tipoEmitente = $this->input->post('tipoEmitente');	
	$matrizFilial = $this->input->post('matrizFilial');	
	$tel = $this->input->post('tel');	
	$cel = $this->input->post('cel');	
	$nomeResp = $this->input->post('nomeResp');	
	$emailResp = $this->input->post('emailResp');	
	
	
	
	$dados = array('id_contratante' => $idContratante,
					'razao_social' => $razaoSocial,
					'nome_fantasia' => $nomeFantasia,
					'tipo_pessoa' => $tipoPessoa,
					'tipo_emitente' => $tipoEmitente,
					'cpf_cnpj' => $cpfCnpj,
					'telefone' => $tel,
					'celular' => $cel,
					'nome_resp' => $nomeResp,
					'email_resp' => $emailResp,
					'matriz_filial' => $matrizFilial,
					'ativo' => 1
	);
	
	$dadosAlterados = '';
	$dadosAtuais = $this->emitente_model->listarEmitenteById($idContratante,$id);
	$tipos = $this->emitente_model->listarTipoEmitenteById($dadosAtuais[0]->tipo_emitente);
	
	
	
	if($dadosAtuais[0]->razao_social <> $razaoSocial){
		$dadosAlterados .= ' - Nome Fantasia: '.$dadosAtuais[0]->razao_social;
	}
	if($dadosAtuais[0]->nome_fantasia <> $nomeFantasia){
		$dadosAlterados .= ' - Nome Fantasia: '.$dadosAtuais[0]->nome_fantasia;
	}
	if($dadosAtuais[0]->tipo_pessoa <> $tipoPessoa){
		if($tipoPessoa == 1){
			$dadosAlterados .= ' - Tipo de Pessoa: Juridica';
		}else{
			$dadosAlterados .= ' - Tipo de Pessoa: Fisica';
		}
	}
	if($dadosAtuais[0]->tipo_emitente <> $tipoEmitente){
		$dadosAlterados .= ' - Tipo de Emitente: '.$tipos[0]->descricao;
	}
	if($dadosAtuais[0]->cpf_cnpj <> $cpfCnpj){
		$dadosAlterados .= ' - CPF/CNPJ: '.$dadosAtuais[0]->cpf_cnpj;
	}
	if($dadosAtuais[0]->telefone <> $tel){
		$dadosAlterados .= ' - Telefone: '.$dadosAtuais[0]->telefone;
	}
	if($dadosAtuais[0]->celular <> $cel){
		$dadosAlterados .= ' - Celular: '.$dadosAtuais[0]->celular;
	}
	if($dadosAtuais[0]->nome_resp <> $nomeResp){
		$dadosAlterados .= ' - Nome Responsável: '.$dadosAtuais[0]->nome_resp;
	}
	if($dadosAtuais[0]->email_resp <> $emailResp){
		$dadosAlterados .= ' - Email Responsável: '.$dadosAtuais[0]->email_resp;
	}
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'emitente',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => utf8_encode($dadosAlterados),
	'data' => date("Y-m-d h:s"),
	);
	
	$this->log_model->log($dadosLog);
					
	
	if($this->emitente_model->atualizar($dados,$id)) {
		
		$_SESSION['mensagemEmitente'] =  'Cadastro Atualizado com Sucesso';
	}else{	
		$_SESSION['mensagemEmitente'] =  ERRO;
	}
	
	redirect('/emitente/listar', 'refresh');
	
				
 }
 
  function editar(){	
	$id = $this->input->get('id');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$result = $this->emitente_model->listarEmitenteById($idContratante,$id);
	
	$data['emitentes'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$result = $this->tipo_emitente_model->listarTipoEmitente();
	$data['tipo_emitentes'] = $result;
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('editar_emitente_view', $data);
	$this->load->view('footer_pages_view');
		
	
 
 }
 
 function buscaEmitenteById(){	
	$id = $this->input->get('id');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$result = $this->emitente_model->listarUmEmitente($idContratante,$id);
	$retorno = '';
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='6'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
		foreach($result as $key => $iptu){ 	
		 
		if($iptu->ativo == 1){
			$status ='Sim';
			$cor = '#009900';
		 }else{
			$status ='N&atilde;o';
			$cor = '#CC0000';
		 }
		$corCelula = $iptu->cor;
		$base = $this->config->base_url().'index.php';	
		$retorno .="<tr >";
		$retorno .="<td width='30%'><a href='#'>".$iptu->razao_social."</a></td>";
		$retorno .="<td width='25%'>$iptu->nome_fantasia</td>";
		$retorno .="<td width='20%'> <span style='font-weight:bold' class='label label-$iptu->cor label-mini'>$iptu->descricao</span></td>";
		
		$retorno .="<td width='10%'>".$status."</td>";
		
		$retorno .="<td width='15%'><a href='$base/emitente/ativar?id=$iptu->id' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
		$retorno .="<a href='$base/emitente/editar?id=$iptu->id' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		$retorno .="<a href='$base/emitente/excluir?id=$iptu->id' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";
		
		$retorno .="</td>";
		$retorno .="</tr>";
		
		
		 
		}
	
	}
	echo json_encode($retorno);
	
	
 
 }
 function export(){	
		
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
					
	$result = $this->emitente_model->listarEmitenteCsv($idContratante);
	
	$file="emitente.xls";

				
		$test="<table border=1>
		<tr>
		<td>Id</td>
		<td>Razão Social</td>
		<td>Nome Fantasia</td>
		<td>Tipo de Emitente</td>
		<td>Tipo</td>
		<td>Documento</td>
		<td>Telefone</td>
		<td>Celular</td>
		<td>Responsável</td>
		<td>Email Responsável</td>
		<td>Ativo</td>
		<td>Alterado Por </td>
		<td>Data Altera&ccedil;&atilde;o </td>
		<td>Dados Alterados </td>		
		</tr>
		";
		
 
		  foreach($result as $key => $emitente){ 
			$dadosLog = $this->log_model->listarLog($emitente->id,'emitente');				
		    $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
			if($emitente->tipo_pessoa == 1){
				$tipoPessoa='Pessoa Física';
			}else if($emitente->tipo_pessoa == 2){
				$tipoPessoa='Pessoa Jurídica';
			}else{
				$tipoPessoa='Departamento Interno';
			}
			if($emitente->ativo == 1){
				$ativo='Ativo';
			}else{
				$ativo='Inativo';
			}
			
			$test .= "<tr>";
			$test .= "<td>".utf8_decode($emitente->id)."</td>";
			$test .= "<td>".utf8_decode($emitente->razao_social)."</td>";
			$test .= "<td>".utf8_decode($emitente->nome_fantasia)."</td>";
			$test .= "<td>".utf8_decode($emitente->descricao)."</td>";
			$test .= "<td>".($tipoPessoa)."</td>";
			if($emitente->tipo_pessoa == 3){			
				$test .= "<td></td>";
			}else{
				$test .= "<td>".utf8_encode($emitente->cpf_cnpj)."</td>";
			}
			$test .= "<td>".utf8_encode($emitente->telefone)."</td>";
			$test .= "<td>".utf8_encode($emitente->celular)."</td>";
			$test .= "<td>".utf8_decode($emitente->nome_resp)."</td>";
			$test .= "<td>".utf8_encode($emitente->email_resp)."</td>";
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
		//echo $test;	exit;
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
	
		
 }
 function listar(){	
 
	
	if( $_SESSION['login_walmart']) {
	   
     $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	 
		$this->load->helper('Paginate_helper');        
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			
		
		$idContratante = $_SESSION['cliente'];
		
							
		//$data['emits'] = $this->emitente_model->listarEmitentes($idContratante);
		
		
		$data['emitentes'] = $this->emitente_model->listarEmitente($idContratante);
		$total = $this->emitente_model->somarTodos($idContratante);
		
		 
		$data['perfil'] = $session_data['perfil'];
		if($this->uri->segment(1)){
			$data['ativo'] ='Emitente';
		}
		if(empty($_SESSION['mensagemEmitente'])){
			$data['mensagemEmitente'] = '';			
		}else{
			$data['mensagemEmitente'] = $_SESSION['mensagemEmitente'];
		}
	 
	 
		$this->load->view('header_pages_view',$data);
		$this->load->view('listar_emitente_view', $data);
		$this->load->view('footer_pages_view');
	}else{
		 redirect('login', 'refresh');
	}
	
	
 
 }
 
 function contaCpf(){
	$cpf = $this->input->get('cpf');	
	$result = $this->emitente_model->verificaCPF($cpf,1);
	$total = $result[0]->total;
	if($total == 0){
		$valido = $this->validaCpf($cpf);
		echo json_encode($valido);
	}else{
		echo json_encode($total); 
	}	
 
 }
 function contaCnpj(){
	$cnpj = $this->input->get('cnpj');	
	$result = $this->emitente_model->verificaCPF($cnpj,2);
	$total = $result[0]->total;
	echo json_encode($total);
		
 
 }
 
  function contaEmail(){
	$email = $this->input->get('email');	
	$result = $this->emitente_model->verificaEmail($email);
	$total = $result[0]->total;
	echo json_encode($total);
		
 
 }
 
 function validaCnpj($cnpj){
		$cnpj = str_pad(str_replace(array('.','-','/'),'',$cnpj),14,'0',STR_PAD_LEFT);
		if (strlen($cnpj) != 14){
			return false;
		} else {
			for($t = 12; $t < 14; $t++){
				for($d = 0, $p = $t - 7, $c = 0; $c < $t; $c++){
					$d += $cnpj{$c} * $p;
					$p  = ($p < 3) ? 9 : --$p;
				}
				$d = ((10 * $d) % 11) % 10;
				if($cnpj{$c} != $d){
					return false;
				}
			}
			return true;
		}
	}
	
 function validaCpf($cpf) {
 
		if(empty($cpf)) {
			return false;
		}
		
		$cpf = preg_replace('/[^0-9]/', '', $cpf);
		
		
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		if (strlen($cpf) != 11) {
			return 1;
		}else if (
			$cpf == '00000000000' || $cpf == '11111111111' ||
			$cpf == '22222222222' || $cpf == '33333333333' ||
			$cpf == '44444444444' || $cpf == '55555555555' ||
			$cpf == '66666666666' || $cpf == '77777777777' ||
			$cpf == '88888888888' || $cpf == '99999999999' ||

			$cpf == '40404040411' || $cpf == '80808080822'

		){
			return 1;
		} else {
			for ($t = 9; $t < 11; $t++) {
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return 1;
				}
			}
			return 0;
		}
	}
 
}
?>