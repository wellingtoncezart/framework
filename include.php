<?php
/**
*@author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
define('BASEPATH',dirname(__FILE__).'/');

require_once(BASEPATH.'system'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

if(!function_exists('autoload'))
{
    /*** nullify any existing autoloads ***/
    spl_autoload_register(null, false);
    /*** specify extensions that may be loaded ***/
    spl_autoload_extensions('.php, .class.php, .library.php, .model.php, .controller.php');
    /*** register the loader functions ***/ 
            
    function includeFile($file)
    {
        require_once(str_replace('\\', '/', $file));
    }

    function _autoload($className)
    {
        $filesPath = array(
            //library app
            BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$className . '.library.php',
            //model app
            BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.MODELS.DIRECTORY_SEPARATOR.$className . '.php',
            //controller app
            BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.$className . '.controller.php',
            //library system
            BASEPATH.DIRECTORY_SEPARATOR.SYSTEMPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$className . '.library.php',
            //core system
            BASEPATH.DIRECTORY_SEPARATOR.SYSTEMPATH.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.$className . '.php',
            //database system
            BASEPATH.DIRECTORY_SEPARATOR.SYSTEMPATH.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.$className . '.php'
        );

        foreach ($filesPath as $file)
        {
            if (file_exists($file)){
                includeFile($file);
                break;
            }
        }
    }

    spl_autoload_register('_autoload');
}


// function checkConfig()
// {
// 	if(	!defined('HOSTNAME') 
// 		|| !defined('USERNAME') 
// 		|| !defined('PASSWORD') 
// 		|| !defined('DBNAME') 
// 		|| !defined('MYSQLPORT')
// 		|| !defined('BASEPATH')
// 		|| !defined('MODELS')
// 		|| !defined('VIEWS')
// 		|| !defined('CONTROLLERS')
// 	){
// 		die('Arquivo de configuração não está configurado corretamente. Configure o caminho do servidor mysql, com porta login e senha.');
// 	}
// }

// checkConfig();