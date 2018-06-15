<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pagamentoController
 *
 * @author Daniel_Caldeira
 */
class pagamentoController extends controller{
    //put your code here
    private $user;
    private $credentials;
    private $config;
    
    public function __construct() {
        $credentials = PagSeguro\Configuration\Configure::getAccountCredentials();
        $this->credentials = $credentials;
        $this->user = array();
        if (isset($_SESSION['user'])){
            $this->user['nome'] = $_SESSION['user']['nome'];
            $this->user['email'] = $_SESSION['user']['email'];
        }
        if (count($this->user) == 0){
            $login = new loginController();
            $login->index();
        }
        //global $config;
        //$this->config = $config;
        parent::__construct();
    }
    
    private function buscarTotalCarrinho($sessionCart, $sessionFrete) {
        $total = 0;
        foreach ($sessionCart as $produto_item) {
            $total += ( intval($produto_item['qtd']) * floatval($produto_item['preco']) );
        }
        $frete = $this->isEmptyFrete($sessionFrete);
        $valorFrete = $this->isValorFrete($frete);
        $total += $valorFrete;
        return $total;
    }
    
    private function isEmptyFrete($sessionFrete) {
        if (!empty($sessionFrete)){
            $frete = $sessionFrete;
        } else {
            $frete = array();
            $error = TRUE;
            $cart = new cartController();
            $cart->index($error);
        }
        return $frete;
    }
    
    private function isValorFrete($frete) {
        if (isset($frete['preco'])) {
            $valorFrete = floatval(str_replace(',', '.', $frete['preco']));
        } else {
            $valorFrete = 0;
        }
        return $valorFrete;
    }
    
    public function index() {
        $filtros = new Filtros();
        $dados = $filtros->getTemplateDados();
        
        $total = $this->buscarTotalCarrinho($_SESSION['cart'], $_SESSION['frete']);
        
        $dados['frete'] = $this->isEmptyFrete($_SESSION['frete']);
        $dados['sessionCode'] = PagSeguro::criarSesssao();
        
        
        $dados['total'] = $total;
        $dados['sidebar'] = FALSE;
        
    //    echo("<pre>");
    //    print_r($dados);
    //    echo("</pre>");
        $this->loadTemplate('pagamento', $dados);
    }
    
