<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Filtros
 *
 * @author Daniel_Caldeira
 */
class Filtros extends model{
    private $where;
    
    public function __construct() {
        parent::__construct();
    }
    
    //put your code here
    private function atualizaWhereProdutos($consultas) {
        $where = array();
        $produtosOpcoes = new ProdutosOpcoes();
        
        if (!empty($consultas['marca'])){
            foreach ($consultas['marca'] as $item) {
                $where['id_marca'][] = $item;
            }
        }
        if (!empty($consultas['star'])){
            foreach ($consultas['star'] as $item) {
                $where['avalia'][] = $item;
            }
        }
        if (!empty($consultas['featured'])){
            foreach ($consultas['featured'] as $item) {
                $where['destaque'][] = $item;
            }
        }
        if (!empty($consultas['sale'])){
            foreach ($consultas['sale'] as $item) {
                $where['promo'][] = $item;
            }
        }
        if (!empty($consultas['bestseller'])){
            foreach ($consultas['bestseller'] as $item) {
                $where['top_vendido'][] = $item;
            }
        }
        if (!empty($consultas['opcao'])){
            foreach ($consultas['opcao'] as $item) {
                $valor[] = $item;
            }
            $OProduto = $produtosOpcoes->selecionarProdutosOpcoesValor($valor);
            foreach ($OProduto as $OPitem) {
                $where['prd.id'][] = $OPitem['id_produto'];
            }
        }
        
        if (!empty($consultas['id_categoria'])){
            $where['id_categoria'] = $consultas['id_categoria'];
        }
        
        if (!empty($consultas['slider0'])){
            $where['preco']['>'] = $consultas['slider0'];
        //    array(
        //        'preco' => $consultas['slider0']
        //    );
        //    "select id from produtos where preco > ".$consultas['slider0'];
        }
        if (!empty($consultas['slider1'])){
            $where['preco']['<'] = $consultas['slider1'];
        //    array(
        //        'preco' => $consultas['slider1']
        //    );
        //    "select id from produtos where preco < ".$consultas['slider1'];
        }
        if (!empty($consultas['busca'])){
            $where['prd.nome']['LIKE'] = $consultas['busca'];
        }
        //echo ("<pre>");
        //print_r($where);
        //echo ("</pre>");
        $this->where = $where;
        return $where;
    }
    
    private function selecionarALLEstrelas() {
        $array = array();
        for ($x=0; $x<7; $x++){
            $array[] = 0;
        }
        return $array;
    }
    
    public function getTotalProdutos($consultas = array()) {
        $produtos = new Produtos();
        if (is_array($this->getWhere())) {
            $where = $this->getWhere();
        }else{
            $where = $this->atualizaWhereProdutos($consultas);
        }
        
        $valor = $produtos->getTotalProdutos($where);
        return $valor;
    }
    
    public function atualizarFiltros($consultas = array()) {
        $produtos = new Produtos();
        $marcas = new Marcas();
        $produtosOpcoes = new ProdutosOpcoes();
        $array = array(
            'busca' => '',
            'marcas' => array(),
            'slider0' => 0,
            'slider1' => 0,
            'maxslider' => 1000,
            'minslider' => 0,
            'estrelas' => array(),
            'promo' => 0,
            'options' => array()
        );
        if (is_array($this->getWhere())) {
            $where = $this->getWhere();
        }else{
            $where = $this->atualizaWhereProdutos($consultas);
        }
        
        //Criando o Filtro de Preco
        $array['maxslider'] = $produtos->getMaxPreco();
        $array['minslider'] = $produtos->getMinPreco();
        $array['slider1'] = $array['maxslider'];
        $array['slider0'] = $array['minslider'];
        if (!empty($consultas['slider0'])){
            $array['slider0'] = $consultas['slider0'];
        }
        if (!empty($consultas['slider1'])){
            $array['slider1'] = $consultas['slider1'];
        }
        
        //Criando o Array busca
        if (isset($consultas['busca'])){
            $array['busca'] = $consultas['busca'];
        }
        
        //Criando Filtro de Marcas
        $array['marcas'] = $marcas->selecionarALLMarcas();
        $marca_produtos = $produtos->getTotalMarcas($where);
        foreach ($array['marcas'] as $keyMarca => $marcaItem) {
            $array['marcas'][$keyMarca]['count'] = 0;
            foreach ($marca_produtos as $mProduto) {
                if ($mProduto['id_marca'] == $marcaItem['id']){
                    $array['marcas'][$keyMarca]['count'] = $mProduto['c'];
                }
            }
            if ($array['marcas'][$keyMarca]['count'] == 0){
                unset($array['marcas'][$keyMarca]);
            }
        }
        
        //Criando Filtro Estrela
        $array['estrelas'] = $this->selecionarALLEstrelas();
        $estrela_produtos = $produtos->getTotalEstrelas($where);
        foreach ($array['estrelas'] as $keyEstrela => $estrelaItem) {
            foreach ($estrela_produtos as $mProduto) {
                if ($mProduto['avalia'] == $keyEstrela){
                    $array['estrelas'][$keyEstrela] = $mProduto['c'];
                }
            }
        }
        
        //Criando Filtro Promocao
        $array['promo'] = $produtos->getPromoCount($where);
        
        //Criando Filtro Opcoes
        $opcoes_count = $produtosOpcoes->visualizarAllCountProdutos($where);
        $array['options'] = $opcoes_count;
        
        return $array;
    }
    
