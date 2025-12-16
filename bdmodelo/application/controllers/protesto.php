<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Protesto extends CI_Controller {

 

 function __construct(){
   parent::__construct();
   $this->load->model('email_model','',TRUE);
   $this->load->model('estado_model','',TRUE);
   $this->load->model('protesto_model','',TRUE);		
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

 function cadastrar_protesto(){
	
	 
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$emailRemetente = $session_data['email'] ;
	$cnpj  = $this->input->post('cnpj'); 
	$ie  = $this->input->post('ie');
	$im  = $this->input->post('im');
	$credorFavorecido  = $this->input->post('credorFavorecido');  
	$cnpjCredor = $this->input->post('cnpjCredor');
	$contatoCredor = $this->input->post('contatoCredor');
	
	$cartorio  = $this->input->post('cartorio');  
	$dadosCartorio  = $this->input->post('dadosCartorio');  
	$folha  = $this->input->post('folha');  
	$livro  = $this->input->post('livro');  
	$natureza  = $this->input->post('natureza'); 
	$competencia_legis  = $this->input->post('competencia_legis'); 
	$numTitulo  = $this->input->post('numTitulo'); 
	
	$valorTitulo  = $this->input->post('valorTitulo');	
	$valorTitulo = str_replace(".","",$valorTitulo);
	$valorTitulo = str_replace(",",".",$valorTitulo);
	
	$valorProtestado  = $this->input->post('valorProtestado');	
	$valorProtestado = str_replace(".","",$valorProtestado);
	$valorProtestado = str_replace(",",".",$valorProtestado);
	
	$breveRelato  = $this->input->post('breve_relato');
	$dataProtesto  = $this->input->post('dataProtesto');
	$vencimento  = $this->input->post('vencimento');
	
	if(!empty($dataProtesto)){
		$dataProtestoArr = explode('/',$dataProtesto);
		$dataProtesto = $dataProtestoArr[2].'-'.$dataProtestoArr[1].'-'.$dataProtestoArr[0];
	}else{		
		$dataProtesto = '1900-01-01';
	}	
	if(!empty($vencimento)){
		$vencimentoArr = explode('/',$vencimento);
		$dtVencimento = $vencimentoArr[2].'-'.$vencimentoArr[1].'-'.$vencimentoArr[0];
	}else{		
		$dtVencimento = '1900-01-01';
	}	
	
	$cnpjCredor  = $this->input->post('cnpjCredor');
	$dataAdmissaoTitulo  = $this->input->post('dataAdmissaoTitulo');
	
	if(!empty($dataAdmissaoTitulo)){
		$dataAdmissaoTituloArr = explode('/',$dataAdmissaoTitulo);
		$dataAdm = $dataAdmissaoTituloArr[2].'-'.$dataAdmissaoTituloArr[1].'-'.$dataAdmissaoTituloArr[0];
	}else{		
		$dataAdm = '1900-01-01';
	}	
	
	
	$nrAutoInfracao  = $this->input->post('nrAutoInfracao');
	
	$nomeApresentante = $this->input->post('nomeApresentante');
	$cnpjApresentante = $this->input->post('cnpjApresentante');
	$contatoApresentante = $this->input->post('contatoApresentante');
	
	
	$nrCertDivAtiv = $this->input->post('nrCertDivAtiv');
	
	$dados = array(
		'id_cnpj' => $cnpj,
		'id_ie' => $ie,
		'id_im' => $im,
		'credor_favorecido' => $credorFavorecido,
		'contato_credor' => $contatoCredor,
		'cnpj_credor' => $cnpjCredor,
		'cartorio' => $cartorio,
		'dados_cartorio' => $dadosCartorio,
		'livro' => $livro,
		'folha' => $folha,
		'data_protesto' => $dataProtesto,
		'valor_protestado' => $valorProtestado,
		'numero_titulo' => $numTitulo,
		'valor_titulo' => $valorTitulo,		
		'vencimento' =>  $dtVencimento,		
		'id_natureza' => $natureza,		
		'id_competencia_legis' => $competencia_legis,		
		'relato_protesto' => $breveRelato,
		'nome_apresentante' => $nomeApresentante,
		'cnpj_apresentante' => $cnpjApresentante,
		'contato_apresentante' => $contatoApresentante,		
		'data_admissao_titulo' => $dataAdm,
		'nr_auto_infracao' => $nrAutoInfracao,
		'nr_cert_div_ativ' => $nrCertDivAtiv
		);		
	$id = $this->protesto_model->add($dados);
	
	define('DEST_DIR', './arquivos/protesto/');
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
			'id_protesto' => $id,
			'arquivo' => $nomeArq		
			);			
			$this->protesto_model->addArq($dadosArq);			
		}     
	}
	
	$dadosProtesto = $this->protesto_model->listarProtestoById($id);
	
	
	$emails = $this->email_model->listarEmailFiscalizacao();
	
	$this->load->library('email');
	$this->email->from('domicilios@bdwebgestora.com.br', 'BD Webdomicilios');
	$this->email->cc($emailRemetente);
	
	foreach($emails as $valor){
		
		$this->email->to($valor->email);
		$this->email->subject('Sistema BD Webdomicilios - Envio de Novo Protesto' );
				
		$texto = '
		<strong>Não responda esse email.</strong> <BR> <hR> 
		Acesse o link abaixo para acessar o sistema.
		<BR>
		<a href="https://bdwebgestora.com.br/domicilios/bdmodelo//index.php/protesto/tracking?id='.$id.'" target="_blank" >https://bdwebgestora.com.br/domicilios/bdmodelo//</a>
		<BR><BR>
			
		<strong>Dados da novo protesto</strong> <BR> <BR> 
		CNPJ Raiz:'.$dadosProtesto[0]->cnpj_raiz.'
		<BR>
		CNPJ : '.$dadosProtesto[0]->cnpj.'
		<BR>
		Inscrição Estadual : '.$dadosProtesto[0]->num_ie.'
		<BR>
		Inscrição Mobiliária : '.$dadosProtesto[0]->num_im.'
		<BR>
		Credor Favorecido : '.$dadosProtesto[0]->credor_favorecido.'
		<BR>
		Cartório : '.$dadosProtesto[0]->cartorio.'
		<BR>
		Número Título : '.$dadosProtesto[0]->numero_titulo.'
		<BR>
		Valor Título : '.$dadosProtesto[0]->valor_titulo.'
		<BR>
		Data Protesto : '.$dadosProtesto[0]->data_protesto_br.'
		<BR>
		Vencimento : '.$dadosProtesto[0]->vencimento_br.'
		<BR>
		Breve Relato do Protesto : '.$dadosProtesto[0]->relato_protesto.'
		<hR>
		
		Atenciosamente, <BR> <BR> <strong>Sistema BD Webdomicilios <br> Apoio Técnico</strong>';
		$html = "<html><body style='font-family:Trebuchet MS'>".$texto."</body></html>";
		
		$this->email->set_mailtype("html");
		$this->email->set_alt_message($texto);
		$this->email->message($html);
		$this->email->send();
	}
	
	
			
	
	redirect('/protesto/listar', 'refresh');
 }

