<html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>AdminLTE 2 | Loja 2.0</title>
            <!-- Tell the browser to be responsive to screen width -->
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" type="text/css">
            <!--<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">-->
            <!-- Font Awesome -->
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/font-awesome/css/font-awesome.min.css" type="text/css">
            <!--<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">-->
            <!-- Ionicons -->
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/ionicons.min.css" type="text/css">
            <!--<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">-->
            <!-- Theme style -->
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/AdminLTE.min.css" type="text/css">
            <!--<link rel="stylesheet" href="dist/css/AdminLTE.min.css">-->
            <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
                  page. However, you can choose any other skin. Make sure you
                  apply the skin class to the body tag so the changes take effect. -->
            <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/skins/skin-blue.min.css" type="text/css">
            <!--<link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">-->

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
            <![endif]-->

            <!-- Google Font -->
            <link rel="stylesheet"
                  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
            
            <!-- REQUIRED JS SCRIPTS -->

            <!-- jQuery 3 -->
            <script src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
            <!--<script src="bower_components/jquery/dist/jquery.min.js"></script>-->
            <!-- Bootstrap 3.3.7 -->
            <script src="<?php echo BASE_URL; ?>assets/js/bootstrap.min.js"></script>
            <!--<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>-->
            <!-- AdminLTE App -->
            <script src="<?php echo BASE_URL; ?>assets/js/adminlte.min.js"></script>
            <!--<script src="dist/js/adminlte.min.js"></script>-->
            <script src="<?php echo BASE_URL;?>assets/js/script.js"></script>
        </head>
        <body>
            <div class="form-group">
                <button class="btn btn-adn" onclick="newImage()"><i class="fa fa-plus"></i></button>
                <button class="btn btn-warning" onclick="delImage()"><i class="fa fa-minus"></i></button>
                <form action="<?php echo BASE_URL; ?>foto/addFotoIFrame/" method="POST" enctype="multipart/form-data">
                    <label for="add_foto">Fotos do Anuncio:</label><br>
                    <div id="fileImage" class="fileImage" idFileImage="0">
                        <input type="file" name="fotos[]" id="fotos0" class="btn btn-box-tool" multiple required/>
                    </div>
                    <input type="hidden" name="id_produto" id="id_produto" value="<?php echo($produto_info['id']); ?>"/>
                    <input type="submit" name="botaoFoto" class="btn btn-success" value="Enviar Fotos"/>
                </form>
                <br/>
                <div class="panel panel-default">
                    <div class="panel-heading">Fotos do Anuncio</div>
                    <div class="panel-body">
                        
                    <?php if (is_array($produto_info['imagens']) ) : ?>
                        <?php foreach ($produto_info['imagens'] as $fotos) : ?>
                        <div class="foto_item">
                            <img src="<?php echo BASE_URL; ?>//media//produtos//<?php echo($fotos['url']); ?>" class="img-thumbnail" border="0">
                            <br>
                            <?php if (count($fotos) > 1): ?>
                            <a href="<?php echo BASE_URL; ?>foto/delFotoIFrame/<?php echo($fotos['id']); ?>" class="btn btn-danger">Excluir Foto</a>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                        <!--<pre>
                        <!--    <?php //print_r($produto_info); ?>
                        <!--</pre>
                        -->
                    </div>
                </div>
            </div>
        </body>
</html>
