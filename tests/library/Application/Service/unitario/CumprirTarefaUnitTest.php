<?php
use Application\Entity,
    Application\Service;

class CumprirTarefaUnitTest extends PHPUnit_Framework_TestCase{
    
    public function testSucesso() {
        
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(1);
        
        $tarefa = new Entity\Tarefa('Tarefa foo', 1, 5);
        
        $cumprirTarefa = new Service\CumprirTarefa($tarefa, $usuario);
        
        $cumprirTarefa->cumprir();
        $realizacoes = $usuario->getRealizacoes();
        $this->assertEquals(1, count($realizacoes));
        $realizacao = $realizacoes[0];
        $this->assertEquals(1, $realizacao->getExecucao());
        $this->assertSame($usuario, $realizacao->getUsuario());
        $this->assertSame($tarefa, $realizacao->getTarefa());
    }
    
    public function testFalhaFaltaEnergia() {
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(0);
        $tarefa = new Entity\Tarefa('Tarefa foo', 1, 5);
        
        $cumprirTarefa = new Service\CumprirTarefa($tarefa, $usuario);
        try{
            $cumprirTarefa->cumprir();
        }catch (Exception $e){ 
            return;
        }
        
        $this->fail();
    }
    
    public function testFalhaNaoCriaRealizacaoDeTarefa() {
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(0);
        $tarefa = new Entity\Tarefa('Tarefa foo', 1, 5);
        
        $cumprirTarefa = new Service\CumprirTarefa($tarefa, $usuario);
        try{  
            $cumprirTarefa->cumprir();
            $this->fail();
        }catch (\Exception $e){
            $this->assertEquals(0, count($usuario->getRealizacoes()));        
        }
    }
    
    
    public function testFalhaFaltaRequisito(){
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(1);
        $tarefa = new Entity\Tarefa('Tarefa foo', 1, 5);
        $requisito = new Entity\RequisitoTarefa();
        $requisito->setTarefa($tarefa);
        $requisito->setTarefaRequisito(new Entity\Tarefa('Tarefa Requisito', 0, 0));
        $tarefa->addRequisito($requisito);
        
        $cumprirTarefa = new Service\CumprirTarefa($tarefa, $usuario);
        try{
            $cumprirTarefa->cumprir();
        }catch (Exception $e){ 
            return;
        }
        
        $this->fail();
    }
    
    public function testSucessoCumpriuRequisito(){
        $usuario = new Entity\Usuario();
        $tarefaRequisito = new Entity\Tarefa('Tarefa Entity\Requisito', 0, 0);
        $realizacao = new Entity\Realizacao();
        $realizacao->setTarefa($tarefaRequisito);
        $usuario->addRealizacao($realizacao);
        $usuario->setEnergia(1);
        $tarefa = new Entity\Tarefa('Tarefa foo', 1, 5);
        $requisito = new Entity\RequisitoTarefa();
        $requisito->setTarefa($tarefa);
        $requisito->setTarefaRequisito($tarefaRequisito);
        $tarefa->addRequisito($requisito);
        
        $cumprirTarefa = new Service\CumprirTarefa($tarefa, $usuario);
        $cumprirTarefa->cumprir();
    }
    
    public function testSucessoCumpriuRequisitoDinheiro(){
        $usuario = new Entity\Usuario();
        $usuario->setSaldo(10);
        
        $tarefa = new Entity\Tarefa('Tarefa monetario foo', 0, 5);
        $requisito = new Entity\RequisitoMonetario();
        $requisito->setValor(10);
        $tarefa->addRequisito($requisito);
        
        $cumprirTarefa = new Service\CumprirTarefa($tarefa, $usuario);
        $cumprirTarefa->cumprir();
        $this->assertEquals(0, $usuario->getSaldo());
    }
    
    public function testFalhaCumpriuRequisitoDinheiro(){
        $usuario = new Entity\Usuario();
        $usuario->setSaldo(9);
        
        $tarefa = new Entity\Tarefa('Tarefa monetario foo', 0, 5);
        $requisito = new Entity\RequisitoMonetario();
        $requisito->setValor(10);
        $tarefa->addRequisito($requisito);
        
        $cumprirTarefa = new Service\CumprirTarefa($tarefa, $usuario);
        try{
            $cumprirTarefa->cumprir();
        }catch (Exception $e){ 
            return;
        }
        
        $this->fail();
    }
    
    public function testFalhaCumprirRequisitoSemEnergia(){
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(0);
        $usuario->setSaldo(1);
        
        $tarefa = new Entity\Tarefa('Tarefa monetario foo', 1, 5);
        $requisito = new Entity\RequisitoMonetario();
        $requisito->setValor(1);
        $tarefa->addRequisito($requisito);
        
        $cumprirTarefa = new Service\CumprirTarefa($tarefa, $usuario);
        try {
            $cumprirTarefa->cumprir();    
            $this->fail('Não disparou a Exception.');
        } catch (Exception $e) {
            $this->assertEquals('Energia Insuficiente', $e->getMessage());
        }
    }
    
    public function testFalhaCumprirSemRequisitoEnergia(){
        $usuario = new Entity\Usuario();
        $usuario->setEnergia(1);
        $usuario->setSaldo(0);
        
        $tarefa = new Entity\Tarefa('Tarefa monetario foo', 1, 5);
        $requisito = new Entity\RequisitoMonetario();
        $requisito->setValor(1);
        $tarefa->addRequisito($requisito);
        
        $cumprirTarefa = new Service\CumprirTarefa($tarefa, $usuario);
        try {
            $cumprirTarefa->cumprir();    
            $this->fail('Não disparou a Exception.');
        } catch (Exception $e) {
            $this->assertEquals('Saldo insuficiante.', $e->getMessage());
        }
    }
}