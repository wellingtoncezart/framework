<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class Router extends Common{
	private $url;
	private $currentUrl;
	private $_controller;
	private $_route;
	private $_action;

	public function __construct()
	{
		if (!defined('URL'))
		{
			if (isset($_SERVER['HTTP_HOST']))
			{
				$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
				$base_url .= '://'. $_SERVER['HTTP_HOST'];
				$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
			}else
			{
				$base_url = 'http://localhost/';
			}
			define('URL',$base_url);
		}
		
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

		parent::__construct();
	}

	public function getRoute(){
		return $this->_route;
	}
	public function getController(){
		return $this->_controller;
	}
	public function getAction(){
		return $this->_action;
	}

	public function explodeUri()
	{
		if(!empty($this->url)){
			foreach ($this->url as $key => $value) 
			{
				if($this->checkDir($this->_route.$value))
				{
					$this->_route .= $value.DIRECTORY_SEPARATOR;
				
					if(!isset($this->url[$key+1])){
						$this->_controller = DEFAULT_CONTROLLER;
						$this->_action = "index";
					}
				}else
				{
					$this->_controller 	= ucfirst($value);
					if(isset($this->url[$key+1]))
						$this->_action = $this->url[$key+1];
					else
						$this->_action = "index";
					break;
				}

			}
		}else{
			$this->_controller = DEFAULT_CONTROLLER;
			$this->_action = "index";
		}
		
	}

	/**
     * @access public
     * @return booleam
     */
    public function checkDir($dir){
        if(is_dir(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.$dir))
            return true;
        else
            return false;
    }
}