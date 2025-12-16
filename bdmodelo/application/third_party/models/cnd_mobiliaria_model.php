<?php


Class Cnd_Mobiliaria_model extends CI_Model{

	function excluirFisicamente($id){
		$this->db->where('id', $id);
		$this->db->delete('cnd_mobiliaria'); 
		return true;
	 } 
	 
 
  function listarEstado($idContratante,$tipo){
	$this->db->distinct();
	$this -> db -> select('loja.estado as uf');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id');
	$this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.estado');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
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
 
  public function addDataEmissao($detalhes = array()){

 

	if($this->db->insert('cnd_data_emissao', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
  function listarDataEmissao($id,$modulo){
	 
	$sql = "select data_emissao,DATE_FORMAT(data_emissao,'%d/%m/%Y') as data_emissao_br from cnd_data_emissao where id_cnd = ? and modulo =? order by id desc limit 1";

	$query = $this->db->query($sql, array($id,$modulo));

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
  
    function listarCidade($idContratante,$tipo){
	$this->db->distinct();
	$this -> db -> select('loja.cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id');
	$this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
   
  }
  
  function listarCndTipoMun($id_contratante,$cidade,$tipo ){

   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_mobiliaria'); 
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('loja.cidade', $cidade);
   if($tipo <> 'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
  function listarCndTipoId($id_contratante,$id,$tipo){

   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_mobiliaria'); 
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   $this -> db -> where('cnd_mobiliaria.id', $id);
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarCndTipoEst($id_contratante,$estado,$tipo ){

   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.razao_social as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_mobiliaria'); 
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   if($tipo <> 'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
	}
   $this -> db -> where('loja.estado', $estado);
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
 
 function listarCndTipoReg($id_contratante,$regional,$tipo ){
	 
	if($tipo == 5){	
	   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
	   $this -> db -> from('cnd_mobiliaria'); 
	   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
	   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
	   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
	   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
	   $this -> db -> where('loja.regional', $regional);
	   $this -> db -> order_by('emitente.nome_fantasia');
		
	}else{
	   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
	   $this -> db -> from('cnd_mobiliaria'); 
	   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
	   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
	   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
	   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
	   $this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
	   $this -> db -> where('loja.regional', $regional);
	   $this -> db -> order_by('emitente.nome_fantasia');
	}


   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }
 }
  function listarCndTipo($id_contratante,$tipo ){

   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_mobiliaria');
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> join('imovel','imovel.id = loja.id_imovel');  
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   if($tipo <> 'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
   }
   $this -> db -> order_by('emitente.nome_fantasia');
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else{
     return false;
   }


 }

  function listarCnd($id_contratante,$_limit = 30, $_start = 0,$cidade,$estado ){


   $this -> db ->limit( $_limit, $_start ); 	


   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as raz_soc,emitente.cpf_cnpj as cpf_cnpj_loja,loja.ins_cnd_mob,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');


   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');


   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   
   if($cidade){
	$this -> db -> where('loja.cidade', $cidade);
	$this -> db -> where('loja.estado', $estado);
   
   }
   
   $this -> db -> order_by('emitente.nome_fantasia');


   $query = $this -> db -> get();


   //print_r($this->db->last_query());exit;


   if($query -> num_rows() <> 0) {
     return $query->result();

   } else{

     return false;

   }


 }

 function contaCndRegional($id_contratante,$ano,$tipo,$reg){
	 if($tipo == 0){
		 $sql = "SELECT count(`cnd_mobiliaria`.`possui_cnd`) as total FROM (`cnd_mobiliaria`) 
		left JOIN  `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`  JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `regional` ON `regional`.`id` = `loja`.`regional`  JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
		 WHERE `cnd_mobiliaria`.`id_contratante` = ? and regional.id = ?
	  ";
	 $query = $this->db->query($sql, array($id_contratante,$reg));
	 }elseif($tipo <> 4){
		 $sql = "SELECT count(`cnd_mobiliaria`.`possui_cnd`) as total FROM (`cnd_mobiliaria`) 
		left JOIN  `loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id`  JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `regional` ON `regional`.`id` = `loja`.`regional`  JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
		 WHERE `cnd_mobiliaria`.`id_contratante` = ? and cnd_mobiliaria.possui_cnd = ? and regional.id = ?
	  ";
	 $query = $this->db->query($sql, array($id_contratante,$tipo,$reg));	
	 }else{
		 
		  $sql = "SELECT count(*) as total FROM (`loja`) 
		JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
		JOIN `regional` ON `regional`.`id` = `loja`.`regional`  
		JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
		 WHERE `loja`.`id_contratante` = ? and regional.id = ?
		 and loja.id not in (select id_loja from cnd_mobiliaria where id_contratante = ?)
	  ";
	 $query = $this->db->query($sql, array($id_contratante,$reg,$id_contratante));	
		 
	 }
	 
	 if($query -> num_rows() <> 0){
		 return $query->result();
	 }else{
		 return false;
	 }
 }
 
 function regionais(){
   $this -> db -> select('id,descricao');
   $this -> db -> from('regional');  
   $query = $this -> db -> get();
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
 function contaCnd($id_contratante,$ano){


 $sql = "SELECT count(`cnd_mobiliaria`.`possui_cnd`) as total, `possui_cnd` FROM (`cnd_mobiliaria`) 
left JOIN 
`loja` ON `cnd_mobiliaria`.`id_loja` = `loja`.`id` 
JOIN `emitente` ON `emitente`.`id` = `loja`.`id_emitente` 
JOIN `regional` ON `regional`.`id` = `loja`.`regional` 
JOIN `bandeira` ON `bandeira`.`id` = `loja`.`bandeira`
 WHERE `cnd_mobiliaria`.`id_contratante` = ? GROUP BY `cnd_mobiliaria`.`possui_cnd` 
 union select count(*) as total, '99' from loja l
 JOIN `emitente` ON `emitente`.`id` = l.`id_emitente` 
JOIN `tipo_emitente` ON `tipo_emitente`.`id` = `emitente`.`tipo_emitente` 
JOIN `regional` ON `regional`.`id` = l.`regional` 
JOIN `bandeira` ON `bandeira`.`id` = l.`bandeira` 
 where l.id not in (select id_loja from cnd_mobiliaria) and l.id_contratante = ?";
	$query = $this->db->query($sql, array($id_contratante,$id_contratante));
	
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
 
 function listarIptuCsv($id_contratante,$tipo){


 
 $this -> db -> select('*,loja.ins_cnd_mob,cnd_mobiliaria.ativo as status_cnd,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');

   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');
   
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }
   
   	$this -> db -> order_by('loja.id');

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
 
  function listarIptuCsvByCidade($id,$tipo){

	$this -> db -> select('*,loja.ins_cnd_mob,cnd_mobiliaria.ativo as status_cnd,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');
   
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');

   $this -> db -> where('loja.cidade', $id);
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }
   
   	$this -> db -> order_by('loja.id');

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
 
 function getStatusInscricaoLojaByEstado($id){


   $this -> db -> select('ins_cnd_mob');

   $this -> db -> from('loja');
   
   $this -> db -> where('loja.estado', $id);
      	

   $query = $this -> db -> get();

  print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return false;

   }

 }
 
 function listarIptuCsvByEstado($id,$tipo){


   $this -> db -> select('*,loja.ins_cnd_mob,cnd_mobiliaria.ativo as status_cnd,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');
   
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');

   $this -> db -> where('loja.estado', $id);
   
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }
   
   	$this -> db -> order_by('loja.id');

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
 
 function listarTodasCidades(){

   $this->db->distinct();
   $this -> db -> select('imovel.cidade');
   $this -> db -> from('imovel');   
   $this -> db -> join('iptu','imovel.id = iptu.id_imovel'); 
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_iptu = iptu.id');   
   $this -> db -> order_by('imovel.cidade');

   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return 0;

   }

 }
 
 function listarEmitenteById($id){

   $this -> db -> select('emitente.id,emitente.nome_fantasia as razao_social,emitente.cpf_cnpj,loja.id as id_loja,loja.ins_cnd_mob as inc_cnd_mob');

   $this -> db -> from('emitente');
   
   $this -> db -> join('loja','emitente.id = loja.id_emitente'); 

   $this -> db -> where('loja.id', $id);

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
 
 function listarEmitentes($id_contratante){

   $this -> db -> select('emitente.id,emitente.nome_fantasia as razao_social');

   $this -> db -> from('emitente');

   $this -> db -> join('tipo_emitente','tipo_emitente.id = emitente.tipo_emitente');

   $this -> db -> where('id_contratante', $id_contratante);

   $this -> db -> where('tipo_emitente', 4);
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
 
 function listarCidadeByEstado($idContratante,$id,$tipo){
	
	$this->db->distinct();
	$this -> db -> select('loja.cidade as cidade');
	$this -> db -> from('loja'); 
	$this -> db -> join('emitente','loja.id_emitente = emitente.id');
	$this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id');
	$this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);
	$this -> db -> where('loja.estado', $id);
	if($tipo <> 'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
	}
	$this -> db -> order_by('loja.cidade');
	$query = $this -> db -> get();



   //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0)

   {

     return $query->result();

   }

   else

   {

     return 0;

   }

 }
 
 function listarIptuCsvById($id,$tipo){
 
   $this -> db -> select('*,loja.ins_cnd_mob,cnd_mobiliaria.ativo as status_cnd,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> join('regional','regional.id = loja.regional');
   
   $this -> db -> join('bandeira','bandeira.id = loja.bandeira');

   $this -> db -> where('loja.id', $id);
   
    if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }
   
   $this -> db -> order_by('loja.id');
   
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 

 }

 function somarTodos($idContratante,$cidade,$estado){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_mobiliaria');
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
     if($cidade){
	$this -> db -> where('loja.cidade', $cidade);
	$this -> db -> where('loja.estado', $estado);
   
   }
   $this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }

   function somarTodosTipo($idContratante,$cidade,$estado,$tipo){
   $this -> db -> select('count(*) as total');
   $this -> db -> from('cnd_mobiliaria');
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
   if($cidade){
	$this -> db -> where('loja.cidade', $cidade);
	$this -> db -> where('loja.estado', $estado);
   
   }
   $this -> db -> where('cnd_mobiliaria.id_contratante', $idContratante);   
 
   $query = $this -> db -> get();

   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0) {
     return $query->result();
   } else {
     return false;
   }
  }
  
  function status_iptu(){
   $this -> db -> select('status_iptu.id,status_iptu.descricao');
   $this -> db -> from('status_iptu');
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
 
 function listarInscricaoByIptu($id){
   $this->db->distinct();
   $this -> db -> select('iptu.id,iptu.inscricao');
   $this -> db -> from('iptu');
   $this -> db -> join('imovel','iptu.id_imovel = imovel.id','left');
   $this -> db -> where('iptu.id', $id);

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
 

function listarTodasInscricoes($id_contratante){
   $this->db->distinct();
   $this -> db -> select('iptu.id,iptu.inscricao');
   $this -> db -> from('iptu');
   $this -> db -> join('imovel','iptu.id_imovel = imovel.id','left');
   $this -> db -> where('imovel.id_contratante', $id_contratante);
   $this -> db -> order_by('iptu.inscricao');

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
 
  function listarLoja($id_contratante,$tipo){
   $this->db->distinct();
   $this -> db -> select('cnd_mobiliaria.id,emitente.nome_fantasia as  nome');
   $this -> db -> from('loja');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> join('cnd_mobiliaria','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> where('cnd_mobiliaria.id_contratante', $id_contratante);
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }
   
   $this -> db -> order_by('loja.id');

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
 
 function listarImovelByEstado($id,$tipo){
   $this -> db ->distinct();
	
   $this -> db -> select('emitente.id,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('loja.estado', $id);
   if($tipo<>'X'){
		$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);
   }
   $this -> db -> order_by('emitente.id');
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
	if($query -> num_rows() <> 0){
     return $query->result();
	}else{
     return false;
   }

 }
 
function listarImovelByCidade($id,$tipo){


	$this -> db ->distinct();
	$this -> db -> select('cnd_mobiliaria.id,emitente.nome_fantasia as nome');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   $this -> db -> where('loja.cidade', $id);
   if($tipo <> 'X'){
	 $this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);  
   }	
	$query = $this -> db -> get();

  //print_r($this->db->last_query());exit;

   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }

 }
 
 
  public function add($detalhes = array()){

 

	if($this->db->insert('cnd_mobiliaria', $detalhes)) {
		
		
				
		$id = $this->db->insert_id();
		

		return $id;


	}

	

	return false;

	}
	
	 function listarCNDById($id){
   $this -> db -> select('*');
   $this -> db -> from('cnd_mobiliaria');
   $this -> db -> where('cnd_mobiliaria.id', $id);   
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return false;
   }
 }
 
	function atualizar($dados,$id){

 

	$this->db->where('id', $id);

	$this->db->update('cnd_mobiliaria', $dados); 

	//print_r($this->db->last_query());exit;

	return true;

  

 } 
 
 	function atualizar_loja($inscricao,$id){

		$dados = array(
			'ins_cnd_mob' => $inscricao
		);

	$this->db->where('id', $id);

	$this->db->update('loja', $dados); 

	//print_r($this->db->last_query());exit;

	return true;

  

 } 
 
 function listarCidadeEstadoById($id){
	
  $this -> db -> select('loja.id,loja.cidade,loja.estado ');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   

   $this -> db -> where('cnd_mobiliaria.id', $id);   


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
 
 function listarInscricaoByLoja($id){
	
  $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,loja.ins_cnd_mob as ins_cnd_mob,loja.id as id_loja,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp ');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   

   $this -> db -> where('cnd_mobiliaria.id', $id);   


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
 
	function listarInscricaoById($id){
	
   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('imovel','imovel.id = loja.id_imovel');
   

   $this -> db -> where('cnd_mobiliaria.id', $id);   


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
 
 function listarLojaByImovel($id_loja,$tipo){
	 
   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');
   $this -> db -> from('cnd_mobiliaria'); 
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
     
   if($id_loja <> 0){
	$this -> db -> where('loja.id', $id_loja);   
   }	
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }	
   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }

   
  function listarImovelByUf($estado,$tipo){
	 
	
   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> where('loja.estado', $estado);  
  
   if($tipo <> 'X'){
	$this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);   
   }	
 
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function listarImovelPendente(){
	 
	
   $this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   $this -> db -> where('cnd_mobiliaria.possui_cnd', '3');  
  
 
   $query = $this -> db -> get();
	//print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 
   function listarImovelByMunicipio($municipio,$tipo){
	 
	$this -> db -> select('*,cnd_mobiliaria.ativo as status_insc,cnd_mobiliaria.id as id_cnd,emitente.nome_fantasia as nome,(select distinct loja.id from acomp_cnd where acomp_cnd.id_loja = loja.id) as loja_acomp,loja.id as id_loja');

   $this -> db -> from('cnd_mobiliaria');
   
   $this -> db -> join('loja','cnd_mobiliaria.id_loja = loja.id');

   
   $this -> db -> join('emitente','emitente.id = loja.id_emitente');
   
   
   $this -> db -> where('loja.cidade', $municipio);  

   if($tipo <> 'X'){
	 $this -> db -> where('cnd_mobiliaria.possui_cnd', $tipo);    
   }

   $query = $this -> db -> get();
   //print_r($this->db->last_query());exit;
   if($query -> num_rows() <> 0){
     return $query->result();
   }else{
     return 0;
   }

 }
 

}


?>