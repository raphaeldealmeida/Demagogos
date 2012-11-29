<?php
use Application\Service\Builder;

class RequisitoUnitTest extends PHPUnit_Framework_TestCase
{
    public function testCreateMonetario() {
        $tarefa = \Mockery::mock('\Application\Entity\Tarefa', array(
                        'getId' => 1,
                        'getNome' => 'Descrição da Tarefa1'));        
        
        
        $builderRequisito = new Builder\Requisito();
        $requisito = $builderRequisito->create($tarefa, 'Monetario', array('valor'=>10));
        
        $this->assertInstanceOf('Application\Entity\RequisitoMonetario', $requisito);
        $this->assertEquals(10, $requisito->getValor());
        $this->assertEquals($tarefa, $requisito->getTarefa());
    }
    
    public function testCreateTarefa() {
        $tarefa = \Mockery::mock('\Application\Entity\Tarefa', array(
                        'getId' => 1,
                        'getNome' => 'Descrição da Tarefa1'));
        
        $tarefaRequisito = \Mockery::mock('\Application\Entity\Tarefa', array(
                        'getId' => 2,
                        'getNome' => 'Descrição da Tarefa2'));
        
        
         $em = \Mockery::mock('\Doctrine\ORM\EntityManager',
            array('find' => $tarefaRequisito));
         
        
        $builderRequisito = new Builder\Requisito();
        $requisito = $builderRequisito->create($tarefa, 'Tarefa', 
                array('tarefa_req'=>2, 'em'=> $em));
        
        $this->assertInstanceOf('Application\Entity\RequisitoTarefa', $requisito);
        $this->assertEquals($tarefaRequisito, $requisito->getTarefaRequisito());
        $this->assertEquals($tarefa, $requisito->getTarefa());
    }
}