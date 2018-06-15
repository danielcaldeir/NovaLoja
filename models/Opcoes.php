<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opcoes
 *
 * @author Daniel_Caldeira
 */
class Opcoes extends model{
    private $id;
    private $nome;
    //put your code here
    
    protected function selecionarALLOpcoes($where = array()){
        $tabela = "produtos_opcoes";
        $colunas = array("id","nome");
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
    
    public function selecionarOpcoesID($id) {
        $tabela = "opcoes";
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
