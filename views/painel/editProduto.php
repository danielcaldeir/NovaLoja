<script>
    function enviarFormulario() {
        var valor = document.getElementById('preco');
        var preco = converteMoedaFloat(valor.value);
        valor.value = preco;
        return true;
    }
</script>
<div class="container-fluid">
    <div class="navbar topnav">
        <h1 class="h1">Editar Produto</h1>
    </div>
    <?php if ( $confirme == "error") :?>
            <div class="alert-warning">
                <label>Preencha todos os Campos</label>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "sucess" ) :?>
            <div class="alert-success">
                <strong>Produto Editado com Sucesso!</strong>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "fotoDEL" ) :?>
            <div class="alert-success">
                <strong>Foto Excluida com Sucesso!</strong>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "fotoADD" ) :?>
            <div class="alert-success">
                <strong>Foto Anexada com Sucesso!</strong>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "fotoERROR" ) :?>
            <div class="alert-warning">
                <strong>Error ao Adicionar ou Excluir uma Foto!</strong>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "successSPECIFICATIONS" ) :?>
            <div class="alert-success">
                <strong>SPECIFICATIONS ao Adicionada/Ediatada/Excluida com success!</strong>
            </div>
    <?php endif; ?>
    <?php if ( $confirme == "errorSPECIFICATIONS" ) :?>
            <div class="alert-warning">
                <strong>error ao Adicionada/Ediatada/Excluida uma SPECIFICATIONS!</strong>
            </div>
    <?php endif; ?>
    <?php if ( !empty($id) ) : ?>
    <?php foreach ($produto as $info) :?>
    <form action="<?php echo BASE_URL; ?>produto/sisEditarProduto/" method="POST" onsubmit="return enviarFormulario()" enctype="multipart/form-data">
        
        <div class="form-group">
            <label for="categoria">Categoria:</label>
            <select name="categoria" id="categoria" class="form-control" required>
            <?php foreach ($cats as $cat): ?>
                <option value="<?php echo($cat['id']); ?>" <?php if($info['id_categoria']==$cat['id']): echo('selected'); endif;?>> 
                    <?php echo utf8_encode($cat['nome']); ?> 
                </option>
            <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <label for="marca">Marca:</label>
            <select name="marca" id="categoria" class="form-control" required>
            <?php foreach ($marcas as $marca): ?>
                <option value="<?php echo($marca['id']); ?>" <?php if($info['id_marca']==$marca['id']): echo('selected'); endif;?>> 
                    <?php echo utf8_encode($marca['nome']); ?> 
                </option>
            <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" class="form-control" value="<?php echo utf8_encode($info['nome']); ?>" required/>
        </div>
        <div class="form-group">
            <label for="descricao">Descricao:</label>
            <textarea name="descricao" id="descricao" class="form-control" required><?php echo utf8_encode($info['descricao']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="estoque">Estoque:</label>
            <button type="button" onclick="javascript:retirar()">-</button>
            <input type="text" id="qtd" name="qtd" disabled value="<?php echo($info['estoque']);?>" class="form-control-static">
            <button type="button" onclick="javascript:estocar()">+</button>
        </div>
        <div class="form-group">
            <label for="precoAnt">Preco Anterior:</label>
            <input type="text" id="preco_Ant" name="preco_Ant" disabled value="<?php echo (number_format($info['preco_ant'],2,",",".")); ?>" class="form-control-static"/>
        </div>
        <div class="form-group">
            <label for="preco">Preco:</label>
            <input type="text" name="preco" id="preco" class="form-control" value="<?php echo(number_format($info['preco'], 2,",",".")); ?>" maxlength="10" onKeyUp="formatarMoeda();" required/>
        </div>
        
        <input type="hidden" id="id" name="id" value="<?php echo($info['id']); ?>"/>
        <input type="hidden" id="usuario" name="usuario" value="<?php echo($_SESSION['id']); ?>" />
        <input type="hidden" id="estoque" name="estoque" value="<?php echo($info['estoque']);?>">
        <input type="hidden" id="precoAnt" name="precoAnt" value="<?php echo (number_format($info['preco'],2,".","")); ?>" />
        <input type="submit" id="botaoEnviarForm" value="SALVAR" class="btn btn-default"/> | 
        <a href="<?php echo BASE_URL; ?>painel/produtos/" class="btn btn-default">VOLTAR</a>
    </form>
            <div class="form-group">
                <form action="<?php echo BASE_URL; ?>foto/addFoto/" method="POST" enctype="multipart/form-data">
                    <label for="add_foto">Fotos do Anuncio:</label><br>
                    <input type="file" name="fotos[]" multiple required/>
                    <input type="hidden" name="id_produto" id="id_produto" value="<?php echo($info['id']); ?>"/>
                    <input type="submit" name="botaoFoto" value="Enviar Fotos"/>
                </form>
                
                <br/>
                <div class="panel panel-default">
                    <div class="panel-heading">Fotos do Anuncio</div>
                    <div class="panel-body">
                        
                    <?php if (is_array($produto_info['imagens']) ) : ?>
                        <?php foreach ($produto_info['imagens'] as $fotos) : ?>
                        <div class="foto_item">
                            <img src="<?php echo BASE_URL; ?>//media//produtos//<?php echo($fotos['url']); ?>" class="img-thumbnail" border="0">
                            <br>
                            <?php if (count($fotos) > 1): ?>
                            <a href="<?php echo BASE_URL; ?>foto/delFoto/<?php echo($fotos['id']); ?>" class="btn btn-danger">Excluir Foto</a>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                        
                    </div>
                </div>
            </div>
    
        
    <?php endforeach; ?>
    
    <br/>
    <hr/>
    <div class="row">
        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php $this->lang->get('PRODUCT_SPECIFICATIONS');?></h3>
                </div>
            <div class="panel-body">
            <?php foreach ($produto_info['opcoes'] as $opcoes) :?>
                    <div>
                        <a href="#EditSPECIFICATIONS<?php echo($opcoes['id_opcao']);?>" data-toggle="collapse" >
                            <strong><?php echo($opcoes['nomeOpcao']);?></strong>: <?php echo($opcoes['valor']);?>
                        </a>
                        <span style="float: right">
                            <a class="btn btn-danger" href="<?php echo BASE_URL; ?>produto/delSpecificacao/<?php echo($opcoes['id']); ?>">
                                Excluir
                            </a>
                        </span>
                    </div>
                <br/>
                <div id="EditSPECIFICATIONS<?php echo($opcoes['id_opcao']);?>" class="collapse panel-collapse">
                    <div class="panel-body">
                        <form action="<?php echo BASE_URL; ?>produto/editSpecificacao/" method="POST">
                            <div class="form-group">
                                <label for="opcao">Opcoes:</label>
                                <select name="opcao" id="opcao" class="form-control" required>
                                <?php foreach ($ops as $op): ?>
                                    <option value="<?php echo($op['id']); ?>" <?php if($opcoes['id_opcao']==$op['id']): echo('selected'); endif;?>> 
                                        <?php echo utf8_encode($op['nome']); ?> 
                                    </option>
                                <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="valorOP">valor:</label>
                                <input type="text" id="valorOP" name="valorOP" value="<?php echo($opcoes['valor']);?>" class="form-control" required/>
                            </div>
                            <input type="hidden" id="id_produto" name="id_produto" value="<?php echo ($opcoes['id_produto']);?>" />
                            <input type="hidden" id="id_opcao" name="id_opcao" value="<?php echo($opcoes['id']); ?>" />
                            <input type="submit" class="btn-default" value="Editar <?php $this->lang->get('PRODUCT_SPECIFICATIONS');?>">
                        </form>
                    </div>
                </div>
            <?php endforeach;?>
            </div>
            
                <div class="panel-footer">
                    <h4 class="panel-info">
                        <a href="#AddSPECIFICATIONS" data-toggle="collapse">Adicionar <?php $this->lang->get('PRODUCT_SPECIFICATIONS');?></a>
                    </h4>
                </div>
                <div id="AddSPECIFICATIONS" class="collapse panel-collapse">
                    <div class="panel-body">
                        <form action="<?php echo BASE_URL; ?>produto/addSpecificacao/" method="POST">
                            <div class="form-group">
                                <label for="opcao">Opcoes:</label>
                                <select name="opcao" id="opcao" class="form-control" required>
                                <?php foreach ($ops as $op): ?>
                                    <option value="<?php echo($op['id']); ?>" > 
                                        <?php echo utf8_encode($op['nome']); ?> 
                                    </option>
                                <?php endforeach;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="valorOP">valor:</label>
                                <input type="text" id="valorOP" name="valorOP" value="" class="form-control" required/>
                            </div>
                            <input type="hidden" id="id_produto" name="id_produto" value="<?php echo ($id);?>" />
                            
                            <input type="submit" class="btn-default" value="Adicionar <?php $this->lang->get('PRODUCT_SPECIFICATIONS');?>">
                        </form>
                    </div>
                </div>
                
                
            </div>
            
        <?php 
        //    echo("<pre>");
        //    foreach ($produto_info['opcoes'] as $opcoes) {
        //        print_r($opcoes);
        //    }
        //    echo("</pre>");
        ?>
        </div>
        <div class="col-sm-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php $this->lang->get('PRODUCT_REVIEWS'); ?></h3>
                </div>
            <?php foreach ($produto_info['avalia'] as $avalia) :?>
                <strong><?php echo($avalia['nomeUser']);?></strong>
                <?php for($q=0;$q< intval($avalia['voto']);$q++):?>
                    <img src="<?php echo BASE_URL; ?>assets/images/star.png" border="0" height="13" />
                <?php endfor;?>
                <br/>
                <q><?php echo($avalia['comentario']);?></q>
                <hr/>
            <?php endforeach;?>
        <?php 
        //    echo("<pre>");
        //    foreach ($produto_info['avalia'] as $avalia) {
        //        print_r($avalia);
        //    }
        //    echo("</pre>");
        ?>
            </div>
            
        </div>
    </div>
    <!--<br/><pre><?php //print_r($produto_info); ?></pre>-->
    <!--<br/><pre><?php //print_r($produto); ?></pre>-->
    
    <br/>
    <br/>
    <br/>
    <?php else : ?>
    <form action="./index.php?pag=meusAnuncios" method="POST">
        <div class="form-group">
            <label>Não foi informado um identificador.</label>
        </div>
        <input type="submit" class="btn btn-default" value="VOLTAR"/>
    </form>
    
    <?php endif; ?>
    
</div>
