<?php

class Form_Requisito_Monetario extends Form_Requisito
{   
    public function init()
    {
        parent::init();
        
        $tipo = new Zend_Form_Element_Hidden('tipo');
        $tipo->setValue('Monetario');
        
        $valor = new Zend_Form_Element_Text('valor');
        $valor->setLabel('Valor')
             ->setRequired(true)
             ->addValidator('NotEmpty');
        
        $submit = new Zend_Form_Element_Submit('salvar');
        $this->addElements(array($tipo, $valor, $submit));
    }
}