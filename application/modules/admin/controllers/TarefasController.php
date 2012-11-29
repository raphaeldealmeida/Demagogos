<?php
use Application\Entity;
class Admin_TarefasController extends Zend_Controller_Action
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
        $dql = "SELECT t FROM Application\Entity\Tarefa t";

        $query =  $this->_em->createQuery($dql);
        $query->setMaxResults(30);
        $tarefas = $query->getResult();

        $this->view->tarefas = $tarefas;
    }
    
    public function showAction()
    {
        $id = (int) $this->_getParam('id', 0);
        
        if ($id){
            $tarefa = $this->_em->find('Application\Entity\Tarefa', $id);
            $this->view->tarefa = $tarefa;    
        }else{
            $this->_helper->FlashMessenger('Tarefa não encontrada.');
            return $this->_helper->redirector('index');
        }
    }

    public function addAction()
    {
        $form = new Form_Tarefa();
        $form->submit->setLabel('Add');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $nome   = $form->getValue('nome');
                $custo  = $form->getValue('custo');
                $passo  = $form->getValue('passo');
                
                $tarefa = new Entity\Tarefa($nome, $custo, $passo);
                $this->_em->persist($tarefa);
                $this->_em->flush();
                $this->_helper->FlashMessenger('Tarefa salva com sucesso.');
                return $this->_helper->redirector('show', 'tarefas', 'admin', array('id'=>$tarefa->getId()));
            } else {
                $form->populate($formData);
            }
        }
    }

    public function editAction()
    {
        $form = new Form_Tarefa();
        $form->submit->setLabel('Edit');
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {
                $id = (int)$form->getValue('id');
                $tarefa = $this->_em->find('Application\Entity\Tarefa', $id);
                
                $tarefa->setNome($form->getValue('nome'));
                $tarefa->setCusto($form->getValue('custo'));
                $tarefa->setPasso($form->getValue('passo'));
                $this->_em->persist($tarefa);
                $this->_em->flush();
                $this->_helper->FlashMessenger('Tarafa editada com sucesso.');
                return $this->_helper->redirector('show', 'tarefas', 'admin', array('id'=>$tarefa->getId()));
            } else {
                $this->_helper->FlashMessenger('Ocorreu um erro na edição da tarafa.');
                $form->populate($formData);
            }
        } else {
            $id = $this->_getParam('id', 0);
            
            $tarefa = $this->_em->find("Application\Entity\Tarefa", $id);
            if(!is_null($tarefa)){
                $form->populate(array('id'=> $id ,'nome'=>$tarefa->getNome(), 'custo' => $tarefa->getCusto(), 'passo' => $tarefa->getPasso()));
                $this->view->tarefa = $tarefa;
            }else{
                $this->_helper->FlashMessenger('Tarafa não encontrada.');
                return $this->_helper->redirector('index');
            }
        }
    }

    public function deleteAction()
    {
        $id = (int) $this->_getParam('id', 0);
        
        if ($id){
            $tarefa = $this->_em->find('Application\Entity\Tarefa', $id);
            $this->_em->remove($tarefa);
            //$this->_em->flush();
            $this->_helper->FlashMessenger('Tarafa excluida com sucesso.');
            return $this->_helper->redirector('index');
        }
    }
}