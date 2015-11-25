<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class db extends Conn{
	private $res;
	private $tabela;
	private $campos = array();
	private $valores = array();
	private $condicao = '';
	private $orderBy = '';
	private $limit = '';
	private $pdo = null;

	public function __construct() 
	{
		$this->pdo = Conn::connect();
	}

	public function setTabela($tabela)
	{
		$this->tabela = $tabela;
	}

	public function setCampos($campos)
	{
		if(is_array($campos))
			$this->campos = $campos;
		else
			die('Informe um tipo array para o metodo setCampos');
	}

	public function setValores($valores)
	{
		if(is_array($valores))
			$this->valores = $valores;
		else
			die('Informe um tipo array para o metodo setValores');
	}


	public function  setCondicao($cond)
	{
		$this->condicao = $cond;
	}


	public function setOrderBy($orderBy = '')
	{
		$this->orderBy = $orderBy;
	}

	public function setLimit($limit1='', $limit2 = null)
	{
		if($limit2 != null)
			$this->limit = $limit1.','.$limit2;	
		else
			$this->limit = $limit1;	
	}

	private function prepare_values($values)
	{
		if(count($this->campos) == count($this->valores))
		{
			$ar_val = array();
			foreach ($this->campos as $key => $val){
				$ar_val[$val] = $this->valores[$key];
			}
			return $ar_val;
		}else
		{
			die('A quantidade de campos não é compativel com a quantidade de valores');
		}
	}

	public function insert($values = NULL)
	{
		if(!is_string($values))
		{
			if(is_array($values))
				$this->res = new insert($this->pdo,$this->tabela,$values);
			else
			{
				$val = $this->prepare_values($this->campos,$this->valores);
				$this->res = new insert($this->pdo,$this->tabela,$val);
			}
		}else
		{
			die('Parâmetros do insert passados incorretamente');
		}
		return $this->res;
	}


	public function update($values = NULL)
	{

		if(!is_string($values))
		{
			if(is_array($values))
				$this->res = new update($this->pdo, $this->tabela, $values, $this->condicao );
			else
			{
				$val = $this->prepare_values( $this->campos, $this->valores );
				$this->res = new update($this->pdo, $this->tabela, $val, $this->condicao );
			}
		}else
		{
			die('Parâmetros do update passados incorretamente');
		}
		return $this->res;
	}

	public function select($campos = NULL)
	{
		
		if($campos != NULL)
		{
			if(is_array($campos))
			{
				$this->res = new select($this->pdo, $this->tabela, $campos, $this->condicao, $this->orderBy, $this->limit);
			}else
			{
				die('Parâmetros passados incorretamente. Informe um tipo array para o método select');
			}
		}else
		{
			$this->res = new select($this->pdo, $this->tabela, $this->campos, $this->condicao, $this->orderBy, $this->limit);
		}
		return $this->res;
	}

	public function query($sql= null)
	{
		if($sql == null)
			die('Informe o comando sql corretamente.');
		else
			$this->res = new query($this->pdo, $sql);
	}


	public function delete()
	{
		if($this->condicao != '')
			$this->res = new delete($this->pdo, $this->tabela, $this->condicao );
		else
			die('Informe a condição do delete');

		return $this->res;
	}


	public function resultAll($tipo = 0)
	{
		$result = $this->res->fetchAll($tipo);
		return $result;
	}


	public function result($tipo = 0)
	{
		$result = $this->res->fetch($tipo);
		return $result;
	}


	public function rowCount()
	{
		return $this->res->rows_affected();
	}

	public function getError()
	{
		return $this->res->getError();	
	}

	
	public function getUltimoId()
	{
		return $this->res->getUltimoId();	
	}

	public function getSql()
	{
		return $this->res->getSql();
	}


	public function clear()
	{
		$this->res = null;
		$this->tabela = '';
		$this->campos = array();
		$this->valores = array();
		$this->condicao = '';
		$this->orderBy = '';
		$this->limit = '';
	}
	

}
