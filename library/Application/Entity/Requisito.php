<?php
namespace Application\Entity;
/**
 * @Entity
 * @Table(name="requisitos")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"tarefa" = "RequisitoTarefa", "monetario" = "RequisitoMonetario",
 *                    "item" = "RequisitoItem"})
 */
abstract class Requisito{
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ManyToOne(targetEntity="Tarefa", inversedBy="requisitos")
     * @var Tarefa
     */
    protected $tarefa;

    public function getId() {
        return $this->id;
    }

    public function setTarefa(Tarefa $tarefa) {
        $this->tarefa = $tarefa;
    }
    
    public function getTarefa() {
        return $this->tarefa;
    }

    public abstract function verificar(Usuario $usuario);
    
    public abstract function cumprir(Usuario $usuario);

}