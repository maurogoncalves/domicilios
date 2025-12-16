<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$dbh = new PDO('mysql:host=localhost;dbname=bd_protesto_smart', 'root', '', array(PDO::ATTR_PERSISTENT => true));
$handle = fopen('carga_inscricao.csv', "r");
$n_linha=0;
while (($data = fgetcsv($handle,2000, ";")) !== FALSE) {
    if($n_linha == 0){
    }else{
		$id_contratante = 1;
		
	
		$cnpj = $data[0];
		$im = $data[1];		
		$ie = $data[2];		
		
		
		
		$consulta = $dbh->prepare("SELECT id as id_cnpj FROM cnpj e  WHERE e.cnpj ='$cnpj'");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_cnpj = $dados['id_cnpj'];
		
		
		if(!empty($im)){
			print$sql = "insert into inscricao  	(id_cpnj,numero,tipo,ativo) 		values  		($id_cnpj,'$im','1',1);";
			print'<BR>';
		}	
		if(!empty($ie)){
			print$sql = "insert into inscricao  	(id_cpnj,numero,tipo,ativo) 		values  		($id_cnpj,'$ie','2',1);";
			print'<BR>';
		}	
			// $stmt = $dbh->prepare($sql);
			// $stmt->execute();
			// $idInserido = $dbh->lastInsertId();
			
		
	}
	$n_linha++;	
}


fclose($handle);


?>