
<div class="container-fluid">
    <div class="navbar topnav">
        <h2 class="logo">Esqueci Senha</h2>
    </div>
    <?php if (isset($_GET['sucess']) && !empty($_GET['sucess'])) :?>
            <div class="alert-success">
                <strong>Parabens E-Mail Encontrado!</strong>
                <a href="<?php echo($_GET['link']);?>&token=<?php echo($_GET['token']);?>">
                    Acesse o Link para Realizar o cadastro de uma nova senha.
                </a>
            </div>
    <?php endif; ?>
    <?php if ( !empty($error) ) :?>
            <div class="alert-warning">
                <label>Informe um E-Mail valido!</label>
            </div>
    <?php endif; ?>
    <form action="<?php echo BASE_URL; ?>login/sisEsqueciSenha/" method="POST">
        <div class="form-group">
            <label>Qual seu e-mail?</label>
            <input type="email" name="email" value="@" class="form-control"/><br/>
        </div>
        <input type="submit" value="Enviar" id="botaoEsqSenha" class="button"/>
    </form>
</div>
