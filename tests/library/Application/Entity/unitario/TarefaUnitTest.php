<?php
use Application\Entity;
class TarefaUnitTest extends PHPUnit_Framework_TestCase{
    
    public function testInicializacao(){
        $tarefa = new Entity\Tarefa('TesteNome', 'TesteCusto', 'TestePasso');
        $this->assertEquals('TesteNome', $tarefa->getNome());
        $this->assertEquals('TesteCusto', $tarefa->getCusto());
        $this->assertEquals('TestePasso', $tarefa->getPasso());
    }
    
//    public function testRequisito() {
//        $tarefa = new Tarefa('Tarefa com requisito', 5, 1);
//        
//        $requisito = new Requisito();
//        $tarefa->addRequisito($requisito);
//        $requisitos = $tarefa->getRequisitos();
//        $this->assertEquals($requisito, $requisitos[0]);
//    }
    
}