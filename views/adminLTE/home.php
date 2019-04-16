    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Page Header
        <small>Optional description</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
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
<br/><br/>
<!--
<!--  <div>
<!--    <?php //echo($this->config['painel_welcome']);?>
<!--    <h1 class="h1">Configurações</h1>
<!--    <h3><pre><?php //print_r($this->config)?></pre></h3>
<!--    <fieldset style="border: 1px solid; border-color: #000">
<!--        <legend>Página Principal</legend>
<!--    	<a href="<?php echo BASE_URL; ?>painel/menus"><h4>Menu</h4></a>
<!--        <a href="<?php echo BASE_URL; ?>painel/categorias"><h4>Categorias</h4></a>
<!--	<a href="<?php echo BASE_URL; ?>painel/pagina"><h4>Pagina</h4></a>
<!--        <a href="<?php echo BASE_URL; ?>painel/produtos"><h4>Produtos</h4></a>
<!--        <a href="<?php echo BASE_URL; ?>painel/marcas"><h4>Marcas</h4></a>
<!--	<br/>
<!--	<br/>
<!--    </fieldset>
<!--    <br/><br/>
<!--  </div>
-->