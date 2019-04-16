<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fotoController
 *
 * @author Daniel_Caldeira
 */
class fotoController extends controller{
    private $destino;
    
    public function __construct() {
        $this->destino = (".\\media\\produtos\\");
        parent::__construct();
    }
    
    //put your code here
    public function index() {
        $dados = array ();
                        
        $this->loadTemplate("erro", $dados);
    }
    
    private function existeArquivo($nomeFoto) {
        //$destino = (".\\media\\produtos\\");
        $filename = $this->destino.$nomeFoto;
        return file_exists($filename);
    }
    
    private function excluirArquivo($nomeFoto) {
        //$destino = (".\\media\\produtos\\");
        $filename = $this->destino.$nomeFoto;
        return unlink($filename);
    }
    
    public function excluirFoto($id_imagem = 0) {
        $prdImagens = new ProdutosImagens();
    //    $filtros = new Filtros();
    //    $produtos = new Produtos();
    //    $menu = new Categorias();
    //    $marca = new Marcas();
    //    $dados = $filtros->getTemplateDados();
        
        $ret = NULL;
        $fotos = $prdImagens->selecionarProdutosImagensID($id_imagem);
        if (count($fotos) > 0){
            foreach ($fotos as $foto) {
        //        $id_produto = $foto['id_produto'];
        //        $nomeFoto = $foto['url'];
        //        $array = $produtos->selecionarProdutosID($foto['id_produto']);

                if ($this->existeArquivo($foto['url']) ){
                    $this->excluirArquivo($foto['url']);
                }
                $prdImagens->deletarProdutosImagensID($id_imagem);
                
                $ret = $foto['id_produto'];
        //        $dados['id'] = $foto['id_produto'];
        //        $dados['produto'] = $produtos->selecionarProdutosID($foto['id_produto']);
        //        $dados['produto_info'] = $filtros->getProdutoInfo($dados['produto']);
            }
        }
        
        return $ret;
        //$dados['cats'] = $menu->selecionarALLCategorias();
        //$dados['marcas'] = $marca->selecionarALLMarcas();
        //$dados['confirme'] = "foto";
        //$dados['sidebar'] = FALSE;
        
        //$this->loadPainel("editProduto", $dados);
    }
    
    public function delFoto($id_imagem = 0) {
        $prd = new produtoController();
        $mensagem = "A foto não pode ser Deletada!";
        //$menu = new Categorias();
        //$marca = new Marcas();
        
        $id_produto = $this->excluirFoto($id_imagem);
        if (!is_null($id_produto)){
            $mensagem = "A foto foi deletada com Sucesso!";
            $prd->editProduto($id_produto, $mensagem);
            //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/fotoDEL");
        } else {
            $prd->editProduto($id_produto, $mensagem);
            //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/fotoERROR");
        }
    }
    
    private function moverArquivo($nomeFotoOld, $nomeFotoNew) {
        //$destino = (".\\media\\produtos\\");
        $destination = $this->destino.$nomeFotoNew;
        $filename = $nomeFotoOld;
        return move_uploaded_file($filename, $destination);
    }
    
    private function getImageSize($nomeFoto) {
        //$destino = (".\\media\\produtos\\");
        $filename = $this->destino.$nomeFoto;
        return getimagesize($filename);
    }
    
    private function redimensionarFigura($larguraOriginal, $alturaOriginal) {
        $ratio = $larguraOriginal / $alturaOriginal;
        $largura = "500";
        $altura = "500";
        $ratioFinal = $largura/$altura;
        if (($largura / $altura) > $ratio) {
            $largura = $altura * $ratio;
        } else {
            $altura = $largura / $ratio;
        }
        
        return array($largura, $altura);
    }
    
    private function imageCreate($largura, $altura, $tipo, $nomeFoto) {
        //$destino = (".\\media\\produtos\\");
        $imageFinal = imagecreatetruecolor($largura, $altura);
        $filename = $this->destino.$nomeFoto;
        if ($tipo == "image/jpg"){
            $imageOriginal = imagecreatefromjpeg($filename);
        } elseif ($tipo == "image/jpeg") {
            $imageOriginal = imagecreatefromjpeg($filename);
        } elseif ($tipo == "image/png") {
            $imageOriginal = imagecreatefrompng($filename);
        }
        return array($imageOriginal, $imageFinal);
    }
    
