    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tela de Produtos
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."adminLTE/"); ?>"><i class="fa fa-dashboard"></i> home</a></li>
        <li class="active"><a href="<?php echo(BASE_URL."produto/listarProduto"); ?>"><i class="fa fa-archive"></i>produtos</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Grupos de Produtos</h3>
                <div class="box-tools">
                    <a href="<?php echo BASE_URL; ?>opcoes/" class="btn btn-primary">Opcoes</a>
                    <a href="<?php echo BASE_URL; ?>produto/addProduto/" class="btn btn-success">Adicionar</a>
                </div>
            </div>
<!--    <div id="AddProdutos" class="collapse panel-collapse">
<!--        <form action="<?php echo BASE_URL; ?>produto/addAction" method="POST">
<!--            <div class="box">
<!--                <div class="box-header">
<!--                    <div class="box-title">
<!--                        <h3 class="h3">Cadastrar Produto</h3>
<!--                    </div>
<!--                    <div class="box-tools">
<!--                        <input type="submit" id="botaoEnviarForm" value="Adicionar" class="btn btn-success" />
<!--                    </div>
<!--                </div>
<!--                <div class="box-body">
<!--                        <div class="form-group">
<!--                            <label for="nome">Nome:</label>
<!--                            <input type="text" name="nome" id="nome" class="form-control" required/>
<!--                        </div>
<!--                    <a href="#AddProdutos" class="btn btn-default" data-toggle="collapse"><i class="fa fa-sign-out"></i>FECHAR</a>
<!--                </div>
<!--            </div>
<!--        </form>
<!--    </div>
-->
            <div class="box-body">
                <table class="table table-condensed">
                    <tr>
                        <!--<th>Marca</th>-->
                        <th>Categoria</th>
                        <th>Nome</th>
                        <th>Estoque</th>
                        <th>Preço</th>
                        <th width="130">Ações</th>
                    </tr>
                    <?php foreach ($produtos as $key => $item) :?>
                    <tr>    
                        <!--<td><?php echo($item['marca_nome']);?></td>-->
                        <td><?php echo($item['categoria_nome']);?></td>
                        <td>
                            <?php echo($item['nome']);?><br/>
                            <small><?php echo($item['marca_nome']);?></small>
                        </td>
                        <td><?php echo($item['estoque']);?></td>
                        <td>
                            <small><strike>R$ <?php echo number_format($item['preco_ant'], 2, ',', '.');?></strike></small>
                            <br/>R$ <?php echo number_format($item['preco'], 2, ',', '.');?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="<?php echo BASE_URL; ?>produto/editProduto/<?php echo $item['id']; ?>" 
                                   class="btn btn-xs btn-primary">
                                    Editar
                                </a>
                                <?php //if (($item['total_marca'] == 0)): ?>
                                <a href="<?php echo BASE_URL; ?>produto/delProduto/<?php echo $item['id']; ?>" 
                                   class="btn btn-xs btn-danger" <?php //echo(($item['total_marca']!=0)?'disabled':'');?>>
                                    Excluir
                                </a>
                                <?php //endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <ul class="pagination">
                    <?php for($q=1;$q<=$numeroPaginas;$q++):?>
                    <li class="<?php if ($paginaAtual == $q) {echo "active"; } ?>">

                        <a href="<?php echo BASE_URL;?>produto/listarProduto/<?php 
                            $pag_array = $_GET;
                            unset($pag_array['q']);
                            echo ($q."?". http_build_query($pag_array) ); 
                            ?>">
                            <?php echo $q; ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </div>
        </div>
        
        
        <script>
            var now = new Date(); 
            var hrs = now.getHours(); 
            var msg = ""; 
            if (hrs > 0) msg = "Mornin' Sunshine!"; 
            // REALLY early 
            if (hrs > 6) msg = "Good morning"; 
            // After 6am 
            if (hrs > 12) msg = "Good afternoon"; 
            // After 12pm 
            if (hrs > 17) msg = "Good evening"; 
            // After 5pm 
            if (hrs > 22) msg = "Go to bed!"; 
            // After 10pm 
            alert(msg);
        </script>
        
    </section>
    
<br/><br/><br/><br/>