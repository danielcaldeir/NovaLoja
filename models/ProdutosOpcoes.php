<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProdutosOpcoes
 *
 * @author Daniel_Caldeira
 */
class ProdutosOpcoes extends model {
    private $id;
    private $id_produto;
    private $id_opcao;
    private $valor;
    //put your code here
    
    private function selecionarAllProdutosJoinProdutosOpcoes( $where = array() ){
        $tabela = "produtos as prd inner join produtos_opcoes as prd_op ON prd_op.id_produto = prd.id inner join opcoes as op ON prd_op.id_opcao = op.id";
        //$colunas = array("prd_op.id","prd.id as id_produto","prd.nome as nomePRD","op.id as id_opcao","op.nome as nomeOP","prd_op.valor");
        $colunas = array("op.id","op.nome as nomeOP","prd_op.valor","count(*) as QTD");
        $where_cond = "AND";
        //$groupBy = array("order by prd.id, op.id");
        $groupBy = array("GROUP BY op.id, prd_op.valor","ORDER BY op.id, prd_op.valor");
        $this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBy);
        if($this->numRows() > 0){
            $array = $this->result();
        } else {
            $array = array();
        }
        return $array;
    }
    
    public function visualizarAllCountProdutos($consultas = array()){
        //Configurar o $where
  //  private $id;
  //  private $id_categoria;
  //  private $id_marca;
  //  private $nome;
  //  private $descricao;
  //  private $estoque;
  //  private $preco;
  //  private $preco_ant;
  //  private $avalia;
  //  private $destaque;
  //  private $promo;
  //  private $top_vendido;
  //  private $novo_produto;
  //  private $opcao;
  //  produtos as prd
        $where = array();
        if (!empty($consultas['prd.id'])){
            $where['prd.id'] = $consultas['prd.id'];
        }
        if (!empty($consultas['prd.nome'])){
            $where['prd.nome'] = $consultas['prd.nome'];
        }
        if (!empty($consultas['id_categoria'])){
            $where['prd.id_categoria'] = $consultas['id_categoria'];
        }
        if (!empty($consultas['id_marca'])){
            $where['prd.id_marca'] = $consultas['id_marca'];
        }
        if (!empty($consultas['avalia'])){
            $where['prd.avalia'] = $consultas['avalia'];
        }
        if (!empty($consultas['destaque'])){
            $where['prd.destaque'] = $consultas['destaque'];
        }
        if (!empty($consultas['promo'])){
            $where['prd.promo'] = $consultas['promo'];
        }
        if (!empty($consultas['top_vendido'])){
            $where['prd.top_vendido'] = $consultas['top_vendido'];
        }
        if (!empty($consultas['preco'])){
            $where['prd.preco'] = $consultas['preco'];
        }
        //$colunas = array("op.id","op.nome as nomeOP","prd_op.valor","count(*) as QTD");
        //$groupBy = array("Group by op.id, prd_op.valor");
        $array = $this->selecionarAllProdutosJoinProdutosOpcoes($where);
        $arrayProdutos = array();
        foreach ($array as $key => $itemPrd) {
            $arrayProdutos[$itemPrd['id']]['nome'] = $itemPrd['nomeOP'];
            $arrayProdutos[$itemPrd['id']]['opcao'][$key]['id'] = $itemPrd['id'];
            $arrayProdutos[$itemPrd['id']]['opcao'][$key]['valor'] = $itemPrd['valor'];
            $arrayProdutos[$itemPrd['id']]['opcao'][$key]['QTD'] = $itemPrd['QTD'];
        }
        
        return $arrayProdutos;
    }
    
    public function selecionarAllProdutosOpcoesJoinOpcoesIDProduto($id_produto) {
        $tabela = "produtos_opcoes as prd_op INNER JOIN opcoes as op ON prd_op.id_opcao = op.id";
        $colunas = array("prd_op.id","prd_op.id_produto","prd_op.id_opcao","prd_op.valor","op.nome as nomeOpcao");
        $where = array(
            "id_produto" => $id_produto
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function selecionarProdutosOpcoesIDProduto($id_produto) {
        $tabela = "produtos_opcoes";
        $colunas = array("id","id_produto","id_opcao","valor");
        $where = array(
            "id_produto" => $id_produto
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function selecionarProdutosOpcoesValor($valor = array()){
        $tabela = "produtos_opcoes";
        $colunas = array("id","id_produto","id_opcao","valor");
        $where_cond = "AND";
        $where = array('valor' => $valor);
        $groupBy = array();
        $this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBy);
        if($this->numRows() > 0){
            $array = $this->result();
        } else {
            $array = array();
        }
        return $array;
    }
    
    protected function selecionarALLProdutosOpcoes($where = array()){
        $tabela = "produtos_opcoes";
        $colunas = array("id","id_produto","id_opcao","valor");
        $where_cond = "AND";
        $groupBy = array();
        $this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBy);
        if($this->numRows() > 0){
            $array = $this->result();
        } else {
            $array = array();
        }
        return $array;
    }
    
    public function selecionarProdutosOpcoesID($id) {
        $tabela = "produtos_opcoes";
        $colunas = array("id","id_produto","id_opcao","valor");
        $where = array(
            "id" => $id
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            foreach ($array as $item) {
                $this->id = $item['id'];
                $this->id_produto = $item['id_produto'];
                $this->id_opcao = $item['id_opcao'];
                $this->valor = $item['valor'];
            }
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function setID($id) {
        $this->id = $id;
    }
    public function getID() {
        return $this->id;
    }
    public function setIDProduto($idProduto) {
        $this->id_produto = $idProduto;
    }
    public function getIDProduto() {
        return $this->id_produto;
    }
    public function setIDOpcao($idOpcao) {
        $this->id_opcao = $idOpcao;
    }
    public function getIDOpcao() {
        return $this->id_opcao;
    }
    public function setValor($valor) {
        $this->valor = $valor;
    }
    public function getValor() {
        return $this->valor;
    }
}
