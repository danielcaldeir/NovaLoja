<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of marcas
 *
 * @author Daniel_Caldeira
 * CREATE TABLE `marcas` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(100) NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=4
;

 */
class Marcas extends model {
    private $id;
    private $nome;
    
    private function incluirElementos($elementos = array()) {
        if (count($elementos) == 1){
            foreach ($elementos as $item) {
                $this->setID($item['id']);
                $this->setNome($item['nome']);
            }
        }
    }
    //put your code here
    public function selecionarALLMarcas() {
        $tabela = "marcas";
        $colunas = array("id","nome");
        $where = array();
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            $this->incluirElementos($array);
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function getALLMarcasProdutos() {
        $tabela = "marcas LEFT JOIN (SELECT id_marca, count(id_marca) as total_marca from produtos GROUP BY id_marca) as prd ON prd.id_marca = marcas.id";
        $colunas = array("marcas.id","marcas.nome", "prd.total_marca");
        $where = array();
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            $this->incluirElementos($array);
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function selecionarMarcasID($id) {
        $tabela = "marcas";
        $colunas = array("id","nome");
        $where = array(
            "id" => $id
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            $this->incluirElementos($array);
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function validarDelMarca($id_marca) {
        $produto = new Produtos();
        $prdMarca = $produto->selecionarProdutosIDMarca($id_marca);
        
        if (count($prdMarca) === 0){
            //$this->delMarcaID($id_marca);
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function delMarcaID($id) {
        $tabela = "marcas";
        $where = array ();
            $where["id"] = $id;
        
        $this->delete($tabela, $where);
        return null;    
    }
    
    public function addMarca($nome) {
        $tabela = "marcas";
        $dados = array ();
            $dados["nome"] = $nome;
        
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->array;
    }
    
    public function editMarca($id, $nome) {
        $tabela = "marcas";
        $dados = array ();
            $dados["nome"] = $nome;
        $where = array();
            $where["id"] = $id;
        
        $this->update($tabela, $dados, $where);
    }
    
    public function setID($id) {
        $this->id = $id;
    }
    public function getID() {
        return $this->id;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function getNome() {
        return $this->nome;
    }
}
