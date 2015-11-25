<?php 

//TEMPO DE EXECUÇÃO
// Iniciamos o "contador"
list($usec, $sec) = explode(' ', microtime());
$script_start = (float) $sec + (float) $usec;

/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/

if (!version_compare(PHP_VERSION, '5.4.0', '>=')) {
   echo 'I am at least PHP version 5.4.0, my version: ' . PHP_VERSION . "\n";
   exit;
}
define('APPPATH','app');

require_once('include.php');

class _initialize extends Router{
	public function __construct(){
		parent::__construct();
		
		$this->rout = '';
		$this->explodeUri();

		/*
		apenas para checagem dos caminhos
		//echo '<p>ROUT FILE: '.$routFile.'</p>';
		echo '<pre >';
		echo '<p>ROTA COMPLETA: '.$this->getRoute().'</p>';
		echo '<p>NOME Controller: '.$this->getController().'</p>';
		echo '<p>NOME METODO: '.$this->getAction().'</p>';
		echo '</pre>';
		*/
		if($this->load->controller($this->getRoute().$this->getController()))
		{
			$_controller = $this->getController();
			$action = $this->getAction();
			if(method_exists($this->$_controller, $action))
			{
				$this->$_controller->$action();
			}else
			{
				$_message_error = "<p><strong>DESCULPE-NOS</strong></p>
								<p>A página que você procura não foi encontrada.</p>
								<p>Verifique o endereço digitado ou tente novamente mais tarde.</p>
								";
				require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.ERRORDIR.DIRECTORY_SEPARATOR.'error_404.php');
			}
		}else{
			$_message_error = "<p><strong>DESCULPE-NOS</strong></p>
								<p>A página que você procura não foi encontrada.</p>
								<p>Verifique o endereço digitado ou tente novamente mais tarde.</p>";
			require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.ERRORDIR.DIRECTORY_SEPARATOR.'error_404.php');
		}
	}
}

new _initialize;

//$this->load('url');





// Tempo de execução
list($usec, $sec) = explode(' ', microtime());
$script_end = (float) $sec + (float) $usec;
$elapsed_time = round($script_end - $script_start, 5);
//echo '<pre style="position: absolute;width: 100%;bottom: 0;margin: 0;z-index: 999;background-color: #383838;color: #FFF;font-size: 17px;">Elapsed time: ', $elapsed_time, ' secs. Memory usage: ', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb</pre>';
