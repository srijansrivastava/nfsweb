<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$_html = '<div style="padding: 20px 100px;">'
        . '<h2 style="border-bottom: 1px solid #999;">Event Details Page</h2>';

foreach($page_data as $key => $value){
    $_html .= '<div class="col">' . $key . ': </div><h3 class="col">' . $value . '</h3>' ;
}

$_html .= '<div style="border-bottom: 1px solid #999;"></div></div>';