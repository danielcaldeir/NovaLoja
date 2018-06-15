<?php foreach ($widget as $item) :?>
<?php
        $pag_array = $_GET;
        unset($pag_array['q']);
        $href = BASE_URL."produto/abrir/".$item['id']."?".http_build_query($pag_array);
?>
                                                    <div class="widget_item">
                                                        <a href="<?php echo($href);?>">
                                                            <div class="widget_info">
                                                                <div class="widget_productname"><?php echo $item['nome']; ?></div>
                                                                <div class="widget_price">
                                                                    <span>R$ <?php echo number_format($item['preco_ant'], 2, ',', '.'); ?></span> 
                                                                    R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
                                                                </div>
                                                            </div>
                                                            <div class="widget_photo">
                                                                <img src="<?php echo BASE_URL; ?>media/produtos/<?php echo $item['imagens'][0]['url']; ?>" />
                                                            </div>
                                                            <div style="clear:both;"></div>
                                                        </a>
                                                    </div>
<?php endforeach; ?>