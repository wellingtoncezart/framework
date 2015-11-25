<?php
if(!defined('BASEPATH')) die('Acesso não permitido');
Class dataFormat{
    private $_moeda = 'R$';
    public function formatar($dados, $tipo, $destino='form'){
        $tipo = strtolower($tipo);
        if($destino == 'banco'){
            switch($tipo){
                case "cnpj":
                case "cpf":
                case "telefone":
                case "cep":
                case "inteiro":
                    $dados = $this->formatar($dados, 'limpanumero', 'banco');
                    break;
                case "moeda":
                    $dados = str_replace($this->_moeda, '',trim($this->formatar($dados, 'decimal', 'banco')));
                    break;
                case "decimal":
                    $dados = $this->converter_decimal_vp($dados);
                    break;
                case "data":
                    $dados = $this->converter_data_fb($dados);
                    break;
                case "hora":
                    $dados = $this->converter_time_bf($dados);
                    break;
                case "datahora":
                    $ret = $this->converter_data_fb(substr($dados, 0, 10));
                    $ret .= ' '.$this->converter_time_bf(substr($dados, 11, 8));
                    $dados = $ret;
                    break;
                case 'limpanumero':
                    $ret = preg_replace('/[^0-9_]/', '', $dados);
                    $dados = $ret;
                    break;        
                      
                Default:
                    break;
            }
        }else{
            switch($tipo){
                case "cpf":
                    $formato = "###.###.###-##";
                    break;
                case "cnpj":
                    $formato = "##.###.###/####-##";
                    break;
                case "telefone":
                    $formato = "(##) ####-####";
                    break;
                case "cep":
                    $formato = "#####-###";
                    break;
                case "moeda":
                    $dados = $this->_moeda.' '.$this->formatar($dados, 'decimal');
                    break;
                case "decimal":
                   $dados = $this->converter_decimal_pv($dados);
                   break;
                case "inteiro":
                   $dados = $this->converter_int_vp($dados);
                   break;
                case "data":
                   $dados = $this->converter_data_bf($dados);
                   break;
                case "hora":
                   $dados = $this->converter_time_bf($dados);
                   break;
                case "datahora":
                   $ret = $this->converter_data_bf(substr($dados, 0, 10));
                   $ret .= ' '.$this->converter_time_bf(substr($dados, 11, 8));
                   $dados = $ret;
                   break;
                Default:
                   break;
            }
            
        }
        if(isset($formato)){
            $dados = $this->string_format($formato, $dados);
        }
        return $dados;
    }
  public function converter_int_vp($strInt) {
      $strInt = number_format($strInt,0,',','.');
      return $strInt;
      unset($strInt);
   }
   public function converter_int_pv($strInt) {
      $strInt = str_replace(".", "", $strInt);
      return $strInt;
      unset($strInt);
   }
   public function converter_decimal_pv($strDecimal) {
      $strDecimalFinal = number_format($strDecimal,2,',','.');
   return $strDecimalFinal;
   }
   function converter_decimal_vp($strDecimal) {
      $strDecimal = str_replace(".", "", $strDecimal);
      $strDecimalFinal = str_replace(",", ".", $strDecimal);
      return $strDecimalFinal;
   }
   function converter_data_fb($strData) {
    if(substr_count($strData, '/') == 2){
        // Recebemos a data no formato: dd/mm/aaaa
        // Convertemos a data para o formato: aaaa-mm-dd
        if ( preg_match("#/#",$strData) == 1 ) {
           $strDataFinal = implode('-', array_reverse(explode('/',$strData)));
        }
        return $strDataFinal;
    }else{
        return $strData;
    }
   }
   function converter_data_bf($strData) {
    if(substr_count($strData, '-') == 2){
        // Recebemos a data no formato: aaa-mm-dd
        // Convertemos a data para o formato: dd/mm/aaaa
        if ( preg_match("#-#",$strData) == 1 ) {
           $strDataFinal = implode('/', array_reverse(explode('-',$strData)));
        }
        return $strDataFinal;
    }else{
        return $strData;
    }
   }
   function converter_time_bf($strTime) {
    if(substr_count($strTime, ':') == 2){
        list($time1, $time2, $time3) = explode(":", $strTime);    
        $strTimeFinal = $time1.':'.$time2;
        return $strTimeFinal;
    }else{
        return $strTime;
    }
   }
    function string_format($format, $string, $placeHolder = "#")
    {            
        $numMatches = preg_match_all("/($placeHolder+)/", $format, $matches);              
        foreach ($matches[0] as $match)
        {
            $matchLen = strlen($match);
            $format = preg_replace("/$placeHolder+/", substr($string, 0, $matchLen), $format, 1);
            $string = substr($string, $matchLen);
        }
        return $format;
    } 
}
?>