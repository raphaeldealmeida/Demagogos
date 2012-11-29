<?php
namespace Application\Service\Builder;
use Application\Entity;

class Requisito
{
    public function __construct() {
        
    }
    
    /**
     * @return Application\Entity\Requisito
     */
    public function create(\Application\Entity\Tarefa $tarefa, $tipo, $config) {
        switch ($tipo){
            case 'Item'     : $requisito = $this->createRequisitoItem($config);
                              break;
            case 'Tarefa'   : $requisito = $this->createRequisitoTarefa($config);
                              break;
            case 'Monetario': 
            default         : $requisito = $this->createRequisitoMonetario($config);
        }
        
        $requisito->setTarefa($tarefa);
        return $requisito;
    }
    
    /**
     * @return Application\Entity\RequisitoMonetario
     */
    private function createRequisitoMonetario($config){
        $requisito = new Entity\RequisitoMonetario();
        $requisito->setValor($config['valor']);
        
        return $requisito;
    }
    
    /**
     * @return Application\Entity\RequisitoTarefa
     */
    private function createRequisitoTarefa($config){
        $requisito = new Entity\RequisitoTarefa();
        $em = $config['em'];
        $tarefaRequisito = $em->find('Application\Entity\Tarefa',
                                    (int) $config['tarefa_req']);
        $requisito->setTarefaRequisito($tarefaRequisito);
        
        return $requisito;
    }
    
    /**
     * @return Application\Entity\RequisitoItem
     */
    private function createRequisitoItem($config){
        $requisito = new Entity\RequisitoItem();
        $em = $config['em'];
        $item = $em->find('Application\Entity\Item',
                                    (int) $config['item_req']);
        $requisito->setItem($item);
        
        return $requisito;
    }
    
}