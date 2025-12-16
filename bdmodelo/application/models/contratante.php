<?php
Class Contratante extends CI_Model
{
 function buscarId($cnpj)
 {
   $this -> db -> select('id, nome_empresa');
   $this -> db -> from('contratante');
   $this -> db -> where('cnpj', $cnpj);
   $this -> db -> limit(1);

   $query = $this -> db -> get();  
	
   if($query -> num_rows() == 1){
     return $query->result();
   }else{
     return false;
   }
 }
}
?>