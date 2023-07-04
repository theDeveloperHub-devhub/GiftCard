<?php declare(strict_types = 1);

namespace DeveloperHub\GiftCard\Block;

use DeveloperHub\GiftCard\Model\ResourceModel\Reviews\TemplateCollectionFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;

class Index extends Template
{

    /**
     * @var TemplateCollectionFactory
     */
    protected $_templateCollectionFactory;

    /**
     * @param Context $context
     * @param UrlInterface $urlBuilder
     * @param TemplateCollectionFactory $_templateCollectionFactory
     */
    public function __construct(
        Context $context,
        UrlInterface $urlBuilder,
        TemplateCollectionFactory $_templateCollectionFactory
    ) {
        $this->_templateCollectionFactory = $_templateCollectionFactory;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context);
    }
    public function getCollection()
    {
        $collectionData = [];
        $data = $this->_templateCollectionFactory->create();
        $data->getData();
        foreach ($data as $item) {
            if ($item['image']) {
                $imageUrl = $this->urlBuilder->getBaseUrl() . 'media/label/tmp/image/i/m/' . $item['image'];
                $collectionData[] = [
                    'id' => $item['id'],
                   'image' => $imageUrl,
                    'name' => $item['name']
                ];
            }
        }

        return $collectionData;
    }
}

