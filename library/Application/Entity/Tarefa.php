<?php
namespace Application\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="tarefas")
 */
class Tarefa {
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $nome;
    
    /**
     * @Column(type="integer")
     */
    protected $custo;
    
    /**
     * @Column(type="integer")
     */
    protected $passo;
    
    /**
     * @OneToMany(targetEntity="Requisito", mappedBy="tarefa",cascade={"persist", "remove"}) 
     * @var ArrayCollection 
     */
    protected $requisitos;
    
    /**
     * @OneToMany(targetEntity="Beneficio", mappedBy="tarefa",cascade={"persist", "remove"}) 
     * @var ArrayCollection 
     */    
    protected $beneficios;
    
    function __construct($nome, $custo, $passo) {
        $this->nome = $nome;
        $this->custo = $custo;
        $this->passo = $passo;
        
        $this->requisitos = new ArrayCollection();
        $this->beneficios = new ArrayCollection();
    }

         
    public function getNome() {
        return $this->nome;
    }

    public function getCusto() {
        return $this->custo;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getPasso() {
        return $this->passo;
    }
    
    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCusto($custo) {
        $this->custo = $custo;
    }

    public function setPasso($passo) {
        $this->passo = $passo;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getRequisitos() {
        return $this->requisitos;
    }

    /**
     * @param Requisito $requisito 
     */
    public function addRequisito(Requisito $requisito) {
        $requisito->setTarefa($this);
        $this->requisitos->add($requisito);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getBeneficios() {
        return $this->beneficios;
    }
    
    /**
     * @param Requisito $requisito 
     */
    public function addBeneficio(Beneficio $beneficio) {
        $beneficio->setTarefa($this);
        $this->beneficio->add($beneficio);
    }
}