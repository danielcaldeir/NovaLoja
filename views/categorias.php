<h1>Categorias - <?php echo($categoriaNome);?></h1>

<?php $cont = 1; //Numeros de linhas ?>
<div class="row">
    <?php foreach ($produtos as $key => $produto_item) : ?>
    <div class="col-sm-4">
        <!-- Inicio do Arquivo (produtoItem.php)  -->
        <?php $this->loadView('produtoItem', $produto_item);?>
        <!-- Fim do Arquivo (produtoItem.php)  -->
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
    <?php foreach ($categoriasID as $value) :?>
    <?php for($q=1;$q<=$numeroPaginas;$q++):?>
    <li class="<?php if ($paginaAtual == $q) {echo "active"; } ?>">
        <?php 
        $pag_array = $_GET;
        unset($pag_array['q']);
        ?>
        <a href="<?php echo BASE_URL;?>categorias/pag/<?php echo $q; ?>/<?php echo $value['id']."?".http_build_query($pag_array); ?>"><?php echo $q; ?></a>
    </li>
    <?php endfor; ?>
    <?php endforeach;?>
</ul>
<div class="paginationArea">
    <?php foreach ($categoriasID as $value) :?>
    <?php for($q=1;$q<=$numeroPaginas;$q++):?>
    <div class="paginationItem <?php if ($paginaAtual == $q) {echo "pag_active"; }?>">
        <?php 
        $pag_array = $_GET;
        unset($pag_array['q']);
        $href = BASE_URL."categorias/pag/".$q."/".$value['id']."?".http_build_query($pag_array);
        ?>
        <a href="<?php echo ($href); ?>"><?php echo $q; ?></a>
    </div>
    <?php endfor; ?>
    <?php endforeach;?>
</div>
<br/>
<!--Total de Produtos: <?php echo $TotalItems; ?><br/>-->
Numero de Páginas: <?php echo $numeroPaginas; ?><br/>
Pagina Atual: <?php echo $paginaAtual; ?><br/>
<pre>
    Os valores do $_GET: <?php    print_r($_GET); ?><br/>
</pre>
