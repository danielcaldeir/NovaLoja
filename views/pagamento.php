<h1>Checkout Transparente - Pagseguro</h1>
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
<div class="pagamentoArea">
    <strong>Nome:</strong><br/>
    <input type="text" id="nome" name="nome" value="Bonieky Lacerda Leal" /><br/><br/>

    <strong>CPF:</strong><br/>
    <input type="text" id="cpf" name="cpf" value="05347965401" /><br/><br/>

    <strong>Telefone:</strong><br/>
    <input type="text" id="telefone" name="telefone" value="1111111111" /><br/><br/>

    <strong>E-mail:</strong><br/>
    <input type="email" id="email" name="email" value="c14608151909675355288@sandbox.pagseguro.com.br" /><br/><br/>

    <strong>Senha:</strong><br/>
    <input type="password" id="password" name="password" value="20g0531cUe55804D" /><br/><br/>

    
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
    <h3>Informações de Pagamento</h3>
    <strong>Titular do cartão:</strong><br/>
    <input type="text" id="cartao_titular" name="cartao_titular" value="Bonieky Lacerda Leal" /><br/><br/>

    <strong>CPF do Titular do cartão:</strong><br/>
    <input type="text" id="cartao_cpf" name="cartao_cpf" value="05347965401" /><br/><br/>

    <strong>Número do cartão:</strong><br/>
    <input type="text" id="cartao_numero" name="cartao_numero" value=""/><br/><br/>

    <strong>Código de Segurança:</strong><br/>
    <input type="text" id="cartao_cvv" name="cartao_cvv" value="" /><br/><br/>

    <strong>Validade:</strong><br/>
    <select id="cartao_mes" name="cartao_mes">
            <?php for($q=1;$q<=12;$q++): ?>
        <option value="<?php echo($q);?>"><?php echo ($q<10)?'0'.$q:$q; ?></option>
            <?php endfor; ?>
    </select>
    <select id="cartao_ano" name="cartao_ano">
            <?php $ano = intval(date('Y')); ?>
            <?php for($q=$ano;$q<=($ano+20);$q++): ?>
        <option value="<?php echo($q);?>"><?php echo $q; ?></option>
            <?php endfor; ?>
    </select><br/><br/>
    <strong>Parcelas:</strong><br/>
    <select id="parc" name="parc"></select><br/><br/>
</div>
    
    <input type="hidden" id="total" name="total" value="<?php echo $total; ?>" />
    
    <button id="efetuarCompra" class="button efetuarCompra">Efetuar Compra</button>
    
</div>



<br/>
<!--<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>-->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/pagseguro.directpayment.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/pagamento.js"></script>
<script type="text/javascript">
PagSeguroDirectPayment.setSessionId("<?php echo $sessionCode; ?>");
</script>

