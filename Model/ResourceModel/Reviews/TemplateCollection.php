<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Model\ResourceModel\Reviews;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class TemplateCollection extends AbstractCollection
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('DeveloperHub\GiftCard\Model\TemplateReviews', 'DeveloperHub\GiftCard\Model\ResourceModel\TemplateReviews');
    }
}
