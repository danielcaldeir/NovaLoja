<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Compras
 *
 * @author Daniel_Caldeira
 */
class Compras extends model{
    private $id;
    private $id_user;
    private $id_desconto;
    private $valor_total;
    private $tipo_pagamento;
    private $status_pagamento;
    //put your code here
    
    public function incluirCompras($uid, $total, $tipoPagamento) {
        $tabela = 'compras';
        $dados = array(
            'id_user' => $uid,
            'id_desconto' => 0,
            'valor_total' => $total,
            'tipo_pagamento' => $tipoPagamento,
            'status_pagamento' => 1
        );
        $this->insert($tabela, $dados);
        $this->query("SELECT LAST_INSERT_ID() as ID");
        return $this->result();
    }
    
    public static function atualizarComprasCodeTransaction($idCompra, $code, $link = null){
        $tabela = "compras";
        $dados = array (
            "code_transaction" => $code,
            "link_pagamento" => $link
        );
        $where = array (
            "id" => $idCompra
        );
        $model = new model();
        $model->update($tabela, $dados, $where);
    }
    
    public function atualizarComprasStatusPagamento($idCompra, $status){
        $tabela = "compras";
        $dados = array (
            "status_pagamento" => $status
        );
        $where = array (
            "id" => $idCompra
        );
        $this->update($tabela, $dados, $where);
    }
    
    public function selecionarComprasID($id) {
        $tabela = "compras";
        $colunas = array ("id","id_user","id_desconto","valor_total","tipo_pagamento","status_pagamento");
        $where = array(
            "id" => $id
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $array = $this->result();
            foreach ($array as $item) {
                $this->id = $item['id'];
                $this->id_user = $item['id_user'];
                $this->id_desconto = $item['id_desconto'];
                $this->valor_total = $item['valor_total'];
                $this->tipo_pagamento = $item['tipo_pagamento'];
                $this->status_pagamento = $item['status_pagamento'];
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
    public function setIDUser($idUser) {
        $this->id_user = $idUser;
    }
    public function getIDUser() {
        return $this->id_user;
    }
    public function setIDDesconto($idDesconto) {
        $this->id_desconto = $idDesconto;
    }
    public function getIDDesconto() {
        return $this->id_desconto;
    }
    public function setValoTotal($valorTotal) {
        $this->valor_total = $valorTotal;
    }
    public function getValorTotal() {
        return $this->valor_total;
    }
    public function setTipoPagamento($tipoPagamento) {
        $this->tipo_pagamento = $tipoPagamento;
    }
    public function getTipoPagamento() {
        return $this->tipo_pagamento;
    }
    public function setStatusPagamento($statusPagamento) {
        $this->status_pagamento = $statusPagamento;
    }
    public function getStatusPagamento() {
        return $this->status_pagamento;
    }
}
