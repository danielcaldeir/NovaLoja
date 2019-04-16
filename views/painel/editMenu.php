
<div class="container-fluid">
    <div class="navbar topnav">
        <h2 class="h2">Editar Menu</h2>
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
    
    <?php foreach ($menu as $info) :?>
    <div class="caption">
        <a class="btn btn-default" href="<?php echo(BASE_URL."painel/addMenu/".$info['id']);?>">Adicionar Menu</a>
    </div>
    <form action="<?php echo BASE_URL; ?>painel/sisEditarMenu/" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="Nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?php echo(utf8_encode($info['nome']));?>" required/>
        </div>
        <?php foreach ($sub as $itemSub) :?>
        <div class="form-group">
            <label for="URL">SUB:</label>
            <input type="text" name="texto" id="texto" class="form-control" value="<?php echo($info['sub']." - ".utf8_encode($itemSub['nome'])); ?>" disabled/>
        </div>
        <?php endforeach; ?>
        
        
        <input type="hidden" id="id" name="id" value="<?php echo($info['id']); ?>" />
        <input type="hidden" name="sub" id="sub" value="<?php echo($info['sub']); ?>" />
        <input type="submit" id="botaoEnviarForm" value="SALVAR" class="btn btn-success" /> | 
        <a href="<?php echo BASE_URL; ?>painel/menus/" class="btn btn-default">VOLTAR</a>
    </form>
    
    <!--<pre><?php print_r($arvore); ?></pre>-->
    
        <?php foreach ($arvore as $item) :?>
            <?php if ($item['id'] != $info['id']) :?>
            <div class="form-group">
                <label for="Tipo">Tipo:</label>
                <a href="<?php echo(BASE_URL."painel/editMenu/".$item['id']);?>"><?php echo(utf8_encode($item['nome'])); ?></a>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    
    <?php endforeach; ?>
    <br/>
    <!--<pre><?php print_r($sub); ?></pre>-->
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
