
<div class="container-fluid">
    <h1 class="h1">Produtos</h1>
    
    <?php if ( $confirme == "excluir" ) :?>
            <div class="alert-success">
                <strong>Produto Excluido!</strong>
            </div>
    <?php endif; ?>
    <form action="<?php echo BASE_URL; ?>produto/addProduto/" method="POST">
        <input type="submit" class="btn-default" value="Adicionar Produto">
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nome</th>
                <th>Descricao</th>
                <th>Estoque</th>
                <th>Valor</th>
                <th>Acoes</th>
            </tr>
        </thead>
        <?php foreach ($produtos as $produto): ?>
        
        <tr class="produto_item">
            <td class="produto_imagem" width="40%">
                <img src="<?php echo BASE_URL;?>media/produtos/<?php echo ($produto['imagens'][0]['url']); ?>" width="40%">
            </td>
            <td class="produto_nome">
                <a href="<?php echo BASE_URL; ?>produto/editProduto/<?php echo($produto['id']); ?>">
                    <?php echo utf8_encode($produto['nome']); ?>
                </a>
            </td>
            <td class="produto_marca"><?php echo utf8_encode($produto['descricao']); ?></td>
            <td class="produto_estoque"><?php echo ($produto['estoque']); ?></td>
            <td class="produto_preco"><?php echo (number_format($produto['preco'],2)); ?></td>
            <td class="produto_acao">
                <a href="<?php echo BASE_URL; ?>produto/editProduto/<?php echo($produto['id']); ?>" class="btn btn-info">
                    Editar
                </a>
                <a href="<?php echo BASE_URL; ?>produto/delProduto/<?php echo($produto['id']); ?>" class="btn btn-danger">
                    Excluir
                </a>
            </td>
        </tr>
        
        <?php endforeach;?>
    </table>
    <ul class="pagination">
        <?php for($q=1;$q<=$numeroPaginas;$q++):?>
        <li class="<?php if ($paginaAtual == $q) {echo "active"; } ?>">
        
            <a href="<?php echo BASE_URL;?>painel/produtos/pag/<?php 
            $pag_array = $_GET;
            unset($pag_array['q']);
            echo ($q."?". http_build_query($pag_array) ); 
            ?>">
            <?php echo $q; ?>
            </a>
        </li>
        <?php endfor; ?>
    </ul>
    <!--<br><pre><?php print_r($produtos); ?></pre>-->
    <br>
    <br>
    <br>
</div>
