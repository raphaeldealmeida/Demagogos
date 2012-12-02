<?php
class Application_Controller_Plugin_GamerLoginRequired extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        $auth = Zend_Auth::getInstance ();
        $auth->setStorage(new Zend_Auth_Storage_Session('default'));
        
        $module = $request->getModuleName();
        $controller = $request->getControllerName();

        if ($module == 'default' && !in_array($controller, array('session', 'error'))){
            if ($auth->hasIdentity()) {
                //$nome = $auth->getIdentity()->nome;
            } else {
                $flash = Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger');
                $flash->addMessage(array('error' =>'Usuário não logado'));
                $request->setModuleName('default')
                        ->setControllerName('session')
                        ->setActionName('index');
            }
        }
    }

}