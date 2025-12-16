<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





class Imovel extends CI_Controller {


 


 function __construct() {


   parent::__construct();
   $this->load->model('log_model','',TRUE);
   $this->load->model('emitente_imovel_model','',TRUE);
   $this->load->model('tipo_emitente_model','',TRUE);
   $this->load->model('situacao_imovel_model','',TRUE);
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

 function buscaImovel(){		$idContratante = $_SESSION['cliente'] ;
	$id = $this->input->get('id');	$retorno ='';	$result = $this->imovel_model->listarImovelByCidade($id,$idContratante);	if($result == 0){		$retorno .="<option value='0'>Não Há Dados</option>";	}else{		$retorno .="<option value=0>Escolha um Imóvel</option>";		foreach($result as $key => $iptu){ 				$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";		}
	}	echo json_encode($retorno); }
 
 function buscaCidade(){	
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	
	$id = $this->input->get('estado');
	$retorno ='';
	$result = $this->imovel_model->listarCidadeByEstado($idContratante,$id);
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
 
 function buscaImovelByCidade(){		$idContratante = $_SESSION['cliente'] ;
	$id = $this->input->get('id');
	
	$retorno ='';
	$result = $this->imovel_model->listarImovelByCidadeLista($id);
	
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	$base = $this->config->base_url();
	$base .='index.php';
	foreach($result as $key => $imo){ 	
		if($imo->ativo == 0){
			$status ='Ativo';
			$cor = '#009900';
		}else{
			$status ='Inativo';
			$cor = '#CC0000';
		}
		if($imo->combo >= 2){
			$combo ='Sim';
		}else{
			$combo ='Não';
		}
$retorno .=" <tr style='color:$cor;'>";
		$retorno .=" <td width='20%'><a href='#'>".$imo->nome."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$imo->descricao."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$imo->area_total."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$combo."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$status."</a></td>";		
		$retorno .="<td width='20%'>";
		$retorno .="<a href='$base/imovel/emitente_imovel?id=$imo->id_imovel' class='btn btn-success btn-xs'><i class='fa fa-bars'></i></a>";									  
		$retorno .="<a href='$base/imovel/editar?id=$imo->id_imovel' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";									  
		$retorno .="<a href='$base/imovel/excluir?id=$imo->id_imovel' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";									  
		$retorno .="<a href='$base/imovel/ativar?id=$imo->id_imovel' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";									  
        $retorno .="</td>";										  
		$retorno .="</tr>";
	}
	
	}
	
	echo json_encode($retorno);
	
 }
 
 function busca(){	
	$id = $this->input->get('id');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;

	$retorno ='';
	$result = $this->imovel_model->listarImovelById($idContratante,$id);
	
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	$base = $this->config->base_url();
	$base .='index.php';
	foreach($result as $key => $imo){ 	
		if($imo->ativo == 0){
			$status ='Ativo';
			$cor = '#009900';
		}else{
			$status ='Inativo';
			$cor = '#CC0000';
		}
		if($imo->combo >= 2){
			$combo ='Sim';
		}else{
			$combo ='Não';
		}
$retorno .=" <tr style='color:$cor;'>";
		$retorno .=" <td width='20%'><a href='#'>".$imo->nome."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$imo->descricao."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$imo->area_total."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$combo."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$status."</a></td>";		
		$retorno .="<td width='20%'>";
		$retorno .="<a href='$base/imovel/emitente_imovel?id=$imo->id_imovel' class='btn btn-success btn-xs'><i class='fa fa-bars'></i></a>";									  
		$retorno .="<a href='$base/imovel/editar?id=$imo->id_imovel' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";									  
		$retorno .="<a href='$base/imovel/excluir?id=$imo->id_imovel' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";									  
		$retorno .="<a href='$base/imovel/ativar?id=$imo->id_imovel' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";									  
        $retorno .="</td>";										  
		$retorno .="</tr>";
	}
	
	}
	
	echo json_encode($retorno);
	
 }
 
  function buscaEstado(){	
	$id = $this->input->get('id');
	
	$retorno ='';
	$result = $this->imovel_model->listarImovelByUf($id);
	
	
	if($result == 0){
		$retorno .="<tr>";
		$retorno .="<td class='hidden-phone' colspan='8'> Não Há Dados </td>";

		$retorno .="</tr>";
	}else{
	
	$base = $this->config->base_url();
	$base .='index.php';
	foreach($result as $key => $imo){ 	
		if($imo->ativo == 0){
			$status ='Ativo';
			$cor = '#009900';
		}else{
			$status ='Inativo';
			$cor = '#CC0000';
		}
		
		if($imo->combo >= 2){
			$combo ='Sim';
		}else{
			$combo ='Não';
		}
$retorno .=" <tr style='color:$cor;'>";
		$retorno .=" <td width='20%'><a href='#'>".$imo->nome."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$imo->descricao."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$imo->area_total."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$combo."</a></td>";			
		$retorno .=" <td width='15%'><a href='#'>".$status."</a></td>";		
		$retorno .="<td width='20%'>";
		$retorno .="<a href='$base/imovel/emitente_imovel?id=$imo->id_imovel' class='btn btn-success btn-xs'><i class='fa fa-bars'></i></a>";									  
		$retorno .="<a href='$base/imovel/editar?id=$imo->id_imovel' class='btn btn-primary btn-xs'><i class='fa fa-pencil'></i></a>";									  
		$retorno .="<a href='$base/imovel/excluir?id=$imo->id_imovel' class='btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></a>";									  
		$retorno .="<a href='$base/imovel/ativar?id=$imo->id_imovel' class='btn btn-primary btn-xs'><i class='fa fa-check-square-o'></i></a>";									  
        $retorno .="</td>";										  
		$retorno .="</tr>";
	}
	
	}
	
	echo json_encode($retorno);
	
 }
 
  function buscaImovelByEstado(){	
	$id = $this->input->get('id');	
	$retorno ='';
	$result = $this->imovel_model->listarImovelByEstado($id);	
	if($result == 0){
		$retorno .="<option value='0'>Não Há Dados</option>";
	}else{	
		$retorno .="<option value=0>Escolha um Imóvel</option>";
		foreach($result as $key => $iptu){ 			 
			$retorno .="<option value=".$iptu->id.">".$iptu->nome."</option>";		 
		}	
	}
	echo json_encode($retorno);
 }
 
 function buscaImByNome(){	
	$nome = $this->input->get('nome');	
	$retorno ='';
	$result = $this->imovel_model->listarImovelByNome($nome);	
	echo json_encode($result[0]->total);
 }
 
 

 function buscaTodasCidades(){	
	$retorno ='';
	$result = $this->imovel_model->listarTodasCidades();
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
 
 


 function index(){


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


 


 function cadastrar(){
 
	 if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	  }

	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	$data['emitentes'] = $this->emitente_model->listarEmitentes($idContratante);
	$data['tipo_emitentes']  = $this->situacao_imovel_model->listarSituacao();
	$data['todos_imoveis']  = $this->imovel_model->listarImoveis($idContratante);
	$data['regionais']  = $this->imovel_model->listarRegionais();
 	$data['perfil'] = $session_data['perfil'];
	$this->load->view('header_pages_view',$data);
    $this->load->view('cadastrar_imovel_view', $data);
	$this->load->view('footer_pages_view');	
 }
 function excluir_emitente_imovel(){
 
 if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
  }
 
	$id = $this->input->get('id');
	if($this->imovel_model->excluir_emitente_imovel($id)) {
		$_SESSION['mensagemImovel'] =  EMITENTE_EXCLUIDO;
	}else{	
		$_SESSION['mensagemImovel'] =  ERRO;
	}
	
	redirect('/imovel/listar', 'refresh');
	
 }

 function excluir(){


 if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
  }

	$session_data = $_SESSION['login_walmart'];
	
	$id = $this->input->get('id');
	$idContratante = $_SESSION['cliente'] ;
	$result = $this->imovel_model->listarImovelById($idContratante,$id);
	

	$_SESSION["cidadeIMBD"] = $result[0]->cidade;
	$_SESSION["estadoIMBD"] = $result[0]->estado;
	$_SESSION["idImBD"] = $result[0]->id;
	
	$podeExcluir = $this->user->perfil_excluir($session_data['id']);
	
	if($podeExcluir[0]['total'] == 1){
		$this->user->excluirFisicamente($id,'imovel');
		$_SESSION['mensagemImovel'] =  CADASTRO_INATIVO;
		
	}else{
			
		if($this->imovel_model->excluir($id)) {
			$_SESSION['mensagemImovel'] =  CADASTRO_INATIVO;

		}else{	
			$_SESSION['mensagemImovel'] =  ERRO;
		}
	}

	redirect('/imovel/listar', 'refresh');


	


 }


