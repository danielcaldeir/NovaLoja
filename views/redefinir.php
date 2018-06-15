
<div class="container">
    <div class="jumbotron">
        <label>Redefinir Senha</label>
    </div>
    <?php if ( !empty($senha) ) :?>
            <div class="alert-warning">
                <label>Informe uma senha Valida!!</label>
            </div>
    <?php endif; ?>
    <?php if ( !empty($error) ) :?>
            <div class="alert-warning">
                <label>Token inválido ou usado!!</label>
            </div>
    <?php endif; ?>
    <?php if ( !empty($sucess) ) :?>
            <div class="alert-success">
                <strong>Parabens Senha Alterada com Sucesso!</strong>
                <a href="<?php echo(BASE_URL); ?>login/">Voltar a pagina de login</a>
            </div>
    <?php endif; ?>
    <?php if ( !empty($redefinir) ) :?>
            <div class="alert-success">
                <strong>Parabens E-Mail Encontrado!</strong>
            </div>
    <?php endif; ?>
    <form action="<?php echo($link); ?>" method="POST">
        <div class="form-group">
            <label>Digite a nova senha:</label>
            <input type="password" name="senha" id="senha" class="form-control"/><br/>
        </div>
        <input type="hidden" name="token" value="<?php echo($token); ?>"/>
        <input type="submit" value="Mudar senha" class="btn-default"/>
    </form>
</div>
