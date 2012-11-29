<?php
use Application\Entity;
class Admin_ItensController extends Zend_Controller_Action
{

    public function init()
    {
        /**
         * @var Doctrine\ORM\EntityManager
         */
        $this->_em = $this->getInvokeArg('bootstrap')->getResource('doctrine')->getEntityManager();
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
        $this->_helper->layout->setLayout('admin');
        
    }

    public function indexAction()
    {
        $dql = "SELECT i FROM Application\Entity\Item i";

        $query =  $this->_em->createQuery($dql);
        $itens = $query->getResult();

        $this->view->itens = $itens;
    }
    
    public function addAction()
    {
        $form = new Form_Item();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $nome   = $form->getValue('nome');
                
                $item = new Entity\Item();
                $item->setNome($nome);
                $this->_em->persist($item);
                $this->_em->flush();
                
                $this->_helper->FlashMessenger('Item criado com sucesso');
                return $this->_helper->redirector('index');
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $form = new Form_Item();
        $form->submit->setLabel('Edit');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('id');
                $item = $this->_em->find('Application\Entity\Item', $id);
                
                $item->setNome($form->getValue('nome'));
                $this->_em->persist($item);
                $this->_em->flush();
                $this->_helper->FlashMessenger('Item editado com sucesso.');
                return $this->_helper->redirector('show', 'itens', 'admin', array('id'=>$item->getId()));
            } else {
                $this->_helper->FlashMessenger('Ocorreu um erro na edição do Item.');
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            if ($id > 0) {
                $item = $this->_em->find("Application\Entity\Item", $id);
                $form->populate(array('id'=> $id ,'nome'=>$item->getNome()));
                $this->view->item = $item;
            }
        }
    }

    public function deleteAction()
    {
        $id = (int) $this->_getParam('id', 0);
        
        if ($id){
            $item = $this->_em->find('Application\Entity\Item', $id);
            $this->_em->remove($item);
            $this->_em->flush();
            $this->_helper->FlashMessenger('Item excluido com sucesso.');
            return $this->_helper->redirector('index');
        }
    }
}