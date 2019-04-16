<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of marcasLTEController
 *
 * @author Daniel_Caldeira
 */
class marcasLTEController extends controller{
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
            
            if (!$this->user->validarPermissao('add_marca')){
                //header("Location: ".BASE_URL."adminLTE");
                $adminLTE->index();
                exit();
            }
        } else {
            $adminLTE->index();
            exit();
        }
        $this->arrayInfo["menuActive"] = "marca";
        $this->arrayInfo["nome"] = $this->user;
        //global $config;
        //$this->config = $config;
        parent::__construct();
    }
    
    //put your code here
    public function index($mensagem = "") {
        $marcas = new Marcas();
        
        $marcas->getALLMarcasProdutos();
        $array = array();
        foreach ($marcas->result() as $item) {
            if (is_null($item['total_marca'])){
                $item['total_marca'] = 0;
                $array[] = $item;
            } else {
                $array[] = $item;
            }
        }
        $this->arrayInfo['marcas'] = $array;
        $this->arrayInfo['mensagem'] = $mensagem;
        //echo ("<pre>");
        //print_r($this->arrayInfo['marcas']);
        //print_r($this->arrayInfo['nome']);
        //echo ("</pre>");
        
        $this->loadAdminLTE("marcas", $this->arrayInfo);
    }
    
    public function addAction($mensagem = "") {
        $marcas = new Marcas();
        
        if (!empty($_POST['nome'])){
            $nome = addslashes($_POST['nome']);
            $array = $marcas->addMarca($nome);
            foreach ($array as $item) {
                $id = $item['ID'];
                $marcas->selecionarMarcasID($id);
                $mensagem = "O item ".$marcas->getNome()." foi incluido com sucesso!!";
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
        $marcas = new Marcas();
        
        if (!empty($_POST['id'])){
            $id = addslashes($_POST['id']);
            if (!empty($_POST['nome'])){
                $nome = addslashes($_POST['nome']);
                $marcas->editMarca($id, $nome);
                $mensagem = "A Marca ".$nome." foi Editada com Sucesso!";
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
        $marcas = new Marcas();
        
        if (!empty($id)){
            $marcas->selecionarMarcasID($id);
            if ($marcas->numRows() > 0){
                $this->arrayInfo['nomeMarca'] = $marcas->getNome();
                $this->arrayInfo['id'] = $marcas->getID();
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
        
        $this->loadAdminLTE("editMarcas", $this->arrayInfo);
    }
    
    public function del($id){
        $marcas = new Marcas();
        
        if ($marcas->validarDelMarca($id)){
            $this->index("Marca Deletada com Sucesso!");
        } else {
            $this->index("Nao foi possivel deletar a marca!");
        }
    }
}
