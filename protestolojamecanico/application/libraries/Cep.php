<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cep {
	
	public function __construct(){

    }
	
    public function busca_cep($cep){
		
		
		include('phpQuery-onefile.php');
		
				
		function simple_curl($url,$post=array(),$get=array()){
			$url = explode('?',$url,2);
			if(count($url)===2){
				$temp_get = array();
				parse_str($url[1],$temp_get);
				$get = array_merge($get,$temp_get);
			}

			$ch = curl_init($url[0]."?".http_build_query($get));
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
			curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			return curl_exec ($ch);
		}

		$html = simple_curl('http://m.correios.com.br/movel/buscaCepConfirma.do',array(
			'cepEntrada'=>$cep,
			'tipoCep'=>'',
			'cepTemp'=>'',
			'metodo'=>'buscarCep'
		));
		
		phpQuery::newDocumentHTML($html, $charset = 'utf-8');

		$obj = 
		array(
			'logradouro'=> trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html()),
			'bairro'=> trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
			'cidade/uf'=> trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html()),
			'cep'=> trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html())
		);
		
		$obj['cidade/uf'] = explode('/',$obj['cidade/uf']);
		$obj['cidade'] = trim($obj['cidade/uf'][0]);
		$obj['uf'] = trim($obj['cidade/uf'][1]);
		unset($obj['cidade/uf']);

		echo(json_encode($obj));
		

		/*
		print "\n".strip_tags($campoTabela[0][0]); // rua
		print "\n".strip_tags($campoTabela[0][1]); // bairro
		print "\n".strip_tags($campoTabela[0][2]); // cidade
		print "\n".strip_tags($campoTabela[0][3]); // estado
		print "\n".strip_tags($campoTabela[0][4]); // cep
		print "\n";
			*/	
				
		
    }
}

/* End of file Someclass.php */