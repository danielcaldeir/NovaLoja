<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of opcoesController
 *
 * @author Daniel_Caldeira
 */
class opcoesController extends controller{
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
            
            if (!$this->user->validarPermissao('add_produto')){
                //header("Location: ".BASE_URL."adminLTE");
                $adminLTE->index();
                exit();
            }
        } else {
            $adminLTE->index();
            exit();
        }
        $this->arrayInfo["menuActive"] = "produto";
        $this->arrayInfo["nome"] = $this->user;
        //global $config;
        //$this->config = $config;
        parent::__construct();
    }
    
    //put your code here
    public function index($mensagem = "") {
        $opcoes = new Opcoes();
        
        $opcoes->getALLOpcoesProdutos();
        $array = array();
        foreach ($opcoes->result() as $item) {
            if (is_null($item['total_opcao'])){
                $item['total_opcao'] = 0;
                $array[] = $item;
            } else {
                $array[] = $item;
            }
        }
        $this->arrayInfo['opcoes'] = $array;
        $this->arrayInfo['mensagem'] = $mensagem;
        //echo ("<pre>");
        //print_r($this->arrayInfo['marcas']);
        //print_r($this->arrayInfo['nome']);
        //echo ("</pre>");
        
        $this->loadAdminLTE("opcoes", $this->arrayInfo);
    }
    
    public function addAction($mensagem = "") {
        $opcoes = new Opcoes();
        
        if (!empty($_POST['nome'])){
            $nome = addslashes($_POST['nome']);
            $array = $opcoes->addOpcoes($nome);
            foreach ($array as $item) {
                $id = $item['ID'];
                $opcoes->selecionarOpcoesID($id);
                $mensagem = "O item ".$opcoes->getNome()." foi incluido com sucesso!!";
            }
        } else{
            $mensagem = "Nao foi Informado um Nome!";
        }
        
        $this->index($mensagem);
    }
    
    //public function add($mensagem = "") {
    //    $marcas = new Marcas();
    //    $perItens = new PermissaoItem();
    //    $permissao = new Permissao();
    //    
    //    $this->arrayInfo['marcas'] = $marcas->selecionarALLMarcas();
    //    $this->arrayInfo['permitido'] = $permissao->getAllPermissaoGrupo();
    //    $this->arrayInfo['permissaoItens'] = $perItens->selecionarALLPermissaoItem();
    //    $this->arrayInfo['mensagem'] = $mensagem;
    //    
    //    $this->loadAdminLTE("addPermissao", $this->arrayInfo);
    //}
    
    public function editAction() {
        $opcoes = new Opcoes();
        
        if (!empty($_POST['id'])){
            $id = addslashes($_POST['id']);
            if (!empty($_POST['nome'])){
                $nome = addslashes($_POST['nome']);
                $opcoes->editOpcoes($id, $nome);
                $mensagem = "A Opcao ".$nome." foi Editada com Sucesso!";
            } else{
                $mensagem = "Nao foi Informado um Nome!";
            }
            $this->index($id, $mensagem);
        } else {
            $mensagem = "Nao foi vinculado um Identificador Valido";
            $this->index($mensagem);
        }
    }
    
    public function edit($id = null, $mensagem = "") {
        $opcoes = new Opcoes();
        
        if (!empty($id)){
            $opcoes->selecionarOpcoesID($id);
            if ($opcoes->numRows() > 0){
                $this->arrayInfo['nomeOpcao'] = $opcoes->getNome();
                $this->arrayInfo['id'] = $opcoes->getID();
                $this->arrayInfo['mensagem'] = $mensagem;
            } else {
                $mensagem = "Nao foi possivel encontrar nenhum Item!!";
                $this->index($mensagem);
                exit();
            }
        } else {
            $mensagem = "Para poder Editar é necessário um ID vinculado!!";
            $this->index($mensagem);
            exit();
        }
        //echo ("<pre>");
        //print_r($this->arrayInfo['marcas']);
        //print_r($this->arrayInfo['nome']);
        //echo ("</pre>");
        
        $this->loadAdminLTE("editOpcoes", $this->arrayInfo);
    }
    
    public function del($id){
        $opcoes = new Opcoes();
        
        if ($opcoes->validarDelOpcao($id)){
            $this->index("Marca Deletada com Sucesso!");
        } else {
            $this->index("Nao foi possivel deletar a marca!");
        }
    }
}
