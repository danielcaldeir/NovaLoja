<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of painelController
 *
 * @author Daniel_Caldeira
 */
class painelController extends controller{
    private $user;
    
    //put your code here
    
    public function __construct() {
        $this->user = array();
        if (isset($_SESSION['user'])){
            $this->user['nome'] = $_SESSION['user']['nome'];
            $this->user['email'] = $_SESSION['user']['email'];
            //$this->user['senha'] =$_SESSION['user']['senha'];
            $this->user['telefone'] = $_SESSION['user']['telefone'];
        }
        if (count($this->user) == 0){
            $login = new loginController();
            $login->index();
            exit();
        }
        //global $config;
        //$this->config = $config;
        parent::__construct();
    }
    
    //put your code here
    public function index() {
        //$paginas = new Paginas();
        $menu = new Categorias();
        $filtros = new Filtros();
		
        $dados = $filtros->getTemplateDados();
        $dados['nome'] = "Administrador: ".$this->user['nome'];
	$dados['menus'] = $menu->ordenarALLCategorias();
        //$dados['paginas'] = $paginas->selecionarALLPaginas();
        $dados['sidebar'] = FALSE;
        
        $this->loadPainel("home", $dados);
    }
    
    public function menus($confirme = "") {
        $menus = new Categorias();
        $filtros = new Filtros();
        
        $dados = $filtros->getTemplateDados();
        $dados['nome'] = "Administrador: ".$this->user['nome'];
        $dados['menus'] = $menus->ordenarALLCategorias();
        $dados['sub'] = $this->buscarSUB(0);
        $dados['excluir'] = $confirme;
        $dados['sidebar'] = FALSE;
        
        $this->loadPainel("selMenus", $dados);
    }
    
    public function categorias($confirme = "") {
        $categorias = new Categorias();
        $filtros = new Filtros();
        
        $dados = $filtros->getTemplateDados();
        $dados['nome'] = "Administrador: ".$this->user['nome'];
        $dados['categorias'] = $categorias->ordenarALLCategorias();
        $dados['sub'] = 0;
        $dados['subArray'] = $this->buscarSUB(0);
        $dados['excluir'] = $confirme;
        $dados['sidebar'] = FALSE;
        
        $this->loadPainel("selCategorias", $dados);
    }
    
    public function marcas($confirme = "") {
        $marcas = new Marcas();
        $filtros = new Filtros();
        
        $dados = $filtros->getTemplateDados();
        $dados['nome'] = "Administrador: ".$this->user['nome'];
        $dados['marcas'] = $marcas->selecionarALLMarcas();
        $dados['excluir'] = $confirme;
        $dados['sidebar'] = FALSE;
        
        $this->loadPainel("selMarcas", $dados);
    }
    
    public function pagina($url = null) {
        //$paginas = new Paginas();
	$pag = new Paginas();
        $filtros = new Filtros();
        $dados = $filtros->getTemplateDados();
	
	if (is_null($url)){
            $dados['nome'] = "Administrador: ".$this->user['nome'];
            //$dados['paginas'] = $paginas->selecionarALLPaginas();
            $dados['paginas'] = $pag->selecionarALLPaginas();
            $this->loadPainel("selPaginas", $dados);
	} else {
            $pag->selecionarPaginasURL($url);
            $dados['nome'] = "Administrador: ".$this->user['nome'];
            $id = $pag->getID();
            $dados["id"] = $id;
            $dados['confirme'] = "";
            $dados['pagina'] = $pag->selecionarPaginasID($id);
            
            $this->loadPainel("editPagina", $dados);
	}
        //$this->loadPainel("selPaginas", $dados);
    }
	
    public function portfolio() {
        $portfolio = new Portfolio();
        $dados = array ();
        
        $dados['portfolio'] = $portfolio->getTrabalhos();
	$dados['nome'] = "Administrador: ".$this->user['nome'];
        
        $this->loadPainel("selPortfolio", $dados);
    }
    
