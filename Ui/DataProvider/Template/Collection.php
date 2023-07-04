<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Ui\DataProvider\Template;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    protected function _initSelect()
    {
        $this->addFilterToMap('id', 'mainTable.id');
        $this->addFilterToMap('name', 'mainTable.name');
        $this->addFilterToMap('image', 'mainTable.image');
        $this->addFilterToMap('status', 'mainTable.status');
        parent::_initSelect();
    }
}
