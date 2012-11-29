<?php
namespace Application\Entity;
/**
 * @Entity
 * @Table(name="admins")
 */
class Admin{
    
    const NOT_FOUND = 1;
    const WRONG_PW  = 2;

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Column(type="string")
     */
    protected $login;
    
    /**
     * @Column(type="string")
     */
    protected $senha;
    
    
     /**
     * Perform authentication of a user
     * @param string $login
     * @param string $senha
     */
    public static function authenticate($login, $senha)
    {
        $em = \Zend_Registry::get('doctrine')->getEntityManager();
        $user = $em->getRepository('Application\Entity\Admin')->findOneByLogin($login);
        if ($user)
        {
            if ($user->senha == $senha)
                return $user;

            throw new Exception(self::WRONG_PW);
        }
        throw new Exception(self::NOT_FOUND);
    }
  
    public function setLogin($login) {
        $this->login = $login;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }


}
?>
