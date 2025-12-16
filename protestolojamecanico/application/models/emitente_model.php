<?php
Class Emitente_model extends CI_Model{
  function listarEmitente($id_contratante,$_limit = 30, $_start = 0 ){
   //$this->db->limit( $_limit, $_start ); 	
   $this -> db -> select('emitente.id,emitente.nome_fantasia,emitente.razao_social,emitente.nome_resp,tipo_emitente.descricao,emitente.ativo,tipo_emitente.cor as cor,emitente.id_contratante');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> where('id_contratante', $id_contratante);
	$this -> db -> order_by('emitente.nome_fantasia');
 
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
 
 function listarLog($idOperacao){
   $this -> db ->limit( 1, 0 ); 		
   $this -> db -> select('log_tabelas.*,usuarios.email');
   $this -> db -> from('log_tabelas'); 
   $this -> db -> join('usuarios','log_tabelas.id_usuario = usuarios.id');   
   $this -> db -> where('log_tabelas.id_operacao', $idOperacao); 
   $this -> db -> where('log_tabelas.tabela', 'emitente'); 
   $this -> db -> order_by('log_tabelas.id','desc');   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
 public function log($detalhes = array()){
	if($this->db->insert('log_tabelas', $detalhes)) {
		$id = $this->db->insert_id();
		return $id;
	}
	return false;
	}
 function listarTipoEmitenteById($id){

   $this -> db -> select('*');

   $this -> db -> from('tipo_emitente');

   $this -> db -> where('id', $id);

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
 
 function listarEmitentes($id_contratante){

   $this -> db -> select('emitente.id,emitente.nome_fantasia');

   $this -> db -> from('emitente');

   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');

   $this -> db -> where('id_contratante', $id_contratante);

   $this -> db -> order_by('nome_fantasia');   
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
 
 function listarCnpj($id_contratante){  
   $sql = "select l.id as id_loja ,e.cpf_cnpj as cpf_cnpj,e.matriz_filial as matriz_filial from loja l left join emitente e on e.id = l.id_emitente where l.id_contratante = ? ";
   $query = $this->db->query($sql, array($id_contratante));
   //print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);
 }
 
  function listarEmitentesNaoInclusos($id_contratante,$idImovel){


  
   $sql = "SELECT `emitente`.`id`, `emitente`.`nome_fantasia` FROM (`emitente`) JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
			WHERE `id_contratante` = ?
			AND `emitente`.`id`  NOT IN 
			(select id_emitente from emitente_imovel where id_imovel = ?)
			and ( tipo_emitente.id = 1 or tipo_emitente.id = 2 or tipo_emitente.id = 7)
			order by `emitente`.`nome_fantasia` ";

   $query = $this->db->query($sql, array($id_contratante, $idImovel));
   //print_r($this->db->last_query());exit;
   $array = $query->result_array(); //array of arrays
   return($array);
  
   

 }
 
  function verificarCnpjCpf($idContratante,$cpfCnpj) {
   $this -> db -> select('count(*) as total');
   $this -> db -> from('emitente');
   $this -> db -> where('id_contratante', $idContratante);   
   $this -> db -> where('cpf_cnpj', $cpfCnpj);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
    }
	
 function somarTodos($idContratante) {
   $this -> db -> select('count(*) as total');
   $this -> db -> from('emitente');
   $this -> db -> where('id_contratante', $idContratante);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
    }

 function listarUmEmitente($id_contratante,$id){
   $this -> db -> select('emitente.id,emitente.nome_fantasia,emitente.razao_social,emitente.nome_resp,tipo_emitente.descricao,emitente.ativo,tipo_emitente.cor as cor');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> where('id_contratante', $id_contratante);
   $this -> db -> where('emitente.id', $id);   
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
 
 function listarEmitenteById($id_contratante,$id){   $this -> db -> select('emitente.*,');   $this -> db -> from('emitente');   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');   $this -> db -> where('id_contratante', $id_contratante);   $this -> db -> where('emitente.id', $id);      $query = $this -> db -> get();      if($query -> num_rows() <> 0){     return $query->result();   }else{     return false;   } }
 
  function listarEmitenteByTipo($id_contratante,$tipo){
   $this -> db -> select('emitente.*,');
   $this -> db -> from('emitente');
   $this -> db -> where('id_contratante', $id_contratante);
   $this -> db -> where('emitente.tipo_emitente', $tipo);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   } else{
     return false;
   }
   
 }
 
   function listarTodosEmitentes($id_contratante){
   $this -> db -> select('id,nome_fantasia');
   $this -> db -> from('emitente');
   $this -> db -> where('id_contratante', $id_contratante);
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   } else{
     return false;
   }
   
 }
 
 function listarEmitenteCsv($id_contratante){
   $this -> db -> select('emitente.*,tipo_emitente.descricao');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> where('id_contratante', $id_contratante);
   $this -> db -> order_by('emitente.id');

 
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
 
  function listarEmitenteCsvByCPFCNPJ($cpfcnpj){
   $this -> db -> select('emitente.*,tipo_emitente.descricao');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> where('cpf_cnpj', $cpfcnpj);

 
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
 function excluir($id){
 
	$data = array('ativo' => 2);

	$this->db->where('id', $id);
	$this->db->update('emitente', $data); 
	
	return true;
  
 } 
 
  function ativar($id){
 
	$data = array('ativo' => 1);

	$this->db->where('id', $id);
	$this->db->update('emitente', $data); 
	
	return true;
  
 } 
 
 function atualizar($dados,$id){
 
	$this->db->where('id', $id);
	$this->db->update('emitente', $dados); 
	
	return true;
  
 } 
 
 function verificaCPF($cpf,$tipo_pessoa){
 
   $this -> db -> select('count(*) as total');
   $this -> db -> from('emitente');
   $this -> db -> where('cpf_cnpj', $cpf);
   if($tipo_pessoa <> 0){
	$this -> db -> where('tipo_pessoa', $tipo_pessoa);
   }
 
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
 
 function verificaEmail($email){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('emitente');
   $this -> db -> where('email_resp', $email);
   

 
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
 
 public function add($detalhes = array()){
 
	if($this->db->insert('emitente', $detalhes)) {
		
	return $id = $this->db->insert_id();
	}
	
	return false;
	}
	
}
?>