<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of adminLTEController
 *
 * @author Daniel_Caldeira
 */
class adminLTEController extends controller{
    
    private $user;
    private $arrayInfo;
    
    public function __construct() {
        $this->user = new Usuarios();
        $this->arrayInfo = array();
        
        //if (isset($_SESSION['user'])){
        //    $this->user['nome'] = $_SESSION['user']['nome'];
        //    $this->user['email'] = $_SESSION['user']['email'];
        //    $this->user['senha'] =$_SESSION['user']['senha'];
        //    $this->user['telefone'] = $_SESSION['user']['telefone'];
        //}
        if (!empty($_SESSION['token'])){
            //$user = new Usuarios();
            //print_r($_SESSION['token']);
            if (!$this->user->isLogado($_SESSION['token'])){
                $this->login();
                exit();
            }
        //    $arrPermissao = $this->permissao->selecionarPermissaoIDGrupo($this->user->getIDGrupo());
        //    
        //    $pItem = new PermissaoItem();
        //    $permissoes = array();
        //    foreach ($arrPermissao as $item) {
        //        $pItem->selecionarPermissaoItemID($item['id_item']);
        //        $permissoes[] = $pItem->getSlug();
        //    }
        //    $this->permissao->setPermissoes($permissoes);
        } else {
            //print_r($_SESSION['token']);
            if (!isset($_SESSION['token'])){
                $this->login();
                exit();
            } else {
                $this->login(FALSE);
                exit();
            }
        }
        $this->arrayInfo["menuActive"] = "home";
        $this->arrayInfo["nome"] = $this->user;
        //global $config;
        //$this->config = $config;
        parent::__construct();
    }
    
    public function index() {
        //$paginas = new Paginas();
        //$menu = new Categorias();
        //$filtros = new Filtros();
        $dados = array();
		
        //$dados = $filtros->getTemplateDados();
        //$dados['nome'] = "Administrador: ".$this->user.getNome;
        $dados['nome'] = ($this->user);
        //$dados['info'] = $this->arrayInfo;
	//$dados['menus'] = $menu->ordenarALLCategorias();
        //$dados['paginas'] = $paginas->selecionarALLPaginas();
        $dados['sidebar'] = FALSE;
        
        $this->loadAdminLTE("home", $this->arrayInfo);
    }
    
    public function login($permision = TRUE) {
        //$paginas = new Paginas();
        $menu = new Categorias();
        //$filtros = new Filtros();
        $dados = array();
		
        //$dados = $filtros->getTemplateDados();
        //$dados['nome'] = "Administrador: ".$this->user['nome'];
	$dados['menus'] = $menu->ordenarALLCategorias();
        //$dados['paginas'] = $paginas->selecionarALLPaginas();
        $dados['permission'] = $permision;
        $dados['sidebar'] = FALSE;
        
        $this->loadViewInAdminLTE("login", $dados);
    }
    
    public function categoria($confirme = "") {
        $categorias = new Categorias();
        
        $this->arrayInfo['categorias'] = $categorias->ordenarALLCategorias();
        $this->arrayInfo['sub'] = 0;
        $this->arrayInfo['subArray'] = $categorias->buscarSUB(0);
        $this->arrayInfo['arvore'] = $categorias->selecionarCategoriasSUB(0);
        $this->arrayInfo['mensagem'] = $confirme;
        $this->arrayInfo["menuActive"] = "categoria";
        
        $this->loadAdminLTE("categorias", $this->arrayInfo);
    }
    
    public static function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['token']);
        header("Location: ".BASE_URL."adminLTE");
        //$home = new homeController();
        //$home->index();
        //exit();
    }
    
    public function marcas($mensagem = "") {
        $marcas = new Marcas();
        
        $this->arrayInfo['marcas'] = ($marcas->selecionarALLMarcas());
        $this->arrayInfo['mensagem'] = $mensagem;
        $this->arrayInfo["menuActive"] = "marca";
        //echo ("<pre>");
        //print_r($this->arrayInfo['marcas']);
        //echo ("</pre>");
	
        
        $this->loadAdminLTE("marcas", $this->arrayInfo);
    }
}
