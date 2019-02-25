<?php

namespace Magenius\Test\CustomerData;

use Magento\Customer\CustomerData\SectionSourceInterface;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magenius\Test\Model\Status as StatusModel;

class Status implements SectionSourceInterface
{
    /**
     * @var CurrentCustomer
     */
    private $_currentCustomer;

    /**
     * Url Builder
     *
     * @var UrlInterface
     */
    private $_urlBuilder;

    /**
     * Escaper
     *
     * @var Escaper
     */
    private $_escaper;

    /**
     * @var StatusModel
     */
    private $_status;

    /**
     * Status constructor.
     * @param CurrentCustomer $currentCustomer
     * @param UrlInterface $urlBuilder
     * @param Escaper $escaper
     * @param StatusModel $status
     */
    public function __construct(
        CurrentCustomer $currentCustomer,
        UrlInterface $urlBuilder,
        Escaper $escaper,
        StatusModel $status
    ) {
        $this->_currentCustomer = $currentCustomer;
        $this->_urlBuilder = $urlBuilder;
        $this->_escaper = $escaper;
        $this->_status = $status;
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData(): array
    {
        return [
            'msg' => $this->_status->getCustomerStatus(),
        ];
    }
}