<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Notificacao extends CI_Controller {

 

 function __construct(){
   parent::__construct();
   $this->load->model('email_model','',TRUE);
   $this->load->model('estado_model','',TRUE);
   $this->load->model('notificacao_model','',TRUE);		
   $this->load->model('cnpj_model','',TRUE);
   $this->load->model('user','',TRUE);
   $this->load->model('contratante','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->library('Auxiliador');
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

 function cadastrar_notificacao(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$emailRemetente = $session_data['email'] ;
	$cnpj  = $this->input->post('cnpj'); 
	$ie  = $this->input->post('ie');
	$im  = $this->input->post('im');
	$st  = $this->input->post('st');
	$numLanc  = $this->input->post('numLanc');  
	$numProcAdm  = $this->input->post('numProcAdm');  
	$natureza  = $this->input->post('natureza'); 
	$competencia_legis  = $this->input->post('competencia_legis'); 
	$breveRelato  = $this->input->post('breve_relato');
	$dataCiencia  = $this->input->post('data_ciencia');
	$prazo  = $this->input->post('prazo');
	
	$fonte  = utf8_encode($this->input->post('fonte'));
	$dataPostagemOrgao  = $this->input->post('data_postagem_orgao');
	$dataCapturaSistema  = $this->input->post('data_captura_sistema');
	
	$estado  = $this->input->post('estado');
	$cidade = $this->input->post('cidade');
	
	
	
	if(!empty($dataCiencia)){
		$dataCienciaArr = explode('/',$dataCiencia);
		$dtCiencia = $dataCienciaArr[2].'-'.$dataCienciaArr[1].'-'.$dataCienciaArr[0];
	}else{		
		$dtCiencia = '1900-01-01';
	}	
	if(!empty($prazo)){
		$prazoArr = explode('/',$prazo);
		$dtPrazo = $prazoArr[2].'-'.$prazoArr[1].'-'.$prazoArr[0];
	}else{		
		$dtPrazo = '1900-01-01';
	}	
	
	if(!empty($dataPostagemOrgao)){
		$prazoArr = explode('/',$dataPostagemOrgao);
		$dataPostagemOrgao = $prazoArr[2].'-'.$prazoArr[1].'-'.$prazoArr[0];
	}else{		
		$dataPostagemOrgao = '1900-01-01';
	}	
	
	if(!empty($dataCapturaSistema)){
		$prazoArr = explode('/',$dataCapturaSistema);
		$dataCapturaSistema = $prazoArr[2].'-'.$prazoArr[1].'-'.$prazoArr[0];
	}else{		
		$dataCapturaSistema = '1900-01-01';
	}	
	
	if(empty($ie)){
		$ie = 0;	
	}
	
	if(empty($im)){
		$im = 0;	
	}
	if(empty($st)){
		$st = 0;	
	}
	
	$dados = array(
		'id_cnpj' => $cnpj,
		'id_ie' => $ie,
		'id_im' => $im,
		'id_st' => $st,
		'id_uf' => $estado,
		'id_municipio' => $cidade,
		'num_lancamento' => $numLanc,
		'num_processo' => $numProcAdm,
		'data_ciencia' => $dtCiencia,
		'prazo' =>  $dtPrazo,
		'id_natureza' => $natureza,
		'id_competencia_legis' => $competencia_legis,
		'relato_infracao' => $breveRelato,
		'fonte' => $fonte,
		'data_postagem_orgao' => $dataPostagemOrgao,
		'data_captura_sistema' => $dataCapturaSistema,
	);		
	
	$id = $this->notificacao_model->add($dados);
	
	define('DEST_DIR', './arquivos/notificacoes/');
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
			$this->notificacao_model->addArq($dadosArq);			
		}     
	}
	
	$dadosInfracao = $this->notificacao_model->listarNotificacaoById($id);
	
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
	$this->email->subject('Sistema BD Webdomicilios - Envio de Notificação' );
			
	if($dadosInfracao[0]->prazo_br ==  '01/01/1900'){
		$dadosInfracao[0]->prazo_br = ''; 
	}
	
	if($dadosInfracao[0]->data_ciencia_br ==  '01/01/1900'){
		$dadosInfracao[0]->data_ciencia_br = ''; 
	}
	
	$texto = '
	<strong>Não responda esse email.</strong> <BR> <hr>
	Entre no sistema e clique nesse link abaixo para acessa o tracking.
	<BR>
	<a href="https://bdwebgestora.com.br/domicilios/lojamecanico/index.php/notificacao/tracking?id='.$id.'" target="_blank" >https://bdwebgestora.com.br/domicilios/lojamecanico </a>
	<BR><BR>
	<strong>Dados da Notificação</strong> <BR> <BR> 
	CNPJ Raiz:'.$dadosInfracao[0]->cnpj_raiz.'
	<BR>
	CNPJ : '.$dadosInfracao[0]->cnpj.'
	<BR>
	Inscrição Estadual : '.$dadosInfracao[0]->num_ie.'
	<BR>
	Inscrição Mobiliária : '.$dadosInfracao[0]->num_im.'
	<BR>
	Num. Lançamento ou Débito : '.$dadosInfracao[0]->num_lancamento.'
	<BR>
	Num. Processo : '.$dadosInfracao[0]->num_processo.'
	<BR>
	Data Ciência : '.$dadosInfracao[0]->data_ciencia_br.'
	<BR>
	Prazo : '.$dadosInfracao[0]->prazo_br.'
	<BR>
	Breve Relato da Infração : '.$dadosInfracao[0]->relato_infracao.'		
	<BR>
	Competência Legislativa : '.$dadosInfracao[0]->id_competencia_legis.'	
	<hr>
	Atenciosamente, <BR> <BR> <strong>Sistema BD Webdomicilios <br> Apoio Técnico</strong>';
	$html = "<html><body style='font-family:Trebuchet MS'>".$texto."</body></html>";
	
	
	 }
	 
	
	$this->email->set_mailtype("html");
	$this->email->set_alt_message($texto);
	$this->email->message($html);
	$this->email->send();		
	
	redirect('/notificacao/listar', 'refresh');
 }

