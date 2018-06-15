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
    //put your code here
    public function selecionarALLMarcas() {
        $tabela = "marcas";
        $colunas = array("id","nome");
        $where = array();
        $this->selecionarTabelas($tabela, $colunas, $where);
        return $this->result();
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
            foreach ($array as $item) {
                $this->id = $item['id'];
                $this->nome = $item['nome'];
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
    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function getNome() {
        return $this->nome;
    }
}
