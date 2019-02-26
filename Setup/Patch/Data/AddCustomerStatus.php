<?php

namespace Magenius\Test\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\ResourceModel\AttributeFactory as AttributeResourceFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

/**
 * Class AddStatus
 * @package Magento\Customer\Setup\Patch
 */
class AddCustomerStatus implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var CustomerSetupFactory
     */
    private $_customerSetupFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private $_moduleDataSetup;

    /**
     * @var AttributeResourceFactory
     */
    private $_attributeResourceFactory;

    /**
     * AddAttribute constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeResourceFactory $attributeResourceFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeResourceFactory $attributeResourceFactory
    ) {
        $this->_moduleDataSetup = $moduleDataSetup;
        $this->_customerSetupFactory = $customerSetupFactory;
        $this->_attributeResourceFactory = $attributeResourceFactory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function apply(): void
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->_customerSetupFactory->create(['setup' => $this->_moduleDataSetup]);

        $customerSetup->addAttribute(
            Customer::ENTITY,
            'customer_status',
            [
                'type' => 'varchar',
                'label' => 'Customer Status',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'position' => 999,
                'system' => false
            ]
        );


        $statusAttr = $customerSetup->getEavConfig()
            ->getAttribute(Customer::ENTITY, 'customer_status');
        $statusAttr->addData(
                [
                    'used_in_forms' => ['adminhtml_customer']
                ]
            );
        $this->_attributeResourceFactory->create()->save($statusAttr);
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }

    public function revert(): void
    {
        /** @var CustomerSetup $customerSetup */
        $customerSetup = $this->_customerSetupFactory->create(['setup' => $this->_moduleDataSetup]);
        $customerSetup->removeAttribute(
            Customer::ENTITY,
            'customer_status');
    }
}
