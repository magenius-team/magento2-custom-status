<?php
declare(strict_types=1);

namespace Magenius\CustomerStatus\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Eav\Model\AttributeRepository;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;

class AddCustomerStatus implements DataPatchInterface
{

    /**
     * @var ModuleDataSetupInterface
     */
    private $_moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $_customerSetupFactory;

    /**
     * @var AttributeRepository
     */
    private $_attributeRepository;

    /**
     * AddCustomerStatus constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeRepository $attributeRepository
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeRepository $attributeRepository
    ) {
        $this->_moduleDataSetup = $moduleDataSetup;
        $this->_customerSetupFactory = $customerSetupFactory;
        $this->_attributeRepository = $attributeRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $setup = $this->_moduleDataSetup;
        /** @var \Magento\Customer\Setup\CustomerSetup $customerSetup */
        $customerSetup = $this->_customerSetupFactory->create(['setup' => $setup]);
        $customerSetup->addAttribute(
            Customer::ENTITY,
            'status',
            [
                'type' => 'varchar',
                'label' => 'Status',
                'input' => 'text',
                'required' => false,
                'system' => 0,
                'position' => 500
            ]
        );
        $attribute = $this->_attributeRepository->get(Customer::ENTITY, 'status');
        $setup->getConnection()
            ->insertOnDuplicate(
                $setup->getTable('customer_form_attribute'),
                [
                    ['form_code' => 'adminhtml_customer', 'attribute_id' => $attribute->getAttributeId()]
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return [];
    }
}
