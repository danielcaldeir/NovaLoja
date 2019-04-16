    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Opcoes
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."adminLTE/"); ?>"><i class="fa fa-dashboard"></i> home</a></li>
        <li><a href="<?php echo(BASE_URL."produto/listarProduto/"); ?>"><i class="fa fa-archive"></i>produtos</a></li>
        <li class="active"><a href="<?php echo(BASE_URL."opcoes/"); ?>"><i class="fa fa-building"></i>Opcoes</a></li>
        <li class="active"><i class="fa fa-anchor"></i>Editar Opcao</li>
      </ol>
    </section>
    
    <?php if ( !empty($id) ) : ?>
    <!-- Main content -->
    <section class="content container-fluid">
        
      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Editar Opcao</h3>
                
            </div>
            <div class="box-body">
                <hr class="headline">
                
                <form action="<?php echo BASE_URL; ?>opcoes/editAction/" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control" value="<?php echo(utf8_encode($nomeOpcao));?>" required/>
                    </div>
                    <input type="hidden" id="id" name="id" value="<?php echo($id); ?>" />
                    <input type="submit" id="botaoEnviarForm" value="Editar" class="btn btn-success" />
                </form>
                
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
    <br/><br/>
<hr/>
    
    <br/><br/><br/>
  <?php else : ?>
        <div class="container">
            <h3 class="h3">Não foi informado um identificador.</h3>
            <a href="<?php echo BASE_URL; ?>opcoes/" class="btn btn-info">VOLTAR</a>
        </div>
        
        
  <?php endif; ?>
