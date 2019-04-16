<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cartController
 *
 * @author Daniel_Caldeira
 */
class cartController extends controller{
    
    private $user;
    
    public function __construct() {
        $this->user = array();
        if (isset($_SESSION['user'])){
            $this->user['nome'] = $_SESSION['user']['nome'];
            $this->user['email'] = $_SESSION['user']['email'];
            $this->user['senha'] =$_SESSION['user']['senha'];
            $this->user['telefone'] = $_SESSION['user']['telefone'];
        }
        parent::__construct();
    }
    
    public function index($error = '') {
        $filtros = new Filtros();
        $carrinho = new Carrinho();
        $cep = '';
        $frete = array();
        
        if (!empty($_POST['cep'])){
            $cep = intval($_POST['cep']);
            $frete = $carrinho->calcularRemessa($cep);
            $_SESSION['frete'] = $frete;
        } elseif (!empty($_SESSION['frete'])){
            $frete = $_SESSION['frete'];
        }
        $dados = $filtros->getTemplateDados();
        $dados['produtos'] = $carrinho->informarALLCompras();
        $dados['cep'] = $cep;
        $dados['frete'] = $frete;
        $dados['error'] = $error;
        $dados['sidebar'] = FALSE;
        
    //    echo("<pre>");
    //    print_r($dados);
    //    echo("</pre>");
        $this->loadTemplate('cart', $dados);
    }
    
    public function add() {
        if (!empty($_POST['id_prd'])){
        //    $id = intval($_POST['id_prd']);
        //    $qtd = intval($_POST['qtd_prd']);
        //    $preco = floatval($_POST['preco']);
        //    $imagens_value = $_POST['imagens_value'];
        //    $imagens_key = $_POST['imagens_key'];
        //    $nome = $_POST['nome_prd'];
            extract($_POST);
            $id = intval($id_prd);
            
            if (!isset($_SESSION['cart'])){
                $_SESSION['cart'] = array();
                $_SESSION['frete'] = array();
            }
        //    $subTotal = (intval($qtd_prd) * floatval($preco));
            $imagensValue = explode(',', $imagens_value);
            $imagensKey = explode(',', $imagens_key);
            foreach ($imagensKey as $key => $item) {
                $imagens[$item] = $imagensValue[$key];
            }
            
            $_SESSION['cart'][$id]['imagens'] = $imagens;
            $_SESSION['cart'][$id]['nome'] = $nome_prd;
            $_SESSION['cart'][$id]['qtd'] = intval($qtd_prd);
            $_SESSION['cart'][$id]['preco'] = floatval($preco);
        //    $_SESSION['cart'][$id]['subTotal'] = $subTotal;
            $_SESSION['cart'][$id]['subTotal'] = (intval($qtd_prd) * floatval($preco));
        }
        
        header("Location: ".BASE_URL."cart");
        exit();
    }
    
    public function decrementar($id) {
        if (!empty($id)){
            $qtd = intval($_SESSION['cart'][$id]['qtd']);
            $preco = floatval($_SESSION['cart'][$id]['preco']);
            $qtd--;
            if ($qtd < 1){
                $qtd++;
            }
            $subTotal = $qtd * $preco;
            $_SESSION['cart'][$id]['qtd'] = $qtd;
            $_SESSION['cart'][$id]['subTotal'] = $subTotal;
        }
        header("Location: ".BASE_URL."cart");
        exit();
    }
    
    public function incrementar($id) {
        if (!empty($id)){
            $qtd = intval($_SESSION['cart'][$id]['qtd']);
            $preco = floatval($_SESSION['cart'][$id]['preco']);
            $qtd++;
            $subTotal = $qtd * $preco;
            $_SESSION['cart'][$id]['qtd'] = $qtd;
            $_SESSION['cart'][$id]['subTotal'] = $subTotal;
        }
        header("Location: ".BASE_URL."cart");
        exit();
    }
    
    public function pagamento() {
        //foreach ($_SESSION['cart'] as $key => $cart) {
        //    $id = $key;
        //    $qtd = ($cart['qtd']);
        //    $preco = ($cart['preco']);
        //    $imagens_value = $cart['imagens'];
        //    $nome = $cart['nome'];
        //}
        
        if (!empty($_POST['tipo_pagamento'])){
            $tipoPagamento = $_POST['tipo_pagamento'];
            switch ($tipoPagamento) {
                case 'checkOutTransparente':
                    $_SESSION['frete']['opt'] = 'checkOutTransparente';
                    header("Location: ".BASE_URL."pagamento?opt=checkOutTransparente");
                    exit();
                    break;
                case 'mercadoPago':
                    $_SESSION['frete']['opt'] = 'mercadoPago';
                    header("Location: ".BASE_URL."pagamentoMP?opt=mercadoPago");
                    exit();
                    break;
                case 'boleto':
                    $_SESSION['frete']['opt'] = 'boleto';
                    header("Location: ".BASE_URL."pagamento/boleto");
                    exit();
                    break;
                default:
                    break;
            }
        }
    }
    
    public function del($id) {
        if (!empty($id)){
            unset($_SESSION['cart'][$id]);
        }
        header("Location: ".BASE_URL."cart");
        exit();
    }
    
    public static function excluirSession() {
        unset($_SESSION['cart']);
        unset($_SESSION['frete']);
        //header("Location: ".BASE_URL);
        //exit();
    }
}
