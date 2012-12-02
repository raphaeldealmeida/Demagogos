<?php
class ModelTestCase {
    
    /**
     * @var \Bisna\Application\Container\DoctrineContainer
     */
    public $doctrineContainer;
    protected static $created = false;

    public function setUp($application = null)
    {
        if(is_null($application))
            global $application;
        $application->bootstrap();
        $this->doctrineContainer = Zend_Registry::get('doctrine');
        if(!self::$created)
            $this->createDatabase ();
        
    }
    
    public function createDatabase() {
        $em = $this->doctrineContainer->getEntityManager();
        $tool = new \Doctrine\ORM\Tools\SchemaTool($em);
        $tool->dropDatabase();
        $tool->createSchema($em->getMetadataFactory()->getAllMetadata());
        
        $usuario = new \Application\Entity\Usuario();

        $usuario->setNome('admin');
        $usuario->setEnergia(100);
        $usuario->setEnergiaMaxima(100);
        $usuario->setEmail('admin@admin.com.br');
        $usuario->setSenha('123');
        
        $em->persist($usuario);
        $em->flush();
        
        self::$created = true;
    }
}