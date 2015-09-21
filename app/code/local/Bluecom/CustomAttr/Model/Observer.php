<?php
class Bluecom_CustomAttr_Model_Observer extends Varien_Object
{
    public function setCustomAttribute(Varien_Event_Observer $observer){
        $item = $observer->getQuoteItem();
        $product = $observer->getProduct();
        $item->setCustomAttribute($product->getCustomAttribute());
    }

}