<?php
namespace Application\Entity;
/**
 * @Entity
 * @Table(name="requisito_monetario")
 */
class RequisitoMonetario extends Requisito
{
    
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
           
    public function verificar(Usuario $usuario){
        if($usuario->getSaldo() < $this->valor)
            throw new \Exception('Saldo insuficiante.');
    }
    
    public function cumprir(Usuario $usuario){
        $this->verificar($usuario);
        $usuario->setSaldo($usuario->getSaldo() - $this->valor);
    }
}