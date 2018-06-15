				  	<aside>
				  		<h1><?php $this->lang->get('FILTER'); ?></h1>
				  		<div class="filterarea">
                                                    <form method="GET">
                                                        <input type="hidden" name="s" value="<?php echo(!empty($busca)?$busca:''); ?>"/>
                                                        <input type="hidden" name="category" value="<?php echo(!empty($category)?$category:''); ?>" />
                                                        <div class="filterbox">
                                                            <div class="filtertitle"><?php $this->lang->get('BRANDS'); ?></div>
                                                            <div class="filtercontent">
                                                                <?php foreach ($filtros['marcas'] as $marcas) :?>
                                                                <div class="filteritem">
                                                                    <input type="checkbox" 
                                                                           name="filter[marca][]" 
                                                                           <?php echo ( isset($filtros_selected['marca']) && in_array($marcas['id'], $filtros_selected['marca']) )?'checked="checked"':''; ?>
                                                                           value="<?php echo ($marcas['id']);?>" 
                                                                           id="filter_marca<?php echo ($marcas['id']);?>"
                                                                    />
                                                                    <label for="filter_marca<?php echo ($marcas['id']);?>"><?php echo($marcas['nome']);?></label><span style="float: right">(<?php echo($marcas['count']);?>)</span>
                                                                </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                        <div class="filterbox">
                                                            <div class="filtertitle"><?php $this->lang->get('PRICE'); ?></div>
                                                            <div class="filtercontent">
                                                                <p>
                                                                    <!--<label for="amount">Price range:</label>-->
                                                                    <input type="hidden" id="slider0" name="filter[slider0]" value="<?php echo $filtros['slider0'];?>"/>
                                                                    <input type="hidden" id="slider1" name="filter[slider1]" value="<?php echo $filtros['slider1'];?>"/>
                                                                    <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                                                                </p>
                                                                <div id="slider-range"></div>
                                                            </div>
                                                        </div>
                                                        <div class="filterbox">
                                                            <div class="filtertitle"><?php $this->lang->get('RATING'); ?></div>
                                                            <div class="filtercontent">
                                                                <?php for ($x=1;$x<7;$x++) :?>
                                                                <div class="filteritem">
                                                                    <input type="checkbox" 
                                                                           name="filter[star][]" 
                                                                           <?php echo ( isset($filtros_selected['star']) && in_array($x, $filtros_selected['star']) )?'checked="checked"':''; ?>
                                                                           value="<?php echo($x);?>" 
                                                                           id="filter_star<?php echo($x);?>"
                                                                    />
                                                                    <?php for($y=1;$y<=$x;$y++):?>
                                                                    <label for="filter_star<?php echo($x);?>"><img src="<?php echo (BASE_URL); ?>assets/images/star.png" height="13" boder="0"/></label>
                                                                    <?php endfor;?>
                                                                    <span style="float: right">(<?php echo($filtros['estrelas'][$x]); ?>)</span>
                                                                </div>
                                                                <?php endfor;?>
                                                            <!--
                                                            <!--    <div class="filteritem">
                                                            <!--        <input type="checkbox" 
                                                            <!--               name="filter[star][]" 
                                                            <!--               <?php echo ( isset($filtros_selected['star']) && in_array('2', $filtros_selected['star']) )?'checked="checked"':''; ?>
                                                            <!--               value="2" 
                                                            <!--               id="filter_star2"
                                                            <!--        />
                                                            <!--        <label for="filter_star2"><img src="<?php echo (BASE_URL); ?>assets/images/star.png" height="13" boder="0"/></label>
                                                            <!--        <label for="filter_star2"><img src="<?php echo (BASE_URL); ?>assets/images/star.png" height="13" boder="0"/></label>
                                                            <!--        <span style="float: right">(<?php echo($filtros['estrelas']['2']); ?>)</span>
                                                            <!--    </div>
                                                            -->
                                                            </div>
                                                        </div>
                                                        <div class="filterbox">
                                                            <div class="filtertitle"><?php $this->lang->get('SALE'); ?></div>
                                                            <div class="filtercontent">
                                                                <div class="filteritem">
                                                                    <input type="checkbox" name="filter[sale][]" <?php echo ( isset($filtros_selected['sale']) && in_array('1', $filtros_selected['sale']) )?'checked="checked"':''; ?> value="1" id="filter_sale"/>
                                                                    <label for="filter_sale"> Em Promoção</label>
                                                                    <span style="float: right">(<?php echo($filtros['promo']); ?>)</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="filterbox">
                                                            <div class="filtertitle"><?php $this->lang->get('OPTIONS'); ?></div>
                                                            <div class="filtercontent">
                                                                <?php foreach ($filtros['options'] as $opcoes) :?>
                                                                <strong><?php echo ($opcoes['nome']);?></strong><br/>
                                                                <?php foreach ($opcoes['opcao'] as $opc) :?>
                                                                    <div class="filteritem">
                                                                        <input type="checkbox" 
                                                                               name="filter[opcao][]" 
                                                                               <?php echo ( isset($filtros_selected['opcao']) && in_array($opc['valor'], $filtros_selected['opcao']) )?'checked="checked"':''; ?>
                                                                               value="<?php echo ($opc['valor']);?>" 
                                                                               id="filter_opcao<?php echo ($opc['id']);?>"
                                                                        />
                                                                        <label for="filter_opcao<?php echo ($opc['id']);?>"><?php echo($opc['valor']);?></label><span style="float: right">(<?php echo($opc['QTD']);?>)</span>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                                <br/>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </form>
				  		</div>
                                            <!--
                                            <!--    <div class="widget">
                                            <!--    	<h1><?php $this->lang->get('FEATUREDPRODUCTS'); ?></h1>
                                            <!--    	<div class="widget_body">
                                            <!--                <!-- Incio da Leitura do Arquio (widgetItem) -->
                                                            <?php 
                                                            //$this->loadView('widgetItem', array('widget'=>$widget_featured1) );
                                                            ?>
                                            <!--                <!-- Fim da Leitura do Arquivo  -->
                                            <!--    	</div>
                                            <!--    </div>
                                                -->
				  	</aside>