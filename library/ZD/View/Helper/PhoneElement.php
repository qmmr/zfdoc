<?php
/**
 * User: ubermaster
 * Date: 05.02.12
 * Time: 13:31
 */
class ZD_View_Helper_PhoneElement extends Zend_View_Helper_FormElement {
    protected $html = '';

    public function phoneElement($name, $value = null, $attribs = null) {

        $areanum = $geonum = $localnum = '';

        $helper = new Zend_View_Helper_FormText();
        $helper->setView($this->view);

        if (is_array($value)) {
            $areanum = (isset($value['areanum'])) ? $value['areanum'] : '';
            $geonum = (isset($value['geonum'])) ? $value['geonum'] : '';
            $localnum = (isset($value['localnum'])) ? $value['localnum'] : '';
        }

        $this->html .= $helper->formText($name . '[areanum]', $areanum, array());
        $this->html .= $helper->formText($name . '[geonum]', $geonum, array());
        $this->html .= $helper->formText($name . '[localnum]', $localnum, array());
        return $this->html;
    }
}
