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
}
