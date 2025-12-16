<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consulta extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	  function __construct(){
	parent::__construct();
    $this->load->model('emitente_imovel_model','',TRUE);
	$this->load->model('loja_model','',TRUE);
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

 
	public function index(){

		
	}
	public function loja(){
	
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	if ($this->uri->segment(3) === FALSE){
		$cpf_cnpj = 0;
	}else{
		$cpf_cnpj_parte1 = $this->uri->segment(3);
		$cpf_cnpj_parte2 = $this->uri->segment(4);
	}
		if($cpf_cnpj_parte2){
			$cpf_cnpj = $cpf_cnpj_parte1.'/'.$cpf_cnpj_parte2;
		}else{
			$cpf_cnpj = $cpf_cnpj_parte1;
		}
		
		$result = $this->emitente_model->verificaCPF($cpf_cnpj,0);
		$total = $result[0]->total;
		
		
		if($total == 0){
			
			print"Esse CPF/CNPJ não existe";
		}else{
			$result = $this->emitente_model->listarEmitenteCsvByCPFCNPJ($cpf_cnpj);
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
			//$dadosLog = $this->emitente_model->listarLog($emitente->id);
			$dadosLog = $this->log_model->listarLog($emitente->id,'emitente');				
		    $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
			if($emitente->tipo_pessoa == 1){
				$tipoPessoa='Pessoa Física';
			}else{
				$tipoPessoa='Pessoa Jurídica';
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
			$test .= "<td>".utf8_encode($emitente->cpf_cnpj)."</td>";

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
		$result = $this->loja_model->listarLojaCsvByEmitente($emitente->id_contratante,$emitente->id);
		
		$isArray =  is_array($result) ? '1' : '0';
		if($isArray == 0){
		
		$test.="<table border=1>
		<tr>
		<td colspan='21'>Não Há Dados de CND Mobiliaria</td>
		</tr>
		";
		
		
		}else{
		$test.="<table border=1>
		<tr>
		<td>Id</td>
		<td>Razão Social</td>
		<td>CPF/CNPJ</td>
		<td>N&uacute;mero Inscri&ccedil;&atildeo</td>	
		<td>Regional</td>
		<td>Cód 1</td>
		<td>Cód 2</td>
		<td>Centro de Custo</td>
		<td>Bandeira</td>
		<td>Tipo de Emitente</td>
		<td>CND Mobili&aacute;ria</td>
		<td>CEP</td>
		<td>N&uacute;mero</td>
		<td>Endere&ccedil;o</td>
		<td>Bairro</td>
		<td>Cidade</td>
		<td>Estado</td>
		<td>Status</td>
		<td>Alterado Por </td>
		<td>Data Altera&ccedil;&atilde;o </td>
		<td>Dados Alterados </td>	
		</tr>
		";
		
 
		  foreach($result as $key => $emitente){ 	
		  $dadosLog = $this->log_model->listarLog($emitente->id,'loja');				
		  $isArrayLog =  is_array($dadosLog) ? '1' : '0';

			if($emitente->ativo == 1){
				$ativo='Ativo';
			}else{
				$ativo='Inativo';
			}
			
			if($emitente->possui_cnd){
				if($emitente->possui_cnd == 1){
					$possui= 'Sim'; 
					//echo strlen($emitente->ins_cnd_mob); // 6
				}else{
					$possui='Pend&ecirc;ncia';
				}	
			}else{
				$possui='N&atilde;o Possui CND ou Pend&ecirc;ncia';
			}
			
			$test .= "<tr>";
			$test .= "<td>".utf8_decode($emitente->id_loja)."</td>";
			$test .= "<td>".utf8_decode($emitente->nome)."</td>";
			$test .= "<td>".utf8_decode($emitente->cpf_cnpj)."</td>";
			$test .= "<td>"."'".$emitente->ins_cnd_mob."'"."</td>";
			
			$test .= "<td>".utf8_decode($emitente->regional)."</td>";
			$test .= "<td>".utf8_decode($emitente->cod1)."</td>";
			$test .= "<td>"."'".utf8_decode($emitente->cod2)."'"."</td>";
			$test .= "<td>".utf8_decode($emitente->cc)."</td>";
			$test .= "<td>".utf8_decode($emitente->descricao_bandeira)."</td>";
			$test .= "<td>".utf8_decode($emitente->descricao)."</td>";
			
			$test .= "<td>".utf8_decode($possui)."</td>";
			$test .= "<td>".utf8_decode($emitente->cep)."</td>";
			$test .= "<td>".utf8_decode($emitente->numero)."</td>";			
			$test .= "<td>".utf8_decode($emitente->endereco)."</td>";
			$test .= "<td>".utf8_decode($emitente->bairro)."</td>";
			$test .= "<td>".utf8_decode($emitente->cidade)."</td>";
			$test .= "<td>".utf8_decode($emitente->estado)."</td>";
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
		
		//echo $test;	exit;
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
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
//START: Adicionando dois casos notorios de cpf invalidos
			$cpf == '40404040411' || $cpf == '80808080822'
//END
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

}
