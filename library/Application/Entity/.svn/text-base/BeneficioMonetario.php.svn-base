<?php
namespace Application\Entity;

/**
 * @Entity
 * @Table(name="beneficio_monetario")
 */
class BeneficioMonetario extends Beneficio{
    
    /**
    * @Column(type="integer") 
    * @var int 
    */
    protected $valor;
    
    public function setValor($valor) {
        $this->valor = $valor;
    }
    
    public function getValor() {
        return $this->valor;
    }
    
    public function fornecerPara(Usuario $usuario){
        $usuario->setSaldo($usuario->getSaldo() + $this->valor);
    }
}