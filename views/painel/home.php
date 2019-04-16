<div>
    <?php echo("Bom Dia ".$nome);  ?>
    <!--<br>-->
    <?php //echo($this->config['painel_welcome']);?>
    <!--<br><br>-->
    <h1 class="h1">Configurações</h1>
    <!--<h3><pre><?php //print_r($this->config)?></pre></h3>-->
    <fieldset style="border: 1px solid; border-color: #000">
        <legend>Página Principal</legend>
    	<a href="<?php echo BASE_URL; ?>painel/menus"><h4>Menu</h4></a>
        <a href="<?php echo BASE_URL; ?>painel/categorias"><h4>Categorias</h4></a>
	<a href="<?php echo BASE_URL; ?>painel/pagina"><h4>Pagina</h4></a>
        <a href="<?php echo BASE_URL; ?>painel/produtos"><h4>Produtos</h4></a>
        <a href="<?php echo BASE_URL; ?>painel/marcas"><h4>Marcas</h4></a>
	<br/>
	<br/>
	<label>Menus Registrados</label>
	<br/>
	<?php foreach($menus as $menu): ?>
	<a href="<?php echo(BASE_URL."painel/editMenu/".$menu['id']); ?>"><h4><?php echo utf8_encode($menu['nome']);?></h4></a>
	<?php endforeach; ?>
	<br><br>
	
        <!--<form action="<?php echo BASE_URL; ?>painel/sisEditPropriedade" method="POST">-->
        <!--<h2>Template</h2>-->
	<!--
            <select name="site_template">
                <option value="DEFAULT" <?php //echo( ($this->config['site_template'] == 'DEFAULT')?('selected'):('') ); ?> >Padrao</option>
                <option value="DefaultNatal" <?php //echo( ($this->config['site_template'] == 'DefaultNatal')?('selected'):('') ); ?> >Padrao Natal</option>
            </select>
	-->
        <!--<input type="text" name="site_title" value="<?php //echo($this->config['site_title']);?>"/><br/><br/>-->
        <!--<input type="text" name="site_color" value="<?php //echo($this->config['site_color']);?>"/><br/><br/>-->
        <!--<input type="text" name="site_banner" value="<?php //echo($this->config['site_banner']);?>"/><br/><br/>-->
        <!--<input type="text" name="site_welcome" value="<?php //echo($this->config['site_welcome']);?>"/><br/><br/>-->
        <!--<input type="submit" name="Enviar" class="button" value="Enviar Dados"/>-->
        <!--</form>-->
        </fieldset>
        <br/><br/>
		<!--
        <fieldset style="border: 1px groove; border-color: #000">
            <legend>Página do Administrador</legend>
            <form action="<?php echo BASE_URL; ?>painel/sisEditPropriedadeADMIN" method="POST">
                <h2>ADMIN</h2>
                <input type="text" name="site_painel" value="<?php //echo($this->config['site_painel']);?>"/><br/><br/>
                <h4>Titulo ADMIN</h4>
                <input type="text" name="site_title_painel" value="<?php //echo($this->config['site_title_painel']);?>"/><br/><br/>
                <h4>Welcome ADMIN</h4>
                <input type="text" name="painel_welcome" value="<?php //echo($this->config['painel_welcome']);?>"/><br/><br/>
                <input type="submit" name="Enviar" class="button" value="Enviar Dados"/>
            </form>
        </fieldset>
		-->
</div>
        
<br/><br/><br/><br/>