<?php
declare(strict_types=1);

namespace Magenius\CustomerStatus\Controller\Status;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Save extends Action
{

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $_customerSession;

    /**
     * @var \Magento\Customer\Model\ResourceModel\CustomerRepository
     */
    private $_customerRepository;

    /**
     * Save constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository
     * @param Context $context
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\ResourceModel\CustomerRepository $customerRepository,
        Context $context
    ) {
        $this->_customerSession = $customerSession;
        $this->_customerRepository = $customerRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $customerId = $this->_customerSession->getCustomerId();
        $customer = $this->_customerRepository->getById($customerId);
        $status = $this->getRequest()->getParam('status_field');
        $customer->setCustomAttribute('status', $status);
        try {
            $this->_customerRepository->save($customer);
        } catch (\Exception $e) {
            return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData(['message' => 'Something went wrong']);
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData(['message' => 'Success']);
    }
}
