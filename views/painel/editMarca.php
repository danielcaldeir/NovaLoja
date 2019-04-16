
<div class="container-fluid">
    <div class="navbar topnav">
        <h2 class="h2">Editar Marca</h2>
    </div>
    
    
    <?php if ( $confirme == "error") :?>
            <div class="alert-warning">
                <label>Preencha todos os Campos</label>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "sucess" ) :?>
            <div class="alert-success">
                <strong>Registro Editado com Sucesso!</strong>
            </div>
    <?php endif; ?>
    <?php if ( !empty($id) ) : ?>
    
    <?php foreach ($marca as $info) :?>
        <form action="<?php echo BASE_URL; ?>painel/sisEditarMenu/" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="Nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" value="<?php echo(utf8_encode($info['nome']));?>" required/>
            </div>
            <input type="hidden" id="id" name="id" value="<?php echo($info['id']); ?>" />
            <input type="submit" id="botaoEnviarForm" value="SALVAR" class="btn btn-success" /> | 
            <a href="<?php echo BASE_URL; ?>painel/marcas/" class="btn btn-default">VOLTAR</a>
        </form>
    <?php endforeach; ?>
    <br/>
    <br/>
    <br/>
    <br/>
    <?php else : ?>
    <form action="<?php echo BASE_URL; ?>painel/menus/" method="POST">
        <div class="form-group">
            <label>Não foi informado um identificador.</label>
        </div>
        <input type="submit" class="button" value="VOLTAR"/>
    </form>
    
    <?php endif; ?>
    
</div>
