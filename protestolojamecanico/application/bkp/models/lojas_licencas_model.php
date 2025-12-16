<?php


Class Lojas_licencas_model extends CI_Model{

  function somarTodos($idContratante){
	$this -> db -> select('count(*) as total');
   $this -> db -> from('lojas_licencas');
   $this -> db -> join('loja','loja.id = lojas_licencas.id_loja');   
   $this -> db -> where('loja.id_contratante', $idContratante);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }
  
  
   function somarTodosTipo($idContratante,$tipo){
   $hoje = date('Y-m-d');
   $this -> db -> select('count(*) as total');
   $this -> db -> from('lojas_licencas');
   $this -> db -> join('loja','loja.id = lojas_licencas.id_loja');   
   $this -> db -> where('loja.id_contratante', $idContratante);   
   if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >', $hoje);   
   }else{
	   $this -> db -> where('lojas_licencas.data_vencimento  <', $hoje);   
   }
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }
  
   function somarTodasVencidas($idContratante){

	$data1 = date('Y-m-d', strtotime("+40 days"));
	$data2 = date('Y-m-d', strtotime("+45 days"));
 
    $sql = " select count(*) as total from licencas where id_contratante = ?  and data_vencimento between ? and ?";

   $query = $this->db->query($sql, array($idContratante,$data1,$data2));
   $array = $query->result_array(); //array of arrays
   return($array);  
  }
  
   function contaCnd($idContratante){

	$data1 = date('Y-m-d') ;
 
    $sql = "SELECT count(*) as total, 
	CASE  WHEN data_vencimento >= ? THEN '1'
    WHEN data_vencimento <= ? THEN '2'
    ELSE 'not yet'	END AS possui_cnd FROM lojas_licencas left join loja on loja.id = lojas_licencas.id_loja where loja.id_contratante = ?
	group by possui_cnd ;";

   $query = $this->db->query($sql, array($data1,$data1,$idContratante));
   //print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);  
  }
  
  function contaCndRegionalVigente($idContratante,$tipo,$regional){

	$data1 = date('Y-m-d') ;
	  
	 if($tipo == 1) {
		 $sql = "SELECT COALESCE(count(*) ,0)as total
			FROM lojas_licencas left join loja on loja.id = lojas_licencas.id_loja 
			left join regional on regional.id = loja.regional
			where loja.id_contratante = ?
			and data_vencimento >= ? 
			and regional.id = ?
			group by regional.descricao";
	 }else{
		 $sql = "SELECT COALESCE(count(*) ,0)as total
			FROM lojas_licencas left join loja on loja.id = lojas_licencas.id_loja 
			left join regional on regional.id = loja.regional
			where loja.id_contratante = ?
			and data_vencimento < ? 
			and regional.id = ?
			group by regional.descricao";
	 }
	  

	$query = $this->db->query($sql, array($idContratante,$data1,$regional));
	//print_r($this->db->last_query());exit;
	$array = $query->result_array(); //array of arrays
	return($array);  
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
 
  function contaCndGrafico($idContratante){

	$data1 = date('Y-m-d') ;
 
    $sql = "SELECT count(*) as total, 
	CASE  WHEN data_vencimento >= ? THEN 'Não Vencida'
    WHEN data_vencimento <= ? THEN 'Vencida'
    ELSE 'Pendente'	END AS possui_cnd FROM lojas_licencas left join loja on loja.id = lojas_licencas.id_loja where loja.id_contratante = ?
	group by possui_cnd ;";

   $query = $this->db->query($sql, array($data1,$data1,$idContratante));
   //print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);  
  }
  
  function contaLicencaAVencer($idContratante,$dias){
	  $data1 = date('Y-m-d') ;
	  $data2 = date('Y-m-d', strtotime("+".$dias." days",strtotime($data1))); 
	  
	  $sql = "SELECT count(*) as total,regional.descricao
			FROM lojas_licencas left join loja on loja.id = lojas_licencas.id_loja 
			left join regional on regional.id = loja.regional
			where loja.id_contratante = ?
			and data_vencimento between ? and ?
			group by regional.descricao";

	$query = $this->db->query($sql, array($idContratante,$data1,$data2));
	//print_r($this->db->last_query());exit;
	$array = $query->result_array(); //array of arrays
	return($array);  
   
	  
  }	  
  function contaCndGraficoNaoVencida($idContratante,$status){

	$data1 = date('Y-m-d') ;
 
	if($status =='V'){
		 $sql = "SELECT count(*) as total,regional.descricao
			FROM lojas_licencas left join loja on loja.id = lojas_licencas.id_loja 
			left join regional on regional.id = loja.regional
			where loja.id_contratante = ?
			and data_vencimento >= ?
			group by regional.descricao";
	}elseif($status=='N'){
		 $sql = "SELECT count(*) as total,regional.descricao
			FROM lojas_licencas left join loja on loja.id = lojas_licencas.id_loja 
			left join regional on regional.id = loja.regional
			where loja.id_contratante = ?
			and data_vencimento <= ?
			group by regional.descricao";
		
	}else{
		 $sql = "SELECT count(*) as total,regional.descricao
			FROM lojas_licencas left join loja on loja.id = lojas_licencas.id_loja 
			left join regional on regional.id = loja.regional
			where loja.id_contratante = ?
			and data_vencimento = '0000-00-00'
			group by regional.descricao";
	}
   

   $query = $this->db->query($sql, array($idContratante,$data1));
   //print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);  
  }
  
  function contaCndGraficoRegional($idContratante,$status,$reg){
	
	$data1 = date('Y-m-d') ;
 
	if($status =='V'){
		 $sql = "SELECT count(*) as total,tipo_licenca_taxa.descricao
				 FROM lojas_licencas left join loja on loja.id = lojas_licencas.id_loja 
				left join tipo_licenca_taxa on lojas_licencas.tipo_licenca_taxa = tipo_licenca_taxa.id
				where loja.id_contratante = ? and data_vencimento <= ?
				and loja.regional = ? group by lojas_licencas.tipo_licenca_taxa";
			 $query = $this->db->query($sql, array($idContratante,$data1,$reg));
	}elseif($status=='N'){
		 $sql = "SELECT count(*) as total,tipo_licenca_taxa.descricao
				 FROM lojas_licencas left join loja on loja.id = lojas_licencas.id_loja 
				left join tipo_licenca_taxa on lojas_licencas.tipo_licenca_taxa = tipo_licenca_taxa.id
				where loja.id_contratante = ? and data_vencimento >= ?
				and loja.regional = ? group by lojas_licencas.tipo_licenca_taxa";
			 $query = $this->db->query($sql, array($idContratante,$data1,$reg));
		
	}else{
		 $sql = "
		 SELECT count(*) as total,tipo_licenca_taxa.descricao
				 FROM lojas_licencas left join loja on loja.id = lojas_licencas.id_loja 
				left join tipo_licenca_taxa on lojas_licencas.tipo_licenca_taxa = tipo_licenca_taxa.id
				where loja.id_contratante = ? and data_vencimento = '0000-00-00'
				and loja.regional = ? group by lojas_licencas.tipo_licenca_taxa";
			 $query = $this->db->query($sql, array($idContratante,$reg));
	}
   

  
   //print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);  
  }
  
  function listarEstado($id_contratante,$tipo){
   $hoje =date('Y-m-d') ;
   $this->db->distinct();
   $this -> db -> select('estado');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','lojas_licencas.id_loja = loja.id');   
   $this -> db -> where('loja.id_contratante', $id_contratante);   
   if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >=', $hoje);   
   }else{
	   $this -> db -> where('lojas_licencas.data_vencimento  <=', $hoje);   
   }
   $this -> db -> order_by('loja.estado');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
 function listarEmitentesComLicenca($id_contratante,$tipo){
   $hoje = date('Y-m-d');
   $this -> db -> select('loja.id,emitente.nome_fantasia');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','loja.id = lojas_licencas.id_loja');   
   $this -> db -> join('tipo_licenca_taxa','lojas_licencas.tipo_licenca_taxa = tipo_licenca_taxa.id');   
   $this -> db -> join('emitente','loja.id_emitente = emitente.id');   
   $this -> db -> where('loja.id_contratante', $id_contratante);   
   if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >=', $hoje);   
   }else{
	   $this -> db -> where('lojas_licencas.data_vencimento  <=', $hoje);   
   }   
   $this -> db -> order_by('emitente.razao_social');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
 function listarCidade($id_contratante,$tipo){
   $hoje =date('Y-m-d');
   $this->db->distinct();
   $this -> db -> select('cidade');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','lojas_licencas.id_loja = loja.id');   
   $this -> db -> where('loja.id_contratante', $id_contratante);
   if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >=', $hoje);   
   }else{
	   $this -> db -> where('lojas_licencas.data_vencimento  <=', $hoje);   
   }
   $this -> db -> order_by('loja.cidade');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
function listarCidadeByEstado($id,$idContratante,$tipo){
   $hoje = date('Y-m-d');
   $this->db->distinct();
   $this -> db -> select('cidade');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','lojas_licencas.id_loja = loja.id');   
   $this -> db -> where('loja.id_contratante', $idContratante);  
   $this -> db -> where('loja.estado', $id);  
   if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >=', $hoje);   
   }else{
	   $this -> db -> where('lojas_licencas.data_vencimento  <=', $hoje);   
   }   
   $this -> db -> order_by('loja.cidade');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   

 }
 
 function listarEmitenteByEstado($id,$idContratante,$tipo){
   $hoje = date('Y-m-d');
   $this->db->distinct();
   $this -> db -> select('loja.id,emitente.nome_fantasia');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','lojas_licencas.id_loja = loja.id','left');   
   $this -> db -> join('emitente','loja.id_emitente = emitente.id','left');   
   $this -> db -> where('loja.id_contratante', $idContratante);  
   $this -> db -> where('loja.estado', $id);   
      if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >=', $hoje);   
   }else{
	   $this -> db -> where('lojas_licencas.data_vencimento  <=', $hoje);   
   }
   $this -> db -> order_by('loja.cidade');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   

 }
 
  function listarEmitenteByCidade($cidade,$idContratante,$tipo){
   $hoje = date('Y-m-d');
   $this->db->distinct();
   $this -> db -> select('loja.id,emitente.nome_fantasia');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','lojas_licencas.id_loja = loja.id','left');   
   $this -> db -> join('emitente','loja.id_emitente = emitente.id','left');   
   $this -> db -> where('loja.id_contratante', $idContratante);  
   $this -> db -> where('loja.cidade', $cidade);   
      if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >=', $hoje);   
   }else{
	   $this -> db -> where('lojas_licencas.data_vencimento  <=', $hoje);   
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   

 }
   function listarLicencasVencer($id_contratante,$_limit = 30, $_start = 0 ){
  $data1 = date('Y-m-d');
  $data2 = date('Y-m-d', strtotime("+45 days"));
   $this -> db ->limit( $_limit, $_start ); 	
   $this -> db -> select('*,licencas.ativo as status,licencas.id as id_licenca');
   $this -> db -> from('licencas'); 
   $this -> db -> join('tipo_licenca_taxa','licencas.tipo_licenca_taxa = tipo_licenca_taxa.id');   
   $this -> db -> join('emitente','licencas.id_emitente = emitente.id');   
   $this -> db -> where('licencas.id_contratante', $id_contratante);   
   $this -> db -> where('licencas.data_vencimento >=', $data1);   
   $this -> db -> where('licencas.data_vencimento <=', $data2);   
   $this -> db -> order_by('emitente.razao_social');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
  function listarLicencasVencidasOld($id_contratante,$_limit = 30, $_start = 0 ){
  $data1 = date('Y-m-d');
  $data2 = date('Y-m-d', strtotime("-45 days"));
   $this -> db ->limit( $_limit, $_start ); 	
   $this -> db -> select('*,licencas.ativo as status,licencas.id as id_licenca');
   $this -> db -> from('licencas'); 
   $this -> db -> join('tipo_licenca_taxa','licencas.tipo_licenca_taxa = tipo_licenca_taxa.id');   
   $this -> db -> join('emitente','licencas.id_emitente = emitente.id');   
   $this -> db -> where('licencas.id_contratante', $id_contratante);   
   $this -> db -> where('licencas.data_vencimento >=', $data2);   
   $this -> db -> where('licencas.data_vencimento <=', $data1);   
   $this -> db -> order_by('emitente.razao_social');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 

  function listarLicencasVencidas($id_contratante,$_limit = 30, $_start = 0 ){
   $data1 = date('Y-m-d');
   $data2 = date('Y-m-d', strtotime("-45 days"));
   $this -> db ->limit( $_limit, $_start ); 	
   $this -> db -> select('*,loja.id as id_loja');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','loja.id = lojas_licencas.id_loja');   
   $this -> db -> join('tipo_licenca_taxa','lojas_licencas.tipo_licenca_taxa = tipo_licenca_taxa.id');   
   $this -> db -> join('emitente','loja.id_emitente = emitente.id');   
   $this -> db -> where('loja.id_contratante', $id_contratante);  
   $this -> db -> where('lojas_licencas.data_vencimento >=', $data2);   
   $this -> db -> where('lojas_licencas.data_vencimento <=', $data1);   
   
   $this -> db -> order_by('emitente.razao_social');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 

  function excluirFisicamente($id,$tabela){
	$this->db->where('id_licenca', $id);
	$this->db->delete($tabela); 
	return true;
 } 
 
  function listarLicencas($id_contratante,$tipo){   
  $hoje = date('Y-m-d');
   $this -> db -> select('*,loja.id as id_loja');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','loja.id = lojas_licencas.id_loja');   
   $this -> db -> join('tipo_licenca_taxa','lojas_licencas.tipo_licenca_taxa = tipo_licenca_taxa.id');   
   $this -> db -> join('emitente','loja.id_emitente = emitente.id');   
   $this -> db -> where('loja.id_contratante', $id_contratante);   
   if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >=', $hoje);   
   }else if($tipo == 2){
	   $this -> db -> where('lojas_licencas.data_vencimento  <=', $hoje);   
   }
   $this -> db -> order_by('emitente.razao_social');

   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();

   } else{

     return false;

   }


 }
 
   function listarContratante($id_contratante){
   $this -> db -> select('*');
   $this -> db -> from('contratante'); 
   $this -> db -> where('contratante.id', $id_contratante);   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
 function listarLog($idOperacao){
   $this -> db ->limit( 1, 0 ); 		
   $this -> db -> select('log_tabelas.*,usuarios.email');
   $this -> db -> from('log_tabelas'); 
   $this -> db -> join('usuarios','log_tabelas.id_usuario = usuarios.id');   
   $this -> db -> where('log_tabelas.id_operacao', $idOperacao); 
    $this -> db -> where('log_tabelas.tabela', 'licencas'); 
   $this -> db -> order_by('log_tabelas.id','desc');   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
 function listarLicencasTodos($id_contratante,$tipo){
   $hoje = date('Y-m-d');	 
   $this -> db -> select('*, `lojas_licencas`.`status`, `lojas_licencas`.`id_licenca`');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','lojas_licencas.id_loja = loja.id');   
   $this -> db -> join('tipo_licenca_taxa','lojas_licencas.tipo_licenca_taxa = tipo_licenca_taxa.id');   
   $this -> db -> join('emitente','loja.id_emitente = emitente.id');   
   $this -> db -> where('loja.id_contratante', $id_contratante);
   if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >', $hoje);   
   }else if($tipo == 2){
	   $this -> db -> where('lojas_licencas.data_vencimento  <', $hoje);   
   } 
   $this -> db -> order_by('emitente.razao_social');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
  function listarLicencasByEmitente($idContratante,$emitente,$tipo){
   $hoje = date('Y-m-d');
   $this -> db -> select('*');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','loja.id = lojas_licencas.id_loja');   
   $this -> db -> join('tipo_licenca_taxa','lojas_licencas.tipo_licenca_taxa = tipo_licenca_taxa.id');   
   $this -> db -> join('emitente','loja.id_emitente = emitente.id');   
   $this -> db -> where('`lojas_licencas`.`id_loja`', $emitente);   
   if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >', $hoje);   
   }else if($tipo == 2){
	   $this -> db -> where('lojas_licencas.data_vencimento  <', $hoje);   
   } 
   $this -> db -> order_by('emitente.razao_social');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarLicencasByCidade($id_contratante,$cidade,$tipo){
   $hoje=date('Y-m-d');
   $this -> db -> select('*, `lojas_licencas`.`status`, `lojas_licencas`.`id_licenca`');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','lojas_licencas.id_loja = loja.id');   
   $this -> db -> join('tipo_licenca_taxa','lojas_licencas.tipo_licenca_taxa = tipo_licenca_taxa.id');   
   $this -> db -> join('emitente','loja.id_emitente = emitente.id');   
   $this -> db -> where('loja.id_contratante', $id_contratante);  
   if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >=', $hoje);   
   }else if($tipo == 2){
	   $this -> db -> where('lojas_licencas.data_vencimento  <=', $hoje);   
   }  
   $this -> db -> where('loja.cidade', $cidade); 
   $this -> db -> order_by('emitente.razao_social');
   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 function listarTipoLicencaById($tipo){
   $this -> db -> select('*');
   $this -> db -> from('tipo_licenca_taxa'); 
   $this -> db -> where('tipo_licenca_taxa.id', $tipo);   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
 function listarLicencasByTipo($idContratante,$id,$tipo){
   $hoje = date('Y-m-d');
   $this -> db -> select('*, `lojas_licencas`.`status`, `lojas_licencas`.`id_licenca`');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','lojas_licencas.id_loja = loja.id');   
   $this -> db -> join('tipo_licenca_taxa','lojas_licencas.tipo_licenca_taxa = tipo_licenca_taxa.id');   
   $this -> db -> join('emitente','loja.id_emitente = emitente.id');   
   $this -> db -> where('loja.id_contratante', $idContratante);   
   if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >', $hoje);   
   }else if($tipo == 2){
	   $this -> db -> where('lojas_licencas.data_vencimento  <', $hoje);   
   }  
   $this -> db -> where('lojas_licencas.tipo_licenca_taxa', $id);     
   $this -> db -> order_by('emitente.razao_social');
   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 function listarLicencasDias($idContratante,$data1,$data2){ 
 
  $sql = "SELECT *,
		CASE  WHEN data_vencimento >= ? THEN 'Não Vencida'
		WHEN data_vencimento <= ? THEN 'Vencida'
		ELSE 'Pendente'	END AS status_licenca,regional.descricao as descricao_regional
		FROM (`lojas_licencas`) 
		JOIN `loja` ON `lojas_licencas`.`id_loja` = `loja`.`id`
		JOIN `tipo_licenca_taxa` ON `lojas_licencas`.`tipo_licenca_taxa` = `tipo_licenca_taxa`.`id` 
		JOIN `emitente` ON `loja`.`id_emitente` = `emitente`.`id` 
		left join regional on regional.id = loja.regional
		WHERE `loja`.`id_contratante` = ? and data_vencimento between ? and ?  ORDER BY data_vencimento,regional.descricao
		";
		
		$query = $this->db->query($sql, array($data1,$data1,$idContratante,$data1,$data2));
		
	   if($query -> num_rows() <> 0) {
		 return $query->result();
	   } else{
		 return false;
	   }
			 
 }
  function listarLicencasByStatus($idContratante,$tipo){  
  
   $hoje=date('Y-m-d');
   
   if($tipo =='T'){
	    $sql = "SELECT *,
		CASE  WHEN data_vencimento >= ? THEN 'Não Vencida'
		WHEN data_vencimento <= ? THEN 'Vencida'
		ELSE 'Pendente'	END AS status_licenca,regional.descricao as descricao_regional
		FROM (`lojas_licencas`) 
		JOIN `loja` ON `lojas_licencas`.`id_loja` = `loja`.`id`
		JOIN `tipo_licenca_taxa` ON `lojas_licencas`.`tipo_licenca_taxa` = `tipo_licenca_taxa`.`id` 
		JOIN `emitente` ON `loja`.`id_emitente` = `emitente`.`id` 
		left join regional on regional.id = loja.regional
		WHERE `loja`.`id_contratante` = ? ORDER BY data_vencimento,regional.descricao
		";
		 $query = $this->db->query($sql, array($hoje,$hoje,$idContratante));
	   
   }elseif($tipo=='V'){
	   $sql = "SELECT *,
		CASE  WHEN data_vencimento >= ? THEN 'Não Vencida'
		WHEN data_vencimento <= ? THEN 'Vencida'
		ELSE 'Pendente'	END AS status_licenca,regional.descricao as descricao_regional
		FROM (`lojas_licencas`) 
		JOIN `loja` ON `lojas_licencas`.`id_loja` = `loja`.`id`
		JOIN `tipo_licenca_taxa` ON `lojas_licencas`.`tipo_licenca_taxa` = `tipo_licenca_taxa`.`id` 
		JOIN `emitente` ON `loja`.`id_emitente` = `emitente`.`id` 
		left join regional on regional.id = loja.regional
		WHERE `loja`.`id_contratante` = ? and data_vencimento <=?  ORDER BY data_vencimento,regional.descricao
		";
		 $query = $this->db->query($sql, array($hoje,$hoje,$idContratante,$hoje));
   }else{
	    $sql = "SELECT *,'Pendente' AS status_licenca,regional.descricao as descricao_regional
		FROM (`lojas_licencas`) 
		JOIN `loja` ON `lojas_licencas`.`id_loja` = `loja`.`id`
		JOIN `tipo_licenca_taxa` ON `lojas_licencas`.`tipo_licenca_taxa` = `tipo_licenca_taxa`.`id` 
		JOIN `emitente` ON `loja`.`id_emitente` = `emitente`.`id`
		left join regional on regional.id = loja.regional		
		WHERE `loja`.`id_contratante` = ? and data_vencimento = '0000-00-00'  ORDER BY data_vencimento,regional.descricao
		";
		 $query = $this->db->query($sql, array($idContratante));
   }
  
 
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
 function listarLicencasByEstado($id_contratante,$estado,$tipo){   
   $hoje=date('Y-m-d');
   $this -> db -> select('*');
   $this -> db -> from('lojas_licencas'); 
   $this -> db -> join('loja','lojas_licencas.id_loja = loja.id');   
   $this -> db -> join('tipo_licenca_taxa','lojas_licencas.tipo_licenca_taxa = tipo_licenca_taxa.id');   
   $this -> db -> join('emitente','loja.id_emitente = emitente.id');   
   $this -> db -> where('loja.id_contratante', $id_contratante);     
   $this -> db -> where('loja.estado', $estado);   
   if($tipo == 1){
	   $this -> db -> where('lojas_licencas.data_vencimento >', $hoje);   
   }else if($tipo == 2){
	   $this -> db -> where('lojas_licencas.data_vencimento  <', $hoje);   
   }  
   $this -> db -> order_by('emitente.razao_social');
   $query = $this -> db -> get();
//   print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }

 function licencasVencidas($idContratante){
	//$data = date ('Y-m-d');
	//$data2 = date ('Y-m-d');
	$data1 = date('Y-m-d');
	$data2 = date('Y-m-d', strtotime("-45 days"));
 
    $sql = " select count(*) as total from licencas where id_contratante = ?  and data_vencimento between ? and ?";

   $query = $this->db->query($sql, array($idContratante,$data2,$data1));
   //print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);
   
 }
 
  function licencasAVencer($idContratante){
	//$data = date ('Y-m-d');
	//$data2 = date ('Y-m-d');
	$data1 = date('Y-m-d');
	$data2 = date('Y-m-d', strtotime("+45 days"));
 
    $sql = " select count(*) as total from licencas where id_contratante = ?  and data_vencimento between ? and ?";

   $query = $this->db->query($sql, array($idContratante,$data1,$data2));
   //print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);
   
 }
 
 function listarTipoLicenca(){
   $this -> db -> select('id,descricao');
   $this -> db -> from('tipo_licenca_taxa');
   $query = $this -> db -> get();

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 
 }
 
 
 function listarEmitentes($id_contratante){

   $this -> db -> select('emitente.id,emitente.nome_fantasia');

   $this -> db -> from('emitente');

   //$this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');

   $this -> db -> where('id_contratante', $id_contratante);
	$this -> db -> order_by('emitente.nome_fantasia');
   //$this -> db -> where('tipo_emitente', 4);
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
 
 function listarLicencaById($id){
  $this -> db -> select('*,licencas.ativo as status,licencas.id as id_licenca');
   $this -> db -> from('licencas'); 
   $this -> db -> join('tipo_licenca_taxa','licencas.tipo_licenca_taxa = tipo_licenca_taxa.id');   
   $this -> db -> join('emitente','licencas.id_emitente = emitente.id');   
   $this -> db -> where('licencas.id', $id);
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;\\
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 /*
 function editar(){	
	$id = $this->input->get('id');
	$session_data = $this->session->userdata('logged_in');
	$idContratante = $_SESSION['cliente'] ;
	
	$data['emitentes'] = $this->loja_model->listarEmitentes($idContratante);
	$data['estados'] = $this->loja_model->buscaEstado($idContratante);
	$data['cidades'] = $this->loja_model->buscaCidades($idContratante);
	$data['bandeiras'] = $this->loja_model->listarBandeira();

	
	$data['dados_licenca'] = $this->licenca_model->listarLicencaById($id);
	//print_r($this->db->last_query());exit;
	//$data['emitentes'] = $result;
	$data['perfil'] = $session_data['perfil'];
	
	//$result = $this->tipo_emitente_model->listarTipoEmitente();
	
	
	$this->load->view('header_view',$data);
    $this->load->view('editar_licenca_view', $data);
	$this->load->view('footer_view');
	
	
 
 }
 */
 public function log($detalhes = array()){

 

	if($this->db->insert('log_tabelas', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
  public function add($detalhes = array()){

 

	if($this->db->insert('licencas', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
	function atualizar($dados,$id){

 

	$this->db->where('id', $id);

	$this->db->update('licencas', $dados); 

	//print_r($this->db->last_query());exit;

	return true;

  

 } 
 
 	
 
   
 
 

}


?>