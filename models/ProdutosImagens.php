<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProdutosImagens
 *
 * @author Daniel_Caldeira
 * CREATE TABLE `produtos_imagens` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`id_produto` INT(11) NOT NULL,
	`url` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=9
;

 */
class ProdutosImagens extends model{
    private $id;
    private $id_produto;
    private $url;
    //put your code here
    
    public function incluirProdutosImagens($id_produto, $url){
        $tabela = "Produtos_imagens";
        $dados = array (
            "id_produto" => $id_produto,
            "url" => $url
        );
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->array;
    }
    
    public function deletarProdutosImagensID($id_imagem){
        $tabela = "Produtos_imagens";
        $where = array( 
            "id" => $id_imagem 
        );
        $this->delete($tabela, $where);
        return null;
    }
    
    public function selecionarALLProdutosImagens() {
        $tabela = "Produtos_imagens";
        $colunas = array("id","id_produto","url");
        $this->selecionarTabelas($tabela, $colunas);
        return $this->result();
    }
    
    public function selecionarProdutosImagensID($id) {
        $tabela = "Produtos_imagens";
        $colunas = array("id","id_produto","url");
        $where = array(
            "id" => $id
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            foreach ($array as $item) {
                $this->id = $item['id'];
                $this->id_produto = $item['id_produto'];
                $this->url = $item['url'];
            }
        } else {
            $array = array();
        }
        return $array;
    }
    
    public function selecionarProdutosImagensIDProduto($id_produto) {
        $tabela = "Produtos_imagens";
        $colunas = array("id","id_produto","url");
        $where = array(
            "id_produto" => $id_produto
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        return $this->result();
    }
    
    public function getID() {
        return $this->id;
    }
    public function getID_Produto() {
        return $this->id_produto;
    }
    public function getURL() {
        return $this->url;
    }
}
