<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProdutosAvalia
 *
 * @author Daniel_Caldeira
 */
class ProdutosAvalia extends model{
    private $id;
    private $id_produto;
    private $id_user;
    private $data_voto;
    private $voto;
    private $comentario;
    //put your code here
    
    public function selecionarAllProdutosAvaliaJoinUsuariosIDProduto($id_produto) {
        $tabela = "produtos_avalia as prd_av INNER JOIN usuarios as user ON prd_av.id_user = user.id";
        $colunas = array("prd_av.id","prd_av.id_produto","prd_av.id_user","prd_av.data_voto","prd_av.voto","prd_av.comentario","user.nome as nomeUser");
        $where = array(
            "id_produto" => $id_produto
        );
        $where_cond = "AND";
        $groupBy = array("ORDER BY data_voto DESC");
        $this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBy);
        if ($this->numRows > 0){
            $array = $this->result();
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function selecionarProdutosAvaliaIDProduto($id_produto) {
        $tabela = "produtos_avalia";
        $colunas = array("id","id_produto","id_user","data_voto","voto","comentario");
        $where = array(
            "id_produto" => $id_produto
        );
        $where_cond = "AND";
        $groupBy = array("ORDER BY data_voto DESC");
        $this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBy);
        if ($this->numRows > 0){
            $array = $this->result();
        } else{
            $array = array();
        }
        return $array;
    }
    
    protected function selecionarALLProdutosAvalia($where = array()){
        $tabela = "produtos_avalia";
        $colunas = array("id","id_produto","id_user","data_voto","voto","comentario");
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
    
    public function selecionarProdutosAvaliaID($id) {
        $tabela = "produtos_avalia";
        $colunas = array("id","id_produto","id_user","data_voto","voto","comentario");
        $where = array(
            "id" => $id
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            foreach ($array as $item) {
                $this->id = $item['id'];
                $this->id_produto = $item['id_produto'];
                $this->id_user = $item['id_user'];
                $this->data_voto = $item['data_voto'];
                $this->voto = $item['voto'];
                $this->comentario = $item['comentario'];
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
    public function setIDProduto($idProduto) {
        $this->id_produto = $idProduto;
    }
    public function getIDProduto() {
        return $this->id_produto;
    }
    public function setIDUser($idUser) {
        $this->id_user = $idUser;
    }
    public function getIDUser() {
        return $this->id_user;
    }
    public function setDataVoto($dataVoto) {
        $this->data_voto = $dataVoto;
    }
    public function getDataVoto() {
        return $this->data_voto;
    }
    public function setVoto($voto) {
        $this->voto = $voto;
    }
    public function getVoto() {
        return $this->voto;
    }
    public function setComentario($comentario) {
        $this->comentario = $comentario;
    }
    public function getComentario() {
        return $this->comentario;
    }
    
}
