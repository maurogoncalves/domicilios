<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Licencas extends CI_Controller {


 


 function __construct(){
	parent::__construct();
	$this->load->model('log_model','',TRUE);
	$this->load->model('lojas_licencas_model','',TRUE);		
	$this->load->model('licenca_model','',TRUE);
	$this->load->model('cnd_imobiliaria_model','',TRUE);	
	$this->load->model('cnd_imobiliaria_model','',TRUE);
    $this->load->model('emitente_imovel_model','',TRUE);
    $this->load->model('tipo_emitente_model','',TRUE);
    $this->load->model('situacao_imovel_model','',TRUE);
	$this->load->model('loja_model','',TRUE);
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

  function dados_agrupados(){	
 
	 if(! $_SESSION['login_walmart']){
			redirect('login', 'refresh');
	  }
  
	$cidade = '0';
	$estado = '0';
	
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	$ano = date('Y');
	$regionais = $this->lojas_licencas_model->regionais();
	
	
	$regionalVig = array();

	$regionalNVig = array();

	
	$i=1;

	foreach($regionais as $reg){
		$resultVig = $this->lojas_licencas_model->contaCndRegionalVigente($idContratante,1,$reg->id);
		$regionalVig[$i]['regional'] = $reg->descricao;
		if(empty($resultVig[0]['total'])){
			$regionalVig[$i]['total'] = 0;
		}else{
			$regionalVig[$i]['total'] = $resultVig[0]['total'];	
		}
		
		$resultNvig = $this->lojas_licencas_model->contaCndRegionalVigente($idContratante,2,$reg->id);
		$regionalNVig[$i]['regional'] = $reg->descricao;
		if(empty($resultNvig[0]['total'])){
			$regionalNVig[$i]['total'] = 0;
		}else{
			$regionalNVig[$i]['total'] = $resultNvig[0]['total'];	
		}
		
		$i++;
	}
	

	$data['regionalVig'] = $regionalVig ;

	$data['regionalNVig'] = $regionalNVig;

	$data['modulo'] = 'licencas';
	$data['iptus'] = $this->lojas_licencas_model->contaCnd($idContratante,$ano);

	$data['perfil'] = $session_data['perfil'];
	
	$_SESSION["cidadeLicBD"] = 0;
	$_SESSION["estadoLicBD"] = 0;
	$_SESSION["idLojaBD"] = 0;
	$_SESSION["licMod"] = '';
		
	$this->load->view('header_pages_view',$data);

    $this->load->view('dados_agrupados_licencas_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 function atualizar_licenca_loja(){
	 
 
   if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	
	$id_licenca = $this->input->post('id_licenca');
	$id_loja = $this->input->post('id_loja');
	
		
	$dadosLoja = $this->loja_model->listarCidadeEstadoLojaById($id_loja);

	$_SESSION["cidadeLicBD"] =  $dadosLoja[0]->cidade;
	$_SESSION["estadoLicBD"] =  $dadosLoja[0]->estado;
	$_SESSION["idLojaBD"] = $id_loja;
	
	$modulo = $_SESSION["licMod"];
	
	$tipo_licenca = $this->input->post('tipo_licenca');
	$data_vencto = $this->input->post('data_vencto');	
	$arrDataVencto = explode("/",$data_vencto);
	$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
	$observacoes = $this->input->post('observacoes');	

	
	if($tipo_licenca == 0){
		$this->session->set_flashdata('mensagem','Escolha um tipo de licença');
	}
	
	$dados = array(	'tipo_licenca_taxa' => $tipo_licenca,
					'data_vencimento' => $dataVencto,
					'observacoes' => $observacoes,
				);
				
	
	
	

	
	if($this->loja_model->atualiza_licenca($dados,$id_licenca)) {
		$this->session->set_flashdata('mensagem','Cadastro Atualizado com sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum Erro Aconteceu');
	}
	redirect('/licencas/'.$modulo, 'refresh');	
 }

  function cadastrar(){
	$session_data = $_SESSION['login_walmart'];

    $data['email'] = $session_data['email'];
	$data['empresa'] = $session_data['empresa'];
	$data['perfil'] = $session_data['perfil'];
	$idContratante = $_SESSION['cliente'] ;
	$data['emitentes'] = $this->lojas_licencas_model->listarEmitentes($idContratante);
	$data['tipos_licencas'] = $this->lojas_licencas_model->listarTipoLicenca();
	$this->load->view('header_pages_view',$data);

    $this->load->view('cadastrar_licenca_view', $data);

	$this->load->view('footer_pages_view');
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

 function atualizar_licenca(){
 
   if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	$id_emitente = $this->input->post('id_emitente');	
	$tipo_licenca = $this->input->post('tipo_licenca');
	$cep = $this->input->post('cep');	
	$numero = $this->input->post('numero');	
	$logradouro = $this->input->post('logradouro');	
	$bairro = $this->input->post('bairro');	
	$cidade = $this->input->post('cidade');	
	$estado = $this->input->post('estado');	
	$data_vencto = $this->input->post('data_vencto');	
	$arrDataVencto = explode("/",$data_vencto);
	$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
	$observacoes = $this->input->post('observacoes');	
	$id = $this->input->post('id');	
	
	
	$dados = array(
	'id_contratante' => $idContratante,
	'id_emitente' => $id_emitente,
	'tipo_licenca_taxa' => $tipo_licenca,
	'data_vencimento' => $dataVencto,
	'observacoes' => utf8_decode($observacoes),
	'ativo' => 0,
	'cep' => $cep,
	'numero' => $numero,
	'rua' => ($logradouro),
	'bairro' => ($bairro),
	'cidade' => ($cidade),
	'estado' => $estado,
	);
	
	$dadosContratante = $this->lojas_licencas_model->listarContratante($idContratante);	
	$dadosEmitente = $this->lojas_licencas_model->listarLicencasByEmitente($idContratante,$id_emitente);
	$dadosTipoLicenca = $this->lojas_licencas_model->listarTipoLicencaById($tipo_licenca);	
	$dadosAtuais = $this->lojas_licencas_model->listarLicencaById($id);	

	$dadosAlterados = '';
	if($dadosAtuais[0]->id_emitente <> $id_emitente){
		$dadosAlterados .= 'Emitente: '.$dadosEmitente[0]->razao_social;
	}
	if($dadosAtuais[0]->tipo_licenca_taxa <> $tipo_licenca){
		$dadosAlterados .= ' - Tipo de Licenca: '.$dadosTipoLicenca[0]->descricao;
	}
	if($dadosAtuais[0]->data_vencimento <> $data_vencto){
		$dadosAlterados .= ' - Data Vencimento: '.$data_vencto;
	}
	if($dadosAtuais[0]->observacoes <> $observacoes){
		$dadosAlterados .= ' - Observacoes: '.$observacoes;
	}
	if($dadosAtuais[0]->cep <> $cep){
		$dadosAlterados .= ' - CEP: '.$cep;
		$dadosAlterados .= ' - Rua: '.$logradouro;
		$dadosAlterados .= ' - Bairro: '.$bairro;
		$dadosAlterados .= ' - Cidade: '.$cidade;
		$dadosAlterados .= ' - Estado: '.$estado;
	}	
	if($dadosAtuais[0]->numero <> $numero){
		$dadosAlterados .= ' - Numero: '.$numero;
	}	
	
	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'licencas',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => $dadosAlterados,
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	if($this->lojas_licencas_model->atualizar($dados,$id)) {
		echo "<script>alert('Cadastro Atualizado com sucesso');</script>";	
	}else{	
		echo "<script>alert('Algum Erro Aconteceu');</script>";	
	}
	redirect('/licencas/listar', 'refresh');

 }
 function contaVencidas(){
  if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$total = $this->lojas_licencas_model->contaVencidas($idContratante);
	return($total);
	
 }  
 
 
 

 function cadastrar_licenca(){
 
   if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$id_emitente = $this->input->post('id_emitente');	

	$tipo_licenca = $this->input->post('tipo_licenca');
	$cep = $this->input->post('cep');	
	$numero = $this->input->post('numero');	
	$logradouro = $this->input->post('logradouro');	
	$bairro = $this->input->post('bairro');	
	$cidade = $this->input->post('cidade');	
	$estado = $this->input->post('estado');	
	$data_vencto = $this->input->post('data_vencto');	
	$arrDataVencto = explode("/",$data_vencto);
	$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
	$observacoes = $this->input->post('observacoes');	
	
	
	$dados = array('id_contratante' => $idContratante,
					'id_emitente' => $id_emitente,
					'tipo_licenca_taxa' => $tipo_licenca,
					'data_vencimento' => $dataVencto,
					'observacoes' => $observacoes,
					'ativo' => 0,
					'cep' => $cep,
					'numero' => $numero,
					'rua' => $logradouro,
					'bairro' => $bairro,
					'cidade' => $cidade,
					'estado' => $estado,
				);
	if($this->lojas_licencas_model->add($dados)) {
		$this->db->cache_off();
		echo "<script>alert('Cadastro Realizado com sucesso');</script>";	
	}else{	
		echo "<script>alert('Algum Erro Aconteceu');</script>";	
	}
	redirect('/licencas/listar', 'refresh');	

 }

 
 

 function inativar(){
	if(! $_SESSION['login_walmart']){
			redirect('login', 'refresh');
	  }

  
	$id = $this->input->get('id');
	
	$dadosLoja = $this->loja_model->listarCidadeEstadoLojaByIdLic($id);
	$_SESSION["cidadeLicBD"] =  $dadosLoja[0]->cidade;
	$_SESSION["estadoLicBD"] =  $dadosLoja[0]->estado;
	
	$session_data = $_SESSION['login_walmart'];
	//$_SESSION["idLojaBD"] = $id_loja;
	
	$modulo = $_SESSION["licMod"];
	
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);

	if($podeExcluir[0]['total'] == 1){	

		$this->lojas_licencas_model->excluirFisicamente($id,'lojas_licencas');
		$_SESSION['mensagemLojaLicena'] =  CADASTRO_APAGADO;	
	}else{
		
		$dados = array('ativo' => 1);

		if($this->lojas_licencas_model->atualizar($dados,$id)) {
			$_SESSION['mensagemLojaLicena'] =  CADASTRO_INATIVO;		
		}else{	
			$_SESSION['mensagemLojaLicena'] =  ERRO;		
		}
		
		
	}
	

	
	redirect('/licencas/'.$modulo, 'refresh');		
 }
 
 function ativar(){
	if(! $_SESSION['login_walmart']){
			redirect('login', 'refresh');
	  }

  
	$id = $this->input->get('id');

	$dados = array('ativo' => 0);

	if($this->lojas_licencas_model->atualizar($dados,$id)) {
//	print_r($this->db->last_query());exit;
		$this->session->set_flashdata('mensagem','Cadastro Ativado com sucesso');
	}else{	
		$this->session->set_flashdata('mensagem','Algum erro aconteceu!');
	}	
	$dadosLoja = $this->loja_model->listarCidadeEstadoLojaByIdLic($id);
	
	$_SESSION["cidadeLicBD"] =  $dadosLoja[0]->cidade;
	$_SESSION["estadoLicBD"] =  $dadosLoja[0]->estado;
	$_SESSION["idLojaBD"] = $id_loja;
	
	$modulo = $_SESSION["licMod"];
	
	redirect('/licencas/'.$modulo, 'refresh');	

 }
 

 

  function editar(){	
  
  if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }



	$id = $this->input->get('id');


	$session_data = $_SESSION['login_walmart'];


	$idContratante = $_SESSION['cliente'] ;


	$data['dados'] = $this->lojas_licencas_model->listarLicencaById($id);
	
	$data['perfil'] = $session_data['perfil'];
	
	$data['emitentes'] = $this->lojas_licencas_model->listarEmitentes($idContratante);
	$data['tipos_licencas'] = $this->lojas_licencas_model->listarTipoLicenca();


	$this->load->view('header_pages_view',$data);


    $this->load->view('editar_licenca_view', $data);


	$this->load->view('footer_pages_view');





 }
 function buscaLicencaByEmitente(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;

	$retorno ='';
	$result = $this->lojas_licencas_model->listarLicencasByEmitente($idContratante,$id,$tipo);
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno .="0";

		
	}else{	
		foreach($result as $key => $licenca){ 			 
		if($licenca->status == 0){
			$status ='Ativo';
			$cor = '#009900';
		 }else{
			$status ='Inativo';
			$cor = '#CC0000';
		 }
		$dataVArr = explode("-",$licenca->data_vencimento);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
		 
		 $base = $this->config->base_url().'index.php';
		 $retorno .="<tr style='color:$cor'>";
		 $retorno .="<td width='20%'>".$licenca->nome_fantasia."</td>";
		 $retorno .="<td width='15%'>".$licenca->descricao."</td>";
		 $retorno .="<td width='20%'>".$dataVencto."</td>";
		 $retorno .="<td width='20%'>".$licenca->cidade."</td>";
		 $retorno .="<td width='10%'>".$licenca->estado."</td>";
		 $retorno .="<td width='15%'>";
		 $retorno .="<a href='$base/licencas/editar_loja_licenca?id_licenca=$licenca->id_licenca&id_loja=$licenca->id_loja' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		 $retorno .="<a href='$base/licencas/inativar?id=$licenca->id_licenca' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		 $retorno .="<a href='$base/licencas/ativar?id=$licenca->id_licenca' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		 $retorno .="</td>";
		 $retorno .="</tr>";
		
		
		 
		}
	
	}

	echo json_encode($retorno);
	
 }
 
  function editar_loja_licenca(){
	 $id_licenca = $this->input->get('id_licenca');
	 $id_loja = $this->input->get('id_loja');
	 
	 $dadosLoja = $this->loja_model->listarCidadeEstadoLojaById($id_loja);
	 
	$_SESSION["cidadeLicBD"] =  $dadosLoja[0]->cidade;
	$_SESSION["estadoLicBD"] =  $dadosLoja[0]->estado;
	$_SESSION["idLojaBD"] = $id_loja;
	

	
	 $data['regionais'] = $this->loja_model->listarRegional();
	 $session_data = $_SESSION['login_walmart'];
	 
	 $idContratante = $_SESSION['cliente'] ;
	 		
	
	 $data['tipos_licencas'] = $this->licenca_model->listarTipoLicenca();	

	 $data['dados_licenca'] = $this->loja_model->listarLicencaLoja($id_loja,$id_licenca);
	 $this->load->view('header_pages_view',$data);
	 $this->load->view('editar_lojas_licencas_view', $data);
	 $this->load->view('footer_pages_view');	
 }
 
 function buscaLicencaByCidade(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;

	$retorno ='';
	$result = $this->lojas_licencas_model->listarLicencasByCidade($idContratante,$id,$tipo);
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno .="0";

		
	}else{	
		foreach($result as $key => $licenca){ 			 
		if($licenca->status == 0){
			$status ='Ativo';
			$cor = '#009900';
		 }else{
			$status ='Inativo';
			$cor = '#CC0000';
		 }
		$dataVArr = explode("-",$licenca->data_vencimento);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
		 
		 $base = $this->config->base_url().'index.php';
		 $retorno .="<tr style='color:$cor'>";
		 $retorno .="<td width='20%'>".$licenca->nome_fantasia."</td>";
		 $retorno .="<td width='15%'>".$licenca->descricao."</td>";
		 $retorno .="<td width='20%'>".$dataVencto."</td>";
		 $retorno .="<td width='20%'>".$licenca->cidade."</td>";
		 $retorno .="<td width='10%'>".$licenca->estado."</td>";
		 $retorno .="<td width='15%'>";
		 $retorno .="<a href='$base/licencas/editar_loja_licenca?id_licenca=$licenca->id_licenca&id_loja=$licenca->id_loja' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		 $retorno .="<a href='$base/licencas/inativar?id=$licenca->id_licenca' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		 $retorno .="<a href='$base/licencas/ativar?id=$licenca->id_licenca' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		 $retorno .="</td>";
		 $retorno .="</tr>";
		
		
		 
		}
	
	}

	echo json_encode($retorno);
	
 }
 
 function export(){	
	
	$id = $this->input->post('id_emitente_export');
	$tipo = $this->input->post('tipo');
	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;

	$retorno ='';
	if($id <> 0){
		$result = $this->lojas_licencas_model->listarLicencasByEmitente($idContratante,$id,$tipo);
	}else{
		$result = $this->lojas_licencas_model->listarLicencasTodos($idContratante,$tipo);
	}	
	
	$file="licencas_por_emitente.xls";
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$retorno .='</table>';

		
	}else{	

	$retorno="<table border=1>
			<tr>
			<td>Id</td>
			<td>Raz&atilde;o Social</td>
			<td>CPF/CNPJ</td>
			<td>Descri&ccedil;&atilde;o</td>
			<td>Data Vencimento</td>
			<td>Rua</td>
			<td>N&uacute;mero</td>
			<td>Bairro</td>
			<td>Cidade</td>
			<td>Estado</td>
			<td>Ativo</td>
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>
			</tr>
			";
		foreach($result as $key => $licenca){ 	
		$dadosLog = $this->log_model->listarLog($licenca->id_licenca,'licencas');	
		$isArrayLog =  is_array($dadosLog) ? '1' : '0';	
		
		//print_r($dadosLog);exit;
		if($licenca->status == 0){
			$status ='Ativo';
			$cor = '#009900';
		 }else{
			$status ='Inativo';
			$cor = '#CC0000';
		 }
		$dataVArr = explode("-",$licenca->data_vencimento);									 
		$dataVencto = $dataVArr[2].'/'.$dataVArr[1].'/'.$dataVArr[0];
		 
		 $base = $this->config->base_url().'index.php';
		 $retorno .="<tr style='color:$cor'>";
		 $retorno .="<td>".$licenca->id_licenca."</td>";
		 $retorno .="<td>".utf8_decode($licenca->nome_fantasia)."</td>";
		 $retorno .="<td>".$licenca->cpf_cnpj."</td>";
		 $retorno .="<td>".utf8_decode($licenca->descricao)."</td>";
		 $retorno .="<td>".$dataVencto."</td>";
		 $retorno .="<td>".$licenca->endereco."</td>";
		 $retorno .="<td>".$licenca->numero."</td>";
		 $retorno .="<td>".utf8_decode($licenca->bairro)."</td>";
		 $retorno .="<td>".utf8_decode($licenca->cidade)."</td>";
		 $retorno .="<td>".$licenca->estado."</td>";
		 $retorno .="<td>".$status."</td>";
		 if($isArrayLog <> 0){
			 $dataFormatadaArr = explode('-',$dadosLog[0]->data);
			 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
			 $retorno .="<td>".$dadosLog[0]->email."</td>";
			 $retorno .="<td>".$dataFormatada."</td>";
			 $retorno .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";
		 }else{
			$retorno .="<td></td>";
			 $retorno .="<td></td>";
			 $retorno .="<td></td>";
		 }
		 $retorno .="</tr>";
		
		
		 
		}
		$retorno .='</table>';
	
	}
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $retorno;	
	//echo json_encode($retorno);
	
 }
 
 function export_mun(){	
	
	$id = $this->input->post('id_mun_export');
	$tipo = $this->input->post('tipo');
	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;

	$retorno ='';
	$result = $this->lojas_licencas_model->listarLicencasByCidade($idContratante,$id,$tipo);
	//print_r($this->db->last_query());exit;
	$file="licencas_por_cidade.xls";
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$retorno .='</table>';

		
	}else{	

	$retorno="<table border=1>
			<tr>
			<td>Id</td>
			<td>Raz&atilde;o Social</td>
			<td>CPF/CNPJ</td>
			<td>Descri&ccedil;&atilde;o</td>
			<td>Data Vencimento</td>
			<td>Rua</td>
			<td>N&uacute;mero</td>
			<td>Bairro</td>
			<td>Cidade</td>
			<td>Estado</td>
			<td>Ativo</td>
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>
			</tr>
			";
		foreach($result as $key => $licenca){ 
		$dadosLog = $this->lojas_licencas_model->listarLog($licenca->id_licenca);	
		$isArrayLog =  is_array($dadosLog) ? '1' : '0';
		
		if($licenca->status == 0){
			$status ='Ativo';
			$cor = '#009900';
		 }else{
			$status ='Inativo';
			$cor = '#CC0000';
		 }
		$dataVArr = explode("-",$licenca->data_vencimento);									 
		$dataVencto = $dataVArr[2].'/'.$dataVArr[1].'/'.$dataVArr[0];
		 
		 $base = $this->config->base_url().'index.php';
		 $retorno .="<tr style='color:$cor'>";
		 $retorno .="<td>".$licenca->id_licenca."</td>";
		 $retorno .="<td>".utf8_decode($licenca->nome_fantasia)."</td>";
		 $retorno .="<td>".$licenca->cpf_cnpj."</td>";
		 $retorno .="<td>".utf8_decode($licenca->descricao)."</td>";
		 $retorno .="<td>".$dataVencto."</td>";
		 $retorno .="<td>".$licenca->endereco."</td>";
		 $retorno .="<td>".$licenca->numero."</td>";
		 $retorno .="<td>".utf8_decode($licenca->bairro)."</td>";
		 $retorno .="<td>".utf8_decode($licenca->cidade)."</td>";
		 $retorno .="<td>".$licenca->estado."</td>";
		 $retorno .="<td>".$status."</td>";
		 if($isArrayLog <> 0){
			 $dataFormatadaArr = explode('-',$dadosLog[0]->data);
			 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
			 $retorno .="<td>".$dadosLog[0]->email."</td>";
			 $retorno .="<td>".$dataFormatada."</td>";
			 $retorno .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";
		 }else{
			$retorno .="<td></td>";
			 $retorno .="<td></td>";
			 $retorno .="<td></td>";
		 }		 
		 $retorno .="</tr>";
		
		
		 
		}
		$retorno .='</table>';
	
	}
	
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $retorno;	
	//echo json_encode($retorno);
	
 }
  function export_est(){	
	
	$id = $this->input->post('id_estado_export');
	$tipo = $this->input->post('tipo');
	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;

	$retorno ='';
	$result = $this->lojas_licencas_model->listarLicencasByEstado($idContratante,$id,$tipo);
	//print_r($this->db->last_query());exit;
	$file="licencas_por_estado.xls";
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$retorno .='</table>';

		
	}else{	

	$retorno="<table border=1>
			<tr>
			<td>Id</td>
			<td>Raz&atilde;o Social</td>
			<td>CPF/CNPJ</td>
			<td>Descri&ccedil;&atilde;o</td>
			<td>Data Vencimento</td>
			<td>Rua</td>
			<td>N&uacute;mero</td>
			<td>Bairro</td>
			<td>Cidade</td>
			<td>Estado</td>
			<td>Ativo</td>
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>
			</tr>
			";
		foreach($result as $key => $licenca){ 
		$dadosLog = $this->lojas_licencas_model->listarLog($licenca->id_licenca);	
		$isArrayLog =  is_array($dadosLog) ? '1' : '0';
		
		if($licenca->status == 0){
			$status ='Ativo';
			$cor = '#009900';
		 }else{
			$status ='Inativo';
			$cor = '#CC0000';
		 }
		$dataVArr = explode("-",$licenca->data_vencimento);									 
		$dataVencto = $dataVArr[2].'/'.$dataVArr[1].'/'.$dataVArr[0];
		 
		 $base = $this->config->base_url().'index.php';
		 $retorno .="<tr style='color:$cor'>";
		 $retorno .="<td>".$licenca->id_licenca."</td>";
		 $retorno .="<td>".utf8_decode($licenca->nome_fantasia)."</td>";
		 $retorno .="<td>".$licenca->cpf_cnpj."</td>";
		 $retorno .="<td>".utf8_decode($licenca->descricao)."</td>";
		 $retorno .="<td>".$dataVencto."</td>";
		 $retorno .="<td>".$licenca->endereco."</td>";
		 $retorno .="<td>".$licenca->numero."</td>";
		 $retorno .="<td>".utf8_decode($licenca->bairro)."</td>";
		 $retorno .="<td>".utf8_decode($licenca->cidade)."</td>";
		 $retorno .="<td>".$licenca->estado."</td>";
		 $retorno .="<td>".$status."</td>";
		 if($isArrayLog <> 0){
			 $dataFormatadaArr = explode('-',$dadosLog[0]->data);
			 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
			 $retorno .="<td>".$dadosLog[0]->email."</td>";
			 $retorno .="<td>".$dataFormatada."</td>";
			 $retorno .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";
		 }else{
			$retorno .="<td></td>";
			 $retorno .="<td></td>";
			 $retorno .="<td></td>";
		 }		 
		 $retorno .="</tr>";
		
		
		 
		}
		$retorno .='</table>';
	
	}

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $retorno;	
	//echo json_encode($retorno);
	
 }
 
 function export_tipo(){	
	
	$id = $this->input->post('id_tipo_export');
	$tipo = $this->input->post('tipo');
	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;

	$retorno ='';
	$result = $this->lojas_licencas_model->listarLicencasByTipo($idContratante,$id,$tipo);
	
	$this->csv($result);	 
	
 }
 
 function export_dias_regiao(){	
	
	$dias = $this->input->get('dias');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;

	$data1 = date('Y-m-d') ;
	$data2 = date('Y-m-d', strtotime("+".$dias." days",strtotime($data1))); 
	  
	$retorno ='';
	$result = $this->lojas_licencas_model->listarLicencasDias($idContratante,$data1,$data2);

	$this->csvGrafico($result);	 
	
 }
 
  function export_status_licenca(){	
	
	$tipo = $this->input->get('tipo');
	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;

	$retorno ='';
	$result = $this->lojas_licencas_model->listarLicencasByStatus($idContratante,$tipo);
	
	$this->csvGrafico($result);	 
	
 }
 
 function csv($result){
	 //print_r($this->db->last_query());exit;
	$file="licencas.xls";
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$retorno .='</table>';

		
	}else{	

	$retorno="<table border=1>
			<tr>
			<td>Id</td>
			<td>Raz&atilde;o Social</td>
			<td>CPF/CNPJ</td>
			<td>Descri&ccedil;&atilde;o</td>
			<td>Data Vencimento</td>
			<td>Status</td>
			<td>Regional</td>
			<td>Rua</td>
			<td>N&uacute;mero</td>
			<td>Bairro</td>
			<td>Cidade</td>
			<td>Estado</td>
			<td>Ativo</td>
			<td>Alterado Por </td>
			<td>Data Altera&ccedil;&atilde;o </td>
			<td>Dados Alterados </td>
			</tr>
			";
		foreach($result as $key => $licenca){ 	
		$dadosLog = $this->lojas_licencas_model->listarLog($licenca->id_licenca);	
		$isArrayLog =  is_array($dadosLog) ? '1' : '0';
		
		if($licenca->status == 0){
			$status ='Ativo';
			$cor = '#009900';
		 }else{
			$status ='Inativo';
			$cor = '#CC0000';
		 }
		$dataVArr = explode("-",$licenca->data_vencimento);									 
		$dataVencto = $dataVArr[2].'/'.$dataVArr[1].'/'.$dataVArr[0];
		 
		 $base = $this->config->base_url().'index.php';
		 $retorno .="<tr style='color:$cor'>";
		 $retorno .="<td>".$licenca->id_licenca."</td>";
		 $retorno .="<td>".utf8_decode($licenca->nome_fantasia)."</td>";
		 $retorno .="<td>".$licenca->cpf_cnpj."</td>";
		 $retorno .="<td>".utf8_decode($licenca->descricao)."</td>";
		 $retorno .="<td>".$dataVencto."</td>";
		 $retorno .="<td>".utf8_decode($licenca->status_licenca)."</td>";
		 $retorno .="<td>".$licenca->descricao_regional."</td>";
		 $retorno .="<td>".utf8_decode($licenca->endereco)."</td>";
		 $retorno .="<td>".$licenca->numero."</td>";
		 $retorno .="<td>".utf8_decode($licenca->bairro)."</td>";
		 $retorno .="<td>".utf8_decode($licenca->cidade)."</td>";
		 $retorno .="<td>".$licenca->estado."</td>";
		 $retorno .="<td>".$status."</td>";
		 if($isArrayLog <> 0){
			 $dataFormatadaArr = explode('-',$dadosLog[0]->data);
			 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
			 $retorno .="<td>".$dadosLog[0]->email."</td>";
			 $retorno .="<td>".$dataFormatada."</td>";
			 $retorno .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";
		 }else{
			$retorno .="<td></td>";
			 $retorno .="<td></td>";
			 $retorno .="<td></td>";
		 }		 
		 $retorno .="</tr>";
		
		
		 
		}
		$retorno .='</table>';
	
	}

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $retorno;	
	//echo json_encode($retorno);
 }	
 
 function csvGrafico($result){
	 //print_r($this->db->last_query());exit;
	$file="licencas.xls";
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		$retorno="<table border=1>
		<tr>
		<td>N&atilde;o H&aacute; Dados Para Esse Filtro</td>
		
		</tr>
		";
		$retorno .='</table>';

		
	}else{	

	$retorno="<table border=1>
			<tr>
			<td>Nome Fantasia</td>
			<td>CPF/CNPJ</td>
			<td>Data Vencimento</td>
			<td>Status</td>
			<td>Regional</td>
			<td>Cidade</td>
			<td>Estado</td>
			</tr>
			";
		foreach($result as $key => $licenca){ 	
		$dadosLog = $this->lojas_licencas_model->listarLog($licenca->id_licenca);	
		$isArrayLog =  is_array($dadosLog) ? '1' : '0';
		
		if($licenca->status == 0){
			$status ='Ativo';
			$cor = '#009900';
		 }else{
			$status ='Inativo';
			$cor = '#CC0000';
		 }
		$dataVArr = explode("-",$licenca->data_vencimento);									 
		$dataVencto = $dataVArr[2].'/'.$dataVArr[1].'/'.$dataVArr[0];
		 
		 $base = $this->config->base_url().'index.php';
		 $retorno .="<tr style='color:$cor'>";
		 $retorno .="<td>".utf8_decode($licenca->nome_fantasia)."</td>";
		 $retorno .="<td>".$licenca->cpf_cnpj."</td>";
		 $retorno .="<td>".$dataVencto."</td>";
		 $retorno .="<td>".utf8_decode($licenca->status_licenca)."</td>";
		 $retorno .="<td>".$licenca->descricao_regional."</td>";
		 $retorno .="<td>".utf8_decode($licenca->cidade)."</td>";
		 $retorno .="<td>".$licenca->estado."</td>";
		 $retorno .="</tr>";
		
		
		 
		}
		$retorno .='</table>';
	
	}

	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $retorno;	
	//echo json_encode($retorno);
 }	
 function buscaLicencaByTipo(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;

	$retorno ='';
	$result = $this->lojas_licencas_model->listarLicencasByTipo($idContratante,$id,$tipo);
	//print_r($result);exit;
	$isArray =  is_array($result) ? '1' : '0';
	if($isArray == 0){
		 $retorno .="<tr >";
		 $retorno .="<td>Sem Dados para o filtro</td>";
		 $retorno .="</tr>";

		
	}else{	
		foreach($result as $key => $licenca){ 			 
		if($licenca->status == 0){
			$status ='Ativo';
			$cor = '#009900';
		 }else{
			$status ='Inativo';
			$cor = '#CC0000';
		 }
		$dataVArr = explode("-",$licenca->data_vencimento);									 
		$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
		 
		 $base = $this->config->base_url().'index.php';
		 $retorno .="<tr style='color:$cor'>";
		 $retorno .="<td width='20%'>".$licenca->nome_fantasia."</td>";
		 $retorno .="<td width='15%'>".$licenca->descricao."</td>";
		 $retorno .="<td width='20%'>".$dataVencto."</td>";
		 $retorno .="<td width='20%'>".$licenca->cidade."</td>";
		 $retorno .="<td width='10%'>".$licenca->estado."</td>";
		 $retorno .="<td width='15%'>";
		 $retorno .="<a href='$base/licencas/editar_loja_licenca?id_licenca=$licenca->id_licenca&id_loja=$licenca->id_loja' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
		 $retorno .="<a href='$base/licencas/inativar?id=$licenca->id_licenca' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
		 $retorno .="<a href='$base/licencas/ativar?id=$licenca->id_licenca' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
		 $retorno .="</td>";
		 $retorno .="</tr>";
		
		
		 
		}
	
	}

	echo json_encode($retorno);
	
 }
