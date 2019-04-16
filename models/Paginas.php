<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Paginas
 *
 * @author Daniel_Caldeira
 */
class Paginas extends model{
    private $id;
    private $titulo;
    private $conteudo;
    //put your code here
    private function incluirElementos($elementos = array()) {
        if (count($elementos) == 1){
            foreach ($elementos as $item) {
                $this->id = $item['id'];
                $this->titulo = $item['titulo'];
                $this->conteudo = $item['conteudo'];
            }
        }
    }
    
    public function selecionarALLPaginas() {
        $tabela = "paginas";
        $colunas = array("id","titulo","conteudo");
        $where = array();
        $this->selecionarTabelas($tabela, $colunas, $where);
        return $this->result();
    }
    
    public function selecionarPaginasID($id) {
        $tabela = "paginas";
        $colunas = array("id","titulo","conteudo");
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
    
    public function selecionarPaginasTitulo($titulo) {
        $tabela = "paginas";
        $colunas = array("id","titulo","conteudo");
        $where = array(
            "titulo" => $titulo
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
    
    public function addPagina($titulo, $conteudo) {
        $tabela = "paginas";
        $dados = array ();
            $dados["titulo"] = $titulo;
            $dados["conteudo"] = $conteudo;
        
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->result();
    }
    
    public function editPagina($id, $titulo, $conteudo) {
        $tabela = "paginas";
        $dados = array ();
            $dados["titulo"] = $titulo;
            $dados["conteudo"] = $conteudo;
        $where = array();
            $where["id"] = $id;
        
        $this->update($tabela, $dados, $where);
    }
    
    public function delPaginaID($id) {
        $tabela = "paginas";
        $where = array ();
            $where["id"] = $id;
        
        $this->delete($tabela, $where);
        return null;    
    }
    
    public function setID($id) {
        $this->id = $id;
    }
    public function getID() {
        return $this->id;
    }
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    public function getTitulo() {
        return $this->titulo;
    }
    public function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }
    public function getConteudo() {
        return $this->conteudo;
    }
}
