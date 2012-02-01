<?php

/*
 * This file is part of Zwig.
 *
 * (c) 2010 Arnaud Le Blanc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Represents a View Helper template function.
 *
 * @package    zwig
 * @author     Arnaud Le Blanc <arnaud.lb@gmail.com>
 */
class Zwig_Function_ViewHelper extends Twig_Function
{
    protected $name;
    protected $helper;

    public function __construct($name, /*Zend_View_Helper_Interface */$helper)
    {
        $this->name = $name;
        $this->helper = $helper;
    }

    public function getSafe(Twig_Node $functionArgs)
    {
        $safeness = array();
        $helper = $this->helper;

        do {
            if ($helper instanceof Zwig_View_Helper_Interface) {
                $safeness = $helper->getSafe();
                break;
            }

            $class = get_class($helper);

            do {
                if (isset($this->builtin_helpers[$class])) {
                    $safeness = $this->builtin_helpers[$class];
                    break 2;
                }
            } while (($class = get_parent_class($class)) !== false);

        } while (false);

        if (is_string($safeness)) {
            return array($safeness);
        }
        return $safeness;
    }

    public function compile()
    {
        $name = preg_replace('#[^a-z0-9]+#i', '', $this->name);
        return '$this->env->view->getHelper("' . $name . '")->' . $name;
    }

    // {{{ 
    /**
     * This is a list of builtin ZF view helpers.
     * 'html' means that the helper normaly outputs
     * HTML code and should not be escaped.
     *
     * For your own helpers, implement 
     * Zwig_View_Helper_Interface instead
     * or use the helper()|raw syntax.
     */
    protected $builtin_helpers = array(
        'Zend_View_Helper_Abstract' => null,
        'Zend_View_Helper_Action' => null,
        'Zend_View_Helper_BaseUrl' => null,
        'Zend_View_Helper_Currency' => null,
        'Zend_View_Helper_Cycle' => null,
        'Zend_View_Helper_DeclareVars' => null,
        'Zend_View_Helper_Doctype' => 'html',
        'Zend_View_Helper_Fieldset' => 'html',
        'Zend_View_Helper_FormButton' => 'html',
        'Zend_View_Helper_FormCheckbox' => 'html',
        'Zend_View_Helper_FormElement' => 'html',
        'Zend_View_Helper_FormErrors' => 'html',
        'Zend_View_Helper_FormFile' => 'html',
        'Zend_View_Helper_FormHidden' => 'html',
        'Zend_View_Helper_FormImage' => 'html',
        'Zend_View_Helper_FormLabel' => 'html',
        'Zend_View_Helper_FormMultiCheckbox' => 'html',
        'Zend_View_Helper_FormNote' => 'html',
        'Zend_View_Helper_FormPassword' => 'html',
        'Zend_View_Helper_FormRadio' => 'html',
        'Zend_View_Helper_FormReset' => 'html',
        'Zend_View_Helper_FormSelect' => 'html',
        'Zend_View_Helper_FormSubmit' => 'html',
        'Zend_View_Helper_FormTextarea' => 'html',
        'Zend_View_Helper_FormText' => 'html',
        'Zend_View_Helper_Form' => 'html',
        'Zend_View_Helper_HeadLink' => 'html',
        'Zend_View_Helper_HeadMeta' => 'html',
        'Zend_View_Helper_HeadScript' => 'html',
        'Zend_View_Helper_HeadStyle' => 'html',
        'Zend_View_Helper_HeadTitle' => 'html',
        'Zend_View_Helper_HtmlElement' => 'html',
        'Zend_View_Helper_HtmlFlash' => 'html',
        'Zend_View_Helper_HtmlList' => 'html',
        'Zend_View_Helper_HtmlObject' => 'html',
        'Zend_View_Helper_HtmlPage' => 'html',
        'Zend_View_Helper_HtmlQuicktime' => 'html',
        'Zend_View_Helper_InlineScript' => 'html',
        'Zend_View_Helper_Interface' => null,
        'Zend_View_Helper_Json' => null,
        'Zend_View_Helper_Layout' => 'html',
        'Zend_View_Helper_Navigation_Breadcrumbs' => 'html',
        'Zend_View_Helper_Navigation_HelperAbstract' => 'html',
        'Zend_View_Helper_Navigation_Helper' => 'html',
        'Zend_View_Helper_Navigation_Links' => 'html',
        'Zend_View_Helper_Navigation_Menu' => 'html',
        'Zend_View_Helper_Navigation_Sitemap' => 'html',
        'Zend_View_Helper_Navigation' => 'html',
        'Zend_View_Helper_PaginationControl' => 'html',
        'Zend_View_Helper_Partial_Exception' => null,
        'Zend_View_Helper_PartialLoop' => 'html',
        'Zend_View_Helper_Partial' => 'html',
        'Zend_View_Helper_Placeholder_Container_Abstract' => 'html',
        'Zend_View_Helper_Placeholder_Container_Exception' => 'html',
        'Zend_View_Helper_Placeholder_Container_Standalone' => 'html',
        'Zend_View_Helper_Placeholder_Container' => 'html',
        'Zend_View_Helper_Placeholder_Registry_Exception' => 'html',
        'Zend_View_Helper_Placeholder_Registry' => 'html',
        'Zend_View_Helper_Placeholder' => 'html',
        'Zend_View_Helper_RenderToPlaceholder' => 'html',
        'Zend_View_Helper_ServerUrl' => null,
        'Zend_View_Helper_Translate' => null,
        'Zend_View_Helper_Url' => null,
    );
    // }}}
}
