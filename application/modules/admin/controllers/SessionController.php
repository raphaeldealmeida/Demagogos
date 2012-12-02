<?php

class Admin_SessionController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout->setLayout('admin');
    }

    public function indexAction()
    {
        $form = new Admin_Form_Login();
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $adapter = new Rph_Auth_Adapter($form->getValue('login'),
                        sha1($form->getValue('senha')));
                $result = Zend_Auth::getInstance()->authenticate($adapter);
                if (Zend_Auth::getInstance()->hasIdentity()){
                    return $this->_helper->redirector('index','index','admin');
                }else{
                    $this->_helper->FlashMessenger(implode(' ' ,$result->getMessages()));
                }
            } else {
                $form->populate($formData);
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