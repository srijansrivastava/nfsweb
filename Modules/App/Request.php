<?php

namespace NFSWeb\App;

class Request{
    
    private $parameters = array();
    private $_uri;
    private $method;
    private $_ip;
    private $_headers = array();
    private $_offset = '';
    
    public function __construct() {
        $this->setUp();
    }
    
    private function setUp(){
        
        $parameters = array();
        // @TODO: user filter_var
        foreach($_REQUEST as $key => $val){
            $parameters[$key] = $val;
        }
        if($parameters && is_array($parameters)){
            $this->setParameters($parameters);
        }
        
        // TODO: dont use global variables directly
        $headers = $_SERVER;
        $this->setHeaders($headers);
        
        $_uri = $headers['REQUEST_URI'];
        $this->setUri($_uri);
        $_offset = '/wh-web';
        $this->setOffset($_offset);
        
        
    }
    public function getOffset() {
        return $this->_offset;
    }

    public function setOffset($offset) {
        $this->_offset = $offset;
    }

    public function setParameters($parameters){
        $this->parameters = $parameters;
    }
    public function getHeaders() {
        return $this->_headers;
    }

    public function setHeaders($headers) {
        $this->_headers = $headers;
    }

        public function getParameters(){
        return $this->parameters;
    }
    
    public function getUri() {
        return $this->_uri;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getIp() {
        return $this->_ip;
    }

    public function setUri($uri) {
        $this->_uri = $uri;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function setIp($ip) {
        $this->_ip = $ip;
    }


}

