<h1>Voce esta procurando por: "<?php echo($busca);?>"</h1>

<?php $cont = 1; //Numeros de linhas ?>
<div class="row">
    <?php foreach ($produtos as $key => $produto_item) : ?>
    <div class="col-sm-4">
        <!-- Inicio do Arquivo (produtoItem.php) -->
        <?php $this->loadView('produtoItem', $produto_item);?>
        <!-- Fim do Arquivo (produtoItem.php) -->
    </div>
    <?php 
        if (fmod(($key+1), 3) == 0){
            $cont++;
            echo ('</div><div class="row">');
        }
    ?>
    <?php endforeach;?>
</div>
<ul class="pagination">
    <?php for($q=1;$q<=$numeroPaginas;$q++):?>
    <li class="<?php if ($paginaAtual == $q) {echo "active"; } ?>">
        
        <a href="<?php echo BASE_URL;?>home/pag/<?php 
            $pag_array = $_GET;
            unset($pag_array['q']);
            echo ($q."?". http_build_query($pag_array) ); 
            ?>">
            <?php echo $q; ?>
        </a>
    </li>
    <?php endfor; ?>
</ul>
<div class="paginationArea">
    <?php for($q=1;$q<=$numeroPaginas;$q++):?>
    <div class="paginationItem <?php if ($paginaAtual == $q) {echo "pag_active"; }?>">
        <?php 
        $pag_array = $_GET;
        unset($pag_array['q']);
        $href = BASE_URL."home/pag/".$q."?".http_build_query($pag_array);
        ?>
        <a href="<?php echo ($href); ?>">
            <?php echo $q; ?>
        </a>
    </div>
    <?php endfor; ?>
</div>
<br/>
<!--Total de Produtos: <?php echo $TotalItems; ?><br/>-->
Numero de Páginas: <?php echo $numeroPaginas; ?><br/>
Pagina Atual: <?php echo $paginaAtual; ?><br/>
<pre>
    Os valores do $_GET: <?php    print_r($_GET); ?><br/>
</pre>
