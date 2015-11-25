<?php
/**
* Classe para insert do banco. Pode ser utilizada diretamete ou através da classe db
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 1.0
*
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class insert extends error_db{
	private $rows_affected;
	private $pdo;
	private $statement;
	private $sql;
	private $error;

	public function __construct($pdo,$table,$value)
	{
		parent::__construct();
		$this->pdo = $pdo;
		$this->insert($table,$value);
	}

	public function __destruct()
	{
		$this->statement->closeCursor();
	}
	public function insert($table, $value)
	{
		$campos='';
		$valores = '';
		$param = '';
		$n = count($value);
		$i = 0;

		foreach($value AS $key => $val)
		{
			$key = trim($key);
			if( $i < $n-1 )
			{
				$campos .= $key.", ";
				$param .= ":".htmlentities($key).", ";
			}
			else
			{
				$campos .= $key."";
				$param .= ":".htmlentities($key)."";
			}
			$paramArray[":".$key.""]= filter_var(trim(htmlentities($val)));
			$i++;
		}

		$this->sql  = "INSERT INTO ".$table." (".$campos.") VALUES (".$param.")";
		$this->statement = $this->pdo->prepare($this->sql);
		
		try{
			$this->statement->execute($paramArray);

			$this->rows_affected = $this->statement->rowCount();

			if($this->rows_affected > 0){
				$this->ultimoId = $this->pdo->lastInsertId();
				return true;
			}else
			{
				$this->error = $this->getMensagemErro('NULLINSERT','inserir');
				return false;
			}
		} catch (PDOException $e){

		    $this->error = $this->getMensagemErro($e,'inserir',$param);
		    $this->rows_affected = 0;
			return false;
		} 
	}

	public function rows_affected()
	{
		return $this->rows_affected;
	}

	public function getUltimoId(){
		return intval($this->ultimoId);
	}


	public function getError()
	{
		return $this->error;
	}
}
