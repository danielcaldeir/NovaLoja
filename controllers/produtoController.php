<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of produtoController
 *
 * @author Daniel_Caldeira
 */
class produtoController extends controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function abrir($id) {
    //    $dados = array();
        $categorias = new Categorias();
        $produtos = new Produtos();
        $filtros = new Filtros();
        
        $seach = (!empty($_GET['s'])?$_GET['s']:"");
        $category = (!empty($_GET['category'])?$_GET['category']:"");
        
        $dados = $filtros->getTemplateDados();
        $dados['produtosID'] = $produtos->selecionarProdutosID($id);
        if (!empty($dados['produtosID'])){
            $dados['produto_info'] = $filtros->getProdutoInfo($dados['produtosID']);
            
            if (!empty($category)){
                $idCat = intval($category);
                $dados['filtroCategoria'] = $categorias->getArvoreCategoria($idCat);
            }
            
            //$dados['categorias'] = $categorias->ordenarALLCategorias();
            //$dados['widget_featured1'] = $filtros->atualizarProdutos(0, 3, array('featured' => array(1)), true);
            //$dados['widget_featured2'] = $filtros->atualizarProdutos(0, 3, array('featured' => array(1)), true);
            //$dados['widget_sale'] = $filtros->atualizarProdutos(0, 3, array('sale' => array(1)), true);
            //$dados['widget_toprated'] = $filtros->atualizarProdutos(0, 3, array('bestseller' => array(1)) );
            
            $dados['busca'] = $seach;
            $dados['category'] = $category;
            $dados['sidebar'] = FALSE;
            
        //    echo("<pre>");
        //    print_r($dados);
        //    echo("</pre>");
            $this->loadTemplate('produtos', $dados);
        } else {
            header("Location: ".BASE_URL);
        }
    }
    
    public function index() {
        header("Location: ".BASE_URL);
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
            
            if (!$user->validarPermissao('add_produto')){
                $adminLTE->index();
                exit();
            }
        } else {
            $adminLTE->index();
            exit();
        }
        $arrayInfo["menuActive"] = "produto";
        $arrayInfo["nome"] = $user;
        return $arrayInfo;
    }
    
    public function listarProduto($paginaAtual = 1, $confirme = ""){
        $produtos = new Produtos();
        
        $limit = 5;
        $offset = ($paginaAtual * $limit) - $limit;
        
        $dados = $this->validarAdminLTE();
        $dados['mensagem'] = $confirme;
        $dados['produtos'] = $produtos->selecionarAllProdutosJoinMarcasCategorias($offset,$limit);
        $TotalItems = $produtos->getTotalProdutos();
        $dados['paginaAtual'] = $paginaAtual;
        $dados['numeroPaginas'] = ceil($TotalItems/$limit);
        //$dados['sidebar'] = FALSE;
        
        $this->loadAdminLTE("produto", $dados);
    }
    
    public function addProduto($mensagem = ""){
        //$filtros = new Filtros();
        $categoria = new Categorias();
        $marca = new Marcas();
        
        $dados = $this->validarAdminLTE();
        $dados['mensagem'] = $mensagem;
        $dados['cats'] = $categoria->ordenarALLCategorias();
        $dados['marcas'] = $marca->selecionarALLMarcas();
        //$dados['sidebar'] = FALSE;
        
        $this->loadAdminLTE("addProduto", $dados);
    }
    
    public function editProduto($id = "0", $mensagem = ""){
        //$filtros = new Filtros();
        $produto = new Produtos();
        $prdOpcoes = new ProdutosOpcoes();
        $prdImagens = new ProdutosImagens();
        $menu = new Categorias();
        $marca = new Marcas();
        $opcoes = new Opcoes();
        
        //$dados = $filtros->getTemplateDados();
        $dados = $this->validarAdminLTE();
        $dados['mensagem'] = $mensagem;
        $dados['id'] = $id;
        $dados['produto'] = $produto->selecionarProdutosID($id);
        //$array = $produto->selecionarProdutosID($id);
        //$dados['produto'] = $array;
        //$dados['produto_info'] = $filtros->getProdutoInfo($array);
        $dados['opcoes'] = $prdOpcoes->selecionarAllProdutosOpcoesJoinOpcoesIDProduto($id);
        $dados['imagens'] = $prdImagens->selecionarProdutosImagensIDProduto($id);
        $dados['cats'] = $menu->selecionarALLCategorias();
        $dados['marcas'] = $marca->selecionarALLMarcas();
        $dados['ops'] = $opcoes->selecionarALLOpcoes();
        //$dados['sidebar'] = FALSE;
        
        //echo("<pre>");
        //print_r($dados);
        //echo("</pre>");
        //exit();
        
        $this->loadAdminLTE("editProduto", $dados);
    }
    
    public function delProduto($id){
        $filtros = new Filtros();
        $produto = new Produtos();
        $categoria = new Categorias();
        $marca = new Marcas();
        
        $dados = $filtros->getTemplateDados();
        //$dados = $this->validarAdminLTE();
        $dados['id'] = $id;
        $array = $produto->selecionarProdutosID($id);
        $dados['produto'] = $array;
        $dados['produto_info'] = $filtros->getProdutoInfo($array);
        $dados['cats'] = $categoria->selecionarALLCategorias();
        $dados['marcas'] = $marca->selecionarALLMarcas();
        $dados['sidebar'] = FALSE;
        
        $this->loadPainel("delProduto", $dados);
    }
    
    public function addProdutoAction() {
        $produto = array();
        $this->validarAdminLTE();
        if (!empty($_POST['nome']) && !empty($_POST['descricao'])){
            $produto['id_categoria'] = addslashes($_POST['categoria']);
            $produto['id_marca'] = addslashes($_POST['marca']);
            $produto['nome'] = utf8_decode(addslashes($_POST['nome']) );
            $produto['descricao'] = utf8_decode(addslashes($_POST['descricao']) );
            $produto['estoque'] = addslashes($_POST['estoque']);
            $produto['preco'] = addslashes($_POST['preco']);
            $produto['peso'] = addslashes($_POST['peso']);
            $produto['altura'] = addslashes($_POST['altura']);
            $produto['largura'] = addslashes($_POST['largura']);
            $produto['comprimento'] = addslashes($_POST['comprimento']);
            $produto['diametro'] = addslashes($_POST['diametro']);
            
            if (!empty($_POST['categoria']) && !empty($_POST['marca']) && !empty($_POST['estoque']) && !empty($_POST['preco']) ){
                $produtos = new Produtos();
                $newProduto = $produtos->inserirProdutoPrincipal($produto);//$categoria, $marca, $nome, $descricao, $estoque, $preco);
                
                foreach ($newProduto as $item) {
                    $id_produto = $item['id'];
                    $produtos->selecionarProdutosID($id_produto);
                }
                $mensagem = "O Produto ".$produtos->getNome()." foi inserido com sucesso!!";
                $this->addProduto($mensagem);
                //header("Location: ".BASE_URL."produto/addProduto/sucess");
            } else {
                $mensagem = "Nao foi possivel incluir este produto!";
                $this->addProduto($mensagem);
                //header("Location: ".BASE_URL."produto/addProduto/error");
            }
        } else{
            $mensagem = "Nao foi possivel incluir este produto!";
            $this->addProduto($mensagem);
            //header("Location: ".BASE_URL."produto/addProduto/error");
        }
    }
    
    public function sisEditarProduto(){
        if (isset($_POST['id']) && !empty($_POST['id'])){
            $id_produto = addslashes($_POST['id']);
            $categoria = addslashes($_POST['categoria']);
            $marca = addslashes($_POST['marca']);
            $nome = utf8_decode(addslashes($_POST['nome']) );
            $descricao = utf8_decode(addslashes($_POST['descricao']) );
            $estoque = addslashes($_POST['estoque']);
            $precoAnt = addslashes($_POST['precoAnt']);
            $preco = addslashes($_POST['preco']);
            //if (isset($_FILES['fotos'])) {
            //    $fotos = $_FILES['fotos'];
            //} else {
            //    $fotos = array();
            //}
            
            if (!empty($categoria) && !empty($marca) && !empty($nome) && !empty($preco) ){
                $produto = new Produtos();
                $produto->atualizarProdutoPrincipal($categoria, $marca, $nome, $descricao, $estoque, $precoAnt, $preco, $id_produto);
                
            //    $foto = new fotoController();
            //    $url = $foto->addFoto($fotos);
                
            //    if (!is_null($url)) {
            //        $prdImagens = new ProdutosImagens();
            //        $prdImagens->incluirProdutosImagens($id_produto, $url);
            //    }
                
            //echo ("<br/>ID_PRODUTO: ". $id_produto);
            //echo ("<br/>ID_CATEGORIA: ".$categoria);
            //echo ("<br/>ID_MARCA: ".$marca);
            //echo ("<br/>Nome: ".$nome);
            //echo ("<br/>Descricao: ".$descricao);
            //echo ("<br/>Estoque: ".$estoque);
            //echo ("<br/>Preco ANTERIOR: ".$precoAnt);
            //echo ("<br/>Preco Atual: ".$preco);
            //    exit();
                header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/sucess");
            } else {
                //header("Location: ../index.php?pag=editarAnuncio&error=true&id=".$id);
                header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/error");
            }
        } else{
            //header("Location: ../index.php?pag=editarAnuncio&error=true&id=".$id);
            header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/error");
        }
    }
    
    public function sisExcluirProduto() {
        $produto = new Produtos();
        $prd_opcoes = new ProdutosOpcoes();
        $prd_imagens = new ProdutosImagens();
        $prd_avalia = new ProdutosAvalia();
        $foto = new fotoController();
        
        if (count($_POST) > 0){
            $id = $_POST['id'];
        } else {
            $id = $_GET['id'];
        }
        $produto->selecionarProdutosID($id);
        if ($produto->numRows() > 0){
            $produto->deletarProduto($id);
            $array_prd_ops = $prd_opcoes->selecionarProdutosOpcoesIDProduto($id);
            if (count($array_prd_ops) > 0){
                foreach ($array_prd_ops as $item) {
                    $prd_opcoes->deletarProdutoOpcao($item['id']);
                }
            }
            $array_prd_img = $prd_imagens->selecionarProdutosImagensIDProduto($id);
            if (count($array_prd_img) > 0){
                foreach ($array_prd_img as $item) {
                    $foto->excluirFoto($item['id']);
                }
            }
            $array_prd_ava = $prd_avalia->selecionarProdutosAvaliaIDProduto($id);
            if (count($array_prd_ava) > 0){
                foreach ($array_prd_ava as $item) {
                    print_r($item);
                }
            }
            //$confirme = "success";
            header("Location: ".BASE_URL."produto/addProduto/successDEL");
        } else {
            //$confirme = "error";
            header("Location: ".BASE_URL."produto/addProduto/errorDEL");
        }
        //$this->menus($confirme);
    }
    
    public function addSpecificacao() {
        $mensagem = "Não foi possivel Adicionar uma especificacao";
        if (!empty($_POST['id_produto']) && !empty($_POST['valorOP'])){
            $id_produto = addslashes($_POST['id_produto']);
            $opcao = addslashes($_POST['opcao']);
            $valorOP = utf8_decode(addslashes($_POST['valorOP']) );
            
            
            if (!empty($id_produto) && !empty($opcao) && !empty($valorOP) ){
                $prdOpcoes = new ProdutosOpcoes();
                $newOpcao = $prdOpcoes->inserirProdutoOpcao($id_produto, $opcao, $valorOP);
                
                //foreach ($newOpcao as $item) {
                //    $id_opcao = $item['ID'];
                //}
            //    echo ("<pre>");
            //    print_r ($newOpcao);
            //    echo ("</pre>");
            //    echo ("<br/>ID_PRODUTO: ".$id_produto);
            //    echo ("<br/>OPCAO: ".$opcao);
            //    echo ("<br/>VALOR: ".$valorOP);
            //    echo ("<br/>ID_OPCAO: ".$id_opcao);
            //    exit();
                $mensagem = "Especificacao Adicionada com Sucesso!";
                $this->editProduto($id_produto, $mensagem);
                //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/successSPECIFICATIONS");
            } else {
                $this->editProduto($id_produto, $mensagem);
                //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/errorSPECIFICATIONS");
            }
        } else {
            $this->editProduto(0, $mensagem);
            //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/errorSPECIFICATIONS");
        }
    }
    
    public function editSpecificacao() {
        $mensagem = "Não foi possivel a edicao da especificacao";
        if (!empty($_POST['id_produto']) && !empty($_POST['valorOP'])){
            $id_produto = addslashes($_POST['id_produto']);
            $opcao = addslashes($_POST['opcao']);
            $valorOP = utf8_decode(addslashes($_POST['valorOP']) );
            $id_opcao = addslashes($_POST['id_opcao']);
            
            if (!empty($id_produto) && !empty($opcao) && !empty($valorOP) ){
                $prdOpcoes = new ProdutosOpcoes();
                $prdOpcoes->atualizarProdutoOpcao($id_produto, $opcao, $valorOP, $id_opcao);
                
            //    echo ("<br/>ID_PRODUTO: ".$id_produto);
            //    echo ("<br/>OPCAO: ".$opcao);
            //    echo ("<br/>VALOR: ".$valorOP);
            //    echo ("<br/>ID_OPCAO: ".$id_opcao);
            //    exit();
                $mensagem = "Especificacao editada com sucesso!";
                $this->editProduto($id_produto, $mensagem);
                //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/successSPECIFICATIONS");
            } else {
                $this->editProduto($id_produto, $mensagem);
                //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/errorSPECIFICATIONS");
            }
        } else{
            $this->editProduto(0, $mensagem);
            //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/errorSPECIFICATIONS");
        }
    }
    
    public function delSpecificacao($id) {
        $prdOpcoes = new ProdutosOpcoes();
        $prdOpcoes->selecionarProdutosOpcoesID($id);
        $id_produto = null;
        if ($prdOpcoes->numRows() > 0){
            $id_produto = $prdOpcoes->getIDProduto();
            $prdOpcoes->deletarProdutoOpcao($id);
            //$confirme = "success";
            header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/successSPECIFICATIONS");
        } else {
            //$confirme = "error";
            header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/errorSPECIFICATIONS");
        }
    }
    
    public function editBandeira() {
        if (!empty($_POST['id_produto']) ){
            $id_produto = addslashes($_POST['id_produto']);
            $destaque = (isset($_POST['destaque'])? 1: 0);
        //    if (isset($_POST['destaque'])){
        //        $destaque = 1;
        //    } else {
        //        $destaque = 0;
        //    }
            $promo = (isset($_POST['promo'])? 1: 0);
        //    if (isset($_POST['promo'])){
        //        $promo = 1;
        //    } else {
        //        $promo = 0;
        //    }
            $top_vendido = (isset($_POST['top_vendido'])? 1: 0);
        //    if (isset($_POST['top_vendido'])){
        //        $top_vendido = 1;
        //    } else {
        //        $top_vendido = 0;
        //    }
            $novo_produto = (isset($_POST['novo_produto'])? 1: 0);
        //    if (isset($_POST['novo_produto'])){
        //        $novo_produto = 1;
        //    } else {
        //        $novo_produto = 0;
        //    }
            
            $prd = new Produtos();
            $prd->atualizarProdutoBandeira($destaque, $promo, $top_vendido, $novo_produto, $id_produto);
            
            $mensagem = "O Produto foi Editado com Sucesso!";
            $this->editProduto($id_produto, $mensagem);
        } else{
            $mensagem = "O Produto não pode ser Editado!";
            $this->editProduto($id_produto, $mensagem);
            //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/errorSPECIFICATIONS");
        }
    }
}
