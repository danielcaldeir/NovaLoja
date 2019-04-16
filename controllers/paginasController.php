<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of paginasController
 *
 * @author Daniel_Caldeira
 */

class paginasController extends controller{
    private $user;
    private $arrayInfo;
    
    public function __construct() {
        $this->user = new Usuarios();
        $this->arrayInfo = array();
        $adminLTE = new adminLTEController();
        
        if (!empty($_SESSION['token'])){
            //print_r($_SESSION['token']);
            if (!$this->user->isLogado($_SESSION['token'])){
                adminLTEController::logout();
                exit();
            }
            //$this->permissao->getPermissaoIDGrupo($this->user->getIDGrupo());
            
            if (!$this->user->validarPermissao('edit_pagina')){
                //header("Location: ".BASE_URL."adminLTE");
                $adminLTE->index();
                exit();
            }
            
        } else {
            //print_r($_SESSION['token']);
            //$validar = new adminLTEController();
            $adminLTE->index();
            exit();
        }
        $this->arrayInfo["menuActive"] = "pagina";
        $this->arrayInfo["nome"] = $this->user;
        //global $config;
        //$this->config = $config;
        parent::__construct();
    }
    
    //put your code here
    public function index($mensagem = "") {
        $pag = new Paginas();
        
        $this->arrayInfo['paginas'] = $pag->selecionarALLPaginas();
        $this->arrayInfo['mensagem'] = $mensagem;
        
        $this->loadAdminLTE("paginas", $this->arrayInfo);
    }
    
    public function edit($id = null, $mensagem = "") {
        $paginas = new Paginas();
        
        if (!empty($id)){
            $array = $paginas->selecionarPaginasID($id);
            if (count($array) > 0){
                $this->arrayInfo['titulo'] = $paginas->getTitulo();
                $this->arrayInfo['conteudo'] = $paginas->getConteudo();
            } else{
                $mensagem = "Nao foi encontrado a Pagina selecionada!";
                $this->index($mensagem);
                exit();
            }
            
        } else {
            $mensagem = "Para poder Editar é necessário um ID vinculado!!";
            $this->index($mensagem);
            exit();
        }
	
        $this->arrayInfo['mensagem'] = $mensagem;
        $this->arrayInfo['id_pagina'] = $id;
        
        $this->loadAdminLTE("editPagina", $this->arrayInfo);
    }
    
    public function add($mensagem = "") {
        $paginas = new Paginas();
        
        $this->arrayInfo['paginas'] = $paginas->selecionarALLPaginas();
        $this->arrayInfo['mensagem'] = $mensagem;
        
        $this->loadAdminLTE("addPagina", $this->arrayInfo);
    }
    
    public function addAction($mensagem = "") {
        $paginas = new Paginas();
        //$perItens = new PermissaoItem();
        
        if (!empty($_POST['titulo'])){
            $titulo = addslashes($_POST['titulo']);
            $conteudo = addslashes($_POST['conteudo']);
            $array = $paginas->addPagina($titulo, $conteudo);
            
            if (count($array) > 0){
                $mensagem = "Página Incluida com Sucesso!!";
            } else {
                $mensagem = "Não foi possivel incluir esta página!";
            }
        } else{
            $mensagem = "Nao foi informado um titulo!";
        }
        
        $this->add($mensagem);
    }
    
    public function editAction($id_pagina, $mensagem = "") {
        $paginas = new Paginas();
        
        if (!empty($id_pagina)){
            $array = $paginas->selecionarPaginasID($id_pagina);
            if ( count($array)>0 ){
                if (!empty($_POST['titulo'])){
                    $titulo = addslashes($_POST['titulo']);
                    $conteudo = addslashes($_POST['conteudo']);
                    $paginas->editPagina($id_pagina, $titulo, $conteudo);
                    $mensagem = "Pagina Editada com Sucesso!";
                } else{
                    $mensagem = "Nao existe um titulo na pagina!";
                }
            } else {
                $mensagem = "A pagina nao existe!";
            }
            $this->edit($id_pagina, $mensagem);
        } else {
            $mensagem = "Nao existe um Identidficador vinculado!";
            $this->index($mensagem);
        }
    }
    
    public function del($id){
        $paginas = new Paginas();
        
        if (!empty($id)){
            $array = $paginas->selecionarPaginasID($id);
            if (count($array) > 0){
                $paginas->delPaginaID($id);
                $this->index("Pagina Deletada com Sucesso!");
            } else {
                $this->index("Pagina a ser deletada nao existe!");
            }
        } else {
            $this->index("Pagina não pode ser deletada!");
        }
    }
    
    public function upload() {
        //print_r($_FILES);
        if ( !empty($_FILES['file']['tmp_name']) ){
            $type = array(
                "image/jpg",
                "image/jpeg",
                "image/png"
            );
            //echo ("<pre>");
            //print_r($_SERVER);
            //echo ("</pre>");
            //$type[] = "image/jpg";
            //$type[] = "image/jpeg";
            //$type[] = "image/png";
            
            if (in_array($_FILES['file']['type'], $type)){
                $destino = $_SERVER['DOCUMENT_ROOT']."/NovaLoja/media/paginas/";
                $newName = md5(time(). rand(0, 999)).$_FILES['file']['name'];
                move_uploaded_file($_FILES['file']['tmp_name'], $destino.$newName);
                $array = array(
                    'location' => BASE_URL.'media/paginas/'.$newName
                );
                
                echo json_encode($array);
                exit();
            }
        }
    }
}
