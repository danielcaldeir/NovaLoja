    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tela de Marcas
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."adminLTE/"); ?>"><i class="fa fa-dashboard"></i> home</a></li>
        <li class="active"><a href="<?php echo(BASE_URL."adminLTE/marcas/"); ?>"><i class="fa fa-book"></i>Marcas</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Grupos de Marcas</h3>
                <div class="box-tools">
                    <a href="#AddMarcas" class="btn btn-success" data-toggle="collapse">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
    <div id="AddMarcas" class="collapse panel-collapse">
        <form action="<?php echo BASE_URL; ?>marcasLTE/addAction" method="POST">
            <div class="box">
                <div class="box-header">
                    <div class="box-title">
                        <h3 class="h3">Cadastrar Marca</h3>
                    </div>
                    <div class="box-tools">
                        <input type="submit" id="botaoEnviarForm" value="Adicionar" class="btn btn-success" />
                    </div>
                </div>
                <div class="box-body">
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" class="form-control" required/>
                        </div>
                    <a href="#AddMarcas" class="btn btn-default" data-toggle="collapse"><i class="fa fa-sign-out"></i>FECHAR</a>
                </div>
            </div>
        </form>
    </div>        
            <div class="box-body">
                <table class="table table-condensed">
                    <tr>
                        <th>Nome Marca</th>
                        <th>Qtd de Produtos</th>
                        <th width="130">Ações</th>
                    </tr>
                    <?php foreach ($marcas as $item) :?>
                    <tr>    
                        <td><?php echo($item['nome']);?></td>
                        <td><?php echo($item['total_marca']);?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?php echo BASE_URL; ?>marcasLTE/edit/<?php echo $item['id']; ?>" 
                                   class="btn btn-xs btn-primary">
                                    Editar
                                </a>
                                <?php if (($item['total_marca'] == 0)): ?>
                                <a href="<?php echo BASE_URL; ?>marcasLTE/del/<?php echo $item['id']; ?>" 
                                   class="btn btn-xs btn-danger" <?php echo(($item['total_marca']!=0)?'disabled':'');?>>
                                    Excluir
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
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