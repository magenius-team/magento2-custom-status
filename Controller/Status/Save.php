<?php

namespace Magenius\Test\Controller\Status;

use Magenius\Test\Model\Status;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class Save extends Action
{

    /**
     * @var Status
     */
    private $_status;

    /**
     * Save constructor.
     * @param Context $context
     * @param Status $status
     */
    public function __construct(
        Context $context,
        Status $status
    ) {
        $this->_status = $status;
        parent::__construct($context);
    }

    /**
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function execute(): ResultInterface
    {
        $statusMessage = $this->getRequest()->getParam('status');
        $this->_status->setCustomerStatus($statusMessage);

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}
