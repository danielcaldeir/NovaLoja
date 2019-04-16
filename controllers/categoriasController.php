<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categoriasController
 *
 * @author Daniel_Caldeira
 */
class categoriasController extends controller{
    //put your code here
    public function __construct() {
        parent::__construct();
    }
    
    public function index($p = 1, $id = 0) {
        //$dados = array();
        $categorias = new Categorias();
        $filtros = new Filtros();
        $consultas = array();
        
        $paginaAtual = $p;
        $limit = 3;
        $offset = ($p *$limit) - $limit;
        $seach = (!empty($_GET['s'])?$_GET['s']:"");
        $category = (!empty($_GET['category'])?$_GET['category']:"");
        
        if ( !empty($_GET['filter']) && is_array($_GET['filter']) ){
            $consultas = $_GET['filter'];
        }
        $consultas['busca'] = $seach;
        $consultas['id_categoria'] = $category;
    //    echo ("<pre>");
    //    print_r($consultas);
    //    echo ("</pre>");
        
        $dados = $filtros->getTemplateDados();
        $dados['categoriasID'] = $categorias->selecionarCategoriasID($id);
        if (!empty($dados['categoriasID'])){
            $dados['filtroCategoria'] = $categorias->getArvoreCategoria($id);
            foreach ($dados['categoriasID'] as $value) {
                $dados['categoriaNome'] = $value['nome'];
            }
            $consultas['id_categoria'] = $id;
            
            $dados['produtos'] = $filtros->atualizarProdutos($offset, $limit, $consultas);
            $dados['TotalItems'] = $filtros->getTotalProdutos($consultas);
            $dados['filtros'] = $filtros->atualizarFiltros($consultas);
            $dados['numeroPaginas'] = ceil($dados['TotalItems']/$limit);
            
            //$dados['categorias'] = $categorias->ordenarALLCategorias();
            //$dados['widget_featured1'] = $filtros->atualizarProdutos(0, 3, array('featured' => array(1)), true);
            //$dados['widget_featured2'] = $filtros->atualizarProdutos(0, 3, array('featured' => array(1)), true);
            //$dados['widget_sale'] = $filtros->atualizarProdutos(0, 3, array('sale' => array(1)), true);
            //$dados['widget_toprated'] = $filtros->atualizarProdutos(0, 3, array('bestseller' => array(1)) );
            
            $dados['paginaAtual'] = $paginaAtual;
            $dados['filtros_selected'] = $consultas;
            $dados['busca'] = $seach;
            $dados['sidebar'] = TRUE;
            if ($category != $id){
                $dados['category'] = $id;
                $_GET['category'] = $id;
            } else {
                $dados['category'] = $category;
            }
            
        //    echo("<pre>");
        //    print_r($dados);
        //    echo("</pre>");
            $this->loadTemplate('categorias', $dados);
        } else {
            header("Location: ".BASE_URL);
        }
    }
    
    public function enter($id=0, $p=1) {
        $this->index($p, $id);
    }
    
    private function validarAdminLTE() {
        $user = new Usuarios();
        $arrayInfo = array();
        $adminLTE = new adminLTEController();
        
        if (!empty($_SESSION['token'])){
            //print_r($_SESSION['token']);
            if (!$user->isLogado($_SESSION['token'])){
                adminLTEController::logout();
                exit();
            }
            
            if (!$user->validarPermissao('add_categoria')){
                $adminLTE->index();
                exit();
            }
        } else {
            $adminLTE->index();
            exit();
        }
        $arrayInfo["menuActive"] = "categoria";
        $arrayInfo["nome"] = $user;
        return $arrayInfo;
    }
    
    public function addCategoria($sub = 0, $confirme = ""){
        $cat = new Categorias();
        
        $dados = $this->validarAdminLTE();
        $dados['confirme'] = $confirme;
        $dados['sub'] = $sub;
        $dados['subArray'] = $cat->buscarSUB($sub);
        $dados['sidebar'] = FALSE;
        
        $this->loadAdminLTE("addCategoria", $dados);
    }
    
    private function montarCategoriasSub($sub = 0) {
        $categoria = new Categorias();
        
        $inicial = $categoria->selecionarCategoriasSUB($sub);
        $arvore = current($inicial);
        while ($arvore['sub'] != '0'){
            $catSub = $categoria->buscarSUB($arvore['sub']);
            for ($i=0;$i<count($catSub);$i++){
                array_push($inicial, $catSub[$i]);
            }
            $arvore = current($catSub);
        }
        $catSub = $categoria->buscarSUB('0');
        array_push($inicial, $catSub['sub']);
            //echo ("<pre>");
            //print_r($inicial);
            //echo ("</pre>");
        return $inicial;
    }
    
    public function editCategoria($id = "0", $confirme = ""){
        //$filtros = new Filtros();
        $categoria = new Categorias();
        $admin = new adminLTEController();
        
        $dados = $this->validarAdminLTE();
        $dados['mensagem'] = $confirme;
        $dados['id'] = $id;
        $array = $categoria->selecionarCategoriasID($id);
        if (count($array) > 0 ){
            $dados['categoria'] = $array;
            foreach ($array as $item) {
                $sub = $item['sub'];
            }
            $dados['sub'] = $sub;
            $dados['subArray'] = $categoria->buscarSUB($sub);
            
            $dados['arvore'] = $this->montarCategoriasSub($sub);
        } else {
            $confirme = "Nao foi informado um Identificador Valido!";
            $admin->categoria($confirme);
            exit();
        }
        //$dados['sidebar'] = FALSE;
        
        $this->loadAdminLTE("editCategoria", $dados);
    }
    
