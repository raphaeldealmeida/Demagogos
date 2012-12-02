<?php

class Default_SessionController extends Zend_Controller_Action
{

    public function init()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
    }

    public function indexAction()
    {
        $form = new Form_Login();
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $adapter = new Rph_Auth_Adapter($form->getValue('login'),
                                                sha1($form->getValue('senha')));
                $result = Zend_Auth::getInstance()->authenticate($adapter);
                if (Zend_Auth::getInstance()->hasIdentity()){
                    return $this->_helper->redirector('index', 'index', 'default');
                }else{
                    $this->_helper->FlashMessenger(implode(' ', $result->getMessages()));
                }
            } else {
                $form->populate($formData);
            }
        }
    }
    
    public function loginAction() {
      
    }
    
    public function createAction() {
      
    }
    
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->FlashMessenger('Você saiu da sua conta.');
        return $this->_helper->redirector('index');
    }
}