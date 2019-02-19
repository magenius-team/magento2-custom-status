<?php

namespace Magenius\CustomerStatus\Controller\Customer;

use Magento\Framework\App\Action\HttpPostActionInterface;

class EditPost extends \Magenius\CustomerStatus\Controller\Customer implements HttpPostActionInterface
{
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());

        if ($validFormKey && $this->getRequest()->isPost()) {
            $customer = $this->customerRepository->getById($this->session->getCustomerId());
            $status = $this->getRequest()->getParam('status');
            $customer->setCustomAttribute('customer_status', $status);
            $this->customerRepository->save($customer);
            $this->messageManager->addSuccessMessage(__('You saved the account information.'));
        }

        return $resultRedirect->setPath('*/*/edit');
    }
}