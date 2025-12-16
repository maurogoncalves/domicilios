<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$dbh = new PDO('mysql:host=localhost;dbname=domicilio-loja', 'root', '', array(PDO::ATTR_PERSISTENT => true));
$handle = fopen('cnpj1.csv', "r");
$n_linha=0;
while (($data = fgetcsv($handle,2000, ";")) !== FALSE) {
    if($n_linha == 0){
    }else{
		$id_contratante = 1;
		
	
		$cnpjRaiz = $data[0];
		$cnpj = $data[1];		
		$bandeira = 1;				
		
		
		
		print$sql = "insert into cnpj  (id_contratante,id_cnpj_raiz,cnpj,id_bandeira,ativo)  values ($id_contratante,'$cnpjRaiz','$cnpj','$bandeira',1);"; 
			 //$stmt = $dbh->prepare($sql);
			// $stmt->execute();
			 //$idInserido = $dbh->lastInsertId();
			
		print'<BR>';
	}
	$n_linha++;	
}


fclose($handle);


?>