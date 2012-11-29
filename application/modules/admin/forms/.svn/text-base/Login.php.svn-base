<?php
class Admin_Form_Login extends Zend_Form
{
    public function init() {
        
        $this->setName('Login');
                      
                
        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('Login')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $senha = new Zend_Form_Element_Password('senha');
        $senha->setLabel('Senha')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $submit = new Zend_Form_Element_Submit('Entrar');
       
        $this->addElements(array($login, $senha, $submit));
    }
}
?>
