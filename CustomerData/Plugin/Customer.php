<?php

namespace Magenius\CustomerStatus\CustomerData\Plugin;

class Customer extends \Magento\Customer\CustomerData\Customer
{
    public function afterGetSectionData($subject, $result)
    {
        if (!empty($result)) {
            $customer = $this->currentCustomer->getCustomer();
            $attribute = $customer->getCustomAttribute('customer_status');
            $status = $attribute ? $attribute->getValue() : '';
            $result['status'] = $status;
        }
        return $result;
    }
}