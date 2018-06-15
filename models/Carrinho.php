<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Carrinho
 *
 * @author Daniel_Caldeira
 */
class Carrinho extends model{
    private $config;
    
    public function __construct() {
        global $config;
        $this->config = $config;
        parent::__construct();
    }
    
    //put your code here
    public function informarALLCompras() {
        $array = array();
        $produto = new Produtos();
    //    $produtoImagens = new ProdutosImagens();
        
        if (!empty($_SESSION['cart']) ){
            $carrinho = $_SESSION['cart'];
            $cont = 0;
            foreach ($carrinho as $id => $value) {
                $arrayPRD = $produto->selecionarProdutosID($id);
                foreach ($arrayPRD as $item) {
                    $array[$cont] = $item;
            //        $array[$cont]['qtd'] = intval($value['qtd']);
            //        $array[$cont]['imagens'] = $produtoImagens->selecionarProdutosImagensIDProduto($id);
            //        if (count($array[$cont]['imagens']) == 0){
            //            $array[$cont]['imagens'][0]['url'] = "indisponivel.jpg";
            //        }
                }
            //    $array[$cont]['id'] = $id;
                $array[$cont]['imagens'][0] = $value['imagens'];
            //    $array[$cont]['nome'] = $value['nome'];
                $array[$cont]['qtd'] = intval($value['qtd']);
            //    $array[$cont]['preco'] = floatval($value['preco']);
                $array[$cont]['subTotal'] = floatval($value['subTotal']);
                //$subTotal = intval($qtd) * floatval($produto->getPreco());
                //$array[] = ['id' => $produto->getID(), 'qtd' => intval($qtd), 'preco' => $produto->getPreco(), 'nome' => $produto->getNome(), 'imagens' => $imagens, 'subTotal' => $subTotal ];
                //$array[$cont]['id'] = $produto->getID();
                //$array[$cont]['qtd'] = intval($qtd);
                //$array[$cont]['preco'] = $produto->getPreco();
                //$array[$cont]['nome'] = $produto->getNome();
                //$array[$cont]['imagens'] = $imagens;
                //$array[$cont]['subTotal'] = $subTotal;
                $cont++;
            }
        }
        
        return $array;
    }
    
    private function verificarCEP($cepDestino){
        $opts = array(
            'ssl' => array(
                //'ciphers'           =>'RC4-SHA',
                'verify_peer'      => false,
                'verify_peer_name' => false
            )
        );
        $options = array( 'encoding' => 'UTF-8', 'verifypeer' => false, 'verifyhost' => false, 'soap_version' => SOAP_1_1, 
            'trace' => 2, 'exceptions' => 2, 'connection_timeout' => 180, 'stream_context' => stream_context_create($opts)
        );
        
        $cepArray = array( 'cep' => $cepDestino );
        
        $cepURL = "https://apphom.correios.com.br/SigepMasterJPA/AtendeClienteService/AtendeCliente?wsdl";
        try {
            $soap = new SoapClient($cepURL, $options);
            $result = $soap->consultaCEP($cepArray);
        } catch (Exception $exc) {
            $result = $exc->getTraceAsString();
            echo $exc->getTraceAsString();
        }
        
        //echo("<pre>");
        //print_r($result);
        //echo("</pre><br/>");
        return $result;
    }
    
    private function calcPrecoPrazo($cepOrigem, $cepDestino, $nVlPeso, $nVlComprimento, $nVlAltura, $nVlLargura, $nVlDiametro, $nVlValorDeclarado) {
        $data = array(
            'nCdServico' => '40010',
            'sCepOrigem' => $cepOrigem,
            'sCepDestino' => $cepDestino,
            'nVlPeso' => $nVlPeso,
            'nCdFormato' => '1',
            'nVlComprimento' => $nVlComprimento,
            'nVlAltura' => $nVlAltura,
            'nVlLargura' => $nVlLargura,
            'nVlDiametro' => $nVlDiametro,
            'sCdMaoPropria' => 'N',
            'nVlValorDeclarado' => $nVlValorDeclarado,
            'sCdAvisoRecebimento' => 'N',
            'StrRetorno' => 'xml'
        );
        
        $url = 'http://ws.correios.com.br/calculador/CalcPrecoprazo.aspx';
        $pag_array = http_build_query($data);
        
        
        $curl = curl_init($url.'?'.$pag_array);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $r = curl_exec($curl);
        $xml = simplexml_load_string($r);
        return $xml;
    }
    
