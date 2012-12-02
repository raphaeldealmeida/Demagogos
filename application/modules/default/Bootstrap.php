<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap
{
    
    protected function _initPlugins() {
        $bootstrap = $this->getApplication();
        if ($bootstrap instanceof Zend_Application) {
            $bootstrap = $this;
        }
        $bootstrap->bootstrap('FrontController');
        $front = $bootstrap->getResource('FrontController');

        $front->registerPlugin(new Application_Controller_Plugin_AtualizaEnergia);
        $front->registerPlugin(new Application_Controller_Plugin_GamerLoginRequired());
    }
}