<?php

require './vendor/mercadopago/sdk/lib/mercadopago.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pagamentoMPController
 *
 * @author Daniel_Caldeira
 */
class pagamentoMPController extends controller {
    private $user;
    private $credentials;
    private $config;
    //put your code here
    
    public function __construct() {
    //    $credentials = PagSeguro\Configuration\Configure::getAccountCredentials();
    //    $this->credentials = $credentials;
        $this->user = array();
        if (isset($_SESSION['user'])){
            $this->user['nome'] = $_SESSION['user']['nome'];
            $this->user['email'] = $_SESSION['user']['email'];
            $this->user['senha'] =$_SESSION['user']['senha'];
            $this->user['telefone'] = $_SESSION['user']['telefone'];
        }
        if (count($this->user) == 0){
            $login = new loginController();
            $login->index();
        }
        global $config;
        $this->config = $config;
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
        if (!empty($sessionFrete) && isset($sessionFrete['cep'])){
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
    
    public function index($error = array()) {
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
        $this->loadTemplate('pagamentoMP', $dados);
    }
    
    public function checkout() {
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
        //if ($uid != 0){
        //    $_SESSION['user']['nome'] = MercadoPago::getNome();
        //    $_SESSION['user']['email'] = MercadoPago::getEmail();
        //    $this->user['nome'] = MercadoPago::getNome();
        //    $this->user['email'] = MercadoPago::getEmail();
        //} else
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
            //$array['type'] = $result->getType();
            //$array['status'] = $result->getStatus();
            //$array['lastEventDate'] = $result->getLastEventDate();
            //$array['installmentCount'] = $result->getInstallmentCount();
            //$array['cancelationSource'] = $result->getCancelationSource();
            Compras::atualizarComprasCodeTransaction($idCompra, $array['code'], $response);
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
    
    public function notification($code = null) {
        $compras = new Compras();
        //require './vendor/mercadopago/sdk/lib/mercadopago.php';
        //global $config;
        $mp = new MP($this->config['mpID'], $this->config['mpSecretKEY']);
        $mp->sandbox_mode(true);
        $access_token = $mp->get_access_token();
        
        if (!is_null($code)){
            //$mp->sandbox_mode(true);
            header("Location: https://api.mercadopago.com/v1/payments/".$code."?access_token=".$access_token);
            exit();
            //$info = $mp->get_payment_info($code);
            //$check = \PagSeguro\Services\Transactions\Search\Code::search($this->credentials, $code); //String
        } else {
            //$mp->sandbox_mode(true);
            $info = $mp->get_payment_info($_GET['id']);
            //$check = \PagSeguro\Services\Transactions\Notification::check($this->credentials); //mixed
        }
        
        //$mp->sandbox_mode(true);
        //$info = $mp->get_payment_info($_GET['id']);
        
        if ($info['status'] == '200'){
            $array = $info['response'];
            file_put_contents('mplog.txt', print_r($array, true));
            
            $reference = $array['collection']['external_reference'];
            $status = $array['collection']['status'];
            $codigo = $array['collection']['id'];
            //$date = $check->getDate();
            //$lastEventDate = $check->getLastEventDate();
            //$creditorFees = $check->getCreditorFees();
        }
        
        /*
	pending = Em análise = 2
	approved = Aprovado = 3
	in_procress = Em revisão = 4
	in_mediation = Em processo de disputa = 5
	rejected = Foi rejeitado = 6
	cancelled = Foi cancelado = 7
	refunded = Reembolsado = 8
	charged_back = Chargeback = 9
	*/
        
        $compras->selecionarComprasID($reference);
        
        if ($compras->getStatusPagamento() != $status){
            $compras->atualizarComprasStatusPagamento($reference, $status);
            $compras->atualizarComprasCodeTransaction($reference, $codigo);
        }
        
    //    try {
            //$credentials = PagSeguro\Configuration\Configure::getAccountCredentials(); //AccountCredentials
    //        if (!is_null($code)){
    //            $check = \PagSeguro\Services\Transactions\Search\Code::search($this->credentials, $code); //String
    //        } else {
    //            $check = \PagSeguro\Services\Transactions\Notification::check($this->credentials); //mixed
    //        }
    //        $reference = $check->getReference();
    //        $status = $check->getStatus();
    //        $codigo = $check->getCode();
            //$date = $check->getDate();
            //$lastEventDate = $check->getLastEventDate();
            //$creditorFees = $check->getCreditorFees();
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
            
    //        $compras->selecionarComprasID($reference);
            
    //        if ($compras->getStatusPagamento() != $status){
    //            $compras->atualizarComprasStatusPagamento($reference, $status);
    //            $compras->atualizarComprasCodeTransaction($reference, $codigo);
    //        }
    //    } catch (Exception $exc) {
    //        echo $exc->getTraceAsString();
    //    }
    }
}
