<?php
namespace Application\Entity;
/**
 * @Entity
 * @Table(name="inventario")
 */
class Inventario{
    
    /**
     * @Id 
     * @ManyToOne(targetEntity="Usuario", inversedBy="inventario")
     * @var Usuario
     */
    protected $usuario;
    
    /**
     * @Id
     * @ManyToOne(targetEntity="Item", fetch="EAGER")
     * @var Item
     */
    protected $item;
    
    /**
     * @Column(type="integer")
     * @var int
     */
    protected $quantidade = 1;
    
    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function getItem() {
        return $this->item;
    }

    public function setItem($item) {
        $this->item = $item;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }
    
    public function addQuantidade($quantidade) {
        $this->quantidade += $quantidade;
    }

    public function subQuantidade($quantidade) {
        if(($this->quantidade - $quantidade) <= 0){
            return false;
        }else{
            $this->quantidade -= $quantidade;    
        }
    }
}