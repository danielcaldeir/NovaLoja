<h1 class="logo">Carrinho de Compras</h1>
<!--
<!--    <pre>
<!--        <?php print_r($_SESSION); ?>
<!--    </pre>
<!--    
<!--    <form method="POST" action="<?php echo(BASE_URL);?>cart/excluirSession">
<!--        <input type="submit" value="ExcluirSession"/>
<!--    </form>
<!--    
<!--    <pre>
<!--        <?php print_r($produtos); ?>
<!--    </pre>
-->
<?php if (count($produtos) == 0) :?>
<div class="row">
    <div class="center-block col-sm-6">
        <div class="center-block cart-empty">
            <strong>Seu carrinho está vazio!</strong>
            <strong>Acesse a <a href="<?php echo (BASE_URL);?>">Página Inicial</a> e escolha o seu produto.</strong>
        </div>
    </div>
    <div class="center-block col-sm-6">
        
    </div>
</div>
<?php else :?>
    <?php if ( $error ) :?>
            <div class="alert-warning">
                <label>CEP não digitado ou CEP invalido</label>
            </div>
    <?php endif; ?>
<table border="1" width="100%">
    <thead>
        <tr>
            <th width="80">Imagem</th>
            <th>Nome</th>
            <th width="80" class="cart_qt">QTD</th>
            <th width="150">Preço</th>
            <th width="150">Sub Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
<?php if (count($produtos) > 0) : ?>
    <?php $subTotal = 0; ?>
    <?php $subTotalItem = 0; ?>
    <?php $qtd = 0; ?>
    <?php $total = 0; ?>
    <?php foreach ($produtos as $produto_item) : ?>
        <?php $qtd += intval($produto_item['qtd']); ?>
        <?php $subTotalItem = ( intval($produto_item['qtd']) * floatval($produto_item['preco']) )?>
        <?php $subTotal += ( intval($produto_item['qtd']) * floatval($produto_item['preco']) ); ?>
        <tr>
            <td>
                <img src="<?php echo BASE_URL;?>media/produtos/<?php echo($produto_item['imagens'][0]['url']);?>" width="50"/>
            </td>
            <td><?php echo($produto_item['nome']);?></td>
            <td><div class="cart_qt">
                <a href="<?php echo BASE_URL; ?>cart/decrementar/<?php echo $produto_item['id']; ?>">-</a>
                <input name="qtd" value="<?php echo($produto_item['qtd']);?>" class="cart_qt" disabled/>
                <a href="<?php echo BASE_URL; ?>cart/incrementar/<?php echo $produto_item['id']; ?>">+</a>
                </div>
            </td>
            <td>R$ <?php echo number_format($produto_item['preco'],2,',','.'); ?></td>
            <td>R$ <?php echo number_format($subTotalItem,2,',','.'); ?></td>
            <td>
                <a href="<?php echo BASE_URL; ?>cart/del/<?php echo $produto_item['id']; ?>">
                    <img src="<?php echo BASE_URL; ?>assets/images/delete.png" width="15"/>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>
        <tr>
            <td colspan="4" align="right">Sub Total</td>
            <td>R$ <?php echo number_format($subTotal,2,',','.'); ?></td>
        </tr>
        <tr>
            <td colspan="4" align="right">Frete</td>
            <?php if (isset($frete['preco'])) :?>
            <td><strong>R$ <?php echo ($frete['preco']);?></strong> (<?php echo $frete['data']; ?> dia<?php echo ($frete['data']=='1')?'':'s'; ?>)</td>
            <?php else :?>
            <td></td>
            <?php endif;?>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td><div class="cart_qt"><?php echo($qtd);?></div></td>
            <td align="right">Total:</td>
            <?php 
            if (isset($frete['preco'])) {
                $freteFinal = floatval(str_replace(',', '.', $frete['preco']));
                $total = $subTotal + $freteFinal;
            } else {
                $total = $subTotal;
            }
            
            ?>
            <td>R$ <?php echo number_format($total,2,',','.'); ?></td>
        </tr>
    </tbody>
</table>

<form method="POST" style="float: right">
    <h4>Qual o seu CEP?</h4>
    <input type="number" name="cep" value="<?php echo($cep);?>"/>
    <input type="submit" value="Calcular"/>
</form>
<br/>
<hr/>
<br/>
<form method="POST" action="<?php echo BASE_URL; ?>cart/pagamento" style="float: right">
    <select name="tipo_pagamento">
        <option value="checkOutTransparente">Pagseguro Checkout Transparente</option>
        <option value="mercadoPago">Mercado Pago</option>
        <option value="boleto">Boleto Bancário</option>
    </select>
    <input type="submit" value="Finalizar Compra" class="button"/>
</form>
<br/>

<?php endif;?>

<br/>

Total de Produtos: <?php echo count($produtos); ?><br/>