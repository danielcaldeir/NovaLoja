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
    
}
