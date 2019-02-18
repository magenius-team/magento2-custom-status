<?php
declare(strict_types=1);

namespace Magenius\CustomerStatus\Model;

use Magento\Customer\Model\ResourceModel\CustomerFactory;
use Magento\Customer\Model\Session;
use Psr\Log\LoggerInterface;

class Status
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var CustomerFactory
     */
    private $customerResourceFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        Session $session,
        CustomerFactory $customerResourceFactory,
        LoggerInterface $logger
    ) {
        $this->customerSession = $session;
        $this->customerResourceFactory = $customerResourceFactory;
        $this->logger = $logger;
    }

    /**
     * Retrieve customer status
     * @return string|null
     */
    public function getCustomerStatus(): ?string
    {
        if ($this->customerSession->isLoggedIn()) {
            return $this->customerSession->getCustomer()
                ->getData('custom_status');
        }

        return null;
    }

    /**
     * @param String $status
     * @throws \Exception
     */
    public function updateStatus(
        String $status
    ) {
        if ($this->customerSession->isLoggedIn()) {
            $customer = $this->customerSession->getCustomer();
            $customer->setData('custom_status', $status);
            $customerResource = $this->customerResourceFactory->create();
            try {
                $customerResource->saveAttribute($customer, 'custom_status');
            } catch (\Exception $e) {
                $this->logger->critical($e->getMessage());
            }
        }
    }
}
