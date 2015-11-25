<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
class dataValidator {
    
    protected $_data     = array();
    protected $_errors   = array();
    protected $_pattern  = array();
    protected $_messages = array();
    
    /**
     * Construct method (Set the error messages default)
     * @access public
     * @return void
     */
    public function __construct() {
        $this->set_messages_default();
        $this->define_pattern();
    }
    
    
    /**
     * Set a data for validate
     * @access public
     * @param $name String The name of data
     * @param $value Mixed The value of data
     * @return Data_Validator The self instance
     */
    public function set($name, $value, $campo = null){
        $this->_data['name'] = $name;
        $this->_data['value'] = $value;
        $this->_data['campo'] = $campo;
        return $this;
    }
    
    
    /**
     * Set error messages default born in the class
     * @access protected
     * @return void
     */
    protected function set_messages_default(){
        $this->_messages = array(
            'is_required'       => 'O campo <strong>%s</strong> é obrigatório',
            'min_length'        => 'O campo <strong>%s</strong> deve conter ao mínimo <strong>%s</strong> caracter(es)',
            'max_length'        => 'O campo <strong>%s</strong> deve conter ao máximo <strong>%s</strong> caracter(es)',
            'between_length'    => 'O campo <strong>%s</strong> deve conter entre <strong>%s</strong> e <strong>%s</strong> caracter(es)',
            'min_value'         => 'O valor do campo <strong>%s</strong> deve ser maior que <strong>%s</strong> ',
            'max_value'         => 'O valor do campo <strong>%s</strong> deve ser menor que <strong>%s</strong> ',
            'between_values'    => 'O valor do campo <strong>%s</strong> deve estar entre <strong>%s</strong> e <strong>%s</strong>',
            'is_email'          => 'O email <strong>%s</strong> não é válido ',
            'is_url'            => 'A URL <strong>%s</strong> não é válida ',
            'is_slug'           => '<strong>%s</strong> não é um slug ',
            'is_num'            => 'O valor <strong>%s</strong> não é numérico ',
            'is_integer'        => 'O valor <strong>%s</strong> não é inteiro ',
            'is_float'          => 'O valor <strong>%s</strong> não é float ',
            'is_string'         => 'O valor <strong>%s</strong> não é String ',
            'is_boolean'        => 'O valor <strong>%s</strong> não é booleano ',
            'is_obj'            => 'A variável <strong>%s</strong> não é um objeto ',
            'is_instance_of'    => '<strong>%s</strong> não é uma instância de <strong>%s</strong> ',
            'is_arr'            => 'A variável <strong>%s</strong> não é um array ',
            'is_directory'      => '<strong>%s</strong> não é um diretório válido ',
            'is_equals'         => 'O valor do campo <strong>%s</strong> deve ser igual à <strong>%s</strong> ',
            'is_not_equals'     => 'O valor do campo <strong>%s</strong> não deve ser igual à <strong>%s</strong> ',
            'is_cpf'            => 'O valor <strong>%s</strong> não é um CPF válido ',
            'is_cnpj'           => 'O valor <strong>%s</strong> não é um CNPJ válido ',
            'contains'          => 'O campo <strong>%s</strong> só aceita um do(s) seguinte(s) valore(s): [<strong>%s</strong>] ',
            'not_contains'      => 'O campo <strong>%s</strong> não aceita o(s) seguinte(s) valore(s): [<strong>%s</strong>] ',
            'is_lowercase'      => 'O campo <strong>%s</strong> só aceita caracteres minúsculos ',
            'is_uppercase'      => 'O campo <strong>%s</strong> só aceita caracteres maiúsculos ',
            'is_multiple'       => 'O valor <strong>%s</strong> não é múltiplo de <strong>%s</strong>',
            'is_positive'       => 'O campo <strong>%s</strong> só aceita valores positivos',
            'is_negative'       => 'O campo <strong>%s</strong> só aceita valores negativos',
            'is_date'           => 'A data <strong>%s</strong> não é válida',
            'is_alpha'          => 'O campo <strong>%s</strong> só aceita caracteres alfabéticos',
            'is_alpha_num'      => 'O campo <strong>%s</strong> só aceita caracteres alfanuméricos',
            'no_whitespaces'    => 'O campo <strong>%s</strong> não aceita espaços em branco',
            'password_confirm'  => 'O valor do campo <strong>%s</strong> não corresponde ao da <strong>senha</strong>'
        );
    }
    
    
    /**
     * The number of validators methods available in DataValidator
     * @access public
     * @return int Number of validators methods
     */
    public function get_number_validators_methods(){
        return count($this->_messages);
    }
    
