<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
        <tr>
            <td><?php echo($item['id']); ?></td>
            <td><?php echo (utf8_encode($item['nome'])); ?></td>
            <td><?php echo($item['sub'] );?></td>
            
            
            <td class="text-center">
                <a class="home_cta_button" href="<?php echo(BASE_URL."painel/editMenu/".$item['id']); ?>">Editar Menu</a> 
                <a class="home_cta_button" href="<?php echo(BASE_URL."painel/excluirMenu/".$item['id']); ?>">Excluir Menu</a>
            </td>
        </tr>
*/
function subSeachMenu($menus = array(), $subs = array(), $level="0", $sub="0") {
    
    echo ("<div id='AddMenu".$sub."' class='collapse panel-collapse'>");
    foreach ($subs as $cat){
        echo ("<div class='row'>");
            echo ("<div class='col-sm-2 table-bordered text-center' style='padding-top:6px; padding-right: 12px; padding-bottom: 6px;'>".$cat['id']."</div>");
            echo ("<div class='col-sm-4 produto_nome table-bordered' style='padding-top:6px; padding-right: 12px; padding-bottom: 6px;'>");
                echo ("<a class='home_cta_button' href='#AddMenu".($cat['id'])."' data-toggle='collapse'> ".utf8_encode($cat['nome'])."</a>");
            echo ("</div>");
            echo ("<div class='col-sm-3 table-bordered text-center' style='padding-top:6px; padding-right: 12px; padding-bottom: 6px;'>");
            foreach ($menus as $item) {
                if ($item['id'] === $cat['sub']){
                    echo (utf8_encode($item['nome']));
                }
            }
                //echo ($cat['sub']);
            echo ("</div>");
            echo ("<div class='col-sm-3 text-center table-bordered'>");
                echo ("<a class='btn btn-info' href='".(BASE_URL."categorias/editCategoria/".$cat['id'])."'>Editar</a> ");
                echo ("<a class='btn btn-danger' href='".(BASE_URL."categorias/delCategoria/".$cat['id'])."'>Excluir</a>");
            echo ("</div>");
        echo ("</div>");
        if (count($cat['subs']) > 0){
            subSeachMenu($subs, $cat['subs'], $level+1, $cat['id']);
        }
    }
    echo ("</div>");
}

function subSeachMenuTR($menus = array(), $subs = array(), $level="0", $sub="0") {
    
    //echo ("<tr id='AddMenu".$sub."' class='collapse panel-collapse'>");
    foreach ($subs as $cat){
        echo ("<tr class=''>");
            //echo ("<td class=' table-bordered text-center' style='padding-top:6px; padding-right: 12px; padding-bottom: 6px;'>".$cat['id']."</td>");
            echo ("<td class='produto_nome table-bordered' style='padding-top:6px; padding-right: 12px; padding-bottom: 6px;'>");
                echo ("<a class='home_cta_button' href='#AddMenu".($cat['id'])."' data-toggle='collapse'> ".utf8_encode($cat['nome'])."</a>");
            echo ("</td>");
            echo ("<td class='table-bordered text-center' style='padding-top:6px; padding-right: 12px; padding-bottom: 6px;'>");
            foreach ($menus as $item) {
                if ($item['id'] === $cat['sub']){
                    echo (utf8_encode($item['nome']));
                }
            }
                //echo ($cat['sub']);
            echo ("</td>");
            echo ("<td class='text-center table-bordered'>");
                echo ("<div class='btn-group'>");
                echo ("<a class='btn btn-xs btn-primary' href='".(BASE_URL."categorias/editCategoria/".$cat['id'])."'>Editar</a> ");
                echo ("<a class='btn btn-xs btn-danger' href='".(BASE_URL."categorias/delCategoria/".$cat['id'])."'>Excluir</a>");
                echo ("</div>");
            echo ("</td>");
        echo ("</tr>");
        if (count($cat['subs']) > 0){
            subSeachMenuTR($subs, $cat['subs'], $level+1, $cat['id']);
        }
    }
    //echo ("</tr>");
}
?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Categorias
        <small><?php echo($mensagem);?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo(BASE_URL."adminLTE/"); ?>"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active"><a href="<?php echo(BASE_URL."adminLTE/categoria"); ?>"><i class="fa fa-bank"></i>Categoria</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Categorias</h3>
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
                        <?php foreach ($subArray as $itemSub) :?>
                        <div class="form-group">
                            <label for="SUB">SUB:</label>
                            <select name="sub" id="sub" class="form-control">
                                <option value="<?php echo $itemSub['id']?>" selected="true"><?php echo $itemSub['nome']?></option>
                                <?php foreach ($arvore as $itemARV) :?>
                                  <?php if ($itemARV['id'] !== $itemSub['id']):?>
                                    <option value="<?php echo $itemARV['id']; ?>"><?php echo $itemARV['nome'];?></option>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <!--<input type="text" name="texto" id="texto" value="<?php echo($sub ." - ". utf8_encode($itemSub['nome'])); ?>" disabled class="form-control"/>-->
                        </div>
                        <?php endforeach; ?>
                        <!--<input type="hidden" name="sub_item" id="sub_item" value="<?php echo($sub); ?>" />-->
                
                        <a href="#AddCategoria" class="btn btn-default" data-toggle="collapse"><i class="fa fa-sign-out"></i>FECHAR</a>
                </div>
            </div>
        </form>
    </div>
            <div class="box-body">
                <table class="table table-condensed">
                    <tr>
                        <th class="table-bordered">Nome da Categoria</th>
                        <th class="text-center table-bordered" width="150">SUB</th>
                        <th class="text-center table-bordered" width="130">Ações</th>
                    </tr>
                    
                    <?php foreach ($categorias as $item) :?>
                    <tr>    
                        <td class="produto_nome table-bordered">
                            <a href="#AddMenu<?php echo($item['id']); ?>" data-toggle="collapse">
                                <?php echo utf8_encode($item['nome']);?>
                            </a>
                        </td>
                        <?php foreach ($subArray as $itemSub) :?>
                        <td class="text-center table-bordered"><?php echo($itemSub['nome']);?></td>
                        <?php endforeach; ?>
                        <td class="text-center table-bordered">
                            <div class="btn-group">
                                <a href="<?php echo BASE_URL; ?>categorias/editCategoria/<?php echo $item['id']; ?>" 
                                   class="btn btn-xs btn-primary">
                                    Editar
                                </a>
                                
                                <a href="<?php echo BASE_URL; ?>categorias/delCategoria/<?php echo $item['id']; ?>" 
                                   class="btn btn-xs btn-danger" >
                                    Excluir
                                </a>
                                
                            </div>
                        </td>
                    </tr>
        <?php 
        if (count($item['subs']) > 0){
                subSeachMenuTR($categorias, $item['subs'], 1, $item['id']);
            }
        ?>
                    <?php endforeach; ?>
                    
                </table>
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
    
