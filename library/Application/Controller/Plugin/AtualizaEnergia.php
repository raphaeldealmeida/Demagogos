<?php
class Application_Controller_Plugin_AtualizaEnergia extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        $module = $request->getModuleName();
        if ($module == 'default'){
            $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
            $viewRenderer->initView();
            $view = $viewRenderer->view;

            $em = Zend_Registry::get('doctrine')->getEntityManager();
            
            //TODO: Usuario fixo
            $usuario = Zend_Auth::getInstance()->getIdentity();
            $usuario = $_SESSION['default']['storage'];
            $usuario = $em->getRepository('Application\Entity\Usuario')->find($usuario->getId());
            if(!is_null($usuario)){
                $content = "Energia: {$usuario->getEnergia()} / {$usuario->getEnergiaMaxima()}";

                $intervalo = $usuario->atualizarEnergia();
                if(!is_null($intervalo)){
                   $proximaRecarga = $intervalo->format('%I:%S');
                   $proximaRecarga = "Mas em <span>$proximaRecarga<span>";

                   $content .= ' '.$proximaRecarga;
                }

                $view->placeholder('energia')->append($content);
            }
        }
    }
}