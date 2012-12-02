<?php

class Form_Usuario extends Zend_Form
{

    public function init()
    {
        $this->setName('Usuario');
      
        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');
                
        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome')
             ->setRequired(true)
             ->addFilter('StripTags')
             ->addFilter('StringTrim')
             ->addValidator('NotEmpty');
        
        $energia = new Zend_Form_Element_Text('energia');
        $energia->setLabel('Energia')
             ->setRequired(true)
             ->addValidator('Digits')
             ->addValidator('NotEmpty');
        
        $saldo = new Zend_Form_Element_Text('saldo');
        $saldo->setLabel('Saldo')
             ->setRequired(true)
             ->addValidator('Digits')
             ->addValidator('NotEmpty');
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
             ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $senha = new Zend_Form_Element_Password('senha');
        $senha->setLabel('Senha')
              ->setAttrib('placeholder', 'senha')  
             // ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');
        
        $this->addElements(array($id, $nome, $energia, $saldo, $email, $senha, $submit));
    }


}