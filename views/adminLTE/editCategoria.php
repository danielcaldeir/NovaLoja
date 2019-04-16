
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Categorias
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."adminLTE/"); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><a href="<?php echo(BASE_URL."adminLTE/categoria"); ?>"><i class="fa fa-bank"></i>Categoria</a></li>
        <li class="active"><i class="fa fa-anchor"></i>Editar Categoria</li>
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
                <h3 class="box-title">Editar Categoria</h3>
                <div class="box-tools">
                    <a href="#AddCategoria" class="btn btn-success" data-toggle="collapse">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        <div id="AddCategoria" class="collapse panel-collapse">
            <form action="<?php echo BASE_URL; ?>categorias/addCategoriaAction" method="POST">
                <div class="box">
                    <div class="box-header">
                        <div class="box-title">
                            <h3 class="h3">Cadastrar Categoria</h3>
                        </div>
                        <div class="box-tools">
                            <input type="submit" id="botaoEnviarForm" value="Adicionar" class="btn btn-success" />
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" class="form-control" required/>
                        </div>
                        <?php foreach ($categoria as $item) :?>
                        <div class="form-group">
                            <label for="SUB">SUB:</label>
                            <select name="sub" id="sub" class="form-control">
                                <option value="<?php echo($item['id']);?>"><?php echo ($item['nome']);?></option>
                                <?php foreach ($arvore as $itemARV) :?>
                                      <?php if ($itemARV['id'] !== $item['id']):?>
                                        <option value="<?php echo $itemARV['id']; ?>"><?php echo $itemARV['nome'];?></option>
                                      <?php endif; ?>
                                    <?php endforeach; ?>
                            </select>
                            <input type="text" name="texto" id="texto" value="<?php echo($id ." - ". utf8_encode($item['nome'])); ?>" disabled class="form-control"/>
                        </div>
                        <?php endforeach; ?>
                        <!--<input type="hidden" name="sub_item" id="sub_item" value="<?php echo($id); ?>" />-->
                        <!--<input type="submit" id="botaoEnviarForm" value="Adicionar" class="btn btn-success" />-->
                        <a href="#AddCategoria" class="btn btn-default" data-toggle="collapse">FECHAR</a>
                    </div>
                </div>
            </form>
        </div>
            <div class="box-body">
                <hr class="headline">
                <?php foreach ($categoria as $item) :?>
                <form action="<?php echo BASE_URL; ?>categorias/editCategoriaAction/" method="POST">
                    <div class="form-group">
                        <label for="nome">Nome:</label>
                        <input type="text" name="nome" id="nome" class="form-control" value="<?php echo(utf8_encode($item['nome']));?>" required/>
                    </div>
                    <?php foreach ($subArray as $itemSub) :?>
                    <div class="form-group">
                        <label for="SUB">SUB:</label>
                        <select name="sub" id="sub" class="form-control">
                            <option value="<?php echo $itemSub['id']?>" selected="true"><?php echo $itemSub['nome']?></option>
                            <?php foreach ($arvore as $itemARV) :?>
                              <?php if ($itemARV['id'] !== $itemSub['id']):?>
                                <?php if ($itemARV['id'] !== $item['id']):?>
                                  <option value="<?php echo $itemARV['id']; ?>"><?php echo $itemARV['nome'];?></option>
                                <?php endif; ?>
                              <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endforeach; ?>
                    <input type="hidden" id="id" name="id" value="<?php echo($item['id']); ?>" />
                    <input type="submit" id="botaoEnviarForm" value="Editar" class="btn btn-success" />
                </form>
                <?php endforeach; ?>
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

<!--<div class="container-fluid">-->
<!--    <div class="navbar topnav">
<!--        <h2 class="h2">Editar Categoria</h2>
<!--    </div>
<!--    
<!--    <?php if ( $confirme == "error") :?>
<!--            <div class="alert-warning">
<!--                <label>Preencha todos os Campos</label>
<!--            </div>
<!--    <?php endif; ?>
<!--    <?php if ( $confirme == "sucess" ) :?>
<!--            <div class="alert-success">
<!--                <strong>Registro Editado com Sucesso!</strong>
<!--            </div>
<!--    <?php endif; ?>
    -->
  
    
    <?php foreach ($categoria as $info) :?>
    
<!--    <div class="caption">
<!--        <a href="#AddCategoria" class="btn btn-default" data-toggle="collapse">Adicionar Categoria</a>
<!--    </div>
    -->
<!--    <div id="AddCategoria" class="collapse panel-collapse">
<!--        <div class="navbar topnav">
<!--            <h3 class="h3">Cadastrar Categoria</h3>
<!--        </div>
<!--        <form action="<?php echo BASE_URL; ?>categorias/sisAddCategoria" method="POST">
<!--            <div class="form-group">
<!--                <label for="nome">Nome:</label>
<!--                <input type="text" name="nome" id="nome" class="form-control" required/>
<!--            </div>
<!--            <div class="form-group">
<!--                <label for="email">SUB:</label>
<!--                <input type="text" name="texto" id="texto" value="<?php echo($info['id'] ." - ". utf8_encode($info['nome'])); ?>" disabled class="form-control"/>
<!--            </div>
<!--            <input type="hidden" name="sub" id="sub" value="<?php echo($info['id']); ?>" />
<!--            <input type="submit" id="botaoEnviarForm" value="Adicionar" class="btn btn-success" />
<!--            <a href="#AddCategoria" class="btn btn-default" data-toggle="collapse">FECHAR</a>
<!--        </form>
<!--    </div>
    -->
    <br/>
    
<!--    <form action="<?php echo BASE_URL; ?>categorias/sisEditCategoria/" method="POST" enctype="multipart/form-data">
<!--        <div class="form-group">
<!--            <label for="Nome">Nome:</label>
<!--            <input type="text" name="nome" id="nome" class="form-control" value="<?php echo(utf8_encode($info['nome']));?>" required/>
<!--        </div>
<!--        <?php foreach ($subArray as $itemSub) :?>
<!--        <div class="form-group">
<!--            <label for="URL">SUB:</label>
<!--            <input type="text" name="texto" id="texto" class="form-control" value="<?php echo($info['sub']." - ".utf8_encode($itemSub['nome'])); ?>" disabled/>
<!--        </div>
<!--        <?php endforeach; ?>
<!--        <input type="hidden" id="id" name="id" value="<?php echo($info['id']); ?>" />
<!--        <input type="hidden" name="sub" id="sub" value="<?php echo($info['sub']); ?>" />
<!--        <input type="submit" id="botaoEnviarForm" value="SALVAR" class="btn btn-success" /> | 
<!--        <a href="<?php echo BASE_URL; ?>painel/categorias/" class="btn btn-default">VOLTAR</a>
<!--    </form>
    -->
    <?php endforeach; ?>
    
    <!--<br/><pre><?php print_r($arvore); ?></pre>-->
    <!--<br/><pre><?php print_r($categoria); ?></pre>-->
    <!--<br/><pre><?php print_r($subArray); ?></pre>-->
    <br/><br/><br/>
  <?php else : ?>
        <div class="container">
            <h3 class="h3">Não foi informado um identificador.</h3>
            <a href="<?php echo BASE_URL; ?>adminLTE/categoria/" class="btn btn-info">VOLTAR</a>
        </div>
        
        
  <?php endif; ?>
    
<!--</div>-->
