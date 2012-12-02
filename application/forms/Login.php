<?php
class Form_Login extends Zend_Form
{
    public function init() {
        
        $this->setName('Login');
                      
                
        $login = new Zend_Form_Element_Text('login');
        $login//->setLabel('Login')
              ->setAttrib('placeholder', 'login')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $senha = new Zend_Form_Element_Password('senha');
        $senha//->setLabel('Senha')
              ->setAttrib('placeholder', 'senha')  
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $submit = new Zend_Form_Element_Submit('Entrar');
        $submit->setAttrib('class', 'btn btn-primary');
        
        $this->addElements(array($login, $senha, $submit));
    }
}
?>