    public function atualizarProdutos($offset = 0, $limit = 0, $consultas = array(), $random = false) {
        $produtos = new Produtos();
    //    $marcas = new Marcas();
    //    $categorias = new Categorias();
        $produtoImagens = new ProdutosImagens();
        $where = $this->atualizaWhereProdutos($consultas);
        
        $array = $produtos->selecionarAllProdutosJoinMarcasCategorias($offset, $limit, $where, $random);
        if ($produtos->numRows() > 0){
            foreach ($array as $key => $item) {
                $array[$key]['imagens'] = $produtoImagens->selecionarProdutosImagensIDProduto($item['id']);
                if (count($array[$key]['imagens']) == 0){
                    $array[$key]['imagens'][0]['url'] = "indisponivel.jpg";
                }
            }
        }
        
    //    $array = $produtos->selecionarALLProdutos($offset, $limit, $where);
    //    if ($produtos->numRows() > 0){
    //        foreach ($array as $key => $item) {
    //            $marcas->selecionarMarcasID($item['id_marca']);
    //            $array[$key]['marca_nome'] = $marcas->getNome();
    //            $categorias->selecionarCategoriasID($item['id_categoria']);
    //            $array[$key]['categoria_nome'] = $categorias->getNome();
    //            $array[$key]['imagens'] = $produtoImagens->selecionarProdutosImagensIDProduto($item['id']);
    //        }
    //    }
        return $array;
    }
    
    public function getProdutoInfo($produto = array()) {
        $marcas = new Marcas();
        $produtosImagens = new ProdutosImagens();
        $produtosOpcoes = new ProdutosOpcoes();
        $produtosAvalia = new ProdutosAvalia();
    //    $usuarios = new Usuarios();
    //    $opcoes = new Opcoes();
        
        $produto_info = array();
        if (count($produto) > 0){
            foreach ($produto as $value) {
                $produto_info = $value;
                $marcas->selecionarMarcasID($value['id_marca']);
                $produto_info['marca_nome'] = $marcas->getNome();
                $idProduto = intval($value['id']);
                $produto_info['imagens'] = $produtosImagens->selecionarProdutosImagensIDProduto($idProduto);
                $produto_info['opcoes'] = $produtosOpcoes->selecionarAllProdutosOpcoesJoinOpcoesIDProduto($idProduto);
                $produto_info['avalia'] = $produtosAvalia->selecionarAllProdutosAvaliaJoinUsuariosIDProduto($idProduto);
            }
            if (count($produto_info['imagens']) == 0){
                $produto_info['imagens'][0]['url'] = "indisponivel.jpg";
            }
        //    if (count($produto_info['opcoes']) > 0){
        //        foreach ($produto_info['opcoes'] as $key => $opc) {
        //            $opcoes->selecionarOpcoesID($opc['id_opcao']);
        //            $nomeOpcao = $opcoes->getNome();
        //            $produto_info['opcoes'][$key]['nomeOpcao'] = $nomeOpcao;
        //        }
        //    }
        //    if (count($produto_info['avalia']) > 0){
        //        foreach ($produto_info['avalia'] as $key => $avalia) {
        //            $usuarios->selecionarUsuariosID($avalia['id_user']);
        //            $userNome = $usuarios->getNome();
        //            $produto_info['avalia'][$key]['nomeUser'] = $userNome;
        //        }
        //    }
        }
        
        return $produto_info;
    }
    
