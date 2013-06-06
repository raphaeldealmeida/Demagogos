<?php

class Form_Tarefa extends Zend_Form
{

    public function init()
    {
        $this->setName('Tarefa');
      
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
                
        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome')
             ->setRequired(true)
             ->addFilter('StripTags')
             ->addFilter('StringTrim')
             ->addValidator('NotEmpty');
        
        $custo = new Zend_Form_Element_Text('custo');
        $custo->setLabel('Custo')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $passo = new Zend_Form_Element_Text('passo');
        $passo->setLabel('Passo')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        $submit->setAttrib('class', 'btn btn-primary');
        $this->addElements(array($id, $nome, $custo, $passo, $submit));
    }


}

