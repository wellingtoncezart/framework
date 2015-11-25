<?php
/**
* @author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');
class Common extends Load
{
    protected $load = null;
    public function __construct()
    {
        $this->load = Load::getInstance();
        $this->_autoloadComplement();
    }
}