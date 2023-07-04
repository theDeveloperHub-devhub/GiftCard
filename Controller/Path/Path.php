<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Controller\Path;

use DeveloperHub\GiftCard\Model\ResourceModel\Reviews\TemplateCollectionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;

class Path implements ActionInterface
{

    /**
     * @var TemplateCollectionFactory
     */
    protected $_templatecollectionFactory;
    /**
     * @var JsonFactory
     */
    protected $jsonFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param RequestInterface $request
     * @param PageFactory $pageFactory
     * @param UrlInterface $urlBuilder
     * @param JsonFactory $jsonFactory
     * @param TemplateCollectionFactory $_templatecollectionFactory
     */
    public function __construct(
        RequestInterface $request,
        PageFactory $pageFactory,
        UrlInterface $urlBuilder,
        JsonFactory $jsonFactory,
        TemplateCollectionFactory $_templatecollectionFactory
    ) {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
        $this->urlBuilder = $urlBuilder;
        $this->jsonFactory = $jsonFactory;
        $this->_templatecollectionFactory = $_templatecollectionFactory;
    }

    public function execute()
    {
        $id = $this->request->getParam('value');
        $collection = $this->_templatecollectionFactory->create()
            ->addFieldToFilter('id', $id)->getFirstItem();
        $data = $collection->getData();
        $imageUrl = $this->urlBuilder->getBaseUrl() . 'media/label/tmp/image/i/m/' . $data['image'];
        $result = $this->jsonFactory->create();
        return $result->setData(['url'=> $imageUrl]);
    }
}
