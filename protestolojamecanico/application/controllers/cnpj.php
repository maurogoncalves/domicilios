<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cnpj extends CI_Controller {
 
 function __construct(){
   parent::__construct();
    $this->load->model('estado_model','',TRUE);
	$this->load->model('cnpj_model','',TRUE);
	$this->load->model('user','',TRUE);
	$this->load->model('contratante','',TRUE);
	$this->load->library('session');
	$this->load->library('form_validation');
	$this->load->helper('url');
    session_start();
  
 }
 
 function index(){
	$this->logado();   
 }
 
  
 function listarCnpjRaiz(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	if(empty($_POST)){
		$data['cnpjs'] = $this->cnpj_model->listarCnpjRaiz($session_data['id_contratante'],0);
	}else{
		$cnpj = $this->input->post('cnpj');
		$data['cnpjs'] = $this->cnpj_model->listarCnpjRaiz($session_data['id_contratante'],$cnpj);
	}
	
	$data['mensagem'] = $this->session->flashdata('mensagem');
	$this->load->view('header_pages_view',$data);
	$this->load->view('cnpj/listar_cnpj_raiz_view', $data);
	$this->load->view('footer_pages_view');
	
  
 }
 
 function listarCnpj(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	if(empty($_POST)){
		$_SESSION['cnpjFiltroCNPJ'] = $_SESSION['cidadeFiltroCNPJ'] =  $_SESSION['estadoFiltroCNPJ'] ='0';
		$data['cnpjs'] = $this->cnpj_model->listarCnpj($session_data['id_contratante'],0,0,0);
		
	}else{
		$_SESSION['estadoFiltroCNPJ'] = $estado = $this->input->post('estado');
		$_SESSION['cidadeFiltroCNPJ'] =  $cidade = $this->input->post('cidade');
		$_SESSION['cnpjFiltroCNPJ'] = $cnpj = $this->input->post('cnpj');
		$data['cnpjs'] = $this->cnpj_model->listarCnpj($session_data['id_contratante'],$estado,$cidade,$cnpj);
	}
	
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('cnpj/listar_cnpj_view', $data);
	$this->load->view('footer_pages_view');
	
  
 }
 
 function listarInscricao(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$data['idCnpj'] = $idCnpj = $this->input->get('idCnpj');
	$data['tipo'] = $tipo = $this->input->get('tipo');
	if($tipo == 2){
		$data['tipoDesc'] = 'Estaduais';
		
	}else{
		$data['tipoDesc'] = 'Mobili&aacute;rias';
	}
	$data['cnpjs'] = $this->cnpj_model->listarInscricao($idCnpj,$tipo);
	$this->load->view('header_pages_view',$data);
	$this->load->view('cnpj/listar_inscricoes_view', $data);
	$this->load->view('footer_pages_view');
	
  
 }
 
  function exportInscricoes(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$data['idCnpj'] = $idCnpj = $this->input->post('cnpjExp');
	$data['tipo'] = $tipo = $this->input->post('tipoExp');
	if($tipo == 1){
		$tipoDesc = 'Estaduais';
		
	}else{
		$tipoDesc = 'Mobili&aacute;rias';
	}
	$result= $this->cnpj_model->listarInscricao($idCnpj,$tipo);
	
	$this->csvInscricao($result,$tipoDesc);
  
 }
 
 function csvInscricao($result,$tipoDesc){
	 
	 $file="cnpjs_inscricoes.xls";

				
		$test="<table border=1>
		<tr>
		<td style='text-align:right!important'>N&uacute;mero de Inscri&ccedil&otilde;es - ".$tipoDesc."</td>
		<td style='text-align:right!important'>Cnpj</td>		
		<td style='text-align:right!important'>CNPJ Raiz</td>
		</tr>
		";
		
		$isArray =  is_array($result) ? '1' : '0';
		if($isArray == 0){
			$test="
			<tr>
			<td>Não Há Dados para exibi&ccedil;&atilde;o</td>		
			</tr>
			";
		}else{			
			  foreach($result as $key => $emitente){ 	
			  
				$test .= "<tr>";
				$test .= "<td style='text-align:right!important'>".utf8_decode($emitente->numero)."</td>";
				$test .= "<td style='text-align:right!important'>".utf8_decode($emitente->cnpj)."</td>";
				$test .= "<td style='text-align:right!important'>".utf8_decode($emitente->cnpj_raiz)."</td>";
				$test .= "</tr>";
				
			}
		}
		$test .='</table>';
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
		
 }
 
  function exportCnpj(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	

	if(empty($_POST)){
		$result = $this->cnpj_model->listarCnpjInscricao($session_data['id_contratante'],0,0,0);
		
	}else{
		$estado = $this->input->post('estado');
		$cidade = $this->input->post('cidade');
		$cnpj = $this->input->post('cnpj');
		$result = $this->cnpj_model->listarCnpjInscricao($session_data['id_contratante'],$estado,$cidade,$cnpj);
	}
	
	
	
	$this->csv($result);
  
 }
 
 
 
 function csv($result){
	 
	 $file="cnpjs_raiz.xls";

				
		$test="<table border=1>
		<tr>
		<td>Id</td>
		<td>CNPJ Raiz</td>		
		<td>CNPJ </td>		
		<td>Cidade</td>
		<td>Estado</td>
		<td>Inscri&ccedil&atilde;o</td>
		<td>Tipo</td>
		</tr>
		";
		
		$isArray =  is_array($result) ? '1' : '0';
		if($isArray == 0){
			$test="
			<tr>
			<td>Não Há Dados para exibi&ccedil;&atilde;o</td>		
			</tr>
			";
		}else{			
			  foreach($result as $key => $emitente){ 	
			  
				$test .= "<tr>";
				$test .= "<td>".utf8_decode($emitente->id)."</td>";
				$test .= "<td>".utf8_decode($emitente->cnpj_raiz)."</td>";
				$test .= "<td>".utf8_decode($emitente->cnpj)."</td>";
				$test .= "<td>".utf8_decode($emitente->cidade)."</td>";
				$test .= "<td>".utf8_decode($emitente->uf)."</td>";
				if(!empty($emitente->numero)){
					$test .= "<td>".utf8_decode($emitente->numero)."</td>";
				}else{
					$test .= "<td></td>";
				}		
				if($emitente->tipo == 1){
					$test .= "<td>Municipal</td>";
				}else{
					$test .= "<td>Estadual</td>";
				}		

				$test .= "</tr>";
				
			}
		}
		$test .='</table>';

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
		
 }	
 
 function cadastrar(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('cnpj/cadastrar_cnpj_raiz_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function editar(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$id = $this->input->get('id');
	$data['cnpj'] = $this->cnpj_model->listarCnpjRaizById($id);
	$this->load->view('header_pages_view',$data);
	$this->load->view('cnpj/editar_cnpj_raiz_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 
 function cadastrarCnpj(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];

	$this->load->view('header_pages_view',$data);
	$this->load->view('cnpj/cadastrar_cnpj_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function editarCnpj(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$id = $this->input->get('id');
	$data['cnpj'] = $this->cnpj_model->listarCnpjById($id);
	
	$this->load->view('header_pages_view',$data);
	$this->load->view('cnpj/editar_cnpj_view', $data);
	$this->load->view('footer_pages_view');
 }
 
 function inserirCnpjRaiz(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
		
	
	$empresa = $this->input->post('empresa');
	$cnpj = $this->input->post('cnpj');
	$id = $this->input->post('id');
	$op = $this->input->post('op');
	
	$dados = array(
		'cnpj_raiz' => $cnpj,
		'empresa' => $empresa,
		'id_contratante' => $idContratante
	);
	
	if($op == 0){
		$dados = $this->cnpj_model->listarCnpjByCnpj($cnpj);
		
		if($dados[0]->total == 0){
			$id = $this->cnpj_model->inserir('cnpj_raiz',$dados);
			$this->session->set_flashdata('mensagem','O cnpj raiz foi inserido');		
		}else{
			$this->session->set_flashdata('mensagem','O cnpj raiz já existe');		
		}
	
		

	}else{
		$this->cnpj_model->atualizar('cnpj_raiz',$dados,$id);
		$this->session->set_flashdata('mensagem','O cnpj raiz foi atualizado');			
	}
	redirect('/cnpj/listarCnpjRaiz');	
	
 }
 
  function inserirInscricao(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
		
	
	$numero = $this->input->post('numero');
	$tipo = $this->input->post('tipo');
	$idCnpj = $this->input->post('idCnpj');
	$op = $this->input->post('op');
	$id = $this->input->post('id');
	
	
	$dados = array(
		'id_cpnj' => $idCnpj,
		'numero' => $numero,
		'tipo' => $tipo,
	);
	
	if($op == 0){
		$id = $this->cnpj_model->inserir('inscricao',$dados);
				
	}else{
		$this->cnpj_model->atualizar('inscricao',$dados,$id);
		
	}
	
	redirect('/cnpj/listarInscricao?idCnpj='.$idCnpj.'&tipo='.$tipo);	
	
 }
  
  function inserirCnpj(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
		
	
	$cnpjRaiz = $this->input->post('cnpj_raiz');
	$bandeira = $this->input->post('bandeira');
	$cnpj = $this->input->post('cnpj');
	$nome = $this->input->post('nome');
	$id = $this->input->post('id');
	$op = $this->input->post('op');
	
	$dados = array(
		'id_cnpj_raiz' => $cnpjRaiz,
		'id_bandeira' => $bandeira,
		'cnpj' => $cnpj,
		'nome' => $nome,
		'id_contratante' => $idContratante
	);
	
	if($op == 0){
		$id = $this->cnpj_model->inserir('cnpj',$dados);

	}else{
		$this->cnpj_model->atualizar('cnpj',$dados,$id);
	}
	redirect('/cnpj/listarCnpj');	
	
 }
 

 
 function listarCnpjJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	echo json_encode($this->cnpj_model->listarCnpjRaiz($session_data['id_contratante'],0));
  
 }
 
 function listarCnpjFilhosJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$cnpjRaiz = $this->input->get('cnpjRaiz');	
	//$estado = $this->input->get('estado');	
	//$cidade = $this->input->get('cidade');	
	echo json_encode($this->cnpj_model->listarCnpjByIdEstCid($cnpjRaiz));
  
 }
 
 function listarEstadoJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$cnpjRaiz = $this->input->get('cnpjRaiz');	
	echo json_encode($this->cnpj_model->listarEstadoByCnpjRaiz($cnpjRaiz));
  
 }
 
  function listarInscricaoJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	$idCnpj = $this->input->get('idCnpj');	
	$tipo = $this->input->get('tipo');	
	echo json_encode($this->cnpj_model->listarInscricao($idCnpj,$tipo));
  
 }
 
 function listarBandeiraJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	echo json_encode($this->cnpj_model->listarBandeira());
  
 }
 
function logado(){	
	if(! $_SESSION['login_walmart']) {	
     redirect('login', 'refresh');
	}			
}  


 
 
}
 
?>