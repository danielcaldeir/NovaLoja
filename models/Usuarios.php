<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuario
 *
 * @author Daniel_Caldeira
 */
class Usuarios extends model{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $status;
    private $telefone;
    
    public function selecionarUsuariosEmailSenha($email, $senha){
        $colunas = array ("id", "nome", "email", "senha", "status", "telefone");
        $tabela = "usuarios";
        $where = array(
            "email" => $email,
            "senha" => $senha
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            if ($this->numRows == 1){
                $array = $this->result();
                foreach ($array as $item) {
                    $this->id = $item['id'];
                    $this->nome = $item['nome'];
                    $this->email = $item['email'];
                    $this->senha = $item['senha'];
                    $this->status = $item['status'];
                    $this->telefone = $item['telefone'];
                }
            } else {
                $array = $this->result();
            }
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function selecionarUsuariosEmail($email){
        $tabela = "usuarios";
        $colunas = array ("id", "nome", "email", "senha", "status", "telefone");
        $where = array(
            "email" => $email
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function selecionarUsuariosID($id){
        $tabela = "usuarios";
        $colunas = array ("id", "nome", "email", "senha", "status", "telefone");
        $where = array(
            "id" => $id
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            foreach ($array as $item) {
                $this->id = $item['id'];
                $this->nome = $item['nome'];
                $this->email = $item['email'];
                $this->senha = $item['senha'];
                $this->status = $item['status'];
                $this->telefone = $item['telefone'];
            }
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function incluirUsuariosNomeEmailSenha(){
        $tabela = "usuarios";
        $dados = array (
            "nome" => $this->nome,
            "email" => $this->email,
            "senha" => md5($this->senha),
            "status" => 0,
            "telefone" => $this->telefone
        );
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->result();
    }
    
    public function atualizarUsuariosSenha($idUsuario){
        $tabela = "usuarios";
        $dados = array (
            "senha" => md5($this->senha)
        );
        $where = array (
            "id" => $this->id
        );
        $this->update($tabela, $dados, $where);
    }
    
    public function atualizarUsuariosNomeEmailSenha($idUsuario){
        $tabela = "usuarios";
        $dados = array (
            "nome" => $this->nome,
            "email" => $this->email,
            "senha" => md5($this->senha),
            "telefone" => $this->telefone
        );
        $where = array (
            "id" => $this->id
        );
        $this->update($tabela, $dados, $where);
    }
    
    public function selecionarALLUsuarios($where = array()){
        $tabela = "usuarios";
        $colunas = array ("id", "nome", "email", "senha", "status", "telefone");
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
    
    public function atualizarUsuariosConfirmarEmail($idUsuario) {
        $tabela = "usuarios";
        $dados = array(
            "status" => '1'
        );
        $where = array(
            "md5(id)" => $this->id
        );
        return $this->update($tabela, $dados, $where);
    }
    
    //put your code here
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
    
    public function setEmail($email) {
        $this->email = $email;
    }
    public function getEmail() {
        return $this->email;
    }
    
    public function setSenha($senha) {
        $this->senha = $senha;
    }
    public function getSenha() {
        return $this->senha;
    }
    
    public function setStatus($status) {
        $this->status = $status;
    }
    public function getStatus() {
        return $this->status;
    }
    
    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }
    public function getTelefone() {
        return $this->telefone;
    }
}