    public function produtos($confirme = "", $p = 1) {
        //$produtos = new Produtos();
        $filtros = new Filtros();
        $consultas = array();
        
        $paginaAtual = $p;
        $limit = 3;
        $offset = ($p *$limit) - $limit;
        //$seach = (!empty($_GET['s'])?$_GET['s']:"");
        //$category = (!empty($_GET['category'])?$_GET['category']:"");
        
        $dados = $filtros->getTemplateDados();
        //$dados['QTD'] = $filtros->getTotalProdutos();
        $dados['produtos'] = $filtros->atualizarProdutos($offset, $limit, $consultas);
        $dados['TotalItems'] = $filtros->getTotalProdutos($consultas);
        $dados['numeroPaginas'] = ceil($dados['TotalItems']/$limit);
        $dados['paginaAtual'] = $paginaAtual;
        
        $dados['confirme'] = $confirme;
        $dados['sidebar'] = FALSE;
	$dados['nome'] = "Administrador: ".$this->user['nome'];
        
        $this->loadPainel("selProdutos", $dados);
    }
    
    //public function sobre() {
    //    $dados = array ();
    //    $this->loadPainel("selSobre", $dados);
    //}
	
    public function formulario($titulo = null, $confirme = null) {
        $dados = array();
	$formulario = new Formulario();
	
	$dados['nome'] = "Administrador: ".$this->user['nome'];
	$dados['formulario'] = $formulario->selecionarFormularioTitulo($titulo);
	$dados['titulo'] = $titulo;
	$dados['confirme'] = $confirme;
                
        $this->loadPainel("selFormulario", $dados);
    }
    
    private function buscarSUB($sub) {
        $return = array();
        $menu = new Categorias();
        
        if ($sub == "0") {
            $return['sub'] = array(
                'nome' => 'INICIAL'
            );
        } else {
            $return = $menu->selecionarCategoriasID($sub);
        }
        
        return $return;
    }
    
    public function addMenu($sub = 0, $confirme = ""){
        $filtros = new Filtros();
        //$menus = new Categorias();
        
        $dados = $filtros->getTemplateDados();
        $dados['confirme'] = $confirme;
        $dados['sub'] = $sub;
        $dados['subArray'] = $this->buscarSUB($sub);
        $dados['sidebar'] = FALSE;
        
        //if ($sub == "0") {
        //    $dados['subArray'] = array(
        //        '0' => array(
        //            'nome' => 'INICIAL'
        //        )
        //    );
        //} else {
        //    $dados['subArray'] = $menus->selecionarCategoriasID($sub);
        //}
        
        $this->loadPainel("addMenu", $dados);
    }
    
    public function editMenu($id = "0", $confirme = ""){
        $filtros = new Filtros();
        $menu = new Categorias();
        
        $dados = $filtros->getTemplateDados();
        $dados['confirme'] = $confirme;
        $dados['id'] = $id;
        $array = $menu->selecionarCategoriasID($id);
        $dados['menu'] = $array;
        foreach ($array as $item) {
            $sub = $item['sub'];
        }
        $dados['sub'] = $this->buscarSUB($sub);
        $dados['arvore'] = $menu->selecionarCategoriasSUB($id);
        $dados['sidebar'] = FALSE;
        
        //if ($sub == "0") {
        //    $dados['sub'] = array(
        //        '0' => array(
        //            'nome' => 'INICIAL'
        //        )
        //    );
        //} else {
        //    $dados['sub'] = $menu->selecionarCategoriasID($sub);
        //}
        
        $this->loadPainel("editMenu", $dados);
    }
    
    public function excluirMenu($id){
        $filtros = new Filtros();
        $menu = new Categorias();
        
        $dados = $filtros->getTemplateDados();
        $dados['id'] = $id;
        $array = $menu->selecionarCategoriasID($id);
        $dados['menu'] = $array;
        foreach ($array as $item) {
            $sub = $item['sub'];
        }
        $dados['sub'] = $this->buscarSUB($sub);
        $dados['sidebar'] = FALSE;
        
        $this->loadPainel("excluirMenu", $dados);
    }
    
    public function sisAddMenu() {
        $menu = new Categorias();
        $nome = utf8_decode(addslashes($_POST['nome']));
        $sub = intval(addslashes($_POST['sub']));
	//$tipo = addslashes($_POST['tipo']);
        
        if (is_string($nome) && is_int($sub)){
            $menu->incluirCategoria($nome, $sub);
            //$confirme = "success";
            header("Location: ".BASE_URL."painel/addMenu/".$sub."/success");
        } else {
            header("Location: ".BASE_URL."painel/addMenu/".$sub."/error");
            //$confirme = "error";
        }
        
        //$this->addMenu($confirme);
    }
    
