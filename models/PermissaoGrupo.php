<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PermissaoGrupo
 *
 * @author Daniel_Caldeira
 */
class PermissaoGrupo extends model{
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
    public function selecionarALLPermissaoGrupo($where = array()){
        $tabela = "permissao_grupo";
        $colunas = array("id","nome");
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
    
    public function delPermissaoGrupoID($id) {
        $tabela = "permissao_grupo";
        $where = array ();
            $where["id"] = $id;
        $this->delete($tabela, $where);
        return null;    
    }
    
    public function selecionarPermissaoGrupoID($id) {
        $tabela = "permissao_grupo";
        $colunas = array("id","nome");
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
    
    public function getAllPermissaoGrupo() {
        $tabela = "permissao_grupo as grupo LEFT JOIN (SELECT id_grupo, count(id) as total_user FROM usuarios group by id_grupo) as user ON user.id_grupo = grupo.id";
        $colunas = array("id","nome","user.total_user");
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
    
    public function addPermissaoGrupo($nome) {
        $tabela = "permissao_grupo";
        $dados = array ();
            $dados["nome"] = $nome;
        
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->result();
    }
    
    public function editPermissaoGrupo($id_grupo, $nome) {
        $tabela = "permissao_grupo";
        $dados = array ();
            $dados["nome"] = $nome;
        $where = array();
            $where["id"] = $id_grupo;
        
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
