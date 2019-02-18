<?php
declare(strict_types=1);

namespace Magenius\CustomerStatus\CustomerData\Plugin\Customer;

use Magento\Customer\CustomerData\Customer;
use Magenius\CustomerStatus\Model\Status as StatusModel;
use Magento\Framework\Escaper;

class CustomStatusData
{
    /**
     * @var StatusModel
     */
    private $statusModel;

    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * CustomStatusData constructor
     *
     * @param StatusModel $statusModel
     */
    public function __construct(
        StatusModel $statusModel,
        Escaper $escaper
    ) {
        $this->statusModel = $statusModel;
        $this->escaper = $escaper;
    }

    public function afterGetSectionData(Customer $subject, $result)
    {
        if (($status = $this->statusModel->getCustomerStatus()) !== null) {
            $result['custom_status'] = $this->escaper->escapeHtml($status);
        }
        return $result;
    }
}
