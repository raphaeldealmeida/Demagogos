<?php
require_once __DIR__ . '/../../../ControllerTestHelper.php';

class Admin_UsuariosControllerTest extends Application_ControllerTestHelper{

  public function testIndex() {
    $params = array('action' => 'index', 'controller' => 'Usuarios', 'module' => 'admin');
    $urlParams = $this->urlizeOptions($params);
    $url = $this->url($urlParams);
    $this->dispatch($url);

    $this->assertModule($urlParams['module']);
    $this->assertController($urlParams['controller']);
    $this->assertAction($urlParams['action']);
    $this->assertQueryContentContains('h2', 'Listando Usuários');
  }

  /**
   * @group wip
   */
  public function testAddAction() {
    $params = array('action' => 'add',
        'controller' => 'usuarios',
        'module' => 'admin');

    $url = $this->url($params);

    $this->request->setMethod('POST')
            ->setPost(array('nome'    => 'Raphael Almeida', 
                            'energia' => '100',
                            'email'   => 'jaguarnet7@gmail.com',
                            'senha'   => '123'));

    //$this->assertFlashMessenger('Usuário salvo com sucesso.');
    $this->dispatch($url);
    
    $this->assertController('usuarios');
    //$this->assertAction('show');
    $this->assertModule('admin');
    
    //$this->assertRedirectRegex('#/admin/usuarios/show/id/[0-9]#');
    $this->assertRedirect();
  }
  
      public function testEditAction()
    {
        $params = array('action' => 'edit', 'controller' => 'Usuarios', 'module' => 'admin', 'id' => 1);
        $urlParams = $this->urlizeOptions($params);
        $url = $this->url($urlParams);
        $this->dispatch($url);
        
        $this->assertController($urlParams['controller']);
        $this->assertAction($urlParams['action']);
        $this->assertModule($urlParams['module']);
                
        $this->assertXpath("//input[@type='submit' and  @value='Edit']");
    }

}