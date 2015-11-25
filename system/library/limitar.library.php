<?php
    /*
    * 
    * @access restrito
    * @since 20/11/2013
    * @version 2.0
    * @author Wellington cezar - wellington-cezar@hotmail.com
    * 
    */
if(!defined('BASEPATH')) die('Acesso não permitido');
class limitar
{
	private $string;
	private $tamanho;
	private $tipo = 'letra';
	private $continue = ' [...]';
	private $encode = 'UTF-8';

	public function __construct()
	{
		//return $this;
	}

	public function setString($string)
	{
		$this->string = $string;
		return $this;
	}

	public function setTamanho($tamanho)
	{
		$this->tamanho = $tamanho;
		return $this;
	}

	public function setTipo($tipo)
	{
		$this->tipo = $tipo;
		return $this;
	}

	public function setContinue($contnue)
	{
		$this->continue = $continue;
		return $this;
	}

	public function setEncode($encode)
	{
		$this->encode = $encode;
		return $this;
	}


	function getLimitar()
	{
		if($this->tipo == 'palavra')//limita por palavras
		{
			$palavras = explode(' ',$this->string);

			if( count($palavras) > $this->tamanho )
			{
				$str=$palavras[0];
				$i=1;
				while($i < $this->tamanho)
				{
					$str .= ' '.$palavras[$i];
					$i++;
				}
				$this->string = trim($str).$this->continue;
		        //$this->string = mb_substr($this->string, 0, $this->tamanho - 3, $encode) . '...';
			}
		    else
		        $this->string = $this->string;
		}else
		{
		    if( strlen($this->string) > $this->tamanho )
		        $this->string = mb_substr($this->string, 0, $this->tamanho - 3, $this->encode) . $this->continue;
		    else
		        $this->string = mb_substr($this->string, 0, $this->tamanho, $this->encode);
		}
		return $this->string;
	}

}