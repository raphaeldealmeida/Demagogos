<?php
use Application\Entity\Admin;
class Rph_Auth_Adapter
    implements Zend_Auth_Adapter_Interface
{
    const NOT_FOUND_MESSAGE = "Conta não encontrada";
    const BAD_PW_MESSAGE = "Senha inválida";
    
    /**
     * @var Admin
     */
    protected $user;

    /**
     *
     * @var string
     */
    protected $login;

    /**
     *
     * @var string
     */
    protected $senha;

    public function __construct($login , $senha)
    {
        $this->login = $login;
        $this->senha = $senha;
    }
    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
      $em = \Zend_Registry::get('doctrine')->getEntityManager();
      $user = $em->getRepository('Application\Entity\Usuario')->findOneByEmail($this->login);
      if ($user){
          if ($user->getSenha() == $this->senha){
              $this->user = $user;
              return $this->result(Zend_Auth_Result::SUCCESS);
          }else{
            return $this->result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, self::BAD_PW_MESSAGE);
          }
      }
      return $this->result(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, self::NOT_FOUND_MESSAGE);
    }

    /**
     * Factory for Zend_Auth_Result
     *
     *@param integer    The Result code, see Zend_Auth_Result
     *@param mixed      The Message, can be a string or array
     *@return Zend_Auth_Result
     */
    public function result($code, $messages = array()) {
        if (!is_array($messages)) {
            $messages = array($messages);
        }

        return new Zend_Auth_Result(
            $code,
            $this->user,
            $messages
        );
    }
}