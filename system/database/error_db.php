<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class error_db{
	private $msg_error;
	private $showlogMessage = false;
	private $nivel = '';
	public function __construct(){
		$this->showlogMessage = SHOWLOGMESSAGE;
	}

	public function getMensagemErro($code, $tipo, $val = '')
	{
		if(is_object($code))
		{
			switch ($code->getCode()){
				case '23000':
					$this->msg_error = 'Não é possível '.$tipo.'. Já existe um registro com esses dados.';
					break;

				case '1451':
					$this->msg_error = 'Não é possível '.$tipo. '.Existem registros relacionados à ele.';
					break;

				case 'HY000':
					$this->msg_error = 'Não pode encontrar o registro';
					break;

				case '08004':
					$this->msg_error = 'Excesso de conexões';
					break;

				case '21S01':
					$this->msg_error = 'Contagem de colunas não confere com a contagem de valores';
					break;

				case '42S21':
					$this->msg_error = 'Nome da coluna duplicado';
					break;
				default:
					$this->msg_error = 'Outro erro: '.$code->getMessage();
					break;
			}


			if($this->showlogMessage === true)
			{
				$this->showlogMessage = '';
				$traces = array_reverse($code->getTrace());
				foreach ($traces as $ind => $errors) {
					if(is_array($errors))
					{
						$this->showlogMessage .='<pre>';
						foreach ($errors as $key => $value) {
							if(!is_array($value)){
								$this->showlogMessage .= '<p><strong>'.$key.'</strong>: '.$value.'</p>';
							}else
							{
								$this->nivel='';
								$this->getValues($value);
							}
						}
						$this->showlogMessage .='</pre>';
					}else
						$this->showlogMessage .= '<p><strong>'.$ind.'</strong>: '.$value.'</p>';
				}
			}else{
				$this->showlogMessage = '';
			}

		}else
		{
			switch ($code) {
				case 'NULLSELECT':
					$this->msg_error = 'Nenhum registro encontrado';
					break;

				case 'NULLINSERT':
					$this->msg_error = 'Nenhum registro inserido';
					break;

				case 'NULLDELETE':
					$this->msg_error = 'Nenhum registro excluído';
					break;

				case 'NULLUPDATE':
					$this->msg_error = 'Nenhum registro alterado';
					break;

				case 'NULLQUERY':
					$this->msg_error = 'Não foi possível executar';
					break;

				default:
					$this->msg_error = 'Erro indefinido';
					break;
			}

			// if($this->showlogMessage === true)
			// {
			// 	$this->showlogMessage = '';
			// }else
			$this->showlogMessage = '';
		}

		return $this->msg_error.$this->showlogMessage;
	}	


	private function getValues($values, $nivel = '')
	{
		$this->nivel .= $nivel;
		foreach ($values as $key => $value) {
			if(!is_array($value) && !is_object($value))
				$this->showlogMessage .= '<p>'.$this->nivel.'→<strong>'.$key.'</strong>: '.$value.'</p>';
			else
				$this->getValues($value,"\t");
		}
	}
}