function alterar_protesto(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$id  = $this->input->post('id'); 
	$cnpj  = $this->input->post('cnpj'); 
	$ie  = $this->input->post('ie');
	$im  = $this->input->post('im');
	$credorFavorecido  = $this->input->post('credorFavorecido');  
	$cnpjCredor = $this->input->post('cnpjCredor');
	$contatoCredor = $this->input->post('contatoCredor');
	
	$cartorio  = $this->input->post('cartorio');  
	$dadosCartorio  = $this->input->post('dadosCartorio');  
	$folha  = $this->input->post('folha');  
	$livro  = $this->input->post('livro');  
	$natureza  = $this->input->post('natureza'); 
	$competencia_legis  = $this->input->post('competencia_legis'); 
	$numTitulo  = $this->input->post('numTitulo'); 
	
	$valorTitulo  = $this->input->post('valorTitulo');	
	$valorTitulo = str_replace(".","",$valorTitulo);
	$valorTitulo = str_replace(",",".",$valorTitulo);
	
	$valorProtestado  = $this->input->post('valorProtestado');	
	$valorProtestado = str_replace(".","",$valorProtestado);
	$valorProtestado = str_replace(",",".",$valorProtestado);
	
	$breveRelato  = $this->input->post('breve_relato');
	$dataProtesto  = $this->input->post('dataProtesto');
	$vencimento  = $this->input->post('vencimento');
	
	if(!empty($dataProtesto)){
		$dataProtestoArr = explode('/',$dataProtesto);
		$dataProtesto = $dataProtestoArr[2].'-'.$dataProtestoArr[1].'-'.$dataProtestoArr[0];
	}else{		
		$dataProtesto = '1900-01-01';
	}	
	if(!empty($vencimento)){
		$vencimentoArr = explode('/',$vencimento);
		$dtVencimento = $vencimentoArr[2].'-'.$vencimentoArr[1].'-'.$vencimentoArr[0];
	}else{		
		$dtVencimento = '1900-01-01';
	}	
	
	$cnpjCredor  = $this->input->post('cnpjCredor');
	$dataAdmissaoTitulo  = $this->input->post('dataAdmissaoTitulo');
	
	if(!empty($dataAdmissaoTitulo)){
		$dataAdmissaoTituloArr = explode('/',$dataAdmissaoTitulo);
		$dataAdm = $dataAdmissaoTituloArr[2].'-'.$dataAdmissaoTituloArr[1].'-'.$dataAdmissaoTituloArr[0];
	}else{		
		$dataAdm = '1900-01-01';
	}	
	
	
	$nrAutoInfracao  = $this->input->post('nrAutoInfracao');
	
	$nomeApresentante = $this->input->post('nomeApresentante');
	$cnpjApresentante = $this->input->post('cnpjApresentante');
	$contatoApresentante = $this->input->post('contatoApresentante');
	
	
	$nrCertDivAtiv = $this->input->post('nrCertDivAtiv');
	
	$dados = array(
		'id_cnpj' => $cnpj,
		'id_ie' => $ie,
		'id_im' => $im,
		'credor_favorecido' => $credorFavorecido,
		'contato_credor' => $contatoCredor,
		'cnpj_credor' => $cnpjCredor,
		'cartorio' => $cartorio,
		'dados_cartorio' => $dadosCartorio,
		'livro' => $livro,
		'folha' => $folha,
		'data_protesto' => $dataProtesto,
		'valor_protestado' => $valorProtestado,
		'numero_titulo' => $numTitulo,
		'valor_titulo' => $valorTitulo,		
		'vencimento' =>  $dtVencimento,		
		'id_natureza' => $natureza,		
		'id_competencia_legis' => $competencia_legis,		
		'relato_protesto' => $breveRelato,
		'nome_apresentante' => $nomeApresentante,
		'cnpj_apresentante' => $cnpjApresentante,
		'contato_apresentante' => $contatoApresentante,		
		'data_admissao_titulo' => $dataAdm,
		'nr_auto_infracao' => $nrAutoInfracao,
		'nr_cert_div_ativ' => $nrCertDivAtiv
		);		
		
	$this->protesto_model->atualizar('protesto',$dados,$id);
	
	redirect('/protesto/listar', 'refresh');
 }
 
	function export(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		
		if(empty($_POST)){
			$result = $this->protesto_model->listarprotesto(0,0,0,0);
		}else{	
			$estado = $this->input->post('estado');
			$cidade = $this->input->post('cidade');
			$cnpjRaiz = $this->input->post('cnpjRaizExp');
			$cnpj = $this->input->post('cnpj');
			$result = $this->protesto_model->listarprotesto($estado,$cidade,$cnpjRaiz,$cnpj);
		}
	
		$this->csv($result);
	
	}
	
	function csv($result){
	 
	 $file="Protesto.xls";

				
		$test="<table border=1>
		<tr>
		<td>Id</td>
		<td>CNPJ Raiz</td>		
		<td>CNPJ</td>
		<td>Inscri&ccedil;&atilde;o Estadual</td>
		<td>Inscri&ccedil;&atilde;o Mobili&aacute;ria</td>
		<td>Cart&oacute;rio</td>
		<td>Dados Cart&oacute;rio</td>
		<td>Folha</td>
		<td>Livro</td>
		<td>Data Protesto</td>
		<td>N&uacute;m. T&iacute;tulo</td>
		<td>Valor Protestado</td>
		<td>Data de Emiss&atilde;o</td>
		<td>Vencimento</td>
		<td>Valor T&iacute;tulo</td>
		<td>Natureza</td>
		<td>Compet&ecirc;ncia Legislativa</td>
		<td>Dados Apresentante</td>
		<td>Cnpj Apresentante</td>
		<td>Contato Apresentante</td>		
		<td>Credor/Favorecido</td>
		<td>CNPJ Credor/Favorecido</td>
		<td>Contato Credor/Favorecido</td>		
		<td>N&uacute;m. certid&atilde;o divida ativa</td>		
		<td>N&uacute;m. do auto de infra&ccedil;&atilde;o</td>	
		<td>Breve Relato da Protesto</td>		
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
				$test .= "<td>".utf8_decode($emitente->num_ie)."</td>";
				$test .= "<td>".utf8_decode($emitente->num_im)."</td>";
				$test .= "<td>".utf8_decode($emitente->cartorio)."</td>";
				$test .= "<td>".utf8_decode($emitente->dados_cartorio)."</td>";
				$test .= "<td>".utf8_decode($emitente->folha)."</td>";
				$test .= "<td>".utf8_decode($emitente->livro)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_protesto_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->numero_titulo)."</td>";
				$test .= "<td>".utf8_decode($emitente->valor_protestado)."</td>";
				$test .= "<td>".utf8_decode($emitente->data_admissao_titulo_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->vencimento_br)."</td>";
				$test .= "<td>".utf8_decode($emitente->valor_titulo)."</td>";	
				$test .= "<td>".utf8_decode($emitente->descricao_natureza)."</td>";
				$test .= "<td>".utf8_decode($emitente->competencia_legis)."</td>";
				$test .= "<td>".utf8_decode($emitente->nome_apresentante)."</td>";
				$test .= "<td>".utf8_decode($emitente->cnpj_apresentante)."</td>";
				$test .= "<td>".utf8_decode($emitente->contato_apresentante)."</td>";				
				$test .= "<td>".utf8_decode($emitente->credor_favorecido)."</td>";
				$test .= "<td>".utf8_decode($emitente->cnpj_credor)."</td>";
				$test .= "<td>".utf8_decode($emitente->contato_credor)."</td>";				
				$test .= "<td>".utf8_decode($emitente->nr_cert_div_ativ)."</td>";				
				$test .= "<td>".utf8_decode($emitente->nr_auto_infracao)."</td>";
				$test .= "<td>".utf8_decode($emitente->relato_protesto)."</td>";				
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
		$this->load->view('protesto/cadastrar_protesto_view', $data);
		$this->load->view('footer_pages_view');
	}

	function editar(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$id = $this->input->get('id');
		$data['dados'] = $this->protesto_model->listarProtestoById($id);
		
		$this->load->view('header_pages_view',$data);
		$this->load->view('protesto/editar_protesto_view', $data);
		$this->load->view('footer_pages_view');
	}
	
	function arquivos(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['id'] = $id = $this->input->get('id');
		$data['dados'] = $this->protesto_model->listarArquivoProtestoById($id);
		
		$this->load->view('header_pages_view',$data);
		$this->load->view('protesto/arquivos_protesto_view', $data);
		$this->load->view('footer_pages_view');
	}
	
	function enviar(){		
	$session_data = $_SESSION['login_walmart'];
	$id = $this->input->get('id');		
	$arquivo = $this->input->get('arquivo');		
	$file = $_FILES["userfile"]["name"];
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './arquivos/protesto/';			
	$config['allowed_types'] = '*';		
	$config['overwrite'] = 'true';				
	$config['file_name'] = $id.'-'.$arquivo.'.'.$extensao;				
	$this->load->library('upload', $config);	
	$this->upload->initialize($config);		
	$field_name = "userfile";				
	
	$filename =  './arquivos/protesto/'.$id.'-'.$arquivo.'.pdf';
	if (file_exists($filename)) {
		unlink($filename);
	} 
	if (!$this->upload->do_upload($field_name)){			
		$error = array('error' => $this->upload->display_errors());						
		$_SESSION['mensagemIptu'] =  $this->upload->display_errors();
		echo '0'; 
	}else{		
		
		echo'1';

	}

}
	
 function listarNaturezaJson(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];
	
	echo json_encode($this->protesto_model->listarNatureza());
  
 }
 
	function listar(){
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['perfil'] = $session_data['perfil'];		
		if(empty($_POST)){
			$_SESSION['estadoFiltroProt'] = $_SESSION['cidadeFiltroProt'] = $_SESSION['cnpjFiltroProt'] = 0;
			$data['dados'] = $this->protesto_model->listarprotesto(0,0,0,0);
		}else{
			$_SESSION['estadoFiltroProt'] = $estado = $this->input->post('estado');
			$_SESSION['cidadeFiltroProt'] = $cidade = $this->input->post('cidade');
			$cnpjRaiz = $this->input->post('cnpjRaiz');
			$_SESSION['cnpjFiltroProt'] =$cnpj = $this->input->post('cnpj');
			
			$data['dados'] = $this->protesto_model->listarprotesto($estado,$cidade,$cnpjRaiz,$cnpj);
		}
		

		$data['emails'] = $this->email_model->listarEmail(0);
		$this->load->view('header_pages_view',$data);
		$this->load->view('protesto/listar_protesto_view', $data);
		$this->load->view('footer_pages_view');
	}

	function listarApp(){
		
		$estado = $_GET['estado'];
		$cidade = 0;$cnpjRaiz= 0;$cnpj= 0;
		$result = $this->protesto_model->listarprotestoapp($estado);
		echo json_encode($result);	
		
	
	}