function buscaLicenca(){	
	$id = $this->input->get('id');
	$tipo = $this->input->get('tipo');
	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;

	$retorno ='';
	$result = $this->lojas_licencas_model->listarLicencasByEstado($idContratante,$id,$tipo);

	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='7'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	
	foreach($result as $key => $licenca){ 	
	 
	if($licenca->status == 0){
		$status ='Ativo';
		$cor = '#009900';
	 }else{
		$status ='Inativo';
		$cor = '#CC0000';
	 }
	$dataVArr = explode("-",$licenca->data_vencimento);									 
	$dataVencto = $dataVArr[2].'-'.$dataVArr[1].'-'.$dataVArr[0];
	 
	 $base = $this->config->base_url().'index.php';
	 $retorno .="<tr style='color:$cor'>";
		 $retorno .="<td width='20%'>".$licenca->nome_fantasia."</td>";
		 $retorno .="<td width='15%'>".$licenca->descricao."</td>";
		 $retorno .="<td width='20%'>".$dataVencto."</td>";
		 $retorno .="<td width='20%'>".$licenca->cidade."</td>";
		 $retorno .="<td width='10%'>".$licenca->estado."</td>";
		 $retorno .="<td width='15%'>";
	 $retorno .="<a href='$base/licencas/editar_loja_licenca?id_licenca=$licenca->id_licenca&id_loja=$licenca->id_loja' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
	 $retorno .="<a href='$base/licencas/inativar?id=$licenca->id_licenca' class='btn btn-danger btn-xs'><i class='fa fa-trash-o '></i></a>";
	 $retorno .="<a href='$base/licencas/ativar?id=$licenca->id_licenca' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";
	 $retorno .="</td>";
	 $retorno .="</tr>";
	
	
	 
	}
	}
	echo json_encode($retorno);
	
 }
 function buscaEmitente(){	
	$id = $this->input->get('estado');
	$tipo = $this->input->get('tipo');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	
	$retorno ='';
	$result = $this->lojas_licencas_model->listarEmitenteByEstado($id,$idContratante,$tipo);
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha um Emitente</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value='".$iptu->id."'>".$iptu->nome_fantasia."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaEmitenteByCidade(){	
	$cidade = $this->input->get('cidade');
	$tipo = $this->input->get('tipo');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	
	$retorno ='';
	$result = $this->lojas_licencas_model->listarEmitenteByCidade($cidade,$idContratante,$tipo);
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha um Emitente</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value='".$iptu->id."'>".$iptu->nome_fantasia."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function buscaCidade(){	
	$id = $this->input->get('estado');
	$tipo = $this->input->get('tipo');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	
	$retorno ='';
	$result = $this->lojas_licencas_model->listarCidadeByEstado($id,$idContratante,$tipo);
	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $iptu){ 	
		 
			$retorno .="<option value='".$iptu->cidade."'>".$iptu->cidade."</option>";
		 
		}
	
	}
	echo json_encode($retorno);
	
 }
 
 function licencas_vencidas(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];
    $data['tipos_licencas'] = $this->lojas_licencas_model->listarTipoLicenca();
	$data['imoveis'] = $this->lojas_licencas_model->listarLicencasVencidas($idContratante);
	$data['estados'] = $this->lojas_licencas_model->listarEstado($idContratante);
	$data['cidades'] = $this->lojas_licencas_model->listarCidade($idContratante);
	$data['emitentes'] = $this->lojas_licencas_model->listarEmitentesComLicenca($idContratante);
	
	//print_r($data['estados']);exit;
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	$result = $this->lojas_licencas_model->listarLicencasVencidas($idContratante,numRegister4PagePaginate(), $page);
	
	
	////print_r($this->db->last_query());exit;
	//print$session_data['licencaVencida'];exit;
	$data['paginacao'] = createPaginate('licencas', $session_data['licencaVencida']  ) ;
	

	$data['licencas'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_licencas_vencidas_view', $data);

	$this->load->view('footer_pages_view');
	

 }
 
 function listarVencidas_old(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
	
	
	$tipo ='2';			
	$data['perfil'] = $session_data['perfil'];
	
    $data['tipos_licencas'] = $this->lojas_licencas_model->listarTipoLicenca();
	
	//$data['imoveis'] = $this->lojas_licencas_model->listarLicencas($idContratante,$tipo);
	$data['estados'] = $this->lojas_licencas_model->listarEstado($idContratante,$tipo);
	$data['cidades'] = $this->lojas_licencas_model->listarCidade($idContratante,$tipo);
	$data['emitentes'] = $this->lojas_licencas_model->listarEmitentesComLicenca($idContratante,$tipo);
	//print_r($data['estados']);exit;
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	
	$result = $this->lojas_licencas_model->listarLicencas($idContratante,numRegister4PagePaginate(), $page,$tipo);
	
	
	////print_r($this->db->last_query());exit;
	$total = $this->lojas_licencas_model->somarTodosTipo($idContratante,$tipo);
	$data['paginacao'] = createPaginateTipoNao('licencas', $total[0]->total) ;

	$data['tipo'] = $tipo;
	$data['modulo'] = 'licencas';
	$data['licencas'] = $result;

	$data['perfil'] = $session_data['perfil'];

	

	
	if(empty($_SESSION["cidadeLicBD"])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION["cidadeLicBD"];
	}
	if(empty($_SESSION["estadoLicBD"])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] = $_SESSION["estadoLicBD"];
	}
	if(empty($_SESSION["idLojaBD"])){
		$data['idLicBD'] = 0;
	}else{
		$data['idLicBD'] = $_SESSION["idLojaBD"];
	}
	
	$_SESSION["licMod"] = 'listarVencidas';
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_licencas_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 function listarVencidas(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
	$tipo ='2';			
	$data['perfil'] = $session_data['perfil'];
	
    $data['tipos_licencas'] = $this->lojas_licencas_model->listarTipoLicenca();
	

	$data['estados'] = $this->lojas_licencas_model->listarEstado($idContratante,$tipo);
	$data['cidades'] = $this->lojas_licencas_model->listarCidade($idContratante,$tipo);
	$data['emitentes'] = $this->lojas_licencas_model->listarEmitentesComLicenca($idContratante,$tipo);

	$session_data = $_SESSION['login_walmart'];

	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->lojas_licencas_model->listarLicencas($idContratante,$tipo);
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		$tipo_licenca = $_POST['tipo_licenca'];
		
		if($tipo_licenca == 0){
			if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result = $this->lojas_licencas_model->listarLicencasByCidade($idContratante,$municipioListar,$tipo);
			}else if($estadoListar <> '0'){
				$result = $this->lojas_licencas_model->listarLicencasByEstado($idContratante,$estadoListar,$tipo);				
			}else{
				$result = $this->lojas_licencas_model->listarLicencas($idContratante,$tipo);
			}
		}else{	
			$result = $this->lojas_licencas_model->listarLicencasByEmitente($idContratante,$idImovelListar,$tipo);			
		}
		}
		else{	
			$result = $this->lojas_licencas_model->listarLicencasByTipo($idContratante,$tipo_licenca,$tipo);			
		}
		
		
	   
		
	}
	//print_r($this->db->last_query());exit;
	$total = $this->lojas_licencas_model->somarTodosTipo($idContratante,$tipo);
	
	$data['tipo'] = $tipo;
	$data['modulo'] = 'licencas';
	$data['licencas'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$_SESSION["licMod"] =  'listarVencidas';
	$data["licMod"] =  'listarVencidas';
	if(empty($_SESSION["cidadeLicBD"])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION["cidadeLicBD"];
	}
	if(empty($_SESSION["estadoLicBD"])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] = $_SESSION["estadoLicBD"];
	}
	if(empty($_SESSION["idLojaBD"])){
		$data['idLicBD'] = 0;
	}else{
		$data['idLicBD'] = $_SESSION["idLojaBD"];
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_licencas_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
 function listarVigentes(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
	$tipo ='1';			
	$data['perfil'] = $session_data['perfil'];
	
    $data['tipos_licencas'] = $this->lojas_licencas_model->listarTipoLicenca();
	

	$data['estados'] = $this->lojas_licencas_model->listarEstado($idContratante,$tipo);
	$data['cidades'] = $this->lojas_licencas_model->listarCidade($idContratante,$tipo);
	$data['emitentes'] = $this->lojas_licencas_model->listarEmitentesComLicenca($idContratante,$tipo);

	$session_data = $_SESSION['login_walmart'];

	if(empty($_POST)){
		$cidade = '';
		$estado = '';		
		$result = $this->lojas_licencas_model->listarLicencas($idContratante,$tipo);
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result = $this->lojas_licencas_model->listarLicencasByCidade($idContratante,$municipioListar,$tipo);
			}else if($estadoListar <> '0'){
				$result = $this->lojas_licencas_model->listarLicencasByEstado($idContratante,$estadoListar,$tipo);				
			}else{
				$result = $this->lojas_licencas_model->listarLicencas($idContratante,$tipo);
			}
		}else{	
			$result = $this->lojas_licencas_model->listarLicencasByEmitente($idContratante,$idImovelListar,$tipo);			
		}
	   
		
	}

	$total = $this->lojas_licencas_model->somarTodosTipo($idContratante,$tipo);
	
	$data['tipo'] = $tipo;
	$data['modulo'] = 'licencas';
	$data['licencas'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$_SESSION["licMod"] =  'listarVigentes';
	$data["licMod"] =  'listarVigentes';
	if(empty($_SESSION["cidadeLicBD"])){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $_SESSION["cidadeLicBD"];
	}
	if(empty($_SESSION["estadoLicBD"])){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] = $_SESSION["estadoLicBD"];
	}
	if(empty($_SESSION["idLojaBD"])){
		$data['idLicBD'] = 0;
	}else{
		$data['idLicBD'] = $_SESSION["idLojaBD"];
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_licencas_tipo_view', $data);

	$this->load->view('footer_pages_view');
	


 }
 
  function limpar_filtro(){	
  
	$_SESSION["cidadeLicBD"] = 0;
	$_SESSION["estadoLicBD"] = 0;
	$_SESSION["idLojaBD"] = 0;
	
	$modulo = $_SESSION["licMod"];
	
	redirect('/licencas/'.$modulo, 'refresh');	
  
  }
 function listar(){	
 
 if(! $_SESSION['login_walmart']){
		redirect('login', 'refresh');
  }

	$session_data = $_SESSION['login_walmart'];
	$tipo = 'X';
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];
	
    $data['tipos_licencas'] = $this->lojas_licencas_model->listarTipoLicenca();
	//$data['imoveis'] = $this->lojas_licencas_model->listarLicencas($idContratante,$tipo);
	$data['estados'] = $this->lojas_licencas_model->listarEstado($idContratante,$tipo);
	$data['cidades'] = $this->lojas_licencas_model->listarCidade($idContratante,$tipo);
	$data['emitentes'] = $this->lojas_licencas_model->listarEmitentesComLicenca($idContratante,$tipo);
	//print_r($data['estados']);exit;
	$this->load->helper('Paginate_helper');        

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

	$session_data = $_SESSION['login_walmart'];
	//print$tipo;exit;
	$result = $this->lojas_licencas_model->listarLicencas($idContratante,numRegister4PagePaginate(), $page,$tipo);
	
	
	////print_r($this->db->last_query());exit;
	$total = $this->lojas_licencas_model->somarTodos($idContratante);
	$data['paginacao'] = createPaginate('licencas', $total[0]->total) ;

	
	$this->session->set_userdata('licMod', 'listar');
	
	$cidadeBD = $this->session->userdata('cidadeLicBD');
	$estadoBD = $this->session->userdata('estadoLicBD');
	$idLicBD = $this->session->userdata('idLicBD');
	
	if(empty($cidadeBD)){
		$data['cidadeBD'] = 0;
	}else{
		$data['cidadeBD'] = $this->session->userdata('cidadeLicBD');
	}
	if(empty($estadoBD)){
		$data['estadoBD'] = 0;	
	}else{
		$data['estadoBD'] = $this->session->userdata('estadoLicBD');
	}
	if(empty($idLicBD)){
		$data['idLicBD'] = 0;
	}else{
		$data['idLicBD'] = $this->session->userdata('idLicBD');
	}
	

	$data['licencas'] = $result;

	$data['perfil'] = $session_data['perfil'];

	$this->load->view('header_pages_view',$data);

    $this->load->view('listar_licencas_view', $data);

	$this->load->view('footer_pages_view');
	


 }





}


 


?>
