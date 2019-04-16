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
class Permissao extends model{
    private $id;
    private $id_grupo;
    private $id_item;
    private $permitido;
    
    //put your code here
    private function incluirElementos($elementos = array()) {
        if (count($elementos) == 1){
            foreach ($elementos as $item) {
                $this->setID($item['id']);
                $this->setIDGrupo($item['id_grupo']);
                $this->setIDItem($item['id_item']);
                $this->setPermitido($item['permitido']);
            }
        }
    }
    
    public function validarDelPermissao($id_grupo) {
        $user = new Usuarios();
        $permissaoGrupo = new PermissaoGrupo();
        if ($user->validatePermissaoGrupo($id_grupo)){
            $this->delPermissaoIDGrupo($id_grupo);
            $permissaoGrupo->delPermissaoGrupoID($id_grupo);
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function selecionarALLPermissao($where = array()){
        $tabela = "permissao";
        $colunas = array("id","id_grupo","id_item","permitido");
        //$where_cond = "AND";
        //$groupBy = array("group by user.id_grupo");
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
    
    public function selecionarPermissaoID($id) {
        $tabela = "permissao";
        $colunas = array("id","id_grupo","id_item","permitido");
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
    
    public function selecionarPermissaoIDGrupo($id_grupo, $permitido = 1) {
        $tabela = "permissao";
        $colunas = array("id","id_grupo","id_item","permitido");
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
    
    public function getPermissaoIDGrupo($id_grupo,$permitido = 1) {
        $this->selecionarPermissaoIDGrupo($id_grupo, $permitido);
        
        $pItem = new PermissaoItem();
        $this->permissoes = array();
            foreach ($this->result() as $item) {
                $pItem->selecionarPermissaoItemID($item['id_item']);
                $this->permissoes[] = $pItem->getSlug();
            }
        return $this->permissoes;
    }
    
    public function getAllPermissaoGrupo() {
        $per = new PermissaoGrupo();
        $per->getAllPermissaoGrupo();
        
        $array = array();
        foreach ($per->result() as $item) {
            if (is_null($item['total_user'])){
                $item['total_user'] = 0;
                $array[] = $item;
            } else {
                $array[] = $item;
            }
        }
        return $array;
    }
    
    public function delPermissaoIDGrupo($id_grupo) {
        $tabela = "permissao";
        $where = array ();
            $where["id_grupo"] = $id_grupo;
        $this->delete($tabela, $where);
        return null;    
    }
    
    public function addPermissao($id_grupo, $id_item, $permitido) {
        $tabela = "permissao";
        $dados = array ();
            $dados["id_grupo"] = $id_grupo;
            $dados["id_item"] = $id_item;
            $dados["permitido"] = $permitido;
        
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->array;
    }
    
    public function editPermissao($id_grupo, $id_item, $permitido) {
        $tabela = "permissao";
        $dados = array ();
            $dados["permitido"] = $permitido;
        $where = array();
            $where["id_grupo"] = $id_grupo;
            $where["id_item"] = $id_item;
        
        $this->update($tabela, $dados, $where);
    }
    
    public function setID($id) {
        $this->id = $id;
    } 
    public function getID() {
        return $this->id;
    }
    
    public function setIDGrupo($id_grupo) {
        $this->id_grupo = $id_grupo;
    }
    public function getIDGrupo() {
        return $this->id_grupo;
    }
    
    public function setIDItem($id_item) {
        $this->id_item = $id_item;
    }
    public function getIDItem() {
        return $this->id_item;
    }
    
    public function setPermitido($permitido) {
        $this->permitido = $permitido;
    }
    public function getPermitido() {
        return $this->permitido;
    }
    
    
}
