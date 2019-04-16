<?php
class controller extends Language{

	protected $db;
        protected $lang;

        public function __construct() {
		global $config;
                $this->lang = new Language();
	}
	
	public function loadView($viewName, $viewData = array()) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function loadTemplate($viewName, $viewData = array()) {
		include 'views/template.php';
	}

	public function loadViewInTemplate($viewName, $viewData) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}
        
        public function loadPainel($viewName, $viewData = array()) {
            //echo ("<br>Nome: ".$viewName);
            //include ("views/painel/". $this->config['site_painel'].".php");
		include ("views/painel/template.php");
        }
	
	public function loadViewInPainel($viewName, $viewData = array()) {
            extract($viewData);
            include ("views/painel/".$viewName.".php");
        }
        
        public function loadAdminLTE($viewName, $viewData = array()) {
            //echo ("<br>Nome: ".$viewName);
            //include ("views/painel/". $this->config['site_painel'].".php");
		include ("views/adminLTE/template.php");
        }
        
        public function loadViewInAdminLTE($viewName, $viewData = array()) {
            extract($viewData);
            include ("views/adminLTE/".$viewName.".php");
        }
}