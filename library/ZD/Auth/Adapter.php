<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Adapter
 *
 * @author User
 */
class ZD_Auth_Adapter implements Zend_Auth_Adapter_Interface {

    const USER_NOT_FOUND = "User not found";
    const WRONG_PASSWORD = "Wrong password";

    /**
     *
     * @var Model_User
     */
    protected $user;

    /**
     *
     * @var string
     */
    protected $username = "";

    /**
     *
     * @var string
     */
    protected $password = "";

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Performs an authentication attempt
     *
     * @throws Zend_Auth_Adapter_Exception If authentication cannot be performed
     * @return Zend_Auth_Result
     */
    public function authenticate() {
        try {
            $this->user = Model_User::authenticate($this->username, $this->password);
            return $this->getResults(Zend_Auth_Result::SUCCESS);
        } catch (Exception $e) {
            if ($e->getMessage() == Model_User::WRONG_PASSWORD)
                return $this->getResults(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, array(self::WRONG_PASSWORD));
            if ($e->getMessage() == Model_User::USER_NOT_FOUND)
                return $this->getResults(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, array(self::USER_NOT_FOUND));
        }
    }

    private function getResults($code, $messages = array()) {
        $result = new Zend_Auth_Result($code, $this->user, $messages);
        return $result;
    }

}

?>
