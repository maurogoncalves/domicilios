<?php


Class Cnd_Estadual_model extends CI_Model{

 function listarCNDEstCsvByEstado($id_contratante,$id,$tipo){
	
  if($tipo == "0"){
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob,`cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and `loja`.`estado` = ?	and cnd_estadual.id_contratante = ? 
			ORDER BY `loja`.`id`";
	$query = $this->db->query($sql, array($id_contratante,$id,$id_contratante));
  }	else{
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob, `cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and `loja`.`estado` = ? AND `cnd_estadual`.`possui_cnd` = ? 
			and cnd_estadual.id_contratante = ? 
			ORDER BY `loja`.`id`";
	$query = $this->db->query($sql, array($id_contratante,$id,$tipo,$id_contratante));
  }
	if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   } 
		
 }	
 
 function listarCNDEstCsvByMun($id_contratante,$id,$tipo){
	
  if($tipo == "X"){
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob,`cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and `loja`.`cidade` = ?	and cnd_estadual.id_contratante = ? 
			ORDER BY `loja`.`id`";
	$query = $this->db->query($sql, array($id_contratante,$id,$id_contratante));
  }	else{
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob, `cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and `loja`.`cidade` = ? AND `cnd_estadual`.`possui_cnd` = ?' 
			and cnd_estadual.id_contratante = ? 
			ORDER BY `loja`.`id`";
	$query = $this->db->query($sql, array($id_contratante,$id,$tipo,$id_contratante));
  }
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
	
 function listarDataEmissao($id,$modulo){
	 
	$sql = "select data_emissao,DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao_br from cnd_data_emissao where id_cnd = ? and modulo =? order by id desc limit 1";

	$query = $this->db->query($sql, array($id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarCNDEstCsvById($id_contratante,$id){
	
  if($id == "0"){
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob,`cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and cnd_estadual.id_contratante = ?  
			ORDER BY `loja`.`id`";
	$query = $this->db->query($sql, array($id_contratante,$id_contratante));
  }	else{
	  $sql = "SELECT *, cnd_estadual.inscricao as ins_cnd_mob, `cnd_estadual`.`ativo` as status_cnd, `cnd_estadual`.`id` as id_cnd, `emitente`.`nome_fantasia` as nome 
			FROM (`cnd_estadual`) 
			JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
			JOIN `regional` ON `regional`.`id` = `loja`.`regional` JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira` 
			WHERE `loja`.`id_contratante` = ? and `cnd_estadual`.`id` = ? and cnd_estadual.id_contratante = ? ORDER BY `loja`.`id`";
	$query = $this->db->query($sql, array($id_contratante,$id,$id_contratante));
  }
	if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   } 
		
 }	
 
 function listarLoja($id_contratante,$tipo){
   $this->db->distinct();
   $this -> db -> select('cnd_estadual.id,emitente.nome_fantasia as  nome');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
   }   
   $this -> db -> order_by('loja.id');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarEmitenteById($id){

   $this -> db -> select('emitente.id,emitente.nome_fantasia as razao_social,emitente.cpf_cnpj,loja.id as id_loja,loja.ins_cnd_mob as inc_cnd_mob');

   $this -> db -> from('emitente');
   
   $this -> db -> join('loja','emitente.id = loja.id_emitente'); 

   $this -> db -> where('loja.id', $id);

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
 function listarCidadeEstadoById($id){
	
   $this -> db -> select('loja.id,loja.cidade,loja.estado ');
   $this -> db -> from('cnd_estadual');  
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_estadual.id', $id);   
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
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
 function listarInscricaoById($id){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> where('cnd_estadual.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarCNDById($id){
   $this -> db -> select('*');
   $this -> db -> from('cnd_estadual');
   $this -> db -> where('cnd_estadual.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 
 function atualizar($dados,$id){
	$this->db->where('id', $id);
	$this->db->update('cnd_estadual', $dados); 
	//print_r($this->db->last_query());exit;
	return true;
 } 
 
function listarInscricaoByLoja($id){

  
  $sql = "SELECT *, `cnd_estadual`.`ativo` as status_insc, `cnd_estadual`.`id` as id_cnd, `cnd_estadual`.`inscricao` as ins_cnd_mob, `loja`.`id` as id_loja, DATE_FORMAT(cnd_estadual.data_emissao, '%d/%m/%Y') as data_emissao FROM (`cnd_estadual`) JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` JOIN `imovel` ON `imovel`.`id` = `loja`.`id_imovel` JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` WHERE `cnd_estadual`.`id` = ?";
  $query = $this->db->query($sql, array($id));
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 public function add($detalhes = array()){

 

	if($this->db->insert('cnd_estadual', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
 function listarLojaByImovel($id_loja,$tipo){
	 
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');
   $this -> db -> from('cnd_estadual'); 
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
     
   if($id_loja <> 0){
	$this -> db -> where('loja.id', $id_loja);   
   }	
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
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
	 
	$this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   
   $this -> db -> where('loja.cidade', $municipio);  

   if($tipo <> 'X'){
	 $this -> db -> where('cnd_estadual.possui_cnd', $tipo);    
   }

   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarImovelByCidade($id,$tipo){


	$this -> db ->distinct();
	$this -> db -> select('cnd_estadual.id,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('loja.cidade', $id);
   if($tipo <> 'X'){
	 $this -> db -> where('cnd_estadual.possui_cnd', $tipo);  
   }	
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarImovelByUf($estado,$tipo){
	 
	
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as nome,loja.id as id_loja,cnd_estadual.inscricao as ins_cnd_mob');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> where('loja.estado', $estado);  
  
   if($tipo <> 'X'){
	$this -> db -> where('cnd_estadual.possui_cnd', $tipo);   
   }	
 
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 function listarImovelByEstado($id,$tipo){
   $this -> db ->distinct();
	
   $this -> db -> select('emitente.id,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_estadual');
   
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('loja.estado', $id);
   if($tipo<>'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
   }
   $this -> db -> order_by('emitente.id');
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
     return $query->result();
	}else{
     return false;
   }

 }
 
  function listarCidadeByEstado($idContratante,$id,$tipo){
	
	$this->db->distinct();
	$this -> db -> select('loja.cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id');
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	$this -> db -> where('loja.estado', $id);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return 0;
   }

 }
 
 function listarEstado($idContratante,$tipo){
	$this->db->distinct();
	$this -> db -> select('loja.estado as uf');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id','left');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id','left');
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.estado');
	$query = $this -> db -> get();
    if($query -> num_rows() <> 0) {
     return $query->result();
    }else{
     return false;
    }
   
  }
  
  function listarCidade($idContratante,$tipo){
	$this->db->distinct();
	$this -> db -> select('loja.cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id','left');
	$this -> db -> join('cnd_estadual','cnd_estadual.id_loja = loja.id','left');
	$this -> db -> where('cnd_estadual.id_contratante', $idContratante);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_estadual.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();
	
	   if($query -> num_rows() <> 0) {
		 return $query->result();
	   } else{
		 return false;
	   }
   
  }
  
  function listarCnd($id_contratante,$tipo){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   if($tipo <> 0){
	  $this -> db -> where('cnd_estadual.possui_cnd', $tipo); 
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
    return false;
   }
 }
 
   function listarCndTipoMun($id_contratante,$cidade,$tipo){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   $this -> db -> where('loja.cidade', $cidade);
   if($tipo <> 0){
	  $this -> db -> where('cnd_estadual.possui_cnd', $tipo); 
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
    return false;
   }
 }
 
 function listarCndTipoReg($id_contratante,$regional,$tipo){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   $this -> db -> where('loja.regional', $regional);
   if($tipo <> 0){
	  $this -> db -> where('cnd_estadual.possui_cnd', $tipo); 
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   //int_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
    return false;
   }
 }
   
  function listarCndTipoEst($id_contratante,$estado,$tipo){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   $this -> db -> where('loja.estado', $estado);
   if($tipo <> 0){
	  $this -> db -> where('cnd_estadual.possui_cnd', $tipo); 
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
    return false;
   }
 }
 
  
  function listarCndTipoId($id_contratante,$id){
   $this -> db -> select('*,cnd_estadual.ativo as status_insc,cnd_estadual.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,cnd_estadual.inscricao as ins_cnd_mob,loja.id as id_loja');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id','left');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel','left');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente','left');
   $this -> db -> where('cnd_estadual.id_contratante', $id_contratante);
   $this -> db -> where('cnd_estadual.id', $id);
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
    return false;
   }
 }
 
 function contaCnd($id_contratante,$ano){
	 $sql = "SELECT count(`cnd_estadual`.`possui_cnd`) as total, `possui_cnd` FROM (`cnd_estadual`) 
	left JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	left JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
	left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
	 WHERE `cnd_estadual`.`id_contratante` = ? GROUP BY `cnd_estadual`.`possui_cnd` 
	 union select count(*) as total, '99' from loja l
	left JOIN `emitente` ON `emitente`.`id` = l.`id_emitente` 
	left JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
	left JOIN `regional` ON `regional`.`id` = l.`regional` 
	left JOIN `bandeira` ON `bandeira`.`id` = l.`bandeira` 
	 where l.id not in (select id_loja from cnd_estadual) and l.id_contratante = ?";
	$query = $this->db->query($sql, array($id_contratante,$id_contratante));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function contaCndRegional($id_contratante,$ano,$tipo,$regional_id){
		 
	 $sql = "SELECT count(`cnd_estadual`.`possui_cnd`) as total FROM (`cnd_estadual`) 
	left JOIN `loja` ON `cnd_estadual`.`id_loja` = `loja`.`id` 
	left JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
	left JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
	left JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
	 WHERE `cnd_estadual`.`id_contratante` = ? and cnd_estadual.possui_cnd = ? and regional.id = ?
	 ";
	$query = $this->db->query($sql, array($id_contratante,$tipo,$regional_id));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 function somarTodos($idContratante,$cidade,$estado){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_estadual');
   $this -> db -> join('loja','cnd_estadual.id_loja = loja.id');
     if($cidade){
	$this -> db -> where('loja.cidade', $cidade);
	$this -> db -> where('loja.estado', $estado);
   
   }
   $this -> db -> where('cnd_estadual.id_contratante', $idContratante);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }
  
  

}


?>