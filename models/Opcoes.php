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
    
    private function incluirElementos($elementos = array()) {
        if (count($elementos) == 1){
            foreach ($elementos as $item) {
                $this->setID($item['id']);
                $this->setNome($item['nome']);
            }
        }
    }
    //put your code here
    
    public function selecionarALLOpcoes($where = array()){
        $tabela = "opcoes";
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
    
    public function getALLOpcoesProdutos() {
        $tabela = "opcoes LEFT JOIN (SELECT id_opcao, count(id_opcao) as total_opcao from produtos_opcoes GROUP BY id_opcao) as prd ON prd.id_opcao = opcoes.id";
        $colunas = array("opcoes.id","opcoes.nome", "prd.total_opcao");
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
    
    public function selecionarOpcoesID($id) {
        $tabela = "opcoes";
        $colunas = array("id","nome");
        $where = array(
            "id" => $id
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            $this->incluirElementos($array);
        //    foreach ($array as $item) {
        //        $this->id = $item['id'];
        //        $this->nome = $item['nome'];
        //    }
        } else{
            $array = array();
        }
        return $array;
    }
    
    public function validarDelOpcao($id_opcao) {
        $produtoOpcoes = new ProdutosOpcoes();
        $prdOpcoes = $produtoOpcoes->selecionarProdutosOpcoesIDOpcao($id_opcao);
        
        if (count($prdOpcoes) === 0){
            //$this->delMarcaID($id_marca);
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    public function delOpcoesID($id) {
        $tabela = "opcoes";
        $where = array ();
            $where["id"] = $id;
        
        $this->delete($tabela, $where);
        return null;    
    }
    
    public function addOpcoes($nome) {
        $tabela = "opcoes";
        $dados = array ();
            $dados["nome"] = $nome;
        
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->array;
    }
    
    public function editOpcoes($id, $nome) {
        $tabela = "opcoes";
        $dados = array ();
            $dados["nome"] = $nome;
        $where = array();
            $where["id"] = $id;
        
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
