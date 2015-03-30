<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace NFSWeb\Controllers;

use NFSWeb\Controllers\MasterController;

class EventController extends MasterController{
    
    private $_id;
    
    public function __construct($params = array()) {
        $slug = isSet($params[0]) ? $params[0] : null;
        if($slug && strpos($slug, '-e-') !== false ){
            $parts = explode('-', $slug);
            $this->_id = array_pop($parts);
        }
        
        parent::__construct($params);
    }
    
    public function detail(){
        $this->setPageData(array(
            'title' => 'This is my Event',
            'venue' => 'Hauz Khas Village',
            'timing'    => '25th April, 6pm onwards'
            ));
        $this->setPageMeta(array(
            'title' => "Event Detail",
            'description' => 'Find out all the details about this event here'
        ));
    }
}