    public function getTemplateDados() {
        $dados = array();
        $categorias = new Categorias();
        
        $dados['categorias'] = $categorias->ordenarALLCategorias();
        $dados['widget_featured1'] = $this->atualizarProdutos(0, 3, array('featured' => array(1)), true);
        //$dados['widget_featured2'] = $this->atualizarProdutos(0, 3, array('featured' => array(1)), true);
        $dados['widget_sale'] = $this->atualizarProdutos(0, 3, array('sale' => array(1)), true);
        $dados['widget_toprated'] = $this->atualizarProdutos(0, 3, array('bestseller' => array(1)) );
        
        return $dados;
    }
    
    protected function getWhere() {
        return $this->where;
    }
    
}
?>

 <?php
namespace PhpSigep\Services\Real;
use PhpSigep\Model\ConsultaCepResposta;
use PhpSigep\Services\Result;
/**
 * @author: Stavarengo
 */
class ConsultaCep
{
    public function execute($cep)
    {
        $cep = preg_replace('/[^\d]/', '', $cep);
        $soapArgs = array(
            'cep' => $cep,
        );
        $r = SoapClientFactory::getSoapClient()->consultaCep($soapArgs);
        $errorCode = null;
        $errorMsg  = null;
        $result    = new Result();
        if (!$r) {
            $errorCode = 0;
        } else if ($r instanceof \SoapFault) {
            $errorCode = $r->getCode();
            $errorMsg  = SoapClientFactory::convertEncoding($r->getMessage());
            $result->setSoapFault($r);
        } else if ($r instanceof \stdClass) {
             if (property_exists($r, 'return') && $r->return instanceof \stdClass) {
                $consultaCepResposta = new ConsultaCepResposta();
                $consultaCepResposta->setBairro(SoapClientFactory::convertEncoding($r->return->bairro));
                $consultaCepResposta->setCep($r->return->cep);
                $consultaCepResposta->setCidade(SoapClientFactory::convertEncoding($r->return->cidade));
                $consultaCepResposta->setComplemento1(SoapClientFactory::convertEncoding($r->return->complemento));
                $consultaCepResposta->setComplemento2(SoapClientFactory::convertEncoding($r->return->complemento2));
                $consultaCepResposta->setEndereco(SoapClientFactory::convertEncoding($r->return->end));
                $consultaCepResposta->setId($r->return->id);
                $consultaCepResposta->setUf($r->return->uf);
                $result->setResult($consultaCepResposta);
             } else {
                 $errorCode = 0;
                 $errorMsg = "Resposta em branco. Confirme se o CEP '$cep' realmente existe.";
             }
        } else {
            $errorCode = 0;
            $errorMsg  = "A resposta do Correios não está no formato esperado.";
        }
        $result->setErrorCode($errorCode);
        $result->setErrorMsg($errorMsg);
        return $result;
    }
}
?>

<?php
/**
 * prestashop Project ${PROJECT_URL}
 *
 * @link      ${GITHUB_URL} Source code
 */
namespace PhpSigep\Model;
class ConsultaCepResposta extends AbstractModel
{
    /**
     * @var string
     */
    protected $bairro;
    /**
     * @var string
     */
    protected $cep;
    /**
     * @var string
     */
    protected $cidade;
    /**
     * @var string
     */
    protected $complemento1;
    /**
     * @var string
     */
    protected $complemento2;
    /**
     * @var string
     */
    protected $endereco;
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $uf;
    /**
     * @param string $bairro
     * @return $this;
     */
    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
        return $this;
    }
    /**
     * @return string
     */
    public function getBairro()
    {
        return $this->bairro;
    }
    /**
     * @param string $cep
     * @return $this;
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
        return $this;
    }
    /**
     * @return string
     */
    public function getCep()
    {
        return $this->cep;
    }
    /**
     * @param string $cidade
     * @return $this;
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
        return $this;
    }
    /**
     * @return string
     */
    public function getCidade()
    {
        return $this->cidade;
    }
    /**
     * @param string $complemento1
     * @return $this;
     */
    public function setComplemento1($complemento1)
    {
        $this->complemento1 = $complemento1;
        return $this;
    }
    /**
     * @return string
     */
    public function getComplemento1()
    {
        return $this->complemento1;
    }
    /**
     * @param string $complemento2
     * @return $this;
     */
    public function setComplemento2($complemento2)
    {
        $this->complemento2 = $complemento2;
        return $this;
    }
    /**
     * @return string
     */
    public function getComplemento2()
    {
        return $this->complemento2;
    }
    /**
     * @param string $endereco
     * @return $this;
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
        return $this;
    }
    /**
     * @return string
     */
    public function getEndereco()
    {
        return $this->endereco;
    }
    /**
     * @param int $id
     * @return $this;
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param string $uf
     * @return $this;
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
        return $this;
    }
    /**
     * @return string
     */
    public function getUf()
    {
        return $this->uf;
    }
   
} 
?>

