<?php
Class Cadastro_model extends CI_Model{

  function listar($id){
	if($id == 0){
		$sql = "select d.* from natureza d ";
		$query = $this->db->query($sql, array());	
	}else{
		$sql = "select d.* from natureza d where id = ? ";
		$query = $this->db->query($sql, array($id));  
	}
    
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
   

}


function listarEmailFiscalizacao(){
    //$sql = "select d.* from email d where tipo = 1 ";
	$sql = "select d.* from email d where tipo = 1 ";
	$query = $this->db->query($sql, array());
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
   

}

 public function inserir($tabela,$detalhes = array()){ 
	if($this->db->insert($tabela, $detalhes)) {
		return $id = $this->db->insert_id();
	}	
	return false;
}	

public function atualizar($tabela,$dados,$id){  
	$this->db->where('id', $id);
	$this->db->update($tabela, $dados); 
	
	return true;  
 } 
 
   function excluirFisicamente($tabela,$id){

	$this->db->where('id', $id);
	$this->db->delete($tabela); 
	return true;

 }
 
}
?>