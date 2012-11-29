<?php
use Application\Entity;
class UsuarioUnitTest extends PHPUnit_Framework_TestCase{
    
    public function testPagarEnergia() {
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(80);
        $usuario->pagarEnergia(50);
        
        $this->assertEquals(30, $usuario->getEnergia());
    }
    
    public function testPagarEnergiaEFicaZerado() {
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(80);
        $usuario->pagarEnergia(80);
        
        $this->assertEquals(0, $usuario->getEnergia());
    }
    
    public function testPagarEnergiaNaoFicaNegativo() {
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(80);
        $this->assertFalse($usuario->pagarEnergia(100));
        $this->assertEquals(80, $usuario->getEnergia());
    }
    
    public function testAtualizarEnergia(){
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(0);
        $usuario->setEnergiaMaxima(100);
        
        $usuario->setUltimaAtualizacaoEnergia(new DateTime('00:00:00'));
        
        $umMinuto = new DateTime('00:01:00');
        $usuario->atualizarEnergia($umMinuto);
        
        $this->assertEquals(1, $usuario->getEnergia());
    }
    
    public function testAtualizarEnergiaMaisDois(){
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(0);
        $usuario->setEnergiaMaxima(100);
        
        $usuario->setUltimaAtualizacaoEnergia(new DateTime('00:00:00'));
        
        $umMinuto = new DateTime('00:02:00');
        $usuario->atualizarEnergia($umMinuto);
        
        $this->assertEquals(2, $usuario->getEnergia());
    }
    
    public function testMaisEnergiaEm(){
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(0);
        $usuario->setEnergiaMaxima(100);
        
        $usuario->setUltimaAtualizacaoEnergia(new DateTime('00:00:00'));
        
        $umMinuto = new DateTime('00:00:01');
        
        $this->assertEquals('00:59', $usuario->atualizarEnergia($umMinuto)->format('%I:%S'));
    }
    
    public function testMaisEnergiaLimiteEnergiaMaxima(){
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(99);
        $usuario->setEnergiaMaxima(100);
        
        $usuario->setUltimaAtualizacaoEnergia(new DateTime('00:00:00'));
        
        $umMinuto = new DateTime('00:02:00');
        $usuario->atualizarEnergia($umMinuto);
        
        $this->assertEquals($usuario->getEnergiaMaxima(), $usuario->getEnergia());
    }
    
    public function testMaisEnergiaAcimaEnergiaMaxima(){
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(100);
        $usuario->setEnergiaMaxima(100);
        
        $usuario->setUltimaAtualizacaoEnergia(new DateTime('00:00:00'));
        
        $umMinuto = new DateTime('00:02:00');
        $usuario->atualizarEnergia($umMinuto);
        
        $this->assertEquals($usuario->getEnergiaMaxima(), $usuario->getEnergia());
    }
    
    public function testInventario(){
        $usuario = new Entity\Usuario();
        $item = \Mockery::mock('\Application\Entity\Item');
        $usuario->addItem($item);
        $intentario = $usuario->getInventario();
        
        $this->assertInstanceOf('\Application\Entity\Inventario', $intentario[0]);
    }
}