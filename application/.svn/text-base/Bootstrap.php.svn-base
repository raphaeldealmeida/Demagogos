<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /*function _initFb(){
        require_once 'php-sdk/src/facebook.php';
        $appapikey = '186427761386774';
        $appsecret = '88beaa450f5f5c86b16deb877aab8fde';
        $appcallbackurl = 'demagogos.logal';
        $facebook = array('appId' => $appapikey,
                          'secret' => $appsecret,
                          'appcallbackurl' => $appcallbackurl
        );

        $registry = Zend_Registry::getInstance();
        $registry->set('facebook',$facebook);
    }*/
    
    protected function _initAutoload()
    {
            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->setFallbackAutoloader(true);

            $moduleLoader = new Zend_Application_Module_Autoloader(array(
                    'namespace'	=> 	'',
                    'basePath'	=>	APPLICATION_PATH));

            return $moduleLoader;
    }
    
    protected function _initAutoloaderNamespaces()
    {
        require_once APPLICATION_PATH . '/../library/Doctrine/Common/ClassLoader.php';

        $autoloader = \Zend_Loader_Autoloader::getInstance();
        $fmmAutoloader = new \Doctrine\Common\ClassLoader('Bisna');
        $autoloader->pushAutoloader(array($fmmAutoloader, 'loadClass'), 'Bisna');
    }
    
    protected function _initZFDebug(){
        if (APPLICATION_ENV == 'development') {
            $autoloader = Zend_Loader_Autoloader::getInstance();
            $autoloader->registerNamespace('ZFDebug');
            $em = $this->bootstrap('doctrine')->getResource('doctrine')->getEntityManager();
            $em->getConnection()->getConfiguration()->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack());

            $options = array(
                'plugins' => array(
                    'Variables',
                    'ZFDebug_Controller_Plugin_Debug_Plugin_Doctrine2'  => array(
                        'entityManagers' => array($em),
                    ),
                    'File'          => array('basePath' => APPLICATION_PATH . '/application'),
                    //'Cache'       => array('backend' => $cache->getBackend()),
                    'Exception',
                    'Html',
                    'Memory',
                    'Time',
                    'Registry',
                )
            );

            $debug = new ZFDebug_Controller_Plugin_Debug($options);
            $this->bootstrap('frontController');
            $frontController = $this->getResource('frontController');
            $frontController->registerPlugin($debug);
        }
    }
}