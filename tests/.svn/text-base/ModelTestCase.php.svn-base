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
        
        $a = new \Application\Entity\Admin();
        $a->setLogin('admin');
        $a->setSenha('admin');
        $em->persist($a);
        $em->flush();
        
        self::$created = true;
    }
}