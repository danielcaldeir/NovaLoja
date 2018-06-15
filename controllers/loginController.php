<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loginController
 *
 * @author Daniel_Caldeira
 */
class loginController extends controller{
    private function isTelefoneNull($telefone) {
        if(is_null($telefone)){
            $tel = "";
        } else {
            $tel = $telefone;
        }
        return $tel;
    }
    
    private function cadastrarUser($nome, $email, $senha, $telefone) {
        $user = new Usuarios();
        //$user->selecionarUsuariosEmail($email);
        $dados = array();
        //if ($user->numRows() == 0){
            $user->setNome($nome);
            $user->setEmail($email);
            $user->setSenha($senha);
            $tel = $this->isTelefoneNull($telefone);
            $user->setTelefone($tel);
            $array = $user->incluirUsuariosNomeEmailSenha();
            
            $id = $array['ID'];
            $md5 = md5($id);
            $link = BASE_URL."cadastrar/confirmarEmail/".$md5;
            
            $assunto = "Confirme seu cadastro";
            $msg = "Clique no Link abaixo para confirmar seu cadastro:\n\n".$link;
            $headers = "From: suporte@b7web.com.br"."\r\n"."X-Mailer: PHP/".phpversion();
            
            
            $dados["confirme"] = "sucess";
            $dados["link"] = $link;
        //} else {
        //    $dados["confirme"] = "existe";
        //}
        return $dados;
    }
    
    //put your code here
    public function index() {
        $filtros = new Filtros();
        //$categorias = new Categorias();
        
        $dados = $filtros->getTemplateDados();
        //$dados['categorias'] = $categorias->ordenarALLCategorias();
        $dados['filtros'] = $filtros->atualizarFiltros();
        $dados['sidebar'] = FALSE;
        
        $this->loadTemplate("login", $dados);
    }
    
    public function cadastrar($confirme = ""){
        $filtros = new Filtros();
        $dados = $filtros->getTemplateDados();
        $dados['sidebar'] = FALSE;
        $dados['confirme'] = $confirme;
        
        $this->loadTemplate("cadastrar", $dados);
    }
    
    public function addUser(){
        $dados = array();
        if (isset($_POST['nome']) && empty($_POST['nome'])==false){
            $nome = addslashes($_POST['nome']);
            $email = addslashes($_POST['email']);
            $senha = addslashes($_POST['senha']);
            $telefone = addslashes($_POST['telefone']);

            if (!empty($nome) && !empty($email) && !empty($senha)){
                $array = Usuarios::selecionarUsuariosEmail($email);
                if (count($array) == 0){
                    $dados = $this->cadastrarUser($nome, $email, $senha, $telefone);
                } else{
                    $dados["confirme"] = "existe";
                }
            } else { 
                $dados["confirme"] = "error";
            }
        } else{ 
            $dados["confirme"] = "error";
        }
        $this->loadTemplate("cadastrar", $dados);
    }
    
    public function redefinir($token = "") {
        if( !empty($_POST['senha']) ) {
            //$token = $_GET['token'];
            
            $userToken = new usuarios_token();
            $userToken->setHash($token);
            $userToken->selecionarToken();
            
            if($userToken->numRows() > 0) {
                
                $result = $userToken->result();
                $id = $result['id_usuario'];
                
                if( !empty($_POST['senha']) ) {
                    $senha = $_POST['senha'];
                    
                    $user = new usuario();
                    $user->setSenha($senha);
                    $user->setID($id);
                    $user->atualizarSenha();
                    
                    $userToken->setHash($token);
                    $userToken->setUsado(1);
                    $userToken->atualizarUsado();
                    
                    //echo "Senha alterada com sucesso!";
                    //header("Location: ../index.php?pag=redefinir&sucess=true");
                    $link = BASE_URL."login/redefinir/".$token;
                    $dados = array();
                    $dados["sucess"] = "true";
                    $dados["link"] = $link;
                    $dados["token"] = $token;
                    
                    $this->loadTemplate("redefinir", $dados);
                    //exit();
                } else {
                    //echo "Informe uma senha valida!";
                    //header("Location: ../index.php?pag=redefinir&senha=true&token=".$token);
                    $link = BASE_URL."login/redefinir/".$token;
                    $dados = array();
                    $dados["senha"] = "true";
                    $dados["token"] = $token;
                    $dados["link"] = $link;
                    
                    $this->loadTemplate("redefinir", $dados);
                    //exit();
                }
            } else {
                //echo "Token inválido ou usado!";
                //header("Location: ../index.php?pag=redefinir&error=true&token=".$token);
                $link = BASE_URL."login/redefinir/".$token;
                $dados = array();
                $dados["error"] = "true";
                $dados["token"] = $token;
                $dados["link"] = $link;
                
                $this->loadTemplate("redefinir", $dados);
                //exit();
            }
        } else {
            //echo "Informe uma senha valida!";
            //header("Location: ../index.php?pag=redefinir&senha=true&token=".$token);
            $link = BASE_URL."login/redefinir/".$token;
            $dados = array();
            $dados["redefinir"] = "true";
            $dados["token"] = $token;
            $dados["link"] = $link;
            
            $this->loadTemplate("redefinir", $dados);
            //exit();
        }
    }
    
