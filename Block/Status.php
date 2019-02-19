<?php
declare(strict_types=1);

namespace Magenius\CustomerStatus\Block;

use Magento\Framework\View\Element\Template;

class Status extends Template
{

    /**
     * @var \Magento\Customer\Helper\Session\CurrentCustomer
     */
    private $_customerSession;

    /**
     * Status constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        Template\Context $context,
        array $data = []
    ) {
        $this->_customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getWidgetJsonOptions(): string
    {
        return json_encode([
            'component' => 'Magenius_CustomerStatus/js/customer-status',
            'formKeyHtml' => $this->getBlockHtml('formkey'),
            'status' => $this->getCustomerStatus(),
            'saveUrl' => $this->_urlBuilder->getUrl('magenius/status/save')
        ]);
    }

    /**
     * @return string
     */
    public function getCustomerStatus(): string
    {
        $status = '';
        if ($this->_customerSession->isLoggedIn()) {
            $status = $this->_customerSession->getCustomer()->getStatus();
        }
        return $status ? $status : '';
    }
}