    public function checkout() {
        //global $config;
        //$user = new Usuarios();
        //$pagSeguro = new PagSeguro();
        //$comprasProduto = new ComprasProduto();
        //$compras = new Compras();
    //    $credicard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
        //$frete = array();
        //$total = 0;
        
        $id = addslashes($_POST['id']);
        $name = addslashes($_POST['name']);
        $cpf = addslashes($_POST['cpf']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);
        $pass = addslashes($_POST['pass']);
        $cep = addslashes($_POST['cep']);
        $rua = addslashes($_POST['rua']);
        $numero = addslashes($_POST['numero']);
        $complemento = addslashes($_POST['complemento']);
        $bairro = addslashes($_POST['bairro']);
        $cidade = addslashes($_POST['cidade']);
        $estado = addslashes($_POST['estado']);
        $cartao_titular = addslashes($_POST['cartao_titular']);
        $cartao_cpf = addslashes($_POST['cartao_cpf']);
        $cartao_numero = addslashes($_POST['cartao_numero']);
        $cvv = addslashes($_POST['cvv']);
        $v_mes = addslashes($_POST['v_mes']);
        $v_ano = addslashes($_POST['v_ano']);
        $cartao_token = addslashes($_POST['cartao_token']);
        $parc = explode(';', $_POST['parc']);
        
    //    $exiteEmail = $user->selecionarUsuariosEmail($email);
    //    if (count($exiteEmail) > 0){
    //        $usuarios = $user->selecionarUsuariosEmailSenha($email, md5($pass));
    //        if (count($usuarios) > 0){
    //            $uid = $user->getID();
    //        } else {
    //            $array = array(
    //                'error' => true,
    //                'msg' => 'E-mail ou Senha não confere'
    //            );
    //            echo json_encode($array);
    //            exit();
    //        }
    //    } else {
    //        $user->setNome($name);
    //        $user->setEmail($email);
    //        $user->setSenha($pass);
    //        $user->setTelefone($telefone);
    //        $uid = $user->incluirUsuariosNomeEmailSenha();
    //    }
        
        $uid = PagSeguro::verificarEmail($email, $pass);
        if ($uid != 0){
            $_SESSION['user']['nome'] = PagSeguro::getNome();
            $_SESSION['user']['email'] = PagSeguro::getEmail();
            $this->user['nome'] = PagSeguro::getNome();
            $this->user['email'] = PagSeguro::getEmail();
        }
        //$cart = $_SESSION['cart'];
        //foreach ($cart as $item) {
        //    $total += (intval($item['qtd']) * floatval($item['preco']));
        //}
        $total = $this->buscarTotalCarrinho($_SESSION['cart'], $_SESSION['frete']);
        
    //    if (!empty($_SESSION['frete'])){
    //        $frete = $_SESSION['frete'];
    //        if (isset($frete['preco'])) {
    //            $valorFrete = floatval(str_replace(',', '.', $frete['preco']));
    //            $total += floatval(str_replace(',', '.', $frete['preco']));
    //        } else {
    //            $valorFrete = 0;
    //        }
    //    }
        
        $frete = $this->isEmptyFrete($_SESSION['frete']);
        $valorFrete = $this->isValorFrete($frete);
        
        //$compraNext = $compras->incluirCompras($uid, $total, $frete['opt']);
        //foreach ($compraNext as $item) {
        //    $idCompra = $item['ID'];
        //}
        //
        //foreach ($_SESSION['cart'] as $key => $item) {
        //    $comprasProduto->inserirComprasProduto($idCompra, $key, $item['qtd'], $item['preco']);
        //}
        $idCompra = PagSeguro::incluirCompras($_SESSION['cart'], $_SESSION['frete'], $uid, $total);
        
        $cartaoPag = array(
            'currency' => "BRL", 
            'name' => $name, 
            'email' => $email, 
            'cpf' => $cpf, 
            'telefone' => $telefone, 
            'id' => $id, 
            'parc' => $parc, 
            'cartao_token' => $cartao_token, 
            'cartao_titular' => $cartao_titular, 
            'cartao_cpf' => $cartao_cpf, 
            'mode' => 'DEFAULT'
        );
        $cartaoEnd = array(
            'rua' => $rua, 
            'numero' => $numero, 
            'bairro' => $bairro, 
            'cep' => $cep, 
            'cidade' => $cidade, 
            'estado' => $estado, 
            'pais' => 'BRA', 
            'complemento' => $complemento
        );
        
        PagSeguro::encaminharPagSeguroCredicard($idCompra, $_SESSION['cart'], $valorFrete, $cartaoPag, $cartaoEnd);
            
    }
    
    //private function encaminharPagSeguroCredicard($idCompra, $cart, $valorFrete, $cartaoPag, $cartaoEnd) {
    //    $array = array();
    //    $credicard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
    //    
    //    $currency = $cartaoPag['currency'];
    //    $name = $cartaoPag['name'];
    //    $email = $cartaoPag['email'];
    //    $cpf = $cartaoPag['cpf'];
    //    $telefone = $cartaoPag['telefone'];
    //    $id = $cartaoPag['id'];
    //    $parc = $cartaoPag['parc'];
    //    $cartao_token = $cartaoPag['cartao_token'];
    //    $cartao_titular = $cartaoPag['cartao_titular'];
    //    $cartao_cpf = $cartaoPag['cartao_cpf'];
    //    $mode = $cartaoPag['mode'];
    //    
    //    $rua = $cartaoEnd['rua'];
    //    $numero = $cartaoEnd['numero'];
    //    $bairro = $cartaoEnd['bairro'];
    //    $cep = $cartaoEnd['cep'];
    //    $cidade = $cartaoEnd['cidade'];
    //    $estado = $cartaoEnd['estado'];
    //    $pais = $cartaoEnd['pais'];
    //    $complemento = $cartaoEnd['complemento'];
    //    
    //    $credicard->setReceiverEmail($this->config['pagseguro_email']);
    //    $credicard->setReference($idCompra);
    //    $credicard->setCurrency($currency);
    //    
    //    foreach ($cart as $key => $item) {
    //        $credicard->addItems()->withParameters($key, $item['nome'], intval($item['qtd']), floatval($item['preco']) );
    //    }
        
