<?php
function subCategoria($subs = array(), $level="0") {
    foreach ($subs as $cat){
        echo ("<ul id=dropmenu".$level." class='collapse panel-collapse'>");
        echo '<li class=active>';
        echo '<a href='.(BASE_URL.'categorias/enter/'.$cat['id']).'>';
        //for($q=0;$q<$level;$q++){echo('-- ');}
        echo utf8_encode($cat['nome']);
        echo '</a>';
        echo '</li>';
        echo ("</ul>");
        if (count($cat['subs']) > 0){
            subCategoria($cat['subs'], $cat['id']);
        }
    }
}

class subCategoriaUI {
    
    private $local;
    
    function __construct() {
        $this->local = array();
        for ($i=0; $i<10; $i++){
            $this->local[$i] = 0;
        }
    }
    
    function subCategoriaEqualsIncrement($level = array(), $sub=0) {
        $key = array_search($sub, $level);
        $this->local[$key] = $this->local[$key]+1;
        if ($this->local[$key] == 1){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function subCategoriaEqualsDecrement($level = array(), $sub=0) {
        $key = array_search($sub, $level);
        $this->local[$key] = $this->local[$key]-1;
        if ($this->local[$key] == 0){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function subCategoriaUI($subs = array(), $level= array()) {
        
        foreach ($subs as $cat){
        //    $this->subCategoriaEquals($level, $cat['sub'], $idSub);
            if ($this->subCategoriaEqualsIncrement($level, $cat['sub']) ){
                echo ("<UL>");
            }
            echo ("<LI>");
            echo ("<div>");
            echo '<a href='.(BASE_URL.'categorias/enter/'.$cat['id']).'>';
            //for($q=0;$q<$level;$q++){echo('-- ');}
            echo utf8_encode($cat['nome']);
            echo '</a>';
            //echo (print_r($level));
            echo ("</div>");
            if (count($cat['subs']) > 0){
                $level[] = $cat['id'];
                $this->subCategoriaUI($cat['subs'], $level);
            }
            echo ("</LI>");
        }
        echo ("</UL>");
        //echo ("<pre>");
        //print_r($this->local);
        //echo ("</pre>");
    }
}




?>
					          
                                        <!--    <li class="dropdown">-->
                                            <ul class="ui-menu" id="menu">
                                                <li>
					        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                    <?php $this->lang->get('SELECTCATEGORY'); ?>
					        <span class="caret"></span></a>
                                                
                                              <!--  <ul class="dropdown-menu ui-menu" id="menu">-->
                                                <ul >
                                                    <?php foreach ($categorias as $cat) :?>
                                                    
                                                    <li class="ui-menu-item">
                                                        <div>
                                                            <a href="#dropmenu<?php echo ($cat['id']); ?>">
                                                                <?php echo utf8_encode($cat['nome']); ?>
                                                            </a>
                                                        </div>
                                                        <?php if (count($cat['subs']) > 0){
                                                            $level = array();
                                                            $level[] = $cat['id'];
                                                            $subCategoria = new subCategoriaUI();
                                                            $subCategoria->subCategoriaUI($cat['subs'], $level);
                                                            //subCategoria($cat['subs'], $cat['id']);
                                                        }?>
                                                    </li>
                                                    <?php endforeach; ?>
					        </ul>
                                              </li>
                                            </ul>
                                        <!--    </li>-->
                                                <?php if (isset($filtroCategoria)) :?>
                                                    <?php foreach ($filtroCategoria as $filtro) :?>
                                                        <li><a href="<?php echo (BASE_URL.'categorias/enter/'.$filtro['id']); ?>">
                                                                <?php echo utf8_encode($filtro['nome']);?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <!--
                                                <ul id="menu">
                                                    <?php foreach ($categorias as $cat) :?>
                                                    
                                                    <li >
                                                        <div>
                                                            <a href="<?php echo (BASE_URL.'categorias/enter/'.$cat['id']); ?>">
                                                                <?php echo utf8_encode($cat['nome']); ?>
                                                                <span class="caret"></span>
                                                            </a>
                                                        </div>
                                                    
                                                        <?php if (count($cat['subs']) > 0){
                                                        //    $level = array();
                                                        //    $level[] = $cat['id'];
                                                        //    $subCategoria = new subCategoriaUI();
                                                        //    $subCategoria->subCategoriaUI($cat['subs'], $level);
                                                        }?>
                                                    </li>
                                                    <?php endforeach; ?>
					        </ul>
                                            -->        