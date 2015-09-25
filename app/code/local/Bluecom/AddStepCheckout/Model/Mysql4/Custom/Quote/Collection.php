<?php
class Bluecom_AddStepCheckout_Model_Mysql4_Custom_Quote_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
    public function _construct()
    {
        parent::_construct();
        $this->_init('addstepcheckout/custom_quote');
    }
}