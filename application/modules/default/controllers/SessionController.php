<?php
use Application\Entity;

class Default_SessionController extends Zend_Controller_Action
{

    public function init() {
      /**
       * @var Doctrine\ORM\EntityManager
       */
      $this->_em = $this->getInvokeArg('bootstrap')->getResource('doctrine')->getEntityManager();
    }

    public function indexAction()
    {
      $formLogin = new Form_Login();
      $formLogin->setAction($this->view->url(array('controller'=> 'session', 'action'=> 'login')));
      $this->view->formLogin = $formLogin;
      
      $formSignUp = new Form_Usuario();
      $formSignUp->removeElement('saldo');
      $formSignUp->removeElement('energia');
      $formSignUp->setAction($this->view->url(array('controller'=> 'session', 'action'=> 'sign-up')));
      $this->view->formSignUp = $formSignUp;
    }
    
    public function loginAction() {
      
      $form = new Form_Login();
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                
              if($this->loginCheck($form->getValue('login'), $form->getValue('senha'))){
                return $this->_helper->redirector('index', 'index', 'default');
              }else{
                $this->_helper->FlashMessenger(implode(' ', $result->getMessages()));
              }
            } else {
                $form->populate($formData);
                return $this->forward('index');
            }
        }
      
    }
    
    private function loginCheck($login, $senha) {
      
      $adapter = new Rph_Auth_Adapter($login, sha1($senha));
      $result = Zend_Auth::getInstance()->authenticate($adapter);
      return Zend_Auth::getInstance()->hasIdentity();
  }

    public function signUpAction() {
      $form = new Form_Usuario();
      $form->removeElement('saldo');
      $form->removeElement('energia');;
      $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
              $nome = $form->getValue('nome');
              $email = $form->getValue('email');
              $senha = $form->getValue('senha');

              $usuario = new Entity\Usuario();
              $usuario->setNome($nome);
              $usuario->setEnergia(100);
              $usuario->setEnergiaMaxima(100);
              $usuario->setEmail($email);
              $usuario->setSenha($senha);

              $this->_em->persist($usuario);
              $this->_em->flush();
              $this->_helper->FlashMessenger(array('success' => 'Usuário salvo com sucesso.'));
              
              $this->loginCheck($email, $senha);
              return $this->_helper->redirector('index', 'index', 'default');
              
            } else {
                $form->populate($formData);
                return $this->forward('index');
            }
        }
    }
    
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->FlashMessenger->addMessage(array('success' => 'Você saiu da sua conta.'));
        return $this->_helper->redirector('index');
    }
}