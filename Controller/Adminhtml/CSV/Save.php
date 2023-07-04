<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Controller\Adminhtml\CSV;

use DeveloperHub\GiftCard\Model\CsvReviewsFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Save extends Action
{
    /**
     * @var CsvReviewsFactory
     */
    protected $_CsvReviewsFactory;

    /**
     * @param Context $context
     * @param CsvReviewsFactory $CsvReviewsFactory
     */
    public function __construct(
        Context $context,
        CsvReviewsFactory $CsvReviewsFactory
    ) {
        $this->_CsvReviewsFactory = $CsvReviewsFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $reviewId = isset($data['id']) ? $data['id'] : '';
        if (!$data) {
            $this->_redirect('developer_hub/csv/create');
        }
        try {
            $rowData = $this->_CsvReviewsFactory->create()->load($reviewId);
            if (!$rowData->getId() && $reviewId) {
                $this->messageManager->addErrorMessage(__('row data no longer exist.'));
                $this->_redirect('developer_hub/csv/create');
            }
            $rowData->setData($data);
            $rowData->save();
            $this->messageManager->addSuccessMessage(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        $this->_redirect('developer_hub/csv/create');
    }
}