    private function imageJPG($image, $nomeFoto) {
        //$destino = (".\\media\\produtos\\");
        $filename = $this->destino.$nomeFoto;
        return imagejpeg($image, $filename, 80);
    }
    
    public function adicionarFoto($fotos = array()) {
        $fotoNome = array();
        if (count($fotos['tmp_name']) > 0){
        //    $destino = (".\\media\\produtos\\");
        //    print "<br><br>";
        //    print_r($destino);
            
            for ($q=0; $q<count($fotos['tmp_name']); $q++){
                $tipo = $fotos['type'][$q];
                $imagensPermitidas = array('image/jpg', 'image/png', 'image/jpeg');
        //        print "<br><br>";
        //        print_r($tipo);
                
                if (in_array($tipo, $imagensPermitidas)) {
        //            $nomeFoto = time().rand("0","0.99").$fotos['name'][$q];
                    $nomeFoto = $fotos['name'][$q];
                    if (!$this->existeArquivo($nomeFoto)) {
                        $this->moverArquivo($fotos['tmp_name'][$q], $nomeFoto);
                    }
        //            move_uploaded_file($fotos['tmp_name'][$q], $destino.$nomeFoto);
        //            print "<br><br>";
        //            print_r($nomeFoto);
        //            print "<br><br>";
                    
        //            list($larguraOriginal, $alturaOriginal) = getimagesize($destino.$nomeFoto);
                    list($larguraOriginal, $alturaOriginal) = $this->getImageSize($nomeFoto);
                    list($largura, $altura)  = $this->redimensionarFigura($larguraOriginal, $alturaOriginal);
                    
        //            $ratio = $larguraOriginal / $alturaOriginal;
        //            $largura = "500";
        //            $altura = "500";
        //            if ($largura / $altura > $ratio) {
        //                $largura = $altura * $ratio;
        //            } else {
        //                $altura = $largura / $ratio;
        //            }
                    
                    list($imageOriginal, $imagemFinal) = $this->imageCreate($largura, $altura, $tipo, $nomeFoto);
        //            $imagemFinal = imagecreatetruecolor($largura, $altura);
        //            if ($tipo == "image/jpg"){
        //                $imageOriginal = imagecreatefromjpeg($destino.$nomeFoto);
        //            } elseif ($tipo == "image/jpeg") {
        //                $imageOriginal = imagecreatefromjpeg($destino.$nomeFoto);
        //            } elseif ($tipo == "image/png") {
        //                $imageOriginal = imagecreatefrompng($destino.$nomeFoto);
        //            }
                    
                    imagecopyresampled($imagemFinal, $imageOriginal, 0, 0, 0, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);
                    $this->imageJPG($imagemFinal, $nomeFoto);
        //            imagejpeg($imagemFinal, $destino.$nomeFoto);
                    
                    $fotoNome[] = $nomeFoto;
                }
            }
        }
        return $fotoNome;
    }
    
