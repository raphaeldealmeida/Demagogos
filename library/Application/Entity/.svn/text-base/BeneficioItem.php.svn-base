<?php
namespace Application\Entity;
/**
 * @Entity
 * @Table(name="beneficio_item")
 */
class BeneficioItem extends Beneficio{
    
   /**
    * @ManyToOne(targetEntity="Item")
    * @var Application\Entity\Item
    */
    protected $item;
    
    public function setItem($item) {
        $this->item = $item;
    }
    
    public function getItem() {
        return $this->item;
    }
            
    public function fornecerPara(Usuario $usuario){
        $usuario->addItem($this->getItem());
    }
}