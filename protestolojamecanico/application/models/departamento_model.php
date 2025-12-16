<?php
Class Departamento_model extends CI_Model{

  function listarDepartamento($id){
    if($id == 0){
		$sql = "select d.* from depto_interno d ";
		$query = $this->db->query($sql, array());
	}else{
		$sql = "select d.* from depto_interno d where id = ? ";
		$query = $this->db->query($sql, array($id));
	}
	
   
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