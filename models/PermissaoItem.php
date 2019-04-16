<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permissao
 *
 * @author Daniel_Caldeira
 */
class PermissaoItem extends model{
    private $id;
    private $nome;
    private $slug;
    //put your code here
    private function incluirElementos($elementos = array()) {
        if (count($elementos) == 1){
            foreach ($elementos as $item) {
                $this->setID($item['id']);
                $this->setNome($item['nome']);
                $this->setSlug($item['slug']);
            }
        }
    }
    
    public function selecionarALLPermissaoItem($where = array()){
        $tabela = "permissao_item";
        $colunas = array("id","nome","slug");
        //$where_cond = "AND";
        //$groupBy = array();
        //$this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBy);
        $this->selecionarTabelas($tabela, $colunas, $where);
        if($this->numRows() > 0){
            $array = $this->result();
            $this->incluirElementos($array);
        } else {
            $array = array();
        }
        return $array;
    }
    
    public function selecionarPermissaoItemID($id) {
        $tabela = "permissao_item";
        $colunas = array("id","nome","slug");
        $where = array();
            $where["id"] = $id;
        //);
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            $this->incluirElementos($array);
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function selecionarPermissaoItemIDGrupo($id_grupo) {
        $tabela = "permissao_item";
        $colunas = array("id","nome","slug");
        $where = array();
            $where["id_grupo"] = $id_grupo;
        //);
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            $this->incluirElementos($array);
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function addPermissaoItem($nome, $slug) {
        $tabela = "permissao_item";
        $dados = array ();
            $dados["nome"] = $nome;
            $dados["slug"] = $slug;
        
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->result();
    }
    
    public function getPermissaoItemIDGrupo($id_grupo,$permitido = 1) {
        $tabela = "permissao_item";
        $colunas = array("id","nome","slug");
        $where = array();
            $where["id_grupo"] = $id_grupo;
            $where["permitido"] = $permitido;
        //);
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            $this->incluirElementos($array);
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
    
    public function setSlug($slug) {
        $this->slug = $slug;
    }
    public function getSlug() {
        return $this->slug;
    }
}
