<h1>Checkout Boleto</h1>
<!--
<!--    <pre>
<!--        <?php print_r($_SESSION); ?>
<!--    </pre>
<!--    
<!--    <form method="POST" action="<?php echo(BASE_URL);?>cart/excluirSession">
<!--        <input type="submit" value="ExcluirSession"/>
<!--    </form>
-->
<br/>
<br/>
<?php if (!empty($error)) :?>
    <div class="alert-warning">
        <label><?php echo($msg);?></label>
    </div>
<?php endif; ?>
<form action="<?php echo(BASE_URL);?>pagamento/checkoutBoleto" method="POST">
<div class="pagamentoArea">
    <strong>Nome:</strong><br/>
    <input type="text" id="name" name="name" value="<?php echo($usuario['nome']);?>" /><br/><br/>

    <strong>CPF:</strong><br/>
    <input type="text" id="cpf" name="cpf" value="05347965401" /><br/><br/>

    <strong>Telefone:</strong><br/>
    <input type="text" id="telefone" name="telefone" value="<?php echo($usuario['telefone']);?>" /><br/><br/>

    <strong>E-mail:</strong><br/>
    <input type="email" id="email" name="email" value="<?php echo($usuario['email']);?>" /><br/><br/>

    <strong>Senha:</strong><br/>
    <input type="text" id="pass" name="pass" value="<?php echo($usuario['senha']);?>" /><br/><br/>

    
<div class="informacoesEND">
    <h3>Informações de Endereço</h3>
    
    <strong>CEP:</strong><br/>
    <input type="text" id="cep" name="cep" value="<?php echo($frete['cep']); ?>" /><br/><br/>

    <strong>Rua:</strong><br/>
    <input type="text" id="rua" name="rua" value="<?php echo($frete['end']); ?>" /><br/><br/>

    <strong>Número:</strong><br/>
    <input type="text" id="numero" name="numero" value="1400" /><br/><br/>

    <strong>Complemento:</strong><br/>
    <input type="text" id="complemento" name="complemento" /><br/><br/>

    <strong>Bairro:</strong><br/>
    <input type="text" id="bairro" name="bairro" value="<?php echo($frete['bairro']); ?>" /><br/><br/>

    <strong>Cidade:</strong><br/>
    <input type="text" id="cidade" name="cidade" value="<?php echo($frete['cidade']); ?>" /><br/><br/>

    <strong>Estado:</strong><br/>
    <input type="text" id="estado" name="estado" value="<?php echo($frete['uf']); ?>" /><br/><br/>
</div>
    
<div class="informacoesPAG">

</div>
    
    <input type="hidden" id="total" name="total" value="<?php echo $total; ?>" />
    <input type="submit" id="efetuarCompra" class="button efetuarCompra" value="Efetuar Compra"/>
    
    <!--<button id="efetuarCompra" class="button efetuarCompra">Efetuar Compra</button>-->
    
</div>
</form>


<br/>
<!--<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>-->
<!--<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/pagseguro.directpayment.js"></script>-->
<!--<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/pagamento.js"></script>-->
<!--<script type="text/javascript">PagSeguroDirectPayment.setSessionId("<?php echo $sessionCode; ?>");</script>-->

