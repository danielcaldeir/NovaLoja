<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of permissaoLTEController
 *
 * @author Daniel_Caldeira
 */
class permissaoLTEController extends controller{
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
            //print_r($_SESSION['token']);
            //$validar = new adminLTEController();
            $adminLTE->index();
            exit();
        }
        $this->arrayInfo["menuActive"] = "permissao";
        $this->arrayInfo["nome"] = $this->user;
        //global $config;
        //$this->config = $config;
        parent::__construct();
    }
    
    //put your code here
    public function index($mensagem = "") {
        //$paginas = new Paginas();
        //$menu = new Categorias();
        //$filtros = new Filtros();
        //$dados = array();
		
        //$dados = $filtros->getTemplateDados();
        //$dados['nome'] = "Administrador: ".$this->user.getNome;
        $permissao = new Permissao();
        $this->arrayInfo['permissao'] = ($permissao);
        $this->arrayInfo['permitido'] = ($permissao->getAllPermissaoGrupo());
        $this->arrayInfo['mensagem'] = $mensagem;
        //echo ("<pre>");
        //print_r($this->permissao);
        //echo ("</pre>");
	//$dados['menus'] = $menu->ordenarALLCategorias();
        //$dados['paginas'] = $paginas->selecionarALLPaginas();
        //$dados['sidebar'] = FALSE;
        
        $this->loadAdminLTE("permissao", $this->arrayInfo);
    }
    
    public function itemPermissao($mensagem = "") {
        //$dados = array();
        $perItens = new PermissaoItem();
        
        $permissao = new Permissao();
        $this->arrayInfo['permissao'] = ($permissao);
        $this->arrayInfo['permitido'] = ($permissao->getAllPermissaoGrupo());
        $this->arrayInfo['mensagem'] = $mensagem;
        $this->arrayInfo['permissaoItens'] = $perItens->selecionarALLPermissaoItem();
        //$dados['sidebar'] = FALSE;
        
        $this->loadAdminLTE("permissaoItem", $this->arrayInfo);
    }
    
    public function del($id_grupo){
        $permissao = new Permissao();
        
        if ($permissao->validarDelPermissao($id_grupo)){
            $this->index("Permissao Deletada com Sucesso!");
        } else {
            $this->index("Nao tem permissao para deletar!");
        }
    }
    
    public function add($mensagem = "") {
	//$dados = array();
        $perItens = new PermissaoItem();

        $permissao = new Permissao();
        $this->arrayInfo['permissao'] = ($permissao);
        $this->arrayInfo['permitido'] = ($permissao->getAllPermissaoGrupo());
        $this->arrayInfo['mensagem'] = $mensagem;
        $this->arrayInfo['permissaoItens'] = $perItens->selecionarALLPermissaoItem();
        //$dados['sidebar'] = FALSE;
        
        $this->loadAdminLTE("addPermissao", $this->arrayInfo);
    }
    
    private function addPermissaoItem($id_grupo, $items) {
        $permissao = new Permissao();
        $perItens = new PermissaoItem();
        
        $allItens = $perItens->selecionarALLPermissaoItem();
        //echo ("<pre>");
        foreach ($allItens as $item) {
            $id_item = $item['id'];
            //echo ("<br>in_array: ");
            //print_r(in_array($id_item, $items));
            if (in_array($id_item, $items)){
                $permissao->addPermissao($id_grupo, $id_item, '1');
            } else {
                $permissao->addPermissao($id_grupo, $id_item, '0');
            }
        }
        //echo ("</pre>");
    }
    
    public function addAction($mensagem = "") {
	//$dados = array();
        //$permissao = new Permissao();
        $perGrupo = new PermissaoGrupo();
        //$perItens = new PermissaoItem();
        if (!empty($_POST['nome'])){
            $nome = addslashes($_POST['nome']);
            $array = $perGrupo->addPermissaoGrupo($nome);
            
            foreach ($array as $item) {
                $id_grupo = $item['ID'];
                if( isset($_POST['items']) && count($_POST['items'])){
                    $items = ($_POST['items']);
                    $this->addPermissaoItem($id_grupo, $items);
                } else{
                    $mensagem = "Nao ha Items!";
                }
            }
        } else{
            $mensagem = "Nao foi vinculado uma permissao!";
        }
        
        $this->add($mensagem);
    }
    
    public function addItem($mensagem = "") {
        //$dados = array();
        $perItens = new PermissaoItem();
        
        $permissao = new Permissao();
        $this->arrayInfo['permissao'] = ($permissao);
        $this->arrayInfo['permitido'] = ($permissao->getAllPermissaoGrupo());
        $this->arrayInfo['mensagem'] = $mensagem;
        $this->arrayInfo['permissaoItens'] = $perItens->selecionarALLPermissaoItem();
        //$dados['sidebar'] = FALSE;
        
        $this->loadAdminLTE("addPermissaoItem", $this->arrayInfo);
    }
    
    public function addItemAction($mensagem = "") {
        //$dados = array();
        //$permissao = new Permissao();
        //$perGrupo = new PermissaoGrupo();
        $perItens = new PermissaoItem();
        
        if (!empty($_POST['nome']) && !empty($_POST['slug'])){
            $nome = addslashes($_POST['nome']);
            $slug = addslashes($_POST['slug']);
            $perItens->addPermissaoItem($nome, $slug);
            $mensagem = "Item Adicionado com Sucesso!";
        } else{
            $mensagem = "Nao foi vinculado uma permissao!";
        }
        
        $this->addItem($mensagem);
    }
    
    public function editItem($id = null, $mensagem = "") {
        //$dados = array();
        $perItens = new PermissaoItem();
        //$perGrupo = new PermissaoGrupo();
        
        if (!empty($id)){
            $perItens->selecionarPermissaoItemID($id);
            $this->arrayInfo['nomeItem'] = $perItens->getNome();
            $this->arrayInfo['slug'] = $perItens->getSlug();
        } else {
            $mensagem = "Para poder Editar é necessário um ID vinculado!!";
            $this->index($mensagem);
            exit();
        }
	
        $permissao = new Permissao();
        $this->arrayInfo['permissao'] = ($permissao);
        $this->arrayInfo['permitido'] = ($permissao->getAllPermissaoGrupo());
        $this->arrayInfo['mensagem'] = $mensagem;
        $this->arrayInfo['permissaoItens'] = $perItens->selecionarALLPermissaoItem();
        $this->arrayInfo['id_Item'] = $id;
        //$dados['sidebar'] = FALSE;
        
        $this->loadAdminLTE("editPermissaoItem", $this->arrayInfo);
    }
    
    public function edit($id = null, $mensagem = "") {
        //$dados = array();
        $perItens = new PermissaoItem();
        $perGrupo = new PermissaoGrupo();
        $permissao = new Permissao();
        
        if (!empty($id)){
            $perGrupo->selecionarPermissaoGrupoID($id);
            $this->arrayInfo['nomeGrupo'] = $perGrupo->getNome();
            $this->arrayInfo['grupoPermissao'] = $permissao->getPermissaoIDGrupo($id);
        } else {
            $mensagem = "Para poder Editar é necessário um ID vinculado!!";
            $this->index($mensagem);
            exit();
        }
	
        $this->arrayInfo['permissao'] = ($permissao);
        $this->arrayInfo['permitido'] = ($permissao->getAllPermissaoGrupo());
        $this->arrayInfo['mensagem'] = $mensagem;
        $this->arrayInfo['permissaoItens'] = $perItens->selecionarALLPermissaoItem();
        $this->arrayInfo['id_grupo'] = $id;
        //$dados['sidebar'] = FALSE;
        
        $this->loadAdminLTE("editPermissao", $this->arrayInfo);
    }
    
    private function editPermissaoItem($id_grupo, $items) {
        $permissao = new Permissao();
        $perItens = new PermissaoItem();
        
        $allItens = $perItens->selecionarALLPermissaoItem();
        $verificar = $permissao->selecionarPermissaoIDGrupo($id_grupo);
        //echo ("<pre>");
        if (count($items) == count($verificar)){
            foreach ($allItens as $item) {
                $id_item = $item['id'];
                //echo ("<br>in_array: ");
                //print_r(in_array($id_item, $items));
                if (in_array($id_item, $items)){
                    $permissao->editPermissao($id_grupo, $id_item, '1');
                } else {
                    $permissao->editPermissao($id_grupo, $id_item, '0');
                }
            }
        } else {
            $permissao->delPermissaoIDGrupo($id_grupo);
            $this->addPermissaoItem($id_grupo, $items);
        }
        //echo ("</pre>");
    }
    
    public function editAction($id_grupo, $mensagem = "") {
        $perGrupo = new PermissaoGrupo();
        //$perItens = new PermissaoItem();
        if (!empty($id_grupo)){
            if (!empty($_POST['nome'])){
                $nome = addslashes($_POST['nome']);
                $perGrupo->editPermissaoGrupo($id_grupo, $nome);
                if( isset($_POST['items']) && count($_POST['items'])){
                    $items = ($_POST['items']);
                    $this->editPermissaoItem($id_grupo, $items);
                } else{
                    $mensagem = "Nao ha Items!";
                }
            } else{
                $mensagem = "Nao foi vinculado uma permissao!";
            }
            $this->edit($id_grupo, $mensagem);
        } else {
            $this->index($mensagem);
        }
    }
}
