<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GerenciaNet
 *
 * @author Daniel_Caldeira
 */
class GerenciaNet {
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
    
    public function encaminharGerenciaNet($sessionCart, $idCompra, $valorFrete, $cep, $rua, $numero, $complemento) {
        global $config;
        $mp = new MP($config['mpID'],$config['mpSecretKEY']);
        
        $data = array(
            'items' => array(),
            'shipments' => array(),
            'back_urls' => array(),
            'notification_url' => BASE_URL.'pagamentoMP/notification',
            'auto_return' => 'all',
            'external_reference' => $idCompra
        );
        $data['shipments']['mode'] = "custom";
        $data['shipments']['cost'] = $valorFrete;
        $data['shipments']['receiver_address'] = array();
        $data['shipments']['receiver_address']['zip_code'] = $cep;
        $data['shipments']['receiver_address']['street_number'] = $numero;
        $data['shipments']['receiver_address']['street_name'] = $rua;
        $data['shipments']['receiver_address']['floor'] = $complemento;
        $data['back_urls']['success'] = BASE_URL.'pagamentoMP/obrigadoSuccess';
        $data['back_urls']['pending'] = BASE_URL.'pagamentoMP/obrigadoPending';
        $data['back_urls']['failure'] = BASE_URL.'pagamentoMP/obrigadoFailure';
        
        foreach ($_SESSION['cart'] as $item) {
            $data['items'][] = array(
                'title' => $item['nome'],
                'quantity' => intval($item['qtd']),
                'currency_id' => 'BRL',
                'unit_price' => floatval($item['preco'])
            );
        }
        $link = $mp->create_preference($data);
        
        echo ("<pre>");
        print_r($link);
        echo ("</pre>");
        exit();
    }
}
