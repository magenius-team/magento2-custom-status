<?php

namespace Magenius\Test\Block\Status;

use Magenius\Test\Model\Status;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Edit extends Template
{
    /**
     * @var Status
     */
    public $status;

    /**
     * Edit constructor.
     * @param Context $context
     * @param Status $status
     */
    public function __construct(
        Context $context,
        Status $status
    ) {
        $this->status = $status;
        parent::__construct($context);
    }

    /**
     * @return Template
     */
    protected function _prepareLayout(): Template
    {
        $this->pageConfig->getTitle()->set(__('Status'));
        return parent::_prepareLayout();
    }
}
