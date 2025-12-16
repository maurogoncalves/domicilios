<?php
Class Situacao_Imovel_model extends CI_Model{
  function listarSituacao(){   $this -> db -> select('id,descricao');   $this -> db -> from('tipo_situacao');   $this -> db -> order_by('id');   $query = $this -> db -> get();   if($query -> num_rows() <> 0){		return $query->result();   }else{     return false;   } }}
?>