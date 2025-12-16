<?php
Class Mapa_model extends CI_Model{

  function buscaCNDEstado($id_contratante){
      $sql = "select count(*) as total,loja.estado,estado_coordenadas.lat1,estado_coordenadas.lat2 from cnd_mobiliaria
			 left join loja on cnd_mobiliaria.id_loja = loja.id
			 left join estado_coordenadas on estado_coordenadas.uf = loja.estado
			 where cnd_mobiliaria.id_contratante = ?
			 group by loja.estado ";

   $query = $this->db->query($sql, array($id_contratante));
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
 
  function todasCidadesDoEstado($id_contratante,$estado){
   $sql = "select cidade from imovel where estado =? union select cidade from loja where estado =? ORDER BY CIDADE	";
   $query = $this->db->query($sql, array($estado,$estado,$id_contratante));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
 }
 
   function todasBandeiras(){
   $sql = "select id,descricao_bandeira from bandeira order by id";
   $query = $this->db->query($sql, array());
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
 }
 function totalBandeiras(){
   $sql = "select count(*) as total from bandeira";
   $query = $this->db->query($sql, array());
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);
 }
 
  function buscaCNDCidade1($id_contratante){
      $sql = " select cidade,estado,sum(possui_cnd) as sim,sum(nao_possui) as nao,sum(nada_costa) as nc from (
			select loja.cidade,loja.estado,
			(select count(*) from 
			cnd_mobiliaria cnd1 where cnd1.possui_cnd = 1 and 
			loja.id = cnd1.id_loja ) as possui_cnd,
			(select count(*) from 
			cnd_mobiliaria cnd2 where cnd2.possui_cnd = 2 and 
			loja.id = cnd2.id_loja ) as nao_possui,
			(select count(*) from 
			cnd_mobiliaria cnd3 where cnd3.possui_cnd = 3 and 
			loja.id = cnd3.id_loja ) as nada_costa
			from loja left join cnd_mobiliaria on loja.id = cnd_mobiliaria.id_loja 
			where cnd_mobiliaria.id_contratante = ?
			order by cidade) as aux group by cidade order by estado
		";

   $query = $this->db->query($sql, array($id_contratante));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

   
 }
 
 function buscaCNDImob($id_contratante,$cidade,$estado,$tipo){
      $sql = "select count(*)as total from cnd_imobiliaria 
			  left join iptu on iptu.id = cnd_imobiliaria.id_iptu
			  left join imovel on iptu.id_imovel = imovel.id 
			  where imovel.cidade = ? and imovel.estado = ? and cnd_imobiliaria.id_contratante = ?
			  and cnd_imobiliaria.possui_cnd = ?
		";

   $query = $this->db->query($sql, array($cidade,$estado,$id_contratante,$tipo));
  
   $array = $query->result(); //array of arrays
   return($array);

   
 }
  function buscaCNDMob($id_contratante,$cidade,$estado,$tipo){
      $sql = "select count(*) as total from loja  left join cnd_mobiliaria on loja.id = cnd_mobiliaria.id_loja
 where cnd_mobiliaria.id_contratante = ? and loja.estado= ? and loja.cidade=? and cnd_mobiliaria.possui_cnd = ?";

   $query = $this->db->query($sql, array($id_contratante,$estado,$cidade,$tipo));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
   function buscaLojaBandeira($id_contratante,$cidade,$estado,$tipo){
      $sql = "select count(*) as total from loja where loja.id_contratante = ? and loja.estado= ? and loja.cidade=? and loja.bandeira = ?";

   $query = $this->db->query($sql, array($id_contratante,$estado,$cidade,$tipo));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 function buscaCNDMobCidade($id_contratante){
      $sql = " select count(*) as total,loja.id,loja.cidade,cidade_coordenadas.lat1,cidade_coordenadas.lat2
		from loja 
		left join cnd_mobiliaria
		on loja.id = cnd_mobiliaria.id_loja
		left join cidade_coordenadas on cidade_coordenadas.cidade = loja.cidade
		where  cnd_mobiliaria.id_contratante = ?
		and cidade_coordenadas.lat1 is not null and cidade_coordenadas.lat2 is not null
		group by loja.cidade
		";

   $query = $this->db->query($sql, array($id_contratante));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
 function buscaTodosEstados($id_contratante){
      $sql = " select  COALESCE(estado, '0') as nao_tem ,uf from estado_cor left join (
				select estado from imovel where id_contratante = ? union select estado from loja where id_contratante = ?) as aux
				on estado_cor.uf = aux.estado";

   $query = $this->db->query($sql, array($id_contratante,$id_contratante));
   //print_r($this->db->last_query());exit;
   $array = $query->result(); //array of arrays
   return($array);

 }
 
  function buscaCNDImobCidade($id_contratante){
      $sql = " select count(*) as total,loja.id,loja.cidade,cidade_coordenadas.lat1,cidade_coordenadas.lat2
		from loja 
		left join cnd_mobiliaria
		on loja.id = cnd_mobiliaria.id_loja
		left join cidade_coordenadas on cidade_coordenadas.cidade = loja.cidade
		where  cnd_imobiliaria.id_contratante = ?
		and cidade_coordenadas.lat1 is not null and cidade_coordenadas.lat2 is not null
		group by loja.cidade
		";

   $query = $this->db->query($sql, array($id_contratante));
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
	
}
?>