function alterar_notificacao(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$id  = $this->input->post('id'); 
	$cnpj  = $this->input->post('cnpj'); 
	$ie  = $this->input->post('ie');
	$im  = $this->input->post('im');
	$numLanc  = $this->input->post('numLanc');  
	$numProcAdm  = $this->input->post('numProcAdm');  
	$natureza  = $this->input->post('natureza');  
	$competencia_legis  = $this->input->post('competencia_legis'); 
	$breveRelato  = $this->input->post('breve_relato');
	$dataCiencia  = $this->input->post('data_ciencia');
	$prazo  = $this->input->post('prazo');
	
	$id_uf  = $this->input->post('estado');
	$id_municipio  = $this->input->post('cidade');
	
	$fonte  = utf8_encode($this->input->post('fonte'));
	$dataPostagemOrgao  = $this->input->post('data_postagem_orgao');
	$dataCapturaSistema  = $this->input->post('data_captura_sistema');
	
	if(!empty($dataPostagemOrgao)){
		$prazoArr = explode('/',$dataPostagemOrgao);
		$dataPostagemOrgao = $prazoArr[2].'-'.$prazoArr[1].'-'.$prazoArr[0];
	}else{		
		$dataPostagemOrgao = '1900-01-01';
	}	
	
	if(!empty($dataCapturaSistema)){
		$prazoArr = explode('/',$dataCapturaSistema);
		$dataCapturaSistema = $prazoArr[2].'-'.$prazoArr[1].'-'.$prazoArr[0];
	}else{		
		$dataCapturaSistema = '1900-01-01';
	}	
	
	
	
	if(!empty($dataCiencia)){
		$dataCienciaArr = explode('/',$dataCiencia);
		$dtCiencia = $dataCienciaArr[2].'-'.$dataCienciaArr[1].'-'.$dataCienciaArr[0];
	}else{		
		$dtCiencia = '1900-01-01';
	}	
	if(!empty($prazo)){
		$prazoArr = explode('/',$prazo);
		$dtPrazo = $prazoArr[2].'-'.$prazoArr[1].'-'.$prazoArr[0];
	}else{		
		$dtPrazo = '1900-01-01';
	}	

	if(empty($ie)){
		$ie = 0;	
	}
	
	if(empty($im)){
		$im = 0;	
	}
	
	$dados = array(
		'id_cnpj' => $cnpj,
		'id_uf' => $id_uf,
		'id_municipio' => $id_municipio,
		'id_ie' => $ie,
		'id_im' => $im,
		'num_lancamento' => $numLanc,
		'num_processo' => $numProcAdm,
		'data_ciencia' => $dtCiencia,
		'prazo' =>  $dtPrazo,
		'id_natureza' => $natureza,
		'id_competencia_legis' => $competencia_legis,
		'relato_infracao' => $breveRelato,
		'fonte' => $fonte,
		'data_postagem_orgao' => $dataPostagemOrgao,
		'data_captura_sistema' => $dataCapturaSistema,
	);		
	$id = $this->notificacao_model->atualizar('notificacoes',$dados,$id);
	
			
	
	redirect('/notificacao/listar', 'refresh');
 }
 
	function export(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		
		if(empty($_POST)){
			$result = $this->notificacao_model->listarNotificacoes(0,0,0,0,'X');
		}else{	
			$estado = $this->input->post('estado');
			$cidade = $this->input->post('cidade');
			$cnpjRaiz = $this->input->post('cnpjRaizExp');
			$cnpj = $this->input->post('cnpj');
			$status = $this->input->post('status');
			$result = $this->notificacao_model->listarNotificacoes($estado,$cidade,$cnpjRaiz,$cnpj,$status);
		}
	
		$this->csv($result);
	
	}
	
	function csv($result){
	 
	 $file="notificacao.xls";

			
		
		$test="<table border=1>
		<tr>
		<td>Id</td>
		<td>CNPJ Raiz</td>		
		<td>CNPJ</td>
		<td>Inscri&ccedil;&atilde;o Estadual</td>
		<td>Inscri&ccedil;&atilde;o Mobili&aacute;ria</td>
		<td>Num. Lan&ccedil;amento ou D&eacute;bito</td>
		<td>Num. Processo</td>
		<td>Natureza</td>
		<td>Compet&ecirc;ncia Legislativa</td>
		<td>Data Ci&ecirc;ncia</td>
		<td>Prazo</td>
		<td>Data Conclus&atilde;o</td>
		<td>Breve Relato</td>
		<td>Status</td>
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
			  
			  	if($emitente->status == 0){
					$emitente->status='Em aberto';
				}else{
					$emitente->status='Conclu&iacute;do';
				}
			  
				$test .= "<tr>";
				$test .= "<td>".utf8_decode($emitente->id)."</td>";
				$test .= "<td>".utf8_decode($emitente->cnpj_raiz)."</td>";
				$test .= "<td>".utf8_decode($emitente->cnpj)."</td>";
				$test .= "<td>".utf8_decode($emitente->num_ie)."</td>";
				$test .= "<td>".utf8_decode($emitente->num_im)."</td>";
				$test .= "<td>".utf8_decode($emitente->num_lancamento)."</td>";
				$test .= "<td>".utf8_decode($emitente->num_processo)."</td>";
				$test .= "<td>".utf8_decode($emitente->descricao_natureza)."</td>";
				$test .= "<td>".utf8_decode($emitente->competencia_legis)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_ciencia_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->prazo_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_conclusao_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->relato_infracao)."</td>";
				$test .= "<td>".utf8_decode($emitente->status)."</td>";
				
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
		$this->load->view('notificacoes/cadastrar_notificacoes_view', $data);
		$this->load->view('footer_pages_view');
	}

	function editar(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$id = $this->input->get('id');
		$data['dados'] = $this->notificacao_model->listarNotificacaoById($id);
		$retorno = $this->auxiliador->verificaID($id);
		if($retorno){
			redirect('notificacao/listar', 'refresh');
		}
		if($data['dados'] == false or is_null($data['dados'])){
			redirect('notificacao/listar', 'refresh');
		}
		
		$this->load->view('header_pages_view',$data);
		$this->load->view('notificacoes/editar_notificacoes_view', $data);
		$this->load->view('footer_pages_view');
	}
	
	function arquivos(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['id'] = $id = $this->input->get('id');
		
		$data['dados'] = $this->notificacao_model->listarArquivoNotificacaoById($id);
		$retorno = $this->auxiliador->verificaID($id);
		if($retorno){
			redirect('notificacao/listar', 'refresh');
		}
		if($data['dados'] == false or is_null($data['dados'])){
			redirect('notificacao/listar', 'refresh');
		}
		
		$this->load->view('header_pages_view',$data);
		$this->load->view('notificacoes/arquivos_notificacoes_view', $data);
		$this->load->view('footer_pages_view');
	}
	
	function arquivosApp(){	
		$id = $_REQUEST['id'];
		$urlArr=array();
		for($i=0;$i<=4;$i++){
			$filename = './arquivos/notificacoes/'.$id.'-'.$i.'.pdf';
			$arq = '/arquivos/notificacoes/'.$id.'-'.$i.'.pdf';
			if (file_exists($filename)) {
				$urlArr[$i]['url'] = 'https://bdwebgestora.com.br/domicilios/lojamecanico/arquivos/notificacoes/'.$id.'-'.$i.'.pdf';				
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
		$config['upload_path'] = './arquivos/notificacoes/';			
		$config['allowed_types'] = '*';		
		$config['overwrite'] = 'true';				
		$config['file_name'] = $id.'-'.$arquivo.'.'.$extensao;				
		$this->load->library('upload', $config);	
		$this->upload->initialize($config);		
		$field_name = "userfile";				

		$arq = $this->notificacao_model->listarArquivo($arquivo);
		
		$filename =  './arquivos/notificacoes/'.$arq[0]->arquivo ;
		if (file_exists($filename)) {
			@unlink($filename);
		} 
		if (!$this->upload->do_upload($field_name)){			
			$error = array('error' => $this->upload->display_errors());						
			$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
			echo '0'; 
		}else{		
			
			$this->notificacao_model->apagaArquivo($arquivo);	
			
			$dadosArq = array(
			'id_notificacao' => $id,
			'arquivo' => $config['file_name'] 
			);			
			$this->notificacao_model->addArq($dadosArq);			
			
			echo'1';

		}

}
	
 function listarNaturezaJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	$emailRemetente = $session_data['email'] ;
	echo json_encode($this->notificacao_model->listarNatureza());
  
 }
 
	function listar(){
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['perfil'] = $session_data['perfil'];		
		if(empty($_POST)){
			$_SESSION['statusNotificacao'] =  'X';
			$_SESSION['estadoFiltroNot'] = $_SESSION['cidadeFiltroNot'] = $_SESSION['cnpjFiltroNot'] = 0;
			$data['dados'] = $this->notificacao_model->listarNotificacoes(0,0,0,0,'X');
		}else{
			$_SESSION['estadoFiltroNot'] = $estado = $this->input->post('estado');
			$_SESSION['cidadeFiltroNot'] =$cidade = $this->input->post('cidade');
			$cnpjRaiz = $this->input->post('cnpjRaiz');
			$_SESSION['cnpjFiltroNot'] =$cnpj = $this->input->post('cnpj');
			$_SESSION['statusNotificacao'] = $status = $this->input->post('status');
			
			$data['dados'] = $this->notificacao_model->listarNotificacoes($estado,$cidade,$cnpjRaiz,$cnpj,$status);
		}
		$data['emails'] = $this->email_model->listarEmail(0);
		$this->load->view('header_pages_view',$data);
		$this->load->view('notificacoes/listar_notificacoes_view', $data);
		$this->load->view('footer_pages_view');
	}
	
	function listarApp(){
		
		$estado = $_REQUEST['estado'];
		$result = $this->notificacao_model->listarNotificacoesApp($estado);
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
		
	$id = $this->notificacao_model->addEnc($dados);
	
	$stringEmails .= ',domiciliolojamecanico@bdservicos.com.br';	
	
	$list = array($stringEmails);

	
	
	

	define('DEST_DIR', './arquivos/enc_notificacoes/');
	
	if (($_FILES['userfile']['name'][0] !== '')){	
		// se o "name" estiver vazio, é porque nenhum arquivo foi enviado e cria uma variável para facilitar
		$arquivos = $_FILES['userfile'];
	 	// total de arquivos enviados
		$total = count($arquivos['name']);
		for ($i = 0; $i < $total; $i++){
			$nomeArquivoRandomico = strtotime("now")+$i;
			// podemos acessar os dados de cada arquivo desta forma:  $arquivos['name'][$i] - $arquivos['tmp_name'][$i] - $arquivos['size'][$i]  - $arquivos['error'][$i]  - $arquivos['type'][$i] 
			$extensao = str_replace('.','',strrchr($arquivos['name'][$i], '.'));	
			//$nomeArquivoRandomico = strtotime("now");
			
			//$nomeArq =  $id.'-'.$i.'.'.$extensao;		
			if (!move_uploaded_file($arquivos['tmp_name'][$i], DEST_DIR . '/' . $nomeArquivoRandomico.'.'.$extensao)) {
				echo "Erro ao enviar o arquivo: " . $arquivos['name'][$i];
			}		
			$dadosArq = array(
			'id_notificacao_enc' => $id,
			'arquivo' => $nomeArquivoRandomico.'.'.$extensao
			);			
			$this->notificacao_model->addArqEnc($dadosArq);			
		}     
	}
	
	
	$dadosInfracao = $this->notificacao_model->listarNotificacaoById($idNotif);

	if($completo == 1){
		$dadosEnc = $this->notificacao_model->listarNotificacaoTrackingById($idNotif);
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
	@$this->email->subject('Sistema BD Webdomicilios - Envio de Encaminhamento de Notificação' );
				
	if($dadosInfracao[0]->prazo_br ==  '01/01/1900'){
		$dadosInfracao[0]->prazo_br = ''; 
	}
												
												
	$texto = '
	<strong>Não responda esse email.</strong> <BR> <hr> 
	Entre no sistema e clique nesse link abaixo para acessa o tracking.
	<BR>
	<a href="https://bdwebgestora.com.br/domicilios/lojamecanico/index.php/notificacao/tracking?id='.$idNotif.'" target="_blank" >https://bdwebgestora.com.br/domicilios/lojamecanico/</a>
	<BR><BR>
	<strong>Dados da Notificação</strong> <BR> <BR> 
	CNPJ Raiz:'.$dadosInfracao[0]->cnpj_raiz.'
	<BR>
	CNPJ : '.$dadosInfracao[0]->cnpj.'
	<BR>
	Inscrição Estadual : '.$dadosInfracao[0]->num_ie.'
	<BR>
	Inscrição Estadual ST : '.$dadosInfracao[0]->num_st.'
	<BR>
	Inscrição Mobiliária : '.$dadosInfracao[0]->num_im.'
	<BR>
	Num. Lançamento ou Débito : '.$dadosInfracao[0]->num_lancamento.'
	<BR>
	Num. Processo : '.$dadosInfracao[0]->num_processo.'
	<BR>
	Data Ciência : '.$dadosInfracao[0]->data_ciencia_br.'
	<BR>
	Prazo : '.$dadosInfracao[0]->prazo_br.'
	<BR>
	Breve Relato da Notificação : '.$dadosInfracao[0]->relato_infracao.'
	<BR>
	Competência Legislativa : '.$dadosInfracao[0]->id_competencia_legis.'	
	<BR><BR>
	Novo Encaminhamento : '.$assunto.'
	<BR><BR>
	'.$textoEnc.'
	<hr>
		
			
	Atenciosamente, <BR> <BR> <strong>Sistema BD Webdomicilios <br> Apoio Técnico</strong>';
	$html = "<html><body style='font-family:Trebuchet MS'>".$texto."</body></html>";
		
	$arquivos = $this->notificacao_model->listarArquivosEnc($id);
	$b = getcwd();
	foreach($arquivos as $val){		
		if($val->arquivo){
			$caminho = $b.'/arquivos/enc_notificacoes/'.$val->arquivo;		
			$this->email->attach($caminho);
		}	
	}
		
	$this->email->set_mailtype("html");
	$this->email->set_alt_message($texto);
	$this->email->message($html);
	$this->email->send();
	
	
			
	if($completo == 1){
		redirect('/notificacao/tracking?id='.$idNotif, 'refresh');
	}else{
		redirect('/notificacao/listar', 'refresh');
	}
	
 }
function verDadosNotificacao(){
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['perfil'] = $session_data['perfil'];
	
		$id = $this->input->get('id');	
		echo json_encode($this->notificacao_model->listarNotificacaoById($id));
  
	}
	
	
	function verArquivos(){
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['perfil'] = $session_data['perfil'];
	
		$id = $this->input->get('id');	
		$arquivos = $this->notificacao_model->listarArquivosEnc($id);
		
	
		$base = $this->config->base_url();
		$array = '';
		$isArrayLog =  is_array($arquivos) ? '1' : '0';
		if($isArrayLog == 1) {
			foreach($arquivos as $dado){
				
				if(!empty($dado->arquivo)){
					$arquivo = "<a href=".$base."/arquivos/enc_notificacoes/".$dado->arquivo." target='_blank'>  <i class='fa fa-download' aria-hidden='true'></i></a>";				
					$array .= "<span>".$dado->arquivo." ".$arquivo."</span> <BR>";
				}else{
					$array .= "<span>Sem Arquivo</span> <BR>";	
				}
				
			}
		}else{
			$array .= "<span>Sem Arquivo</span>";
		}
	
	
		echo json_encode($array);		
  
	}
	
function tracking(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['id'] = $id = $this->input->get('id');
		
		$data['dados'] = $this->notificacao_model->listarNotificacaoTrackingById($id);
		$data['emails'] = $this->email_model->listarEmail(0);
		$this->load->view('header_pages_view',$data);
		$this->load->view('notificacoes/tracking_view', $data);
		$this->load->view('footer_pages_view');
	}
	
	function trackingApp(){	
		$id = $_REQUEST['id'];
		
		$result = $this->notificacao_model->listarNotificacaoTrackingById($id);
		
		echo json_encode($result);
		
		
	}
	
	function logado(){	
		if(! $_SESSION['login_walmart']) {	
		 redirect('login', 'refresh');
		}			
	}  

}

 

?>