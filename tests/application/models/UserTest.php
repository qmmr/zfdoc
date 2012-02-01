<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserTest
 *
 * @author User
 */
class UserTest  extends Zend_Test_PHPUnit_ControllerTestCase {
    
//    public function testCanDoTest() {
//        $this->assertTrue(true);
//    }
    
    public function testCanAddUsers() {
        $user = new User();
        $user->username = "John Doe";
        $user->password = "john";
        $user->email = "john.doe@examples.com";
        $user->save();
        
        $this->assertTrue(intval($user->id) === 1);
        
        $user2 = new User();
        $user2->username = "Jane Doe";
        $user2->password = "jane";
        $user2->email = "jane.doe@examples.com";
        $user2->save();
        
        $this->assertTrue(intval($user2->id) === 2);
    }
    
}
