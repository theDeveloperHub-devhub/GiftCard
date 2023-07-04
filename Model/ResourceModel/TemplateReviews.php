<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class TemplateReviews extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('template_data', 'id');
    }
}
