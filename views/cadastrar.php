<div class="container-fluid">
    <div class="navbar topnav">
        <h2 class="logo">Cadastrar</h2>
    </div>
    <?php if ( $confirme == "error" ) :?>
            <div class="alert-warning">
                <label>Preencha todos os Campos</label>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "sucess" ) :?>
            <div class="alert-success">
                <strong>Parabens Cadastro Realizado!</strong>
                <a href="<?php echo($link); ?>">
                    Acesse o Link para confirmar o cadastro.
                </a>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "existe" ) :?>
            <div class="alert-warning">
                <label>Este usuario ja existe!</label><br/>
                <a href="<?php echo BASE_URL; ?>login/">Faca o login.</a>
            </div>
    <?php else :?>
    <form action="<?php echo BASE_URL; ?>login/addUser" method="POST">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="email">E-Mail:</label>
            <input type="email" name="email" id="email" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" name="senha" id="senha" class="form-control"/>
        </div>
        <div class="form-group">
            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" id="telefone" class="form-control"/>
        </div>
        <input type="submit" id="botaoEnviarForm" value="Cadastrar" class="button"/>
    </form>
    <?php endif; ?>
    
    <br/>
    <br/>
    <br/>
    <br/>
</div>