    /**
     * Define a custom error message for some method
     * @access public
     * @param String $name The name of the method
     * @param String $value The custom message
     * @return void
     */
    public function set_message($name, $value){
        if (array_key_exists($name, $this->_messages)){
            $this->_messages[$name] = $value;
        }
    }
    
    
    /**
     * Get the error messages
     * @access public
     * @param String $param [optional] A specific method
     * @return Mixed One array with all error messages or a message of specific method
     */
    public function get_messages($param = false){
        if ($param){
            return $this->_messages[$param];
        }
        return $this->_messages;
    }
    
    
    /**
     * Define the pattern of name of error messages
     * @access public
     * @param String $prefix [optional] The prefix of name
     * @param String $sufix [optional] The sufix of name
     * @return void
     */
    public function define_pattern($prefix = '', $sufix = ''){
        $this->_pattern['prefix'] = $prefix;
        $this->_pattern['sufix']  = $sufix;
    }
    
    
    /**
     * Set a error of the invalid data
     * @access protected
     * @param String $error The error message
     * @return void
     */
    protected function set_error($error){
        $this->_errors[$this->_pattern['prefix'] . $this->_data['campo'] . $this->_pattern['sufix']][] = $error;
    }
        
    /**
     * Verify if the current data is not null
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_required(){
        if (empty ($this->_data['value'])){
            $this->set_error(sprintf($this->_messages['is_required'], $this->_data['name']));
        }
        return $this;
    } 
    
    
    /**
     * Verify if the length of current value is less than the parameter
     * @access public
     * @param Int $length The value for compare
     * @param Boolean $inclusive [optional] Include the lenght in the comparison
     * @return Data_Validator The self instance
     */
    public function min_length($length, $inclusive = false){
        $verify = ($inclusive === true ? strlen($this->_data['value']) >= $length : strlen($this->_data['value']) > $length);
        if (!$verify){
            $this->set_error(sprintf($this->_messages['min_length'], $this->_data['name'], $length));
        }
        return $this;
    }
    
    
    /**
     * Verify if the length of current value is more than the parameter
     * @access public
     * @param Int $length The value for compare
     * @param Boolean $inclusive [optional] Include the lenght in the comparison
     * @return Data_Validator The self instance
     */
    public function max_length($length, $inclusive = false){
        $verify = ($inclusive === true ? strlen($this->_data['value']) <= $length : strlen($this->_data['value']) < $length);
        if (!$verify){
            $this->set_error(sprintf($this->_messages['max_length'], $this->_data['name'], $length));
        }
        return $this;
    }
    
    
    /**
     * Verify if the length current value is between than the parameters
     * @access public
     * @param Int $min The minimum value for compare
     * @param Int $max The maximum value for compare
     * @return Data_Validator The self instance
     */
    public function between_length($min, $max){
        if(strlen($this->_data['value']) < $min || strlen($this->_data['value']) > $max){
            $this->set_error(sprintf($this->_messages['between_length'], $this->_data['name'], $min, $max));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current value is less than the parameter
     * @access public
     * @param Int $value The value for compare
     * @param Boolean $inclusive [optional] Include the value in the comparison
     * @return Data_Validator The self instance
     */
    public function min_value($value, $inclusive = false){
        $verify = ($inclusive === true ? !is_numeric($this->_data['value']) || $this->_data['value'] >= $value : !is_numeric($this->_data['value']) || $this->_data['value'] > $value);
        if (!$verify){
            $this->set_error(sprintf($this->_messages['min_value'], $this->_data['name'], $value));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current value is more than the parameter
     * @access public
     * @param Int $value The value for compare
     * @param Boolean $inclusive [optional] Include the value in the comparison
     * @return Data_Validator The self instance
     */
    public function max_value($value, $inclusive = false){
        $verify = ($inclusive === true ? !is_numeric($this->_data['value']) || $this->_data['value'] <= $value : !is_numeric($this->_data['value']) || $this->_data['value'] < $value);
        if (!$verify){
            $this->set_error(sprintf($this->_messages['max_value'], $this->_data['name'], $value));
        }
        return $this;
    }
    
    
    /**
     * Verify if the length of current value is more than the parameter
     * @access public
     * @param Int $min_value The minimum value for compare
     * @param Int $max_value The maximum value for compare
     * @return Data_Validator The self instance
     */
    public function between_values($min_value, $max_value){
        if(!is_numeric($this->_data['value']) || (($this->_data['value'] < $min_value || $this->_data['value'] > $max_value ))){
            $this->set_error(sprintf($this->_messages['between_values'], $this->_data['name'], $min_value, $max_value));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a valid email
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_email(){
        if (filter_var($this->_data['value'], FILTER_VALIDATE_EMAIL) === false) {
            $this->set_error(sprintf($this->_messages['is_email'], $this->_data['value']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a valid URL
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_url(){
        if (filter_var($this->_data['value'], FILTER_VALIDATE_URL) === false) {
            $this->set_error(sprintf($this->_messages['is_url'], $this->_data['value']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a slug
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_slug(){
        $verify = true;
        
        if (strstr($input, '--')) {
            $verify = false;
        }
        if (!preg_match('@^[0-9a-z\-]+$@', $input)) {
            $verify = false;
        }
        if (preg_match('@^-|-$@', $input)){
            $verify = false;
        }        
        if(!$verify){
            $this->set_error(sprintf($this->_messages['is_slug'], $this->_data['value']));
        }
        return $this;        
    }
    
    
    /**
     * Verify if the current data is a numeric value
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_num(){
        if (!is_numeric($this->_data['value'])){
            $this->set_error(sprintf($this->_messages['is_num'], $this->_data['value']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a integer value
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_integer(){
        if (!is_numeric($this->_data['value']) && (int) $this->_data['value'] != $this->_data['value']){
            $this->set_error(sprintf($this->_messages['is_integer'], $this->_data['value']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a float value
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_float(){
        if (!is_float(filter_var($this->_data['value'], FILTER_VALIDATE_FLOAT))){
            $this->set_error(sprintf($this->_messages['is_float'], $this->_data['value']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a string value
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_string(){
        if(!is_string($this->_data['value'])){
            $this->set_error(sprintf($this->_messages['is_string'], $this->_data['value']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a boolean value
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_boolean(){
        if(!is_bool($this->_data['value'])){
            $this->set_error(sprintf($this->_messages['is_boolean'], $this->_data['value']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a object
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_obj(){
        if(!is_object($this->_data['value'])){
            $this->set_error(sprintf($this->_messages['is_obj'], $this->_data['name']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a instance of the determinate class
     * @access public
     * @param String $class The class for compare
     * @return Data_Validator The self instance
     */
    public function is_instance_of($class){
        if(!($this->_data['value'] instanceof $class)){
            $this->set_error(sprintf($this->_messages['is_instance_of'], $this->_data['name'], $class));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a array
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_arr(){
        if(!is_array($this->_data['value'])){
            $this->set_error(sprintf($this->_messages['is_arr'], $this->_data['name']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current parameter it is a directory
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_directory(){
        $verify = is_string($this->_data['value']) && is_dir($this->_data['value']);
        if(!$verify){
            $this->set_error(sprintf($this->_messages['is_directory'], $this->_data['value']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is equals than the parameter
     * @access public
     * @param String $value The value for compare
     * @param Boolean $identical [optional] Identical?
     * @return Data_Validator The self instance
     */
    public function is_equals($value, $identical = false){
        $verify = ($identical === true ? $this->_data['value'] === $value : strtolower($this->_data['value']) == strtolower($value));
        if(!$verify){
            $this->set_error(sprintf($this->_messages['is_equals'], $this->_data['name'], $value));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is not equals than the parameter
     * @access public
     * @param String $value The value for compare
     * @param Boolean $identical [optional] Identical?
     * @return Data_Validator The self instance
     */
    public function is_not_equals($value, $identical = false){
        $verify = ($identical === true ? $this->_data['value'] !== $value : strtolower($this->_data['value']) != strtolower($value));
        if(!$verify){
            $this->set_error(sprintf($this->_messages['is_not_equals'], $this->_data['name'], $value));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a valid CPF
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_cpf(){
        $verify = true;
        if($this->_data['value'] != '')
        {
            $c = preg_replace('/\D/', '', $this->_data['value']);
            
            if (strlen($c) != 11) 
                $verify = false;

            if (preg_match("/^{$c[0]}{11}$/", $c)) 
                $verify = false;
            
            for ($s = 10, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);
            
            if ($c[9] != ((($n %= 11) < 2) ? 0 : 11 - $n)) 
                $verify = false;

            for ($s = 11, $n = 0, $i = 0; $s >= 2; $n += $c[$i++] * $s--);

            if ($c[10] != ((($n %= 11) < 2) ? 0 : 11 - $n)) 
                $verify = false;
            
            if(!$verify){
                $this->set_error(sprintf($this->_messages['is_cpf'], $this->_data['value']));
            }
        }else
            $verify = false;
        
        return $this;
    }
    
    
    /**
     * Verify if the current data is a valid CNPJ
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_cnpj(){
        $verify = true;
        if($this->_data['value'] != '')
        {
            $c = preg_replace('/\D/', '', $this->_data['value']);
            $b = array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
            
            if (strlen($c) != 14) 
                $verify = false;
            for ($i = 0, $n = 0; $i < 12; $n += $c[$i] * $b[++$i]);
            
            if ($c[12] != ((($n %= 11) < 2) ? 0 : 11 - $n)) 
                $verify = false;
            
            for ($i = 0, $n = 0; $i <= 12; $n += $c[$i] * $b[$i++]);
            
            if ($c[13] != ((($n %= 11) < 2) ? 0 : 11 - $n)) 
                $verify = false;
            
            if(!$verify){
                $this->set_error(sprintf($this->_messages['is_cnpj'], $this->_data['value']));
            }
        }
        
        return $this;
    }
    
    
    /**
     * Verify if the current data contains in the parameter
     * @access public
     * @param Mixed $values One array or String with valids values
     * @param Mixed $separator [optional] If $values as a String, pass the separator of values (ex: , - | )
     * @return Data_Validator The self instance
     */
    public function contains($values, $separator = false){
        if(!is_array($values)){
            if(!$separator || is_null($values)){
                $values = array();
            }
            else{
                $values = explode($separator, $values);
            }            
        }
        
        if(!in_array($this->_data['value'], $values)){
            $this->set_error(sprintf($this->_messages['contains'], $this->_data['name'], implode(', ', $values)));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data not contains in the parameter
     * @access public
     * @param Mixed $values One array or String with valids values
     * @param Mixed $separator [optional] If $values as a String, pass the separator of values (ex: , - | )
     * @return Data_Validator The self instance
     */
    public function not_contains($values, $separator = false){
        if(!is_array($values)){
            if(!$separator || is_null($values)){
                $values = array();
            }
            else{
                $values = explode($separator, $values);
            }            
        }
        
        if(in_array($this->_data['value'], $values)){
            $this->set_error(sprintf($this->_messages['not_contains'], $this->_data['name'], implode(', ', $values)));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is loweracase
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_lowercase(){
        if($this->_data['value'] !== mb_strtolower($this->_data['value'], mb_detect_encoding($this->_data['value']))){
            $this->set_error(sprintf($this->_messages['is_lowercase'], $this->_data['name']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is uppercase
     * @access public
     * @return Data_Validator The self instance
     */
    public function is_uppercase(){
        if($this->_data['value'] !== mb_strtoupper($this->_data['value'], mb_detect_encoding($this->_data['value']))){
            $this->set_error(sprintf($this->_messages['is_uppercase'], $this->_data['name']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is multiple of the parameter
     * @access public
     * @param Int $value The value for comparison
     * @return Data_Validator The self instance
     */
    public function is_multiple($value){
        if($value == 0){
            $verify = ($this->_data['value'] == 0);
        }
        else{
            $verify = ($this->_data['value'] % $value == 0);
        }
        if(!$verify){
            $this->set_error(sprintf($this->_messages['is_multiple'], $this->_data['value'], $value));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a positive number
     * @access public
     * @param Boolean $inclusive [optional] Include 0 in comparison?
     * @return Data_Validator The self instance
     */
    public function is_positive($inclusive = false){
        $verify = ($inclusive === true ? ($this->_data['value'] >= 0) : ($this->_data['value'] > 0));
        if(!$verify){
            $this->set_error(sprintf($this->_messages['is_positive'], $this->_data['name']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a negative number
     * @access public
     * @param Boolean $inclusive [optional] Include 0 in comparison?
     * @return Data_Validator The self instance
     */
    public function is_negative($inclusive = false){
        $verify = ($inclusive === true ? ($this->_data['value'] <= 0) : ($this->_data['value'] < 0));
        if(!$verify){
            $this->set_error(sprintf($this->_messages['is_negative'], $this->_data['name']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data is a valid Date
     * @access public
     * @param String $format [optional] The Date format
     * @return Data_Validator The self instance
     */
    public function is_date($format = null){
        $verify = true;
        if($this->_data['value'] instanceof DateTime){
            return $this;
        }
        elseif(!is_string($this->_data['value'])){
            $verify = false;
        }
        elseif (is_null($format)){
            $verify = (strtotime($this->_data['value']) !== false);
            if($verify){
                return $this;
            }
        }
        if($verify){
            $date_from_format = DateTime::createFromFormat($format, $this->_data['value']);
            $verify = $date_from_format && $this->_data['value'] === date($format, $date_from_format->getTimestamp());
        }        
        if(!$verify){
            $this->set_error(sprintf($this->_messages['is_date'], $this->_data['value']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data contains just alpha caracters
     * @access protected
     * @param String $string_format The regex
     * @param String $additional [optional] The extra caracters
     * @return Boolean True if data is valid or false otherwise
     */
    protected function generic_alpha_num($string_format, $additional = ''){
        $this->_data['value'] = (string) $this->_data['value'];
        $clean_input = str_replace(str_split($additional), '', $this->_data['value']);
        return ($clean_input !== $this->_data['value'] && $clean_input === '') || preg_match($string_format, $clean_input);
    }
    
    
    /**
     * Verify if the current data contains just alpha caracters
     * @access public
     * @param String $additional [optional] The extra caracters
     * @return Data_Validator The self instance
     */
    public function is_alpha($additional = ''){
        $string_format = '/^(\s|[a-zA-Z])*$/';       
        if(!$this->generic_alpha_num($string_format, $additional)){
            $this->set_error(sprintf($this->_messages['is_alpha'], $this->_data['name']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data contains just alpha-numerics caracters
     * @access public
     * @param String $additional [optional] The extra caracters
     * @return Data_Validator The self instance
     */
    public function is_alpha_num($additional = ''){
        $string_format = '/^(\s|[a-zA-Z0-9])*$/';  
        if(!$this->generic_alpha_num($string_format, $additional)){
            $this->set_error(sprintf($this->_messages['is_alpha_num'], $this->_data['name']));
        }
        return $this;
    }
    
    
    /**
     * Verify if the current data no contains white spaces
     * @access public
     * @return Data_Validator The self instance
     */
    public function no_whitespaces(){
        $verify = is_null($this->_data['value']) || preg_match('#^\S+$#', $this->_data['value']);
        if(!$verify){
            $this->set_error(sprintf($this->_messages['no_whitespaces'], $this->_data['name']));
        }
        return $this;
    }
    

    /**
     * Verify if the current data is equals than the parameter
     * @access public
     * @param String $value The value for compare
     * @param Boolean $identical [optional] Identical?
     * @return Data_Validator The self instance
     */
    public function password_confirm($value, $identical = false){
        $verify = ($identical === true ? $this->_data['value'] === $value : strtolower($this->_data['value']) == strtolower($value));
        if(!$verify){
            $this->set_error(sprintf($this->_messages['password_confirm'], $this->_data['name'], $value));
        }
        return $this;
    }




    
    /**
     * Validate the data
     * @access public
     * @return bool The validation of data 
     */
    public function validate(){
        return (count($this->_errors) > 0 ? false : true);
    }
    
    
    /**
     * The messages of invalid data
     * @param String $param [optional] A specific error
     * @return Mixed One array with messages or a message of specific error 
     */
    public function get_errors($param = false){
        if ($param){
            if(isset($this->_errors[$this->_pattern['prefix'] . $param . $this->_pattern['sufix']])){
                return $this->_errors[$this->_pattern['prefix'] . $param . $this->_pattern['sufix']];
            }
            else{
                return false;
            }
        }        
        return $this->_errors;
    }
}