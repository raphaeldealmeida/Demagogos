<?php

class Form_Requisito_Tarefa extends Form_Requisito
{   
    public function init()
    {
        parent::init();
        
        $tipo = new Zend_Form_Element_Hidden('tipo');
        $tipo->setValue('Tarefa');
        
        
        $em = Zend_Registry::get('doctrine')->getEntityManager();
        $dql = "SELECT t FROM Application\Entity\Tarefa t";
        $query =  $em->createQuery($dql);
        $tarefas = $query->getResult();
        
        
        $tarefaRequirida = new Zend_Form_Element_Select('tarefa_req');
        $tarefaRequirida->setLabel('Tarefa Obrigatória')
             ->setRequired(true)
             ->addValidator('NotEmpty');
        foreach ($tarefas as $t){
            $tarefaRequirida->addMultiOption($t->getId(), $t->getNome());
        }
        
        $submit = new Zend_Form_Element_Submit('salvar');
       
        $this->addElements(array($tipo, $tarefaRequirida, $submit));
    }
}