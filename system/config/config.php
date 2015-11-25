<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
header('Content-Type: text/html; charset=utf-8');
/**
* Arquivo de configuração geral
* @author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
* @since 05/03/2015
* @version 2.0
*
*/
require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

define('SYSTEMPATH','system');
define('LIBRARYPATH','library');

foreach ($_config as $key => $value)
{
	$key = strtoupper($key);
	define($key,$value);
}

if( ERRORREPORTING == 'E_ALL')
	error_reporting(E_ALL);
else
	error_reporting(0);