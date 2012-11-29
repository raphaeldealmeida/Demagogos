<?php
namespace Application\Service\Builder;
use Application\Entity;

class Beneficio
{
    public function __construct() {
        
    }
    
    /**
     * @return Application\Entity\Beneficio
     */
    public function create(\Application\Entity\Tarefa $tarefa, $tipo, $config) {
        switch ($tipo){
            case 'Item'     : $beneficio = $this->createBeneficioItem($config);
                              break;
            case 'Monetario': 
            default         : $beneficio = $this->createBeneficioMonetario($config);
        }
        
        $beneficio->setTarefa($tarefa);
        return $beneficio;
    }
    
    /**
     * @return Application\Entity\BeneficioMonetario
     */
    private function createBeneficioMonetario($config){
        $beneficio = new Entity\BeneficioMonetario();
        $beneficio->setValor($config['valor']);
        
        return $beneficio;
    }
    
    /**
     * @return Application\Entity\BeneficioItem
     */
    private function createBeneficioItem($config){
        $beneficio = new Entity\BeneficioItem();
        $em = $config['em'];
        $item = $em->find('Application\Entity\Item',
                (int) $config['item']);
        $beneficio->setItem($item);
        
        return $beneficio;
    }
}