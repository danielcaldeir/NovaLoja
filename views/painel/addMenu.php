<div class="container-fluid">
    <div class="navbar topnav">
        <h2 class="h2">Cadastrar Menu</h2>
    </div>
    <?php if ( $confirme == "error" ) :?>
            <div class="alert-warning">
                <label>Preencha todos os Campos</label>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "success" ) :?>
            <div class="alert-success">
                <label>Registro inserido com sucesso</label>
                <a href="<?php echo(BASE_URL."painel/menus"); ?>">
                    Acesse o Link para visualizar.
                </a>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "existe" ) :?>
            <div class="alert-warning">
                <label>Este registro ja existe!</label><br/>
                <a href="<?php echo BASE_URL; ?>painel/menus">Acesse o Menu.</a>
            </div>
    <?php else :?>
    <form action="<?php echo BASE_URL; ?>painel/sisAddMenu" method="POST">
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" required/>
        </div>
        <?php foreach ($subArray as $itemSub) :?>
        <div class="form-group">
            <label for="email">SUB:</label>
            <input type="text" name="texto" id="texto" value="<?php echo($sub ." - ". utf8_encode($itemSub['nome'])); ?>" disabled class="form-control"/>
        </div>
        <?php endforeach; ?>
        <input type="hidden" name="sub" id="sub" value="<?php echo($sub); ?>" />
        <input type="submit" id="botaoEnviarForm" value="Adicionar" class="btn btn-success" />
        <a href="<?php echo BASE_URL; ?>painel/menus/" class="btn btn-default">VOLTAR</a>
    </form>
    <!--<pre><?php print_r($subArray)?></pre>-->
    <?php endif; ?>
    
    <br/>
    <br/>
    <br/>
    <br/>
</div>