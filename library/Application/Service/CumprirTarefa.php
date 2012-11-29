<?php
namespace Application\Service;
use Application\Entity\Realizacao;

class CumprirTarefa {
    
    /**
     *
     * @var Tarefa
     */
    protected $tarefa;

    /**
     *
     * @var Usuario
     */
    protected $usuario;
    
    public function __construct($tarefa, $usuario) {
        $this->tarefa = $tarefa;
        $this->usuario = $usuario;
    }

    public function cumprir() {
        $realizacoes = $this->usuario->getRealizacoes();
        $realizacao=null;
        foreach ($realizacoes as $r){
            if($r->getTarefa() == $this->tarefa){
                $realizacao = $r;
            }
        }
        
        if($this->usuario->pagarEnergia($this->tarefa->getCusto())){
            if(is_null($realizacao)){
                $realizacao = new Realizacao();
                $realizacao->setTarefa($this->tarefa);
                $this->usuario->addRealizacao($realizacao);
            }
            
            if(count($this->tarefa->getRequisitos()) > 0){
                $requisitos = $this->tarefa->getRequisitos();
                foreach ($requisitos as $requisito){
                    $requisito->cumprir($this->usuario);
                }
            }
            
            $realizacao->setExecucao($realizacao->getExecucao() + 1);
            
            if(count($this->tarefa->getBeneficios()) > 0){
                $beneficios = $this->tarefa->getBeneficios();
                foreach ($beneficios as $beneficio){
                    $beneficio->fornecerPara($this->usuario);
                }
            }
            
            
        }else{
            throw new \Exception('Energia Insuficiente');
        }
    }
    
}