<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NFSWeb\Controllers;

class MasterController{
    
    public $page_data = array();
    public $page_meta = array();
    
    protected function __construct($params = array()) {
        ;
    }
    
    public function getPageData() {
        return $this->page_data;
    }

    public function getPageMeta() {
        return $this->page_meta;
    }

    public function setPageData($page_data) {
        $this->page_data = $page_data;
    }

    public function setPageMeta($page_meta) {
        $this->page_meta = $page_meta;
    }

}