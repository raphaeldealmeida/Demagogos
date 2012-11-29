<?php
namespace Application\Entity;
/**
 * @Entity
 * @Table(name="beneficos")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"item" = "BeneficioItem", "monetario" = "BeneficioMonetario"})
 */
abstract class Beneficio{
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ManyToOne(targetEntity="Tarefa", inversedBy="beneficios")
     * @var Tarefa
     */
    protected $tarefa;

    public function getId() {
        return $this->id;
    }

    public function setTarefa($tarefa) {
        $this->tarefa = $tarefa;
    }
    
    public function getTarefa() {
        return $this->tarefa;
    }

    public abstract function fornecerPara(Usuario $usuario);
}