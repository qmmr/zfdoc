<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ubermaster
 * Date: 04.02.12
 * Time: 20:46
 * To change this template use File | Settings | File Templates.
 */
class Form_Register extends Zend_Form {
    public function init() {
        $this->setMethod('post');

        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('Username:')
            ->setRequired(true);

        $password = new Zend_Form_Element_Text('password');
        $password->setLabel('Password:')
            ->setRequired(true);

        $mobile = new ZD_Form_Element_Phone('mobile');
        $mobile->setLabel('Mobile phone:')
            ->setRequired(true);

        $submit = new Zend_Form_Element_Submit('Register');

        $this->addElements(array($username, $password, $mobile, $submit));
    }
}
