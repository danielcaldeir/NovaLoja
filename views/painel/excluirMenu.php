
<div class="container-fluid">
    <div class="navbar topnav">
        <h2 class="h2">Excluir Menu</h2>
    </div>
    
    <?php if ( !empty($id) ) : ?>
        <form action="<?php echo BASE_URL; ?>painel/sisExcluirMenu/" method="POST">
            <div class="form-group">
                <label>Tem certeza que deseja excluir esse menu?</label>
            </div>
            <table class="table table-bordered" width="100%">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">URL</th>
                    </tr>
                </thead>
                
            <?php foreach ($menu as $item): ?>
                <tr class="text-center text-uppercase">
                    <td><?php echo($item['id']); ?></td>
                    <td><?php echo (utf8_encode($item['nome'])); ?></td>
                    <?php foreach ($sub as $itemSub) :?>
                    <td><?php echo($item['sub']." - ".utf8_encode($itemSub['nome']));?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </table>
            <input type="hidden" name="id" value="<?php echo($id); ?>"/>
            <input type="submit" class="btn btn-success" value="SIM"/>
            <a href="<?php echo BASE_URL; ?>painel/menus/" class="btn btn-danger">NÃO</a>
        </form>
    <?php else : ?>
    <form action="<?php echo BASE_URL; ?>painel/menus/" method="GET">
        <div class="form-group">
            <label>Não foi informado um identificador.</label>
        </div>
        <input type="submit" class="btn btn-default" value="VOLTAR"/>
    </form>
    
    <?php endif; ?>
    
</div>
