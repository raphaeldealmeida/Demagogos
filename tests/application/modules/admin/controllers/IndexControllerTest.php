<?php
require_once __DIR__ . '/../../../ControllerTestHelper.php';

class Admin_IndexControllerTest extends Application_ControllerTestHelper
{

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