<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function subSeachCategoria($subs = array(), $level="0", $category) {
    foreach ($subs as $cat){
        echo '<option '.($category==$cat['id']?'selected="selected"':'').' value="'.$cat['id'].'">';
        for($q=0;$q<$level;$q++){
            echo('-- ');
        }
        echo utf8_encode($cat['nome']);
        echo '</option>';
        if (count($cat['subs']) > 0){
            subSeachCategoria($cat['subs'], $level+1, $category);
        }
    }
}
?>

<input type="text" name="s" required value="<?php echo(!empty($busca)?$busca:'');?>" placeholder="<?php $this->lang->get('SEARCHFORANITEM'); ?>" />
                                                        <select name="category">
                                                            <option value=""><?php $this->lang->get('ALLCATEGORIES'); ?></option>
                                                                <?php foreach ($categorias as $cat) :?>
                                                            <option <?php echo($category==$cat['id']?'selected="selected"':'');?> value="<?php echo ($cat['id']); ?>">
                                                                    <?php echo utf8_encode($cat['nome']); ?>
                                                                </option>
                                                                    <?php if (count($cat['subs']) > 0){
                                                                        subSeachCategoria($cat['subs'], 1, $category);
                                                                    }?>
                                                                <?php endforeach; ?>
							</select>
							<input type="submit" value="" />