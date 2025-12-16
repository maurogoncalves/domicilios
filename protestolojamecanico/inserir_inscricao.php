<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$dbh = new PDO('mysql:host=localhost;dbname=domicilio-loja', 'root', '', array(PDO::ATTR_PERSISTENT => true));
$handle = fopen('cnpj.csv', "r");
$n_linha=0;
while (($data = fgetcsv($handle,2000, ";")) !== FALSE) {
    if($n_linha == 0){
    }else{
		$id_contratante = 1;
		
	
		$cnpj = $data[1];
		$tipo = $data[2];
		$ie = $data[3];		
		$ieSt = $data[4];		
		$iM = $data[5];		
		
		$consulta = $dbh->prepare("SELECT id as id_cnpj FROM cnpj e  WHERE e.cnpj ='$cnpj' ");
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_ASSOC);
		$id_cnpj = $dados['id_cnpj'];
		
		if($tipo == 1){
			
			print$sql = "insert into inscricao  	(id_cpnj,numero,tipo,ativo) 		values  		($id_cnpj,'$ie','$tipo',1);";
			print'<BR>';
			
		}elseif($tipo == 2){
			print$sql = "insert into inscricao  	(id_cpnj,numero,tipo,ativo) 		values  		($id_cnpj,'$ieSt','$tipo',1);";
			print'<BR>';
			
		}elseif($tipo == 3){
			print$sql = "insert into inscricao  	(id_cpnj,numero,tipo,ativo) 		values  		($id_cnpj,'$iM','$tipo',1);";
			print'<BR>';
		}
		
		
	}
	$n_linha++;	
}


fclose($handle);


?>