function encaminhar(){
	
	
	date_default_timezone_set('America/Sao_Paulo');	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$emailRemetente = $session_data['email'] ;
	$emailEnviar  = $this->input->post('email'); 
	$assunto  = $this->input->post('assunto');
	$idProtesto  = $this->input->post('id');
	$completo  = $this->input->post('completo');
	
	//$dadosEmail = $this->email_model->listarEmail($emailEnviar);
	
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
	
	$dados = array(
		'id_protesto' => $idProtesto,
		'id_email' => $stringEmails,
		'texto' => $assunto,
		'data_envio' => date("Y-m-d H:i:s"),
		);		
	$id = $this->protesto_model->addEnc($dados);

	$stringEmails .= ',domicilioSmartFit@bdservicos.com.br';	
	
	$list = array($stringEmails);


	$nomeArquivoRandomico = strtotime("now");
	
	
	$file = $_FILES["userfile"]["name"];
	
	$extensao = str_replace('.','',strrchr($file, '.'));						
	$base = base_url();		        
	$config['upload_path'] = './arquivos/enc_protesto/';			
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
		'id_protesto_enc' => $idProtesto,
		'arquivo' => $nomeArquivoRandomico.'.'.$extensao,	
		);			
		$this->protesto_model->addArqEnc($dadosArq);
		
	}
	
	$dadosProtesto = $this->protesto_model->listarProtestoById($idProtesto);

	if($completo == 1){
		$dadosEnc = $this->protesto_model->listarProtestoTrackingById($idProtesto);
		$textoEnc ='Histórico de Encaminhamento <BR><BR>';
		
		foreach($dadosEnc as $val){
			$textoEnc .="<span style='font-weight:bold'>Enviado para ".$val->nome." : ".$val->email." ".$val->data_envio_br."</span><BR>";
			$textoEnc .=$val->texto."<BR>";
			$textoEnc .="<BR>";

		}
	}else{
		$textoEnc ='';
	}
	
	
	
	
	$this->load->library('email');
	$this->email->from('domicilios@bdwebgestora.com.br', 'BD Webdomicilios');
	$this->email->cc($emailRemetente);
	$this->email->to($list);
		$this->email->subject('Sistema BD Webdomicilios - Envio de Encaminhamento de Protesto' );
				
				
		$texto = '
		<strong>Não responda esse email.</strong> <BR> <hr> 
		Acesse o link abaixo para acessar o sistema.
		<BR>
		<a href="https://bdwebgestora.com.br/domicilios/bdmodelo//index.php/protesto/tracking?id='.$idProtesto.'" target="_blank" >https://bdwebgestora.com.br/domicilios/bdmodelo//</a>
		<BR><BR>
			
		<strong>Dados da novo protesto</strong> <BR> <BR> 
		CNPJ Raiz:'.$dadosProtesto[0]->cnpj_raiz.'
		<BR>
		CNPJ : '.$dadosProtesto[0]->cnpj.'
		<BR>
		Inscrição Estadual : '.$dadosProtesto[0]->num_ie.'
		<BR>
		Inscrição Mobiliária : '.$dadosProtesto[0]->num_im.'
		<BR>
		Credor Favorecido : '.$dadosProtesto[0]->credor_favorecido.'
		<BR>
		Cartório : '.$dadosProtesto[0]->cartorio.'
		<BR>
		Número Título : '.$dadosProtesto[0]->numero_titulo.'
		<BR>
		Valor Título : '.$dadosProtesto[0]->valor_titulo.'
		<BR>
		Data Protesto : '.$dadosProtesto[0]->data_protesto_br.'
		<BR>
		Vencimento : '.$dadosProtesto[0]->vencimento_br.'
		<BR>
		Breve Relato do Protesto : '.$dadosProtesto[0]->relato_protesto.'
		<BR><BR>
		Novo Encaminhamento : '.$assunto.'
		<BR><BR>
		'.$textoEnc.'
		<hr>
			
		Atenciosamente, <BR> <BR> <strong>Sistema BD Webdomicilios <br> Apoio Técnico</strong>';
		$html = "<html><body style='font-family:Trebuchet MS'>".$texto."</body></html>";
		
		$b = getcwd();
		$caminho = $b.'/arquivos/enc_notificacoes/'.$dadosProtesto[0]->arq;
		$this->email->attach($caminho);
		
		$this->email->set_mailtype("html");
		$this->email->set_alt_message($texto);
		$this->email->message($html);
		$this->email->send();
	
	if($completo == 1){
		redirect('/protesto/tracking?id='.$idProtesto, 'refresh');
	}else{
		redirect('/protesto/listar', 'refresh');
	}
	
 }
 
 function verDadosProtesto(){
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['perfil'] = $session_data['perfil'];
	
		$id = $this->input->get('id');	
		echo json_encode($this->protesto_model->listarProtestoById($id));
  
	}
	
	function trackingApp(){	
	
		$id = $_REQUEST['id'];		
		$result = $this->protesto_model->listarProtestoTrackingById($id);		
		echo json_encode($result);
		
		
	}
	
	function arquivosApp(){	
		$id = $_REQUEST['id'];
		$urlArr=array();
		for($i=0;$i<=4;$i++){
			$filename = './arquivos/protesto/'.$id.'-'.$i.'.pdf';
			$arq = '/arquivos/protesto/'.$id.'-'.$i.'.pdf';
			if (file_exists($filename)) {
				$urlArr[$i]['url'] = 'https://bdwebgestora.com.br/domicilios/bdmodelo//arquivos/protesto/'.$id.'-'.$i.'.pdf';				
			}else{
				$urlArr[$i]['url'] = '-';
			}
		}	
		echo json_encode($urlArr);
	}
	
 function tracking(){	
		$this->logado();    
		$session_data = $_SESSION['login_walmart'];
		$idContratante = $session_data['id_contratante'] ;
		$data['id'] = $id = $this->input->get('id');
		
		$data['dados'] = $this->protesto_model->listarProtestoTrackingById($id);
		$data['emails'] = $this->email_model->listarEmail(0);
		$this->load->view('header_pages_view',$data);
		$this->load->view('protesto/tracking_view', $data);
		$this->load->view('footer_pages_view');
	}
	
	function logado(){	
		if(! $_SESSION['login_walmart']) {	
		 redirect('login', 'refresh');
		}			
	}  

}

 

?>