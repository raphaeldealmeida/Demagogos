<?php
use Application\Entity;
class RealizacaoUnitTest extends PHPUnit_Framework_TestCase{
    
    public function testInicializacao(){
        $tarefaFake = $this->getMockBuilder("Application\Entity\Tarefa")
                     ->disableOriginalConstructor()
                     ->getMock();
        
        $usuarioFake = $this->getMock('Application\Entity\Usuario');
        
        $realizacao = new Entity\Realizacao();
        $realizacao->setExecucao(1);
        $realizacao->setTarefa($tarefaFake);
        $realizacao->setUsuario($usuarioFake);
        
        $this->assertEquals(1, $realizacao->getExecucao());
    }
}