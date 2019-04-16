<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Filtros
 *
 * @author Daniel_Caldeira
 */
class Filtros extends model{
    private $where;
    
    public function __construct() {
        parent::__construct();
    }
    
    //put your code here
    private function atualizaWhereProdutos($consultas) {
        $where = array();
        $produtosOpcoes = new ProdutosOpcoes();
        
        if (!empty($consultas['marca'])){
            foreach ($consultas['marca'] as $item) {
                $where['id_marca'][] = $item;
            }
        }
        if (!empty($consultas['star'])){
            foreach ($consultas['star'] as $item) {
                $where['avalia'][] = $item;
            }
        }
        if (!empty($consultas['featured'])){
            foreach ($consultas['featured'] as $item) {
                $where['destaque'][] = $item;
            }
        }
        if (!empty($consultas['sale'])){
            foreach ($consultas['sale'] as $item) {
                $where['promo'][] = $item;
            }
        }
        if (!empty($consultas['bestseller'])){
            foreach ($consultas['bestseller'] as $item) {
                $where['top_vendido'][] = $item;
            }
        }
        if (!empty($consultas['opcao'])){
            foreach ($consultas['opcao'] as $item) {
                $valor[] = $item;
            }
            $OProduto = $produtosOpcoes->selecionarProdutosOpcoesValor($valor);
            foreach ($OProduto as $OPitem) {
                $where['prd.id'][] = $OPitem['id_produto'];
            }
        }
        
        if (!empty($consultas['id_categoria'])){
            $where['id_categoria'] = $consultas['id_categoria'];
        }
        
        if (!empty($consultas['slider0'])){
            $where['preco']['>'] = $consultas['slider0'];
        //    array(
        //        'preco' => $consultas['slider0']
        //    );
        //    "select id from produtos where preco > ".$consultas['slider0'];
        }
        if (!empty($consultas['slider1'])){
            $where['preco']['<'] = $consultas['slider1'];
        //    array(
        //        'preco' => $consultas['slider1']
        //    );
        //    "select id from produtos where preco < ".$consultas['slider1'];
        }
        if (!empty($consultas['busca'])){
            $where['prd.nome']['LIKE'] = $consultas['busca'];
        }
        //echo ("<pre>");
        //print_r($where);
        //echo ("</pre>");
        $this->where = $where;
        return $where;
    }
    
    private function selecionarALLEstrelas() {
        $array = array();
        for ($x=0; $x<7; $x++){
            $array[] = 0;
        }
        return $array;
    }
    
    public function getTotalProdutos($consultas = array()) {
        $produtos = new Produtos();
        if (is_array($this->getWhere())) {
            $where = $this->getWhere();
        }else{
            $where = $this->atualizaWhereProdutos($consultas);
        }
        
        $valor = $produtos->getTotalProdutos($where);
        return $valor;
    }
    
    public function atualizarFiltros($consultas = array()) {
        $produtos = new Produtos();
        $marcas = new Marcas();
        $produtosOpcoes = new ProdutosOpcoes();
        $array = array(
            'busca' => '',
            'marcas' => array(),
            'slider0' => 0,
            'slider1' => 0,
            'maxslider' => 1000,
            'minslider' => 0,
            'estrelas' => array(),
            'promo' => 0,
            'options' => array()
        );
        if (is_array($this->getWhere())) {
            $where = $this->getWhere();
        }else{
            $where = $this->atualizaWhereProdutos($consultas);
        }
        
        //Criando o Filtro de Preco
        $array['maxslider'] = $produtos->getMaxPreco();
        $array['minslider'] = $produtos->getMinPreco();
        $array['slider1'] = $array['maxslider'];
        $array['slider0'] = $array['minslider'];
        if (!empty($consultas['slider0'])){
            $array['slider0'] = $consultas['slider0'];
        }
        if (!empty($consultas['slider1'])){
            $array['slider1'] = $consultas['slider1'];
        }
        
        //Criando o Array busca
        if (isset($consultas['busca'])){
            $array['busca'] = $consultas['busca'];
        }
        
        //Criando Filtro de Marcas
        $array['marcas'] = $marcas->selecionarALLMarcas();
        $marca_produtos = $produtos->getTotalMarcas($where);
        foreach ($array['marcas'] as $keyMarca => $marcaItem) {
            $array['marcas'][$keyMarca]['count'] = 0;
            foreach ($marca_produtos as $mProduto) {
                if ($mProduto['id_marca'] == $marcaItem['id']){
                    $array['marcas'][$keyMarca]['count'] = $mProduto['c'];
                }
            }
            if ($array['marcas'][$keyMarca]['count'] == 0){
                unset($array['marcas'][$keyMarca]);
            }
        }
        
        //Criando Filtro Estrela
        $array['estrelas'] = $this->selecionarALLEstrelas();
        $estrela_produtos = $produtos->getTotalEstrelas($where);
        foreach ($array['estrelas'] as $keyEstrela => $estrelaItem) {
            foreach ($estrela_produtos as $mProduto) {
                if ($mProduto['avalia'] == $keyEstrela){
                    $array['estrelas'][$keyEstrela] = $mProduto['c'];
                }
            }
        }
        
        //Criando Filtro Promocao
        $array['promo'] = $produtos->getPromoCount($where);
        
        //Criando Filtro Opcoes
        $opcoes_count = $produtosOpcoes->visualizarAllCountProdutos($where);
        $array['options'] = $opcoes_count;
        
        return $array;
    }
    
