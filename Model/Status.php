<?php

namespace Magenius\Test\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\GroupManagementInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\Data\Customer;
use Magento\Customer\Model\ResourceModel\Customer as ResourceCustomer;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\Config\Share;
use Magento\Customer\Model\Url;

class Status extends CustomerSession
{
    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Session\SidResolverInterface $sidResolver,
        \Magento\Framework\Session\Config\ConfigInterface $sessionConfig,
        \Magento\Framework\Session\SaveHandlerInterface $saveHandler,
        \Magento\Framework\Session\ValidatorInterface $validator,
        \Magento\Framework\Session\StorageInterface $storage,
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        \Magento\Framework\Stdlib\Cookie\CookieMetadataFactory $cookieMetadataFactory,
        \Magento\Framework\App\State $appState,
        Share $configShare,
        \Magento\Framework\Url\Helper\Data $coreUrl,
        Url $customerUrl,
        ResourceCustomer $customerResource,
        CustomerFactory $customerFactory,
        \Magento\Framework\UrlFactory $urlFactory,
        \Magento\Framework\Session\Generic $session,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\App\Http\Context $httpContext,
        CustomerRepositoryInterface $customerRepository,
        GroupManagementInterface $groupManagement,
        \Magento\Framework\App\Response\Http $response
    ) {
        parent::__construct($request, $sidResolver, $sessionConfig, $saveHandler, $validator, $storage, $cookieManager,
            $cookieMetadataFactory, $appState, $configShare, $coreUrl, $customerUrl, $customerResource,
            $customerFactory, $urlFactory, $session, $eventManager, $httpContext, $customerRepository, $groupManagement,
            $response);
    }

    /**
     * @param $status
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\State\InputMismatchException
     */
    public function setCustomerStatus($status): void
    {
        $customerId = $this->getCustomerId();
        /** @var Customer $customer */
        $customer = $this->customerRepository->getById($customerId);
        $customer->setCustomAttribute('customer_status', $status);
        $this->customerRepository->save($customer);
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getCustomerStatus(): string
    {
        $customerId = $this->getCustomerId();

        $customerAttr = $this->customerRepository
            ->getById($customerId)
            ->getCustomAttribute('customer_status');

        if ($customerAttr) {
            return $customerAttr->getValue();
        }

        return "";
    }
}
