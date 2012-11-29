<?php
namespace Application\Entity;
/**
 * @Entity
 * @Table(name="requisito_tarefa")
 */
class RequisitoTarefa extends Requisito{
    
   /**
    * @ManyToOne(targetEntity="Tarefa")
    * @var Tarefa
    */
    protected $tarefaRequisito;
    
    public function setTarefaRequisito(Tarefa $tarefaRequisito) {
        $this->tarefaRequisito = $tarefaRequisito;
    }
    
    public function getTarefaRequisito() {
        return $this->tarefaRequisito;
    }
           
    public function verificar(Usuario $usuario){
        $realizacoes = $usuario->getRealizacoes();
        $realizacao=null;
        foreach ($realizacoes as $r){
            if($r->getTarefa() == $this->tarefaRequisito){
                $realizacao = $r;
            }
        }
        
        if(is_null($realizacao)){
            throw new \Exception('Não cumpriu a tarefa: '.$this->tarefaRequisito->getNome());
        }
    }
    
    public function cumprir(Usuario $usuario){
        $this->verificar($usuario);
    }
}
