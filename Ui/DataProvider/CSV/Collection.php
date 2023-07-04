<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Ui\DataProvider\CSV;

use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;

class Collection extends SearchResult
{
    protected function _initSelect()
    {
        $this->addFilterToMap('id', 'mainTable.id');
        $this->addFilterToMap('code', 'mainTable.code');
        $this->addFilterToMap('status', 'mainTable.status');
        $this->addFilterToMap('initial_value', 'mainTable.initial_value');
        $this->addFilterToMap('current_value', 'mainTable.current_value');
        $this->addFilterToMap('expiry_date', 'mainTable.expiry_date');
        parent::_initSelect();
    }
}
