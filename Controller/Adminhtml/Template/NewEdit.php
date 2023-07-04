<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Controller\Adminhtml\Template;

use DeveloperHub\GiftCard\Model\TemplateReviewsFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class NewEdit extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var TemplateReviewsFactory
     */
    protected $_templatereviewFactory;


    /**
     * @param Context $context
     * @param PageFactory $rawFactory
     * @param UrlInterface $urlBuilder
     * @param TemplateReviewsFactory $_templatereviewFactory
     */
    public function __construct(
        Context $context,
        PageFactory $rawFactory,
        UrlInterface $urlBuilder,
        TemplateReviewsFactory $_templatereviewFactory
    ) {
        $this->pageFactory = $rawFactory;
        $this->_templatereviewFactory = $_templatereviewFactory;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context);
    }

    /**
     * @return Page
     */
    public function execute(): Page
    {
        $resultPage = $this->pageFactory->create();
        $resultPage->setActiveMenu('DeveloperHub_GiftCard::DeveloperHub');
        $rowId = (int)$this->getRequest()->getParam('id');

        if ($rowId) {
            $rowData = $this->_templatereviewFactory->create()->load($rowId);
            if ($rowData['image']) {
                $imageUrl = $this->urlBuilder->getBaseUrl() . 'media/label/icon/' . $rowData['image'];
                $rowData['image'] = $imageUrl;
            }

            if (!$rowData->getId()) {
                $this->messageManager->addErrorMessage(__('row data no longer exist.'));
                $this->_redirect('developer_hub/template/create');
            }
        }
        $title = $rowId ? __('Edit Template ') : __('New Gift Card Template');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
