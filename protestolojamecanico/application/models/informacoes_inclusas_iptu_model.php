<?php
Class Informacoes_inclusas_iptu_model extends CI_Model{
  function listar(){
   $this -> db -> select('id,descricao');
   $this -> db -> from('informacoes_inclusas_iptu');
   $this -> db -> order_by('descricao');
 
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
}
?>