<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PagSeguro
 *
 * @author Daniel_Caldeira
 */
class PagSeguro extends model{
    private $nome;
    private $email;
    
    public static function getEmail() {
        $this->email;
    }
    public static function getNome() {
        $this->nome;
    }
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
    
    public static function verificarEmail($email, $senha) {
        $user = new Usuarios();
        
        $exiteEmail = $user->selecionarUsuariosEmail($email);
        if (count($exiteEmail) > 0){
            $usuarios = $user->selecionarUsuariosEmailSenha($email, md5($senha));
            if (count($usuarios) > 0){
                $uid = $user->getID();
                $this->nome = $user->getNome();
                $this->email = $user->getEmail();
            } else {
                $array = array(
                    'error' => true,
                    'msg' => 'E-mail ou Senha não confere'
                );
                echo json_encode($array);
                exit();
            }
        } else {
            $uid = 0;
    //        $user->setNome($nome);
    //        $user->setEmail($email);
    //        $user->setSenha($senha);
    //        $user->setTelefone($telefone);
    //        $uid = $user->incluirUsuariosNomeEmailSenha();
        }
        return $uid;
    }
    
    public static function criarSesssao() {
        $credentials = PagSeguro\Configuration\Configure::getAccountCredentials();
        try {
            $sessionCode = PagSeguro\Services\Session::create($credentials);
            $valor = $sessionCode->getResult();
        } catch (Exception $exc) {
            echo $exc->getMessage();
            echo ("<br/>");
            echo $exc->getTraceAsString();
            exit();
        }
        return $valor;
    }
    
    public static function encaminharPagSeguroCredicard($idCompra, $cart, $valorFrete, $cartaoPag, $cartaoEnd) {
        $array = array();
        global $config;
        $credentials = PagSeguro\Configuration\Configure::getAccountCredentials();
        $credicard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        
        $currency = $cartaoPag['currency'];
        $name = $cartaoPag['name'];
        $email = $cartaoPag['email'];
        $cpf = $cartaoPag['cpf'];
        $telefone = $cartaoPag['telefone'];
        $id = $cartaoPag['id'];
        $parc = $cartaoPag['parc'];
        $cartao_token = $cartaoPag['cartao_token'];
        $cartao_titular = $cartaoPag['cartao_titular'];
        $cartao_cpf = $cartaoPag['cartao_cpf'];
        $mode = $cartaoPag['mode'];
        
        $rua = $cartaoEnd['rua'];
        $numero = $cartaoEnd['numero'];
        $bairro = $cartaoEnd['bairro'];
        $cep = $cartaoEnd['cep'];
        $cidade = $cartaoEnd['cidade'];
        $estado = $cartaoEnd['estado'];
        $pais = $cartaoEnd['pais'];
        $complemento = $cartaoEnd['complemento'];
        
        $credicard->setReceiverEmail($config['pagseguro_email']);
        $credicard->setReference($idCompra);
        $credicard->setCurrency($currency);
        $credicard->setToken($cartao_token);
        
        foreach ($cart as $key => $item) {
            $credicard->addItems()->withParameters($key, $item['nome'], intval($item['qtd']), floatval($item['preco']) );
        }
        
        //$credicard->setExtraAmount($valorFrete);
        $credicard->setSender()->setName($name);
        $credicard->setSender()->setEmail($email);
        $credicard->setSender()->setDocument()->withParameters('CPF', $cpf);
        $ddd = substr($telefone, 0,2);
        $tel = substr($telefone, 2);
        $credicard->setSender()->setPhone()->withParameters($ddd, $tel);
        $credicard->setSender()->setHash($id);
        
        $ip = $_SERVER['REMOTE_ADDR'];
        if(strlen($ip) < 9) {
            $ip = '127.0.0.1';
        }
        //echo ($ip);
        $credicard->setSender()->setIp($ip);
        
        $credicard->setShipping()->setAddress()->withParameters($rua, $numero, $bairro, $cep, $cidade, $estado, 'BRA', $complemento);
        $credicard->setShipping()->setCost()->withParameters($valorFrete);
        $credicard->setBilling()->setAddress()->withParameters($rua, $numero, $bairro, $cep, $cidade, $estado, 'BRA', $complemento);
        //print_r($parc);
        $quantity = intval($parc[0]);
        $value = ($parc[1]);
        //$noInterest = $parc[2];
        $credicard->setInstallment()->withParameters($quantity, $value);
        
        $credicard->setHolder()->setName($cartao_titular);
        $credicard->setHolder()->setDocument()->withParameters('CPF', $cartao_cpf);
        
        $credicard->setMode($mode);
        
        $credicard->setNotificationUrl(BASE_URL.'pagamento/notification');
        
        try {
            $result = $credicard->register($credentials);
            $array['date'] = $result->getDate();
            $array['code'] = $result->getCode();
            $array['reference'] = $result->getReference();
            $array['type'] = $result->getType();
            $array['status'] = $result->getStatus();
            $array['lastEventDate'] = $result->getLastEventDate();
            $array['installmentCount'] = $result->getInstallmentCount();
            $array['cancelationSource'] = $result->getCancelationSource();
            
            Compras::atualizarComprasCodeTransaction($idCompra, $array['code']);
            echo ( json_encode($result) );
            //print_r($result);
            exit();
        } catch (Exception $exc) {
            echo (json_encode(array('error'=>true,'msg'=>$exc->getMessage() ) ) );
            echo $exc->getTraceAsString();
            exit();
        }
    }
    
