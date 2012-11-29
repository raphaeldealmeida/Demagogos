<?php
use Application\Entity,
    Application\Service;

class Admin_BeneficiosController extends Zend_Controller_Action{
    
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
        
        $formName = 'Form_Beneficio_'.$tipo;
        $form = new $formName();
        $this->view->form = $form;
        
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($form->isValid($formData)) {

                $tarefa = $this->_em->find('Application\Entity\Tarefa', $tarefa_id);
                $config = $form->getValues();
                $config['em'] = $this->_em;
                
                $builderBeneficio = new Service\Builder\Beneficio();
                $beneficio = $builderBeneficio->create(
                        $tarefa, 
                        $form->getValue('tipo'),
                        $config); 
                
                $this->_em->persist($beneficio);
                $this->_em->flush();
                $this->_helper->FlashMessenger('Benefício incluído com sucesso');

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
            $beneficio = $this->_em->find('Application\Entity\Beneficio', $id);
            $this->_em->remove($beneficio);
            $this->_em->flush();
            $this->_helper->FlashMessenger('Benefício excluido com sucesso');
            return $this->_helper->redirector('edit', 'tarefas', 'admin', array('id' => $tarefa_id));
        }
    }
}
