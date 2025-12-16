<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Acesso extends CI_Controller {

	function __construct(){
	   parent::__construct();
	   $this->load->library('session');
	 	session_start();	   
	}
	public function index()
	{
		//print$this->config->base_url();exit;
		if(!empty($this->session->flashdata('mensagem'))){
			$dados['mensagem'] = $this->session->flashdata('mensagem');
		}else{
			$dados['mensagem']='';
		}
		
		
		$this->load->helper(array('form'));
		$this->load->view('login',$dados);
	}
	

}
