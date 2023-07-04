<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Ui\DataProvider\Reviews;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    protected function _initSelect()
    {
        $this->addFilterToMap('id', 'mainTable.id');
        $this->addFilterToMap('gift_code_pattern', 'mainTable.gift_code_pattern');
        $this->addFilterToMap('code_pattern', 'mainTable.code_pattern');
        $this->addFilterToMap('quantity', 'mainTable.quantity');
        $this->addFilterToMap('unused', 'mainTable.unused');
        parent::_initSelect();
    }
}
