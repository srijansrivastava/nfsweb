<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NFSWeb\App;

class Response{
    
    private $html = '';
    private $meta_data = array();
    private $css_files = array();
    private $js_files = array();
    private $header;
    private $footer;
    private $body;
    private $data;
    
    public function __construct() {
        
    }
    
    function init(){
        $this->setData(App::getData());
        $this->setMetaData(App::getMetaData());
    }
    
    public function build(){
        $this->open();
        $this->addMeta();
        $this->addCssFiles();
        $this->addHeader();
        $this->addBody();
        $this->addFooter();
        $this->addJsFiles();
        $this->close();
    }
    
    public function dispatch(){
        echo $this->getHtml();
    }
    
    private function open(){
        $open_tag = '<html>';
        $this->add($open_tag);
    }
    
    private function close(){
        $close_tag = '</html>';
        $this->add($close_tag);
    }
    
    private function addMeta(){
        $meta = $this->getMetaData();
        $meta_html = '';
        foreach($meta as $key => $val){
            if($key == 'title'){
                $meta_html .= '<title>'.$val.'</title>';
            }else{
                $meta_html .= '<meta name="'.$key.'" content="'.$val.'" />' ;
            }
        }
        $this->add($meta_html);
    }
    
    private function addCssFiles(){
        $css = $this->getCssFiles();
        $html = '';
        foreach($css as $file){
            $html .= '<link rel="stylesheet" type="text/css" href="'.$file.'" />';
        }
        $this->add($html);
    }
    
    private function addHeader(){
        $_html = '';
        include_once VIEW_ROOT . 'common/header.php';
        $this->add($_html);
    }
    
    private function addBody(){
        $view_file = App::getView_file();
        $page_data = $this->getData();
        include_once $view_file;
        $this->add($_html);
    }
    
    private function addFooter(){
        $_html = '';
        include_once VIEW_ROOT . 'common/footer.php';
        $this->add($_html);
    }
    
    private function addJsFiles(){
        
    }
    
    private function add($str){
        $this->html .= $str;
    }
    

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }
    
    public function getHtml() {
        return $this->html;
    }

    public function getMetaData() {
        return $this->meta_data;
    }

    public function getCssFiles() {
        return $this->css_files;
    }

    public function getJsFiles() {
        return $this->js_files;
    }

    public function getHeader() {
        return $this->header;
    }

    public function getFooter() {
        return $this->footer;
    }

    public function getBody() {
        return $this->body;
    }

    public function setHtml($html) {
        $this->html = $html;
    }

    public function setMetaData($meta_data) {
        $this->meta_data = $meta_data;
    }

    public function setCssFiles($css_files) {
        $this->css_files = $css_files;
    }

    public function setJsFiles($js_files) {
        $this->js_files = $js_files;
    }

    public function setHeader($header) {
        $this->header = $header;
    }

    public function setFooter($footer) {
        $this->footer = $footer;
    }

    public function setBody($body) {
        $this->body = $body;
    }


    
    
}
