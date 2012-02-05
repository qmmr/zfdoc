<?php
class Form_Login extends Zend_Form {
    public function init() {
        $this->setMethod('post');

        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('username:')
            ->setRequired(true);

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('password:')
            ->setRequired(true);

        $submit = new Zend_Form_Element_Submit('submit');

        $this->addElements(array($username, $password, $submit));

        $this->setElementDecorators(
            array('ViewHelper', 'Label')
        );

        /*
         * if you want table base you need to specify wrapping elements like this
         *
        $this->setElementDecorators(array(
            'ViewHelper',
            array(
                array('data' => 'HtmlTag'),
                array('tag' =>'td', 'class'=> 'element')
            ),
            array('Label', array('tag' => 'td')),
            array(
                array('row' => 'HtmlTag'),
                array('tag' => 'tr')
            )
        ));

        $submit->setDecorators(array('ViewHelper',
            array(
                array('data' => 'HtmlTag'),
                array('tag' =>'td', 'class'=> 'element')
            ),
            array(
                array('emptyrow' => 'HtmlTag'),
                array(
                    'tag' =>'td',
                    'class'=> 'element',
                    'placement' => 'PREPEND'
                )
            ),
            array(
                array('row' => 'HtmlTag'),
                array('tag' => 'tr')
            )
        ));

        $this->setDecorators(array(
            'FormElements',
            array(
                'HtmlTag',
                array('tag' => 'table')
            ),
            'Form'
        ));
        */

        $submit->setDecorators(array('ViewHelper'));

        $this->setDecorators(
            array(
                'FormElements',
                'Form'
            )
        );

    }
}
