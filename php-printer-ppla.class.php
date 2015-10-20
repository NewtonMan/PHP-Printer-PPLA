<?php
/*
In Production with ARGOX 210 PLUS
*/
class PHPPrinterPPLA {
    
    private $STX = null;
    private $CR = null;
    
    public function __construct() {
        $this->STX = chr(2);
        $this->CR = chr(13);
    }
    
    public $linhas = array();
    
    public function add(){
        $this->linhas[] = $this->STX . 'L' . $this->CR;
        $this->linhas[] = $this->STX . 'c0600' . $this->CR;
    }
    
    public function text($str, $x, $y, $fonte = 0, $orientacao = 1, $mH = 0, $mV = 0){
        $x = ($x < 45 ? 45:$x);
        $x = addLeading($x, 4);
        $y = addLeading($y, 4);
        $this->linhas[] = $orientacao . $fonte . $mH . $mV . '003' . $y . $x . $str . $this->CR;
    }
    
    public function barcode($bar, $x = 0, $y = 0, $alt = 0){
        $x = ($x < 45 ? 45:$x);
        $x = addLeading($x, 4);
        $y = addLeading($y, 4);
        $alt = addLeading($alt, 3);
        $this->linhas[] = 'H16' . $this->CR;
        $this->linhas[] = 'D18' . $this->CR;
        $this->linhas[] = '1A63' . $alt . $y . $x . $bar . $this->CR;
    }
    
    public function gerar(){
        $this->linhas[] = 'E' . $this->CR;
        $this->linhas[] = $this->STX . 'f320' . $this->CR;
        return implode('', $this->linhas);
    }
    
}

function clearString($var) {
    ini_set('mbstring.substitute_character', "none");
    setlocale(LC_ALL, 'pt_BR');
    $var = strtolower($var);
    $var = ereg_replace("[áàâãª]", "a", $var);
    $var = ereg_replace("[éèê]", "e", $var);
    $var = ereg_replace("[íìî]", "i", $var);
    $var = ereg_replace("[óòôõº]", "o", $var);
    $var = ereg_replace("[úùû]", "u", $var);
    $var = str_replace("ç", "c", $var);
    $var = str_replace("&", "", $var);
    $var = mb_convert_encoding($var, 'UTF-8', 'UTF-8'); 
    return strtoupper($var);
}

function onlyNumbers($str) {
    $str_out = "";
    for ($x = 0; $x < strlen($str); $x++) {
        $y = substr($str, $x, 1);
        $str_out .= (is_numeric($y) ? $y : '');
    }
    return $str_out;
}

function addLeading($i, $size) {
    if (strlen($i) < $size) {
        for ($x = strlen($i); $x < $size; $x++) {
            $i = "0{$i}";
        }
    }
    return $i;
}
