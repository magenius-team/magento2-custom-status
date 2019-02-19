<?php
declare(strict_types=1);

namespace Magenius\CustomerStatus\Controller\Status;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\Controller\ResultFactory;

class Index extends AbstractAccount
{

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
