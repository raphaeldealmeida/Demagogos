<?
class Application_ControllerTestHelper extends Zend_Test_PHPUnit_ControllerTestCase {

  public function setUp() {
    $this->bootstrap = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');

    parent::setUp();
    $this->loginAdmin('admin@admin.com.br', '123');
  }

  public function teardown() {
    \Mockery::close();
  }

  public function loginAdmin($user, $password) {
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
  
  public function assertFlashMessenger($messenger) {
    Zend_Controller_Action_HelperBroker::removeHelper('FlashMessenger');
    $mockFlashMessenger = \Mockery::mock('Zend_Controller_Action_Helper_FlashMessenger[getName, addMessage]')
            ->shouldReceive('addMessage')->with($messenger)->once()
            ->shouldReceive('getName')->andReturn('FlashMessenger')
            ->mock();
    Zend_Controller_Action_HelperBroker::addHelper($mockFlashMessenger);
  }

}