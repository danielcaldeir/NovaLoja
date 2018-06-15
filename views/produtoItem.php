<?php 
        $pag_array = $_GET;
        unset($pag_array['q']);
        $href = BASE_URL."produto/abrir/".$id."?".http_build_query($pag_array);
?>
<div class="produto_item">
    <a href="<?php echo ($href);?>">
        <div class="produto_tags">
            <?php if ($promo == 1): ?>
            <div class="produto_tag produto_tag_vermelho"><?php $this->lang->get('SALE'); ?></div>
            <?php endif; ?>
            <?php if($top_vendido == 1): ?>
            <div class="produto_tag produto_tag_verde"><?php $this->lang->get('BESTSELLER'); ?></div>
            <?php endif; ?>
            <?php if($novo_produto == 1): ?>
            <div class="produto_tag produto_tag_azul"><?php $this->lang->get('NEW'); ?></div>
            <?php endif; ?>
        </div>
        <div class="produto_imagem">
            <img src="<?php echo BASE_URL;?>media/produtos/<?php echo ($imagens[0]['url']); ?>" width="100%">
        </div>
        <div class="produto_nome"><?php echo ($nome); ?></div>
        <div class="produto_marca"><?php echo ($marca_nome); ?></div>
        <?php if($preco_ant != '0') : ?>
        <div class="produto_preco_ant">R$ <?php echo number_format($preco_ant,2,',','.'); ?></div>
        <?php endif; ?>
        <div class="produto_preco">R$ <?php echo number_format($preco,2,',','.'); ?></div>
    </a>
    <div class="clear: both"></div>
</div>