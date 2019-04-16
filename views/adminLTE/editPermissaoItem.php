    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tela de Item de Permissao
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."adminLTE/"); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?php echo(BASE_URL."permissaoLTE/"); ?>"><i class="fa fa-database"></i>Permissao</a></li>
        <li><a href="<?php echo(BASE_URL."permissaoLTE/itemPermissao"); ?>"><i class="fa fa-dashcube"></i>Item de Permissao</a></li>
        <li class="active"><i class="fa fa-anchor"></i>Editar Item de Permissao</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        <form action="<?php echo BASE_URL; ?>permissaoLTE/editItemAction/<?php echo($id_grupo);?>" method="POST">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Editar Item de Permissões</h3>
                    <div class="box-tools">
                        <input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success"/>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="nomeItem">Nome do Item:</label>
                        <input type="text" name="nome" id="nome" class="form-control" value="<?php echo ($nomeItem);?>" required/>
                    </div>
                    
                    <div class="form-group">
                        <label for="SLUG">Slug:</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="<?php echo ($slug);?>" disabled/>
                    </div>
                    
                </div>
            </div>
        </form>
        
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
        <!--<pre>-->
        <?php //echo("Bom Dia ".$nome); ?>
        <?php //print_r($nome);  ?>
        <!--</pre>-->
        <!--<br>-->
        
    </section>
    <!-- /.content -->