    public function esqueciSenha($error = "") {
        $filtros = new Filtros();
        $dados = $filtros->getTemplateDados();
        $dados['sidebar'] = FALSE;
        $dados['error'] = $error;
        
        $this->loadTemplate("esqueciSenha", $dados);
    }
    
    public function sisEsqueciSenha(){
        if(!empty($_POST['email'])) {
            
            $email = $_POST['email'];
            
            $user = new usuario();
            $user->setEmail($email);
            $user->selecionarEmail();
            $token = md5(time().rand(0, 99999).rand(0, 99999));
            $link = BASE_URL."login/redefinir/".$token;
            
            if($user->numRows() > 0) {
                
                $result = $user->result();
                $id = $result['id'];
                //$token = md5(time().rand(0, 99999).rand(0, 99999));
                $expirado_em = date('Y-m-d H:i', strtotime('+2 months'));
                
                $userToken = new usuarios_token();
                $userToken->setIDUsuario($id);
                $userToken->setHash($token);
                $userToken->setExpiradoEm($expirado_em);
                $userToken->incluirUsuariosToken();
                
                //$link = BASE_URL."login/redefinir/".$token;
                
                $mensagem = "Clique no link para redefinir sua senha:<br/>";
                $mensagem = $mensagem . "<a href='".$link."'>link</a>";
                
                $assunto = "Redefinição de senha";
                
                $headers = 'From: seuemail@seusite.com.br'."\r\n" .
                              'X-Mailer: PHP/'.phpversion();
                
                //mail($email, $assunto, $mensagem, $headers);
                
                echo ("<h2>OK! Redefinição de Senha!</h2>");
                echo ("<br>");
                echo ($assunto);
                echo ("<br>");
                echo ("<h2>E-Mail: ".$email."</h2>");
                echo ("<a href=".$link.">Clique aqui para redefinir senha</a>");
                
                echo $mensagem;
                
                $dados = array(
                    "redefinir" => "true",
                    "link" => $link,
                    "token" => $token
                );
                //print_r($dados);
                //$this->loadTemplate("redefinir", $dados);
                header("Location: ".BASE_URL."login/redefinir/".$token);
                //header("Location: ../index.php?pag=esqueciSenha&sucess=true&link=".$link);
                //exit();
            } else {
                $dados = array(
                    "error" => "true",
                    "token" => $token,
                    "link" => $link
                );
                //$this->loadTemplate("esqueciSenha", $dados);
                header("Location: ".BASE_URL."login/esqueciSenha/error/");
            }
        }
    }
    
    private function verificarStatus(Usuarios $user, Filtros $filtros) {
        if ($user->getStatus() == 1){
            $_SESSION['user']['id'] = $user->getID();
            $_SESSION['user']['nome'] = $user->getNome();
            $_SESSION['user']['email'] = $user->getEmail();
            $_SESSION['user']['senha'] = $user->getSenha();
            $_SESSION['user']['status'] = $user->getStatus();
            $_SESSION['user']['telefone'] = $user->getTelefone();
            
            //exit();
            header("Location: ".BASE_URL);
            //$this->loadTemplate("inicial");
        } else {
            //$result = "Usuario desabilitado ou E-Mail Invalido!";
            //header("Location: ".BASE_URL."login/index/true/");
            $dados = $filtros->getTemplateDados();
            $dados['habilitado'] = "true";
            $dados['sidebar'] = FALSE;
            
            $this->loadTemplate("login", $dados);
        }
        
    }
    
    public static function logout() {
        unset($_SESSION['user']);
        $home = new homeController();
        $home->index();
        //exit();
    }
    
    public function logar(){
        $filtros = new Filtros();
        $user = new Usuarios();
        
        if (isset($_POST['email']) && empty($_POST['email'])==false){
            $email = addslashes($_POST['email']);
            $senha = md5(addslashes($_POST['senha']));
            
            $user->selecionarUsuariosEmailSenha($email, $senha);
            if ($user->numRows() > 0){
                //$dado = $user->result();
                $this->verificarStatus($user, $filtros);
            } else {
                //$result = "E-mail ou Senha Invalido!";
                //header("Location: ".BASE_URL."login/index/true/");
                $dados = $filtros->getTemplateDados();
                $dados['error'] = "true";
                $dados['sidebar'] = FALSE;
                
                $this->loadTemplate("login", $dados);
            }
        }
    }
}
