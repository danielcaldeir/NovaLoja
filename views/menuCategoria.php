<?php
function subCategoria($subs = array(), $level="0") {
    foreach ($subs as $cat){
        echo '<li>';
        echo '<a href='.(BASE_URL.'categorias/enter/'.$cat['id']).'>';
        for($q=0;$q<$level;$q++){echo('-- ');}
        echo utf8_encode($cat['nome']);
        echo '</a>';
        echo '</li>';
        if (count($cat['subs']) > 0){
            subCategoria($cat['subs'], $level+1);
        }
    }
}
?>
					          
                                                <li class="dropdown">
					        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php $this->lang->get('SELECTCATEGORY'); ?>
					        <span class="caret"></span></a>
					        <ul class="dropdown-menu">
                                                    <?php foreach ($categorias as $cat) :?>
                                                    <li>
                                                        <a href="<?php echo (BASE_URL.'categorias/enter/'.$cat['id']); ?>">
                                                            <?php echo utf8_encode($cat['nome']); ?>
                                                        </a>
                                                    </li>
                                                        <?php if (count($cat['subs']) > 0){
                                                            subCategoria($cat['subs'], 1);
                                                        }?>
                                                    <?php endforeach; ?>
					        </ul>
					        </li>
                                                <?php if (isset($filtroCategoria)) :?>
                                                    <?php foreach ($filtroCategoria as $filtro) :?>
                                                        <li><a href="<?php echo (BASE_URL.'categorias/enter/'.$filtro['id']); ?>">
                                                                <?php echo utf8_encode($filtro['nome']);?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>