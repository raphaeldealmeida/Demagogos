<?php

class Admin_IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
        $this->loginAdmin('admin', 'admin');
    }
    
    public function loginAdmin($user, $password)
    {
        $this->request->setMethod('POST')
                      ->setPost(array(
                          'login' => $user,
                          'senha' => $password,
                      ));
        $this->dispatch('/admin/session');
 
        $this->resetRequest()
             ->resetResponse();
 
        $this->request->setPost(array());
     }
    
    public function testIndexAction()
    {
        
        $params = array('action' => 'index', 'controller' => 'Index', 'module' => 'admin');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        //$this->assertQueryContentContains('a', 'Admin');
    }


}