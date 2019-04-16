<script>
    function enviarFormulario() {
        var valor = document.getElementById('preco');
        var preco = converteMoedaFloat(valor.value);
        valor.value = preco;
        return true;
    }
</script>
<div class="container-fluid">
    <div class="navbar topnav">
        <h1 class="h1">Adicionar Produto</h1>
    </div>
    <?php if ( $confirme == "error") :?>
            <div class="alert-warning">
                <label>Preencha todos os Campos</label>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "sucess") :?>
            <div class="alert-success">
                <strong>Parabens Produto Cadastrado!</strong>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "successDEL") :?>
            <div class="alert-success">
                <strong>Produto Deletado com Sucesso!</strong>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "errorDEL") :?>
            <div class="alert-warning">
                <label>Error ao Deletar o Produto!</label>
            </div>
    <?php endif; ?>
    <form id="formulario" action="<?php echo BASE_URL; ?>produto/sisAddProduto/" method="POST" onsubmit="return enviarFormulario()" enctype="multpart/form-data">
        <div class="form-group">
            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria" class="form-control" required>
            <?php foreach ($cats as $cat): ?>
                <option value="<?php echo($cat['id']); ?>" > 
                    <?php echo utf8_encode($cat['nome']); ?> 
                </option>
            <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <label for="marca">Marca:</label>
            <select name="marca" id="categoria" class="form-control" required>
            <?php foreach ($marcas as $marca): ?>
                <option value="<?php echo($marca['id']); ?>" > 
                    <?php echo utf8_encode($marca['nome']); ?> 
                </option>
            <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" value="" required/>
        </div>
        <div class="form-group">
            <label for="descricao">Descricao:</label>
            <textarea name="descricao" id="descricao" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="estoque">Estoque:</label>
            <button type="button" onclick="javascript:retirar()">-</button>
            <input type="text" id="qtd" name="qtd" disabled value="0" class="form-control-static">
            <button type="button" onclick="javascript:estocar()">+</button>
        </div>
        <div class="form-group">
            <label for="preco">Preco:</label>
            <input type="text" name="preco" id="preco" class="form-control" value="" maxlength="10" onKeyUp="formatarMoeda();" required/>
        </div>
        
        <input type="hidden" id="usuario" name="usuario" value="<?php echo($_SESSION['id']); ?>" />
        <input type="hidden" id="estoque" name="estoque" value="0">
        <input type="submit" id="botaoEnviarForm" value="ADICIONAR" class=" btn btn-default"/>
        <a href="<?php echo BASE_URL; ?>painel/produtos/" class="btn btn-default">VOLTAR</a>
    </form>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
</div>
