    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tela de Permissao
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."adminLTE/"); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active"><a href="<?php echo(BASE_URL."permissaoLTE/"); ?>"><i class="fa fa-database"></i>Permissao</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Grupos de Permissoes</h3>
                <div class="box-tools">
                    <a href="<?php echo BASE_URL; ?>permissaoLTE/itemPermissao/" class="btn btn-primary">Itens de Permissao</a>
                    <a href="<?php echo BASE_URL; ?>permissaoLTE/add/" class="btn btn-success">Adicionar</a>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-condensed">
                    <tr>
                        <th>Nome Permissao</th>
                        <th width="150">QTD de Ativos</th>
                        <th width="130">Ações</th>
                    </tr>
                    
                    <?php foreach ($permitido as $item) :?>
                    <tr>    
                        <td><?php echo($item['nome']);?></td>
                        <td><?php echo($item['total_user']);?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?php echo BASE_URL; ?>permissaoLTE/edit/<?php echo $item['id']; ?>" 
                                   class="btn btn-xs btn-primary">
                                    Editar
                                </a>
                                <?php if (($item['total_user'] == 0)): ?>
                                <a href="<?php echo BASE_URL; ?>permissaoLTE/del/<?php echo $item['id']; ?>" 
                                   class="btn btn-xs btn-danger" <?php echo(($item['total_user']!=0)?'disabled':'');?>>
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
    <!-- /.content -->
      <!--
      <!--  <div>
      <!--    <h1 class="h1">Permissões</h1>
      <!--    <fieldset style="border: 1px solid; border-color: #000">
      <!--      <legend>Página Principal</legend>
      <!--      <?php foreach ($permitido as $item) :?>
      <!--      <br><?php print_r($item);?>
      <!--      <?php endforeach; ?>
      <!--      <br/><br/>
      <!--    </fieldset>
      <!--    <br/><br/>
      <!--  </div>
      -->
<br/><br/><br/><br/>