<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of produtos
 *
 * @author Daniel_Caldeira
 * 
 * CREATE TABLE `produtos` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_categoria` INT(11) NOT NULL,
	`id_marca` INT(11) NOT NULL,
	`nome` VARCHAR(100) NOT NULL,
	`descricao` TEXT NULL,
	`estoque` INT(11) NOT NULL,
	`preco` FLOAT NOT NULL,
	`preco_ant` FLOAT NOT NULL DEFAULT '0',
	`avalia` FLOAT NOT NULL DEFAULT '0',
	`destaque` TINYINT(1) NOT NULL DEFAULT '0',
	`promo` TINYINT(1) NOT NULL DEFAULT '0',
	`top_vendido` TINYINT(1) NOT NULL DEFAULT '0',
	`novo_produto` TINYINT(1) NOT NULL DEFAULT '1',
	`opcao` VARCHAR(200) NULL DEFAULT NULL,
        `peso` FLOAT NOT NULL DEFAULT '0',
	`altura` FLOAT NOT NULL DEFAULT '0',
	`largura` FLOAT NOT NULL DEFAULT '0',
	`comprimento` FLOAT NOT NULL DEFAULT '0',
	`diametro` FLOAT NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=9
;

 */
class Produtos extends model{
    private $id;
    private $id_categoria;
    private $id_marca;
    private $nome;
    private $descricao;
    private $estoque;
    private $preco;
    private $preco_ant;
    private $avalia;
    private $destaque;
    private $promo;
    private $top_vendido;
    private $novo_produto;
    private $opcao;
    private $peso;
    private $altura;
    private $largura;
    private $comprimento;
    private $diametro;
    
    //put your code here
    public function getTotalProdutos($where = array()) {
        $tabela = "produtos as prd";
        $colunas = array("COUNT(*) AS C");
        $this->selecionarTabelas($tabela, $colunas, $where);
        $array = $this->result();
        foreach ($array as $item) {
            $valor = $item["C"];
        }
        return $valor;
    }
    
    public function getPromoCount($where = array()) {
        $tabela = "produtos as prd";
        $colunas = array("COUNT(promo) AS C");
        $where['promo'] = 1;
        $this->selecionarTabelas($tabela, $colunas, $where);
        $array = $this->result();
        foreach ($array as $item) {
            $valor = $item["C"];
        }
        return $valor;
    }
    
    public function getTotalMarcas($where = array()) {
        $tabela = "produtos as prd";
        $colunas = array("id_marca, COUNT(*) AS c");
        $where_cond = "AND";
        $groupBY = array("GROUP BY ID_MARCA");
        $this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBY);
        if($this->numRows() > 0){
            $array = $this->result();
        } else {
            $array = array();
        }
        return $array;
    }
    
    public function getTotalEstrelas($where = array()) {
        $tabela = "produtos as prd";
        $colunas = array("avalia, COUNT(*) AS c");
        $where_cond = "AND";
        $groupBY = array("GROUP BY AVALIA");
        $this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBY);
        if($this->numRows() > 0){
            $array = $this->result();
        } else {
            $array = array();
        }
        return $array;
    }
    
    public function getTotalCategorias($where = array()) {
        $tabela = "produtos as prd";
        $colunas = array("id_categoria, COUNT(*) AS c");
        $where_cond = "AND";
        $groupBY = array("GROUP BY ID_CATEGORIA");
        $this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBY);
        if($this->numRows() > 0){
            $array = $this->result();
        } else {
            $array = array();
        }
        return $array;
    }
    
    public function getMaxPreco() {
        $tabela = "produtos as prd";
        $colunas = array("MAX(preco) AS MaxPreco");
        $this->selecionarTabelas($tabela, $colunas);
        $array = $this->result();
        foreach ($array as $item) {
            $valor = $item["MaxPreco"];
        }
        return $valor;
    }
    
    public function getMinPreco() {
        $tabela = "produtos as prd";
        $colunas = array("MIN(preco) AS MinPreco");
        $this->selecionarTabelas($tabela, $colunas);
        $array = $this->result();
        foreach ($array as $item) {
            $valor = $item["MinPreco"];
        }
        return $valor;
    }
    
    public function selecionarAllProdutosJoinMarcasCategorias($offset = 0, $limit = 3, $where = array(), $random = false ){
        $tabela = "produtos as prd inner join marcas as mar ON mar.id = prd.id_marca inner join categorias as cat ON prd.id_categoria = cat.id";
        //$colunas = array("prd_op.id","prd.id as id_produto","prd.nome as nomePRD","op.id as id_opcao","op.nome as nomeOP","prd_op.valor");
        $colunas = array("prd.id as id","prd.id_categoria","prd.id_marca","prd.nome","descricao","estoque","preco","preco_ant","avalia","destaque","promo","top_vendido","novo_produto","opcao","mar.nome as marca_nome","cat.nome as categoria_nome");
        $where_cond = "AND";
        $groupBy = array();
        if ($random == true){
            $groupBy[] = ("ORDER BY RAND()");
        }else{
            //$groupBy = array("order by prd.id, op.id");
            $groupBy[] = ("ORDER BY prd.id, prd.id_categoria, prd.id_marca");
        }
        $groupBy[] = ("LIMIT $offset, $limit");
        $this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBy);
        if($this->numRows() > 0){
            $array = $this->result();
        } else {
            $array = array();
        }
        return $array;
    }
    
    public function selecionarALLProdutos($offset = 0, $limit = 3, $where = array()){
        $tabela = "produtos";
        $colunas = array("id","id_categoria","id_marca","nome","descricao","estoque","preco","preco_ant","avalia","destaque","promo","top_vendido","novo_produto","opcao","peso","altura","largura","comprimento","diametro");
        $where_cond = "AND";
        $groupBy = array("LIMIT $offset, $limit");
        $this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBy);
        if($this->numRows() > 0){
            $array = $this->result();
        } else {
            $array = array();
        }
        return $array;
    }
    
    public function selecionarProdutosID($id) {
        $tabela = "produtos";
        $colunas = array("id","id_categoria","id_marca","nome","descricao","estoque","preco","preco_ant","avalia","destaque","promo","top_vendido","novo_produto","opcao","peso","altura","largura","comprimento","diametro");
        $where = array(
            "id" => $id
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            foreach ($array as $item) {
                $this->id = $item['id'];
                $this->id_categoria = $item['id_categoria'];
                $this->id_marca = $item['id_marca'];
                $this->nome = $item['nome'];
                $this->descricao = $item['descricao'];
                $this->estoque = $item['estoque'];
                $this->preco = $item['preco'];
                $this->preco_ant = $item['preco_ant'];
                $this->avalia = $item['avalia'];
                $this->destaque = $item['destaque'];
                $this->promo = $item['promo'];
                $this->top_vendido = $item['top_vendido'];
                $this->novo_produto = $item['novo_produto'];
                $this->opcao = $item['opcao'];
                $this->peso = $item['peso'];
                $this->altura = $item['altura'];
                $this->largura = $item['largura'];
                $this->comprimento = $item['comprimento'];
                $this->diametro = $item['diametro'];
            }
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function getID() {
        return $this->id;
    }
    public function getIDCategoria() {
        return $this->id_categoria;
    }
    public function getIDMarca() {
        return $this->id_marca;
    }
    public function getNome() {
        return $this->nome;
    }
    public function getDescricao() {
        return $this->descricao;
    }
    public function getEstoque() {
        return $this->estoque;
    }
    public function getPreco() {
        return $this->preco;
    }
    public function getPrecoAnt() {
        return $this->preco_ant;
    }
    public function getAvalia() {
        return $this->avalia;
    }
    public function getDestaque() {
        return $this->destaque;
    }
    public function getPromo() {
        return $this->promo;
    }
    public function getTopVendido() {
        return $this->top_vendido;
    }
    public function getNovoProduto() {
        return $this->novo_produto;
    }
    public function getOpcao() {
        return $this->opcao;
    }
    public function getPeso() {
        return $this->peso;
    }
    public function getAltura() {
        return $this->altura;
    }
    public function getLargura() {
        return $this->largura;
    }
    public function getComprimento() {
        return $this->comprimento;
    }
    public function getDiametro() {
        return $this->diametro;
    }
}
