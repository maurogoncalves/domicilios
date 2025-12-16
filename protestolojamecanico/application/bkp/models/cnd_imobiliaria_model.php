<?php


Class Cnd_Imobiliaria_model extends CI_Model{


	function excluirFisicamente($id){
		$this->db->where('id', $id);
		$this->db->delete('cnd_imobiliaria'); 
		return true;
	 } 
	 
  function listarEstado($idContratante,$tipo,$situacao){
	$data = date('Y-m-d');
	$this->db->distinct();
	$this -> db -> select('estado as uf');
	$this -> db -> from('imovel'); 
	$this -> db -> join('iptu','iptu.id_imovel = imovel.id');
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
	$this -> db -> where('cnd_imobiliaria.id_contratante', $idContratante);
	if($tipo <> '0'){
		  $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
	}
	if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	$this -> db -> order_by('imovel.estado');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }

  
    function listarCidade($idContratante,$tipo,$situacao){
    $data = date("Y-m-d");
	$this->db->distinct();
	$this -> db -> select('imovel.cidade');
	$this -> db -> from('imovel'); 
	$this -> db -> join('iptu','iptu.id_imovel = imovel.id');
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
	$this -> db -> where('cnd_imobiliaria.id_contratante', $idContratante);
	if($tipo <> '0'){
		  $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
	}
	
	if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	
	$this -> db -> order_by('imovel.cidade');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }

  
  function listarCndTipo($id_contratante,$cidade,$estado,$tipo ){
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
   $this -> db -> from('cnd_imobiliaria'); 
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   
   if($cidade){
	$this -> db -> where('imovel.cidade', $cidade);
	$this -> db -> where('imovel.estado', $estado);   
   }   
   $this -> db -> order_by('imovel.nome');
   $query = $this -> db -> get();
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
 function listarCndTipoId($id_contratante,$id,$tipo ){
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
   $this -> db -> from('cnd_imobiliaria'); 
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   $this -> db -> where('imovel.id', $id);
   $this -> db -> order_by('imovel.nome');
   $query = $this -> db -> get();
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
 function listarCndTipoEst($id_contratante,$estado,$tipo,$situacao ){
	$data = date("Y-m-d");
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
   $this -> db -> from('cnd_imobiliaria'); 
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   $this -> db -> where('imovel.estado', $estado);
   if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	
   $this -> db -> order_by('imovel.nome');
   $query = $this -> db -> get();
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
 function situacao(){
   $this -> db -> select('id,descricao');
   $this -> db -> from('tipo_situacao');  
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 
  function listarCndVigente($id_contratante,$situacao ){
	  
	 $data = date("Y-m-d");
	  
	 if($situacao == 2) {
		 
		  $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
		   $this -> db -> from('cnd_imobiliaria'); 
		   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');
		   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
		   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
		   $this -> db -> where('cnd_imobiliaria.possui_cnd', 1);
		   $this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		   $this -> db -> order_by('imovel.nome');
		   $query = $this -> db -> get();
   
	 }else{
		  $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
		   $this -> db -> from('cnd_imobiliaria'); 
		   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');
		   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
		   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
		   $this -> db -> where('cnd_imobiliaria.possui_cnd',1);
		   $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
		   $this -> db -> order_by('imovel.nome');
		   $query = $this -> db -> get();
	 }
  
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
 function listarCndTipoSituacao($id_contratante,$situacao,$tipo ){
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
   $this -> db -> from('cnd_imobiliaria'); 
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   $this -> db -> where('imovel.situacao', $situacao);
   $this -> db -> order_by('imovel.nome');
   $query = $this -> db -> get();
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
   function listarCndTipoMun($id_contratante,$cidade,$tipo,$situacao ){
	$data = date("Y-m-d");
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');
   $this -> db -> from('cnd_imobiliaria'); 
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   $this -> db -> where('imovel.cidade', $cidade);
    if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
   $this -> db -> order_by('imovel.nome');
   $query = $this -> db -> get();
  //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
 }
 
  function listarCnd($id_contratante,$_limit = 30, $_start = 0,$cidade,$estado ){


   $this -> db ->limit( $_limit, $_start ); 	


   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,iptu.area_total,iptu.area_construida,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.ativo as status_insc');


   $this -> db -> from('cnd_imobiliaria');
   
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id');


   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   
   if($cidade){
	$this -> db -> where('imovel.cidade', $cidade);
	$this -> db -> where('imovel.estado', $estado);
   
   }
   
   $this -> db -> order_by('imovel.nome');


   $query = $this -> db -> get();


   //print_r($this->db->last_query());exit;


   if($query -> num_rows() <> 0) {
     return $query->result();

   } else{

     return false;

   }


 }

 
 function listarIptuTotalCsv($id_contratante,$possuiCnd){
	 
	 $data =date("Y-m-d");
	
   $this -> db -> select('cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.id as id_cnd,imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_vencto,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.plano,cnd_imobiliaria.observacoes as obs_cnd, emitente.cpf_cnpj,imovel.cidade,imovel.estado');
   $this -> db -> from('cnd_imobiliaria');
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left'); 
   $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');   
   $this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');   
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   
   if($possuiCnd <> 'X'){
	$this -> db -> where('cnd_imobiliaria.possui_cnd', $possuiCnd);   
	$this -> db -> order_by('iptu.id');
   }else{
	$this -> db -> order_by('cnd_imobiliaria.possui_cnd');   
   }
   
  
   $query = $this -> db -> get();

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarIptuCsv($id_contratante,$possuiCnd,$situacao){
	 
	 $data =date("Y-m-d");
	
   $this -> db -> select('cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.id as id_cnd,imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_vencto,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.plano,cnd_imobiliaria.observacoes as obs_cnd, emitente.cpf_cnpj,imovel.cidade,imovel.estado');
   $this -> db -> from('cnd_imobiliaria');
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left'); 
   $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');   
   $this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');   
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   
   if($possuiCnd <> 'X'){
	$this -> db -> where('cnd_imobiliaria.possui_cnd', $possuiCnd);   
	$this -> db -> order_by('iptu.id');
   }else{
	$this -> db -> order_by('cnd_imobiliaria.possui_cnd');   
   }
   
    if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
   
   

   $query = $this -> db -> get();

  

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
  function listarIptuCsvByCidade($id_contratante,$possuiCnd,$situacao){
	  
	 $data =date("Y-m-d");  


   $this -> db -> select('cnd_imobiliaria.id as id_cnd,imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_vencto,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.plano,cnd_imobiliaria.plano,cnd_imobiliaria.observacoes as obs_cnd, emitente.cpf_cnpj,imovel.cidade,imovel.estado');

   $this -> db -> from('cnd_imobiliaria');

   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');

   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   
   $this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left');
   
   $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');
   
   $this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');
   

   $this -> db -> where('imovel.cidade', $id_contratante);
   
   if($possuiCnd <> 'X'){
	$this -> db -> where('cnd_imobiliaria.possui_cnd', $possuiCnd); 
   }
   
   
 if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
   
   $this -> db -> order_by('iptu.id');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarIptuCsvByEstado($id_contratante,$possuiCnd,$situacao){


	 $data =date("Y-m-d");
   $this -> db -> select('cnd_imobiliaria.id as id_cnd, imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_vencto,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.observacoes as obs_cnd,cnd_imobiliaria.plano, emitente.cpf_cnpj,imovel.cidade,imovel.estado');

   $this -> db -> from('cnd_imobiliaria');

   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');
   
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   
   $this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left');
   
   $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');
   
   $this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');
   
   $this -> db -> where('imovel.estado', $id_contratante);
   if($possuiCnd <> 'X'){
	   $this -> db -> where('cnd_imobiliaria.possui_cnd', $possuiCnd);
   }
   
    if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	
   $this -> db -> order_by('cnd_imobiliaria.id');
   


   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarTodasCidades($tipo){

   $this->db->distinct();
   $this -> db -> select('imovel.cidade');
   $this -> db -> from('imovel');   
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel'); 
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');   
   if($tipo <> 'X'){
	 $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   }
   $this -> db -> order_by('imovel.cidade');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return 0;

   }

 }
 
 function listarEmitentes($id_contratante){

   $this -> db -> select('emitente.id,emitente.razao_social');

   $this -> db -> from('emitente');

   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');

   $this -> db -> where('id_contratante', $id_contratante);

   $this -> db -> where('tipo_emitente', 4);
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarCidadeByEstadoVig($id,$tipo,$situacao){
	$data = date('Y-m-d');
	
   $this->db->distinct();
   $this -> db -> select('imovel.cidade');
   $this -> db -> from('imovel');   
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');   
   $this -> db -> where('imovel.estado', $id);
   
   if($tipo <> '0'){
	    $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   }
   
   if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
   
   $this -> db -> order_by('imovel.cidade');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return 0;

   }

 }
 
 function listarCidadeByEstado($id,$tipo,$situacao){
	 
   $data = date("Y-m-d");
   $this->db->distinct();
   $this -> db -> select('imovel.cidade');
   $this -> db -> from('imovel');   
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');   
   $this -> db -> where('imovel.estado', $id);
   if($tipo <> '0'){
	    $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
   }
    if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
   
   
   $this -> db -> order_by('imovel.cidade');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return 0;

   }

 }
 
 function listarIptuCsvById($id_imovel){
 
  $this -> db -> select('cnd_imobiliaria.id as id_cnd,imovel.nome,iptu.*,iptu.id as id_iptu,informacoes_inclusas_iptu.descricao,status_iptu.descricao as status_pref,emitente.razao_social,cnd_imobiliaria.possui_cnd as cnd,cnd_imobiliaria.data_vencto,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.plano,cnd_imobiliaria.plano,cnd_imobiliaria.observacoes as obs_cnd,emitente.cpf_cnpj,imovel.cidade,imovel.estado');

   $this -> db -> from('cnd_imobiliaria');
   
   $this -> db -> join('iptu','cnd_imobiliaria.id_iptu = iptu.id','left');

   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   
   $this -> db -> join('emitente','emitente.id = iptu.nome_proprietario','left');
   
   $this -> db -> join('informacoes_inclusas_iptu','informacoes_inclusas_iptu.id = iptu.info_inclusas','left');
   
   $this -> db -> join('status_iptu','status_iptu.id = iptu.status_prefeitura','left');
   
   
   $this -> db -> where('iptu.id_imovel', $id_imovel);   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 

 }

  function somarTodosTipo($idContratante,$cidade,$estado,$tipo){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_imobiliaria');
   $this -> db -> join('iptu','iptu.id = cnd_imobiliaria.id_iptu','left');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $idContratante);  
   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);  
   
   
   if($cidade){
		$this -> db -> where('imovel.cidade', $cidade);
		$this -> db -> where('imovel.estado', $estado);   
   }
     
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }
  
 function somarTodos($idContratante,$cidade,$estado){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_imobiliaria');
   $this -> db -> join('iptu','iptu.id = cnd_imobiliaria.id_iptu','left');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel','left');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $idContratante);  
   
   if($cidade){
		$this -> db -> where('imovel.cidade', $cidade);
		$this -> db -> where('imovel.estado', $estado);   
   }
     
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }

  function status_iptu(){
   $this -> db -> select('status_iptu.id,status_iptu.descricao');
   $this -> db -> from('status_iptu');
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarInscricaoByIptu($id){
   $this->db->distinct();
   $this -> db -> select('iptu.id,iptu.inscricao');
   $this -> db -> from('iptu');
   $this -> db -> join('imovel','iptu.id_imovel = imovel.id','left');
   $this -> db -> where('iptu.id', $id);

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 

function listarTodasInscricoes($id_contratante){
   $this->db->distinct();
   $this -> db -> select('iptu.id,iptu.inscricao');
   $this -> db -> from('iptu');
   $this -> db -> join('imovel','iptu.id_imovel = imovel.id','left');
   $this -> db -> where('imovel.id_contratante', $id_contratante);
   $this -> db -> order_by('iptu.inscricao');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarImovelVig($id_contratante,$tipo,$situacao){
	 $data = date("Y-m-d");
   $this->db->distinct();
   $this -> db -> select('imovel.id,imovel.nome');
   $this -> db -> from('imovel');
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
  
	if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}	
   
   $this -> db -> order_by('imovel.id');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
  function listarImovel($id_contratante,$tipo,$situacao){
   $data = date("Y-m-d");
   $this->db->distinct();
   $this -> db -> select('imovel.id,imovel.nome');
   $this -> db -> from('imovel');
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> where('cnd_imobiliaria.id_contratante', $id_contratante);
   if($tipo <> 'X'){
		$this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
  }		
	if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}	
   
   
   $this -> db -> order_by('imovel.id');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarImovelByEstado($id,$tipo,$situacao){
	 $data = date("Y-m-d");
	$this -> db ->distinct();
	$this -> db -> select('imovel.id,imovel.nome');
	$this -> db -> from('imovel');
	$this -> db -> join('iptu','imovel.id = iptu.id_imovel');
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
	$this -> db -> where('estado', $id);
	if($tipo <> '0'){
		$this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
	}
	
	 if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	
	$this -> db -> order_by('imovel.id');
	$query = $this -> db -> get();
	if($query -> num_rows() <> 0){
     return $query->result();
	}else{
     return false;
   }

 }
 
function listarImovelByCidade($id,$tipo,$situacao){
	$data = date("Y-m-d");
	$this->db->distinct();
	$this -> db -> select('imovel.id,imovel.nome');
	$this -> db -> from('imovel');
	$this -> db -> join('iptu','imovel.id = iptu.id_imovel');
	$this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
	if($id <> '0'){
		$this -> db -> where('cidade', $id);
	}	
	if($tipo <> '0'){
		$this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);
	}
	 if($situacao == '1'){
		  $this -> db -> where('cnd_imobiliaria.data_vencto > ', $data);
	}elseif($situacao == '2'){
		$this -> db -> where('cnd_imobiliaria.data_vencto <=', $data);
		
	}		
	
	
	$this -> db -> order_by('imovel.id');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 public function addDataEmissao($detalhes = array()){

 

	if($this->db->insert('cnd_data_emissao', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
 
  public function add($detalhes = array()){

 

	if($this->db->insert('cnd_imobiliaria', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
	 function atualizar($dados,$id){

 

	$this->db->where('id', $id);

	$this->db->update('cnd_imobiliaria', $dados); 

	//print_r($this->db->last_query());exit;

	return true;

  

 } 
 
 
 
 function listarCNDById($id){
   $this -> db -> select('*');
   $this -> db -> from('cnd_imobiliaria');
   $this -> db -> where('cnd_imobiliaria.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 function listarCidadeEstadoById($id){
   $this -> db -> select('imovel.id,imovel.cidade,imovel.estado,cnd_imobiliaria.possui_cnd');
   $this -> db -> from('iptu');
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
function listarInscricaoById($id){
   $this -> db -> select('iptu.inscricao,iptu.ano_ref, iptu.id as id_iptu,iptu.ano_ref,cnd_imobiliaria.id as id_cnd,cnd_imobiliaria.arquivo,cnd_imobiliaria.arquivo_pendencias,cnd_imobiliaria.data_vencto,cnd_imobiliaria.observacoes,cnd_imobiliaria.plano,cnd_imobiliaria.possui_cnd,imovel.nome as nome_im,cnd_imobiliaria.data_pendencias,cnd_imobiliaria.data_vencto');
   $this -> db -> from('iptu');
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   $this -> db -> join('imovel','imovel.id = iptu.id_imovel');
   $this -> db -> where('cnd_imobiliaria.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 function listarDataEmissao($id,$modulo){
	 
	$sql = "select data_emissao,DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao_br from cnd_data_emissao where id_cnd = ? and modulo =? order by data_emissao desc limit 1";

	$query = $this->db->query($sql, array($id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarTodasDataEmissao($id,$modulo){
	 
	$sql = "select DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao  from cnd_data_emissao where id_cnd = ? and modulo =? order by data_emissao desc ";

	$query = $this->db->query($sql, array($id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarImovelByImovel($id_imovel,$tipo){
	 
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.ativo as status_inscr');

   $this -> db -> from('imovel');

   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   
   if($id_imovel <> 0){
	$this -> db -> where('iptu.id_imovel', $id_imovel);   
   }
   
   if($tipo <> 'X'){
	$this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);   
   }
   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }

   
  function listarImovelByUf($estado,$tipo){
	 
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.ativo as status_inscr');

   $this -> db -> from('imovel');

   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   
   $this -> db -> where('imovel.estado', $estado); 
   
   if($tipo <> 'X'){
	   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo); 
   }
   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function listarImovelByMunicipio($municipio,$tipo){
	 
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.ativo as status_inscr');

   $this -> db -> from('imovel');

   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   if($tipo <> 'X'){
	   $this -> db -> where('cnd_imobiliaria.possui_cnd', $tipo);   
   }
   $this -> db -> where('imovel.cidade', $municipio);   

   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
    function contaTodasCnd(){
	 
   $this -> db -> select('count(`cnd_imobiliaria`.`possui_cnd`) as total');

   $this -> db -> from('imovel');

   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   
   
   $this -> db -> order_by('total');   

   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
    function contaCnd($idContratante){
	 
	$sql = "SELECT count(`cnd_imobiliaria`.`possui_cnd`) as total, `possui_cnd` 
	FROM (`cnd_imobiliaria`) 		
	where cnd_imobiliaria.id_contratante = ? 
	GROUP BY `cnd_imobiliaria`.`possui_cnd` 
	 ";

	$query = $this->db->query($sql, array($idContratante));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function contaVigente($idContratante,$tipo,$statusVigente){
	 
	 $data = date("Y-m-d");
	 if($statusVigente == 2){
		 
		 $sql = "SELECT count(*) as total FROM (`cnd_imobiliaria`)  WHERE `cnd_imobiliaria`.`id_contratante` = ?  AND `cnd_imobiliaria`.`possui_cnd` = ?  and data_vencto <= ?";
		$query = $this->db->query($sql, array($idContratante,$tipo,$data));	
		 
	 }else{
		 
		 $sql = "SELECT count(*) as total FROM (`cnd_imobiliaria`)  WHERE `cnd_imobiliaria`.`id_contratante` = ?  AND `cnd_imobiliaria`.`possui_cnd` = ? and data_vencto > ?";
		$query = $this->db->query($sql, array($idContratante,$tipo,$data));	
	 }
	  	 
	 
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
  function regionais(){
   $this -> db -> select('id,descricao');
   $this -> db -> from('regional');  
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
  function contaCndRegional($idContratante,$tipo,$regional){
	   
	$sql = "SELECT count(*) as total,regional.descricao FROM (`cnd_imobiliaria`)  
			LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id` 
			left join imovel on imovel.id = iptu.id_imovel
			left join regional on imovel.regional = regional.id
		 WHERE `cnd_imobiliaria`.`id_contratante` = ?  AND `cnd_imobiliaria`.`possui_cnd` = ?  and imovel.regional = ?  ";
		$query = $this->db->query($sql, array($idContratante,$tipo,$regional));		 
		
		
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 
   function contaSituacao($idContratante,$tipo,$situacao){
	   
	 if($tipo == 4){
		 $sql = "SELECT count(*) as total
		FROM `iptu` JOIN `imovel` ON `imovel`.`id` = `iptu`.`id_imovel` 
		left join tipo_situacao on tipo_situacao.id = imovel.situacao
		WHERE   imovel.id_contratante = ? and iptu.id not in (select id_iptu from cnd_imobiliaria where cnd_imobiliaria.id_contratante = ?)
		 ";
		 $query = $this->db->query($sql, array($idContratante,$idContratante));
	 }else{
		$sql = "SELECT count(*) as total FROM (`cnd_imobiliaria`)  LEFT JOIN `iptu` ON `cnd_imobiliaria`.`id_iptu` = `iptu`.`id` 
		left join tipo_situacao on tipo_situacao.id = iptu.status_prefeitura WHERE `cnd_imobiliaria`.`id_contratante` = ?  AND `cnd_imobiliaria`.`possui_cnd` = ?   and tipo_situacao.id = ?";
		$query = $this->db->query($sql, array($idContratante,$tipo,$situacao));		 
	 }	 

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function listarImovelPendente(){
	 
   $this -> db -> select('*,iptu.id as id_iptu,iptu.ativo,cnd_imobiliaria.ativo as status_inscr');

   $this -> db -> from('imovel');

   $this -> db -> join('iptu','imovel.id = iptu.id_imovel');
   
   $this -> db -> join('cnd_imobiliaria','cnd_imobiliaria.id_iptu = iptu.id');
   
   $this -> db -> where('cnd_imobiliaria.possui_cnd', '3');   

   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
}


?>