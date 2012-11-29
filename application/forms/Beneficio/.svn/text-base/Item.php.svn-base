<?php

class Form_Beneficio_Item extends Zend_Form
{   
    public function init()
    {

        
        $tipo = new Zend_Form_Element_Hidden('tipo');
        $tipo->setValue('Item');
        
        
        $em = Zend_Registry::get('doctrine')->getEntityManager();
        $dql = "SELECT i FROM Application\Entity\Item i";
        $query =  $em->createQuery($dql);
        $itens = $query->getResult();
        
        
        $item = new Zend_Form_Element_Select('item');
        $item->setLabel('Item')
             ->setRequired(true)
             ->addValidator('NotEmpty');
        foreach ($itens as $i){
            $item->addMultiOption($i->getId(), $i->getNome());
        }
        
        $submit = new Zend_Form_Element_Submit('salvar');
       
        $this->addElements(array($tipo, $item, $submit));
    }
}