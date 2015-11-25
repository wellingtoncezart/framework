<?php
/**
* Classe para envio de email
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 1.0
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class email
{
	private $para;
	private $de;
	private $nome = '';
	private $assunto = 'Sem título';
	private $mensagem;
	private $returnPath;
	private $cc;
	private $bcc;
	private $error;
	private $anexo = false;
	private $headers = '';

	public function para($para)
	{
		$this->para = $para;
	}

	public function de($de)
	{
		$this->de = $de;
	}

	public function nome($nome)
	{
		$this->nome = $nome;
	}

	public function assunto($assunto)
	{
		$this->assunto = $assunto;
	}

	public function mensagem($mensagem)
	{
		$this->mensagem = $mensagem;
	}

	public function returnPath($returnPath)
	{
		$this->returnPath = $returnPath;
	}

	public function cc($cc)
	{
		$this->cc = $cc;
	}

	public function bcc($bcc)
	{
		$this->bcc = $bcc;
	}

	public function getError()
	{
		return $this->error;
	}

	public function anexo($anexo = false)
	{
		return $this->anexo = $anexo;
	}

	public function send()
	{
		if($this->anexo != false)
		{
			$prepare = $this->prepareSendAnexo();//email com anexo
		}else{
			$prepare = $this->prepareSend(); // email sem anexo
		}

		if($prepare != false){
			if(!mail($this->para, $this->assunto, $this->mensagem,$this->headers,"-r")){
				$this->error = 'Erro ao enviar o email';
			}else{
				return true;
			}
		}else
			return false;
	}

	private function prepareSendAnexo()
	{
		 if(file_exists($this->anexo["tmp_name"]) and !empty($this->anexo))
		 {
		 	if(	$this->de != '' 
				&& $this->para != ''  
				&& $this->mensagem != '')
			{
				$this->para 		= trim($this->para);
				$this->de 		= trim($this->de);

				$arquivo = $this->anexo;
				//$this->mensagem = wordwrap( $this->mensagem, 50, " ", 1);

				$fp = fopen($this->anexo["tmp_name"],"rb");
				$this->anexo = fread($fp,filesize($this->anexo["tmp_name"]));
				$this->anexo = base64_encode($this->anexo);
				fclose($fp);
				$this->anexo = chunk_split($this->anexo);
				$boundary = "XYZ-" . date("dmYis") . "-ZYX";
				$mens = "--$boundary\n";
				$mens .= "Content-Transfer-Encoding: 8bits\n";
				$mens .= "Content-Type: text/html; charset=\"UTF-8\"\n\n"; //plain
				$mens .= $this->mensagem."\n";
				$mens .= "--$boundary\n";
				$mens .= "Content-Type: ".$arquivo["type"]."\n";
				$mens .= "Content-Disposition: attachment; filename=\"".$arquivo["name"]."\"\n";
				$mens .= "Content-Transfer-Encoding: base64\n\n";
				$mens .= "$this->anexo\n";
				$mens .= "--$boundary--\r\n";
				$this->mensagem = $mens;


				$this->headers = "MIME-Version: 1.0\n";
				$this->headers = "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
				$nome = '';
				if($this->nome != '')
				{
					$nome = $this->nome;
				}

				$this->headers .= "From: $nome <".$this->de.">\r\n";

				if($this->cc != '')
				{
					$this->headers .= "Cc: ".trim($this->cc)."\r\n";
				}
				
				if($this->bcc != '')
				{
					$this->headers .= "Bcc: ".trim($this->bcc)."\r\n";
				}

				if($this->returnPath != '')
				{
					$this->headers .= "Return-Path: ".trim($this->returnPath)."\r\n";
				}else
					$this->headers .= "Return-Path: ".trim($this->de)."\r\n";
				
				$this->headers .= "$boundary\n";
				return true;
			}else
			{
				$this->error = 'Informe os dados corretamente';
				return false;
			}

		 }else
		 	echo "Anexo não encontrado";
		

	}

	
	private function prepareSend(){
		if(	$this->de != '' 
			&& $this->para != ''  
			&& $this->mensagem != '')
		{
			$this->para 		= trim($this->para);
			$this->de 		= trim($this->de);

			$this->headers = "Content-type: text/html; charset=UTF-8\r\n";

			$nome = '';
			if($this->nome != '')
			{
				$nome = $this->nome;
			}

			$this->headers .= "From: $nome <".$this->de.">\r\n";

			if($this->cc != '')
			{
				$this->headers .= "Cc: ".trim($this->cc)."\r\n";
			}
			
			if($this->bcc != '')
			{
				$this->headers .= "Bcc: ".trim($this->bcc)."\r\n";
			}

			if($this->returnPath != '')
			{
				$this->headers .= "Return-Path: ".trim($this->returnPath)."\r\n";
			}else
				$this->headers .= "Return-Path: ".trim($this->de)."\r\n";
			return true;
		}else
		{
			$this->error = 'Informe os dados corretamente';
			return false;
		}
	}

}