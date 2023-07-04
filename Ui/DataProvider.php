<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Ui;

use Magento\Framework\App\Request\DataPersistor;
use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use DeveloperHub\GiftCard\Model\ResourceModel\Reviews\Collection;
use DeveloperHub\GiftCard\Model\ResourceModel\Reviews\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /** @var RequestInterface */
    protected $request;

    /** @var Collection */
    protected $collection;

    /** @var DataPersistor */
    protected $dataPersistor;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param RequestInterface $request
     * @param DataPersistor $dataPersistor
     * @param CollectionFactory $tabsCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        RequestInterface $request,
        DataPersistor $dataPersistor,
        CollectionFactory $tabsCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $tabsCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->request = $request;
    }

    /** @return array */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $itemId = $this->request->getParam('id');
        if (!empty($itemId)) {
            $items = $this->collection->getItems();
            foreach ($items as $item) {
                $this->loadedData[$item->getId()] = $item->getData();
            }
            return $this->loadedData;
        }
        return [];
    }
}
