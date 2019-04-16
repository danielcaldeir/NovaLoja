<div>
    <?php echo("Bom Dia ".$nome);  ?>
    <br/><br/>
    <div class="navbar topnav">
        <h1 class="h1">Marcas</h1>
    </div>
    <div>
        <!--<a href="<?php echo(BASE_URL."categorias/addMarca");?>" class="home_cta_button">Adicionar Marca</a>-->
        <a href="#AddMarca" class="btn btn-default" data-toggle="collapse">Adicionar Marca</a>
    </div>
    <div id="AddMarca" class="collapse panel-collapse">
        <div class="navbar topnav">
            <h3 class="h3">Cadastrar Marca</h3>
        </div>
        <form action="<?php echo BASE_URL; ?>categorias/sisAddMarca" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" required/>
            </div>
            <input type="submit" id="botaoEnviarForm" value="Adicionar" class="btn btn-success" />
            <a href="#AddMarca" class="btn btn-default" data-toggle="collapse">FECHAR</a>
        </form>
    </div>
        
        <table class="table table-bordered" width="100%">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th class="text-center">Ações</th>
            </tr>
            <?php foreach ($marcas as $marca): ?>
            <tr>
                <td><?php echo($marca['id']); ?></td>
                <td class="text-uppercase">
                    <a href="<?php echo BASE_URL; ?>categorias/editMarca/<?php echo($marca['id']); ?>">
                        <?php echo (utf8_encode($marca['nome'])); ?>
                    </a>
                </td>
                <td class="text-center">
                    <a class="btn btn-info" href="<?php echo(BASE_URL."categorias/editMarca/".$marca['id']); ?>">Editar Marca</a> 
                    <a class="btn btn-danger" href="<?php echo(BASE_URL."categorias/delMarca/".$marca['id']); ?>">Excluir Marca</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
</div>

