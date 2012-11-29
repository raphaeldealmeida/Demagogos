<?php

class Form_Beneficio_Monetario extends Zend_Form
{   
    public function init()
    {
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
        
        $tipo = new Zend_Form_Element_Hidden('tipo');
        $tipo->setValue('Monetario');
        
        $valor = new Zend_Form_Element_Text('valor');
        $valor->setLabel('Valor')
             ->setRequired(true)
             ->addValidator('NotEmpty');
        
        $submit = new Zend_Form_Element_Submit('salvar');
        $this->addElements(array($id, $tipo, $valor, $submit));
    }
}