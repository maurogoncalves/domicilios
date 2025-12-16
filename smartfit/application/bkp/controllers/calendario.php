<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Calendario extends CI_Controller {


 


 function __construct(){
	parent::__construct();
	$this->load->model('calendario_model','',TRUE);
	$this->load->model('log_model','',TRUE);
	$this->load->model('cnd_estadual_model','',TRUE);	
	$this->load->model('cnd_estadual_model','',TRUE);	
	$this->load->model('cnd_estadual_model','',TRUE);
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

   if( $_SESSION['login_walmart']){
     $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
     $this->load->view('home_view', $data);
   }else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }


 }
 
  function montar(){

   if( $_SESSION['login_walmart']){
     $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 $idContratante = $_SESSION['cliente'] ;	
	 $idUsuario = $session_data['id'];
	 
	 $ultimoDiaCorrente = date('Y-m').'-'.date('t');
	 $primeiroDiaCorrente = date('Y-m').'-01';	 
	 
	 $eventos = $this->calendario_model->listarEvento($idContratante,$idUsuario);
	 $stringEventos ='';
	 foreach($eventos as $eve){
		 $stringEventos .= "{title: '$eve->descricao',start: '$eve->data_evento'},";	
	 }
	 $data['eventos']  = $stringEventos;
	 $this->load->view('header_pages_view',$data);
	 $this->load->view('calendario_view', $data);
	 $this->load->view('footer_pages_view');
	
   }else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }


 }

  function inserir(){

   if( $_SESSION['login_walmart']){
     $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 $idContratante = $_SESSION['cliente'] ;	
	 $idUsuario = $session_data['id'];
	 
	 $ultimoDiaCorrente = date('Y-m').'-'.date('t');
	 $primeiroDiaCorrente = date('Y-m').'-01';	 
	 
	 if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	
	 $this->load->view('header_pages_view',$data);
	 $this->load->view('inserir_evento_view', $data);
	 $this->load->view('footer_pages_view');
	
   }else{
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }

 }
 
 function inserir_Evento(){
 
 if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
	 $idUsuario = $session_data['id'];
	
	$evento = $this->input->post('evento');
	$data = $this->input->post('data');
	$arrData = explode("-",$data);
	$data = $arrData[2].'-'.$arrData[1].'-'.$arrData[0];
	
		
	$dados = array(	'id_usuario' => $idUsuario,
					'id_contratante' => $idContratante,
					'data_evento' => $data,
					'descricao' => $evento
				);
				
	$this->calendario_model->add($dados);
	redirect('calendario/montar', 'refresh');
	
 }
 
}
?>