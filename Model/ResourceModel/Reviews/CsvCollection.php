<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Model\ResourceModel\Reviews;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class CsvCollection extends AbstractCollection
{
    /**
     * @return void
     */
    public function _construct()
    {
        $this->_init('DeveloperHub\GiftCard\Model\CsvReviews', 'DeveloperHub\GiftCard\Model\ResourceModel\CsvReviews');
    }
}