    private function montarCategoriasID($id = 0, $cats = array()) {
        $categoria = new Categorias();
        
        $inicial = $categoria->selecionarCategoriasSUB($id);
        if (count($inicial) > 0){
            foreach ($inicial as $item) {
                if ( !(in_array($item['id'], $cats)) ){
                    $idInt = $item['id'];
                    $cats[$idInt] = $item;
                }
                $cats = $this->montarCategoriasID($idInt, $cats);
            }
        }
            //echo ("<pre>");
            //print_r($inicial);
            //echo ("</pre>");
        return $cats;
    }
    
    public function delCategoria($id){
        $categoria = new Categorias();
        $admin = new adminLTEController();
        
        if (!empty($id)){
            $array = $categoria->selecionarCategoriasID($id);
            if (count($array) > 0 ){
                //$item = current($array);
                //$inicial = array();
                $inicial[$id] = current($array);
                $arvore = $this->montarCategoriasID($id, $inicial);
                //echo ("<pre>");
                //print_r($arvore);
                //echo ("</pre>");
                if ( !($categoria->existeProduto($arvore)) ){
                    foreach ($arvore as $key => $item) {
                        //$categoria->deletarCategoriaID($key);
                        $excluidos[] = $item['nome'];
                    }
                    
                    $confirme = "Itens ". implode(", ", $excluidos) ." Excluidos com Sucesso!!";
                } else {
                    $confirme = "Existe produto vinculado a Categoria!!";
                }
            } else {
                $confirme = "Nao foi informado um Identificador Valido!";
            }
        } else {
            $confirme = "Nao foi informado um Identificador Valido!";
        }
        $admin->categoria($confirme);
        exit();
    }
    
    public function addCategoriaAction() {
        $categoria = new Categorias();
        $admin = new adminLTEController();
        $nome = utf8_decode(addslashes($_POST['nome']));
        $sub = intval(addslashes($_POST['sub']));
	$confirme = "";
        
        if (is_string($nome) && is_int($sub)){
            $categoria->incluirCategoria($nome, $sub);
            $confirme = "success";
            //header("Location: ".BASE_URL."categorias/addCategoria/".$sub."/success");
            $admin->categoria($confirme);
        } else {
            $confirme = "Nome da Categoria nao informado!";
            //header("Location: ".BASE_URL."categorias/addCategoria/".$sub."/error");
            $admin->categoria($confirme);
        }
        
        //$this->addMenu($confirme);
    }
    
    public function editCategoriaAction(){
        $categoria = new Categorias();
        $id = 0;
        if (isset($_POST['id']) && !empty($_POST['id'])){
            $id = addslashes($_POST['id']);
            $nome = utf8_decode(addslashes($_POST['nome']));
            $sub = intval( addslashes($_POST['sub']) );
            $confirme = "";
            
            if (is_string($nome) && is_int($sub) ){
                $categoria->atualizarCategoriaNomeSUB($id, $nome, $sub);
                $confirme = "Registro Editado com Sucesso!";
                $this->editCategoria($id, $confirme);
                //header("Location: ".BASE_URL."categorias/editCategoria/".$id."/sucess");
            } else {
                $confirme = "Nao foi informado um nome valido!";
                $this->editCategoria($id, $confirme);
                //header("Location: ".BASE_URL."categorias/editCategoria/".$id."/error");
            }
        } else{
            $confirme = "Nao foi informado um Identificador";
            $this->editCategoria($id, $confirme);
            //header("Location: ".BASE_URL."categorias/editCategoria/".$id."/error");
        }
    }
    
    public function sisExcluirCategoria() {
        $categoria = new Categorias();
        if (count($_POST) > 0){
            $id = $_POST['id'];
        } else {
            $id = $_GET['id'];
        }
        $categoria->selecionarCategoriasID($id);
        if ($categoria->numRows() > 0){
            $categoria->deletarCategoriaID($id);
            //$confirme = "success";
            header("Location: ".BASE_URL."painel/categorias/success");
        } else {
            //$confirme = "error";
            header("Location: ".BASE_URL."painel/categorias/error");
        }
        //$this->menus($confirme);
    }
    
    public function addMarca($confirme = ""){
        $filtros = new Filtros();
        
        $dados = $filtros->getTemplateDados();
        $dados['confirme'] = $confirme;
        $dados['sidebar'] = FALSE;
        
        $this->loadPainel("addMarca", $dados);
    }
    
    public function editMarca($id = "0", $confirme = ""){
        $filtros = new Filtros();
        $marca = new Marcas();
        
        $dados = $filtros->getTemplateDados();
        $dados['confirme'] = $confirme;
        $dados['id'] = $id;
        $dados['marca'] = $marca->selecionarMarcasID($id);
        $dados['sidebar'] = FALSE;
        
        $this->loadPainel("editMarca", $dados);
    }
    
    public function delMarca($id){
        $filtros = new Filtros();
        $marca = new Marcas();
        
        $dados = $filtros->getTemplateDados();
        $dados['id'] = $id;
        $dados['marca'] = $marca->selecionarMarcasID($id);
        $dados['sidebar'] = FALSE;
        
        $this->loadPainel("delMarca", $dados);
    }
}
