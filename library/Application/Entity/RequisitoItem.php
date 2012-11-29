<?php
namespace Application\Entity;
/**
 * @Entity
 * @Table(name="requisito_item")
 */
class RequisitoItem extends Requisito{
    
   /**
    * @ManyToOne(targetEntity="Item")
    * @var Item
    */
    protected $item;
    
    public function setItem(Item $item) {
        $this->item = $item;
    }
    
    public function getItem() {
        return $this->item;
    }
           
    /**
     *
     * @param Usuario $usuario
     * @return int Key for Inventario
     */
    public function verificar(Usuario $usuario){
        $inventarios = $usuario->getInventario()->toArray();
        $inventario=null;
        $key=null;
        foreach ($inventarios as $k => $i){
            if($i->getItem()->getId() == $this->item->getId()){
                $inventario = $i;
                $key = $k;
            }
        }
        
        if(is_null($inventario)){
            throw new \Exception('Não possui o item: '.$this->item->getNome());
        }
        return $key;        
    }
    
    public function cumprir(Usuario $usuario){
        $key = $this->verificar($usuario);
        $inventario = $usuario->getInventario()->get($key);
        if(!$inventario->subQuantidade(1)){
            $usuario->getInventario()->removeElement($inventario);
        }
    }
}