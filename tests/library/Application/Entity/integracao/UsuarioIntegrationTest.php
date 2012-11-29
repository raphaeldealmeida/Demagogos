<?php
use Application\Entity;

class UsuarioIntegrationTest extends PHPUnit_Framework_TestCase{
    
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



    public function testEhCapazDeCriarUmUsuario() {
        
        $this->_em = $this->doctrineContainer->getEntityManager();
        
        $usuario = new Entity\Usuario();
        $usuario->setNome('Corrupto');
        $usuario->setEnergia(100);
        $usuario->setEnergiaMaxima(100);
        $this->assertEquals('Corrupto', $usuario->getNome());
        
        $this->_em->persist($usuario);
        $this->_em->flush();
        
        $usuarios = $this->_em->createQuery('select u from Application\Entity\Usuario u')->execute();
        $this->assertEquals(1,count($usuarios));
    }
    
    
     /**
     * @depends testEhCapazDeCriarUmUsuario
     */
    public function _testTemRealizacaoes()
    {
        $this->_em = $this->doctrineContainer->getEntityManager();
        $usuario = $this->_em->getRepository('Application\Entity\Usuario')->findOneByNome('Corrupto');
        $this->assertInstanceOf('Application\Entity\Usuario', $usuario);
        
        $realizacaoes = $usuario->getRealizacoes();
        $realizacao = $realizacaoes[0];
        
        $this->assertEquals('Organizar um comissio com 100 pessoas', $realizacao->getTarefa()->getNome());
        $this->assertEquals(1, $realizacao->getExecucao());
        
    }
    
    public function testInventario() {
        $this->_em = $this->doctrineContainer->getEntityManager();
        
        $usuario = new Entity\Usuario();
        $usuario->setNome('Corrupto Inventario');
        $usuario->setEnergia(100);
        $usuario->setEnergiaMaxima(100);
                        
        $item = new Entity\Item();
        $item->setNome('Limosine');
        
        $this->_em->persist($item);
        $this->_em->persist($usuario);
        
        $this->_em->flush();
        
        $usuario->addItem($item);
        
        $this->_em->flush();
        
        $usuarioBanco =  $this->_em->getRepository('Application\Entity\Usuario')->findOneByNome('Corrupto Inventario');
        $this->assertEquals(1, $usuarioBanco->getInventario()->count());
        $this->assertInstanceOf('Application\Entity\Inventario', $usuarioBanco->getInventario()->first());
        $this->assertEquals('Limosine', $usuarioBanco->getInventario()->first()->getItem()->getNome());
    }
    
}