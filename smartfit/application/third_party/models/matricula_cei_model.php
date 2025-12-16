<?php
Class Matricula_cei_model extends CI_Model{
	
  function listarCei($id_contratante,$cidade,$estado ){
   if($cidade){
	$sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
			coalesce((select possui_cnd from cnd_obras where cnd_obras.id_cei = matricula_cei.id),0) as possui_cnd,cnd_obras.id as id_cnd_obras
			from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id
			left join regional on regional.id = matricula_cei.regional
			left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
			left join cnd_obras on cnd_obras.id_cei = matricula_cei.id
			where matricula_cei.id_contratante = ? and matricula_cei.cidade = ? and matricula_cei.estado = ?
			ORDER BY imovel.nome ";
	$query = $this->db->query($sql, array($id_contratante,$cidade,$estado));

   }else{
	   $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		coalesce((select possui_cnd from cnd_obras where cnd_obras.id_cei = matricula_cei.id),0) as possui_cnd,cnd_obras.id as id_cnd_obras
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		where matricula_cei.id_contratante = ?  ORDER BY imovel.nome ";
		$query = $this->db->query($sql, array($id_contratante));

   }
   /*      
   print_r($this->db->last_query());exit;
   */
   $array = $query->result(); 
   return($array);
   

 }
 
 function listarTodasCei($id_contratante ){
  $sql = "SELECT matricula_cei.id as id_cei, matricula_cei.cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.tipo_empreitada,matricula_cei.tipo_obra,matricula_cei.status_obra, imovel.nome as imovel,regional.descricao,matricula_cei.ativo,tipo_empreitada.descricao as empreitada,
		coalesce((select possui_cnd from cnd_obras where cnd_obras.id_cei = matricula_cei.id),0) as possui_cnd,cnd_obras.id as id_cnd_obras
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		where matricula_cei.id_contratante = ?  ORDER BY imovel.nome ";
		$query = $this->db->query($sql, array($id_contratante));
   /*      
   print_r($this->db->last_query());exit;
   */
   $array = $query->result(); 
   return($array);
   

 }
 
 function listarTodasDataEmissao($id,$modulo){
	 
	$sql = "select DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao  from cnd_data_emissao where id_cnd = ? and modulo =? order by data_emissao desc ";

	$query = $this->db->query($sql, array($id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
 
   function listarCeiById($id){
	   $sql = "SELECT matricula_cei.*, matricula_cei.id as id_cei,DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,DATE_FORMAT(matricula_cei.data_inicio_obra,'%d/%m/%Y') as data_inicio_obra,	coalesce((select possui_cnd from cnd_obras where cnd_obras.id_cei = matricula_cei.id),0) as possui_cnd,imovel.estado,imovel.cidade,matricula_cei.id_emitente, matricula_cei.observacoes
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		where matricula_cei.id = ? ";
		$query = $this->db->query($sql, array($id));

	
  /*      
   print_r($this->db->last_query());exit;
   */
   
   
   $array = $query->result(); 
   return($array);
   

 }
 
  function excluir($id){
 
	$data = array('ativo' => 2);

	$this->db->where('id', $id);
	$this->db->update('matricula_cei', $data); 
	
	return true;
  
 } 
 
   function ativar($id){
 
	$data = array('ativo' => 1);

	$this->db->where('id', $id);
	$this->db->update('matricula_cei', $data); 
	
	return true;
  
 } 
   function atualizar($dados,$id){ 
	$this->db->where('id', $id);
	$this->db->update('matricula_cei', $dados); 
		
	return true;  
 } 
 function somarTodos($idContratante,$cidade,$estado){
 
   $this -> db -> select('count(*) as total');
   $this -> db -> from('matricula_cei');
   $this -> db -> where('id_contratante', $idContratante);   
	  if($cidade){
			$this -> db -> where('matricula_cei.cidade', $cidade);
			$this -> db -> where('matricula_cei.estado', $estado);   
	   }
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
   
 }
 
  function listarEstado(){
	$this->db->distinct();
	$this -> db -> select('imovel.estado as uf');
	$this -> db -> from('matricula_cei'); 
	$this -> db -> join('imovel','imovel.id = matricula_cei.id_imovel');
	$this -> db -> order_by('imovel.estado');
	$query = $this -> db -> get();

   

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
 
   function listarCidade($estado){

	$this->db->distinct();
	$this -> db -> select('imovel.cidade as cidade');
	$this -> db -> from('matricula_cei'); 
	$this -> db -> join('imovel','imovel.id = matricula_cei.id_imovel');
	if($estado <> '0'){
		$this -> db -> where('imovel.estado', $estado);   
	}
	$this -> db -> order_by('imovel.cidade');
	$query = $this -> db -> get();
	   if($query -> num_rows() <> 0) {
		 return $query->result();
	   } else{
		 return false;
	   }   
  }
  
   function listarBandeiraById($id){
   $this -> db -> select('*');
   $this -> db -> from('bandeira');
   $this -> db -> where('id', $id);   
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
 function listarBandeira(){
   $this -> db -> select('*');
   $this -> db -> from('bandeira');
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }

  public function add($detalhes = array()){
 
	if($this->db->insert('matricula_cei', $detalhes)) {
		return $id = $this->db->insert_id();
	}
	
	return false;
	}
 
 
 function buscaCeiExistente($id_contratante,$cei){
	   $sql = "SELECT count(*) as total from matricula_cei where  matricula_cei.id_contratante = ? and  matricula_cei.cei = ? ";
		$query = $this->db->query($sql, array($id_contratante,$cei));
		
		      
		
		
        $array = $query->result(); 
		return($array);
 }
 
     function listarTodasCeiExport($id_contratante){
	   $sql = "SELECT 
	   matricula_cei.id as id_cei, 
	   matricula_cei.cei,
	   DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.
	   tipo_empreitada,
	   matricula_cei.tipo_obra,
	   matricula_cei.status_obra, 
	   imovel.nome as imovel,
	   regional.descricao,
	   matricula_cei.ativo,
	   tipo_empreitada.descricao as empreitada,
	   coalesce((select possui_cnd from cnd_obras where cnd_obras.id_cei = matricula_cei.id),0) as possui_cnd,
	   tipo_obra.descricao as tipo_obra_desc,
	   bandeira.descricao_bandeira,
	   matricula_cei.cidade,
	   matricula_cei.estado,
	   matricula_cei.averbado,
	   matricula_cei.area_existente,
	   matricula_cei.area_reforma,
	   matricula_cei.area_acres_nova,
	   matricula_cei.area_demolicao,
	   matricula_cei.area_total,
	   matricula_cei.alvara,
	   matricula_cei.projeto,
	   matricula_cei.contr_loc_matr_escr,
	   matricula_cei.habitese,
	   matricula_cei.contrato_obra,
	   matricula_cei.nota_fiscal,
	   matricula_cei.gps_2631,	   
	   matricula_cei.relatorio_sefip	  
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join tipo_obra on tipo_obra.id = matricula_cei.tipo_obra
		left join bandeira on bandeira.id = matricula_cei.bandeira
		where matricula_cei.id_contratante = ?  ORDER BY imovel.nome ";
		$query = $this->db->query($sql, array($id_contratante));
		
		      
		
		
        $array = $query->result(); 
		return($array);
 }
 
      function listarCeiByCidade($id_contratante,$cidade){
	   $sql = "SELECT 
	   matricula_cei.id as id_cei, 
	   matricula_cei.cei,
	   DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.
	   tipo_empreitada,
	   matricula_cei.tipo_obra,
	   matricula_cei.status_obra, 
	   imovel.nome as imovel,
	   regional.descricao,
	   matricula_cei.ativo,
	   tipo_empreitada.descricao as empreitada,
	   coalesce((select possui_cnd from cnd_obras where cnd_obras.id_cei = matricula_cei.id),0) as possui_cnd,
	   tipo_obra.descricao as tipo_obra_desc,
	   bandeira.descricao_bandeira,
	   matricula_cei.cidade,
	   matricula_cei.estado,
	   matricula_cei.averbado,
	   matricula_cei.area_existente,
	   matricula_cei.area_reforma,
	   matricula_cei.area_acres_nova,
	   matricula_cei.area_demolicao,
	   matricula_cei.area_total,
	   matricula_cei.alvara,
	   matricula_cei.projeto,
	   matricula_cei.contr_loc_matr_escr,
	   matricula_cei.habitese,
	   	   matricula_cei.contrato_obra,
	   matricula_cei.nota_fiscal,
	   matricula_cei.gps_2631,	   
	   matricula_cei.relatorio_sefip, 
	   cnd_obras.id as id_cnd_obras
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join tipo_obra on tipo_obra.id = matricula_cei.tipo_obra
		left join bandeira on bandeira.id = matricula_cei.bandeira
		left join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		where matricula_cei.id_contratante = ? and imovel.cidade = ?  ORDER BY imovel.nome ";
		$query = $this->db->query($sql, array($id_contratante,$cidade));
		
		      
		
		
        $array = $query->result(); 
		return($array);
 }
 
       function listarCeiByCodigo($id_contratante,$id){
	   $sql = "SELECT 
	   matricula_cei.id as id_cei, 
	   matricula_cei.cei,
	   DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.
	   tipo_empreitada,
	   matricula_cei.tipo_obra,
	   matricula_cei.status_obra, 
	   imovel.nome as imovel,
	   regional.descricao,
	   matricula_cei.ativo,
	   tipo_empreitada.descricao as empreitada,
	   coalesce((select possui_cnd from cnd_obras where cnd_obras.id_cei = matricula_cei.id),0) as possui_cnd,
	   tipo_obra.descricao as tipo_obra_desc,
	   bandeira.descricao_bandeira,
	   matricula_cei.cidade,
	   matricula_cei.estado,
	   matricula_cei.averbado,
	   matricula_cei.area_existente,
	   matricula_cei.area_reforma,
	   matricula_cei.area_acres_nova,
	   matricula_cei.area_demolicao,
	   matricula_cei.area_total,
	   matricula_cei.alvara,
	   matricula_cei.projeto,
	   matricula_cei.contr_loc_matr_escr,
	   matricula_cei.habitese,
	   	   matricula_cei.contrato_obra,
	   matricula_cei.nota_fiscal,
	   matricula_cei.gps_2631,	   
	   matricula_cei.relatorio_sefip,
	   cnd_obras.id as id_cnd_obras
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join tipo_obra on tipo_obra.id = matricula_cei.tipo_obra
		left join bandeira on bandeira.id = matricula_cei.bandeira
		left join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		where matricula_cei.id_contratante = ? and matricula_cei.id = ?  ORDER BY imovel.nome ";
		$query = $this->db->query($sql, array($id_contratante,$id));
		
		      
		
		
        $array = $query->result(); 
		return($array);
 }
  
      function listarCeiByEstado($id_contratante,$estado){
	   $sql = "SELECT 
	   matricula_cei.id as id_cei, 
	   matricula_cei.cei,
	   DATE_FORMAT(matricula_cei.data_abertura,'%d/%m/%Y') as data_abertura,matricula_cei.
	   tipo_empreitada,
	   matricula_cei.tipo_obra,
	   matricula_cei.status_obra, 
	   imovel.nome as imovel,
	   regional.descricao,
	   matricula_cei.ativo,
	   tipo_empreitada.descricao as empreitada,
	   coalesce((select possui_cnd from cnd_obras where cnd_obras.id_cei = matricula_cei.id),0) as possui_cnd,
	   tipo_obra.descricao as tipo_obra_desc,
	   bandeira.descricao_bandeira,
	   matricula_cei.cidade,
	   matricula_cei.estado,
	   matricula_cei.averbado,
	   matricula_cei.area_existente,
	   matricula_cei.area_reforma,
	   matricula_cei.area_acres_nova,
	   matricula_cei.area_demolicao,
	   matricula_cei.area_total,
	   matricula_cei.alvara,
	   matricula_cei.projeto,
	   matricula_cei.contr_loc_matr_escr,
	   matricula_cei.habitese,
	   matricula_cei.contrato_obra,
	   matricula_cei.nota_fiscal,
	   matricula_cei.gps_2631,
	   matricula_cei.relatorio_sefip,
	   cnd_obras.id as id_cnd_obras	   
		from matricula_cei left join imovel on matricula_cei.id_imovel = imovel.id 
		left join regional on regional.id = matricula_cei.regional
		left join tipo_empreitada on tipo_empreitada.id = matricula_cei.tipo_empreitada
		left join tipo_obra on tipo_obra.id = matricula_cei.tipo_obra
		left join bandeira on bandeira.id = matricula_cei.bandeira
		left join cnd_obras on cnd_obras.id_cei = matricula_cei.id
		where matricula_cei.id_contratante = ? and imovel.estado = ?  ORDER BY imovel.nome ";
		$query = $this->db->query($sql, array($id_contratante,$estado));
		
		      
		
		
        $array = $query->result(); 
		return($array);
 }
 
   function listarLojaByEmitente($emitente){
   $this -> db -> select('count(*) as tem, loja.id,emitente.nome_fantasia as razao_social');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> where('loja.id_emitente', $emitente);
 
   $query = $this -> db -> get();

   
   if($query -> num_rows() <> 0)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }

 function listarEmitentes($id_contratante){
$sql = "SELECT `emitente`.`id`, `emitente`.`nome_fantasia`  FROM (`emitente`) JOIN `tipo_emitente`  ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
		WHERE `id_contratante` = ?  and (`emitente`.`tipo_emitente` = 2  OR `emitente`.`tipo_emitente` = 1 OR `emitente`.`tipo_emitente` = 15)
		 order by `emitente`.`nome_fantasia` ";

	$query = $this->db->query($sql, array($id_contratante));
   /*
   $this -> db -> select('emitente.id,emitente.nome_fantasia');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente'); 
   $this -> db -> where('id_contratante', $id_contratante);
   $this -> db -> or_where('emitente.tipo_emitente', 2);
   $this -> db -> or_where('emitente.tipo_emitente', 1);   
   $this -> db -> or_where('emitente.tipo_emitente', 15);   
   $query = $this -> db -> get();
   */

   if($query -> num_rows() <> 0){
     return $query->result();
   } else {
     return false;
   }

 }
 
 function buscaEstado($idContratante){

   $this -> db -> distinct();
   $this -> db -> select('imovel.estado');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');
   $this -> db -> join('emitente_imovel','emitente.id = emitente_imovel.id_emitente');   
   $this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel');
   $this -> db -> where('emitente.id_contratante', $idContratante);
   $this -> db -> or_where('emitente.tipo_emitente', 2);
   $this -> db -> or_where('emitente.tipo_emitente', 1);
   $this -> db -> or_where('emitente.tipo_emitente', 15);
   $this -> db -> order_by('imovel.estado');
   $query = $this -> db -> get();

   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function buscaCidades($idContratante){

   $this -> db -> distinct();
   $this -> db -> select('imovel.cidade');
   $this -> db -> from('emitente');
   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');  
   $this -> db -> join('emitente_imovel','emitente.id = emitente_imovel.id_emitente');
   $this -> db -> join('imovel','imovel.id = emitente_imovel.id_imovel');
   $this -> db -> where('emitente.id_contratante', $idContratante);
   $this -> db -> or_where('emitente.tipo_emitente', 2);
   $this -> db -> or_where('emitente.tipo_emitente', 1);
   $this -> db -> or_where('emitente.tipo_emitente', 15);
   $this -> db -> order_by('imovel.estado');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0) {
     return $query->result();
   }else{
     return false;
   }

 }
 
 function listarTipoEmpreitada(){
	$sql = "SELECT id,descricao from tipo_empreitada ";
	$query = $this->db->query($sql, array());
	 return $query->result();
 }
 
  function listarTipoObra(){
	$sql = "SELECT id,descricao from tipo_obra ";
	$query = $this->db->query($sql, array());
	 return $query->result();
 }
}
?>