<?php
class Bluecom_AddStepCheckout_Model_Sales_Order extends Mage_Sales_Model_Order{
    public function hasCustomFields(){
        $var = $this->getExcellenceLike();
        if($var && !empty($var)){
            return true;
        }else{
            return false;
        }
    }
    public function getFieldHtml(){
        $var = $this->getExcellenceLike();
        $html = '<b>Excellence Review Is:</b> '.$var.'<br/>';
        return $html;
    }
}