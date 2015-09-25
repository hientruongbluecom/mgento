<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Bluecom_AddStepCheckout_OnepageController extends  Mage_Checkout_OnepageController{

    public function saveExcellenceAction(){
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('excellence', array());

            $result = $this->getOnepage()->saveExcellence($data);

            if (!isset($result['error'])) {
                $result['goto_section'] = 'billing';
            }

            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }
}