<?php
use Application\Entity,
    Application\Service;
class Default_IndexController extends Zend_Controller_Action
{
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;
    
    public function init()
    {
        $this->_em = $this->getInvokeArg('bootstrap')->getResource('doctrine')->getEntityManager();
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        } 
    }

    public function indexAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $auth    = Zend_Auth::getInstance();
        //if ($auth->hasIdentity()) {
            //$this->_helper->redirector('index', 'profile');
            return $this->_redirect('/index/dashboard');
        //}

        $bootstrap = $this->getInvokeArg('bootstrap');
        $config = $bootstrap->getOption('facebook');
        $adapter = new Zend_Auth_Adapter_Facebook($config);
        $token = $this->_getParam('code');
        
        //$this->face($token, $array);
//
        if($token) {
            $adapter->setToken($token);
            $result  = $auth->authenticate($adapter);
            if ($result->isValid()) {
                $access_token = $auth->getIdentity();
                // do your stuff with access token
            } else {
                Zend_Debug::dump($result->getMessages());
            }
        } else {
            $adapter->redirect();
        }
//        
//        Zend_Debug::dump($this->_getAllParams());
//        die();
//
//        return $this->_redirect('/index/dashboard');
        
        require_once 'php-sdk/src/facebook.php';

        $facebook = new Facebook($config);
        $user = $facebook->getUser();

        if ($user) {
          try {
            $user_profile = $facebook->api('/me');
            $this->view->user_profile = $user_profile;
          } catch (FacebookApiException $e) {
            error_log($e);
            $user = null;
          }
        }

        // Login or logout url will be needed depending on current user state.
        if ($user) {
          $loginUrl = $facebook->getLogoutUrl();
        } else {
          $loginUrl = $facebook->getLoginUrl();
        }

        // This call will always work since we are fetching public data.
       // $friends = $facebook->api('/100000874886897/friends');
        
        
        $this->view->user = $user;
        $this->view->loginUrl = $loginUrl;
        $this->view->friends = array();//$friends['data'];
    }

    private function face($access_token, $dataConfig) {
        require_once 'php-sdk/src/facebook.php';
        
        $facebook = new Facebook($dataConfig);
        $facebook->setAccessToken($access_token);
        Zend_Debug::dump($user = $facebook->getUser());
        if ($user) {
            $this->view->faceUrl = $facebook->getLogoutUrl();
        } else {
            $this->view->faceUrl = $facebook->getLoginUrl();
        } 
        
        Zend_Debug::dump($_REQUEST);
        
        Zend_Debug::dump($naitik = $facebook->api('/100000874886897'));
        
        if ($user) {
            try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $facebook->api('/me');
                print_r($user_profile);
            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }
        
        $this->view->user = $naitik;
        
    }
    
    public function faceLoginAction(){
        $this->_helper->viewRenderer->setNoRender();

        $auth    = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            return $this->_redirect('/index/dashboard');
        }

        $bootstrap = $this->getInvokeArg('bootstrap');
        $config = $bootstrap->getOption('facebook');
        $adapter = new Zend_Auth_Adapter_Facebook($config);
        $token = $this->_getParam('code');
        
        if($token) {
            $adapter->setToken($token);
            $result  = $auth->authenticate($adapter);
            if ($result->isValid()) {
                $access_token = $auth->getIdentity();
                // do your stuff with access token
            } else {
                print $result->getMessages();
            }
        } else {
            $adapter->redirect();
        }
    }
    
    public function doctrineAction(){
        /*$testEntity = new Usuario;
        $testEntity->setNome('Zaphod Beeblebrox');
        $testEntity->setEnergia(100);
        $this->_em->persist($testEntity);
        $this->_em->flush();*/
    }
    
    public function dashboardAction()
    {
        $usuario = Zend_Auth::getInstance()->getIdentity();
        $usuario = $this->_em->getRepository('Application\Entity\Usuario')->find($usuario->getId());
        if($usuario instanceof Entity\Usuario){
            $idUsuario = $usuario->getId();

            $this->view->usuario = $usuario;
            
            $tarefa = array();
                       
            $dql = 'select t from Application\Entity\Tarefa t';
            $query = $this->_em->createQuery($dql);
            $tarefas1 = $query->getResult();
            
            foreach ($tarefas1 as $tarefa){
                
                $tarefas[$tarefa->getId()]['tarefa'] = $tarefa;
            }
            
            $realizacoes = $usuario->getRealizacoes();
           
            foreach ($realizacoes as $realizacao){
                $tarefas[$realizacao->getTarefa()->getId()]['realizacao'] = $realizacao;
            }
            $this->view->realizacoes = $realizacoes;
            
            $this->view->tarefas = $tarefas;
            $this->_em->persist($usuario);
            $this->_em->flush();
        }else{
            return $this->_redirect('/');
        }
    }
    
    public function realizarAction() {
        $this->_helper->viewRenderer->setNoRender();
        $tarefa_id = (int) $this->_getParam('tarefa_id', 0);
        $usuario = Zend_Auth::getInstance()->getIdentity();
        $usuario = $this->_em->getRepository('Application\Entity\Usuario')->find($usuario->getId());
      
        $tarefa = $this->_em->find('Application\Entity\Tarefa', $tarefa_id);
                        
        $cumprirTarefa = new Service\CumprirTarefa($tarefa, $usuario);
           
        try {
            $cumprirTarefa->cumprir();
            $this->_em->persist($usuario);
            $this->_em->flush();
        } catch (Exception $e) {
            $this->_helper->FlashMessenger->addMessage(array('error' => $e->getMessage()));
        }

        return $this->_redirect('/index/dashboard');
    }
    
    public function inventarioAction()
    {
        $usuario = Zend_Auth::getInstance()->getIdentity();
        $usuario = $this->_em->getRepository('Application\Entity\Usuario')->find($usuario->getId());
        $this->view->usuario = $usuario;
        $this->view->inventario = $usuario->getInventario();
    }
    
}