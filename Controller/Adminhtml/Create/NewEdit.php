<?php declare(strict_types = 1);

namespace DeveloperHub\GiftCard\Controller\Adminhtml\Create;

use DeveloperHub\GiftCard\Model\ReviewsFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
class NewEdit extends Action
{
    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var ReviewsFactory
     */
    protected $_reviewFactory;


    /**
     * Edit constructor.
     * @param Context $context
     * @param PageFactory $rawFactory
     * @param ReviewsFactory $_reviewFactory
     */
    public function __construct(
        Context $context,
        PageFactory $rawFactory,
        ReviewsFactory $_reviewFactory,
    ) {
        $this->pageFactory = $rawFactory;
        $this->_reviewFactory = $_reviewFactory;
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
            $rowData = $this->_reviewFactory->create()->load($rowId);
            if (!$rowData->getId()) {
                $this->messageManager->addErrorMessage(__('row data no longer exist.'));
                $this->_redirect('developer_hub/create/create');
            }
        }
        $title = $rowId ? __('Edit Review ') : __('Add Review');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
