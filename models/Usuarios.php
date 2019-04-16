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
    private $id_grupo;
    private $nome;
    private $email;
    private $senha;
    private $status;
    private $telefone;
    private $token;
    private $permissoes;
    
    private function incluirElementos($elementos = array()) {
        if (count($elementos) == 1){
            foreach ($elementos as $item) {
                $this->id = $item['id'];
                $this->id_grupo = $item['id_grupo'];
                $this->nome = $item['nome'];
                $this->email = $item['email'];
                $this->senha = $item['senha'];
                $this->status = $item['status'];
                $this->telefone = $item['telefone'];
                $this->token = $item['token'];
            }
        }
    }
    
    public function selecionarUsuariosEmailSenha($email, $senha){
        $colunas = array ("id", "id_grupo", "nome", "email", "senha", "status", "telefone", "token");
        $tabela = "usuarios";
        $where = array();
            $where['email'] = $email;
            $where['senha'] = $senha;
        
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            if ($this->numRows == 1){
                $array = $this->result();
                $this->incluirElementos($array);
            //    foreach ($array as $item) {
            //        $this->id = $item['id'];
            //        $this->nome = $item['nome'];
            //        $this->email = $item['email'];
            //        $this->senha = $item['senha'];
            //        $this->status = $item['status'];
            //        $this->telefone = $item['telefone'];
            //    }
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
        $colunas = array ("id", "id_grupo", "nome", "email", "senha", "status", "telefone", "token");
        $where = array();
            $where['email'] = $email;
        
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            $this->incluirElementos($array);
            //if ($this->numRows == 1){
            //    $this->incluirElementos($array);
            //}
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function selecionarUsuariosID($id){
        $tabela = "usuarios";
        $colunas = array ("id", "id_grupo", "nome", "email", "senha", "status", "telefone", "token");
        $where = array();
            $where['id'] = $id;
        
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            $this->incluirElementos($array);
        //    foreach ($array as $item) {
        //        $this->id = $item['id'];
        //        $this->nome = $item['nome'];
        //        $this->email = $item['email'];
        //        $this->senha = $item['senha'];
        //        $this->status = $item['status'];
        //        $this->telefone = $item['telefone'];
        //    }
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function incluirUsuariosNomeEmailSenha(){
        $tabela = "usuarios";
        $dados = array();
            $dados["id_grupo"] = $this->id_grupo;
            $dados["nome"] = $this->nome;
            $dados["email"] = $this->email;
            $dados["senha"] = md5($this->senha);
            $dados["status"] = 0;
            $dados["telefone"] = $this->telefone;
        
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->result();
    }
    
    public function validarPermissao($permissao_slug) {
        //print_r($permissao_slug);
        //echo ("<br>");
        //print_r($this->permissoes);
        if (in_array($permissao_slug, $this->permissoes)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    private function getPermissaoIDGrupo($id_grupo) {
        $permissao = new Permissao();
        $pItem = new PermissaoItem();
        $slugs = array();
        
        $arrPermissao = $permissao->selecionarPermissaoIDGrupo($id_grupo);
        foreach ($arrPermissao as $item) {
            $pItem->selecionarPermissaoItemID($item['id_item']);
            $slugs[] = $pItem->getSlug();
        }
        $this->setPermissoes($slugs);
    }
    
    public function isLogado($token) {
        $tabela = "usuarios";
        $colunas = array ("id", "id_grupo", "nome", "email", "senha", "status", "telefone", "token");
        $where = array();
            $where['token'] = $token;
        
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            $this->incluirElementos($array);
            $this->getPermissaoIDGrupo($this->getIDGrupo());
            
            return TRUE;
        } else{
            return FALSE;
        }
    }
    
    public function atualizarUsuariosToken($idUsuario, $token) {
        $tabela = "usuarios";
        $dados = array ();
            $dados["token"] = $token;
        //);
        $where = array ();
            $where["id"] = $idUsuario;
        //);
        $this->update($tabela, $dados, $where);
    }

    public function validatePermissaoGrupo($id_grupo) {
        $tabela = "usuarios";
        $colunas = array ("id", "id_grupo", "nome", "email", "senha", "status", "telefone", "token");
        $where = array();
            $where['id_grupo'] = $id_grupo;
        
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows === 0){
            return TRUE;
        } else{
            return FALSE;
        }
    }
    
    public function validateLogin($email, $senha) {
        $this->selecionarUsuariosEmailSenha($email, $senha);
        if ($this->numRows == 1){
            if ($this->getStatus() == 2){
                $token = md5(time(). rand(0, 999).$this->id);
                $this->setToken($token);
                $this->atualizarUsuariosToken($this->id, $token);
                
                //$tabela = "usuarios";
                //$dados = array();
                //    $dados["token"] = $token;
                //$where = array();
                //    $where["id"] = $this->id;
                //$this->update($tabela, $dados, $where);
                
                return TRUE;
            }
            if ($this->getStatus() == 1){
                $this->setToken(FALSE);
                return TRUE;
            }
            return FALSE;
        } else{
            return FALSE;
        }
    }
    
    public function atualizarUsuariosSenha($idUsuario, $senha){
        $tabela = "usuarios";
        $dados = array ();
            $dados["senha"] = md5($senha);
        //);
        $where = array ();
            $where["id"] = $idUsuario;
        //);
        $this->update($tabela, $dados, $where);
    }
    
    public function atualizarUsuariosNomeEmailSenha($idUsuario, $nome, $email, $senha, $telefone){
        $tabela = "usuarios";
        $dados = array ();
            $dados["nome"] = $nome;
            $dados["email"] = $email;
            $dados["senha"] = md5($senha);
            $dados["telefone"] = $telefone;
        //);
        $where = array ();
            $where["id"] = $idUsuario;
        //);
        $this->update($tabela, $dados, $where);
    }
    
    public function selecionarALLUsuarios($where = array()){
        $tabela = "usuarios";
        $colunas = array ("id", "id_grupo", "nome", "email", "senha", "status", "telefone", "token");
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
    
    public function setIDGrupo($id_grupo) {
        $this->id_grupo = $id_grupo;
    }
    public function getIDGrupo() {
        return $this->id_grupo;
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
    
    public function setToken($token) {
        $this->token = $token;
    }
    public function getToken() {
        return $this->token;
    }
    
    public function setPermissoes($permissoes) {
        $this->permissoes = $permissoes;
    }
    public function getPermissoes() {
        return $this->permissoes;
    }
}
