<?php
Class Notif_model extends CI_Model{
	

	
	public function listarArquivo($id){
		$sql = "select id,id_notificacao,arquivo from notificacoes_arquivos a where a.id =  ?"; 
		$query = $this->db->query($sql, array($id));
		//print_r($this->db->last_query());exit;
		$array = $query->result(); //array of arrays
		return($array);
			
	}
	 
}
?>