        //$credicard->setExtraAmount($valorFrete);
    //    $credicard->setSender()->setName($name);
    //    $credicard->setSender()->setEmail($email);
    //    $credicard->setSender()->setDocument()->withParameters('CPF', $cpf);
    //    $ddd = substr($telefone, 0,2);
    //    $tel = substr($telefone, 2);
    //    $credicard->setSender()->setPhone()->withParameters($ddd, $tel);
    //    $credicard->setSender()->setHash($id);
    //    
    //    $ip = $_SERVER['REMOTE_ADDR'];
    //    if(strlen($ip) < 9) {
    //        $ip = '127.0.0.1';
    //    }
        //echo ($ip);
    //    $credicard->setSender()->setIp($ip);
    //    
    //    $credicard->setShipping()->setAddress()->withParameters($rua, $numero, $bairro, $cep, $cidade, $estado, 'BRA', $complemento);
    //    $credicard->setShipping()->setCost()->withParameters($valorFrete);
    //    $credicard->setBilling()->setAddress()->withParameters($rua, $numero, $bairro, $cep, $cidade, $estado, 'BRA', $complemento);
        //print_r($parc);
    //    $quantity = intval($parc[0]);
    //    $value = ($parc[1]);
        //$noInterest = $parc[2];
    //    $credicard->setInstallment()->withParameters($quantity, $value);
    //    $credicard->setToken($cartao_token);
    //    $credicard->setHolder()->setName($cartao_titular);
    //    
    //    $credicard->setHolder()->setDocument()->withParameters('CPF', $cartao_cpf);
    //    
    //    $credicard->setMode($mode);
    //    
    //    $credicard->setNotificationUrl(BASE_URL.'pagamento/notification');
    //    
    //    try {
            //$credentials = PagSeguro\Configuration\Configure::getAccountCredentials();
    //        $result = $credicard->register($this->credentials);
    //        $array['date'] = $result->getDate();
    //        $array['code'] = $result->getCode();
    //        $array['reference'] = $result->getReference();
    //        $array['type'] = $result->getType();
    //        $array['status'] = $result->getStatus();
    //        $array['lastEventDate'] = $result->getLastEventDate();
    //        $array['installmentCount'] = $result->getInstallmentCount();
    //        $array['cancelationSource'] = $result->getCancelationSource();
    //        
    //        Compras::atualizarComprasCodeTransaction($idCompra, $array['code']);
    //        echo ( json_encode($result) );
            //print_r($result);
    //        exit();
    //    } catch (Exception $exc) {
    //        echo (json_encode(array('error'=>true,'msg'=>$exc->getMessage() ) ) );
    //        echo $exc->getTraceAsString();
    //        exit();
    //    }
    //}
    
