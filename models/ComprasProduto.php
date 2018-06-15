<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ComprasProduto
 *
 * @author Daniel_Caldeira
 */
class ComprasProduto extends model{
    private $id;
    private $id_compra;
    private $id_produto;
    private $quantidade;
    private $preco;
    //put your code here
    
    public function inserirComprasProduto($idCompra, $idProduto, $quantidade, $preco) {
        $tabela = "compras_produtos";
        $dados = array(
            'id_compra' => $idCompra,
            'id_produto' => $idProduto,
            'quantidade' => $quantidade,
            'preco' => $preco
        );
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->result();
    }
    
    public function selecionarComprasProdutoIDCompra($idCompra) {
        $tabela = "compras_produtos";
        $colunas = array("id","id_compra","id_produto","quantidade","preco");
        $where = array(
            "id_compra" => $idCompra
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function selecionarComprasProdutoID($id) {
        $tabela = "compras_produto";
        $colunas = array ("id","id_compra","id_produto","quantidade","preco");
        $where = array(
            "id" => $id
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            foreach ($array as $item) {
                $this->id = $item['id'];
                $this->id_compra = $item['id_compra'];
                $this->id_produto = $item['id_produto'];
                $this->quantidade = $item['quantidade'];
                $this->preco = $item['preco'];
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
    public function setIDCompra($idCompra) {
        $this->id_compra = $idCompra;
    }
    public function getIDCompra() {
        return $this->id_compra;
    }
    public function setIDProduto($idProduto) {
        $this->id_produto = $idProduto;
    }
    public function getIDProduto() {
        return $this->id_produto;
    }
    public function setQuantidade($qtd) {
        $this->quantidade = $qtd;
    }
    public function getQuantidade() {
        return $this->quantidade;
    }
    public function setPreco($preco) {
        $this->preco = $preco;
    }
    public function getPreco() {
        return $this->preco;
    }
}
