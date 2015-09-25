<?php
class Bluecom_AddStepCheckout_Model_Observer{

    public function saveQuoteBefore($evt){
        $quote = $evt->getQuote();
        $post = Mage::app()->getFrontController()->getRequest()->getPost();
        if(isset($post['excellence']['like'])){
            $var = $post['excellence']['like'];
            $quote->setExcellenceLike($var);
        }
    }
    public function saveQuoteAfter($evt){
        $quote = $evt->getQuote();
        if($quote->getExcellenceLike()){
            $var = $quote->getExcellenceLike();
            if(!empty($var)){
                $model = Mage::getModel('addstepcheckout/custom_quote');
                $model->deteleByQuote($quote->getId(),'excellence_like');
                $model->setQuoteId($quote->getId());
                $model->setKey('excellence_like');
                $model->setValue($var);
                $model->save();
            }
        }
    }
    public function loadQuoteAfter($evt){
        $quote = $evt->getQuote();
        $model = Mage::getModel('addstepcheckout/custom_quote');
        $data = $model->getByQuote($quote->getId());
        foreach($data as $key => $value){
            $quote->setData($key,$value);
        }
    }
    public function saveOrderAfter($evt){
        $order = $evt->getOrder();
        $quote = $evt->getQuote();
        if($quote->getExcellenceLike()){
            $var = $quote->getExcellenceLike();
            if(!empty($var)){
                $model = Mage::getModel('addstepcheckout/custom_order');
                $model->deleteByOrder($quote->getId(),'excellence_like');
                $model->setOrderId($order->getId());
                $model->setKey('excellence_like');
                $model->setValue($var);
                $model->save();
            }
        }
    }
    public function loadOrderAfter($evt){
        $order = $evt->getOrder();
        $model = Mage::getModel('addstepcheckout/custom_order');
        $data = $model->getByOrder($order->getId());
        foreach($data as $key => $value){
            $order->setData($key,$value);
        }
    }

}