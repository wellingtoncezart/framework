<?php
/**
 * Classe auxiliadora do crop de imagens
 * @author Wellington cezar - wellington-cezar@hotmail.com
 * 
 */
require_once("wideimage/WideImage.php");

if(!defined('BASEPATH')) die('Acesso não permitido');
class crop_image{
	private $data = array();
	public function setImage($origem,$destino,$w = NULL, $h = NULL,$x = NULL, $y = NULL,$resizeH = NULL, $resizeW=NULL)
	{
		$this->data[] = array(
				'origem' =>$origem,
				'destino'=>$destino,
				'w'=>$w,
				'h'=>$h,
				'x'=>$x,
				'y'=>$y,
				'resizeH' => $resizeH,
				'resizeW' => $resizeW
				);
	}
	public function crop()
	{
		foreach ($this->data as $dt){
			$x= $dt['x'];
			$y= $dt['y'];
			$w= $dt['w'];
			$h= $dt['h'];
			$img = WideImage::load($dt['origem']);
			$img = $img->crop("$x", "$y",$w, $h);
			$img = $img->saveToFile($dt['destino']);
		}
		unset($this->data);
	}
	public function cropResize()
	{
		foreach ($this->data as $dt){
			$x= $dt['x'];
			$y= $dt['y'];
			$w= $dt['w'];
			$h= $dt['h'];
			$img = WideImage::load($dt['origem']);
			$img = $img->crop("$x", "$y",$w, $h)->resize($dt['resizeH'],$dt['resizeW'],"outside");
			$img = $img->saveToFile($dt['destino']);
		}
		unset($this->data);
	}
	public function resize()
	{
		foreach ($this->data as $dt){
			$x= $dt['x'];
			$y= $dt['y'];
			$w= $dt['w'];
			$h= $dt['h'];
			$img = WideImage::load($dt['origem']);
			$img->resize($dt['resizeH'],$dt['resizeW'],"outside");
			$img = $img->saveToFile($dt['destino']);
		}
		unset($this->data);
	}
}