    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tela de Paginas
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."adminLTE/"); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?php echo(BASE_URL."paginas/"); ?>"><i class="fa fa-book"></i>Pagina</a></li>
        <li class="active"><i class="fa fa-anchor"></i>Adicionar Pagina</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        <form action="<?php echo BASE_URL; ?>paginas/addAction" method="POST">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Adicionar Grupos de Paginas</h3>
                    <div class="box-tools">
                        <input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success"/>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="tituloPagina">Titulo da Pagina:</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" required/>
                    </div>
                    
                    <div class="form-group">
                        <label for="corpoConteudo">Conteudo:</label>
                        <textarea name="conteudo" value="" id="conteudo" class="form-control"></textarea>
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
        
    </section>
    <!-- /.content -->
        
<br/><br/><br/><br/>