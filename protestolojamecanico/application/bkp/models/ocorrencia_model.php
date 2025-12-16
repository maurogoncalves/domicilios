<?php
Class Ocorrencia_model extends CI_Model
{
 function listar($id)
 {
 
   if($id == 0){
	   $sql = "select  ocorrencia.*,modulos.nome as nome_modulo,DATE_FORMAT(data_abertura,'%d/%m/%Y') as data_abertura,DATE_FORMAT(data_fechamento,'%d/%m/%Y') as data_fechamento 
		from   ocorrencia    left join modulos on ocorrencia.id_modulo = modulos.id_modulo    order by ocorrencia.id desc ";
   }else{
	    $sql = "select  ocorrencia.*,modulos.nome as nome_modulo,DATE_FORMAT(data_abertura,'%d/%m/%Y') as data_abertura,DATE_FORMAT(data_fechamento,'%d/%m/%Y') as data_fechamento 
		from   ocorrencia    left join modulos on ocorrencia.id_modulo = modulos.id_modulo    where id_usuario_abriu = ? and ocorrencia.ativo = 0 order by ocorrencia.id desc ";
   }
  

	$query = $this->db->query($sql, array($id));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

   
 }
 
 function listarOcorrenciaById($id)
 {
 
   
   $sql = "select  ocorrencia.*,modulos.nome as nome_modulo,DATE_FORMAT(data_abertura,'%d/%m/%Y') as data_abertura,DATE_FORMAT(data_fechamento,'%d/%m/%Y') as data_fechamento  
   from
   ocorrencia 
   left join modulos on ocorrencia.id_modulo = modulos.id_modulo
   where ocorrencia.id = ?  ";

	$query = $this->db->query($sql, array($id));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

   
 }
 
 function atualizar($dados,$id){ 	
	$this->db->where('id', $id);	
	$this->db->update('ocorrencia', $dados); 	
	return true;   
}

 function listarModulos()
 {
 
   
   $sql = "select  id_modulo,nome  from modulos  order by nome ";

	$query = $this->db->query($sql, array());

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

   
 }
 
  
 function listarPrioridade()
 {
 
   
   $sql = "select  id,descricao  from prioridade_ocorrencia  order by descricao ";

	$query = $this->db->query($sql, array());

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

   
 }
 
 public function add($detalhes = array()){ 	
	if($this->db->insert('ocorrencia', $detalhes)) {										
		$id = $this->db->insert_id();				
		return $id;	
	}		
		return false;	
 }		
 
}
?>