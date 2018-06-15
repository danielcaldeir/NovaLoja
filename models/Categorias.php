<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categorias
 *
 * @author Daniel_Caldeira
 * CREATE TABLE `categorias` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`sub` INT(11) NULL DEFAULT '0',
	`nome` VARCHAR(100) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=11
;
 */
class Categorias extends model{
    private $id;
    private $sub;
    private $nome;
    private $arrayINCat;
    //put your code here
    
    public function getArvoreCategoria($id) {
        $verificador = TRUE;
        while ($verificador){
            $this->selecionarCategoriasID($id);
            if ($this->numRows() > 0){
                foreach ($this->result() as $item) {
                    $arrayInit[] = $item;
                }
                if ($this->getSub() == 0){
                    $verificador = FALSE;
                } else {
                    $id = $this->getSub();
                }
            }
        }
        $array = array_reverse($arrayInit);
        return $array;
    }
    
    public function ordenarALLCategorias() {
        $this->selecionarALLCategorias();
        if ($this->numRows() > 0){
            foreach ($this->arrayINCat as $key => $item) {
                $this->arrayINCat[$key]['subs'] = array();
                if ($item['sub']==0){
                    $this->arrayINCat[$key]['sub'] = NULL;
                }
            }
            while ($this->necessitaOrganizacao($this->arrayINCat)){
                $this->organizarCategoria();
            }
            
        }
        
        return $this->arrayINCat;
    }
    
    private function identificarKEY($array, $id) {
        foreach ($array as $key => $value) {
            if (!strcmp($value['id'], $id)){
                $sel = $key;
                //echo('-'.$id.','.$sel.','.$value['id'].'-');
                break;
            }
        }
        return $sel;
    }
    
    private function organizarCategoria() {
        $array = $this->arrayINCat;
        foreach($array as $id => $item) {
            if(isset($item['sub'])) {
                $idSub = $item['sub'];
                $key = $this->identificarKEY($array, $idSub);
                $idSubs = $item['id'];
                $this->arrayINCat[$key]['subs'][$idSubs] = $item;
                unset($this->arrayINCat[$id]);
                break;
            }
        }
    }
    
    private function necessitaOrganizacao($array) {
        foreach($array as $item) {
            if(!empty($item['sub'])) {
                return true;
            }
        }
        return false;
    }
    
    public function selecionarALLCategorias() {
        $tabela = "categorias";
        $colunas = array("id","sub","nome");
        $where = array();
        $where_cond = "AND";
        $groupBy = array("ORDER BY sub DESC");
        $this->selecionarTabelas($tabela, $colunas, $where, $where_cond, $groupBy);
        $this->arrayINCat = $this->result();
        return $this->arrayINCat;
    }
    
    public function selecionarCategoriasID($id) {
        $tabela = "categorias";
        $colunas = array("id","sub","nome");
        $where = array(
            "id" => $id
        );
        $this->selecionarTabelas($tabela, $colunas, $where);
        if ($this->numRows > 0){
            $this->arrayINCat = $this->result();
            foreach ($this->arrayINCat as $item) {
                $this->id = $item['id'];
                $this->sub = $item['sub'];
                $this->nome = $item['nome'];
            }
        }
        return $this->arrayINCat;
    }
    
    public function setID($id) {
        $this->id = $id;
    }
    public function getID() {
        return $this->id;
    }
    
    public function setSub($sub) {
        $this->sub = $sub;
    }
    public function getSub() {
        return $this->sub;
    }
    
    public function setNome($nome) {
        $this->nome = $nome;
    }
    public function getNome() {
        return $this->nome;
    }
    
}
