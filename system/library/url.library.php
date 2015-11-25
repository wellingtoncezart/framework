<?php
/**
* Classe que retorna a url atual
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 1.1
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class url
{
	private $url;
	private $currentUrl;
	public function __construct()
	{
		$server = 'http://'.$_SERVER['SERVER_NAME'].'/'; 
		$endereco = $_SERVER ['REQUEST_URI'];
		$endereco = rtrim($endereco,'/'); //remove as barras do final da string
		$endereco = ltrim($endereco,'/'); //remove as barras do começo da string
		$url = $server.$endereco.'/';//endereço completo
		$this->currentUrl = $url;
		$url = str_replace(URL, '', $url);//remove o endereço original e fica apenas o caminho
		$url = explode('/',$url);
		$url =array_filter($url);//remove todos os índices vazios
		$newArr =array();
		foreach ($url as $value) { //para ordenar o array pelo índice
			$newArr[] = $value;
		}
		$this->url = $newArr;
		unset($url);
		unset($newArr);
	}

	public function getUrl()
	{
		return $this->url;//retorna o array da url
	}

	public function getCurrentUrl()
	{
		return $this->currentUrl;
	}


	public function getSegment($chave)//retorna o segmento da url
	{
		if(array_key_exists($chave, $this->url))//se existir a categoria
			return strtolower($this->url[$chave]);
		else
			return false;
	}

	
}