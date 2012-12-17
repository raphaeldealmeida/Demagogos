<?php

use Application\Entity;

class Admin_UsuariosController extends Zend_Controller_Action {

  public function init() {
    /**
     * @var Doctrine\ORM\EntityManager
     */
    $this->_em = $this->getInvokeArg('bootstrap')->getResource('doctrine')->getEntityManager();
    $this->_helper->layout->setLayout('admin');
  }

  public function indexAction() {
    $dql = "SELECT u FROM Application\Entity\Usuario u";

    $query = $this->_em->createQuery($dql);
    $query->setMaxResults(30);
    $usuarios = $query->getResult();

    $this->view->usuarios = $usuarios;
  }

  public function addAction() {
    $form = new Form_Usuario();
    $form->submit->setLabel('Add');
    $this->view->form = $form;

    if ($this->getRequest()->isPost()) {
      $formData = $this->getRequest()->getPost();
      if ($form->isValid($formData)) {
        $nome = $form->getValue('nome');
        $energia = $form->getValue('energia');
        $email = $form->getValue('email');
        $senha = $form->getValue('senha');

        $usuario = new Entity\Usuario();
        $usuario->setNome($nome);
        $usuario->setEnergia($energia);
        $usuario->setEnergiaMaxima($energia);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);

        $this->_em->persist($usuario);
        $this->_em->flush();
        $this->_helper->FlashMessenger(array('success' => 'Usuário salvo com sucesso.'));
        return $this->_helper->redirector('show', 'usuarios', 'admin', array('id' => $usuario->getId()));
      } else {
        $this->_helper->FlashMessenger->addMessage(array('error'=>'Preencha o formulário corretamente.'));
        $form->populate($formData);
      }
    }
  }

  public function showAction() {
    $id = (int) $this->_getParam('id', 0);

    if ($id) {
      $usuario = $this->_em->find('Application\Entity\Usuario', $id);
      $this->view->usuario = $usuario;
    } else {
      $this->_helper->FlashMessenger->addMessage(array('error' => 'Usuario não encontrado.'));
      return $this->_helper->redirector('index');
    }
  }

  public function editAction() {
    $form = new Form_Usuario();
    $form->getElement('senha')->removeValidator('NotEmpty');
    
    $form->submit->setLabel('Edit');
    $this->view->form = $form;

    if ($this->getRequest()->isPost()) {
      $formData = $this->getRequest()->getPost();
      if ($form->isValid($formData)) {
        $id = (int) $form->getValue('id');
        $usuario = $this->_em->find('Application\Entity\Usuario', $id);

        $usuario->setNome($form->getValue('nome'));
        $usuario->setEnergia($form->getValue('energia'));
        $usuario->setEnergiaMaxima($form->getValue('energia'));
        $usuario->setSaldo($form->getValue('saldo'));
        $usuario->setEmail($form->getValue('email'));
        $senha = $form->getValue('senha');
        if(!empty($senha)){
            $usuario->setSenha($senha);
        }
        
        $this->_em->persist($usuario);
        $this->_em->flush();
        $this->_helper->FlashMessenger->addMessage(array('success' =>'Usuario editado com sucesso.'));
        return $this->_helper->redirector('show', 'usuarios', 'admin', array('id' => $usuario->getId()));
      } else {
        $this->_helper->FlashMessenger->addMessage(array('error' => 'Ocorreu um erro na edição do usuario.'));
        $form->populate($formData);
      }
    } else {
      $id = $this->_getParam('id', 0);

      $usuario = $this->_em->find("Application\Entity\Usuario", $id);
      if (!is_null($usuario)) {
        $form->populate(array('id' => $id, 
                              'nome' => $usuario->getNome(), 
                              'energia' => $usuario->getEnergia(),
                              'email' => $usuario->getEmail(),
                              'saldo' => $usuario->getSaldo()
                      )
                );
        $this->view->usuario = $usuario;
      } else {
        $this->_helper->FlashMessenger->addMessage(array('error' => 'Usuario não encontrado.'));
        return $this->_helper->redirector('index');
      }
    }
  }
  
  public function deleteAction()
    {
        $id = (int) $this->_getParam('id', 0);
        
        if ($id){
            $usuario = $this->_em->find('Application\Entity\Usuario', $id);
            $this->_em->remove($usuario);
            $this->_em->flush();
            $this->_helper->FlashMessenger->addMessage(array('success' => 'Usuário excluido com sucesso.'));
            return $this->_helper->redirector('index');
        }
    }

}