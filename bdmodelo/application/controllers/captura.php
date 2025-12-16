<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Captura extends CI_Controller {
 function __construct(){
   parent::__construct();
   $this->load->model('email_model','',TRUE);
   $this->load->model('estado_model','',TRUE);
   $this->load->model('notificacao_model','',TRUE);		
   $this->load->model('captura_model','',TRUE);		
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

function cadastrar(){	
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data='';
	$this->load->view('header_pages_view',$data);
	$this->load->view('captura/cadastrar_captura_view', $data);
	$this->load->view('footer_pages_view');
}

	
function cadastrar_captura(){	
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;

	$uf  = $this->input->post('estado'); 
	$cnpj  = $this->input->post('cnpj');
	
	$dados = array(
	'cnpj' => $cnpj,
	'uf' => $uf,
	'data_captura' => date("Y-m-d"),
	);		
	

	$id = $this->captura_model->add($dados);
	define('DEST_DIR', './arquivos/captura/');
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
				'imagem' => $nomeArq,
			);		
			$this->captura_model->atualizar('captura_domicilio',$dadosArq,$id);			
		}     
	}
	
	redirect('/captura/listar', 'refresh');

}
	
function listar(){
	$this->logado();    
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $session_data['id_contratante'] ;
	$data['perfil'] = $session_data['perfil'];		
	if(empty($_POST)){
		$_SESSION['ufCaptura'] = $_SESSION['cnpjCaptura'] = 0;
		$data['dados'] = $this->captura_model->listarCapturas(0,0,0,0);
	}else{
		$_SESSION['ufCaptura'] = $estado = $this->input->post('estado');
		$_SESSION['cnpjCaptura'] = $cnpj = $this->input->post('cnpj');
		
		$data['dados'] = $this->captura_model->listarCapturas($estado,$cnpj);
	}
	
	$data['cnpjs'] =$this->captura_model->listarCnpj(0);
	
	$data['uf'] =$this->captura_model->listarUFs();
	$data['emails'] = $this->email_model->listarEmail(0);
	$this->load->view('header_pages_view',$data);
	$this->load->view('captura/listar_captura_view', $data);
	$this->load->view('footer_pages_view');
}
	
function listarEstadoComCnpj(){
	echo json_encode($this->captura_model->listarUFs());
}
function listarCnpj(){
	$estado = $this->input->get('estado');
	echo json_encode($this->captura_model->listarCnpj($estado));
}
	
function logado(){	
	if(! $_SESSION['login_walmart']) {	
	 redirect('login', 'refresh');
	}			
}  

}

 

?>