<br/><br/><br/><br/>
<hr>
<div class="container-fluid">
    <br/><br/><br/>
    <!--<div class="navbar topnav">
    <!--    <h1 class="h1">Categorias</h1>
    <!--</div>
    -->
    <?php if (isset($excluir) && $excluir == "success" ) :?>
    <!--    <div class="alert-success">
    <!--        <label>Registro excluido com sucesso</label>
    <!--    </div>
    -->
    <?php endif; ?>
    <?php if (isset($excluir) && $excluir == "error" ) :?>
    <!--    <div class="alert-warning">
    <!--        <label>Não foi possivel excluir esse registro</label>
    <!--    </div>
    -->
    <?php endif; ?>
    <!--<div>
    <!--    <a href="#AddCategoria" class="btn btn-default" data-toggle="collapse">Adicionar Categorias</a>
    <!--</div>
    -->
    <!--<div id="AddCategoria" class="collapse panel-collapse">
        <!--<div class="navbar topnav">
        <!--    <h3 class="h3">Cadastrar Categoria</h3>
        <!--</div>
        -->
        <!--<form action="<?php echo BASE_URL; ?>categorias/sisAddCategoria" method="POST">
        <!--    <div class="form-group">
        <!--        <label for="nome">Nome:</label>
        <!--        <input type="text" name="nome" id="nome" class="form-control" required/>
        <!--    </div>
        <!--    <?php foreach ($subArray as $itemSub) :?>
        <!--    <div class="form-group">
        <!--        <label for="email">SUB:</label>
        <!--        <input type="text" name="texto" id="texto" value="<?php echo($sub ." - ". utf8_encode($itemSub['nome'])); ?>" disabled class="form-control"/>
        <!--    </div>
        <!--    <?php endforeach; ?>
        <!--    <input type="hidden" name="sub" id="sub" value="<?php echo($sub); ?>" />
        <!--    <input type="submit" id="botaoEnviarForm" value="Adicionar" class="btn btn-success" />
        <!--    <a href="#AddCategoria" class="btn btn-default" data-toggle="collapse">FECHAR</a>
        <!--</form>
        -->
    <!--</div>-->
    <br/>
    <!--<div class="table">-->
        <!--<div class="row text-center">
        <!--    <div class="col-sm-2 table-bordered">ID</div>
        <!--    <div class="col-sm-4 table-bordered">NOME</div>
        <!--    <div class="col-sm-3 table-bordered">SUB</div>
        <!--    <div class="col-sm-3 text-center table-bordered">AÇÕES</div>
        <!--</div>
        -->
    <?php foreach ($categorias as $item): ?>
        
        <!--<div class="row">-->
        <!--    <div class="col-sm-2 table-bordered text-center" style="padding-top:6px; padding-right: 12px; padding-bottom: 6px;">
        <!--        <?php echo($item['id']); ?>
        <!--    </div>
        -->
        <!--    <div class="col-sm-4 produto_nome table-bordered" style="padding-top:6px; padding-right: 12px; padding-bottom: 6px;">
        <!--        <a class="home_cta_button" href="#AddMenu<?php echo($item['id']); ?>" data-toggle="collapse"> 
        <!--            <?php echo (utf8_encode($item['nome'])); ?> 
        <!--        </a>
        <!--    </div>
        -->
        <!--    <?php foreach ($subArray as $itemSub) :?>
        <!--    <div class="col-sm-3 table-bordered text-center" style="padding-top:6px; padding-right: 12px; padding-bottom: 6px">
        <!--        <?php echo (utf8_encode($itemSub['nome'])); ?>
        <!--    </div>
        <!--    <?php endforeach; ?>
        -->
        <!--    <div class="col-sm-3 text-center table-bordered">
        <!--        <a class="btn btn-info" href="<?php echo(BASE_URL."categorias/editCategoria/".$item['id']); ?>">Editar</a> 
        <!--        <a class="btn btn-danger" href="<?php echo(BASE_URL."categorias/delCategoria/".$item['id']); ?>">Excluir</a>
        <!--    </div>
        -->
        <!--</div>-->
    
        <?php 
        if (count($item['subs']) > 0){
                subSeachMenu($categorias, $item['subs'], 1, $item['id']);
            }
        ?>
        
    <?php endforeach; ?>
        
    <!--</div>-->
    <!--<pre><?php //print_r($subArray); ?></pre>-->
    <!--<pre><?php //print_r($categorias); ?></pre>-->
</div>
        
