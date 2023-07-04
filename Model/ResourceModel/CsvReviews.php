<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CsvReviews extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('csv_data', 'id');
    }
}