    public function sisEditarMenu(){
        $menu = new Categorias();
        if (isset($_POST['id']) && !empty($_POST['id'])){
            $id = addslashes($_POST['id']);
            $nome = utf8_decode(addslashes($_POST['nome']));
            $sub = intval( addslashes($_POST['sub']) );
            //$tipo = addslashes($_POST['tipo']);
            
            if (is_string($nome) && is_int($sub) ){
                $menu->atualizarCategoriaNomeSUB($id, $nome, $sub);
                
                header("Location: ".BASE_URL."painel/editMenu/".$id."/sucess");
            } else {
                //header("Location: ../index.php?pag=editarAnuncio&error=true&id=".$id);
                header("Location: ".BASE_URL."painel/editMenu/".$id."/error");
            }
        } else{
            //header("Location: ../index.php?pag=editarAnuncio&error=true&id=".$id);
            header("Location: ".BASE_URL."painel/editMenu/".$id."/error");
        }
    }
    
    public function sisExcluirMenu() {
        $menu = new Categorias();
        if (count($_POST) > 0){
            $id = $_POST['id'];
        } else {
            $id = $_GET['id'];
        }
        $menu->selecionarCategoriasID($id);
        if ($menu->numRows() > 0){
            $menu->deletarCategoriaID($id);
            //$confirme = "success";
            header("Location: ".BASE_URL."painel/menus/success");
        } else {
            //$confirme = "error";
            header("Location: ".BASE_URL."painel/menus/error");
        }
        //$this->menus($confirme);
    }
    
    public function addPagina($confirme = ""){
        $dados = array();
        $dados['confirme'] = $confirme;
        $this->loadPainel("addPagina", $dados);
    }
    
    public function editPagina($id, $confirme = ""){
        $dados = array();
        $pagina = new Paginas();
        $dados['confirme'] = $confirme;
        $dados['id'] = $id;
        $dados['pagina'] = $pagina->selecionarPaginasID($id);
        
        $this->loadPainel("editPagina", $dados);
    }
    
    public function excluirPagina($id){
        $dados = array();
        $pagina = new Paginas();
        $dados['id'] = $id;
        $dados['pagina'] = $pagina->selecionarPaginasID($id);
        
        $this->loadPainel("excluirPagina", $dados);
    }
    
    public function sisAddPagina() {
        $pagina = new Paginas();
        $url = addslashes($_POST['url']);
        $titulo = addslashes($_POST['titulo']);
        $corpo = addslashes($_POST['corpo']);
        
        if (!empty($url) && !empty($titulo)){
            $pagina->incluirPaginaURLTituloCorpo($url, $titulo, $corpo);
            //$confirme = "success";
            header("Location: ".BASE_URL."painel/addPagina/success");
        } else {
            header("Location: ".BASE_URL."painel/addPagina/error");
            //$confirme = "error";
        }
        //$this->addMenu($confirme);
    }
    
    public function sisEditarPagina(){
        if (isset($_POST['id']) && !empty($_POST['id'])){
            $id = addslashes($_POST['id']);
            $url = addslashes($_POST['url']);
            $titulo = utf8_decode(addslashes($_POST['titulo']) );
            $corpo = addslashes($_POST['corpo']);
            
            if (!empty($titulo) && !empty($url) ){
                $pagina = new Paginas();
                $pagina->atualizarPaginaURLTituloCorpo($id, $url, $titulo, $corpo);
                
                header("Location: ".BASE_URL."painel/editPagina/".$id."/sucess");
            } else {
                //header("Location: ../index.php?pag=editarAnuncio&error=true&id=".$id);
                header("Location: ".BASE_URL."painel/editPagina/".$id."/error");
            }
        } else{
            //header("Location: ../index.php?pag=editarAnuncio&error=true&id=".$id);
            header("Location: ".BASE_URL."painel/editPagina/".$id."/error");
        }
    }
    
