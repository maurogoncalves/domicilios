<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cep {
	
	public function __construct(){

    }
	
    public function busca_cep($cep){
			
		$cep = str_replace(".", "", $cep);	
		$cep = str_replace("-", "", $cep);	
		
		$resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');  
		if(!$resultado){  
			$obj['logradouro'] = '-';
			$obj['bairro'] = '-';
			$obj['cidade'] = '-';
			$obj['uf'] = '-';			
		}else{
			parse_str($resultado, $retorno);   
			$obj['logradouro'] = $retorno['tipo_logradouro'].' '.$retorno['logradouro'];
			$obj['bairro'] = $retorno['bairro'];
			$obj['cidade'] = $retorno['cidade'];
			$obj['uf'] = $retorno['uf'];
		}  
		
		
		
		echo(json_encode($obj));
		

				
		
    }
}

/* End of file Someclass.php */