    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tela de Pagina
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."adminLTE/"); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?php echo(BASE_URL."paginas/"); ?>"><i class="fa fa-book"></i>Pagina</a></li>
        <li class="active"><i class="fa fa-anchor"></i>Editar Pagina</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        <form action="<?php echo BASE_URL; ?>paginas/editAction/<?php echo($id_pagina);?>" method="POST">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Editar Grupo de Paginas</h3>
                    <div class="box-tools">
                        <input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success"/>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="tituloPagina">Nome do Grupo:</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" value="<?php echo ($titulo);?>" required/>
                    </div>
                    
                    <div class="form-group">
                        <label for="corpoConteudo">Conteudo:</label>
                        <textarea name="conteudo" id="conteudo" class="form-control"><?php echo($conteudo); ?></textarea>
                    </div>
                    
                </div>
            </div>
        </form>
        <hr>
        <?php echo ($conteudo);?>
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
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector:'#conteudo',
            height:500,
            plugins: 'print preview fullpage powerpaste searchreplace autolink \n\
                    directionality advcode visualblocks visualchars fullscreen image \n\
                    link media template codesample table charmap hr pagebreak nonbreaking \n\
                    anchor toc insertdatetime advlist lists textcolor wordcount a11ychecker \n\
                    imagetools colorpicker textpattern help',
            toolbar: 'undo redo | formatselect | bold italic Underline strikethrough forecolor backcolor | \n\
                    link Image Media Table | alignleft aligncenter alignright alignjustify  | \n\
                    numlist bullist outdent indent | removeformat codeSample | help',
            automatic_uploads:true,
            file_picker_types:'image',
            images_upload_url:'<?php echo BASE_URL; ?>paginas/upload'
        });
    </script>
    