    public function atualizarProdutos($offset = 0, $limit = 0, $consultas = array(), $random = false) {
        $produtos = new Produtos();
    //    $marcas = new Marcas();
    //    $categorias = new Categorias();
        $produtoImagens = new ProdutosImagens();
        $where = $this->atualizaWhereProdutos($consultas);
        
        $array = $produtos->selecionarAllProdutosJoinMarcasCategorias($offset, $limit, $where, $random);
        if ($produtos->numRows() > 0){
            foreach ($array as $key => $item) {
                $array[$key]['imagens'] = $produtoImagens->selecionarProdutosImagensIDProduto($item['id']);
                if (count($array[$key]['imagens']) == 0){
                    $array[$key]['imagens'][0]['url'] = "indisponivel.jpg";
                }
            }
        }
        
    //    $array = $produtos->selecionarALLProdutos($offset, $limit, $where);
    //    if ($produtos->numRows() > 0){
    //        foreach ($array as $key => $item) {
    //            $marcas->selecionarMarcasID($item['id_marca']);
    //            $array[$key]['marca_nome'] = $marcas->getNome();
    //            $categorias->selecionarCategoriasID($item['id_categoria']);
    //            $array[$key]['categoria_nome'] = $categorias->getNome();
    //            $array[$key]['imagens'] = $produtoImagens->selecionarProdutosImagensIDProduto($item['id']);
    //        }
    //    }
        return $array;
    }
    
    public function getProdutoInfo($produto = array()) {
        $marcas = new Marcas();
        $produtosImagens = new ProdutosImagens();
        $produtosOpcoes = new ProdutosOpcoes();
        $produtosAvalia = new ProdutosAvalia();
    //    $usuarios = new Usuarios();
    //    $opcoes = new Opcoes();
        
        $produto_info = array();
        if (count($produto) > 0){
            foreach ($produto as $value) {
                $produto_info = $value;
                $marcas->selecionarMarcasID($value['id_marca']);
                $produto_info['marca_nome'] = $marcas->getNome();
                $idProduto = intval($value['id']);
                $produto_info['imagens'] = $produtosImagens->selecionarProdutosImagensIDProduto($idProduto);
                $produto_info['opcoes'] = $produtosOpcoes->selecionarAllProdutosOpcoesJoinOpcoesIDProduto($idProduto);
                $produto_info['avalia'] = $produtosAvalia->selecionarAllProdutosAvaliaJoinUsuariosIDProduto($idProduto);
            }
            if (count($produto_info['imagens']) == 0){
                $produto_info['imagens'][0]['url'] = "indisponivel.jpg";
            }
        //    if (count($produto_info['opcoes']) > 0){
        //        foreach ($produto_info['opcoes'] as $key => $opc) {
        //            $opcoes->selecionarOpcoesID($opc['id_opcao']);
        //            $nomeOpcao = $opcoes->getNome();
        //            $produto_info['opcoes'][$key]['nomeOpcao'] = $nomeOpcao;
        //        }
        //    }
        //    if (count($produto_info['avalia']) > 0){
        //        foreach ($produto_info['avalia'] as $key => $avalia) {
        //            $usuarios->selecionarUsuariosID($avalia['id_user']);
        //            $userNome = $usuarios->getNome();
        //            $produto_info['avalia'][$key]['nomeUser'] = $userNome;
        //        }
        //    }
        }
        
        return $produto_info;
    }
    
    public function getTemplateDados() {
        $dados = array();
        $categorias = new Categorias();
        
        $dados['categorias'] = $categorias->ordenarALLCategorias();
        $dados['widget_featured1'] = $this->atualizarProdutos(0, 3, array('featured' => array(1)), true);
        //$dados['widget_featured2'] = $this->atualizarProdutos(0, 3, array('featured' => array(1)), true);
        $dados['widget_sale'] = $this->atualizarProdutos(0, 3, array('sale' => array(1)), true);
        $dados['widget_toprated'] = $this->atualizarProdutos(0, 3, array('bestseller' => array(1)) );
        
        return $dados;
    }
    
    protected function getWhere() {
        return $this->where;
    }
    
}
?>
