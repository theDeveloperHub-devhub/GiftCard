<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Controller\Adminhtml\Template;

use DeveloperHub\GiftCard\Model\TemplateReviewsFactory;
use DeveloperHub\GiftCard\Model\ImageUploader;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Save extends Action
{
    /**
     * @var TemplateReviewsFactory
     */
    protected $_reviewsFactory;

    protected $helperData;

    /**
     * @param Context $context
     * @param ImageUploader $imageUploader
     * @param TemplateReviewsFactory $reviewsFactory
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader,
        TemplateReviewsFactory $reviewsFactory
    ) {
        $this->_reviewsFactory = $reviewsFactory;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }
    public function execute()
    {
        try {
            $this->redirectResult = $this->resultRedirectFactory->create();
            $postData = $this->getRequest()->getPostValue();
            if (isset($postData['image'])) {
                if (isset($postData['image'][0]['name'])) {
                    $this->imageUploader->moveFileFromTmp($postData['image'][0]['file']);
                    $postData['image'] = $postData['image'][0]['name'];
                } else {
                    $postData['image'] = $postData['image'][0]['name'];
                }
            } else {
                $postData['image'] = null;
            }
            $rowData = $this->_reviewsFactory->create();
            $rowData->setData($postData);
            $rowData->save();
            $this->messageManager->addSuccessMessage(__('Row data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__($e->getMessage()));
        }
        $this->_redirect('developer_hub/template/create');
    }
}
