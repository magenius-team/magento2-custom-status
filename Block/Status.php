<?php
declare(strict_types=1);

namespace Magenius\CustomerStatus\Block;

use Magenius\CustomerStatus\Model\Status as StatusModel;
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Block\Account\Dashboard;

class Status extends Dashboard
{
    /**
     * @var StatusModel
     */
    private $statusModel;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory,
        CustomerRepositoryInterface $customerRepository,
        AccountManagementInterface $customerAccountManagement,
        StatusModel $statusModel,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $customerSession,
            $subscriberFactory,
            $customerRepository,
            $customerAccountManagement,
            $data
        );
        $this->statusModel = $statusModel;
    }

    /**
     * Retrieve status model
     *
     * @return string|null
     */
    public function getCustomStatus()
    {
        return $this->statusModel->getCustomerStatus();
    }
}
