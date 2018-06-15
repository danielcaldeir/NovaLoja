<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Language
 *
 * @author Daniel_Caldeira
 */
class Language {
    
    private $l;
    private $ini;
    
    //put your code here
    
    public function __construct() {
        global $config;
        $this->l = $config['default_lang'];
        if(!empty($_SESSION['lang']) && file_exists('lang/'.$_SESSION['lang'].'.ini')) {
            $this->l = $_SESSION['lang'];
        }
        $this->ini = parse_ini_file('lang/'.$this->l.'.ini');
    }
    
    public function get($word, $return = false) {
        if(isset($this->ini[$word])) {
            $text = $this->ini[$word];
        } else {
            $text = $word;
        }
        
        if($return) {
            return $text;
        } else {
            echo $text;
        }
    }
    
    public function setLanguage($lang) {
        if(!empty($lang) && file_exists('lang/'.$lang.'.ini')) {
            $_SESSION['lang'] = $lang;
        }
        header("Location: ".BASE_URL);
    }
}
