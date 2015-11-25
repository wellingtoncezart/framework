<?php
/**
* Classe que cria uma tabela dinamicamente
* @access 
* @author Wellington cézar
* @since 18/06/2014
* @version 1.0
*
*/


if(!defined('BASEPATH')) die('Acesso não permitido');
class table{
	private $tabela;
	private $cols = '';
	private $rows = '';
	private $default_table;
	private $tabelaOpen;
	private $tabelaClose;

	public function __construct()
	{
		$this->default_table = array (
						'table_open'	=> '<table border="1">'."\n\t",
						'thead_open'	=> '<thead>',
						'thead_close'	=> '</thead>',

						'tr_open'		=> '<tr>',
						'tr_close'		=> '</tr>',
						'th_open'		=> '<th>',
						'th_close'		=> '</th>',

						'tbody_open'	=> '<tbody>',
						'tbody_close'	=> '</tbody>',

						'td_open'		=> '<td>',
						'td_close'		=> '</td>',
						'table_close'			=> "\n".'</table>'."\n"
					);

	}




	//setCampos
	public function setCampos($colunas = '')
	{
		if($colunas != '')
		{
			$colunas = explode(',', $colunas);
			$this->cols .= $this->default_table['tr_open'];
			foreach ($colunas as $col) 
			{
				$this->cols .= $this->default_table['td_open'];
				$this->cols .= $col;
				$this->cols .= $this->default_table['td_close'];
			}
			$this->cols .= $this->default_table['tr_close'];
		}
	}


	public function setLinhas($linhas = '')
	{
		if($linhas != '')
		{
			$this->rows .= $this->default_table['tr_open'];
			foreach ($linhas as $linha){
				foreach ($linha as $ln){
					$this->rows .= $this->default_table['td_open'];
					$this->rows .= $ln;
					$this->rows .= $this->default_table['td_close'];
				}
			}
			$this->rows .= $this->default_table['tr_close'];
		}
	}

	//table_open
	public function table_open()
	{
		$this->tabelaOpen .=  $this->default_table['table_open'];
	}


	//table_close
	public function table_close()
	{
		$this->tabelaClose .=  $this->default_table['table_close'];
	}

	//getTabela
	public function getTabela()
	{
		$this->tabela .= $this->tabelaOpen;
		$this->tabela .=  $this->cols;
		$this->tabela .=  $this->rows;
		$this->tabela .= $this->tabelaClose;



		return $this->tabela;
	}


}
