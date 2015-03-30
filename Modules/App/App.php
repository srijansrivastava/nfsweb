<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NFSWeb\App;

use NFSWeb\App\Router;
use NFSWeb\App\Request;


class App{
    
    protected static $_controller_name;
    protected static $_Controller;
    protected static $_action;
    protected static $_city;
    protected static $_view_file;
    protected static $_params = array();
    protected static $_request_method;
    protected static $_Request;
    protected static $_Response;
    protected static $_data;
    protected static $_meta_data;


    public static function run(){
        self::init();
        self::route();
        self::execute();
        self::render();
        self::dispatch();
    }
    
    public static function init() {
        $Request = new Request();
        self::setRequest($Request);
        
        // session 
        // cookie 
        
        $Response = new Response();
        self::setResponse($Response);
        
        
    }
    
    private static function route(){
        
        $Request = self::getRequest();
        
        $Router = new Router($Request->getUri(), $Request->getOffset());
        
        self::setAction($Router->getAction());
        self::setController($Router->getController());
        self::setCity($Router->getCity());
        self::setView_file($Router->getView_file());
    }
    
    private static function execute(){
        
        $Controller = self::getController();
        $action = self::getAction();
        $Controller->$action();
        
        $pageData = $Controller->getPageData();
        $metaData = $Controller->getPageMeta();
        self::setData($pageData);
        self::setMetaData($metaData);
        
        // city handling 
        // cookie handling 
        // session handling 
        // create controller class --> get data & get meta data 
        // call action function of controller 
    }
    
    private static function render(){
        
        $Response = self::getResponse();
        $Response->init();
        $Response->build();
        
    }
    
    private static function dispatch(){
        
        $Response = self::getResponse();
        $Response->dispatch();
        
    }
    
    public static function getData() {
        if(!empty(self::$_data)){
            return self::$_data;
        }
    }

    public static function setData($data) {
        self::$_data = $data;
    }
    
    public static function getMetaData() {
        return self::$_meta_data;
    }

    public static function setMetaData($meta_data) {
        self::$_meta_data = $meta_data;
    }

    public static function getController_name() {
        return self::$_controller_name;
    }

    public static function getController() {
        return self::$_Controller;
    }

    public static function getAction() {
        return self::$_action;
    }

    public static function getCity() {
        return self::$_city;
    }

    public static function getView_file() {
        return self::$_view_file;
    }

    public static function getParams() {
        return self::$_params;
    }

    public static function getRequest_method() {
        return self::$_request_method;
    }

    public static function getRequest() {
        return self::$_Request;
    }

    public static function getResponse() {
        return self::$_Response;
    }

    public static function setController_name($controller_name) {
        self::$_controller_name = $controller_name;
    }

    public static function setController($Controller) {
        self::$_Controller = $Controller;
    }

    public static function setAction($action) {
        self::$_action = $action;
    }

    public static function setCity($city) {
        self::$_city = $city;
    }

    public static function setView_file($view_file) {
        self::$_view_file = $view_file;
    }

    public static function setParams($params) {
        self::$_params = $params;
    }

    public static function setRequest_method($request_method) {
        self::$_request_method = $request_method;
    }

    public static function setRequest($Request) {
        self::$_Request = $Request;
    }

    public static function setResponse($Response) {
        self::$_Response = $Response;
    }


    
}