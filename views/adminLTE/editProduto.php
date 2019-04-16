    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tela de Produto
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."adminLTE/"); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?php echo(BASE_URL."produto/listarProduto"); ?>"><i class="fa fa-archive"></i>produtos</a></li>
        <li class="active"><i class="fa fa-anchor"></i>Editar Produto</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        
        <div class="box">
            <?php foreach ($produto as $info) :?>
            <form action="<?php echo BASE_URL; ?>produto/editProdutoAction/<?php echo($id_pagina);?>" method="POST">
                <div class="box-header">
                    <h3 class="box-title">Editar Produto</h3>
                    <div class="box-tools">
                        <input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success"/>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="categoria">Categoria:</label>
                        <select name="categoria" id="categoria" class="form-control" required>
                        <?php foreach ($cats as $cat): ?>
                            <option value="<?php echo($cat['id']); ?>" <?php if($info['id_categoria']==$cat['id']): echo('selected'); endif;?>> 
                                <?php echo utf8_encode($cat['nome']); ?> 
                            </option>
                        <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <select name="marca" id="categoria" class="form-control" required>
                        <?php foreach ($marcas as $marca): ?>
                            <option value="<?php echo($marca['id']); ?>" <?php if($info['id_marca']==$marca['id']): echo('selected'); endif;?>> 
                                <?php echo utf8_encode($marca['nome']); ?> 
                            </option>
                        <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control" value="<?php echo utf8_encode($info['nome']); ?>" required/>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descricao:</label>
                        <textarea name="descricao" id="descricao" class="form-control" required><?php echo utf8_encode($info['descricao']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="estoque">Estoque:</label>
                        <button type="button" onclick="javascript:retirar()">-</button>
                        <input type="text" id="qtd" name="qtd" disabled value="<?php echo($info['estoque']);?>" class="form-control-static">
                        <button type="button" onclick="javascript:estocar()">+</button>
                    </div>
                    <div class="form-group">
                        <label for="precoAnt">Preco Anterior:</label>
                        <input type="text" id="preco_Ant" name="preco_Ant" disabled value="<?php echo (number_format($info['preco_ant'],2,",",".")); ?>" class="form-control-static"/>
                    </div>
                    <div class="form-group">
                        <label for="preco">Preco:</label>
                        <input type="text" name="preco" id="preco" class="form-control" value="<?php echo(number_format($info['preco'], 2,",",".")); ?>" maxlength="10" onKeyUp="formatarMoeda();" required/>
                    </div>
                    <div class="form-group">
                        <label for="nome">Peso (em Kg):</label>
                        <input type="text" name="peso" id="peso" class="form-control" value="<?php echo($info['peso']);?>" required/>
                    </div>
                    <div class="form-group">
                        <label for="nome">Altura (em Cm):</label>
                        <input type="text" name="altura" id="altura" class="form-control" value="<?php echo($info['altura']);?>" required/>
                    </div>
                    <div class="form-group">
                        <label for="nome">Largura (em Cm):</label>
                        <input type="text" name="largura" id="largura" class="form-control" value="<?php echo($info['largura']);?>" required/>
                    </div>
                    <div class="form-group">
                        <label for="nome">Comprimento (em Cm):</label>
                        <input type="text" name="comprimento" id="comprimento" class="form-control" value="<?php echo($info['comprimento']);?>" required/>
                    </div>
                    <div class="form-group">
                        <label for="nome">Diametro (em Cm):</label>
                        <input type="text" name="diametro" id="diametro" class="form-control" value="<?php echo($info['diametro']);?>" required/>
                    </div>
                    <input type="hidden" id="id" name="id" value="<?php echo($info['id']); ?>"/>
                    <input type="hidden" id="usuario" name="usuario" value="<?php echo($nome->getID()); ?>" />
                    <input type="hidden" id="estoque" name="estoque" value="<?php echo($info['estoque']);?>" />
                    <input type="hidden" id="precoAnt" name="precoAnt" value="<?php echo (number_format($info['preco'],2,".","")); ?>" />
                    
                    
                </div>
            </form>
            <?php endforeach; ?>
            <div class="box-footer">
            <div class="row">
                <div class="col-sm-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php $this->lang->get('PRODUCT_SPECIFICATIONS');?></h3>
                        </div>
                        <div class="panel-body">
                    <?php //foreach ($produto_info['opcoes'] as $opcoes) :
                        foreach ($opcoes as $opcoes) :
                        ?>
                            <div>
                                <a href="#EditSPECIFICATIONS<?php echo($opcoes['id_opcao']);?>" data-toggle="collapse" >
                                    <strong><?php echo($opcoes['nomeOpcao']);?></strong>: <?php echo($opcoes['valor']);?>
                                </a>
                                <span style="float: right">
                                    <a class="btn btn-danger" href="<?php echo BASE_URL; ?>produto/delSpecificacao/<?php echo($opcoes['id']); ?>">
                                        Excluir
                                    </a>
                                </span>
                            </div>
                            <br/>
                            <div id="EditSPECIFICATIONS<?php echo($opcoes['id_opcao']);?>" class="collapse panel-collapse">
                                <div class="panel-body">
                                    <form action="<?php echo BASE_URL; ?>produto/editSpecificacao/" method="POST">
                                        <div class="form-group">
                                            <label for="opcao">Opcoes:</label>
                                            <select name="opcao" id="opcao" class="form-control" required>
                                            <?php foreach ($ops as $op): ?>
                                                <option value="<?php echo($op['id']); ?>" <?php if($opcoes['id_opcao']==$op['id']): echo('selected'); endif;?>> 
                                                    <?php echo utf8_encode($op['nome']); ?> 
                                                </option>
                                            <?php endforeach;?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="valorOP">valor:</label>
                                            <input type="text" id="valorOP" name="valorOP" value="<?php echo($opcoes['valor']);?>" class="form-control" required/>
                                        </div>
                                        <input type="hidden" id="id_produto" name="id_produto" value="<?php echo ($opcoes['id_produto']);?>" />
                                        <input type="hidden" id="id_opcao" name="id_opcao" value="<?php echo($opcoes['id']); ?>" />
                                        <input type="submit" class="btn btn-toolbar" value="Editar <?php $this->lang->get('PRODUCT_SPECIFICATIONS');?>">
                                    </form>
                                </div>
                            </div>
                    <?php endforeach;?>
                        </div>
                        <div class="panel-footer">
                            <h4 class="panel-info">
                                <a href="#AddSPECIFICATIONS" data-toggle="collapse">Adicionar <?php $this->lang->get('PRODUCT_SPECIFICATIONS');?></a>
                            </h4>
                        </div>
                        <div id="AddSPECIFICATIONS" class="collapse panel-collapse">
                            <div class="panel-body">
                                <form action="<?php echo BASE_URL; ?>produto/addSpecificacao/" method="POST">
                                    <div class="form-group">
                                        <label for="opcao">Opcoes:</label>
                                        <select name="opcao" id="opcao" class="form-control" required>
                                        <?php foreach ($ops as $op): ?>
                                            <option value="<?php echo($op['id']); ?>" > 
                                                <?php echo utf8_encode($op['nome']); ?> 
                                            </option>
                                        <?php endforeach;?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="valorOP">valor:</label>
                                        <input type="text" id="valorOP" name="valorOP" value="" class="form-control" required/>
                                    </div>
                                    <input type="hidden" id="id_produto" name="id_produto" value="<?php echo ($id);?>" />
                                    <input type="submit" class="btn btn-primary" value="Adicionar <?php $this->lang->get('PRODUCT_SPECIFICATIONS');?>">
                                </form>
                            </div>
                        </div>
                    </div>
                <?php 
                //    echo("<pre>");
                //    foreach ($produto_info['opcoes'] as $opcoes) {
                //        print_r($opcoes);
                //    }
                //    echo("</pre>");
                ?>
                </div>
                <div class="col-sm-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Bandeiras Flutuantes</h3>
                        </div>
                    <?php foreach ($produto as $info) :?>
                        <div class="panel-body">
                            <form action="<?php echo BASE_URL; ?>produto/editBandeira/" method="POST">
                                <div class="form-group">
                                    <label for="EmDestaque">Em Destaque:</label>
                                    <input type="checkbox" name="destaque" id="destaque" <?php echo ($info['destaque']==1)?'checked':''; ?>/>
                                </div>
                                <div class="form-group">
                                    <label for="EmPromocao">Em Promoção:</label>
                                    <input type="checkbox" name="promo" id="promo" <?php echo ($info['promo']==1)?'checked':''; ?>/>
                                </div>
                                <div class="form-group">
                                    <label for="MaisVendido">Mais Vendido:</label>
                                    <input type="checkbox" name="top_vendido" id="top_vendido" <?php echo ($info['top_vendido']==1)?'checked':''; ?>/>
                                </div>
                                <div class="form-group">
                                    <label for="NovoProduto">Novo Produto:</label>
                                    <input type="checkbox" name="novo_produto" id="novo_produto" <?php echo ($info['novo_produto']==1)?'checked':''; ?>/>
                                </div>
                                <input type="hidden" name="id_produto" id="id_produto" value="<?php echo ($info['id'])?>"/>
                                <input type="submit" class="btn btn-success" name="Editar" value="Editar Bandeira"/>
                            </form>
                        </div>
                    <?php endforeach;?>
                    <?php 
                    //    echo("<pre>");
                    //    foreach ($produto_info['avalia'] as $avalia) {
                    //        print_r($avalia);
                    //    }
                    //    echo("</pre>");
                    ?>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <?php foreach ($produto as $info) :?>
        <iframe src="<?php echo BASE_URL; ?>foto/editFoto/<?php echo $info['id'];?>" height="1024"  width="950" style="border: none;"></iframe>
        <?php endforeach; ?>
        <!--    <div class="form-group">
        <!--        <button class="btn btn-adn" onclick="newImage()"><i class="fa fa-plus"></i></button>
        <!--        <button class="btn btn-warning" onclick="delImage()"><i class="fa fa-minus"></i></button>
        <!--        <form action="<?php echo BASE_URL; ?>foto/addFoto/" method="POST" enctype="multipart/form-data">
        <!--            <label for="add_foto">Fotos do Anuncio:</label><br>
        <!--            <div id="fileImage" class="fileImage" idFileImage="0">
        <!--                <input type="file" name="fotos[]" id="fotos0" class="btn btn-box-tool" multiple required/>
        <!--            </div>
        <!--            <input type="hidden" name="id_produto" id="id_produto" value="<?php echo($info['id']); ?>"/>
        <!--            <input type="submit" name="botaoFoto" class="btn btn-success" value="Enviar Fotos"/>
        <!--        </form>
        <!--        <br/>
        <!--        <div class="panel panel-default">
        <!--            <div class="panel-heading">Fotos do Anuncio</div>
        <!--            <div class="panel-body">
        <!--                
                    <?php //if (is_array($produto_info['imagens']) ) : 
                        if (is_array($imagens) ) : 
                        ?>
                        <?php //foreach ($produto_info['imagens'] as $fotos) : 
                            foreach ($imagens as $fotos) : 
                            ?>
        <!--                <div class="foto_item">
        <!--                    <img src="<?php echo BASE_URL; ?>//media//produtos//<?php echo($fotos['url']); ?>" class="img-thumbnail" border="0">
        <!--                    <br>
        <!--                    <?php if (count($fotos) > 1): ?>
        <!--                    <a href="<?php echo BASE_URL; ?>foto/delFoto/<?php echo($fotos['id']); ?>" class="btn btn-danger">Excluir Foto</a>
        <!--                    <?php endif; ?>
        <!--                </div>
        <!--                <?php endforeach; ?>
        <!--            <?php endif; ?>
        <!--                
        <!--            </div>
        <!--        </div>
        <!--    </div>
        -->
        <hr>
    <!--    <pre>
    <!--        <?php //print_r ($produto_info);?>
    <!--    </pre>
        -->
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
            selector:'#descricao',
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
