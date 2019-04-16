<?php
$id = intval($produto_info['id']);
$qtd = 1;
$preco = floatval($produto_info['preco']);
$imagens_value = implode(',', $produto_info['imagens'][0]);
$imagens_key = implode(',', array_keys($produto_info['imagens'][0]));
$nome_prd = $produto_info['nome'];
if (!empty($_SESSION['cart'][$id] ) ){
    foreach ($_SESSION['cart'] as $id_cart => $item) {
        if ($id_cart == $id){
            $qtd = intval($item['qtd']);
        }
    }
}
?>
<div class="row">
    <div class="col-sm-5">
        <div class="mainphoto">
            <img src="<?php echo BASE_URL;?>media/produtos/<?php echo ($produto_info['imagens'][0]['url']); ?>" />
        </div>
        <div class="gallery">
            <?php foreach ($produto_info['imagens'] as $img) :?>
            <div class="photo_item">
                <img src="<?php echo BASE_URL;?>media/produtos/<?php echo ($img['url']); ?>" />
            </div>
            <?php endforeach;?>
        </div>
        Fotos
        
    </div>
    <div class="col-sm-7">
        <h2><?php echo($produto_info['nome'] );?></h2>
        <small><?php echo($produto_info['marca_nome']);?></small><br/>
        
        <?php if ($produto_info['avalia']!= 0) :?>
            <?php for ($q=0; $q<intval($produto_info['avalia']) ;$q++) :?>
            <img src="<?php echo (BASE_URL); ?>assets/images/star.png" height="13" boder="0"/>
            <?php endfor;?>
        <?php endif;?>
        <hr/>
        <p><?php echo utf8_encode($produto_info['descricao']); ?></p>
        <hr/>
        De: <span class="price_from">R$ <?php echo number_format($produto_info['preco_ant'], 2); ?></span><br/>
        Por: <span class="original_price">R$ <?php echo number_format($produto_info['preco'], 2); ?></span>
        
        <form method="POST" class="addtocartform" action="<?php echo(BASE_URL);?>cart/add">
            <input type="hidden" id="id_prd" name="id_prd" value="<?php echo($id);?>" />
            <input type="hidden" id="qtd_prd" name="qtd_prd" value="<?php echo($qtd);?>"/>
            <input type="hidden" id="preco" name="preco" value="<?php echo($preco);?>"/>
            <input type="hidden" id="imagens_value" name="imagens_value" value="<?php echo($imagens_value);?>"/>
            <input type="hidden" id="imagens_key" name="imagens_key" value="<?php echo($imagens_key);?>"/>
            <input type="hidden" id="nome_prd" name="nome_prd" value="<?php echo($nome_prd);?>"/>
            <button onclick="decrementar();">-</button>
            <input type="text" id="qtd" name="qtd" disabled value="<?php echo($qtd);?>" class="addtocart_qt">
            <button onclick="incrementar();">+</button>
            <input type="submit" value="<?php $this->lang->get('ADD_TO_CART')?>" class="addtocart_submit">
        </form>
    </div>
</div>
<hr/>
<div class="row">
    <div class="col-sm-5">
        <h3><?php $this->lang->get('PRODUCT_SPECIFICATIONS');?></h3>
        <?php foreach ($produto_info['opcoes'] as $opcoes) :?>
        <strong><?php echo($opcoes['nomeOpcao']);?></strong>: <?php echo($opcoes['valor']);?><br>
        <?php endforeach;?>
        <?php 
        //echo("<pre>");
        //foreach ($produto_info['opcoes'] as $opcoes) {
        //    print_r($opcoes);
        //}
        //echo("</pre>");
        ?>
    </div>
    <div class="col-sm-7">
        <h3><?php $this->lang->get('PRODUCT_REVIEWS'); ?></h3>
        <?php foreach ($produto_info['avalia'] as $avalia) :?>
            <strong><?php echo($avalia['nomeUser']);?></strong>
            <?php for($q=0;$q< intval($avalia['voto']);$q++):?>
            <img src="<?php echo BASE_URL; ?>assets/images/star.png" border="0" height="13" />
            <?php endfor;?>
            <br/>
            <q><?php echo($avalia['comentario']);?></q>
            <hr/>
        <?php endforeach;?>
        <?php 
        //echo("<pre>");
        //foreach ($produto_info['avalia'] as $avalia) {
        //    print_r($avalia);
        //}
        //echo("</pre>");
        ?>
    </div>
</div>