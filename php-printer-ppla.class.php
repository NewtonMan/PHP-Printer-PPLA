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
    
    public $lines = array();
    
    public function add(){
        $this->lines[] = $this->STX . 'L' . $this->CR;
        $this->lines[] = $this->STX . 'c0600' . $this->CR;
    }
    
    public function text($str, $x, $y, $font = 0, $orientation = 1, $mH = 0, $mV = 0){
        $x = ($x < 45 ? 45:$x);
        $x = addLeading($x, 4);
        $y = addLeading($y, 4);
        $this->lines[] = $orientation . $font . $mH . $mV . '003' . $y . $x . $str . $this->CR;
    }
    
    public function barcode($bar, $x = 0, $y = 0, $height = 0){
        $x = ($x < 45 ? 45:$x);
        $x = addLeading($x, 4);
        $y = addLeading($y, 4);
        $height = addLeading($alt, 3);
        $this->lines[] = 'H16' . $this->CR;
        $this->lines[] = 'D18' . $this->CR;
        $this->lines[] = '1A63' . $height . $y . $x . $bar . $this->CR;
    }
    
    public function output(){
        $this->lines[] = 'E' . $this->CR;
        $this->lines[] = $this->STX . 'f320' . $this->CR;
        return implode('', $this->lines);
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