    public function addFoto() {
        $prdImagens = new ProdutosImagens();
        $prd = new produtoController();
        $mensagem = "Nao foi possivel inserir a Foto!";
        
        if (isset($_POST['id_produto']) && !empty($_POST['id_produto'])){
            $id_produto = addslashes($_POST['id_produto']);
            $fotos = ((isset($_FILES['fotos']))?$_FILES['fotos']:array());
            //if (isset($_FILES['fotos'])) {
            //    $fotos = $_FILES['fotos'];
            //} else {
            //    $fotos = array();
            //}
            
            if (count($fotos) > 0){
                $urlArray = $this->adicionarFoto($fotos);
                //print_r($urlArray);
                if (count($urlArray) > 0){
                    foreach ($urlArray as $url) {
                        //echo $url;
                        $prdImagens->incluirProdutosImagens($id_produto, $url);
                    }
                    $mensagem = "Foto Inserida com Sucesso!";
                    $prd->editProduto($id_produto, $mensagem);
                    //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/fotoADD");
                } else {
                    $prd->editProduto($id_produto, $mensagem);
                    //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/fotoERROR");
                }
            } else {
                $prd->editProduto($id_produto, $mensagem);
                //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/fotoERROR");
            }
        }
        
        //$nomeFoto = NULL;
        //if (count($fotos['tmp_name']) > 0){
        //    $destino = (".\\media\\produtos\\");
        //    for ($q=0; $q<count($fotos['tmp_name']); $q++){
        //        $tipo = $fotos['type'][$q];
        //        if (in_array($tipo, array('image/jpg','image/png','image/jpeg'))) {
        //            $nomeFoto = time().rand("0","0.99").$fotos['name'][$q];
        //            //$nomeFoto = $fotos['name'][$q];
        //            move_uploaded_file($fotos['tmp_name'][$q], $destino.$nomeFoto);
        //            list($larguraOriginal, $alturaOriginal) = getimagesize($destino.$nomeFoto);
        //            $ratio = $larguraOriginal / $alturaOriginal;
        //            $largura = "500";
        //            $altura = "500";
        //            if ($largura / $altura > $ratio) {
        //                $largura = $altura * $ratio;
        //            } else {
        //                $altura = $largura / $ratio;
        //            }
        //            $imagemFinal = imagecreatetruecolor($largura, $altura);
        //            if ($tipo == "image/jpg"){
        //                $imageOriginal = imagecreatefromjpeg($destino.$nomeFoto);
        //            } elseif ($tipo == "image/jpeg") {
        //                $imageOriginal = imagecreatefromjpeg($destino.$nomeFoto);
        //            } elseif ($tipo == "image/png") {
        //                $imageOriginal = imagecreatefrompng($destino.$nomeFoto);
        //            }
        //            imagecopyresampled($imagemFinal, $imageOriginal, 0, 0, 0, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);
        //            imagejpeg($imagemFinal, $destino.$nomeFoto,80);
        //        }
        //    }
        //}
        //return $nomeFoto;
    }
    
    public function editFoto($id_produto = 0, $mensagem = "") {
        $produtoImagem = new ProdutosImagens();
        $dados = array();
        
        $produto_info = array();
        $produto_info['id'] = $id_produto;
        $produto_info['mensagem'] = $mensagem;
        $produto_info['imagens'] = $produtoImagem->selecionarProdutosImagensIDProduto($id_produto);
        $dados['produto_info'] = $produto_info;
        //echo ("<pre>");
        //print_r($dados);
        //echo ("</pre>");
        
        $this->loadViewInAdminLTE('editfoto', $dados);
    }
    
    public function addFotoIFrame() {
        $prdImagens = new ProdutosImagens();
        //$prd = new produtoController();
        $mensagem = "Nao foi possivel inserir a Foto!";
        
        if (isset($_POST['id_produto']) && !empty($_POST['id_produto'])){
            $id_produto = addslashes($_POST['id_produto']);
            $fotos = ((isset($_FILES['fotos']))?$_FILES['fotos']:array());
            //if (isset($_FILES['fotos'])) {
            //    $fotos = $_FILES['fotos'];
            //} else {
            //    $fotos = array();
            //}
            
            if (count($fotos) > 0){
                $urlArray = $this->adicionarFoto($fotos);
                //print_r($urlArray);
                if (count($urlArray) > 0){
                    foreach ($urlArray as $url) {
                        //echo $url;
                        $prdImagens->incluirProdutosImagens($id_produto, $url);
                    }
                    $mensagem = "Foto Inserida com Sucesso!";
                    $this->editFoto($id_produto, $mensagem);
                    //$prd->editProduto($id_produto, $mensagem);
                    //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/fotoADD");
                } else {
                    $this->editFoto($id_produto, $mensagem);
                    //$prd->editProduto($id_produto, $mensagem);
                    //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/fotoERROR");
                }
            } else {
                $this->editFoto($id_produto, $mensagem);
                //$prd->editProduto($id_produto, $mensagem);
                //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/fotoERROR");
            }
        }
    }
    
    public function delFotoIFrame($id_imagem = 0) {
        //$prd = new produtoController();
        $mensagem = "A foto não pode ser Deletada!";
        
        $id_produto = $this->excluirFoto($id_imagem);
        if (!is_null($id_produto)){
            $mensagem = "A foto foi deletada com Sucesso!";
            $this->editFoto($id_produto, $mensagem);
            //$prd->editProduto($id_produto, $mensagem);
            //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/fotoDEL");
        } else {
            $this->editFoto($id_produto, $mensagem);
            //$prd->editProduto($id_produto, $mensagem);
            //header("Location: ".BASE_URL."produto/editProduto/".$id_produto."/fotoERROR");
        }
    }
}
