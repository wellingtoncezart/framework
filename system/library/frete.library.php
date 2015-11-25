<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class frete
{
	private $empresa = '';
	private $senha = '';
	private $formato = 1;
	private $servico;
	private $cepOrigem;
	private $cepDestino;
	private $peso;
	private $largura = 11;
	private $altura = 2;
	private $comprimento = 16;
	private $valor=0;
	private $recebimento = 'n';
	private $diametro = 0;
	private $maoPropria ='n';

	public function setEmpresa($empresa)
	{
		$this->empresa = $empresa;
	}

	public function setSenha($senha)
	{
		$this->senha = $senha;
	}

	public function setFormato($formato)
	{
		$this->formato = $formato;
	}


	public function setServico($servico)
	{
		$this->servico = $servico;
	}

	public function setCepOrigem($cepOrigem)
	{
		$this->cepOrigem = $cepOrigem;
	}

	public function setCepDestino($cepDestino)
	{
		$this->cepDestino = $cepDestino;
	}

	public function setPeso($peso)
	{
		$this->peso = $peso;
	}

	public function setLargura($largura)
	{
		$this->largura = $largura;
	}

	public function setAltura($altura)
	{
		$this->altura = $altura;
	}

	public function setComprimento($comprimento)
	{
		$this->comprimento = $comprimento;
	}

	public function setMaoPropria($maoPropria)
	{
		$this->maoPropria = $maoPropria;
	}

	public function setValor($valor)
	{
		$this->valor = $valor;
	}

	public function setRecebimento($recebimento)
	{
		$this->recebimento = $recebimento;
	}

	public function setDiametro($diametro)
	{
		$this->diametro = $diametro;
	}

	public function calculaFrete(){
	    ////////////////////////////////////////////////
	    // Código dos Serviços dos Correios
	    // 41106 PAC
	    // 40010 SEDEX
	    // 40045 SEDEX a Cobrar
	    // 40215 SEDEX 10
	    ////////////////////////////////////////////////
	    // URL do WebService
	    $correios = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?";
	    $correios .= "nCdEmpresa=".$this->empresa;
	    $correios .= "&sDsSenha=".$this->senha;
	    $correios .= "&sCepOrigem=".$this->cepOrigem;
	    $correios .= "&sCepDestino=".$this->cepDestino;
	    $correios .= "&nVlPeso=".$this->peso;
	    $correios .= "&nCdFormato=".$this->formato;
	    $correios .= "&nVlComprimento=".$this->comprimento;
	    $correios .= "&nVlAltura=".$this->altura;
	    $correios .= "&nVlLargura=".$this->largura;
	    $correios .= "&sCdMaoPropria=".$this->maoPropria;
	    $correios .= "&nVlValorDeclarado=".$this->valor;
	    $correios .= "&sCdAvisoRecebimento=".$this->recebimento;
	    $correios .= "&nCdServico=".$this->servico;
	    $correios .= "&nVlDiametro=".$this->diametro;
	    $correios .= "&StrRetorno=xml";

	    // Carrega o XML de Retorno
	    $xml = simplexml_load_file($correios);
	    return $xml;
	}
	
}