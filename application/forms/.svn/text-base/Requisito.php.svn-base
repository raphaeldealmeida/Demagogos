<?php

class Form_Requisito extends Zend_Form
{   
    protected $tarefas;

    public function init()
    {
        $this->setName('Requisito');
        
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
        
        $tarefa = new Zend_Form_Element_Select('tarefa');
        $tarefa->setLabel('Tarefa')
             ->setRequired(true)
             ->addValidator('NotEmpty');
        foreach ($this->tarefas as $t){
            $tarefa->addMultiOption($t->getId(), $t->getNome());
        }
        
        $this->addElements(array($id, $tarefa));
        
    }
    
    public function __construct($tarefas = array()) {
        $this->tarefas = $tarefas;
        parent::__construct();
    }


}

