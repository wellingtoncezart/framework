<?php
/**
*@author 
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class home extends Controller{
	public function __construct(){
		parent::__construct();

	}
	public function index()
	{
		$data = array(
			'titlePage' => 'Welcome'
		);
		
		$this->load->view('home',$data);
	}
}