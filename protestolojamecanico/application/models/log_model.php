<?php

Class Log_model extends CI_Model{

  function listarLog($idOperacao,$tabela){
   $this -> db ->limit( 1, 0 ); 		
   $this -> db -> select('log_tabelas.*,usuarios.email,');
   $this -> db -> from('log_tabelas'); 
   $this -> db -> join('usuarios','log_tabelas.id_usuario = usuarios.id');   
   $this -> db -> where('log_tabelas.id_operacao', $idOperacao); 
    $this -> db -> where('log_tabelas.tabela', $tabela); 
   $this -> db -> order_by('log_tabelas.id','desc');   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }

 }
 
 function ultimaAlteracao($idContratante,$id,$idUsuario){
 
   
   $sql = "SELECT `log_tabelas`.*, `usuarios`.`email` ,DATE_FORMAT(data,'%d/%m/%Y') as data 
FROM (`log_tabelas`) JOIN `usuarios` ON `log_tabelas`.`id_usuario` = `usuarios`.`id` 
WHERE `log_tabelas`.`id_operacao` = ?
AND `log_tabelas`.`id_usuario` = ? 
AND `log_tabelas`.`id_contratante` = ? 
AND `log_tabelas`.`tabela` = 'sublocacoes' 
ORDER BY `log_tabelas`.`id` desc
		     ";

   $query = $this->db->query($sql, array($id,$idUsuario,$idContratante));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
   

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
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

}