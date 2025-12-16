<?php
Class Tipo_Emitente_model extends CI_Model{
  function listarTipoEmitente(){   $this -> db -> select('id,descricao');   $this -> db -> from('tipo_emitente');   $this -> db -> order_by('id');   $query = $this -> db -> get();   if($query -> num_rows() <> 0){     return $query->result();   }else{     return false;   } }
}
?>