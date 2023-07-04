<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Reviews extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'custom_tabs';
    /**
     * @var string
     */
    protected $_cacheTag = 'custom_tabs';
    /**
     * @var string
     */
    protected $_eventPrefix = 'custom_tabs';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('DeveloperHub\GiftCard\Model\ResourceModel\Reviews');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