<?php
/**
 * prestashop Project ${PROJECT_URL}
 *
 * @link      ${GITHUB_URL} Source code
 */
 
namespace PhpSigep\Services;
use PhpSigep\DefaultStdClass;
use PhpSigep\Model\AbstractModel;
use PhpSigep\Services\Real\SoapClientFactory;
class Result extends DefaultStdClass
{
    /**
     * @var bool
     */
    protected $isSoapFault = false;
    
    /**
     * @var int
     */
    protected $errorCode = null;
    /**
     * @var string
     */
    protected $errorMsg = null;
    /**
     * @var AbstractModel|AbstractModel[]
     */
    protected $result;
    /**
     * @var \SoapFault
     */
    protected $soapFault;
    
    public function hasError()
    {
        return ($this->errorCode !== null || $this->errorMsg !== null || $this->isSoapFault);
    }
    /**
     * @param boolean $isSoapFault
     * @return $this;
     */
    public function setIsSoapFault($isSoapFault)
    {
        $this->isSoapFault = $isSoapFault;
        return $this;
    }
    /**
     * @return boolean
     */
    public function getIsSoapFault()
    {
        return $this->isSoapFault;
    }
    
    /**
     * @param int $errorCode
     * @return $this;
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
        return $this;
    }
    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }
    /**
     * @param string $errorMsg
     * @return $this;
     */
    public function setErrorMsg($errorMsg)
    {
        $this->errorMsg = $errorMsg;
        return $this;
    }
    /**
     * @return string
     */
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
    /**
     * @param \SoapFault $soapFault
     * @return $this;
     */
    public function setSoapFault(\SoapFault $soapFault)
    {
        $this->soapFault = $soapFault;
        $this->setIsSoapFault(true);
        return $this;
    }
    /**
     * @return \SoapFault
     */
    public function getSoapFault()
    {
        return $this->soapFault;
    }
    /**
     * @param AbstractModel|AbstractModel[]|\SoapFault $result
     * @throws InvalidArgument
     * @return $this;
     */
    public function setResult($result)
    {
        if ($result instanceof \SoapFault) {
            $this->setIsSoapFault(true);
            $this->setErrorCode($result->getCode());
            $this->setErrorMsg(SoapClientFactory::convertEncoding($result->getMessage()));
            $this->result = null;
            $this->setSoapFault($result);
        } else {
            $piece = $result;
            if (is_array($result)) {
                if (count($result)) {
                    $piece = reset($result);
                } else {
                    $piece = null;
                }
            }
            
            if ($piece !== null && !($piece instanceof AbstractModel) && !($piece instanceof \SoapFault)) {
                throw new InvalidArgument('O resultado deve ser uma instância de PhpSigep\Model\AbstractModel ou um ' .
                    'array de PhpSigep\Model\AbstractModel ou uma instância de \SoapFault.');
            }
            
            $this->result = $result;
        }
        return $this;
    }
    /**
     * @return \PhpSigep\Model\AbstractModel|\PhpSigep\Model\AbstractModel[]
     */
    public function getResult()
    {
        return $this->result;
    }
    
    
} 
?>


<?php
/**
 * prestashop Project ${PROJECT_URL}
 *
 * @link      ${GITHUB_URL} Source code
 */
