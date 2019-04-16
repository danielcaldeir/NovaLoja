
<div class="container-fluid">
    <div class="navbar topnav">
        <h1 class="h1">Excluir Produto</h1>
    </div>
    
    <?php if ( !empty($id) ) : ?>
    <?php foreach ($produto as $info) :?>
    <form action="<?php echo BASE_URL; ?>produto/sisExcluirProduto/" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Tem certeza que deseja excluir esse Produto?</label>
        </div>
        <div class="form-group">
            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria" class="form-control" disabled>
            <?php foreach ($cats as $cat): ?>
                <option value="<?php echo($cat['id']); ?>" <?php if($info['id_categoria']==$cat['id']): echo('selected'); endif;?>> 
                    <?php echo utf8_encode($cat['nome']); ?> 
                </option>
            <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <label for="marca">Marca:</label>
            <select name="marca" id="categoria" class="form-control" disabled>
            <?php foreach ($marcas as $marca): ?>
                <option value="<?php echo($marca['id']); ?>" <?php if($info['id_marca']==$marca['id']): echo('selected'); endif;?>> 
                    <?php echo utf8_encode($marca['nome']); ?> 
                </option>
            <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?php echo utf8_encode($info['nome']); ?>" disabled/>
        </div>
        <div class="form-group">
            <label for="descricao">Descricao:</label>
            <textarea name="descricao" id="descricao" class="form-control" disabled><?php echo utf8_encode($info['descricao']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="estoque">Estoque:</label>
            <input type="text" id="qtd" name="qtd" disabled value="<?php echo($info['estoque']);?>" class="form-control-static">
        </div>
        <div class="form-group">
            <label for="precoAnt">Preco Anterior:</label>
            <input type="text" id="preco_Ant" name="preco_Ant" disabled value="<?php echo (number_format($info['preco_ant'],2,",",".")); ?>" class="form-control-static"/>
        </div>
        <div class="form-group">
            <label for="preco">Preco:</label>
            <input type="text" name="preco" id="preco" class="form-control" value="<?php echo(number_format($info['preco'], 2,",",".")); ?>" maxlength="10" onKeyUp="formatarMoeda();" disabled/>
        </div>
        
        <input type="hidden" id="id" name="id" value="<?php echo($info['id']); ?>"/>
        <input type="hidden" id="usuario" name="usuario" value="<?php echo($_SESSION['id']); ?>" />
        <input type="submit" id="botaoEnviarForm" value="SIM" class="btn btn-danger"/> | 
        <a href="<?php echo BASE_URL; ?>painel/produtos/" class="btn btn-default">NAO</a>
    </form>
    <?php endforeach; ?>
    <?php else : ?>
    <form action="<?php echo BASE_URL; ?>produto/meusAnuncios/" method="GET">
        <div class="form-group">
            <label>Não foi informado um identificador.</label>
        </div>
        <input type="submit" class="btn btn-default" value="VOLTAR"/>
    </form>
    
    <?php endif; ?>
    
</div>
