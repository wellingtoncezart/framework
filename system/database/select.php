<?php
/**
* Classe para select do banco. Pode ser utilizada diretamete ou através da classe db
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 1.0
*
*/

if(!defined('BASEPATH')) die('Acesso não permitido');
class select extends error_db
{
	private $rows_affected = 0;
	private $result;
	private $statement;
	private $pdo;
	private $sql;
	private $error;

	public function __destruct()
	{
		$this->statement->closeCursor();
	}

	public function __construct($pdo, $table,$column = null, $cond = '', $order = '', $limit = '')
	{

		$this->pdo = $pdo;
		$this->statement = null;
		parent::__construct();
		
		if($column != null)
		{
			$campos = '';
			$campos = implode(', ', $column);
		}else
			$campos = '*';

		$this->sql  = "SELECT ".$campos." FROM ".$table." ";
		if($cond != '')
			$this->sql .= " WHERE ".trim($cond);

		if($order != '')
			$this->sql .= " ORDER BY ".trim($order);

		if($limit != '')
			$this->sql .= " LIMIT ".trim($limit);


		$this->statement = $this->pdo->prepare($this->sql);
		try{ 
		    $this->statement->execute();
		    $this->rows_affected = $this->statement->rowCount();
			if($this->rows_affected > 0)
				return true;
			else
			{
				$this->error = $this->getMensagemErro('NULLSELECT','selecionar');
				$this->rows_affected = 0;
				return false;
			}
		}catch (PDOException $e)
		{
		    $this->error = $this->getMensagemErro($e,'selecionar');
		    $this->rows_affected = 0;
			return false;
		}
	}


	public function fetchAll($tipo = 0)
	{
		if($this->rows_affected > 0)
		{
			if($tipo == 0) //todos
				return $this->statement->fetchAll(PDO :: FETCH_BOTH);
			else
			if($tipo == 1)//penas os nomes dos campos
				return $this->statement->fetchAll(PDO :: FETCH_ASSOC);
			else
			if($tipo == 2)//apenas como classe
				return $this->statement->fetchAll(PDO::FETCH_CLASS);
		}else{

			return false;
		}

	}


	public function fetch($tipo = 0)
	{
		if($this->rows_affected > 0)
		{
			if($tipo == 0) //todos
				return $this->statement->fetch(PDO :: FETCH_BOTH);
			else
			if($tipo == 1)//penas os nomes dos campos
				return $this->statement->fetch(PDO :: FETCH_ASSOC);
		}else{
			return false;
		}


	}

	public function rows_affected()
	{
		return $this->statement->rowCount();
	}
	
	public function getSql()
	{
		return $this->sql;
	}

	public function getError()
	{
		return $this->error;
	}
}
