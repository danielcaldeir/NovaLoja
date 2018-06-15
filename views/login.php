        <div class="container-fluid">
            <nav class="navbar topnav">
                <h2 class="logo">Página de Login!!</h2>
            </nav>
            <?php if (!empty($error)) :?>
            <div class="alert-warning">
                <label>E-mail ou Senha Invalido!</label>
            </div>
            <?php endif; ?>
            <?php if (!empty($habilitado)) :?>
            <div class="alert-warning">
                <label>Usuário Desabilitado ou E-mail Invalido!</label>
            </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-lg-6 logo">
            <form action="<?php echo BASE_URL; ?>login/logar/" method="POST">
                E-Mail:
                <input class="item" type="text" name="email" value=""><br>
                Senha:
                <input class="item" type="password" name="senha" value=""><br>
                <input class="button" type="submit" id="botaoEnviarForm" value="Entrar">
            </form>
            <a href="<?php echo BASE_URL; ?>login/esqueciSenha/">Esqueceu a senha!</a><br>
        <!--    <a href="<?php echo BASE_URL; ?>cadastrar/gerenciaUsuario/">Gerenciamento de Usuarios</a>-->
                </div>
                <div class="col-lg-6 logo">
                    <h2>Ainda não tem cadastro!</h2>
                    <h4 class="text-justify">Para comprar em nosso site é preciso realizar um cadastro.</h4>
                    <form action="<?php echo(BASE_URL);?>login/cadastrar" method="POST">
                        <input type="submit" id="cadastrar" class="button" value="Cadastrar"/>
                    </form>
                </div>
            </div>
        </div>
