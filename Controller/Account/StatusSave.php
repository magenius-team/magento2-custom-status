<?php
/**
 * Created by PhpStorm.
 * User: den4ik
 * Date: 2019-02-18
 * Time: 14:06
 */

namespace Magenius\CustomerStatus\Controller\Account;

use Magenius\CustomerStatus\Model\Status;
use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\app\Action\Context;
use Magento\Framework\App\ActionInterface;

class StatusSave extends AbstractAccount implements ActionInterface
{
    /**
     * @var Status
     */
    private $statusModel;

    /**
     * @param Context $context
     * @param Status $statusModel
     */
    public function __construct(
        Context $context,
        Status $statusModel
    ) {
        parent::__construct($context);
        $this->statusModel = $statusModel;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        if (($status = $this->getRequest()->getParam('custom_status', null)) !== null) {
            $this->statusModel->updateStatus($status);
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setRefererUrl();
        return $resultRedirect;
    }
}