    public function sisExcluirPagina() {
        $pagina = new Paginas();
        if (count($_POST) > 0){
            $id = $_POST['id'];
        } else {
            $id = $_GET['id'];
        }
        $pagina->selecionarPaginasID($id);
        if ($pagina->numRows() > 0){
            $pagina->deletarPaginaID($id);
            //$confirme = "success";
            header("Location: ".BASE_URL."painel/paginas/success");
        } else {
            //$confirme = "error";
            header("Location: ".BASE_URL."painel/paginas/error");
        }
        //$this->menus($confirme);
    }
	
    public function addPortfolio($confirme = ""){
	if (isset($_FILES['fotos'])) {
            $fotos = $_FILES['fotos'];
        } else {
            $fotos = array();
        }
        print_r($fotos);
        //exit();
        
	$fotoCTRL = new fotoController();
        $fotoCTRL->addPortfolio($fotos);
		
	$dados = array();
        $dados['sucess'] = TRUE;
        $this->loadPainel("addPortfolio", $dados);
    }
    
    public function delPortfolio($id){
        $portfolio = new Portfolio;
	$fotoCTRL = new fotoController();
	$dados = array();
	$portfolio->getPortfolioID($id);
        
	$dados['id'] = $portfolio->getID();
	$dados['imagem'] = $portfolio->getImagem();
	
	$destino = (".\\imagem\\portfolio\\");
	if (file_exists($destino.$portfolio->getImagem())){
            $destinoFinal = $destino.$portfolio->getImagem();
            print ('Verdadeiro');
            print ('<br/>');
            $fotoCTRL->delPortfolio($portfolio->getImagem(), $destinoFinal);
	} else{
            print ($portfolio->getImagem());
            print ('<br/>');
            print ('Falso');
	}
		
        //$dados['portfolio'] = $portfolio->deletarPortfolio($id);
        //exit();
        $this->loadPainel("delPortfolio", $dados);
    }
    
    public function addFormulario($confirme = ""){
	$formulario = new Formulario();
        $titulo = addslashes($_POST['titulo']);
        $label = addslashes($_POST['label']);
	$tipo = addslashes($_POST['tipo']);
        
        if (!empty($titulo) && !empty($label)){
            $formulario->incluirFormularioTituloLabelTipo($titulo, $label, $tipo);
            //$confirme = "success";
            header("Location: ".BASE_URL."painel/formulario/".$titulo."/success");
        } else {
            header("Location: ".BASE_URL."painel/formulario/error");
            //$confirme = "error";
        }
        
        //$this->addMenu($confirme);
    }
	
    public function delFormulario($id = ""){
	$formulario = new Formulario();
        //$titulo = addslashes($_POST['titulo']);
        //$label = addslashes($_POST['label']);
	//$tipo = addslashes($_POST['tipo']);
        
        if (!empty($id) ){
            $formulario->selecionarFormularioID($id);
            $titulo = $formulario->getTitulo();
            $formulario->deletarFormularioID($id);
            //$confirme = "success";
            header("Location: ".BASE_URL."painel/formulario/".$titulo."/success");
        } else {
            header("Location: ".BASE_URL."painel/formulario/error");
            //$confirme = "error";
        }
        
        //$this->addMenu($confirme);
    }
	
    public function sisEditPropriedade() {
        $config = new Config();
        if (isset($_POST['site_title']) && !empty($_POST['site_title'])){
            $title = addslashes($_POST['site_title']);
            $config->setConfigPropriedade('site_title',$title);
        }
        if (isset($_POST['site_template']) && !empty($_POST['site_template'])){
            $template = addslashes($_POST['site_template']);
            $config->setConfigPropriedade('site_template',$template);
        }
        if (isset($_POST['site_welcome']) && !empty($_POST['site_welcome'])){
            $welcome = addslashes($_POST['site_welcome']);
            $config->setConfigPropriedade('site_welcome',$welcome);
        }
        if (isset($_POST['site_color']) && !empty($_POST['site_color'])){
            $color = addslashes($_POST['site_color']);
            $config->setConfigPropriedade('site_color',$color);
        }
        header("Location: ".BASE_URL."painel");
        exit();
    }
}
