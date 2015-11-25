<?php
/**
* Classe de upload de arquivos
* @access 
* @author Wellington cézar
* @since 14/06/2014
* @version 1.0
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class upload{
	private $_UP = array(
		'tamanho' => 5242880,//5mb -- 1024 * 1024 * 5
		'extensoes' => array('jpg', 'png', 'gif'),
		'errors' => array(
			0 => FALSE,
			1 => 'O arquivo no upload é maior do que o limite do PHP',
			2 => 'O arquivo ultrapassa o limite de tamanho especifiado no HTML',
			3 => 'O upload do arquivo foi feito parcialmente',
			4 => 'Não foi feito o upload do arquivo'
			)
	);
	private $error = FALSE;
	private $destino; //caminho do arquivo após o upload
	private $arquivoFinal;//nome do arquivo após o upload 
	public function __construct($arquivo, $dest, $novo_nome = NULL,$extensao = NULL)
	{
		if($extensao != null)
		{
			$this->_UP['extensoes'] = $extensao;
		}

		if($dest == NULL)
		{
			$this->error = ('Não foi definido a pasta de destinho.');
			return false;
		}else
			$this->_UP['pasta'] = $dest;
		
		if ($arquivo['error'] != 0) {
			$this->error = ("Não foi possível fazer o upload, erro:<br />" . $this->_UP['errors'][$arquivo['error']]);
			return false; // Para a execução do script
		}

		$extensao = explode('.', $arquivo['name']);
		$extensao = strtolower(end($extensao));
		if (array_search($extensao, $this->_UP['extensoes']) === false) {
			$this->error = "Por favor, envie arquivos com as seguintes extensões: ". implode(', ',$this->_UP['extensoes']);
			return false;
		}else 
		if ($this->_UP['tamanho'] < $arquivo['size']) {
			$this->error =  "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
			return false;
		}else 
		{
			if ($novo_nome != NULL) {
				$nome_final = $novo_nome.'.'.$extensao;
			} else {
				$nome_final = $arquivo['name'];
			}

			$this->arquivoFinal = $nome_final;
			$this->destino = $this->_UP['pasta'] . $nome_final;
			/*
			//UPLOAD VIA FTP
			$ftp = URLFTP;
			$username = LOGINFTP;
			$pwd = SENHAFTP;
			$filename = $this->destino;
			$tmp = $arquivo['tmp_name'];
			//$d = $_POST['des'];

			$connect = ftp_connect($ftp)or die("Unable to connect to host");
			ftp_login($connect,$username,$pwd)or die("Authorization Failed");

			ftp_put($connect,CAMINHOFTP.'/'.$filename,$tmp,FTP_BINARY)or die("Unable to upload");
			*/

			 //UPLOAD VIA HTTP
			if (move_uploaded_file($arquivo['tmp_name'], $this->destino)) {
				return true;
			} else {
				return "Não foi possível enviar o arquivo, tente novamente";
			}
			return true;
		}
	}

	public function setTamanho($tamanho)
	{
		$this->_UP['tamanho'] = $tamanho;
	}

	public function setExtensoes($extensoes)
	{
		if(is_array($extensoes))
			$this->_UP['extensoes'] = $extensoes;
		else
		{
			echo 'Informe um array';
			exit;
		}
	}

	public function getDestino()
	{
		return $this->destino;
	}

	public function getArquivo()
	{
		return $this->arquivoFinal;
	}
	public function getError()
	{
		return $this->error;
	}
}

