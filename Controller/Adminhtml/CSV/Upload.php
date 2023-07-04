<?php declare(strict_types=1);

namespace DeveloperHub\GiftCard\Controller\Adminhtml\CSV;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Filesystem;
use Magento\Framework\Session\SessionManagerInterface;

class Upload extends Action
{
    protected $filesystem;

    protected $sessionManager;

    public function __construct(
        Context $context,
        Filesystem $filesystem,
        SessionManagerInterface $sessionManager
    ) {
        parent::__construct($context);
        $this->filesystem = $filesystem;
        $this->sessionManager = $sessionManager;
    }

    public function execute()
    {
        try {
            $file = $this->getRequest()->getFiles('csv_upload');

            if (!$file) {
                throw new \Exception(__('Please select a CSV file to upload.'));
            }

            $targetDir = $this->filesystem->getDirectoryWrite(DirectoryList::TMP)->getAbsolutePath();
            $targetFile = $targetDir . $file['name'];

            move_uploaded_file($file['tmp_name'], $targetFile);
            $this->sessionManager->start();
            $this->sessionManager->setData('my_data', $targetFile);

            $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $result->setData([
                'success' => false,
                'message' => __('CSV file uploaded successfully.')
            ]);

            return $result;
        } catch (\Exception $e) {
            $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $result->setData([
                'success' => false,
                'message' => $e->getMessage()
            ]);

            return $result;
        }
    }
}
