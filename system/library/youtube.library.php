<?php
/**
 * Retorna o codigo de um vídeo do youtube
 * @return String
 */
if(!defined('BASEPATH')) die('Acesso não permitido');
class youtube
{
	private $url;
	function __construct($str)
	{
		$regex = "#youtu(be.com|.b)(/v/|/watch\\?v=|e/|/watch(.+)v=)(.{11})#";
		preg_match_all($regex , $str, $matches);		 
		if(!empty($matches[4]))
		{
		    $codigos_unicos = array();
		    $quantidade_videos = count($matches[4]);
		    foreach($matches[4] as $code)
		    {
		        if(!in_array($code,$codigos_unicos))
		            array_push($codigos_unicos,$code);
		    }

		    $this->url = $codigos_unicos;
		}
	}

	function getUrl()
	{
		return $this->url;
	}
}