    public static function encaminharPagSeguroBoleto($idCompra, $cart, $valorFrete, $cartaoPag, $cartaoEnd) {
        global $config;
        $credentials = PagSeguro\Configuration\Configure::getAccountCredentials();
        $boleto = new \PagSeguro\Domains\Requests\DirectPayment\Boleto();
        
        $currency = $cartaoPag['currency'];
        $name = $cartaoPag['name'];
        $email = $cartaoPag['email'];
        $cpf = $cartaoPag['cpf'];
        $telefone = $cartaoPag['telefone'];
        $id = $cartaoPag['id'];
        $parc = $cartaoPag['parc'];
        $cartao_token = $cartaoPag['cartao_token'];
        $cartao_titular = $cartaoPag['cartao_titular'];
        $cartao_cpf = $cartaoPag['cartao_cpf'];
        $mode = $cartaoPag['mode'];
        
        $rua = $cartaoEnd['rua'];
        $numero = $cartaoEnd['numero'];
        $bairro = $cartaoEnd['bairro'];
        $cep = $cartaoEnd['cep'];
        $cidade = $cartaoEnd['cidade'];
        $estado = $cartaoEnd['estado'];
        $pais = $cartaoEnd['pais'];
        $complemento = $cartaoEnd['complemento'];
        
        $boleto->setCurrency($currency);
        $boleto->setReceiverEmail($config['pagseguro_email']);
        $boleto->setReference($idCompra);
        
        $boleto->setSender()->setName($name);
        $boleto->setSender()->setEmail($email);
        $boleto->setSender()->setDocument()->withParameters('CPF', $cpf);
        $ddd = substr($telefone, 0,2);
        $tel = substr($telefone, 2);
        $boleto->setSender()->setPhone()->withParameters($ddd, $tel);
        $boleto->setSender()->setHash($id);
        $ip = $_SERVER['REMOTE_ADDR'];
        if(strlen($ip) < 9) {
            $ip = '127.0.0.1';
        }
        $boleto->setSender()->setIp($ip);
        
        foreach ($cart as $key => $item) {
            $boleto->addItems()->withParameters($key, $item['nome'], intval($item['qtd']), floatval($item['preco']) );
        }
        
        $boleto->setShipping()->setAddress()->withParameters($rua, $numero, $bairro, $cep, $cidade, $estado, 'BRA', $complemento);
        $boleto->setShipping()->setCost()->withParameters($valorFrete);
        
        $boleto->setMode($mode);
        $boleto->setRedirectUrl($urlRedirect);
        $boleto->setNotificationUrl($urlNotification);
        
        try {
            $result = $boleto->register($credentials);
            $array['date'] = $result->getDate();
            $array['code'] = $result->getCode();
            $array['reference'] = $result->getReference();
            $array['type'] = $result->getType();
            $array['status'] = $result->getStatus();
            $array['lastEventDate'] = $result->getLastEventDate();
            $array['installmentCount'] = $result->getInstallmentCount();
            $array['cancelationSource'] = $result->getCancelationSource();
            
            Compras::atualizarComprasCodeTransaction($idCompra, $array['code']);
            echo ( json_encode($result) );
            //print_r($result);
            exit();
        } catch (Exception $exc) {
            echo (json_encode(array('error'=>true,'msg'=>$exc->getMessage() ) ) );
            echo $exc->getTraceAsString();
            exit();
        }
        
    }
}
