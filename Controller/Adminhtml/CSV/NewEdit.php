<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Controller\Adminhtml\CSV;

use DeveloperHub\GiftCard\Model\CsvReviewsFactory;
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
     * @var CsvReviewsFactory
     */
    protected $_csvreviewFactory;


    /**
     * Edit constructor.
     * @param Context $context
     * @param PageFactory $rawFactory
     * @param CsvReviewsFactory $_csvreviewFactory
     */
    public function __construct(
        Context $context,
        PageFactory $rawFactory,
        CsvReviewsFactory $_csvreviewFactory,
    ) {
        $this->pageFactory = $rawFactory;
        $this->_csvreviewFactory = $_csvreviewFactory;
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
            $rowData = $this->_csvreviewFactory->create()->load($rowId);
            if (!$rowData->getId()) {
                $this->messageManager->addErrorMessage(__('row data no longer exist.'));
                $this->_redirect('developer_hub/csv/create');
            }
        }
        $title = $rowId ? __('Edit Review ') : __('Add Review');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
