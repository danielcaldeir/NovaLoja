<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MercadoPago
 *
 * @author Daniel_Caldeira
 */
class MercadoPago {
    private $nome;
    private $email;
    private $dados;
    
    //put your code here
    public static function incluirCompras($sessionCart, $sessionFrete, $uid, $total) {
        $comprasProduto = new ComprasProduto();
        $compras = new Compras();
        
        $compraNext = $compras->incluirCompras($uid, $total, $sessionFrete['opt']);
        foreach ($compraNext as $item) {
            $idCompra = $item['ID'];
        }
        
        foreach ($sessionCart as $key => $item) {
            $comprasProduto->inserirComprasProduto($idCompra, $key, $item['qtd'], $item['preco']);
        }
        return $idCompra;
    }
    
    public static function verificarEmail($email) {
        $user = new Usuarios();
        
        $usuarios = $user->selecionarUsuariosEmail($email);
        if (count($usuarios) > 0){
            if (count($usuarios) == 1){
                foreach ($usuarios as $item) {
                    $uid = $item['id'];
                }
            } else {
                //$array = array();
                //$array['error'] = TRUE;
                //$array['msg'] = 'E-mail ou Senha não confere';
                //$this->dados = $array;
                $uid = -1;
            }
        } else {
            //$array = array();
            //$array['error'] = TRUE;
            //$array['msg'] = 'Usuario não Cadastrado';
            //$this->dados = $array;
            $uid = -2;
        }
        return $uid;
    }
}
