<?php declare(strict_types = 1);

namespace DeveloperHub\GiftCard\Block;

use DeveloperHub\GiftCard\Model\ResourceModel\Reviews\TemplateCollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;

class ProductDetail extends Template
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var TemplateCollectionFactory
     */
    protected $_templatecollectionFactory;

    /**
     * @param Template\Context $context
     * @param RequestInterface $request
     * @param UrlInterface $urlBuilder
     * @param TemplateCollectionFactory $_templatecollectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        UrlInterface $urlBuilder,
        TemplateCollectionFactory $_templatecollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
        $this->_templatecollectionFactory = $_templatecollectionFactory;
    }

    public function getParams()
    {
        $collectionData = [];
        $id = $this->request->getParam('id');
        $collection = $this->_templatecollectionFactory->create();
        $data = $collection->getData();
        foreach ($data as $item) {
            if ($item['status'] == 'Active') {
                $templateName[] = [
                    'template_id' => $item['id'],
                   'template_name' => $item['name']
                ];
            }
        }
        $collection = $this->_templatecollectionFactory->create();
        $firstItem = $collection->addFieldToFilter('id', $id)->getFirstItem();
        $data = $firstItem->getData();
        $imageUrl = $this->urlBuilder->getBaseUrl() . 'media/label/tmp/image/i/m/' . $data['image'];
        $collectionData[] = [
            'id' => $id,
            'image' => $imageUrl,
            'name' => $data['name'],
            'templateName' => $templateName
        ];
        return $collectionData;
    }
}
