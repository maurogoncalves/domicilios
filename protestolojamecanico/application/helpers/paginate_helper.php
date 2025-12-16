<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

	/**
	 * Metodo que configura numero de registro por pagina
	 */
	function numRegister4PagePaginate()
	{
		return 15;
	}

	/**
	 * Metodo que cria link de paginacao
	 */
	function createPaginate( $_modulo, $_total )
	{	
		$ci = &get_instance();
		$ci->load->library('pagination');
		
		$config['base_url']    = base_url('index.php/'.$_modulo.'/listar/');
		$config['total_rows']  = $_total;
		$config['per_page']    = numRegister4PagePaginate();
		$config["uri_segment"] = 3;
		$config['first_link']  = 'Primeiro';
		$config['last_link']   = '&Uacute;ltimo';
		$config['next_link']   = 'Pr&oacute;ximo';
		$config['prev_link']   = 'Anterior';

		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
	}

	function createPaginateTipo( $_modulo, $_total )
	{	
		$ci = &get_instance();
		$ci->load->library('pagination');
		
		$config['base_url']    = base_url('index.php/'.$_modulo.'/listarPorTipo/');
		$config['total_rows']  = $_total;
		$config['per_page']    = numRegister4PagePaginate();
		$config["uri_segment"] = 3;
		$config['first_link']  = 'Primeiro';
		$config['last_link']   = '&Uacute;ltimo';
		$config['next_link']   = 'Pr&oacute;ximo';
		$config['prev_link']   = 'Anterior';

		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
	}
	
	function createPaginateTipoSim( $_modulo, $_total )
	{	
		$ci = &get_instance();
		$ci->load->library('pagination');
		
		$config['base_url']    = base_url('index.php/'.$_modulo.'/listarPorTipoSim/');
		$config['total_rows']  = $_total;
		$config['per_page']    = numRegister4PagePaginate();
		$config["uri_segment"] = 3;
		$config['first_link']  = 'Primeiro';
		$config['last_link']   = '&Uacute;ltimo';
		$config['next_link']   = 'Pr&oacute;ximo';
		$config['prev_link']   = 'Anterior';

		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
	}
	
	function createPaginateTipoNao( $_modulo, $_total )
	{	
		$ci = &get_instance();
		$ci->load->library('pagination');
		
		$config['base_url']    = base_url('index.php/'.$_modulo.'/listarPorTipoNao/');
		$config['total_rows']  = $_total;
		$config['per_page']    = numRegister4PagePaginate();
		$config["uri_segment"] = 3;
		$config['first_link']  = 'Primeiro';
		$config['last_link']   = '&Uacute;ltimo';
		$config['next_link']   = 'Pr&oacute;ximo';
		$config['prev_link']   = 'Anterior';

		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
	}
	function createPaginateTipoPendencia( $_modulo, $_total )
	{	
		$ci = &get_instance();
		$ci->load->library('pagination');
		
		$config['base_url']    = base_url('index.php/'.$_modulo.'/listarPorTipoPendencia/');
		$config['total_rows']  = $_total;
		$config['per_page']    = numRegister4PagePaginate();
		$config["uri_segment"] = 3;
		$config['first_link']  = 'Primeiro';
		$config['last_link']   = '&Uacute;ltimo';
		$config['next_link']   = 'Pr&oacute;ximo';
		$config['prev_link']   = 'Anterior';

		$ci->pagination->initialize($config);
		return $ci->pagination->create_links();
	}