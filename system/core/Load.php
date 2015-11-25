<?php
/**
* @author Wellington cezar (programador jr) - wellington-cezar@hotmail.com
*/
if(!defined('BASEPATH')) die('Acesso não permitido');

class Load{
    private static $data = array();
    /**
     * Construtor do tipo protegido previne que uma nova instância da
     * Classe seja criada através do operador `new` de fora dessa classe.
     */
    protected function __construct(){
    }

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }
    /**
     * Método clone do tipo privado previne a clonagem dessa instância
     * da classe
     *
     * @return void
     */
    private function __clone()
    {
    }


    /**
     * Método unserialize do tipo privado para prevenir a desserialização
     * da instância dessa classe.
     *
     * @return void
     */
    private function __wakeup()
    {
    }


    /**
     *  Autoload das classes 
     * @access protected
     * @return void
     */
    protected function _autoloadComplement(){
        require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'autoload.php');
        if(!empty($autoload['libraries']))
        {
            foreach ($autoload['libraries'] as $loadLibrary){
                $this->load->library($loadLibrary);
            }
        }

        if(!empty($autoload['model']))
        {
            foreach ($autoload['model'] as $loadModel){
                $this->load->library($loadModel);
            }
        }
    }


    /**
     * @access public
     * @return void
     */
    public function __set($name , $value ){
        self::$data[$name] = $value;
    }

    /**
     * @access public
     * @return object, null
     */
    public function __get($name)
    {   
        if (array_key_exists($name, self::$data)) {
            return self::$data[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    /**
     * @access public
     * @return void
     */
    /**  As of PHP 5.1.0  */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * @access private
     * @return booleam
     */
    private function _isloaded($class)
    {

        if (array_key_exists($class, self::$data)) {
            return true;
        }else
            return false;
    }

    /**
    * inclui e instancia o controller requisitado
     * @access public
     * @return booleam
     */
    public function controller($filename, $autoExec = true)
    {
        $filename = str_replace('\\', '/', $filename);
        $name = explode('/',rtrim($filename));
        $name = end($name);
        spl_autoload_register(array($this,'controller'));
        $filename = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.CONTROLLERS.DIRECTORY_SEPARATOR.$filename.'.controller.php';
        if(!$this->_isloaded($name))
        {
            if(file_exists($filename)){
                require_once(str_replace('\\', '/', $filename));
                if($autoExec == true)
                    $this->$name = new $name();
                return true;
            }else
                return false;
        }
    }


    /**
    * inclui e instancia a biblioteca requisitada
     * @access public
     * @return booleam
     */
    public function library($filename, $parameters = null, $autoExec = true)
    {
        $filename = str_replace('\\', '/', $filename);
        $name = explode('/',rtrim($filename));
        $name = end($name);

        spl_autoload_register(array($this,'library'));
        $files = array(
            BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$filename.'.library.php',
            BASEPATH.DIRECTORY_SEPARATOR.SYSTEMPATH.DIRECTORY_SEPARATOR.LIBRARYPATH.DIRECTORY_SEPARATOR.$filename.'.library.php',
            BASEPATH.DIRECTORY_SEPARATOR.SYSTEMPATH.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.$filename.'.php'
        );

        if(!$this->_isloaded($name))
        {
            foreach ($files as $file)
            {
                if(file_exists($file)){
                    require_once(str_replace('\\', '/', $file));
                    if($autoExec === true)
                        $this->$name = new $name($parameters);
                    return true;
                }
            }
            return false;
        }else
            return false;
    }


    /**
    * inclui o model requisitado
     * @access public
     * @return booleam
     */
    public function model($filename)
    {
        $filename = str_replace('\\', '/', $filename);
        spl_autoload_register(array($this,'model'));
        $file = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.MODELS.DIRECTORY_SEPARATOR.$filename.'.php';
        if(file_exists($file)){
            require_once(str_replace('\\', '/', $file));
            return true;
        }else{
            return false;
        }
    }

    /**
    * inclui a dao requisitada
     * @access public
     * @return booleam
     */
    public function dao($filename)
    {
        $filename = str_replace('\\', '/', $filename);
        $name = explode('/',rtrim($filename));
        $name = end($name);
        spl_autoload_register(array($this,'dao'));
        $file = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.MODELS.DIRECTORY_SEPARATOR.'DAO'.DIRECTORY_SEPARATOR.$filename.'.php';
        
        if(!$this->_isloaded($name))
        {
            if(file_exists($file)){
                require_once(str_replace('\\', '/', $file));
                return true;
            }else{
                return false;
            }
        }else
            return false;
    }


    /**
    * inclui e instancia a biblioteca requisitada
     * @access public
     * @return  booleam
     */
    public function view($filename, $param = array())
    {
        $filename = BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.VIEWS.DIRECTORY_SEPARATOR.$filename.'.phtml';
        if(file_exists($filename)){
            if(is_array($param) && !empty($param)){
                extract($param);
            }
      
            require_once(str_replace('\\', '/', $filename));
            return true;
        }else{
            $_message_error = "<p><strong>DESCULPE-NOS</strong></p>
                                <p>A página que você procura não foi encontrada.</p>
                                <p>Verifique o endereço digitado ou tente novamente mais tarde. </p>
                                <p>[View não definida]</p>";
            require_once(BASEPATH.DIRECTORY_SEPARATOR.APPPATH.DIRECTORY_SEPARATOR.ERRORDIR.DIRECTORY_SEPARATOR.'error_404.php');
            return false;
        }
    }
}