    public function notification($code = null) {
        $compras = new Compras();
        try {
            //$credentials = PagSeguro\Configuration\Configure::getAccountCredentials(); //AccountCredentials
            if (!is_null($code)){
                $check = \PagSeguro\Services\Transactions\Search\Code::search($this->credentials, $code); //String
                //echo ("<br/><hr><br>");
                //echo ("<pre>");
                //print_r ($check);
                //echo ("</pre>");
                //echo ("<br/><hr><br>");
                //$reference = $check->getReference();
                //$status = $check->getStatus();
                //$codigo = $check->getCode();
                //$date = $check->getDate();
                //$lastEventDate = $check->getLastEventDate();
                //$creditorFees = $check->getCreditorFees();
            } else {
                $check = \PagSeguro\Services\Transactions\Notification::check($this->credentials); //mixed
                //echo ("<br/><hr><br>");
                //echo ("<pre>");
                //print_r ($check);
                //echo ("</pre>");
                //echo ("<br/><hr><br>");
                //$reference = $check->getReference();
                //$status = $check->getStatus();
                //$codigo = $check->getCode();
                //$date = $check->getDate();
                //$lastEventDate = $check->getLastEventDate();
                //$creditorFees = $check->getCreditorFees();
            }
            $reference = $check->getReference();
            $status = $check->getStatus();
            $codigo = $check->getCode();
            $date = $check->getDate();
            $lastEventDate = $check->getLastEventDate();
            $creditorFees = $check->getCreditorFees();
            /*
             * STATUS
             *   1 = Aguardando Pagamento
             *   2 = Em análise
             *   3 = Paga
             *   4 = Disponível
             *   5 = Em disputa
             *   6 = Devolvida
             *   7 = Cancelada
             *   8 = Debitado
             *   9 = Retenção Temporária = Chargeback
             ***/
            
            echo ("<br/> Reference: ".$reference);
            echo ("<br/> Status: ".$status);
            echo ("<br/> Codigo: ".$codigo);
            echo ("<br/> Date: ".$date);
            echo ("<br/> LastEventDate: ".$lastEventDate);
            echo ("<br/> CreditorFees: ");
            print_r($creditorFees);
            
            $compras->selecionarComprasID($reference);
            
            if ($compras->getStatusPagamento() != $status){
                $compras->atualizarComprasStatusPagamento($reference, $status);
                $compras->atualizarComprasCodeTransaction($reference, $codigo);
            }
            
            //if ($status == '3'){
            //    echo ("<br/> Reference");
            //    echo ($reference);
            //    echo ("<br/> Status");
            //    echo ($status);
            //} elseif ($status == '7') {
            //    echo ("<br/> Reference");
            //    echo ($reference);
            //    echo ("<br/> Status");
            //    echo ($status);
            //}
            
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    public function obrigado() {
        cartController::excluirSession();
        
        $filtros = new Filtros();
        $dados = $filtros->getTemplateDados();
        $dados['nome'] = $this->user['nome'];
        $dados['email'] = $this->user['email'];
        $dados['sidebar'] = FALSE;
        
        $this->loadTemplate("pagSeguroObrigado", $dados);
    }
    
    public function boleto($error = array()) {
        $filtros = new Filtros();
        $dados = $filtros->getTemplateDados();
        
        $total = $this->buscarTotalCarrinho($_SESSION['cart'], $_SESSION['frete']);
        
        if (count($error) > 0){
            $dados['error'] = $error['error'];
            $dados['msg'] = $error['msg'];
        }
        $dados['frete'] = $this->isEmptyFrete($_SESSION['frete']);
        $dados['usuario'] = $this->user;
        
        
        $dados['total'] = $total;
        $dados['sidebar'] = FALSE;
        
    //    echo("<pre>");
    //    print_r($dados);
    //    echo("</pre>");
        $this->loadTemplate('boleto', $dados);
    }
    
    public function checkoutBoleto() {
        //$id = addslashes($_POST['id']);
        $name = addslashes($_POST['name']);
        $cpf = addslashes($_POST['cpf']);
        $telefone = addslashes($_POST['telefone']);
        $email = addslashes($_POST['email']);
        $pass = addslashes($_POST['pass']);
        $cep = addslashes($_POST['cep']);
        $rua = addslashes($_POST['rua']);
        $numero = addslashes($_POST['numero']);
        $complemento = addslashes($_POST['complemento']);
        $bairro = addslashes($_POST['bairro']);
        $cidade = addslashes($_POST['cidade']);
        $estado = addslashes($_POST['estado']);
        
        $uid = MercadoPago::verificarEmail($email);
        
        if ($uid == -1) {
            $error = array();
            $error['error'] = TRUE;
            $error['msg'] = 'Existe mais de um Usuario com o mesmo e-mail';
            $this->index($error);
            exit();
        } elseif ($uid == -2) {
            $error = array();
            $error['error'] = TRUE;
            $error['msg'] = 'Usuario não Cadastrado';
            $this->index($error);
            exit();
        }
        
        $total = $this->buscarTotalCarrinho($_SESSION['cart'], $_SESSION['frete']);
        $frete = $this->isEmptyFrete($_SESSION['frete']);
        $valorFrete = $this->isValorFrete($frete);
        echo("<pre>");
        print_r($_SESSION['cart']);
        echo("</pre>");
        echo("<br>");
        echo("<pre>");
        print_r($_SESSION['frete']);
        echo ("</pre>");
        echo("<br> UID:");
        echo($uid);
        echo("<br> TOTAL:");
        echo($total);
        echo("<br>");
        $idCompra = MercadoPago::incluirCompras($_SESSION['cart'], $_SESSION['frete'], $uid, $total);
        //$idCompra = intval("31");
        
        //require './vendor/mercadopago/sdk/lib/mercadopago.php';
        //global $config;
        $mp = new MP($this->config['mpID'], $this->config['mpSecretKEY']);
        
        
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
        
        if ($link['status'] == "201"){
            $response = $link['response']['sandbox_init_point'];
            $array['date'] = $link['response']['date_created'];
            $array['code'] = $link['response']['id'];
            $array['reference'] = $link['response']['external_reference'];
            Compras::atualizarComprasCodeTransaction($idCompra, $array['code']);
        } else {
            $error = array();
            $error['error'] = TRUE;
            $error['msg'] = 'Tente Novamente mais Tarde!';
            $this->index($error);
            exit();
        }
        
        echo ("<pre>");
        print_r($link);
        echo ("</pre>");
        exit();
        
        header("location: ".$response);
        //MercadoPago::encaminharMercadoPago($idCompra, $_SESSION['cart'], $valorFrete, $cartaoPag, $cartaoEnd);
        
    }
}
