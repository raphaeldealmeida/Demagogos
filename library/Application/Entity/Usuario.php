<?php
namespace Application\Entity;
use \DateTime,
    \DateInterval,
    Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="usuarios")
 */
class Usuario{
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Column(type="integer")
     */
    protected $fbId = 0;
        
    /**
     * @Column(type="string")
     */
    protected $nome;
    
    /**
     * @Column(type="string")
     */
    protected $email;
    
    /**
     * @Column(type="string")
     */
    protected $senha;
    
    /**
     * @Column(type="integer")
     */
    protected $energia;
    
    /**
     * @Column(type="integer")
     */
    protected $energiaMaxima;
    
    /**
     * @Column(type="datetime", nullable="true")
     * @var DateTime
     */
    protected $ultimaAtualizacaoEnergia;

    /**
     * @OneToMany(targetEntity="Realizacao", mappedBy="usuario",cascade={"persist", "remove"}) 
     * @var ArrayCollection 
     */
    protected $realizacoes;
    
    
    /**
     * @Column(type="integer")
     * @var int 
     */
    protected $saldo = 0;
    
    /**
     * @OneToMany(targetEntity="Inventario", mappedBy="usuario",cascade={"persist", "remove"}) 
     * @var ArrayCollection 
     */
    protected $inventario; 
    
    public function __construct()
    {
        $this->realizacoes = new ArrayCollection();
        $this->inventario = new ArrayCollection();
    }
    
    public function getInventario() {
        return $this->inventario;
    }
    
    public function addItem(Item $item) {
        $inventario = new Inventario();
        $inventario->setItem($item);
        $inventario->setUsuario($this);

        $key = false;
        foreach ($this->inventario as $k => $i){
           if($i->getItem()->getId() == $item->getId()){
               var_dump($key = $k);
               break;
           }
        }
        
        if($key === false){
            $this->inventario->add($inventario);    
        }else{
            $inventario = $this->inventario->get($key);
            $inventario->addQuantidade(1);
        }
    }
    
    public function addRealizacao(Realizacao $realizacao)
    {
        $realizacao->setUsuario($this);
        $this->realizacoes->add($realizacao);
    }

    public function getRealizacoes() {
        return $this->realizacoes;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    //FIX Não ultrapassar energia máxima
    public function getEnergia() {
        return $this->energia;
    }

    public function setNome($string) {
        $this->nome = $string;
        return true;
    }
    
    public function setEnergia($integer) {
        $this->energia = $integer;
        return true;
    }
    
    public function getEnergiaMaxima() {
        return $this->energiaMaxima;
    }

    public function setEnergiaMaxima($energiaMaxima) {
        $this->energiaMaxima = $energiaMaxima;
    }
    
    public function getUltimaAtualizacaoEnergia() {
        return $this->ultimaAtualizacaoEnergia;
    }

    public function setUltimaAtualizacaoEnergia($ultimaAtualizacaoEnergia) {
        $this->ultimaAtualizacaoEnergia = $ultimaAtualizacaoEnergia;
    }

    public function setSaldo($saldo) {
        $this->saldo = $saldo;
    }
        
    public function getSaldo() {
        return $this->saldo;
    }
    
    public function getEmail() {
      return $this->email;
    }

    public function setEmail($email) {
      $this->email = $email;
    }

    public function getSenha() {
      return $this->senha;
    }

    public function setSenha($senha) {
      $this->senha = sha1($senha);
    }

    
        
    /**
     *
     * @param Integer $energia 
     * @return boolean
     */
    public function pagarEnergia($energia) {
        $resultado = $this->energia - $energia;
        if($resultado < 0){
            return false;
        }else{
            $this->energia = $resultado;
            $this->ultimaAtualizacaoEnergia = new \DateTime("now");
            return true;
        }
        
    }
    
    /**
     *
     * @return null | DateInterval 
     */
    public function atualizarEnergia($now = null){
        if($this->energia < $this->energiaMaxima){
            $now = (is_null($now))? new DateTime("now") : $now;
            $intervalo = $this->ultimaAtualizacaoEnergia->diff($now);
            
            //OPTIMIZE retirar número mágico
            $intervaloEmsegundos = $intervalo->s + ($intervalo->i * 60) + 
                    ($intervalo->h * 60 * 60) + ($intervalo->d * 60 * 60 * 60);
            $energiaRecuperada = (int) ($intervaloEmsegundos / 60);
            
            if($energiaRecuperada > 0){
                if(($this->energia + $energiaRecuperada) > $this->energiaMaxima){
                    $this->energia = $this->energiaMaxima;
                    $this->ultimaAtualizacaoEnergia = new DateTime("now");
                }else{            
                    $this->energia += $energiaRecuperada;
                    $this->ultimaAtualizacaoEnergia = new DateTime("now");
                }
            }
            $ultimaAtualizacaoEnergia = clone $this->ultimaAtualizacaoEnergia;
            
            $ultimaAtualizacaoEnergia->add(new DateInterval('P0M0DT0H1M0S'));
            
            return $ultimaAtualizacaoEnergia->diff($now);
        }
    }
}