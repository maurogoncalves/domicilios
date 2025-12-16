<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Loja extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('acomp_cnd_model','',TRUE);
   $this->load->model('licenca_model','',TRUE);
   $this->load->model('log_model','',TRUE);
   $this->load->model('tipo_emitente_model','',TRUE);
   $this->load->model('falencia_concordata_model','',TRUE);
	$this->load->model('acoes_civeis_exec_model','',TRUE);
	$this->load->model('tributos_estaduais_model','',TRUE);
	$this->load->model('justica_trabalho_model','',TRUE);
	$this->load->model('justica_federal_model','',TRUE);
	$this->load->model('tributos_mobiliarios_model','',TRUE);
	$this->load->model('tributos_imobiliarios_model','',TRUE);
	$this->load->model('depri_model','',TRUE);
	$this->load->model('fgts_model','',TRUE);
	$this->load->model('divida_ativa_estadual_model','',TRUE);
   
	
   $this->load->model('user','',TRUE);
   $this->load->model('contratante','',TRUE);
   $this->load->model('emitente_model','',TRUE);
   $this->load->model('loja_model','',TRUE);
   $this->load->library('session');
   $this->load->library('form_validation');
   $this->load->helper('url');
   //$this->db->cache_on();
    session_start();
  
 }
 
 function index()
 {
   if( $_SESSION['login_walmart'])
   {
	
     $session_data = $_SESSION['login_walmart'];
     $data['email'] = $session_data['email'];
	 $data['empresa'] = $session_data['empresa'];
	 $data['perfil'] = $session_data['perfil'];
	 
     $this->load->view('home_view', $data);
   }
   else
   {
     
     redirect('login', 'refresh');
   }
 }
 
 function excluir_loja_licenca(){
 
	$id_licenca = $this->input->get('id_licenca');
	$id_loja = $this->input->get('id_loja');
	if($this->loja_model->excluir_loja_licenca($id_licenca)) {
		$_SESSION['mensagemLoja'] =  CADASTRO_APAGADO;
	}else{	
		$_SESSION['mensagemLoja'] =  ERRO;
	}
	redirect('/loja/licencas?id='.$id_loja, 'refresh');	
 }
 
 
 
 function inserir_licenca_loja(){
 
 if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$id = $this->input->post('id');
	$tipo_licenca = $this->input->post('tipo_licenca');
	$data_vencto = $this->input->post('data_vencto');	
	$arrDataVencto = explode("/",$data_vencto);
	$dataVencto = $arrDataVencto[2].'-'.$arrDataVencto[1].'-'.$arrDataVencto[0];
	$observacoes = $this->input->post('observacoes');	
	
	if($tipo_licenca == 0){
		echo "<script>alert('Escolha um tipo de licença'); window.history.go(-1);</script>";
		exit;
	}
	
	$dados = array(	'id_loja' => $id,
					'tipo_licenca_taxa' => $tipo_licenca,
					'data_vencimento' => $dataVencto,
					'observacoes' => $observacoes,
				);
	if($this->loja_model->add_licenca($dados)) {
		$this->db->cache_off();
		$_SESSION['mensagemLoja'] =  CADASTRO_FEITO;
	}else{	
		$_SESSION['mensagemLoja'] =  CADASTRO_APAGADO;
	}
	redirect('/loja/licencas?id='.$id, 'refresh');	
 }
 
   function buscaInscricao(){
	$inscricao = $this->input->get('inscricao');
	$emitente = $this->input->get('emitente');
	
	$tem = $this->loja_model->buscaInscricao($inscricao,$emitente);
	
	$obj = array();
	$obj['total']=$tem[0]->total;
	echo json_encode($obj);

	} 
	
 function cadastrar(){

	$data['regionais'] = $this->loja_model->listarRegional();
	$data['bandeiras'] = $this->loja_model->listarBandeira();
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	$data['emitentes'] = $this->loja_model->listarEmitentes($idContratante);
	$data['estados'] = $this->loja_model->buscaEstado($idContratante);
	
	$data['cidades'] = $this->loja_model->buscaCidades($idContratante);
	$data['tipo_emitentes'] = $this->tipo_emitente_model->listarTipoEmitente();
	
 	$data['perfil'] = $session_data['perfil'];
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('cadastrar_loja_view', $data);
	$this->load->view('footer_pages_view');
	
 }
 
  function buscaCPFCNPJ(){	
	$id = $this->input->get('emitente');
	
	$retorno ='';
	$result = $this->loja_model->buscaCPFCNPJ($id);
	
	
	if(empty($result[0]->cpf_cnpj)){
		echo json_encode(0);
	}else{
		echo json_encode($result[0]->cpf_cnpj);
	}	
	
	
	
 }
 
 function buscaEmitente(){	
	$id = $this->input->get('id_estado');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaEmitente($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha</option>";
		foreach($result as $key => $imovel){ 	
		 
			$retorno .="<option value='".$imovel->id."'>".$imovel->nome_fantasia."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 
 function buscaEmitenteByCidade(){	
	$id = $this->input->get('id_cidade');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaEmitenteByCidade($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha</option>";
		foreach($result as $key => $imovel){ 	
			if($imovel->matriz_filial == 1){
				$retorno .="<option value='".$imovel->id."'>".$imovel->nome_fantasia." - Matriz</option>";
			}else{
				$retorno .="<option value='".$imovel->id."'>".$imovel->nome_fantasia." - Filial</option>";
			}	
			
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
  function buscaLojaByCidade(){	
	$id = $this->input->get('id');
	$status = $this->input->get('status');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaLojaByCidadeFiltro($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Loja</option>";
		foreach($result as $imovel){ 	
		 
			$retorno .="<option value='".$imovel->id."'>".$imovel->razao_social."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 
  function buscaBandeira(){	
	$id = $this->input->get('id');
	
	$estado = $this->input->get('estado');
	$municipio = $this->input->get('municipio');
	$imovel = $this->input->get('imovel');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaLojaByBandeira($idContratante,$id,$estado,$municipio,$imovel);
	
$isArray =  is_array($result) ? '1' : '0';
	
	$base = $this->config->base_url();
	$base .='index.php';
	
	if($isArray == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$retorno .="</tr>";
	}else{
		foreach($result as $imovel){ 
			$id_loja = $imovel['id_loja'];
			$id_cnd = $imovel['id_cnd'];
			if(empty($imovel['cnd'])){	
				$cnd ='Nada Consta';
				$corCnd = '#990000';										 
			}else{
				if($imovel['cnd'] == 1){
					$cnd ='Sim';
					$corCnd = '#000099';										
				}elseif($imovel['cnd'] == 2){
					$cnd ='N&atilde;o';
					$corCnd = '#000099';
				}elseif($imovel['cnd'] == 3){
					$cnd ='Pend&ecirc;ncia';
					$corCnd = '#000099';
				}else{
					$cnd ='Nada Consta';
					$corCnd = '#990000';
				}
			}
									
			$retorno .="<tr>";
			
			$retorno .="<td width='22%' >";
				if( $cnd <> 'Nada Consta') {
					$retorno .="<a href='$base/cnd_mob/editar?id=$id_cnd' >".$imovel['razao_social']."</a>";
				}else{
					$retorno .="<a href='$base/cnd_mob/cadastrar?id=$id_cnd' >".$imovel['razao_social']."</a>";
				}
			$retorno .="</td>";
			
			$retorno .="<td width='18%' > <a href='#'>".$imovel['cpf_cnpj']."</a></td>";
			$retorno .="<td width='20%' > ".$imovel['tipo_emitente']."</td>";
			$retorno .="<td width='10%' > ".$imovel['descricao_bandeira']."</td>";
			$retorno .="<td width='15%' > ".$cnd."</td>";
			$retorno .="<td width='15%' >";
			
			$retorno .="<a href='$base/loja/ativar?id=$id_loja' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/loja/editar?id=$id_loja' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="<a href='$base/loja/excluir?id=$id_loja' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";										  
			$retorno .="</td>";
			$retorno .="</tr>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
 }	
 
  function buscaStatus(){	
	$id = $this->input->get('id');
	
	$estado = $this->input->get('estado');
	$municipio = $this->input->get('municipio');
	$imovel = $this->input->get('imovel');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaLojaByStatus($idContratante,$id,$estado,$municipio,$imovel);
	$isArray =  is_array($result) ? '1' : '0';
	
	$base = $this->config->base_url();
	$base .='index.php';
	
	if($isArray == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$retorno .="</tr>";
	}else{
		foreach($result as $imovel){ 
			$id_loja = $imovel['id_loja'];
			$id_cnd = $imovel['id_cnd'];

			if($imovel['cnd'] == 1){
				$cnd ='Sim';
				$corCnd = '#000099';										
			}elseif($imovel['cnd'] == 2){
				$cnd ='N&atilde;o';
				$corCnd = '#000099';
			}elseif($imovel['cnd'] == 3){
				$cnd ='Pend&ecirc;ncia';
				$corCnd = '#000099';
			}else{
				$cnd ='Nada Consta';
				$corCnd = '#990000';
			}
									
			$retorno .="<tr>";
			
			$retorno .="<td width='22%' >";
				if( $cnd <> 'Nada Consta') {
					$retorno .="<a href='$base/cnd_mob/editar?id=$id_cnd' >".$imovel['razao_social']."</a>";
				}else{
					$retorno .="<a href='$base/cnd_mob/cadastrar?id=$id_cnd' >".$imovel['razao_social']."</a>";
				}
			$retorno .="</td>";
			
			$retorno .="<td width='18%' > <a href='#'>".$imovel['cpf_cnpj']."</a></td>";
			$retorno .="<td width='20%' > ".$imovel['tipo_emitente']."</td>";
			$retorno .="<td width='10%' > ".$imovel['descricao_bandeira']."</td>";
			$retorno .="<td width='15%' > ".$cnd."</td>";
			$retorno .="<td width='15%' >";
			
			$retorno .="<a href='$base/loja/ativar?id=$id_loja' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/loja/editar?id=$id_loja' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="<a href='$base/loja/excluir?id=$id_loja' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";										  
			$retorno .="</td>";
			$retorno .="</tr>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
 }	
 
 function buscaLoja(){	
	$id = $this->input->get('id');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaLojaById($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	$base = $this->config->base_url();
	$base .='index.php';
	
	if($isArray == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$retorno .="</tr>";
	}else{
		foreach($result as $imovel){ 
			$id_loja = $imovel['id_loja'];
			$id_cnd = $imovel['id_cnd'];
			if(empty($imovel['cnd'])){	
				$cnd ='Nada Consta';
				$corCnd = '#990000';										 
			}else{
				if($imovel['cnd'] == 1){
					$cnd ='Sim';
					$corCnd = '#000099';										
				}elseif($imovel['cnd'] == 2){
					$cnd ='N&atilde;o';
					$corCnd = '#000099';
				}elseif($imovel['cnd'] == 3){
					$cnd ='Pend&ecirc;ncia';
					$corCnd = '#000099';
				}else{
					$cnd ='Nada Consta';
					$corCnd = '#990000';
				}
			}
									
			$retorno .="<tr>";
			
			$retorno .="<td width='22%' >";
				if( $cnd <> 'Nada Consta') {
					$retorno .="<a href='$base/cnd_mob/editar?id=$id_cnd' >".$imovel['razao_social']."</a>";
				}else{
					$retorno .="<a href='$base/cnd_mob/cadastrar?id=$id_loja' >".$imovel['razao_social']."</a>";
				}
			$retorno .="</td>";
			
			$retorno .="<td width='18%' > ".$imovel['cpf_cnpj']."</td>";
			$retorno .="<td width='20%' > ".$imovel['tipo_emitente']."</td>";
			$retorno .="<td width='10%' > ".$imovel['descricao_bandeira']."</td>";
			$retorno .="<td width='15%' > ".$cnd."</td>";
			$retorno .="<td width='15%' >";
			
			$retorno .="<a href='$base/loja/ativar?id=$id_loja' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/loja/editar?id=$id_loja' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="<a href='$base/loja/excluir?id=$id_loja' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";										  
			$retorno .="</td>";
			$retorno .="</tr>";
		 
		}
	
	}

	echo json_encode($retorno);
	
	
	
 }

 function buscaLojasByCidade(){	
	$id = $this->input->get('id');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaLojaByCidade($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	$base = $this->config->base_url();
	$base .='index.php';
	
	if($isArray == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$retorno .="</tr>";
	}else{
		foreach($result as $imovel){ 
			$id_loja = $imovel['id_loja'];
			$id_cnd = $imovel['id_cnd'];
			if(empty($imovel['cnd'])){	
				$cnd ='Nada Consta';
				$corCnd = '#990000';										 
			}else{
				if($imovel['cnd'] == 1){
					$cnd ='Sim';
					$corCnd = '#000099';										
				}elseif($imovel['cnd'] == 2){
					$cnd ='N&atilde;o';
					$corCnd = '#000099';
				}elseif($imovel['cnd'] == 3){
					$cnd ='Pend&ecirc;ncia';
					$corCnd = '#000099';
				}else{
					$cnd ='Nada Consta';
					$corCnd = '#990000';
				}
			}
									
			$retorno .="<tr>";
			
			$retorno .="<td width='22%' >";
				if( $cnd <> 'Nada Consta') {
					$retorno .="<a href='$base/cnd_mob/editar?id=$id_cnd' >".$imovel['razao_social']."</a>";
				}else{
					$retorno .="<a href='$base/cnd_mob/cadastrar?id=$id_loja' >".$imovel['razao_social']."</a>";
				}
			$retorno .="</td>";
			
			$retorno .="<td width='18%' > ".$imovel['cpf_cnpj']."</td>";
			$retorno .="<td width='20%' > ".$imovel['tipo_emitente']."</td>";
			$retorno .="<td width='10%' > ".$imovel['descricao_bandeira']."</td>";
			$retorno .="<td width='15%' > ".$cnd."</td>";
			$retorno .="<td width='15%' >";
			
			$retorno .="<a href='$base/loja/ativar?id=$id_loja' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/loja/editar?id=$id_loja' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="<a href='$base/loja/excluir?id=$id_loja' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";										  
			$retorno .="</td>";
			$retorno .="</tr>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 function buscaLojasByEstado(){	
	$id = $this->input->get('id');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaLojaByEstado($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	$base = $this->config->base_url();
	$base .='index.php';
	
	if($isArray == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='5'> Não Há Dados </td>";
		$retorno .="</tr>";
	}else{
		foreach($result as $imovel){ 
			$id_loja = $imovel['id_loja'];
			$id_cnd = $imovel['id_cnd'];
			if(empty($imovel['cnd'])){	
				$cnd ='Nada Consta';
				$corCnd = '#990000';										 
			}else{
				if($imovel['cnd'] == 1){
					$cnd ='Sim';
					$corCnd = '#000099';										
				}elseif($imovel['cnd'] == 2){
					$cnd ='N&atilde;o';
					$corCnd = '#000099';
				}elseif($imovel['cnd'] == 3){
					$cnd ='Pend&ecirc;ncia';
					$corCnd = '#000099';
				}else{
					$cnd ='Nada Consta';
					$corCnd = '#990000';
				}
			}
									
			$retorno .="<tr>";
			
			$retorno .="<td width='22%' >";
				if( $cnd <> 'Nada Consta') {
					$retorno .="<a href='$base/cnd_mob/editar?id=$id_cnd' >".$imovel['razao_social']."</a>";
				}else{
					$retorno .="<a href='$base/cnd_mob/cadastrar?id=$id_loja' >".$imovel['razao_social']."</a>";
				}
			$retorno .="</td>";
			
			$retorno .="<td width='18%' > ".$imovel['cpf_cnpj']."</td>";
			$retorno .="<td width='20%' > ".$imovel['tipo_emitente']."</td>";
			$retorno .="<td width='10%' > ".$imovel['descricao_bandeira']."</td>";
			$retorno .="<td width='15%' > ".$cnd."</td>";
			$retorno .="<td width='15%' >";
			
			$retorno .="<a href='$base/loja/ativar?id=$id_loja' class='btn btn-success btn-xs'><i class='fa fa-check'></i></a>";
			$retorno .="<a href='$base/loja/editar?id=$id_loja' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";
			$retorno .="<a href='$base/loja/excluir?id=$id_loja' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";										  
			$retorno .="</td>";
			$retorno .="</tr>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 function buscaLojaByEstado(){	
	$id = $this->input->get('id');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaLojaByEstado($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Loja</option>";
		foreach($result as $imovel){ 	
		 
			$retorno .="<option value='".$imovel['id']."'>".$imovel['razao_social']."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 
 function buscaCidadeByEstado(){	
	$id = $this->input->get('estado');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaCidade($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $imovel){ 	
		 
			$retorno .="<option value='".$imovel->cidade."'>".$imovel->cidade."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 
 function buscaLojaByEstadoTipo(){	
	$id = $this->input->get('id_estado');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaLojaByEstadoTipo($idContratante,$id,1);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Loja</option>";
		foreach($result as $key => $loja){ 	
		 
			$retorno .="<option value='".$loja['id']."'>".$loja['nome_fantasia']."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 
  function buscaLojaByCidadeTipo(){	
	$id = $this->input->get('id_cidade');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaLojaByCidadeTipo($idContratante,$id,1);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Loja</option>";
		foreach($result as $key => $loja){ 	
		 
			$retorno .="<option value='".$loja['id']."'>".$loja['nome_fantasia']."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 
  function buscaCidadeByEstadoTipo(){	
	$id = $this->input->get('id_estado');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaCidadeByEstadoTipo($idContratante,$id,1);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $loja){ 	
		 
			$retorno .="<option value='".$loja['cidade']."'>".$loja['cidade']."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 
 function buscaCidadeImByEstado(){	
	$id = $this->input->get('id_estado');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaCidadeImByEstado($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $imovel){ 	
		 
			$retorno .="<option value='".$imovel->cidade."'>".$imovel->cidade."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 
 function buscaCidade(){	
	$id = $this->input->get('id_estado');
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;	
	
	$retorno ='';
	$result = $this->loja_model->buscaCidade($idContratante,$id);
	
	$isArray =  is_array($result) ? '1' : '0';
	
	if($isArray == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{
	
		$retorno .="<option value=0>Escolha uma Cidade</option>";
		foreach($result as $key => $imovel){ 	
		 
			$retorno .="<option value='".$imovel->cidade."'>".$imovel->cidade."</option>";
		 
		}
	
	}
	
	echo json_encode($retorno);
	
	
	
 }
 
  function busca(){	
	$id = $this->input->get('emitente');	
	$retorno ='';	
	$result = $this->loja_model->buscaImovel($id);	
	$isArray =  is_array($result) ? '1' : '0';	
	if($isArray == 0){		
		$retorno .="<option value='0'>Não Há Dados</option>";	
	}else{			
		foreach($result as $key => $imovel){ 			 			
		$retorno .="<option value='".$imovel->id."'>".$imovel->nome."</option>";		 		
		}	
	}
	echo json_encode($retorno);
 }
 
 function excluir(){
 
	$id = $this->input->get('id');
	$session_data = $_SESSION['login_walmart'];
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	
	if($podeExcluir[0]['total'] == 1){
		
		$this->loja_model->excluirFisicamente($id);
		$_SESSION['mensagemImovel'] =  CADASTRO_INATIVO;
		
	}else{
		if($this->loja_model->excluir($id)) {
			$_SESSION['mensagemLoja'] =  CADASTRO_INATIVO;
		}else{	
			$_SESSION['mensagemLoja'] =  ERRO;

		}
	
	}	
	
	
	redirect('/loja/listar', 'refresh');
	
 }
 
 function ativar(){
 
	$id = $this->input->get('id');
	
	if($this->loja_model->ativar($id)) {		
		$_SESSION['mensagemLoja'] =  CADASTRO_ATIVO;
	}else{	
		$_SESSION['mensagemLoja'] =  ERRO;
	}
	
	
	redirect('/loja/listar', 'refresh');
	
 }
 
 function cadastrar_loja(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$emitente = $this->input->post('id_emitente');	
	$imovel = $this->input->post('id_imovel');	
	$cod1 = $this->input->post('cod1');	
	$cod1 = $this->input->post('cod1');	
	$cod2 = $this->input->post('cod2');	
	$bandeira = $this->input->post('bandeira');	
	$cc = $this->input->post('cc');	
	$cep = $this->input->post('cep');	
	$numero = $this->input->post('numero');	
	$logradouro = $this->input->post('logradouro');	
	$bairro = $this->input->post('bairro');	
	$cidade = $this->input->post('cidade');	
	$estado = $this->input->post('estado');	
	$regional = $this->input->post('regional');	
	$insc = $this->input->post('insc');	

	if(empty($emitente)){
		$_SESSION['mensagemLoja'] =  'ESCOLHA UM EMITENTE';
		redirect('/loja/cadastrar', 'refresh');
	}else{
		
	$dados = array('id_contratante' => $idContratante,
						'id_emitente' => $emitente,
						'id_imovel' => $imovel,
						'cod1' => $cod1,
						'cod2' => $cod2,
						'bandeira' => $bandeira,
						'cc' => $cc,
						'cep' => $cep,
						'numero' => $numero,
						'endereco' => $logradouro,
						'bairro' => $bairro,
						'cidade' => $cidade,
						'estado' => $estado,
						'regional' => $regional,
						'ins_cnd_mob' => $insc
	);
	

	$id = $this->loja_model->add($dados);
	
	$dados = array(
			'id_loja' => $id,
			'id_contratante' => $idContratante,
			'possui_cnd' => 3
		);
	
	$this->falencia_concordata_model->add($dados);
	$this->acoes_civeis_exec_model->add($dados);
	$this->tributos_estaduais_model->add($dados);
	$this->justica_trabalho_model->add($dados);
	$this->justica_federal_model->add($dados);
	$this->tributos_mobiliarios_model->add($dados);
	$this->tributos_imobiliarios_model->add($dados);
	$this->depri_model->add($dados);	
	$this->fgts_model->add($dados);	
	$this->divida_ativa_estadual_model->add($dados);	
	
		
	$_SESSION['mensagemLoja'] =  ERRO;
	
	redirect('/loja/listar', 'refresh');
		
	
	
	}
	
				
 }
 function licencas(){
	 $id = $this->input->get('id');
	 $data['regionais'] = $this->loja_model->listarRegional();
	 $session_data = $_SESSION['login_walmart'];
	 $idContratante = $_SESSION['cliente'] ;
	 $data['tipos_licencas'] = $this->licenca_model->listarTipoLicenca();	
	 
	 if(empty($_SESSION['mensagemLoja'])){
		 $data['mensagemLoja'] = '';			
	 }else{
		 $data['mensagemLoja'] = $_SESSION['mensagemLoja'];
	 }
	 
	 if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	 
	 $data['dados_licenca'] = $this->loja_model->listarLicencaLoja($id,0);

	$this->load->view('header_pages_view',$data);
    $this->load->view('lojas_licencas_view', $data);
	$this->load->view('footer_pages_view');
 }
 
  function acomp(){
  	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	 $id = $this->input->get('id');
	 
	 $data['tipos_licencas'] = $this->licenca_model->listarTipoLicenca();	
	 $data['areas'] = $this->acomp_cnd_model->listarAreas();
	 $data['projetos'] = $this->acomp_cnd_model->listarNomeProjetos($idContratante);
	 	 
	 $data['dados_acomp'] = $this->loja_model->listarAcomp($idContratante,$id);
		if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}

	 $data['tipo_acomp'] = $this->acomp_cnd_model->listarTipoAcomp();
	 $this->load->view('header_pages_view',$data);
	 $this->load->view('lojas_acomp_view', $data);
	 $this->load->view('footer_pages_view');	
 }
 function editar_loja_acomp(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	 $id_acomp = $this->input->get('id_acomp');
	 $id_loja = $this->input->get('id_loja');
	 $data['tipos_licencas'] = $this->licenca_model->listarTipoLicenca();	
	 $data['areas'] = $this->acomp_cnd_model->listarAreas();
	 $data['subareas'] = $this->acomp_cnd_model->listarSubArea(0);
	 $data['etapas'] = $this->acomp_cnd_model->listarEtapa(0);
	 $data['tipoDebito'] = $this->acomp_cnd_model->tipoDebito(0);
	 $data['tipo_acomp'] = $this->acomp_cnd_model->listarTipoAcomp();
	 $data['dados_acomp'] = $this->loja_model->listarAcompById($id_acomp,$id_loja);
	 $data['projetos'] = $this->acomp_cnd_model->listarNomeProjetos($idContratante);
	 $this->load->view('header_view',$data);
	 $this->load->view('editar_lojas_acomp_view', $data);
	 $this->load->view('footer_view');	

 }
 
 function enviar_acomp(){
		$id = $this->input->post('id');
		$loja = $this->input->post('loja');
		$file = $_FILES["userfile"]["name"];
		
		$extensao = str_replace('.','',strrchr($file, '.'));
		
		
		$base = base_url();
		
        $config['upload_path'] = './assets/acomp_cnd/';
		$config['allowed_types'] = '*';
		
		$config['file_name'] = $id.'-'.$loja.'.'.$extensao;
		$config['overwrite'] = 'true';	
		$this->load->library('upload', $config);
		

		
		$this->upload->initialize($config);
		$field_name = "userfile";
		
		$dadosArquivo = $this->loja_model->listarAcompById($id,$loja);
		if($dadosArquivo[0]->arquivo){
			$b = getcwd();

			$a = @unlink($b.'/assets/acomp_cnd/'.$dadosArquivo[0]->arquivo);
		}
		
		if ( ! $this->upload->do_upload($field_name)){

			$error = array('error' => $this->upload->display_errors());
			$_SESSION['mensagemLoja'] =  ERRO;
		}else{
			$dados = array(
			'arquivo' => $id.'-'.$loja.'.'.$extensao
			);
				
			$this->loja_model->atualizar_arquivo_acomp($dados,$id,$loja);
			$data = array('upload_data' => $this->upload->data($field_name));
			$_SESSION['mensagemLoja'] =  UPLOAD;
			
		}
		
		redirect('/loja/acomp?id='.$loja, 'refresh');
		
 }
 
  function upload_loja_acomp(){
	 $id_acomp = $this->input->get('id_acomp');
	 $id_loja = $this->input->get('id_loja');
	 $data['tipos_licencas'] = $this->licenca_model->listarTipoLicenca();	
	 $data['areas'] = $this->acomp_cnd_model->listarAreas();
	 $data['subareas'] = $this->acomp_cnd_model->listarSubArea(0);
	 $data['etapas'] = $this->acomp_cnd_model->listarEtapa(0);
	 $data['tipoDebito'] = $this->acomp_cnd_model->tipoDebito(0);
	 $data['tipo_acomp'] = $this->acomp_cnd_model->listarTipoAcomp();
	 $data['dados_acomp'] = $this->loja_model->listarAcompById($id_acomp,$id_loja);
	 $this->load->view('header_view',$data);
	 $this->load->view('upload_loja_acomp_view', $data);
	 $this->load->view('footer_view');	

 }
 

 function atualizar_loja(){
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->post('id');
	$idUsuario = $session_data['id'];
	$emitente = $this->input->post('id_emitente');	
	$id_imovel = $this->input->post('id_imovel');	
	$cod1 = $this->input->post('cod1');	
	$cod2 = $this->input->post('cod2');	
	$bandeira = $this->input->post('bandeira');	
	$cc = $this->input->post('cc');	
	$cep = $this->input->post('cep');	
	$numero = $this->input->post('numero');	
	$logradouro = $this->input->post('logradouro');	
	$bairro = $this->input->post('bairro');	
	$cidade = $this->input->post('cidade');	
	$estado = $this->input->post('estado');	
	$regional = $this->input->post('regional');	
	$insc = $this->input->post('insc');	

	
	$dados = array('id_contratante' => $idContratante,
		'id_emitente' => $emitente,
		'id_imovel' => $id_imovel,
		'cod1' => $cod1,
		'cod2' => $cod2,
		'bandeira' => $bandeira,
		'cc' => $cc,
		'cep' => $cep,
		'numero' => $numero,
		'endereco' => $logradouro,
		'bairro' => $bairro,
		'cidade' => $cidade,
		'estado' => $estado,
		'regional' => $regional,
		'ins_cnd_mob' => $insc,
		'id' => $id
	);
			
	$dadosAtuais = $this->loja_model->listarLojaById($id);
	
	$dadosBandeira = $this->loja_model->listarBandeiraById($dadosAtuais[0]->bandeira);
	$dadosEmitente = $this->loja_model->listarEmitenteById($idContratante,$dadosAtuais[0]->id_emitente);
	$dadosImovel = $this->loja_model->listarImovelById($dadosAtuais[0]->id_imovel);
	
	$dadosAlterados = '';
	
	
	if($dadosAtuais[0]->id_emitente <> $emitente){
		$dadosAlterados .= ' - Razão Social: '.$dadosEmitente[0]->razao_social;	
	}
	
	if($dadosAtuais[0]->id_imovel <> $id_imovel){
		$dadosAlterados .= ' - Imóvel: '.$dadosImovel[0]->nome;	
	}
	
	
	if($dadosAtuais[0]->cod1 <> $cod1){
		$dadosAlterados .= ' - Cod1: '.$dadosAtuais[0]->cod1;	
	}
	
	if($dadosAtuais[0]->cod2 <> $cod2){
		$dadosAlterados .= ' - Cod2: '.$dadosAtuais[0]->cod2;	
	}
	
	if($dadosAtuais[0]->bandeira <> $bandeira){		if(empty($dadosBandeira[0]->descricao_bandeira)){			$dadosAlterados .= ' - Bandeira: '.utf8_decode('Sem Descrição');		
					}else{			$dadosAlterados .= ' - Bandeira: '.utf8_decode($dadosBandeira[0]->descricao_bandeira);			}	
	}
	
	if($dadosAtuais[0]->cc <> $cc){
		$dadosAlterados .= ' - Centro de Custo: '.$dadosAtuais[0]->cc;	
	}
	
	if($dadosAtuais[0]->cep <> $cep){
		$dadosAlterados .= ' - CEP: '.$cep;
		$dadosAlterados .= ' - Rua: '.$dadosAtuais[0]->endereco;
		$dadosAlterados .= ' - Bairro: '.$dadosAtuais[0]->bairro;
		$dadosAlterados .= ' - Cidade: '.$dadosAtuais[0]->cidade;
		$dadosAlterados .= ' - Estado: '.$dadosAtuais[0]->estado;
	}
	
	if($dadosAtuais[0]->numero <> $numero){
		$dadosAlterados .= ' - Número: '.$dadosAtuais[0]->numero;	
	}

	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'loja',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => utf8_encode($dadosAlterados),
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	
	if($this->loja_model->atualizar($dados,$id)) {
		

		$_SESSION['mensagemLoja'] =  CADASTRO_ATUALIZADO;
		
		$_SESSION["cidadeLojaBD"] = $cidade;
		$_SESSION["estadoLojaBD"] = $estado;
		$_SESSION["idLojaBD"] = $id;

		redirect('/loja/listar', '');
	
	}else{	
		
		$_SESSION['mensagemLoja'] =  CADASTRO_INATIVO;
		
		$_SESSION["cidadeLojaBD"] = 0;
		$_SESSION["estadoLojaBD"] = 0;
		$_SESSION["idLojaBD"] = 0;
		
		redirect('/loja/listar', 'refresh');
	}
	
	
	
				
 }
 
 
 function limpar_filtro(){	
 		
		$_SESSION["cidadeLojaBD"] = 0;
		$_SESSION["estadoLojaBD"] = 0;
		$_SESSION["idLojaBD"] = 0;
		$_SESSION["status"]=0;
		redirect('/loja/listar', '');

}
 
 
  function editar(){	
	$id = $this->input->get('id');
	$data['regionais'] = $this->loja_model->listarRegional();
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$data['emitentes'] = $this->loja_model->listarTodosEmitentes($idContratante);
	$data['estados'] = $this->loja_model->buscaEstado($idContratante);
	$data['cidades'] = $this->loja_model->buscaCidades($idContratante);
	$data['bandeiras'] = $this->loja_model->listarBandeira();

	$result = $this->loja_model->listarLojaById($id);
	
	$_SESSION["cidadeLojaBD"] = $result[0]->cidade;
	$_SESSION["estadoLojaBD"] = $result[0]->estado;
	$_SESSION["idLojaBD"] = $result[0]->id;
	
	if(empty($_SESSION["mensagemLoja"])){
		$data['mensagemLoja'] = '';
	}else{
		$data['mensagemLoja'] = $_SESSION['mensagemLoja'];
	}
	
	$data['dados_loja'] = $result;

	$data['perfil'] = $session_data['perfil'];
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$this->load->view('header_pages_view',$data);
    $this->load->view('editar_loja_view', $data);
	$this->load->view('footer_pages_view');
	
	
 
 }
  function export_mun(){	
		
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$id = $this->input->post('id_mun_export');	
	$id_status = $this->input->post('id_status');	
	$result = $this->loja_model->listarLojaCsvMun($idContratante,$id,$id_status);
	
	$this->csv($result);
		
 }
 
 function csv($result){
	 
	 $file="lojas.xls";

				
		$test="<table border=1>
		<tr>
		<td>Id</td>
		<td>Razão Social</td>
		<td>CPF/CNPJ</td>
		<td>Inscri&ccedil;&atilde;o Mobili&aacute;ria</td>
		<td>Inscri&ccedil;&atilde;o Estadual</td>
		<td>Regional</td>
		<td>Cód 1</td>
		<td>Cód 2</td>
		<td>Centro de Custo</td>
		<td>Bandeira</td>
		<td>Tipo de Emitente</td>
		<td>CND Mobili&aacute;ria</td>
		<td>CND Estadual</td>
		<td>CND Federal</td>
		<td>CEP</td>
		<td>N&uacute;mero</td>
		<td>Endere&ccedil;o</td>
		<td>Bairro</td>
		<td>Cidade</td>
		<td>Estado</td>
		<td>Status</td>
		<td>Alterado Por </td>
		<td>Data Altera&ccedil;&atilde;o </td>
		<td>Dados Alterados </td>	
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
			  $dadosLog = $this->log_model->listarLog($emitente->id,'loja');				
			  $isArrayLog =  is_array($dadosLog) ? '1' : '0';

				if($emitente->ativo == 1){
					$ativo='Ativo';
				}else{
					$ativo='Inativo';
				}

				
				$arrayCndMob = $this->loja_model->buscaCNDMobById($emitente->id_loja);
				
				
				if($arrayCndMob[0]['total'] <> 0) {			
					if($arrayCndMob[0]['possui_cnd'] == 1){
							$cndMob = 'Sim';
							$dataFormatadaArr = explode('-',$arrayCndMob[0]['data_vencto']);
							$data  = $dataFormatadaArr[2].'-'.$dataFormatadaArr[1].'-'.$dataFormatadaArr[0] ;
						}elseif($arrayCndMob[0]['possui_cnd'] == 2){
							$cndMob ='Não';
							$dataFormatadaArr = explode('-',$arrayCndMob[0]['data_vencto']);
							$data  = $dataFormatadaArr[2].'-'.$dataFormatadaArr[1].'-'.$dataFormatadaArr[0] ;
						}else{
							$cndMob='Pend&ecirc;ncia';
							$dataFormatadaArr = explode('-',$arrayCndMob[0]['data_pendencias']);
							$data  = $dataFormatadaArr[2].'-'.$dataFormatadaArr[1].'-'.$dataFormatadaArr[0] ;
						}
				}else{
					$cndMob = 'Nada Consta ';
				}
				
				
				$arrayCndEst = $this->loja_model->buscaCNDEstByIdCSV($emitente->id_loja);
				$j = 1;
				$cndEstadual = '';
				$inscricao = '';
				$isArrayCndEst =  is_array($arrayCndEst) ? '1' : '0';	
				if($isArrayCndEst <> 0) {			
					foreach($arrayCndEst as $cnd_est){
						if($cnd_est['possui_cnd'] == 1){
							$cndEstadual .= 'Sim <BR>';
							$inscricao .= $cnd_est['inscricao'];
						}elseif($cnd_est['possui_cnd'] == 2){
							$cndEstadual .='Não <BR>';
							$inscricao .= $cnd_est['inscricao'];
						}else{
							$cndEstadual.='Pend&ecirc;ncia <BR>';
							$inscricao .= $cnd_est['inscricao'];
						}
						$j++;
					}
				}else{
					$cndEstadual = 'Nada Consta';
				}
				
		
				$test .= "<tr>";
				$test .= "<td>".utf8_decode($emitente->id_loja)."</td>";
				$test .= "<td>".utf8_decode($emitente->nome)."</td>";
				$test .= "<td>".utf8_decode($emitente->cpf_cnpj)."</td>";
				$test .= "<td>"."'".utf8_decode($emitente->ins_cnd_mob)."'"."</td>";
				$test .= "<td>"."'".utf8_decode($inscricao)."'"."</td>";
				$test .= "<td>".utf8_decode($emitente->regional)."</td>";
				$test .= "<td>".utf8_decode($emitente->cod1)."</td>";
				$test .= "<td>"."'".utf8_decode($emitente->cod2)."'"."</td>";
				$test .= "<td>".utf8_decode($emitente->cc)."</td>";
				$test .= "<td>".utf8_decode($emitente->descricao_bandeira)."</td>";
				$test .= "<td>".utf8_decode($emitente->descricao)."</td>";
				
				$test .= "<td>".$cndMob."</td>";
				$test .= "<td>".$cndEstadual."</td>";
				$test .= "<td>CND Federal</td>";
				$test .= "<td>".utf8_decode($emitente->cep)."</td>";
				$test .= "<td>".utf8_decode($emitente->numero)."</td>";			
				$test .= "<td>".utf8_decode($emitente->endereco)."</td>";
				$test .= "<td>".utf8_decode($emitente->bairro)."</td>";
				$test .= "<td>".utf8_decode($emitente->cidade)."</td>";
				$test .= "<td>".utf8_decode($emitente->estado)."</td>";
				$test .= "<td>".utf8_encode($ativo)."</td>";
					if($isArrayLog <> 0){
						 $dataFormatadaArr = explode('-',$dadosLog[0]->data);
						 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
						 $test .="<td>".$dadosLog[0]->email."</td>";
						 $test .="<td>".$dataFormatada."</td>";
						 $test .="<td>"."'".utf8_decode($dadosLog[0]->texto)."'"."</td>";
					}else{
						$test .="<td></td>";
						$test .="<td></td>";
						$test .="<td></td>";
					}				
				$test .= "</tr>";
				
			}
		}
		$test .='</table>';

		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
		
 }	 
 
 function export_est(){	
		
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$id = $this->input->post('id_estado_export');	
	$id_status = $this->input->post('id_status');	
	$result = $this->loja_model->listarLojaCsvEst($idContratante,$id,$id_status);
	
	
	$this->csv($result);
	
	
		
 }
 function export(){	
		
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$id = $this->input->post('id_imovel_export');
	$id_status = $this->input->post('id_status');
	$tabela = $this->input->post('tabela');
	if($id == '0'){
		$result = $this->loja_model->listarLojaCsv($idContratante,$id_status,$tabela);
	}else{
		$result = $this->loja_model->listarLojaCsvById($idContratante,$id,$tabela);
	}
	
	$this->csv($result);
			
 }
function listar_status(){	
 
	if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	}
	
	$session_data = $_SESSION['login_walmart'];
	
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
	$idContratante = $_SESSION['cliente'] ;
	
	$status = $_GET['status'];
	
	$cidade = '0';
	$estado = '0';	
	
	$data['cidadeBD'] = 0;	
	$data['estadoBD'] = 0;	
	$data['idLojaBD'] = 0;		
	
	$data['estados'] = $this->loja_model->listarEstadoByStatus($idContratante,$status);
	$data['cidades'] = $this->loja_model->listarCidadeByStatus($idContratante,$status);
	$data['bandeiras'] = $this->loja_model->listarBandeira($idContratante);
	$data['todas_lojas'] = $this->loja_model->listarTodasLojasByStatus($idContratante,$status);
	
	$result = $this->loja_model->buscaLojaStatus($idContratante,$status);	
	
	$arrDados = array();
	$i=1;
	foreach($result as $res){
		$arrCNDEst =  array();
		$arrDados[$i]['razao_social'] = $res->razao_social;
		$arrDados[$i]['cpf_cnpj'] = $res->cpf_cnpj;
		$arrDados[$i]['cnd'] = $res->cnd;
		$arrDados[$i]['id_cnd'] = $res->id_cnd;
		$arrDados[$i]['id_cnd'] = $res->id_cnd;
		$arrDados[$i]['id'] = $res->id;
		
		$arrayCndEst = $this->loja_model->buscaCNDEstById($res->id);
		$j = 1;
		$isArrayCndEst =  is_array($arrayCndEst) ? '1' : '0';			
		if($isArrayCndEst <> 0) {			
			foreach($arrayCndEst as $cnd_est){
				$arrCNDEst[$j]['cnd_est'] = $cnd_est['id'];					
				if($cnd_est['possui_cnd'] == 1){
					$arrCNDEst[$j]['possui_cnd_est'] ='Sim';
				}elseif($cnd_est['possui_cnd'] == 2){
					$arrCNDEst[$j]['possui_cnd_est'] ='Não';
				}else{
					$arrCNDEst[$j]['possui_cnd_est'] ='Pend&ecirc;ncia';
				}
				$j++;
			}
		}else{
			$arrayCndEst = '0';
		}
		$arrDados[$i]['cnd_est'] = $arrayCndEst;
		$i++;
		
	}
	
	
	if(empty($_SESSION["mensagemLoja"])){
		$data['mensagemLoja'] = '';
	}else{
		$data['mensagemLoja'] = $_SESSION['mensagemLoja'];
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$data['emitentes'] = $arrDados;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_loja_view_fixo', $data);
	$this->load->view('footer_pages_view');
 }
 
 function listarLojaSemCNDEst(){	
 
	if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];
	
	
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
	$idContratante = $_SESSION['cliente'] ;
	
	$data['estados'] = $this->loja_model->listarEstado($idContratante);
	$cidade = '0';
	$estado = '0';	
	$data['cidades'] = $this->loja_model->listarCidade($idContratante);
	$data['bandeiras'] = $this->loja_model->listarBandeira($idContratante);
	$data['todas_lojas'] = $this->loja_model->listarTodasLojas($idContratante,$cidade,$estado);
	
	if(empty($_POST)){
		
		$data['cidadeBD'] = 0;	
		$data['estadoBD'] = 0;	
		$data['idLojaBD'] = 0;		
		$result = $this->loja_model->buscaLojaSemCndEst($idContratante);
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		$data['cidadeBD'] = $municipioListar;	
		$data['estadoBD'] = $estadoListar ;	
		$data['idLojaBD'] = $idImovelListar;	
		
		$status = $_POST['status'];
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				$result = $this->loja_model->buscaLojaByCidade($idContratante,$municipioListar,$status);
			}else if($estadoListar <> '0'){
				$result = $this->loja_model->buscaLojaByEstado($idContratante,$estadoListar,$status);				
			}else{
				$result = $this->loja_model->buscaLojaById($idContratante,$idImovelListar,$status);
			}
		}else{	
			$result = $this->loja_model->buscaLojaById($idContratante,$idImovelListar,$status);
		}
	   
		
	}	
	
	$arrDados = array();
	$i=1;
	foreach($result as $res){
		$arrCNDEst =  array();
		$arrDados[$i]['razao_social'] = $res->razao_social;
		$arrDados[$i]['cpf_cnpj'] = $res->cpf_cnpj;
		$arrDados[$i]['cnd'] = $res->cnd;
		$arrDados[$i]['id_cnd'] = $res->id_cnd;
		$arrDados[$i]['id_cnd'] = $res->id_cnd;
		$arrDados[$i]['id'] = $res->id;
		
		$arrayCndEst = $this->loja_model->buscaCNDEstById($res->id);
		$j = 1;
		$isArrayCndEst =  is_array($arrayCndEst) ? '1' : '0';			
		if($isArrayCndEst <> 0) {			
			foreach($arrayCndEst as $cnd_est){
				$arrCNDEst[$j]['cnd_est'] = $cnd_est['id'];					
				if($cnd_est['possui_cnd'] == 1){
					$arrCNDEst[$j]['possui_cnd_est'] ='Sim';
				}elseif($cnd_est['possui_cnd'] == 2){
					$arrCNDEst[$j]['possui_cnd_est'] ='Não';
				}else{
					$arrCNDEst[$j]['possui_cnd_est'] ='Pend&ecirc;ncia';
				}
				$j++;
			}
		}else{
			$arrayCndEst = '0';
		}
		$arrDados[$i]['cnd_est'] = $arrayCndEst;
		$i++;
		
	}
	

	if(empty($_SESSION["mensagemLoja"])){
		$data['mensagemLoja'] = '';
	}else{
		$data['mensagemLoja'] = $_SESSION['mensagemLoja'];
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	
	$data['emitentes'] = $arrDados;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_loja_view_fixo', $data);
	$this->load->view('footer_pages_view');
	
 
 }
 
 function listar(){	
 
	if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	}
	$session_data = $_SESSION['login_walmart'];    	
	$idContratante = $_SESSION['cliente'] ;	
	$data['estados'] = $this->loja_model->listarEstado($idContratante);
	$cidade = '0';
	$estado = '0';	
	$data['cidades'] = $this->loja_model->listarCidade($idContratante);
	$data['bandeiras'] = $this->loja_model->listarBandeira($idContratante);
	$data['todas_lojas'] = $this->loja_model->listarTodasLojas($idContratante,$cidade,$estado);	
	if(empty($_POST)){
		
		$data['cidadeBD'] = 0;	
		$data['estadoBD'] = 0;	
		$data['idLojaBD'] = 0;	
		$tabela = 'cnd_mobiliaria';	
		$data['tabela'] = $tabela;
		$result = $this->loja_model->listarTodasLoja($idContratante,$cidade,$estado);
	}else{
		$estadoListar = $_POST['estadoListar'];
		$municipioListar = $_POST['municipioListar'];
		$idImovelListar = $_POST['idImovelListar'];
		
		$data['cidadeBD'] = $municipioListar;	
		$data['estadoBD'] = $estadoListar ;	
		$data['idLojaBD'] = $idImovelListar;	
		
		$status = $_POST['status'];
		$tabela = $_POST['tabela'];
		$data['tabela'] = $tabela;
		
		if($idImovelListar == '0'){	
			if($municipioListar <> '0'){
				//print'aqui';exit;
				$result = $this->loja_model->buscaLojaByCidade($idContratante,$municipioListar,$status,$tabela);
			}else if($estadoListar <> '0'){
				//print'aqui1';exit;
				$result = $this->loja_model->buscaLojaByEstado($idContratante,$estadoListar,$status,$tabela);				
			}else{
				//print'aqui2';exit;
				$result = $this->loja_model->buscaLojaById($idContratante,$idImovelListar,$status,$tabela);
				//print_r($this->db->last_query());exit;
			}
		}else{	
		//print'aqui3';exit;
			$result = $this->loja_model->buscaLojaById($idContratante,$idImovelListar,$status,$tabela);
		}
	   
		
	}	
	
	$arrDados = array();
	$i=1;
	foreach($result as $res){
		$arrCNDEst =  array();
		$arrDados[$i]['razao_social'] = $res->razao_social;
		$arrDados[$i]['cpf_cnpj'] = $res->cpf_cnpj;
		$arrDados[$i]['id'] = $res->id;
		
		$arrayCndEst = $this->loja_model->buscaCNDEstById($res->id);
		$j = 1;
		$isArrayCndEst =  is_array($arrayCndEst) ? '1' : '0';			
		if($isArrayCndEst <> 0) {			
			foreach($arrayCndEst as $cnd_est){
				$arrCNDEst[$j]['cnd_est'] = $cnd_est['id'];					
				if($cnd_est['possui_cnd'] == 1){
					$arrCNDEst[$j]['possui_cnd_est'] ='Sim';
				}elseif($cnd_est['possui_cnd'] == 2){
					$arrCNDEst[$j]['possui_cnd_est'] ='Não';
				}else{
					$arrCNDEst[$j]['possui_cnd_est'] ='Pend&ecirc;ncia';
				}
				$j++;
			}
		}else{
			$arrayCndEst = '0';
		}
		$arrDados[$i]['cnd_est'] = $arrayCndEst;
		$i++;
		
	}
	

	if(empty($_SESSION["mensagemLoja"])){
		$data['mensagemLoja'] = '';
	}else{
		$data['mensagemLoja'] = $_SESSION['mensagemLoja'];
	}
	
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	
	$data['emitentes'] = $arrDados;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('listar_loja_view_fixo', $data);
	$this->load->view('footer_pages_view');
	
 
 }
 
  function listarComParametro(){	
	$this->load->helper('Paginate_helper');        
    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
	$cidade  = $this->input->get('cidade');
	$estado  = $this->input->get('uf');
	$data['cidadeFiltro'] = $cidade;
	$data['estadoFiltro'] = $estado;
	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$data['estados'] = $this->loja_model->listarEstado();
	$data['cidades'] = $this->loja_model->listarCidade();
	$data['bandeiras'] = $this->loja_model->listarBandeira();
	$data['todas_lojas'] = $this->loja_model->listarTodasLojas($idContratante);
	
	$result = $this->loja_model->listarLoja($idContratante,numRegister4PagePaginate(), $page,$cidade,$estado);
	
	$total =  $this->loja_model->somarTodos($idContratante,$cidade,$estado);
	
	$data['paginacao'] = createPaginate('loja', $total[0]->total) ;
	
	$data['emitentes'] = $result;
	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_view',$data);
    $this->load->view('listar_loja_view_fixo', $data);
	$this->load->view('footer_view');
	
	
 
 }
 
 function contaCpf(){
	$cpf = $this->input->get('cpf');	
	$result = $this->emitente_model->verificaCPF($cpf,1);
	$total = $result[0]->total;
	if($total == 0){
		$valido = $this->validaCpf($cpf);
		echo json_encode($valido);
	}else{
		echo json_encode($total); 
	}	
 
 }
 function contaCnpj(){
	$cnpj = $this->input->get('cnpj');	
	$result = $this->emitente_model->verificaCPF($cnpj,2);
	$total = $result[0]->total;
	echo json_encode($total);
		
 
 }
 
  function contaEmail(){
	$email = $this->input->get('email');	
	$result = $this->emitente_model->verificaEmail($email);
	$total = $result[0]->total;
	echo json_encode($total);
		
 
 }
 
 function validaCnpj($cnpj){
		$cnpj = str_pad(str_replace(array('.','-','/'),'',$cnpj),14,'0',STR_PAD_LEFT);
		if (strlen($cnpj) != 14){
			return false;
		} else {
			for($t = 12; $t < 14; $t++){
				for($d = 0, $p = $t - 7, $c = 0; $c < $t; $c++){
					$d += $cnpj{$c} * $p;
					$p  = ($p < 3) ? 9 : --$p;
				}
				$d = ((10 * $d) % 11) % 10;
				if($cnpj{$c} != $d){
					return false;
				}
			}
			return true;
		}
	}
	
 function validaCpf($cpf) {
 
		if(empty($cpf)) {
			return false;
		}
		
		$cpf = preg_replace('/[^0-9]/', '', $cpf);
		
		
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		if (strlen($cpf) != 11) {
			return 1;
		}else if (
			$cpf == '00000000000' || $cpf == '11111111111' ||
			$cpf == '22222222222' || $cpf == '33333333333' ||
			$cpf == '44444444444' || $cpf == '55555555555' ||
			$cpf == '66666666666' || $cpf == '77777777777' ||
			$cpf == '88888888888' || $cpf == '99999999999' ||

			$cpf == '40404040411' || $cpf == '80808080822'

		){
			return 1;
		} else {
			for ($t = 9; $t < 11; $t++) {
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return 1;
				}
			}
			return 0;
		}
	}
 
}
 
?>