 function cadastrar_imovel(){
 
   if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
  }


	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$nomeImovel = $this->input->post('nomeImovel');	
	$areaTotal = $this->input->post('areaTotal');	
	$areaConstruida = $this->input->post('areaConstruida');	
	$cep = $this->input->post('cep');	
	$numero = $this->input->post('numero');	
	$logradouro = $this->input->post('logradouro');	
	$bairro = $this->input->post('bairro');	
	$cidade = $this->input->post('cidade');	
	$estado = $this->input->post('estado');	
	$situacao = $this->input->post('situacao');	
	$regional = $this->input->post('regional');	
	
	$dados = array('id_contratante' => $idContratante,
		'nome' => $nomeImovel,
		'area_total' => $areaTotal,
		'area_construida' => $areaConstruida,
		'cep' => $cep,
		'numero' => $numero,
		'rua' => $logradouro,
		'bairro' => $bairro,
		'cidade' => $cidade,
		'estado' => $estado,
		'situacao' => $situacao,
		'regional' => $regional
	);

	if($this->imovel_model->add($dados)) {
		$_SESSION['mensagemImovel'] =  CADASTRO_FEITO;
	}else{	
		$_SESSION['mensagemImovel'] =  ERRO;
	}
	redirect('/imovel/listar', 'refresh');
 }

  function atualizar_emitente_imovel(){
 
  if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
  }

 
	$id = $this->input->post('id');
	$id_im = $this->input->post('id_im');
	$areaDestinada = $this->input->post('areaDestinada');
	
	$dados = array(	'area' => $areaDestinada);

	if($this->emitente_imovel_model->update($dados,$id)) {		
		$_SESSION['mensagemImovel'] =  CADASTRO_ATUALIZADO;
	}else{	
		$_SESSION['mensagemImovel'] =  ERRO;
	}
	
	redirect('/imovel/emitente_imovel?id='.$id_im, 'refresh');


 }
 

 function inserir_emitente_imovel(){
 
  if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
  }

	$id = $this->input->post('id');
	$emitente = $this->input->post('emitente');
	if($emitente == 0){
		echo "<script>alert('Escolha um emitente'); window.history.go(-1);</script>";
			exit;
	}
	$areaDestinada = $this->input->post('areaDestinada');
	
	$dados = array(	'area' => $areaDestinada,
					'id_imovel' => $id,
					'id_emitente' => $emitente					
				);

	if($this->emitente_imovel_model->add($dados)) {
		$this->db->cache_off();
		$_SESSION['mensagemImovel'] =  CADASTRO_FEITO;
	}else{	
		$_SESSION['mensagemImovel'] =  ERRO;

	}
	
	redirect('/imovel/emitente_imovel?id='.$id, 'refresh');
 
 }

 function ativar(){
	if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	  }

  
	$id = $this->input->get('id');

	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;

	
	$result = $this->imovel_model->listarImovelById($idContratante,$id);
	
	
	$_SESSION["cidadeIMBD"] = $result[0]->cidade;
	$_SESSION["estadoIMBD"] = $result[0]->estado;
	$_SESSION["idImBD"] = $result[0]->id;
	

	$dados = array('ativo' => 0);

	if($this->imovel_model->atualizar($dados,$id)) {

		$_SESSION['mensagemImovel'] =  CADASTRO_ATUALIZADO;

	}else{	

		$_SESSION['mensagemImovel'] =  ERRO;

	}

	redirect('/imovel/listar');

				

 }
 

 function atualizar_imovel(){
	if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	  }
 

	$id = $this->input->post('id');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	$idUsuario = $session_data['id'];
	$nomeImovel = $this->input->post('nomeImovel');	
	$areaTotal = $this->input->post('areaTotal');	
	$areaConstruida = $this->input->post('areaConstruida');
	$cep = $this->input->post('cep');	
	$numero = $this->input->post('numero');	
	$logradouro = $this->input->post('logradouro');	
	$bairro = $this->input->post('bairro');	
	$cidade = $this->input->post('cidade');	
	$estado = $this->input->post('estado');	
	$situacao = $this->input->post('situacao');	
	$regional = $this->input->post('reg');	
	

	$dados = array('id_contratante' => $idContratante,
		'nome' => $nomeImovel,
		'area_total' => $areaTotal,
		'area_construida' => $areaConstruida,
		'cep' => $cep,
		'numero' => $numero,
		'rua' => $logradouro,
		'bairro' => $bairro,
		'cidade' => $cidade,
		'estado' => $estado,				
		'situacao' => $situacao,
		'regional' => $regional	
	);

	$dadosAtuais = $this->imovel_model->listarImovelById($idContratante,$id);
	$tipoSituacao = $this->imovel_model->listarTipoSituacaoById($dadosAtuais[0]->situacao);		
	$dadosRegional = $this->imovel_model->dadosRegional($dadosAtuais[0]->regional);		
	$dadosAlterados = '';
	
	if($dadosAtuais[0]->nome <> $nomeImovel){
		$dadosAlterados .= 'Nome Imóvel: '.$dadosAtuais[0]->nome;
	}
	if($dadosAtuais[0]->area_total <> $areaTotal){
		$dadosAlterados .= ' - Area Total: '.$dadosAtuais[0]->area_total;
	}
	if($dadosAtuais[0]->area_construida <> $areaConstruida){
		$dadosAlterados .= ' - Area Construida: '.$dadosAtuais[0]->area_construida;
	}
	if($dadosAtuais[0]->cep <> $cep){
		$dadosAlterados .= ' - CEP: '.$dadosAtuais[0]->cep;
		$dadosAlterados .= ' - Rua: '.$dadosAtuais[0]->rua;
		$dadosAlterados .= ' - Bairro: '.$dadosAtuais[0]->bairro;
		$dadosAlterados .= ' - Cidade: '.$dadosAtuais[0]->cidade;
		$dadosAlterados .= ' - Estado: '.$dadosAtuais[0]->estado;
	}
	if($dadosAtuais[0]->numero <> $numero){
		$dadosAlterados .= ' - Numero: '.$dadosAtuais[0]->numero;
	}	
	if($dadosAtuais[0]->situacao <> $situacao){
		$dadosAlterados .= ' - Situação: '.$tipoSituacao[0]->descricao;
	}	
	if($dadosAtuais[0]->regional <> $regional){
		$dadosAlterados .= ' - Rergional: '.$dadosRegional[0]->descricao;
	}	

	$dadosLog = array(
	'id_contratante' => $idContratante,
	'tabela' => 'imovel',
	'id_usuario' => $idUsuario,
	'id_operacao' => $id,
	'tipo' => 2,
	'texto' => $dadosAlterados,
	'data' => date("Y-m-d"),
	);
	$this->log_model->log($dadosLog);
	
	$result = $this->imovel_model->listarImovelById($idContratante,$id);
	
	$_SESSION["cidadeIMBD"] = $result[0]->cidade;
	$_SESSION["estadoIMBD"] = $result[0]->estado;
	$_SESSION["idImBD"] = $result[0]->id;
	
	
	
	if($this->imovel_model->atualizar($dados,$id)) {
		$_SESSION['mensagemImovel'] =  CADASTRO_ATUALIZADO;
	}else{	
		$_SESSION['mensagemImovel'] =  ERRO;
		
	}


	redirect('/imovel/listar', '');
 }


  function emitente_imovel(){	
  	if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
   }
	$idImovel = $this->input->get('id');
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;				
	$data['perfil'] = $session_data['perfil'];
	$data['id_im'] = $idImovel;
	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	$data['emitentes']  = $this->imovel_model->listarImovelEmitente($idContratante,$idImovel);
	$soma = 0;
	
	$isArray =  is_array($data['emitentes'] ) ? '1' : '0';	
	if($isArray == 0){ 
		$omsa = 0;
	}else{
		foreach ($data['emitentes'] as $key){
			$soma = $soma + $key->area;		
		}
	}
	
	$data['soma'] =  $soma;
	$data['emitentesNaoInc']  = $this->emitente_model->listarEmitentesNaoInclusos($idContratante,$idImovel);
	$data['imovel'] =  $result = $this->imovel_model->listarImovelById($idContratante,$idImovel);
	$this->load->view('header_pages_view',$data);
    $this->load->view('emitente_imovel_view', $data);
	$this->load->view('footer_pages_view');	

  }
  
  function outro_emitente_imovel(){	
  
  if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
  }

	
	$idImovel = $this->input->get('id');
	
	$session_data = $_SESSION['login_walmart'];
	
	$idContratante = $_SESSION['cliente'] ;
				
	$data['perfil'] = $session_data['perfil'];

	
	$data['emitentes']  = $this->emitente_model->listarEmitentesNaoInclusos($idContratante,$idImovel);
	$data['imovel'] =  $result = $this->imovel_model->listarImovelById($idContratante,$idImovel);
	
	$this->load->view('header_pages_view',$data);

    $this->load->view('outro_emitente_imovel_view', $data);

	$this->load->view('footer_pages_view');	

  }
  function editar_emitente(){	
  
	  if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	  }


	$id = $this->input->get('id');
	$id_im = $this->input->get('id_im');

	$session_data = $_SESSION['login_walmart'];

	$idContratante = $_SESSION['cliente'] ;

	$result = $this->imovel_model->listarEmitenteImovelById($id);

	$data['imovel'] = $result;
	$data['id_im'] = $id_im;
	
	
	$data['perfil'] = $session_data['perfil'];


	$this->load->view('header_pages_view',$data);

    $this->load->view('editar_emitente_imovel_view', $data);

	$this->load->view('footer_pages_view');



 }
 

  function editar(){	
  
  if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
  }



	$id = $this->input->get('id');


	$session_data = $_SESSION['login_walmart'];


	$idContratante = $_SESSION['cliente'] ;


	$result = $this->imovel_model->listarImovelById($idContratante,$id);
	
	$_SESSION["cidadeIMBD"] = $result[0]->cidade;
	$_SESSION["estadoIMBD"] = $result[0]->estado;
	$_SESSION["idImBD"] = $result[0]->id;
	
	
	$data['dadosIptu'] = $this->imovel_model->somarAreaIptu($id);

	$data['imovel'] = $result;
	
	$data['tipo_emitentes']  = $this->situacao_imovel_model->listarSituacao();

	$data['regionais']  = $this->imovel_model->listarRegionais();
	
	$data['perfil'] = $session_data['perfil'];


	if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}

	$this->load->view('header_pages_view',$data);


    $this->load->view('editar_imovel_view', $data);


	$this->load->view('footer_pages_view');





 }


  function export(){	
  
  if(! $_SESSION['login_walmart']) {
		redirect('login', 'refresh');
  }

		
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
					
	$result = $this->imovel_model->listarImovelCsv($idContratante);
	
	$file="imoveis.xls";

				
		$test="<table border=1>
		<tr>
		<td>Id</td>
		<td>Nome</td>
		<td>Situa&ccedil;&atilde;o</td>
		<td>Area Total</td>
		<td>Area Construida</td>
		<td>Area Total Iptu</td>
		<td>Area Construida Iptu</td>
		
		<td>Combinado</td>
		<td>CEP</td>
		<td>N&uacute;mero</td>
		<td>Rua</td>
		<td>Bairro</td>
		<td>Cidade</td>
		<td>Estado</td>
		<td>Status</td>
		<td>Emitente</td>
		<td>&Aacute;rea</td>
		<td>Alterado Por </td>
		<td>Data Altera&ccedil;&atilde;o </td>
		<td>Dados Alterados </td>		
		</tr>
		";
		
		
 
		  foreach($result as $key => $imovel){ 

			$dadosLog = $this->log_model->listarLog($imovel->id,'imovel');	
		    $isArrayLog =  is_array($dadosLog) ? '1' : '0';	
		  
			if($imovel->ativo == 0){
				$ativo='Ativo';
			}else{
				$ativo='Inativo';
			}
			if($imovel->combo >= 2){
				$cor='#dedede';
				$combo ='Sim';
			}else{
				$cor='';
				$combo ='Não';
			}
			$area_total_iptu = number_format($imovel->area_total_iptu, 2, ',', '.');
			$area_construida_iptu = number_format($imovel->area_construida_iptu, 2, ',', '.');
			$test .= "<tr style='background-color:$cor'>";
			$test .= "<td>".utf8_decode($imovel->id)."</td>";
			$test .= "<td>".utf8_decode($imovel->nome)."</td>";
			$test .= "<td>".utf8_decode($imovel->descricao)."</td>";
			$test .= "<td>'".$imovel->area_total."'</td>";		
			$test .= "<td>'".$imovel->area_construida."'</td>";
			$test .= "<td>'".$area_total_iptu."'</td>";		
			$test .= "<td>'".$area_construida_iptu."'</td>";			
			$test .= "<td>".utf8_decode($combo)."</td>";
			$test .= "<td>".utf8_encode($imovel->cep)."</td>";
			$test .= "<td>".utf8_encode($imovel->numero)."</td>";
			$test .= "<td>".utf8_decode($imovel->rua)."</td>";
			$test .= "<td>".utf8_decode($imovel->bairro)."</td>";
			$test .= "<td>".utf8_decode($imovel->cidade)."</td>";
			$test .= "<td>".utf8_encode($imovel->estado)."</td>";
			$test .= "<td>".utf8_encode($ativo)."</td>";
			$test .= "<td>".utf8_decode($imovel->razao_social)."</td>";
			$test .= "<td>".utf8_encode($imovel->area)."</td>";
			if($isArrayLog <> 0){
			 $dataFormatadaArr = explode('-',$dadosLog[0]->data);
			 $dataFormatada = $dataFormatadaArr[2].'/'.$dataFormatadaArr[1].'/'.$dataFormatadaArr[0];
			 $test .="<td>".$dadosLog[0]->email."</td>";
			 $test .="<td>".$dataFormatada."</td>";
			 $test .="<td>".utf8_decode($dadosLog[0]->texto)."</td>";
			 }else{
				$test .="<td></td>";
				 $test .="<td></td>";
				 $test .="<td></td>";
			 }			
			
			$test .= "</tr>";
		
			
		}
		$test .='</table>';
		
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$file");
		echo $test;	
	
		
 }

 function limpar_filtro(){	
 
		
	$_SESSION["cidadeIMBD"] = 0;
	$_SESSION["estadoIMBD"] = 0;
	$_SESSION["idImBD"] = 0;
	
	redirect('/imovel/listar', '');

 }

  function listarComParametro(){	
 
	$uf = $this->input->get('uf');	
	$_SESSION["cidadeIMBD"] = 0;
	$_SESSION["estadoIMBD"] = $uf;
	$_SESSION["idImBD"] = 0;
	
	redirect('/imovel/listar', '');

 }
 
  
 function listar(){	
 
	 if(! $_SESSION['login_walmart']) {
			redirect('login', 'refresh');
	  }

    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	$session_data = $_SESSION['login_walmart'];
	$idContratante = $_SESSION['cliente'] ;
	 if(empty($session_data['visitante'])){
		$data['visitante'] = 0;
	}else{
		$data['visitante'] = $session_data['visitante'];	
	}
	
	if(empty($_POST)){			$result = $this->imovel_model->listarTodosImovel($idContratante);			
	}else{		$estadoListar = $_POST['estadoListar'];		$municipioListar = $_POST['municipioListar'];		$idImovelListar = $_POST['idImovelListar'];
		$data['idImovelBD'] = $_POST['idImovelListar'];
		$data['idImovelMunBD'] = $_POST['municipioListar'];
		$data['idImovelUFBD'] = $_POST['estadoListar'];		if($idImovelListar == '0'){							if($municipioListar <> '0'){				$result =  $this->imovel_model->listarImovelByCidadeLista($idContratante,$municipioListar);								}else{				$result =  $this->imovel_model->listarImovelByUf($idContratante,$estadoListar);											}		}else{				$result = $this->imovel_model->listarImovelById($idContratante,$idImovelListar);							}	}		$data['imoveis'] = $result;		$data['select_imoveis'] = $this->imovel_model->listarTodosImoveis($idContratante);	$data['cidades'] = $this->imovel_model->listarCidade($idContratante);						$data['estados'] = $this->imovel_model->listarEstado($idContratante);		$session_data = $_SESSION['login_walmart'];	$data['email'] = $session_data['email'];	$data['empresa'] = $session_data['empresa'];	$data['perfil'] = $session_data['perfil'];	$this->load->view('header_pages_view',$data);	$this->load->view('listar_imovel_view', $data);	$this->load->view('footer_pages_view');
 }
 
 

 function buscaCep(){
	 $this->load->library('cep');
	 $cep = $this->input->get('cep');
	 $this->cep->busca_cep($cep);  

	 
	 
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