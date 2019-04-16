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
                echo ("<a class='btn btn-info' href='".(BASE_URL."painel/editMenu/".$cat['id'])."'>Editar Menu</a> ");
                echo ("<a class='btn btn-danger' href='".(BASE_URL."painel/excluirMenu/".$cat['id'])."'>Excluir Menu</a>");
            echo ("</div>");
        echo ("</div>");
        if (count($cat['subs']) > 0){
            subSeachMenu($subs, $cat['subs'], $level+1, $cat['id']);
        }
    }
    echo ("</div>");
}
?>

<div class="container-fluid">
    <?php echo("Bom Dia ".$nome);  ?>
    <br/>
    <?php //echo($this->config['painel_welcome']);?>
    <br/>
    <br/>
    <div class="navbar topnav">
        <h1 class="h1">Menus</h1>
    </div>
    <?php if (isset($excluir) && $excluir == "success" ) :?>
        <div class="alert-success">
            <label>Registro excluido com sucesso</label>
        </div>
    <?php endif; ?>
    <?php if (isset($excluir) && $excluir == "error" ) :?>
        <div class="alert-warning">
            <label>Não foi possivel excluir esse registro</label>
        </div>
    <?php endif; ?>
    <a class="btn btn-default" href="<?php echo(BASE_URL."painel/addMenu");?>">Adicionar Menu</a>
    <br/>
    <div class="table">
        <div class="row text-center">
            <div class="col-sm-2 table-bordered">ID</div>
            <div class="col-sm-4 table-bordered">NOME</div>
            <div class="col-sm-3 table-bordered">SUB</div>
            <div class="col-sm-3 text-center table-bordered">AÇÕES</div>
        </div>
        
    <?php foreach ($menus as $item): ?>
        
        <div class="row">
            <div class="col-sm-2 table-bordered text-center" style="padding-top:6px; padding-right: 12px; padding-bottom: 6px;">
                <?php echo($item['id']); ?>
            </div>
            <div class="col-sm-4 produto_nome table-bordered" style="padding-top:6px; padding-right: 12px; padding-bottom: 6px;">
                <a class="home_cta_button" href="#AddMenu<?php echo($item['id']); ?>" data-toggle="collapse"> 
                    <?php echo (utf8_encode($item['nome'])); ?> 
                </a>
            </div>
            
            <?php foreach ($sub as $itemSub) :?>
            <div class="col-sm-3 table-bordered text-center" style="padding-top:6px; padding-right: 12px; padding-bottom: 6px">
                <?php echo (utf8_encode($itemSub['nome'])); ?>
            </div>
            <?php endforeach; ?>
            
            <div class="col-sm-3 text-center table-bordered">
                <a class="btn btn-info" href="<?php echo(BASE_URL."painel/editMenu/".$item['id']); ?>">Editar Menu</a> 
                <a class="btn btn-danger" href="<?php echo(BASE_URL."painel/excluirMenu/".$item['id']); ?>">Excluir Menu</a>
            </div>
        </div>
    
        <?php 
        if (count($item['subs']) > 0){
                subSeachMenu($menus, $item['subs'], 1, $item['id']);
            }
        ?>
        
    <?php endforeach; ?>
        
    </div>
    
    <!--<pre><?php //print_r($menus); ?></pre>-->
</div>
        
