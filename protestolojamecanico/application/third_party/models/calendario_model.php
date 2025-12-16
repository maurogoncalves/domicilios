<?php
Class Calendario_model extends CI_Model{
	
  
  function listarEvento($id_contratante,$id_usuario){
	  $sql = "select data_evento,descricao from calendario where id_contratante = ? and id_usuario = ? ";
	  $query = $this->db->query($sql, array($id_contratante,$id_usuario));
	  
	  $array = $query->result(); 
	  return($array);
  }
  
   public function add($detalhes = array()){
 
	if($this->db->insert('calendario', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}	

}  
?>