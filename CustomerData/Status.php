<?php
declare(strict_types=1);

namespace Magenius\CustomerStatus\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;

class Status implements SectionSourceInterface
{

    /**
     * @var CurrentCustomer
     */
    private $_currentCustomer;

    /**
     * Status constructor.
     * @param CurrentCustomer $currentCustomer
     */
    public function __construct(
        CurrentCustomer $currentCustomer
    ) {
        $this->_currentCustomer = $currentCustomer;
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        if (!$this->_currentCustomer->getCustomerId()) {
            return [];
        }
        $customer = $this->_currentCustomer->getCustomer();
        $status = $customer->getCustomAttribute('status');
        $status = $status ? $status->getValue() : '';
        return [
            'customer_status' => $status
        ];
    }
}
