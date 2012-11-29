<?php

class Admin_TarefasControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function setUp()
    {
        $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        parent::setUp();
        $this->loginAdmin('admin', 'admin');
    }
    
    public function teardown()
    {
        \Mockery::close();
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
        $params = array('action' => 'index', 'controller' => 'Tarefas', 'module' => 'admin');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertQueryContentContains('h2', 'Listando Tarefas');
        $this->assertQueryContentContains('ul li a', 'Criar nova Tarefa');
        //$this->assertQueryContentContains('a[href*="/tarefas/edit/id/"]', 'Editar');
        //$this->assertQueryContentContains('a[href*="/tarefas/delete/id/"]', 'Excluir');
    }

    
    public function assertFlashMessenger($messenger) {
       Zend_Controller_Action_HelperBroker::removeHelper('FlashMessenger');
       $mockFlashMessenger = \Mockery::mock('Zend_Controller_Action_Helper_FlashMessenger[getName, addMessage]')
                ->shouldReceive('addMessage')->with($messenger)->once()
                ->shouldReceive('getName')->andReturn('FlashMessenger')
                ->mock();
        Zend_Controller_Action_HelperBroker::addHelper($mockFlashMessenger);
    }

    /**
     * @group wip
     */
    public function testAddAction()
    {
        $params = array('action'     => 'add', 
                        'controller' => 'tarefas', 
                        'module'     => 'admin');

        $url = $this->url($params);
        
        $this->request->setMethod('POST')
                      ->setPost(array('nome'  => 'TarefaAdd', 
                                      'custo' => '1', 
                                      'passo' => '1'
                      ));

        $this->assertFlashMessenger('Tarefa salva com sucesso.');
        $this->dispatch($url);
        $this->assertRedirectRegex('#/admin/tarefas/show/id/[0-9]#');
    }

    public function testEditAction()
    {
        $params = array('action' => 'edit', 'controller' => 'Tarefas', 'module' => 'admin');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        $this->assertModule($urlParams['module']);
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertXpath("//input[@type='submit' and  @value='Edit']");
    }

    //FIX: Erro do teste de redirecionamento
    public function _testDeleteAction()
    {
        $params = array('action' => 'delete', 'controller' => 'Tarefas', 'module' => 'default',
            'id' => '5');
        
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        
        $this->assertRedirect();
        $this->dispatch($url);
        $this->assertXpathContentContains('//div#mensagem','Tarafa exclu ida com sucesso.');
    }
    
    public function testEdiatarTarefaInexistente() {
        $params = array('action' => 'edit', 'controller' => 'Tarefas', 
            'module' => 'admin', 'id' => '9999');
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        $this->assertRedirectTo('/admin/Tarefas');
    }
}