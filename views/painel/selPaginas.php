<div>
        <?php echo("Bom Dia ".$nome);  ?>
        <br>
        <?php echo($this->config['painel_welcome']);?>
        <br><br>
        <h1 class="h1">Paginas</h1>
        <a href="<?php echo(BASE_URL."painel/addPagina");?>" class="home_cta_button">Adicionar Pagina</a>
        <table width="100%" border="1">
            <tr>
                <th>ID</th>
                <th>URL</th>
                <th>Titulo</th>
                <th class="text-center">Ações</th>
            </tr>
            <?php foreach ($paginas as $itemPag): ?>
            <tr>
                <td><?php echo($itemPag['id']); ?></td>
                <td><?php echo($itemPag['url'] );?></td>
                <td><?php echo (utf8_encode($itemPag['titulo'])); ?></td>
                <td class="text-center">
                    <a class="home_cta_button" href="<?php echo(BASE_URL."painel/editPagina/".$itemPag['id']); ?>">Editar Pagina</a> 
                    <a class="home_cta_button" href="<?php echo(BASE_URL."painel/excluirPagina/".$itemPag['id']); ?>">Excluir Pagina</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
</div>
        
