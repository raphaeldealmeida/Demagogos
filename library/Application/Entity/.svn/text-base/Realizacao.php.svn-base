<?php
namespace Application\Entity;
/**
 * @Entity
 * @Table(name="tarefas_usuarios")
 */
class Realizacao {
    
    /**
     * @Id
     * @ManyToOne(targetEntity="Tarefa", fetch="EAGER")
     * @var Tarefa
     */
    protected $tarefa;
    
    /**
     * @Id
     * @ManyToOne(targetEntity="Usuario", inversedBy="realizacoes")
     * @var Usuario
     */
    protected $usuario;
    
    /**
     * @Column(type="integer")
     * @var Integer
     */
    protected $execucao;
    
    
    public function getTarefa() {
        return $this->tarefa;
    }
    
    public function getUsuario() {
        return $this->usuario;
    }

        public function getExecucao() {
        return $this->execucao;
    }
    
    public function setExecucao($execucao) {
        $this->execucao = $execucao;
    }
    
    public function setTarefa(Tarefa $tarefa) {
        $this->tarefa = $tarefa;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
}
