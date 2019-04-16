    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tela de Permissao
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."permissaoLTE/"); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?php echo(BASE_URL."permissaoLTE/"); ?>"><i class="fa fa-database"></i>Permissao</a></li>
        <li class="active"><i class="fa fa-anchor"></i>Adicionar Permissao</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        <form action="<?php echo BASE_URL; ?>permissaoLTE/addAction" method="POST">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Adicionar Grupos de Permissões</h3>
                    <div class="box-tools">
                        <input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success"/>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="nomeGrupo">Nome do Grupo:</label>
                        <input type="text" name="nome" id="nome" class="form-control" required/>
                    </div>
                    <?php foreach ($permissaoItens as $item) :?>
                    <div class="form-group">
                        <input type="checkbox" name="items[]" value="<?php echo ($item['id']);?>" id="item-<?php echo($item['id']);?>"/>
                        <label for="item-<?php echo($item['id']);?>"><?php echo($item['nome']);?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </form>
        
        <!--<div>-->
          <!--<h1 class="h1">Permissões</h1>-->
          <!--<h3><pre><?php //print_r($this->config)?></pre></h3>-->
          <!--<fieldset style="border: 1px solid; border-color: #000">-->
            <!--<legend>Items</legend>-->
            <?php foreach ($permissaoItens as $item) :?>
            <!--<br><?php print_r($item);?>-->
            <?php endforeach; ?>
          <!--</fieldset>-->
          <!--<br/><br/>-->
        <!--</div>-->
        
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
        
<br/><br/><br/><br/>