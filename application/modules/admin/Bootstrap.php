<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
    
    public function _initLoginRequired(){
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Rph_Controller_Plugin_LoginRequired());
    }
}