<?php
use Application\Entity,
    Application\Service;

class Admin_RequisitosController extends Zend_Controller_Action{
    
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
        return $this->_helper->redirector('admin/index');
    }

    public function addAction()
    {
        $tipo = $this->_getParam('tipo', 'Monetario');
        $tarefa_id = (int) $this->_getParam('tarefa', 0);
        
        if(!$tarefa_id){
            $dql = "SELECT t FROM Application\Entity\Tarefa t";
            $query =  $this->_em->createQuery($dql);
            $tarefas = $query->getResult();
        }else{
            $tarefas[] = $this->_em->find('Application\Entity\Tarefa', $tarefa_id);
        }
        
        $formName = 'Form_Requisito_'.$tipo;
        $form = new $formName($tarefas);
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                $tarefa = $this->_em->find('Application\Entity\Tarefa', $tarefa_id);
                $config = $form->getValues();
                $config['em'] = $this->_em;
                
                $builderRequisito = new Service\Builder\Requisito();
                $requisito = $builderRequisito->create(
                        $tarefa, 
                        $form->getValue('tipo'),
                        $config); 
                
                $this->_em->persist($requisito);
                $this->_em->flush();
                $this->_helper->FlashMessenger('Requisito incluído com sucesso');

                return $this->_helper->redirector('edit', 'tarefas', 'admin', array('id' => $tarefa_id));
            } else {
                $form->populate($formData);
            }
        }
    }
    
    public function deleteAction()
    {
        $id = (int) $this->_getParam('id', 0);
        $tarefa_id = (int) $this->_getParam('tarefa', 0);
        
        if ($id){
            $requisito = $this->_em->find('Application\Entity\Requisito', $id);
            $this->_em->remove($requisito);
            $this->_em->flush();
            $this->_helper->FlashMessenger('Requisito excluido com sucesso');
            return $this->_helper->redirector('edit', 'tarefas', 'admin', array('id' => $tarefa_id));
        }
    }
}
