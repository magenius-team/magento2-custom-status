<?php
declare(strict_types=1);

namespace Magenius\CustomerStatus\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use \Magento\Customer\Model\ResourceModel\Attribute as AttributeResourceModel;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/*TODO: PatchRevertableInterface*/

class AddCustomerStatusAttribute implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @var AttributeResourceModel
     */
    private $attributeResourceModel;

    /**
     * AddCustomerUpdatedAtAttribute constructor.
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeResourceModel $attributeResource,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->attributeResourceModel = $attributeResource;
    }

    /**
     * Get array of patches that have to be executed prior to this.
     *
     * @return array
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * Get aliases (previous names) for the patch.
     *
     * @return array
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * Add customer status attribute
     */
    public function apply(): void
    {
        $customerSetup = $this->customerSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $customerSetup->addAttribute(
            Customer::ENTITY,
            'custom_status',
            [
                'type' => 'varchar',
                'label' => 'Status',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'system' => false,
                'validate_rules' => '{"max_text_length":255}',
                'input_filter' => 'trim'
            ]
        );

        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();

        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'custom_status');
        $attribute->addData(
            [
                'sort_order' => 100,
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => ['adminhtml_customer']
            ]
        );
        $this->attributeResourceModel->save($attribute);
    }
}