namespace PhpSigep\Services\Real;
use PhpSigep\Bootstrap;
use PhpSigep\Config;
use PhpSigep\Services\Real\Exception\SoapExtensionNotInstalled;
class SoapClientFactory
{
    const WEB_SERVICE_CHARSET = 'ISO-8859-1';
    /**
     * @var \SoapClient
     */
    protected static $_soapClient;
    /**
     * @var \SoapClient
     */
    protected static $_soapCalcPrecoPrazo;
    /**
     * @var \SoapClient
     */
    protected static $_soapRastrearObjetos;
    public static function getSoapClient()
    {
        if (!self::$_soapClient) {
            if (!extension_loaded('soap')) {
                throw new SoapExtensionNotInstalled('The "soap" module must be enabled in your PHP installation. The "soap" module is required in order to PHPSigep to make requests to the Correios WebService.');
            }
            $wsdl = Bootstrap::getConfig()->getWsdlAtendeCliente();
            $opts = array(
                'ssl' => array(
                    //'ciphers'           =>'RC4-SHA', // comentado o parâmetro ciphers devido ao erro que ocorre quando usado dados de ambiente de produção em um servidor local conforme issue https://github.com/stavarengo/php-sigep/issues/35#issuecomment-290081903
                    'verify_peer'       =>false, 
                    'verify_peer_name'  =>false
                )
            );
            // SOAP 1.1 client
            $params = array (
                'encoding'              => self::WEB_SERVICE_CHARSET, 
                'verifypeer'            => false, 
                'verifyhost'            => false, 
                'soap_version'          => SOAP_1_1, 
                'trace'                 => Bootstrap::getConfig()->getEnv() != Config::ENV_PRODUCTION,
                'exceptions'            => Bootstrap::getConfig()->getEnv() != Config::ENV_PRODUCTION, 
                "connection_timeout"    => 180, 
                'stream_context'        => stream_context_create($opts) 
            );
            self::$_soapClient = new \SoapClient($wsdl, $params);
        }
        return self::$_soapClient;
    }
    public static function getSoapCalcPrecoPrazo()
    {
        if (!self::$_soapCalcPrecoPrazo) {
            $wsdl = Bootstrap::getConfig()->getWsdlCalcPrecoPrazo();
            $opts = array(
                'ssl' => array(
                    'ciphers'           =>'RC4-SHA',
                    'verify_peer'       =>false,
                    'verify_peer_name'  =>false
                )
            );
            // SOAP 1.1 client
            $params = array (
                'encoding'              => self::WEB_SERVICE_CHARSET,
                'verifypeer'            => false,
                'verifyhost'            => false,
                'soap_version'          => SOAP_1_1,
                'trace'                 => Bootstrap::getConfig()->getEnv() != Config::ENV_PRODUCTION,
                'exceptions'            => Bootstrap::getConfig()->getEnv() != Config::ENV_PRODUCTION,
                "connection_timeout"    => 180,
                'stream_context'        => stream_context_create($opts)
            );
            self::$_soapCalcPrecoPrazo = new \SoapClient($wsdl, $params);
        }
        return self::$_soapCalcPrecoPrazo;
    }
    public static function getRastreioObjetos()
    {
        if (!self::$_soapRastrearObjetos) {
            $wsdl = Bootstrap::getConfig()->getWsdlRastrearObjetos();
            $opts = array(
                'ssl' => array(
                    //'ciphers'           =>'RC4-SHA',
                    'verify_peer'       =>false,
                    'verify_peer_name'  =>false
                )
            );
            // SOAP 1.1 client
            $params = array (
                'encoding'              => self::WEB_SERVICE_CHARSET,
                'verifypeer'            => false,
                'verifyhost'            => false,
                'soap_version'          => SOAP_1_1,
                'trace'                 => Bootstrap::getConfig()->getEnv() != Config::ENV_PRODUCTION,
                'exceptions'            => Bootstrap::getConfig()->getEnv() != Config::ENV_PRODUCTION,
                "connection_timeout"    => 180,
                'stream_context'        => stream_context_create($opts)
            );
            self::$_soapRastrearObjetos = new \SoapClient($wsdl, $params);
        }
        return self::$_soapRastrearObjetos;
    }
    /**
     * Se possível converte a string recebida.
     * @param $string
     * @return bool|string
     */
    public static function convertEncoding($string)
    {
        $to     = 'UTF-8';
        $from   = self::WEB_SERVICE_CHARSET;
        $str = false;
        
        if (function_exists('iconv')) {
            $str = iconv($from, $to . '//TRANSLIT', $string);
        } elseif (function_exists('mb_convert_encoding')) {
            $str = mb_convert_encoding($string, $to, $from);
        }
        if ($str === false) {
            $str = $string;
        }
        return $str;
    }
} 