<?php
use Application\Entity;
class TarefaIntegrationTest extends PHPUnit_Framework_TestCase{
    
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;
    
    public function setUp() {
        
        $modelTest = new ModelTestCase();
        $modelTest->setUp();
        $this->doctrineContainer = $modelTest->doctrineContainer;
    }
    

    public function testNaCriacao() {
        
        $tarefa = new Entity\Tarefa('TesteNome', 100, 1);
      
        $this->_em = $this->doctrineContainer->getEntityManager();
        $this->_em->persist($tarefa);
        $this->_em->flush();
        
        $tarefas = $this->_em->createQuery('select t from Application\Entity\Tarefa t')->execute();
        $this->assertEquals(1,count($tarefas));

        $tarefaBanco = $tarefas[0];
        
        $this->assertEquals('TesteNome', $tarefaBanco->getNome());
        $this->assertEquals(100, $tarefaBanco->getCusto());
        $this->assertEquals(1, $tarefaBanco->getPasso());
    }

    public function testRequisito() {
        
        $tarefa = new Entity\Tarefa('TesteNomeRequisito', 100, 1);
        $requisito = new Entity\RequisitoMonetario();
        $requisito->setValor(1);
        $tarefa->addRequisito($requisito);
      
        $this->_em = $this->doctrineContainer->getEntityManager();
        $this->_em->persist($tarefa);
        $this->_em->flush();
        
        $tarefaBanco = $this->_em->getRepository('Application\Entity\Tarefa')->findOneByNome('TesteNomeRequisito');
                
        $this->assertEquals($tarefa->getNome(),$tarefaBanco->getNome());
        $this->assertEquals(1, $tarefaBanco->getRequisitos()->count());
        $this->assertInstanceOf('Application\Entity\RequisitoMonetario', $tarefaBanco->getRequisitos()->first());
        
        $this->assertEquals($tarefa->getRequisitos()->first()->getValor(),
                $tarefaBanco->getRequisitos()->first()->getValor());
    }
    
}