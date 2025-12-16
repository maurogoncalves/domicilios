<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Mensagem extends CI_Controller {

 

 function __construct(){
   parent::__construct();
   $this->load->model('email_model','',TRUE);
   $this->load->model('estado_model','',TRUE);
   $this->load->model('mensagem_model','',TRUE);		
   $this->load->model('cnpj_model','',TRUE);
   $this->load->model('user','',TRUE);
   $this->load->model('contratante','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->helper('url');
   date_default_timezone_set('America/Sao_Paulo');
	session_start();
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, OPTIONS, POST');
	header('Access-Control-Allow-Headers: origin, x-requested-with,Content-Type, Content-Range, Content-Disposition, Content-Description');
	
}

 

 function index(){
   $this->logado();   
 }

 function cadastrar_mensagem(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$emailRemetente = $session_data['email'] ;
	
	
	$cnpj  = $this->input->post('cnpj'); 
	$numLanc  = $this->input->post('numLanc');  
	$competencia_legis  = $this->input->post('competencia_legis'); 
	$breveRelato  = $this->input->post('breve_relato');
	$dataCiencia  = $this->input->post('data_ciencia');
	$cidade  = $this->input->post('cidade');
	$estado  = $this->input->post('estado');
	
	
	if(!empty($dataCiencia)){
		$dataCienciaArr = explode('/',$dataCiencia);
		$dtCiencia = $dataCienciaArr[2].'-'.$dataCienciaArr[1].'-'.$dataCienciaArr[0];
	}else{		
		$dtCiencia = '1900-01-01';
	}	
	
	$dados = array(
		'id_cnpj' => $cnpj,
		'num_lancamento' => $numLanc,
		'data_ciencia' => $dtCiencia,
		'id_competencia_legis' => $competencia_legis,
		'relato_infracao' => $breveRelato,
		'id_municipio' => $cidade,
		'id_uf' => $estado,
	);		
	$id = $this->mensagem_model->add($dados);
	define('DEST_DIR', './arquivos/mensagem/');
	if (($_FILES['userfile']['name'][0] !== '')){	
		// se o "name" estiver vazio, é porque nenhum arquivo foi enviado e cria uma variável para facilitar
		$arquivos = $_FILES['userfile'];
	 	// total de arquivos enviados
		$total = count($arquivos['name']);
		for ($i = 0; $i < $total; $i++){
			// podemos acessar os dados de cada arquivo desta forma:  $arquivos['name'][$i] - $arquivos['tmp_name'][$i] - $arquivos['size'][$i]  - $arquivos['error'][$i]  - $arquivos['type'][$i] 
			$extensao = str_replace('.','',strrchr($arquivos['name'][$i], '.'));	
			$nomeArq =  $id.'-'.$i.'.'.$extensao;		
			if (!move_uploaded_file($arquivos['tmp_name'][$i], DEST_DIR . '/' . $nomeArq)) {
				echo "Erro ao enviar o arquivo: " . $arquivos['name'][$i];
			}		
			$dadosArq = array(
			'id_notificacao' => $id,
			'arquivo' => $nomeArq		
			);			
			$this->mensagem_model->addArq($dadosArq);			
		}     
	}
	
	$dadosInfracao = $this->mensagem_model->listarNotificacaoById($id);
	
	if($dadosInfracao[0]->id_competencia_legis == 1){
		$dadosInfracao[0]->id_competencia_legis ='Federal';	
	}elseif($dadosInfracao[0]->id_competencia_legis == 2){
		$dadosInfracao[0]->id_competencia_legis ='Estadual';	
	}else{
		$dadosInfracao[0]->id_competencia_legis ='Municipal';	
	}
	$emails = $this->email_model->listarEmailFiscalizacao();
	
	$this->load->library('email');
	$this->email->from('domicilios@bdwebgestora.com.br', 'BD Webdomicilios');
	$this->email->cc($emailRemetente);
	$this->email->cc('domicilios@bdwebgestora.com.br');
	
	foreach($emails as $valor){
	
		$this->email->to('domicilios@bdwebgestora.com.br');
		$this->email->subject('Sistema BD Webdomicilios - Envio de Mensagem' );
				
				
		$texto = '
		<strong>Não responda esse email.</strong> <BR> <hr>
		Entre no sistema e clique nesse link abaixo para acessa o tracking.
		<BR>
		<a href="https://bdwebgestora.com.br/domicilios/smartfit/index.php/mensagem/tracking?id='.$id.'" target="_blank" >https://bdwebgestora.com.br/domicilios/smartfit </a>
		<BR><BR>
		<strong>Dados da Mensagem</strong> <BR> <BR> 
		CNPJ Raiz:'.$dadosInfracao[0]->cnpj_raiz.'
		<BR>
		CNPJ : '.$dadosInfracao[0]->cnpj.'
		<BR>
		Num. Mensagem : '.$dadosInfracao[0]->num_lancamento.'
		<BR>
		Data Ciência : '.$dadosInfracao[0]->data_ciencia_br.'
		<BR>
		Breve Relato : '.$dadosInfracao[0]->relato_infracao.'		
		<BR>
		Competência Legislativa : '.$dadosInfracao[0]->id_competencia_legis.'	
		<hr>
		Atenciosamente, <BR> <BR> <strong>Sistema BD Webdomicilios <br> Apoio Técnico</strong>';
		$html = "<html><body style='font-family:Trebuchet MS'>".$texto."</body></html>";		
	
	 }
	 
	// $this->email->set_mailtype("html");
	// $this->email->set_alt_message($texto);
	// $this->email->message($html);
	// $this->email->send();		
	
	redirect('/mensagem/listar', 'refresh');
 }

function alterar_mensagem(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$id  = $this->input->post('id'); 
	$cnpj  = $this->input->post('cnpj'); 
	$numLanc  = $this->input->post('numLanc');  
	$competencia_legis  = $this->input->post('competencia_legis'); 
	$breveRelato  = $this->input->post('breve_relato');
	$dataCiencia  = $this->input->post('data_ciencia');
	
	$cidade  = $this->input->post('cidade');
	$estado  = $this->input->post('estado');
		
	
	
	if(!empty($dataCiencia)){
		$dataCienciaArr = explode('/',$dataCiencia);
		$dtCiencia = $dataCienciaArr[2].'-'.$dataCienciaArr[1].'-'.$dataCienciaArr[0];
	}else{		
		$dtCiencia = '1900-01-01';
	}	
	
	$dados = array(
		'id_cnpj' => $cnpj,
		'num_lancamento' => $numLanc,
		'data_ciencia' => $dtCiencia,
		'id_competencia_legis' => $competencia_legis,
		'relato_infracao' => $breveRelato,
		'id_municipio' => $cidade,
		'id_uf' => $estado,
	);		
	$id = $this->mensagem_model->atualizar('mensagem',$dados,$id);
	
			
	
	redirect('/mensagem/listar', 'refresh');
 }
 
	function export(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		
		if(empty($_POST)){
			$result = $this->mensagem_model->listarMensagem(0,0,0,0);
		}else{	
			$estado = $this->input->post('estado');
			$cidade = $this->input->post('cidade');
			$cnpjRaiz = $this->input->post('cnpjRaizExp');
			$cnpj = $this->input->post('cnpj');
			$result = $this->mensagem_model->listarMensagem($estado,$cidade,$cnpjRaiz,$cnpj);
		}
	
		$this->csv($result);
	
	}
	
	function csv($result){
	 
	 $file="mensagem.xls";

			
		
		$test="<table border=1>
		<tr>
		<td>Id</td>
		<td>CNPJ Raiz</td>		
		<td>CNPJ</td>
		<td>UF</td>
		<td>Cidade</td>
		<td>Num. Mensagem</td>
		<td>Compet&ecirc;ncia Legislativa</td>
		<td>Data Ci&ecirc;ncia</td>
		<td>Breve Relato</td>
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
				$test .= "<td>".utf8_decode($emitente->uf)."</td>";
				$test .= "<td>".utf8_decode($emitente->cidade)."</td>";
				$test .= "<td>".utf8_decode($emitente->num_lancamento)."</td>";
				$test .= "<td>".utf8_decode($emitente->competencia_legis)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_ciencia_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->relato_infracao)."</td>";
				
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
		$data='';
		$this->load->view('header_pages_view',$data);
		$this->load->view('mensagem/cadastrar_mensagem_view', $data);
		$this->load->view('footer_pages_view');
	}

	function editar(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$id = $this->input->get('id');
		$data['dados'] = $this->mensagem_model->listarNotificacaoById($id);
		
		
		$this->load->view('header_pages_view',$data);
		$this->load->view('mensagem/editar_mensagem_view', $data);
		$this->load->view('footer_pages_view');
	}
	
	function arquivos(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['id'] = $id = $this->input->get('id');
		
		$data['dados'] = $this->mensagem_model->listarArquivoNotificacaoById($id);
		
		
		$this->load->view('header_pages_view',$data);
		$this->load->view('mensagem/arquivos_mensagem_view', $data);
		$this->load->view('footer_pages_view');
	}
	
	function arquivosApp(){	
		$id = $_REQUEST['id'];
		$urlArr=array();
		for($i=0;$i<=4;$i++){
			$filename = './arquivos/mensagem/'.$id.'-'.$i.'.pdf';
			$arq = '/arquivos/mensagem/'.$id.'-'.$i.'.pdf';
			if (file_exists($filename)) {
				$urlArr[$i]['url'] = 'https://bdwebgestora.com.br/domicilios/smartfit/arquivos/mensagem/'.$id.'-'.$i.'.pdf';				
			}else{
				$urlArr[$i]['url'] = '-';
			}
		}	
		echo json_encode($urlArr);
	}
	
	function enviar(){		
		$session_data = $_SESSION['login_walmart'];
		$id = $this->input->get('id');		
		$arquivo = $this->input->get('arquivo');		
		$file = $_FILES["userfile"]["name"];
		$extensao = str_replace('.','',strrchr($file, '.'));						
		$base = base_url();		        
		$config['upload_path'] = './arquivos/mensagem/';			
		$config['allowed_types'] = '*';		
		$config['overwrite'] = 'true';				
		$config['file_name'] = $id.'-'.$arquivo.'.'.$extensao;				
		$this->load->library('upload', $config);	
		$this->upload->initialize($config);		
		$field_name = "userfile";				

		$arq = $this->mensagem_model->listarArquivo($arquivo);
		
		$filename =  './arquivos/mensagem/'.$arq[0]->arquivo ;
		if (file_exists($filename)) {
			@unlink($filename);
		} 
		if (!$this->upload->do_upload($field_name)){			
			$error = array('error' => $this->upload->display_errors());						
			$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
			echo '0'; 
		}else{		
			
			$this->mensagem_model->apagaArquivo($arquivo);	
			
			$dadosArq = array(
			'id_notificacao' => $id,
			'arquivo' => $config['file_name'] 
			);			
			$this->mensagem_model->addArq($dadosArq);			
			
			echo'1';

		}

}
	
 function listarNaturezaJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$emailRemetente = $session_data['email'] ;
	echo json_encode($this->mensagem_model->listarNatureza());
  
 }
 
	function listar(){
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['perfil'] = $session_data['perfil'];		
		if(empty($_POST)){
			$_SESSION['estadoFiltroNot'] = $_SESSION['cidadeFiltroNot'] = $_SESSION['cnpjFiltroNot'] = 0;
			$data['dados'] = $this->mensagem_model->listarMensagem(0,0,0,0);
		}else{
			$_SESSION['estadoFiltroNot'] = $estado = $this->input->post('estado');
			$_SESSION['cidadeFiltroNot'] =$cidade = $this->input->post('cidade');
			$cnpjRaiz = $this->input->post('cnpjRaiz');
			$_SESSION['cnpjFiltroNot'] =$cnpj = $this->input->post('cnpj');
			
			$data['dados'] = $this->mensagem_model->listarMensagem($estado,$cidade,$cnpjRaiz,$cnpj);
		}
		$data['emails'] = $this->email_model->listarEmail(0);
		$this->load->view('header_pages_view',$data);
		$this->load->view('mensagem/listar_mensagem_view', $data);
		$this->load->view('footer_pages_view');
	}
	
	function listarApp(){
		
		$estado = $_REQUEST['estado'];
		$result = $this->mensagem_model->listarNotificacoesApp($estado);
		echo json_encode($result);	
	}
	
	function encaminhar(){
	
	
	date_default_timezone_set('America/Sao_Paulo');	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$emailRemetente = $session_data['email'] ;
	
	$emailEnviar  = $this->input->post('email'); 
	$assunto  = $this->input->post('assunto');
	$idNotif  = $this->input->post('id');
	$completo  = $this->input->post('completo');
	
	
	$contaEmails = count($emailEnviar);
	$i=1;
	$stringEmails = '';
	foreach($emailEnviar as $email){				
		$dados = $this->email_model->listarEmail($email);
		if($i==$contaEmails){
			$stringEmails .= $dados[0]->email;
		}else{
			$stringEmails .= $dados[0]->email.',';	
		}
		$i++;
	}

	
	
	
	
	//$dadosEmail = $this->email_model->listarEmail($emailEnviar);
	
	$dados = array(
		'id_notificacao' => $idNotif,
		'id_email' => $stringEmails,
		'texto' => $assunto,
		'data_envio' => date("Y-m-d H:i:s"),
		);		
	$id = $this->mensagem_model->addEnc($dados);
	
	$stringEmails .= ',domicilioSmartFit@bdservicos.com.br';	
	
	$list = array($stringEmails);

	$nomeArquivoRandomico = strtotime("now");
	
	
	$file = $_FILES["userfile"]["name"];
	
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './arquivos/enc_mensagem/';			
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] =$nomeArquivoRandomico.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";				
	
	
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		
	}else{				
		$dadosArq = array(
		'id_notificacao_enc' => $idNotif,
		'arquivo' => $nomeArquivoRandomico.'.'.$extensao,	
		);			
		$this->mensagem_model->addArqEnc($dadosArq);
		
	}
	
	$dadosInfracao = $this->mensagem_model->listarNotificacaoById($idNotif);

	if($completo == 1){
		$dadosEnc = $this->mensagem_model->listarNotificacaoTrackingById($idNotif);
		$textoEnc ='Histórico de Encaminhamento <BR><BR>';
		
		foreach($dadosEnc as $val){
			$textoEnc .="<span style='font-weight:bold'>Enviado para ".$val->nome." : ".$val->email." ".$val->data_envio_br."</span><BR>";
			$textoEnc .=$val->texto."<BR>";
			$textoEnc .="<BR>";

		}
	}else{
		$textoEnc ='';
	}
	
	if($dadosInfracao[0]->id_competencia_legis == 1){
		$dadosInfracao[0]->id_competencia_legis ='Federal';	
	}elseif($dadosInfracao[0]->id_competencia_legis == 2){
		$dadosInfracao[0]->id_competencia_legis ='Estadual';	
	}else{
		$dadosInfracao[0]->id_competencia_legis ='Municipal';	
	}
	
	
	@$this->load->library('email');
	@$this->email->from('domicilios@bdwebgestora.com.br', 'BD Webdomicilios');
	$emailRemetente = $session_data['email'] ;
	@$this->email->cc($emailRemetente);
	@$this->email->to($list[0]);
	@$this->email->subject('Sistema BD Webdomicilios - Envio de Encaminhamento de Mensagem' );
				
				
		$texto = '
		<strong>Não responda esse email.</strong> <BR> <hr> 
		Entre no sistema e clique nesse link abaixo para acessa o tracking.
		<BR>
		<a href="https://bdwebgestora.com.br/domicilios/smartfit/index.php/notificacao/tracking?id='.$idNotif.'" target="_blank" >https://bdwebgestora.com.br/domicilios/smartfit/</a>
		<BR><BR>
		<strong>Dados da Mensagem</strong> <BR> <BR> 
		CNPJ Raiz:'.$dadosInfracao[0]->cnpj_raiz.'
		<BR>
		CNPJ : '.$dadosInfracao[0]->cnpj.'
		<BR>
		Num. Mensagem : '.$dadosInfracao[0]->num_lancamento.'
		<BR>
		Data Ciência : '.$dadosInfracao[0]->data_ciencia_br.'
		<BR>
		Breve Relato da Mensagem : '.$dadosInfracao[0]->relato_infracao.'
		<BR>
		Competência Legislativa : '.$dadosInfracao[0]->id_competencia_legis.'	
		<BR><BR>
		Nova Mensagem : '.$assunto.'
		<BR><BR>
		'.$textoEnc.'
		<hr>
		
			
		Atenciosamente, <BR> <BR> <strong>Sistema BD Webdomicilios <br> Apoio Técnico</strong>';
		$html = "<html><body style='font-family:Trebuchet MS'>".$texto."</body></html>";
		
		$b = getcwd();
		$caminho = $b.'/arquivos/enc_mensagem/'.$dadosInfracao[0]->arq;
		if($dadosInfracao[0]->arq){
			$this->email->attach($caminho);
		}	
				
		// $this->email->set_mailtype("html");
		// $this->email->set_alt_message($texto);
		// $this->email->message($html);
		// $this->email->send();
	
	
			
	if($completo == 1){
		redirect('/mensagem/tracking?id='.$idNotif, 'refresh');
	}else{
		redirect('/mensagem/listar', 'refresh');
	}
	
 }
function verDadosNotificacao(){
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['perfil'] = $session_data['perfil'];
	
		$id = $this->input->get('id');	
		echo json_encode($this->mensagem_model->listarNotificacaoById($id));
  
	}
	
function tracking(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['id'] = $id = $this->input->get('id');
		
		$data['dados'] = $this->mensagem_model->listarNotificacaoTrackingById($id);
		$data['emails'] = $this->email_model->listarEmail(0);
		$this->load->view('header_pages_view',$data);
		$this->load->view('mensagem/tracking_view', $data);
		$this->load->view('footer_pages_view');
	}
	
	function trackingApp(){	
		$id = $_REQUEST['id'];
		
		$result = $this->mensagem_model->listarNotificacaoTrackingById($id);
		
		echo json_encode($result);
		
		
	}
	
	function logado(){	
		if(! $_SESSION['login_walmart']) {	
		 redirect('login', 'refresh');
		}			
	}  

}

 

?>