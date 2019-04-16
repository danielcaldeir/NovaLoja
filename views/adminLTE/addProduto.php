<?php
function subCategoria($subs = array(), $level="0") {
    foreach ($subs as $cat){
        echo ("<option value='");
        echo ($cat['id']);
        echo ("' >");
        for($q=0;$q<$level;$q++){echo('-- ');}
        echo utf8_encode($cat['nome']);
        echo '</option>';
        if (count($cat['subs']) > 0){
            subCategoria($cat['subs'], $level+1);
        }
    }
}
?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tela de Produto
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."adminLTE/"); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?php echo(BASE_URL."produto/listarProduto"); ?>"><i class="fa fa-archive"></i>produtos</a></li>
        <li class="active"><i class="fa fa-anchor"></i>Adicionar Produto</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        <form action="<?php echo BASE_URL; ?>produto/addProdutoAction/" method="POST" onsubmit="return enviarFormulario()" enctype="multpart/form-data">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Adicionar Produto</h3>
                    <div class="box-tools">
                        <input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success"/>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="categoria">Categoria:</label>
                        <select name="categoria" id="categoria" class="form-control" required>
                        <?php foreach ($cats as $cat): ?>
                            <option value="<?php echo($cat['id']); ?>" > 
                                <?php echo utf8_encode($cat['nome']); ?> 
                            </option>
                            <?php if (count($cat['subs']) > 0){
                                                            subCategoria($cat['subs'], 1);
                                                        }?>
                        <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <select name="marca" id="categoria" class="form-control" required>
                        <?php foreach ($marcas as $marca): ?>
                            <option value="<?php echo($marca['id']); ?>" > 
                                <?php echo utf8_encode($marca['nome']); ?> 
                            </option>
                        <?php endforeach;?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control" value="" required/>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descricao:</label>
                        <textarea name="descricao" id="descricao" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="estoque">Estoque:</label>
                        <button type="button" onclick="javascript:retirar()">-</button>
                        <input type="text" id="qtd" name="qtd" disabled value="0" class="form-control-static">
                        <button type="button" onclick="javascript:estocar()">+</button>
                    </div>
                    <div class="form-group">
                        <label for="preco">Preco:</label>
                        <input type="text" name="preco" id="preco" class="form-control" value="" maxlength="10" onKeyUp="formatarMoeda();" required/>
                    </div>
                    <div class="form-group">
                        <label for="nome">Peso (em Kg):</label>
                        <input type="text" name="peso" id="peso" class="form-control" value="" onkeypress="return isNumber(event)" required/>
                    </div>
                    <div class="form-group">
                        <label for="nome">Altura (em Cm):</label>
                        <input type="text" name="altura" id="altura" class="form-control" value="" onkeypress="return isNumber(event)" required/>
                    </div>
                    <div class="form-group">
                        <label for="nome">Largura (em Cm):</label>
                        <input type="text" name="largura" id="largura" class="form-control" value="" onkeypress="return isNumber(event)" required/>
                    </div>
                    <div class="form-group">
                        <label for="nome">Comprimento (em Cm):</label>
                        <input type="text" name="comprimento" id="comprimento" class="form-control" value="" onkeypress="return isNumber(event)" required/>
                    </div>
                    <div class="form-group">
                        <label for="nome">Diametro (em Cm):</label>
                        <input type="text" name="diametro" id="diametro" class="form-control" value="" onkeypress="return isNumber(event)" required/>
                    </div>
                    <input type="hidden" id="usuario" name="usuario" value="<?php echo($nome->getID()); ?>" />
                    <input type="hidden" id="estoque" name="estoque" value="0" />
                </div>
            </div>
        </form>
        
    <!--    <pre>
    <!--        <?php print_r($nome);?>
    <!--    </pre>
    -->    
        
    </section>
    <!-- /.content -->
    <script type="text/javascript" src="<?php echo BASE_URL; ?>assets/tinymce/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
        tinymce.init({
            selector:'#descricao',
            height:300,
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
        function enviarFormulario() {
            var valor = document.getElementById('preco');
            var preco = converteMoedaFloat(valor.value);
            valor.value = preco;
            return true;
        }
    </script>
        
<br/><br/><br/><br/>