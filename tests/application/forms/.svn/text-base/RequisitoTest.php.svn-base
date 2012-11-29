<?php
use Application\Entity;

class Form_RequisitoTest extends PHPUnit_Framework_TestCase
{
    public function testCriarElementos() {
        
        $form = new Form_Requisito();
        
        $this->assertInstanceOf('Zend_Form_Element_Select', $form->getElement('tarefa'));
    }
    
    public function testListadeTarefas(){
        
        $tarefas[] = \Mockery::mock('Application\Entity\Tarefa', array(
                'getId' => 1,
                'getNome' => 'Descrição da Tarefa1'));
        
        $tarefas[] = \Mockery::mock('Application\Entity\Tarefa', array(
                'getId' => 2,
                'getNome' => 'Descrição da Tarefa2')); 
        
        
        $form = new Form_Requisito($tarefas);
        $selectTarefas = $form->getElement('tarefa');
        
        $tarefasExpected = array('1'=> 'Descrição da Tarefa1',
                                 '2'=> 'Descrição da Tarefa2');
        
        $this->assertEquals($tarefasExpected, $selectTarefas->getMultiOptions());
    }
    
    
}
