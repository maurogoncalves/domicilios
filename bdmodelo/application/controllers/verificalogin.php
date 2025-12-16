<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');class VerificaLogin extends CI_Controller {	function __construct(){	   parent::__construct();	   $this->load->model('user','',TRUE);	   $this->load->model('infracao_model','',TRUE);	   $this->load->model('contratante','',TRUE);	   $this->load->library('session');	   $this->load->library('form_validation');	   $this->load->helper('url');	 		session_start();	   
	}
	public function index(){		$cnpj = $this->input->post('cnpj');			$senha = $this->input->post('senha');			$email_usuario = $this->input->post('email_usuario');		//query the database						$contratante = $this->contratante->buscarId($cnpj);			if($contratante){			$contratante[0]->id;			$empresa = $contratante[0]->nome_empresa;						$result = $this->user->login($email_usuario, $senha,$contratante[0]->id);						if($result){				$sess_array = array();				foreach($result as $row){					$modulos = $this->user->perfil($row->id,1,$row->perfil);					$modulosFilho = $this->user->perfil($row->id,0,$row->perfil);										if(!$modulos){						$this->session->set_flashdata('mensagem','Você digitou algo errado, ou não tem acesso ao sistema2222');						redirect('/login', 'refresh');						}else{						   $sess_array = array(						 'id' => $row->id,		 						 'id_contratante' => $contratante[0]->id,						 'tipoUsuario' => $row->perfil,						 'consulta' => $row->consulta,						 'nome_usu' => $row->nome_usuario,					
						 'email' => $row->email,
						 'empresa' => $empresa,
						 'perfil' => $modulos,
						 'perfilFilho' => $modulosFilho,						 'primeiro_acesso' => $row->primeiro_acesso,					
					   );					   $_SESSION['login_walmart'] = $sess_array;					   if($row->perfil == 1){							redirect('cnpj/listarCnpjRaiz', 'refresh');   					   }else{							redirect('home', 'refresh');  					   }					   
					}   
				 }				 return TRUE;
			 }else{
				$this->session->set_flashdata('mensagem','Você digitou algo errado, ou não tem acesso ao sistemaxxxx');
				redirect('/login', 'refresh');				
			 }
		}else{
			$this->session->set_flashdata('mensagem','CNPJ não existexxx');
			redirect('/login', 'refresh');
		}		
	}
}