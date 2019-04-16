<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarios_token
 *
 * @author Daniel_Caldeira
 */
class UsuariosToken extends model{
    private $id;
    private $id_usuario;
    private $hash;
    private $usado;
    private $expirado_em;
    
    //put your code here
    
    private function incluirElementos($elementos = array()) {
        if (count($elementos) == 1){
            foreach ($elementos as $item) {
                $this->id = $item['id'];
                $this->nome = $item['nome'];
                $this->email = $item['email'];
                $this->senha = $item['senha'];
                $this->status = $item['status'];
                $this->telefone = $item['telefone'];
                $this->token = $item['token'];
            }
        }
    }
    
    public function atualizarUsuariosTokenUsado($hash, $usado){
        $tabela = "usuarios_token";
        $dados = array ();
            $dados["usado"] = $usado;
        //);
        $where = array ();
            $where["hash"] = $hash;
        //);
        $this->update($tabela, $dados, $where);
    }
    
    public function selecionarUsuariosTokenHash($hash) {
        $tabela = "usuarios_token";
        $colunas = array("id","id_usuario","hash","usado","expirado_em");
        $where = array();
            $where["hash"] = $hash;
            $where["usado"] = 0;
        //);
        $this->selecionarTabelas($tabela, $colunas, $where);
        if($this->numRows() > 0) { 
            $array = $this->result(); 
            $this->incluirElementos($array);
        } else { 
            $array = array();
        }
        return $array;
    }
    
    public function incluirUsuariosTokenHashExpirado($idUsuario, $hash, $expirado_em) {
        $tabela = "usuarios_token";
        $dados = array ();
            $dados["id_usuario"] = $idUsuario;
            $dados["hash"] = $hash;
            $dados["expirado_em"] = $expirado_em;
        //);
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->array;
    }
    
    public function setID($id) {
        $this->id = $id;
    } 
    public function getID() {
        return $this->id;
    }
    
    public function setIDUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
    public function getIDUsuario() {
        return $this->id_usuario;
    }
    
    public function setHash($hash) {
        $this->hash = $hash;
    }
    public function getHash() {
        return $this->hash;
    }
    
    public function setUsado($usado) {
        $this->usado = $usado;
    }
    public function getUsado() {
        return $this->usado;
    }
    
    public function setExpiradoEm($expirado_em) {
        $this->expirado_em = $expirado_em;
    }
    public function getExpiradoEm() {
        return $this->expirado_em;
    }
    
}
