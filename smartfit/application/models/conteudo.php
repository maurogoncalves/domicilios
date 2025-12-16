<?php
Class Conteudo extends CI_Model{

 function listarDadosByModulo($modulo){
   $this -> db -> select('id, modulo,conteudo');
   $this -> db -> from('conteudo');
   $this -> db -> where('modulo', $modulo);
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function atualizar_conteudo($texto,$id){
 
	$this->db->where('id', $id);
	$this->db->update('conteudo', $texto); 
	//print_r($this->db->last_query());exit;
	return true;
 
 }
 
}
?>