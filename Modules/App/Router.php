<?php

namespace NFSWeb\App;

class Router{
    
    private $data = array();
    private $uriFragments = null;
    private $city = null;
    private $controller = null;
    private $action = null;
    private $view_file;
    

    public function __construct($_uri, $_offset = null) {
        
        if($_offset){
            $_uri = substr($_uri, strlen($_offset));
        }
        $this->data['_uri'] = $_uri;
        $this->initialiseRequest();
        //$this->test();
    }
    
    public function __get($name) {
        if(isSet($this->data[$name])){
            return $this->data[$name];
        }
    }
    
    public function getController(){
        return $this->controller;
    }
    
    private function setController($controller, $params = array()){
        $class_name = '\\NFSWeb\\Controllers\\'. $controller;
        if(class_exists($class_name)){
            $Controller = new $class_name($params);
            $this->controller = $Controller;
        }
        
    }


    public function getAction(){
        return $this->action;
    }
    
    private function setAction($action){
        $this->action = $action;
    }
    public function getView_file() {
        return $this->view_file;
    }

    public function setView_file($view_file) {
        $this->view_file = $view_file;
    }

        private function getCities(){
        return array(
            'delhi'     => 1,
            'mumbai'    => 2,
            'banglore'  => 3
        );
    }
    
    private function isCity($name){
        $cities = $this->getCities();
        if(isSet($cities[$name])){
            return $cities[$name];
        }
    }
    
    private function getRouteMap(){
        return array(
            'index'             => array('controller' => 'HomeController', 'action' => 'index'),
            'city'              => array(
                                        'index' => array('controller' => 'HomeController', 'action' => 'city'),
                                        'venue' => array('string' => array(
                                                                            'index' => array('controller' => 'VenueController', 'action' => 'detail'),
                                                                        )),
                                        'area' => array(),
                                        'events' => array(),
                                        'match' => array(
                                                    '/([a-zA-Z0-9])*\-e\-([0-9])+/' => array('index' => array('controller' => 'EventController', 'action' => 'detail')),
                                                    '/([a-zA-Z0-9])*\-c\-([0-9])+/'        => array('index' => array('controller' => 'ContentController', 'action' => 'detail')),
                                        ),
                                        //'string' => array('index' => array('controller' => 'EntityController', 'action' => 'process'))
                                    ),
            'tag'               => array('string' => array('index' => array('controller' => 'TagController', 'action' => 'list'))),
            'author'            => array('string' => array('index' => array('controller' => 'AuthorController', 'action' => 'detail'))),
            'critic-review'     => array('string' => array('index' => array('controller' => 'CriticReviewController', 'action' => 'detail'))),
            'search'            => array('string' => array('index' => array('controller' => 'SearchController', 'action' => 'list'))),
        );
    }
    
    private function initialiseRequest($_uri = null){

        if($_uri){
            $this->data['_uri'] = $_uri; 
        }
        
        $Map = $this->getRouteMap();
        
        //var_dump($Map);
        
        $city = null;
        $params = array();
        $_map = $this->lookupMap($Map, $this->getUriFragments(), $params);
        
        $data = array(
            
            'map'           => $_map,
            'city'          => $city,
            'params'        => $params,
            
        );
        
        //var_dump($data);
        
        $action = $_map['action'];
        $controller = $_map['controller'];
        
        $this->setAction($action);
        $this->setController($controller, $params);
        
        $view_file = isSet($_map['view_file']) ? $_map['view_file'] : null;
        if(is_null($view_file)){
            $view_file = str_replace('Controller', "_".$action, $controller);
        }
        $view_file = VIEW_ROOT . strtolower($view_file) . '.php';
        $this->setView_file($view_file);
        
        // @
        
    }
    
    function getUriFragments(){
        if($this->uriFragments){
            return $this->uriFragments;
        }
        $_uri = $this->_uri;
        //var_dump($_uri);
        
        $_uri_parts = explode('?', $_uri);
        $_uri = $_uri_parts[0];
        if(substr($_uri, -1) !== '/'){
            $_uri .= '/';
        }
        //$query_string = isSet($_uri_parts[1]) ? $_uri_parts[1]: "";
        $_uri_parts = explode('/', $_uri);
        
        array_shift($_uri_parts);
        $parts = sizeof($_uri_parts);
        if(trim($_uri_parts[$parts-1]) === ''){
            $_uri_parts[$parts-1] = 'index';
        }
        
        
        $_1_fragment = $_uri_parts[0];
        if($this->isCity($_1_fragment)){
            $this->setCity($_1_fragment) ;
            $_uri_parts[0] = 'city';
        }
        
        $this->uriFragments = $_uri_parts;
        return $_uri_parts;
        
    }
    
    private function setCity($city){
        $this->city = $city;
    }
    
    public function getCity(){
        return $this->city;
    }
    
    function lookupMap($_map, $fragments, &$params){
        
        $continue = true;
        $loop = 10;
        
        while($continue && $loop){
            
            $fragment = array_shift($fragments);
            
            if(isSet($_map[$fragment])){
                $_map = $_map[$fragment];
            }elseif(isSet($_map['string'])){
                $_map = $_map['string'];
                $params[] = $fragment;
            }else if(isSet($_map['match'])) {

                $continue = false;
                $keys = array_keys($_map['match']);
                //var_dump($keys);
                foreach($keys as $pattern){
                    if(preg_match($pattern, $fragment)){
                        $_map = $_map['match'][$pattern];
                        $params[] = $fragment;
                        $continue = true;
                    }
                }
                
            }else{
                $continue = false;
            }
            $loop--;
        }
        
        if(!isSet($_map['controller'])){
            $_map = array(
                'controller'    => 'ExceptionController',
                'action'        => 'notFound'
            );
        }
        return $_map;
    }
    
    function test(){
        $cases = array();
        $cases[] = "/";
        $cases[] = "/delhi/venue/out-of-the-box-v-2038430/";
        $cases[] = "/delhi/";
        $cases[] = "/delhi/best-publs-in-delgi-c-20382";
        $cases[] = "/delhi/ITPL-Roger-federer-e-934394/";
        $cases[] = "/critic-review/the-god-bad-restaurant-review-r-947924";
        $cases[] = "/author/srijan-srivastava";
        $cases[] = "/search/samosa";
        $cases[] = "/tag/mytag/?someparam=someval";
        $cases[] = "/my-page-my-way";
        
        echo '<h3>Running Test Cases</h3>';
        foreach($cases as $_uri){
            $this->initialiseRequest($_uri);
        }
    }
    
    
    
}

?>