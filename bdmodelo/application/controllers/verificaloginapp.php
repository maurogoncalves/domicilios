<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class verificaloginapp extends CI_Controller {	function __construct(){		parent::__construct();		$this->load->model('user','',TRUE);		$this->load->model('infracao_model','',TRUE);		$this->load->model('contratante','',TRUE);		$this->load->library('session');		$this->load->library('form_validation');		$this->load->helper('url');	 		session_start();		header('Access-Control-Allow-Origin: *');		header('Access-Control-Allow-Methods: GET, OPTIONS, POST');		header('Access-Control-Allow-Headers: origin, x-requested-with,Content-Type, Content-Range, Content-Disposition, Content-Description');		
	}	public function index(){		header('Access-Control-Allow-Origin: *');		header('Access-Control-Allow-Methods: GET, OPTIONS, POST');		header('Access-Control-Allow-Headers: origin, x-requested-with,Content-Type, Content-Range, Content-Disposition, Content-Description');				$email_usuario = $_REQUEST['email_usuario'];		$senha = $_REQUEST['senha'];			$result = $this->user->loginApp($email_usuario, $senha);		$obj = 	array();				if($result){			$obj[0]['name']='Email existe';			$obj[0]['log']=1;			$obj[0]['contratante']=$result[0]->id_contratante;		 }else{			$obj[0]['name']='Email não existe';			$obj[0]['log']=2;			$obj[0]['contratante']=0;		 }		echo(json_encode($obj));	}	
	public function indexOld(){		$senha = $this->input->post('senha');			$email_usuario = $this->input->post('email_usuario');		//query the database				$contratante = $this->contratante->buscarId($cnpj);			if($contratante){			$contratante[0]->id;			$empresa = $contratante[0]->nome_empresa;			$result = $this->user->login($email_usuario, $senha,$contratante[0]->id);			if($result){				$sess_array = array();				foreach($result as $row){					$modulos = $this->user->perfil($row->id,1,$row->perfil);					$modulosFilho = $this->user->perfil($row->id,0,$row->perfil);					if(!$modulos){						print_r($modulos);exit;						$this->session->set_flashdata('mensagem','Você digitou algo errado, ou não tem acesso ao sistema');						redirect('/login', 'refresh');						}else{						   $sess_array = array(						 'id' => $row->id,		 						 'id_contratante' => $contratante[0]->id,						 'tipoUsuario' => $row->perfil,						 'consulta' => $row->consulta,						 'nome_usu' => $row->nome_usuario,					
						 'email' => $row->email,
						 'empresa' => $empresa,
						 'perfil' => $modulos,
						 'perfilFilho' => $modulosFilho,
					   );					   $_SESSION['login_walmart'] = $sess_array;					   if($row->perfil == 1){							redirect('cnpj/listarCnpjRaiz', 'refresh');   					   }else{							redirect('home', 'refresh');  					   }					   
					}   
				 }				 return TRUE;
			 }else{
				$this->session->set_flashdata('mensagem','Você digitou algo errado, ou não tem acesso ao sistema');
				redirect('/login', 'refresh');				
			 }
		}else{
			$this->session->set_flashdata('mensagem','CNPJ não existe');
			redirect('/login', 'refresh');
		}		
	}
}