    public function calcularRemessa($cepDestino) {
        $array = array( 
            'preco' => 0, 
            'data' => '', 
            'cidade' => '', 
            'cep' => '', 
            'uf' => '', 
            'end' => '', 
            'bairro' => '' 
        );
        
        $cepXML = $this->verificarCEP($cepDestino);
        $array['cidade'] = ($cepXML->return->cidade);
        $array['uf'] = ($cepXML->return->uf);
        $array['bairro'] = ($cepXML->return->bairro);
        $array['cep'] = $cepDestino;
        $array['end'] = ($cepXML->return->end);
        
        $produtos = $this->informarALLCompras();
        
        $nVlPeso = 0;
        $nVlComprimento = 0;
        $nVlAltura = 0;
        $nVlLargura = 0;
        $nVlDiametro = 0;
        $nVlValorDeclarado = 0;
        
        foreach ($produtos as $item) {
            $nVlPeso += floatval($item['peso']);
            $nVlComprimento += floatval($item['comprimento']);
            $nVlAltura += floatval($item['altura']);
            $nVlLargura += floatval($item['largura']);
            $nVlDiametro += floatval($item['diametro']);
            $nVlValorDeclarado += (floatval($item['preco']) * intval($item['qtd']));
        }
        
        $soma = $nVlComprimento + $nVlAltura + $nVlLargura;
        if ($soma > 200){ $nVlComprimento = 66; $nVlAltura = 66; $nVlLargura = 66; }
        if ($nVlDiametro > 90){ $nVlDiametro = 90; }
        if ($nVlPeso > 40){ $nVlPeso = 40; }
        $cepOrigem = $this->config['cep_origem'];
        
        $xml = $this->calcPrecoPrazo($cepOrigem, $cepDestino, $nVlPeso, $nVlComprimento, $nVlAltura, $nVlLargura, $nVlDiametro, $nVlValorDeclarado);
    //    $data = array(
    //        'nCdServico' => '40010',
    //        'sCepOrigem' => $config['cep_origem'],
    //        'sCepDestino' => $cepDestino,
    //        'nVlPeso' => $nVlPeso,
    //        'nCdFormato' => '1',
    //        'nVlComprimento' => $nVlComprimento,
    //        'nVlAltura' => $nVlAltura,
    //        'nVlLargura' => $nVlLargura,
    //        'nVlDiametro' => $nVlDiametro,
    //        'sCdMaoPropria' => 'N',
    //        'nVlValorDeclarado' => $nVlValorDeclarado,
    //        'sCdAvisoRecebimento' => 'N',
    //        'StrRetorno' => 'xml'
    //    );
        
    //    $url = 'http://ws.correios.com.br/calculador/CalcPrecoprazo.aspx';
    //    $pag_array = http_build_query($data);
        
        
    //    $curl = curl_init($url.'?'.$pag_array);
    //    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //    $r = curl_exec($curl);
    //    $xml = simplexml_load_string($r);
    //    echo ("<pre>");
    //    print_r($data);
    //    echo ("</pre><br/>");
    //    echo ("<pre>");
    //    print_r($xml);
    //    echo ("</pre><br/>");
        
        $array['preco'] = current($xml->cServico->Valor);
        $array['data'] = current($xml->cServico->PrazoEntrega);
        return $array;
    }
}

